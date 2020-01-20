<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

include __DIR__.'/../surfencrypt.php';


function begin(){
	mysql_query("BEGIN");
}

function rollback(){
	mysql_query("ROLLBACK");
}

function commit(){
	mysql_query("COMMIT");
}

function smsHistory(){

}

$success = true;
$datetime = date('Y/m/d H:i'); 

$content = trim($_REQUEST["content"]);
$keyword = trim($_REQUEST["keyword"]);

mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

if($content == "" || $keyword == ""){
	exit;
}

$content = preg_replace('/\s+/u', ' ', $content);

$bankname = explode("@", $keyword)[0];
$arrSMS = explode("@", $content);

if($bankname == "신한"){
	//[Web발신]@신한 04/09 14:20@389-02-188735@입금         34@이승철
	$banknum = $arrSMS[2];

	$bankprice = explode(" ", $arrSMS[3])[1];
	$bankprice = str_replace(',', '', $bankprice);

	$bankuser = $arrSMS[4];
}else if($bankname == "농협"){
	//[Web발신]@농협 입금130,000원@04/09 14:20 351-****-8484-73 김보미
	$bankprice = explode(" ", $arrSMS[1])[1];
	$bankprice = str_replace(',', '', $bankprice);
	$bankprice = str_replace('입금', '', $bankprice);
	$bankprice = str_replace('원', '', $bankprice);

	$banknum = explode(" ", $arrSMS[2])[2];
	$bankuser = explode(" ", $arrSMS[2])[3];
}else if($bankname == "우리"){
	//[Web발신]@우리 06/08 08:58@8900*01@입금 200원@이승철
	$bankprice = explode(" ", $arrSMS[3])[1];
	$bankprice = str_replace(',', '', $bankprice);
	$bankprice = str_replace('입금', '', $bankprice);
	$bankprice = str_replace('원', '', $bankprice);

	$banknum = $arrSMS[2];
	$bankuser = $arrSMS[4];
}else if($bankname == "하나"){
	//[Web발신]@하나,06/07,13:56@210******32605@입금160,000원@박승용
	$bankprice = explode(" ", $arrSMS[3])[1];
	$bankprice = str_replace(',', '', $bankprice);
	$bankprice = str_replace('입금', '', $bankprice);
	$bankprice = str_replace('원', '', $bankprice);

	$banknum = $arrSMS[2];
	$bankuser = $arrSMS[4];
}else{
	$bankprice = "0";
	$banknum = "";
	$bankuser = "";
}

$select_query = "INSERT INTO `SURF_SMS`(`smscontent`, `keyword`, `shopSeq`, `bankprice`, `bankname`, `banknum`, `bankuser`, `insdate`) VALUES ('$content', '$keyword', 0, '$bankprice', '$bankname', '$banknum', '$bankuser', now())";
$result_set = mysqli_query($conn, $select_query);
$seq = mysqli_insert_id($conn);
//echo $select_query.'<br>';

if(!$result_set){
	mysqli_query($conn, "ROLLBACK");
	echo 'err';
}else{
	mysqli_query($conn, "COMMIT");

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	if($banknum == "389-02-188735" && $bankname == "신한"){ //셔틀, 바베큐 계좌 : 서프엔조이
		$resgubun = "surfbus";
		//ex : https://actrip.co.kr/userAdd/callback/bank.php?content=[Web발신]@신한 04/09 14:20@389-02-188735@입금 35100@이승철&keyword=신한@입금
	}else if($banknum == "351-****-8484-73" && $bankname == "농협"){ //야영장 : 이준영
		$resgubun = "camp";
		//ex : https://actrip.co.kr/userAdd/callback/bank.php?content=[Web발신]@농협 입금130,000원@04/09 14:20 351-****-8484-73 김보미 잔액1,124,000&keyword=농협@입금
	}else{
		$resgubun = "surfshop";
	}



	if($resgubun == "surfbus" || $resgubun == "camp"){		
		if($resgubun == "surfbus"){ //서핑버스 or 바베큐
			$subTable = "SURF_BUS_SUB";
			$gubunname = "서핑버스";

			$select_query = "SELECT * FROM SURF_BUS_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price FROM `SURF_BUS_SUB` WHERE ResConfirm = 0 GROUP BY MainNumber HAVING SUM(ResPrice) = $bankprice) as b
								ON a.MainNumber = b.MainNumber
								WHERE a.userName = '$bankuser'";
		}else{ //야영장
			$subTable = "SURF_CAMPING_SUB";
			$gubunname = "야영장";

			$select_query = "SELECT * FROM SURF_CAMPING_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price, SUM(CASE WHEN ResOptPrice = '1@전기@5000' THEN 5000 ELSE 0 END) AS opt FROM `SURF_CAMPING_SUB` WHERE ResConfirm = 0 GROUP BY MainNumber) as b 
								ON a.MainNumber = b.MainNumber 
								WHERE (price + opt) = $bankprice AND userName = '$bankuser'";
		}
		//echo $select_query;
		$result_setlist = mysqli_query($conn, $select_query);
		$count = mysqli_num_rows($result_setlist);

		//바베큐 쿼리
		$select_query_bbq = "SELECT * FROM SURF_SHOP_RES_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price FROM SURF_SHOP_RES_SUB WHERE ResConfirm = 0 GROUP BY MainNumber) as b 
							ON a.MainNumber = b.MainNumber 
							WHERE a.shopSeq = 5 AND price = $bankprice AND userName = '$bankuser'";
		
		$ResConfirm = 1;
		$shopSeq = 0;
		$totalcount = $count;
		$count_bbq = 0;

		if($resgubun == "surfbus"){
			if($count == 0){
				$result_setlist = mysqli_query($conn, $select_query_bbq);
				$count_bbq = mysqli_num_rows($result_setlist);

				if($count_bbq > 0){		
					$resgubun = "surfbbq";
					$subTable = "SURF_SHOP_RES_SUB";
					$gubunname = "바베큐";
					$ResConfirm = 5;
					$shopSeq = 5;

					$totalcount = $count_bbq;
				}
			}else{
				$result_setlist_bbq = mysqli_query($conn, $select_query_bbq);
				$count_bbq = mysqli_num_rows($result_setlist_bbq);

				$totalcount = $count + $count_bbq;
			}
		}

		if($totalcount == 1){
			while ($row = mysqli_fetch_assoc($result_setlist)){
				$MainNumber = $row['MainNumber'];
				$ResNumber = $row["MainNumber"];
				$userName = $row["userName"];
				$etc = $row["Etc"];
				$userPhone = $row["userPhone"];
				$usermail = $row["userMail"];
			}

			if($resgubun == "surfbus"){
				//====== 셔틀버스 알림톡 발송
				$busSeatInfo = "";
				$busStopInfo = "";
				$pointMsg = '';
				$arrSeatInfo = array();
				$arrStopInfo = array();
				$select_query_sub = 'SELECT * FROM SURF_BUS_SUB where ResConfirm = 0 AND MainNumber = '.$ResNumber.' ORDER BY busDate, busSeat';

				$resultSite = mysqli_query($conn, $select_query_sub);

				while ($rowSub = mysqli_fetch_assoc($resultSite)){
					if(array_key_exists($rowSub['busDate'].$rowSub['busNum'], $arrSeatInfo)){
						$arrSeatInfo[$rowSub['busDate'].$rowSub['busNum']] .= '    - '.$rowSub['busSeat'].'번 ('.$rowSub['sLocation'].' -> '.$rowSub['eLocation'].')\n';
					}else{
						$arrSeatInfo[$rowSub['busDate'].$rowSub['busNum']] = '   ['.$rowSub['busDate'].'] '.fnBusNum($rowSub['busNum']).'\n    - '.$rowSub['busSeat'].'번 ('.$rowSub['sLocation'].' -> '.$rowSub['eLocation'].')\n';
					}

					$arrData = explode("|", fnBusPoint($rowSub['sLocation'], $rowSub['busNum'], 0));
					$arrStopInfo[$rowSub['sLocation']] = '   ['.$rowSub['sLocation'].'] '.$arrData[0].'\n    - '.$arrData[1].'\n';
				}

				foreach($arrSeatInfo as $x) {
					$busSeatInfo .= $x;
				}

				foreach($arrStopInfo as $x) {
					$busStopInfo .= $x;
				}

				$busSeatInfo = '  ▶ 좌석안내\n'.$busSeatInfo;
				$pointMsg = '\n  ▶ 탑승시간/위치 안내\n'.$busStopInfo.'\n';

				$campStayName = "busConfirm1";
				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 양양셔틀버스 예약확정 안내입니다.\n\n서프엔조이 양양셔틀버스 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자 : '.$userName.'\n'.$busSeatInfo.$pointMsg.$bbqMsg.'---------------------------------\n  ▶ 안내사항\n   - 이용일, 탑승시간, 탑승위치 꼭 부탁드립니다. \n   - 자세한 정류장 위치는 https://actrip.co.kr/surfbus 에서 확인하세요.\n\n  ▶ 문의\n    - 010.3308.6080\n    - http://pf.kakao.com/_HxmtMxl';

				sendKakao($campStayName, "surfenjoy_busres1", $kakaoMsg1, $userPhone, $ResNumber, "surfbus", "link2", "link3");

				$to = "lud1@naver.com";
				if(strrpos($usermail, "@") > 0){
					$to .= ','.$usermail;
				}

				$arrMail = array(
					"campStayName"=> "busConfirm1"
					, "userName"=> $userName
					, "busSeatInfo"=> str_replace('\n', '<br>', $busSeatInfo)
					, "busStopInfo"=> str_replace('\n', '<br>', $busStopInfo)
					, "ResNumber"=> $ResNumber
					, "gubun"=>"양양셔틀버스"
					, "userPhone"=>$userPhone
					, "etc"=>$etc
					, "totalPrice"=>number_format($TotalPrice)
					, "banknum"=>"신한은행 / 389-02-188735 / 이승철"
				);

				sendMail("surfbus2@surfenjoy.com", "surfenjoy", sendMailContentBus($arrMail), $to, $arrMail);

			}else if($resgubun == "surfbbq"){
				//====== 바베큐 알림톡 발송
				$select_query = "SELECT a.*, b.gubun, b.codename FROM `SURF_SHOP` a INNER JOIN SURF_CODE b ON a.cate_3 = b.seq AND a.intseq = 5";

				$result_setlist = mysqli_query($conn, $select_query);
				$rowShop = mysqli_fetch_array($result_setlist);
				$count = mysqli_num_rows($result_setlist);

				$subTable = "SURF_SHOP_RES_SUB";
				$gubunname = "서핑샵";

				$shopSeq = $rowShop["intseq"];
				$shopName = $rowShop["shopname"];
				
				$shopname = $rowShop["shopname"]; //샵 정보
				$admin_tel = $rowShop["admin_tel"]; //카톡 발송 연락처
				$shop_addr = $rowShop["shop_addr"]; //샵 주소
				$shop_gubun = $rowShop["gubun"]; //샵 구분
				$admin_email = $rowShop["admin_email"]; //샵 메일주소
				$codename = $rowShop["codename"]; //샵 해변
				$groupcode = $rowShop["groupcode"];
				$opt_bbq = $rowShop["opt_bbq"]; //서프엔조이 바베큐 여부

				$shopseq = $shopSeq;

				$arrSeatInfo = array();
				$arrStopInfo = array();

				//==========================카카오 메시지 발송 ==========================
				$select_query_sub = 'SELECT * FROM `SURF_SHOP_RES_SUB` WHERE ResConfirm = 0 AND MainNumber = '.$MainNumber.' ORDER BY ResDate, subintseq';
				$resultSite = mysqli_query($conn, $select_query_sub);

				while ($rowSub = mysqli_fetch_assoc($resultSite)){
					$TimeDate = "";
					if($rowSub["ResGubun"] == 0 || $rowSub["ResGubun"] == 2){
						$TimeDate = '('.$rowSub["ResTime"].')';
					}else if($rowSub["ResGubun"] == 3){
						$TimeDate = '('.$rowSub["ResDay"].')';
					}

					$ResNum = "";
					if($rowSub["ResNumM"] > 0){
						$ResNum = "남:".$rowSub["ResNumM"].'명 ';
					}

					if($rowSub["ResNumW"] > 0){
						$ResNum .= "여:".$rowSub["ResNumW"].'명';
					}

					$surfMsg .= '    -  ['.$rowSub["ResDate"].'] '.$rowSub["ResOptName"].$TimeDate.' / '.$ResNum.'\n';
					if($rowSub["ResGubun"] == 2){
						$surfMsg .= '         ('.preg_replace('/\s+/', '', $rowSub["ResDay"]).')\n';
					}

					if(!($opt_bbq == "Y" && $rowSub["ResGubun"] == 4)){
						$surfshopMsg .= '    -  ['.$rowSub["ResDate"].'] '.$rowSub["ResOptName"].$TimeDate.' / '.$ResNum.'\n';
						if($rowSub["ResGubun"] == 2){
							$surfshopMsg .= '         ('.preg_replace('/\s+/', '', $rowSub["ResDay"]).')\n';
						}
					}else{
						$bbqMsg = "  ▶ 바베큐 정보\n    - 위치 : 죽도해변 관리실 앞\n    - 시간 : 19:00 ~ 22:00까지\n";
						$bbqMsgMail = "  - 위치 : 죽도해변 관리실 앞<br> - 시간 : 19:00 ~ 22:00까지";
					}
				}

				if($etc != ''){
					$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
				}

				if($surfMsg != ""){
					//======== 고객 알림톡 발송 =========
					$campStayName = "surfshop2";
					$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 확정완료 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록\n'.$surfMsg.$shopInfo.$bbqMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n   - 예약샵, 이용일, 이용시간 꼭 확인부탁드립니다.\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';
					sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $MainNumber, "surfres?seq=".$shopseq, "surforder", $shopname);

					$to = "lud1@naver.com";
					if(strrpos($admin_email, "@") > 0){
						$to .= ','.$admin_email;
					}

					$arrMail = array(
						"campStayName"=> "surfshop1"
						, "userName"=> $userName
						, "surfInfo"=> str_replace('\n', '<br>', $surfMsg)
						, "surfInfoAddr"=> $bbqMsgMail
						, "ResNumber"=> $MainNumber
						, "gubun"=>$shopname
						, "userPhone"=>$userPhone
						, "etc"=>$etc
					);

					sendMail("surfshop2@surfenjoy.com", "surfenjoy", sendMailContentSurf($arrMail), $to, $arrMail);
				}
				//==========================카카오 메시지 발송 End ==========================
			}else{
			//====== 야영장 알림톡 발송
				$i = 0;
				$select_query_sub = 'SELECT * FROM `SURF_CAMPING_SUB` WHERE ResConfirm = 0 AND MainNumber = '.$ResNumber.' ORDER BY sDate, sLocation';
				$resultSite = mysqli_query($conn, $select_query_sub);

				$coupon = "";
				while ($rowSub = mysqli_fetch_assoc($resultSite)){
					$sDate = $rowSub["sDate"];
					if($i == 0){
						$selDate = $sDate;
					}

					$arrOpt = explode("@",$rowSub['ResOptPrice']);

					$totalPrice = $rowSub['ResPrice'] + $arrOpt[2];
					$totalPriceRtn = $totalPriceRtn + $totalPrice;
					$locationOpt = "";
					$locationOpt2 = "";
		
					if($arrOpt[2] > 0){
						$locationOpt = " (".$arrOpt[1]." ".number_format($arrOpt[2])."원)";
						$locationOpt2 = "(".$arrOpt[1].")";
					}

					$location1 .= " - [".$sDate."] ".$rowSub['sLocation']." (".number_format($rowSub['ResPrice'])."원)".$locationOpt."<br>";

					$location2 .= "       - [".$sDate."] ".$rowSub['sLocation'].$locationOpt2."\n";

					$totalPriceRtn2 = $totalPriceRtn2 + $totalPrice;

					$splitM = explode("-", $sDate)[1]; // 지정된 월
					if($splitM == "07" || $splitM == "08"){
						$coupon = "   - 7,8월 이용시 1박당 샤워쿠폰 2매드립니다. 관리실에 문의주세요.\n";
					}

					$i++;
				}
				$lastDate = date("Y-m-d", strtotime($sDate." +1 day"));

				$totalPrice2 = number_format($totalPriceRtn2).'원';

				if($etc != ''){
					$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
				}

				$campStayName = "campOk1";
				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 확정완료 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 입실 : '.$selDate.' 오후 2시부터\n  ▶ 퇴실 : '.$lastDate.' 오후 12시까지\n  ▶ 예약위치 : \n'.$location2.'\n'.$etcMsg.'---------------------------------\n  ▶안내사항\n'.$coupon.'   - 야영장 이용시 애견동반금지\n   - 전기사용시 15m이상 릴선이 필요합니다.\n   - 23시 이후로는 주변에 피해가 안가도록 대화소리를 작게 해주세요.\n\n  ▶문의\n   - '.sendTel('이준영').'\n   - http://pf.kakao.com/_HxmtMxl';
				sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $MainNumber, "campres", "link2", "link3");

				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 확정완료 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 예약위치 : \n'.$location2.'\n'.$etcMsg.'---------------------------------\n  ▶안내사항\n   - 확정예약 완료되었습니다.';
				sendKakao('campshop1', "surfenjoy_shop", $kakaoMsg1, sendTel('이준영'), date("Y-m-d").'|'.$MainNumber, "campadminkakao", "link2", "link3");

				$to = "lud1@naver.com";
				if(strrpos($userMail, "@") > 0){
					$to .= ','.$userMail;
				}

				$arrMail = array(
					"campStayName"=> $campStayName
					, "userName"=> $userName
					, "selDate"=> $selDate
					, "lastDate"=> $lastDate
					, "ResNumber"=> $MainNumber
					, "gubun"=>"야영장"
					, "userPhone"=>$userPhone
					, "etc"=>$etc
					, "location"=>$location1
				);

				sendMail("surfcamp2@surfenjoy.com", "surfenjoy", sendMailContent($arrMail), $to, $arrMail);
				//==========================카카오 메시지 발송 End ==========================

			}

			$select_query = "UPDATE ".$subTable." 
						   SET ResConfirm = ".$ResConfirm."
							  ,insdate = now()
							  ,udpdate = now()
							  ,udpuserid = 'autobank'
						WHERE MainNumber = ".$MainNumber." AND ResConfirm = 0;";

			$result_set = mysqli_query($conn, $select_query);

			if(!$result_set){
				$success = false;
			}else{
				$select_query = "INSERT INTO `SURF_SMS_HISTORY`(`smscontent`, `keyword`, `shopSeq`, `goodstype`, `bankprice`, `bankname`, `banknum`, `bankuser`, `MainNumber`, `insdate`) VALUES ('$content', '$keyword', $shopSeq, '$resgubun', '$bankprice', '$bankname', '$banknum', '$bankuser', $MainNumber, now())";
				$result_set = mysqli_query($conn, $select_query);

				$select_query = "DELETE FROM `SURF_SMS` WHERE seq = ".$seq;
				$result_set = mysqli_query($conn, $select_query);
			}

		}else if ($totalcount > 1){ //같은 금액, 같은 이름 2명 이상
			$MainNumberList = "";
			while ($row = mysqli_fetch_assoc($result_setlist)){
				$MainNumber = $row['MainNumber'];

				$mailcontent .= 'seq : '.$seq.' / 주문번호 : '.$MainNumber.' / 이름 : '.$bankuser.' / 금액 : '.$bankprice.'<br>';
				$MainNumberList .= $MainNumber."|";
			}

			if($resgubun == "surfbus" && $count_bbq > 0){
				$mailcontent .= '바베큐<br>';
				while ($rowbbq = mysqli_fetch_assoc($result_setlist_bbq)){
					$MainNumber = $rowbbq['MainNumber'];

					$mailcontent .= 'seq : '.$seq.' / 주문번호 : '.$MainNumber.' / 이름 : '.$bankuser.' / 금액 : '.$bankprice.'<br>';
					$MainNumberList .= $MainNumber."|";
				}
			}

			$select_query = "UPDATE `SURF_SMS` SET goodstype = '$resgubun', MainNumberList = '$MainNumberList', shopSeq = $shopSeq WHERE seq = ".$seq;
			$result_set = mysqli_query($conn, $select_query);

			$to = "lud1@naver.com";
			$arrMail = array(
				"campStayName"=> "surfbank"
				,"gubun"=> $gubunname
			);

			sendMail("surfbank@surfenjoy.com", "surfenjoy", $gubunname.'<br>'.$mailcontent, $to, $arrMail);

		}else if ($totalcount == 0){ //금액, 이름이 없을 경우
			$select_query = "UPDATE `SURF_SMS` SET goodstype = '$resgubun', MainNumberList = 'none', shopSeq = $shopSeq WHERE seq = ".$seq;
			$result_set = mysqli_query($conn, $select_query);

			$to = "lud1@naver.com";
			$arrMail = array(
				"campStayName"=> "surfbanknone"
				,"gubun"=> $gubunname
			);

			$mailcontent = "은행 : $bankname<br>계좌번호 : $banknum<br>입금자명 : $bankuser<br>금액 : $bankprice";

			sendMail("surfbank@surfenjoy.com", "surfenjoy", $gubunname.'<br>'.$mailcontent, $to, $arrMail);
		}

	}else if($resgubun == "surfshop"){ //서핑샵
		$select_query = "SELECT a.*, b.gubun, b.codename FROM `SURF_SHOP` a INNER JOIN SURF_CODE b ON a.cate_3 = b.seq AND a.groupcode in ('surf', 'bbq') WHERE shopbankname LIKE '%".$bankname."%' AND REPLACE(shopbanknum, '-', '') = '".str_replace("-", "", $banknum)."'";

		$result_setlist = mysqli_query($conn, $select_query);
		$rowShop = mysqli_fetch_array($result_setlist);
		$count = mysqli_num_rows($result_setlist);

		$subTable = "SURF_SHOP_RES_SUB";
		$gubunname = "서핑샵";

		if($count == 0){
			$totalcount = 0;
		}else{
			$shopSeq = $rowShop["intseq"];
			$shopName = $rowShop["shopname"];
			
			$shopname = $rowShop["shopname"]; //샵 정보
			$admin_tel = $rowShop["admin_tel"]; //카톡 발송 연락처
			$shop_addr = $rowShop["shop_addr"]; //샵 주소
			$shop_gubun = $rowShop["gubun"]; //샵 구분
			$admin_email = $rowShop["admin_email"]; //샵 메일주소
			$codename = $rowShop["codename"]; //샵 해변
			$groupcode = $rowShop["groupcode"];
			$opt_bbq = $rowShop["opt_bbq"]; //서프엔조이 바베큐 여부

			$ResConfirm = 2;
			$select_query = "SELECT a.userName, a.userName, a.userPhone, a.userMail, a.Etc, a.memo, b.* FROM SURF_SHOP_RES_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price FROM SURF_SHOP_RES_SUB WHERE ResConfirm = 0 GROUP BY MainNumber) as b 
								ON a.MainNumber = b.MainNumber 
								WHERE a.shopSeq = $shopSeq AND price = $bankprice AND userName = '$bankuser'";
			$result_setlist = mysqli_query($conn, $select_query);
			$count = mysqli_num_rows($result_setlist);

			$totalcount = $count;
		}

		if($totalcount == 1){
			while ($row = mysqli_fetch_assoc($result_setlist)){
				$MainNumber = $row['MainNumber'];

				$userName = $row["userName"];
				$userPhone = $row["userPhone"];
				$userMail = $row["userMail"];
				$etc = $row["Etc"];
			}

			//====== 서핑샵 알림톡 발송
			$shopseq = $shopSeq;

			$arrSeatInfo = array();
			$arrStopInfo = array();

			//==========================카카오 메시지 발송 ==========================
			$select_query_sub = 'SELECT * FROM `SURF_SHOP_RES_SUB` WHERE ResConfirm = 0 AND MainNumber = '.$MainNumber.' ORDER BY ResDate, subintseq';
			$resultSite = mysqli_query($conn, $select_query_sub);

			while ($rowSub = mysqli_fetch_assoc($resultSite)){
				if($opt_bbq == "Y" && $rowSub["ResGubun"] == 4){
					continue;
				}

				$TimeDate = "";
				if($rowSub["ResGubun"] == 0 || $rowSub["ResGubun"] == 2){
					$TimeDate = '('.$rowSub["ResTime"].')';
				}else if($rowSub["ResGubun"] == 3){
					$TimeDate = '('.$rowSub["ResDay"].')';
				}

				$ResNum = "";
				if($rowSub["ResNumM"] > 0){
					$ResNum = "남:".$rowSub["ResNumM"].'명 ';
				}

				if($rowSub["ResNumW"] > 0){
					$ResNum .= "여:".$rowSub["ResNumW"].'명';
				}

				$surfMsg .= '    -  ['.$rowSub["ResDate"].'] '.$rowSub["ResOptName"].$TimeDate.' / '.$ResNum.'\n';
				if($rowSub["ResGubun"] == 2){
					$surfMsg .= '         ('.preg_replace('/\s+/', '', $rowSub["ResDay"]).')\n';
				}

				$surfshopMsg .= '    -  ['.$rowSub["ResDate"].'] '.$rowSub["ResOptName"].$TimeDate.' / '.$ResNum.'\n';
				if($rowSub["ResGubun"] == 2){
					$surfshopMsg .= '         ('.preg_replace('/\s+/', '', $rowSub["ResDay"]).')\n';
				}
			}

			if($etc != ''){
				$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
			}

			if($surfshopMsg != ""){
				//======== 고객 알림톡 발송 =========
				$ordersearch = "surfres?seq=".$shopseq;

				$campStayName = "surfshop6";
				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 입금완료 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록\n'.$surfMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n   - 예약하신 샵에서 예약가능 여부 확인 후 확정 및 취소가 진행됩니다.\n   - 예약항목이 매진되어 예약이 불가능 할 경우 취소 될 수 있으니 참고부탁드립니다.\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';
				sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $MainNumber, $ordersearch, "surforder", $shopname);

				//======== 샵 알림톡 발송 =========
				$kakaoInfo = "    - 예약내역 확인 후 승인처리 부탁드립니다.\n    - 매진되어 예약이 불가할 경우 임시취소 및 사유작성해주시면 별도로 처리해드리겠습니다.\n    - [예약관리] 메뉴에서 매진처리 진행하시면 해당날짜는 예약불가 처리됩니다.";

				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$userName.']님 입금완료 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록\n'.$surfshopMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n'.$kakaoInfo.'\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';

				sendKakao("surfshop4", "surfenjoy_shop2", $kakaoMsg1, $admin_tel, urlencode(encrypt(date("Y-m-d").'|'.$MainNumber.'|'.$shopseq)), $shopname, $userName, "link3");

				$to = "lud1@naver.com";
				if(strrpos($admin_email, "@") > 0){
					$to .= ','.$admin_email;
				}
				
				$arrMail = array(
					"campStayName"=> "surfshop3"
					, "userName"=> $userName
					, "surfInfo"=> str_replace('\n', '<br>', $surfMsg)
					, "surfInfoAddr"=> str_replace('\n', '<br>', "")
					, "ResNumber"=> $MainNumber
					, "gubun"=>$shopname
					, "userPhone"=>$userPhone
					, "etc"=>$etc
					, "memo"=> $row["memo"]
				);

				sendMail("surfshop2@surfenjoy.com", "surfenjoy", sendMailContentSurf($arrMail), $to, $arrMail);
			}
			//==========================카카오 메시지 발송 End ==========================

			$select_query = "UPDATE ".$subTable." 
						   SET ResConfirm = ".$ResConfirm."
							  ,insdate = now()
							  ,udpdate = now()
							  ,udpuserid = 'autobank'
						WHERE MainNumber = ".$MainNumber." AND ResConfirm = 0;";

			$result_set = mysqli_query($conn, $select_query);


			if(!$result_set){
				$success = false;
			}else{
				$select_query = "INSERT INTO `SURF_SMS_HISTORY`(`smscontent`, `keyword`, `shopSeq`, `goodstype`, `bankprice`, `bankname`, `banknum`, `bankuser`, `MainNumber`, `insdate`) VALUES ('$content', '$keyword', $shopSeq, '$resgubun', '$bankprice', '$bankname', '$banknum', '$bankuser', $MainNumber, now())";
				$result_set = mysqli_query($conn, $select_query);

				$select_query = "DELETE FROM `SURF_SMS` WHERE seq = ".$seq;
				$result_set = mysqli_query($conn, $select_query);
			}

		}else if ($totalcount > 1){ //같은 금액, 같은 이름 2명 이상
			$MainNumberList = "";
			while ($row = mysqli_fetch_assoc($result_setlist)){
				$MainNumber = $row['MainNumber'];

				$mailcontent .= 'seq : '.$seq.' / 샵seq : '.$shopSeq.' / 샵이름 : '.$shopName.' / 주문번호 : '.$MainNumber.' / 이름 : '.$bankuser.' / 금액 : '.$bankprice.'<br>';
				$MainNumberList .= $MainNumber."|";
			}
			
			$select_query = "UPDATE `SURF_SMS` SET goodstype = '$resgubun', MainNumberList = '$MainNumberList', shopSeq = $shopSeq WHERE seq = ".$seq;
			$result_set = mysqli_query($conn, $select_query);

			$to = "lud1@naver.com";
			$arrMail = array(
				"campStayName"=> "surfbank"
				,"gubun"=> $gubunname
			);

			sendMail("surfbank@surfenjoy.com", "surfenjoy", $gubunname.'<br>'.$mailcontent, $to, $arrMail);

		}else if ($totalcount == 0){ //금액, 이름이 없을 경우
			$select_query = "UPDATE `SURF_SMS` SET goodstype = '$resgubun', MainNumberList = 'none', shopSeq = $shopSeq WHERE seq = ".$seq;
			$result_set = mysqli_query($conn, $select_query);

			$to = "lud1@naver.com";
			$arrMail = array(
				"campStayName"=> "surfbanknone"
				,"gubun"=> $gubunname
			);

			$mailcontent = "은행 : $bankname<br>계좌번호 : $banknum<br>입금자명 : $bankuser<br>금액 : $bankprice";

			sendMail("surfbank@surfenjoy.com", "surfenjoy", $gubunname.'<br>'.$mailcontent, $to, $arrMail);
		}

	}

	if(!$result_set){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");
		echo '0';
	}
}

mysqli_close($conn);
?>

