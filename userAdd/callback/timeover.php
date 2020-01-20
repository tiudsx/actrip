<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

function smsHistory(){

}

$success = true;
$datetime = date('Y/m/d H:i'); 

$user_name = trim(urldecode($_REQUEST["username"]));
$weeknum = trim($_REQUEST["weeknum"]);
$timenum = trim($_REQUEST["timenum"]);
$timestart = trim($_REQUEST["timestart"]);
$timeend = trim($_REQUEST["timeend"]);

$select_query = "DELETE FROM SURF_TIMEOVER WHERE TIMESTAMPDIFF(DAY, insdate, now()) > 8";
$result_set = mysqli_query($conn, $select_query);


$select_query = "INSERT INTO SURF_TIMEOVER(`user_name`, `weeknum`, `timenum`, `insdate`, `stats`, `timestart`, `timeend`, `sqlquery`) VALUES ('$user_name', $weeknum, $timenum, now(), 'OK', $timestart, $timeend, '')";
$result_set = mysqli_query($conn, $select_query);
$seq = mysqli_insert_id($conn);

mysqli_query($conn, "COMMIT");


//============================ 실행 ============================
mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

$errChk = "01";
$countChk = "";

//==== 서핑샵 예약건 자동취소 ====
$select_query = 'SELECT a.userName, a.userPhone, a.Etc, a.shopCode, b.* 
	FROM SURF_SHOP_RES_MAIN as a INNER JOIN SURF_SHOP_RES_SUB as b 
		ON a.MainNumber = b.MainNumber 
	WHERE b.ResConfirm = 0
		AND TIMESTAMPDIFF(MINUTE, b.insdate, now()) > 60
	ORDER BY b.MainNumber, b.ResDate, b.subintseq';

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

$query_log = '조회 SURF_SHOP_RES_SUB : '.$select_query;

$errChk .= "|02";

$k = 0;
if($count > 0){
	$x = 0;
	$PreMainNumber = "";

	while ($rowTime = mysqli_fetch_assoc($result_setlist)){
		$MainNumber = $rowTime['MainNumber'];

		//============================ 실행 단계 ============================
		if($MainNumber != $PreMainNumber && $x > 0){
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 자동취소 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$PreMainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록 : \n'.$surfshopMsg.'\n---------------------------------\n  ▶안내사항\n   - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n  ▶문의\n - '.sendTel('이승철').'\n - http://pf.kakao.com/_HxmtMxl';

			sendKakao("surfTime", "surfenjoy_res1", $kakaoMsg1, $userPhone, $PreMainNumber, "link1", "link2", "link3");

			$surfshopMsg = "";
			$k++;
		}
		//============================ 실행 단계 ============================

		$sDate = $rowTime["ResDate"];
		$userName = $rowTime['userName'];
		$userPhone = $rowTime['userPhone'];
		$shopname = $rowTime['shopCode'];

		$TimeDate = "";
		if($rowTime['ResGubun'] == 0 || $rowTime['ResGubun'] == 2){
			$TimeDate = '('.$rowTime['ResTime'].')';
		}else if($rowTime['ResGubun'] == 3){
			$TimeDate = '('.$rowTime['ResDay'].')';
		}
		
		$ResNum = "";
		if($rowTime['ResNumM'] > 0){
			$ResNum = "남:".$rowTime['ResNumM'].' ';
		}

		if($rowTime['ResNumW'] > 0){
			$ResNum .= "여:".$rowTime['ResNumW'];
		}

		$surfshopMsg .= '    -  ['.$rowTime["ResDate"].'] '.$rowTime["ResOptName"].$TimeDate.' / '.$ResNum.'\n';
		if($rowTime["ResGubun"] == 2){
			$surfshopMsg .= '         ('.preg_replace('/\s+/', '', $rowTime["ResDay"]).')\n';
		}

		$x++;
		$PreMainNumber = $rowTime['MainNumber'];
		$subintseq .= $rowTime['subintseq'].',';
	}
	$subintseq .= '0';

	$errChk .= "|03";
//============================ 실행 단계 ============================
	$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 자동취소 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$PreMainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록 : \n'.$surfshopMsg.'\n---------------------------------\n  ▶안내사항\n   - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n  ▶문의\n - '.sendTel('이승철').'\n - http://pf.kakao.com/_HxmtMxl';

	sendKakao("surfTime", "surfenjoy_res1", $kakaoMsg1, $userPhone, $PreMainNumber, "link1", "link2", "link3");
	$k++;
//============================ 실행 단계 ============================

	$errChk .= "|04";

	$select_query = "
				UPDATE SURF_SHOP_RES_SUB
				   SET ResConfirm = 1
					  ,udpdate = now()
					  ,udpuserid = 'timeover'
				WHERE subintseq IN (".$subintseq.")";

	$result_set = mysqli_query($conn, $select_query);

	$query_log .= '자동취소 SURF_SHOP_RES_SUB : '.$select_query;

	$errChk .= "|05";
	if(!$result_set) $success = false;
}
$countChk = "서핑|".$k;

//==== 서핑버스 예약건 자동취소 ====
$subintseq = "";
$select_query = 'SELECT a.userName, a.userPhone, a.Etc, b.* 
	FROM `SURF_BUS_MAIN` as a INNER JOIN `SURF_BUS_SUB` as b 
		ON a.MainNumber = b.MainNumber 
	WHERE b.ResConfirm = 0
		AND TIMESTAMPDIFF(MINUTE, b.insdate, now()) > 60
	ORDER BY b.MainNumber, b.busDate, b.sLocation, b.subintseq';

$query_log .= '조회 SURF_BUS_SUB : '.$select_query;

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

$errChk .= "|06";

$k = 0;
if($count > 0){
	$x = 0;
	$PreMainNumber = "";
	$arrSeatInfo = array();
	while ($rowTime = mysqli_fetch_assoc($result_setlist)){
		$MainNumber = $rowTime['MainNumber'];

		$userName = $rowTime['userName'];
		$ResNumber = $rowTime['MainNumber'];
		$userPhone = $rowTime['userPhone'];

//============================ 실행 단계 ============================
		if($MainNumber != $PreMainNumber && $x > 0){
			foreach($arrSeatInfo as $x) {
				$busSeatInfo .= $x;
			}

			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 양양셔틀버스 자동취소 안내입니다.\n\n서프엔조이 양양셔틀버스 예약정보\n  ▶ 예약번호 : '.$PreMainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 취소좌석 : \n'.$busSeatInfo.'---------------------------------\n  ▶안내사항\n   - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n  ▶문의\n - '.sendTel('이승철').'\n - http://pf.kakao.com/_HxmtMxl';

			sendKakao("campTime", "surfenjoy_res1", $kakaoMsg1, $userPhone, $PreMainNumber, "campres", "link2", "link3");

			$busSeatInfo = "";
			$arrSeatInfo = array();

			$k++;
		}
//============================ 실행 단계 ============================
		$sDate = $rowTime["busDate"];
		$userName = $rowTime['userName'];
		$userPhone = $rowTime['userPhone'];

		if(array_key_exists($sDate.$rowTime['busNum'], $arrSeatInfo)){
			$arrSeatInfo[$sDate.$rowTime['busNum']] .= '    - '.$rowTime['busSeat'].'번 ('.$rowTime['sLocation'].' -> '.$rowTime['eLocation'].')\n';
		}else{
			$arrSeatInfo[$sDate.$rowTime['busNum']] = '   ['.$sDate.'] '.fnBusNum($rowTime['busNum']).'\n    - '.$rowTime['busSeat'].'번 ('.$rowTime['sLocation'].' -> '.$rowTime['eLocation'].')\n';
		}

		$x++;
		$PreMainNumber = $rowTime['MainNumber'];
		$subintseq .= $rowTime['subintseq'].',';
	}
	$subintseq .= '0';

//============================ 실행 단계 ============================
	foreach($arrSeatInfo as $x) {
		$busSeatInfo .= $x;
	}

	$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 양양셔틀버스 자동취소 안내입니다.\n\n서프엔조이 양양셔틀버스 예약정보\n  ▶ 예약번호 : '.$PreMainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 취소좌석 : \n'.$busSeatInfo.'---------------------------------\n  ▶안내사항\n   - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n  ▶문의\n - '.sendTel('이승철').'\n - http://pf.kakao.com/_HxmtMxl';

	sendKakao("busTime", "surfenjoy_res1", $kakaoMsg1, $userPhone, $PreMainNumber, "link1", "link2", "link3");
	$k++;
//============================ 실행 단계 ============================

	$success = true;
	$select_query = "
				UPDATE `SURF_BUS_SUB` 
				   SET ResConfirm = 2
					  ,udpdate = now()
					  ,udpuserid = 'timeover'
				WHERE subintseq IN (".$subintseq.")";

	$query_log .= '자동취소 SURF_BUS_SUB : '.$select_query;

	$result_set = mysqli_query($conn, $select_query);

	$errChk .= "|07";
	if(!$result_set) $success = false;
}
$countChk .= "@버스|".$k;


//==== 양양페스티벌 예약건 자동취소 ====
$subintseq = "";
$select_query = 'SELECT * FROM SURF_YANGFE_MAIN WHERE ResConfirm = 0 AND TIMESTAMPDIFF(MINUTE, insdate, now()) > 60';

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

$query_log = '조회 SURF_YANGFE_MAIN : '.$select_query;

$errChk .= "|08";

$k = 0;
if($count > 0){
	while ($rowTime = mysqli_fetch_assoc($result_setlist)){
		$MainNumber = $rowTime['MainNumber'];
		$userName = $rowTime['userName'];
		$userPhone = $rowTime['userPhone'];
		$subintseq .= $rowTime['intseq'].',';

		$curl = curl_init();

		$tempName = "yangfe1";
		$smsTitle = "2019 양양서핑 페스티벌 자동취소";

		$kakaoMsg = '안녕하세요! ['.$userName.']님\n2019 양양서핑 페스티벌 예약안내입니다.\n\n2019 양양서핑 페스티벌 자동취소\n  ▶ 예약자: '.$userName.'\n---------------------------------\n▶ 안내사항\n    - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n▶ 문의\n    - 02.512.9879';

		$btnList = '"button1":{"type":"WL","name":"페스티벌 안내","url_mobile":"https://actrip.co.kr/yangfe"},"button2":{"type":"WL","name":"셔틀버스 안내","url_mobile":"https://actrip.co.kr/surfbus"},"button3":{"type":"WL","name":"서핑강습 안내","url_mobile":"https://actrip.co.kr/surfeast"},';

		$arryKakao = '[{"message_type":"at","phn":"82'.substr(str_replace('-', '',$userPhone), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$tempName.'","msg":"'.$kakaoMsg.'",'.$btnList.'"smsKind":"L","msgSms":"'.$kakaoMsg.'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$smsTitle.'","smsOnly":"N"}]';

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://alimtalk-api.bizmsg.kr/v2/sender/send",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $arryKakao,
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/json", "userId: surfenjoy"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$x++;
	}
	$subintseq .= '0';

	$errChk .= "|09";

	$select_query = "
				UPDATE SURF_YANGFE_MAIN
				   SET ResConfirm = 3
					  ,udpdate = now()
				WHERE intseq IN (".$subintseq.")";

	$result_set = mysqli_query($conn, $select_query);

	$query_log .= '자동취소 SURF_YANGFE_MAIN : '.$select_query;

	$errChk .= "|10";
	if(!$result_set) $success = false;
}
$countChk .= "@양페|".$k;


if(!$success){
	mysqli_query($conn, "ROLLBACK");
	$success = 'err';
}else{
	mysqli_query($conn, "COMMIT");
	$success = 'ok';
}

$query_log = '';

$select_query = "UPDATE SURF_TIMEOVER SET success = '".$success."', stats = '".$errChk."', gubuncount = '".$countChk."', sqlquery = '".$query_log."' WHERE seq = ".$seq;
$result_set = mysqli_query($conn, $select_query);

mysqli_query($conn, "COMMIT");
?>