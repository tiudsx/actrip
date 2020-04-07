<?php
include __DIR__.'/../db.php';
include __DIR__.'/../surf/surfkakao.php';
include __DIR__.'/../surf/surfmail.php';
include __DIR__.'/../surf/surffunc.php';

$success = true;
$datetime = date('Y/m/d H:i'); 

$content = trim($_REQUEST["content"]);
$keyword = trim($_REQUEST["keyword"]);

mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

if($content == "" || $keyword == ""){
	return;
}

// 문자내역
$content = preg_replace('/\s+/u', ' ', $content);
$arrSMS = explode("@", $content);

// 은행명
$bankname = explode("@", $keyword)[0];


if($bankname == "신한"){
	//ex : https://actrip.co.kr/act/callback/bank.php?content=[Web발신]@신한 04/09 14:20@389-02-188735@입금 35100@이승철&keyword=신한@입금
	//[Web발신]@신한 04/09 14:20@389-02-188735@입금         34@이승철
	$banknum = $arrSMS[2];

	$bankprice = explode(" ", $arrSMS[3])[1];
	$bankprice = str_replace(',', '', $bankprice);

	$bankuser = $arrSMS[4];
}else if($bankname == "우리"){
	//ex : https://actrip.co.kr/act/callback/bank.php?content=[Web발신]@우리 04/05 19:05@*467316@입금 100원@이승철&keyword=우리@입금
	//[Web발신]@우리 06/08 08:58@8900*01@입금 200원@이승철
	//[Web발신]@우리 04/05 19:05@*467316@입금 100원@이승철

	$bankprice = explode(" ", $arrSMS[3])[1];
	$bankprice = str_replace(',', '', $bankprice);
	$bankprice = str_replace('입금', '', $bankprice);
	$bankprice = str_replace('원', '', $bankprice);

	$banknum = $arrSMS[2];
	$bankuser = $arrSMS[4];
}else{
	return;
}
$select_query = "INSERT INTO `AT_CALL_BANK`(`smscontent`, `keyword`, `shopSeq`, `bankprice`, `bankname`, `banknum`, `bankuser`, `insdate`) VALUES ('$content', '$keyword', 0, '$bankprice', '$bankname', '$banknum', '$bankuser', now())";
$result_set = mysqli_query($conn, $select_query);
$seq = mysqli_insert_id($conn);
if(!$result_set) goto errGo;
//echo $select_query.'<br>';

//주문내역과 문자내역의 이름/금액 매칭
$select_query = "SELECT a.user_name, a.user_tel, a.user_email, a.etc, b.* 
					FROM AT_RES_MAIN as a INNER JOIN (SELECT resnum, SUM(res_totalprice) as price, MAX(seq) as shopSeq, MAX(code) as code FROM AT_RES_SUB WHERE res_confirm = 0 GROUP BY resnum) as b 
						ON a.resnum = b.resnum 
					WHERE price = $bankprice AND a.user_name = '$bankuser'";
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

// 주문내역과 문자입금 내역 매칭이 맞을경우...
if($count == 1){
	while ($row = mysqli_fetch_assoc($result_setlist)){
		$ResNumber = $row['resnum'];
		$userName = $row["user_name"];
		$etc = $row["etc"];
		$userPhone = $row["user_tel"];
		$usermail = $row["user_email"];
		$shopSeq = $row["shopSeq"];
		$code = $row['code'];
	}
	
	$busSeatInfo = "";
	$busStopInfo = "";
	$ressubseq = "";
	$arrSeatInfo = array();
	$arrStopInfo = array();

	$select_query_sub = 'SELECT * FROM AT_RES_SUB WHERE res_confirm = 0 AND resnum = '.$ResNumber.' ORDER BY res_date, ressubseq';
	$resultSite = mysqli_query($conn, $select_query_sub);

	while ($rowSub = mysqli_fetch_assoc($resultSite)){
		$shopname = $rowSub['shopname'];
		$ressubseq .= $rowSub['ressubseq'].',';

		if(array_key_exists($rowSub['res_date'].$rowSub['res_bus'], $arrSeatInfo)){
			$arrSeatInfo[$rowSub['res_date'].$rowSub['res_bus']] .= '      - '.$rowSub['res_seat'].'번 ('.$rowSub['res_spointname'].' -> '.$rowSub['res_epointname'].')\n';
		}else{
			$arrSeatInfo[$rowSub['res_date'].$rowSub['res_bus']] = '    ['.$rowSub['res_date'].'] '.fnBusNum($rowSub['res_bus']).'\n      - '.$rowSub['res_seat'].'번 ('.$rowSub['res_spointname'].' -> '.$rowSub['res_epointname'].')\n';
		}

		$arrData = explode("|", fnBusPoint($rowSub['res_spointname'], $rowSub['res_bus']));
		$arrStopInfo[$rowSub['res_spointname']] = '    ['.$rowSub['res_spointname'].'] '.$arrData[0].'\n      - '.$arrData[1].'\n';
	}
	$ressubseq .= '0';

	foreach($arrSeatInfo as $x) {
		$busSeatInfo .= $x;
	}

	foreach($arrStopInfo as $x) {
		$busStopInfo .= $x;
	}

	$pointMsg = ' ▶ 탑승시간/위치 안내\n'.$busStopInfo;
	if($etc != ''){
		$etcMsg = ' ▶ 특이사항\n      '.$etc.'\n';
	}

	$msgTitle = '액트립 '.$shopname.' 예약안내';
	$kakaoMsg = $msgTitle.'\n안녕하세요. '.$userName.'님\n\n액트립 예약정보 [예약확정]\n ▶ 예약번호 : '.$ResNumber.'\n ▶ 예약자 : '.$userName.'\n ▶ 좌석안내\n'.$busSeatInfo.$pointMsg.$etcMsg.'---------------------------------\n ▶ 안내사항\n      - 이용일, 탑승시간, 탑승위치 꼭 확인 부탁드립니다.\n      - 탑승시간 5분전에는 도착해주세요~\n\n ▶ 문의\n      - 010.3308.6080\n      - http://pf.kakao.com/_HxmtMxl';

	$arrKakao = array(
		"gubun"=> $code
		, "admin"=> "N"
		, "smsTitle"=> $msgTitle
		, "userName"=> $userName
		, "tempName"=> "at_res_bus1"
		, "kakaoMsg"=>$kakaoMsg
		, "userPhone"=> $userPhone
		, "link1"=>"ordersearch?resNumber=".$ResNumber //예약조회/취소
		, "link2"=>"notice" //셔틀버스 실시간위치 조회
		, "link3"=>"ordersearch?resNumber=".$ResNumber //셔틀버스 탑승 위치확인
		, "link4"=>"eatlist" //제휴업체 목록
		, "link5"=>"notice" //공지사항
		, "smsOnly"=>"N"
	);
	sendKakao($arrKakao);

	$select_query = "UPDATE `AT_RES_SUB` 
						SET res_confirm = 3
							,upddate = now()
							,upduserid = 'autobank'
						WHERE ressubseq IN (".$ressubseq.")";
	$result_set = mysqli_query($conn, $select_query);
	if(!$result_set) goto errGo;
	
	$select_query = "INSERT INTO `AT_CALL_BANK_HISTORY`(`smscontent`, `keyword`, `shopSeq`, `goodstype`, `bankprice`, `bankname`, `banknum`, `bankuser`, `MainNumber`, `insdate`) VALUES ('$content', '$keyword', $shopSeq, '$code', '$bankprice', '$bankname', '$banknum', '$bankuser', $ResNumber, now())";
	$result_set = mysqli_query($conn, $select_query);
	if(!$result_set) goto errGo;

	$select_query = "DELETE FROM `AT_CALL_BANK` WHERE seq = ".$seq;
	$result_set = mysqli_query($conn, $select_query);
	if(!$result_set) goto errGo;

}else if($count > 1){ //같은 금액, 같은 이름 2명 이상
	$ResNumberList = "";
	while ($row = mysqli_fetch_assoc($result_setlist)){
		$ResNumber = $row['resnum'];
		$userName = $row["user_name"];
		$etc = $row["etc"];
		$userPhone = $row["user_tel"];
		$usermail = $row["user_email"];
		$shopSeq = $row["shopSeq"];
		$code = $row['code'];
		
		$mailcontent .= 'seq : '.$seq.' / 주문번호 : '.$ResNumber.' / 이름 : '.$bankuser.' / 금액 : '.$bankprice.'<br>';
		$ResNumberList .= $ResNumber."|";

		$select_query = "UPDATE `AT_RES_SUB` 
							SET res_confirm = 1
								,upddate = now()
								,upduserid = 'autobank_over'
							WHERE resnum = '$ResNumber' AND res_confirm = 0";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) goto errGo;
	}

	$select_query = "UPDATE `AT_CALL_BANK` SET goodstype = '$code', MainNumberList = '$ResNumberList', shopSeq = $shopSeq WHERE seq = ".$seq;
	$result_set = mysqli_query($conn, $select_query);
	if(!$result_set) goto errGo;

	$to = "lud1@naver.com";
	$arrMail = array(
		"campStayName"=> "surfbank"
		,"gubun"=> $gubunname
	);

	//sendMail("surfbank@surfenjoy.com", "surfenjoy", $gubunname.'<br>'.$mailcontent, $to, $arrMail);

}else if ($count == 0){ //금액, 이름이 없을 경우
	//주문내역과 문자내역의 이름/금액 매칭
	$select_query = "SELECT a.user_name, a.user_tel, a.user_email, a.etc, b.* 
	FROM AT_RES_MAIN as a INNER JOIN (SELECT resnum, SUM(res_totalprice) as price, MAX(seq) as shopSeq, MAX(code) as code FROM AT_RES_SUB WHERE res_confirm = 0 GROUP BY resnum) as b 
		ON a.resnum = b.resnum 
	WHERE price = $bankprice";
	$result_setlist = mysqli_query($conn, $select_query);
	$count = mysqli_num_rows($result_setlist);

	$ResNumberList = "";

	// 주문내역과 문자내역 중 금액이 같은 경우 임시 체크
	if($count > 0){
		$ResNumberList = "Price:";
		while ($row = mysqli_fetch_assoc($result_setlist)){
			$ResNumber = $row['resnum'];
			$ResNumberList .= $ResNumber."|";
	
			$select_query = "UPDATE `AT_RES_SUB` 
								SET res_confirm = 1
									,upddate = now()
									,upduserid = 'autobank_none'
								WHERE resnum = '$ResNumber' AND res_confirm = 0";
			$result_set = mysqli_query($conn, $select_query);
			if(!$result_set) goto errGo;
		}
	}else{
		$select_query = "SELECT a.user_name, a.user_tel, a.user_email, a.etc, b.* 
		FROM AT_RES_MAIN as a INNER JOIN (SELECT resnum, SUM(res_totalprice) as price, MAX(seq) as shopSeq, MAX(code) as code FROM AT_RES_SUB WHERE res_confirm = 0 GROUP BY resnum) as b 
			ON a.resnum = b.resnum 
		WHERE a.user_name = '$bankuser'";
		$result_setlist = mysqli_query($conn, $select_query);
		$count = mysqli_num_rows($result_setlist);

		if($count > 0){
			$ResNumberList = "Name:";
			while ($row = mysqli_fetch_assoc($result_setlist)){
				$ResNumber = $row['resnum'];
				$ResNumberList .= $ResNumber."|";
		
				$select_query = "UPDATE `AT_RES_SUB` 
									SET res_confirm = 1
										,upddate = now()
										,upduserid = 'autobank_none'
									WHERE resnum = '$ResNumber' AND res_confirm = 0";
				$result_set = mysqli_query($conn, $select_query);
				if(!$result_set) goto errGo;
			}
		}
	}

	$select_query = "UPDATE `AT_CALL_BANK` SET goodstype = 'none', MainNumberList = '$ResNumberList' WHERE seq = ".$seq;
	$result_set = mysqli_query($conn, $select_query);
	// echo $select_query;
	if(!$result_set) goto errGo;

	$to = "lud1@naver.com";
	$arrMail = array(
		"campStayName"=> "surfbanknone"
		,"gubun"=> $gubunname
	);

	$mailcontent = "은행 : $bankname<br>계좌번호 : $banknum<br>입금자명 : $bankuser<br>금액 : $bankprice";

	//sendMail("surfbank@surfenjoy.com", "surfenjoy", $gubunname.'<br>'.$mailcontent, $to, $arrMail);
}

if(!$success){
	errGo:
	mysqli_query($conn, "ROLLBACK");
	echo 'err';
}else{
	mysqli_query($conn, "COMMIT");
	echo '0';
}
mysqli_close($conn);
?>

