<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

include __DIR__.'/../surfencrypt.php';

$param = $_REQUEST["resparam"];

function begin(){
	mysql_query("BEGIN");
}

function rollback(){
	mysql_query("ROLLBACK");
}

function commit(){
	mysql_query("COMMIT");
}

$success = true;
if($param == "CampI"){
	$ResNumber = '1'.time().substr(mt_rand(0, 99) + 100, 1, 2); //예약번호 랜덤생성
	$ResNumber2 = '2'.time().substr(mt_rand(0, 99) + 100, 1, 2); //예약번호 랜덤생성

	$selDate = $_REQUEST["selDate"];
	$selWeek = $_REQUEST["selWeek"];
	
	$selDay = $_REQUEST["selDay"];
	$nextday = explode("-", $_REQUEST["selDate"]);
	$nextDate = date("Y-m-d", mktime(0, 0, 0, $nextday[1], $nextday[2], $nextday[0]));
	$lastDate = date("Y-m-d", strtotime($nextDate." +".$selDay." day"));

	$userId = $_REQUEST["userId"];
	$userName = $_REQUEST["userName"];
	$userPhone = $_REQUEST["userPhone1"]."-".$_REQUEST["userPhone2"]."-".$_REQUEST["userPhone3"];
	$userYear = $_REQUEST["userYear"];
	$InsUserID = $_REQUEST["userId"];
	$usermail = $_REQUEST["usermail"];
	$restype = $_REQUEST["hidrestype"];
	
	$ReschkOpt = count($_REQUEST['chkOpt']);
	$ResUserNum = count($_REQUEST['chkSeat']);
	$chkSeatSel = $_REQUEST['chkSeatSel'];
	$priceType = "N";
	$etc = $_REQUEST["etc"];

	$datetime= date('Y/m/d H:i'); 
	$select_query = 'SELECT sLocation FROM SURF_CAMPING_SUB where (sDate >= "'.$selDate.'" AND sDate < "'.$lastDate.'") AND sLocation IN ('.$chkSeatSel.') AND DelUse = "N" AND ResConfirm IN (0, 1) GROUP BY sLocation';

	$result_setlist = mysqli_query($conn, $select_query);
	$count = mysqli_num_rows($result_setlist);

	if($count > 0){
		echo '<script>alert("선택하신 자리 중 먼저 예약된 자리가 있습니다.\n\n날짜를 다시 선택해주세요.");</script>';
		return;
	}

	$campMon = substr($selDate,5,2);

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$arrResOpt = array();
	$ResOptPriceSum = 0;
	$ResPriceSum = 0;

	if($_REQUEST['chkOpt'] != ""){
		foreach($_REQUEST['chkOpt'] as $z) {
			$ResOpt = htmlspecialchars($z);

			$x=explode("|",$ResOpt);
			$tmpResType = substr($x[1], 0, 1);

			if($tmpResType == 'A'){
				$arrResOpt[$x[1]] = $x[0].'@전기@0';
			}else{
				$arrResOpt[$x[1]] = $x[0].'@전기@5000';
				$ResOptPriceSum += ($selDay * 5000);
			}
		}
	}

	foreach($_REQUEST['chkSeat'] as $c) {
		$ResSeat = htmlspecialchars($c);
		$SunNumber = $ResNumber.$ResSeat;
		$ResType = substr($ResSeat, 0, 1);
		
		$ResOpt = "";
		if(array_key_exists($ResSeat, $arrResOpt)){
			$ResOpt = $arrResOpt[$ResSeat];
		}

		$LastResNumber = $ResNumber;

		for($i=0;$i < $selDay;$i++){
			$sumNextDate = date("Y-m-d", strtotime($nextDate." +".$i." day"));
			$priceBool = ($sumNextDate >= $nextday[0]."-07-01" && $sumNextDate <= $nextday[0]."-08-31");

			if($priceBool){ //성수기
				if($ResType == "A"){
					$LastPrice = 150000;
				}else if($ResType == "C"){
					$LastPrice = 40000;
				}else{
					$LastPrice = 30000;
				}
			}else{ //비수기
				if($ResType == "A"){
					$LastPrice = 120000;
				}else if($ResType == "C"){
					$LastPrice = 30000;
				}else{
					$LastPrice = 20000;
				}
			}

			$ResPriceSum += $LastPrice;

			$select_query = "INSERT INTO `SURF_CAMPING_SUB` (`MainNumber`, `sDate`, `sArea`, `sLocation`, `ResPrice`, `ResOptName`, `ResOptPrice`, `ResConfirm`, `ResGubun`, `RtnPrice`, `RtnBank`, `DelUse`, `insuserid`, `insdate`, `udpuserid`, `udpdate`, `restype`) VALUES ('$LastResNumber', '$sumNextDate', '$ResType', '$ResSeat', $LastPrice, NULL, '$ResOpt', 0, 1, 0, NULL, 'N', '$InsUserID', '$datetime', '$InsUserID', '$datetime', '$restype');";
			//echo $select_query.'<br><br>';

			$result_set = mysqli_query($conn, $select_query);
			//$result_set = 1;

			if(!$result_set){
				$success = false;
				break;
			}
		}
	}

	if($success){
		$Gubun = "jukdo";
		$MainsType = "C";
		$seatList = str_replace('\'', '',$chkSeatSel);

		$select_query = "INSERT INTO `SURF_CAMPING_MAIN` (`Gubun`, `sType`, `MainNumber`, `sDate`, `eDate`, `stay`, `sLocation`, `userID`, `userName`, `userPhone`, `userMail`, `Etc`, `ResConfirm`, `ResPrice`, `ResOptPrice`, `DelUse`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES ('$Gubun', '$MainsType', '$ResNumber', '$selDate', '$lastDate', '$selDay', '$seatList', '$userId', '$userName', '$userPhone', '$usermail', '$etc', '0', '$ResPriceSum', '$ResOptPriceSum', 'N', '$InsUserID', '$datetime', '$InsUserID', '$datetime');";
		//echo $select_query;
		//return;

		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo '<script>alert("예약 중 오류가 발생하였습니다.");</script>';
	}else{
		mysqli_query($conn, "COMMIT");

		$select_query = '
			SELECT * FROM `SURF_CAMPING_SUB` where MainNumber = '.$ResNumber;
		$result_setlist = mysqli_query($conn, $select_query);

		$location = "";
		$location2 = "";
		$location3 = "";
		$totalPriceRtn = 0;
		$totalPriceRtn2 = 0;
		$totalPriceRtn3 = 0;

		while ($rowSub = mysqli_fetch_assoc($result_setlist)){
			$arrOpt = explode("@",$rowSub['ResOptPrice']);

			$totalPrice = $rowSub['ResPrice'] + $arrOpt[2];
			$totalPriceRtn = $totalPriceRtn + $totalPrice;
			$locationOpt = "";
			$locationOpt2 = "";
			
			if($rowSub['sArea'] == "A"){
				$location0 .= " - ".$rowSub['sLocation']." (".number_format($rowSub['ResPrice'])."원 + ".$arrOpt[1]." ".number_format($arrOpt[2])."원 = ".number_format($totalPrice).")<br>";

				$location3 .= "       - ".$rowSub['sLocation']."(".number_format($rowSub['ResPrice'])."원 + ".$arrOpt[1]." ".number_format($arrOpt[2])."원 = ".number_format($totalPrice).")\r\n";

				$totalPriceRtn3 = $totalPriceRtn3 + $totalPrice;
			}else{

				if($arrOpt[2] > 0){
					$locationOpt = " (".$arrOpt[1]." ".number_format($arrOpt[2])."원)";
					$locationOpt2 = "(".$arrOpt[1].")";
				}

				$location1 .= " - [".substr($rowSub['sDate'], 0, 10)."] ".$rowSub['sLocation']." (".number_format($rowSub['ResPrice'])."원)".$locationOpt."<br>";

				$location2 .= "       - [".substr($rowSub['sDate'], 0, 10)."] ".$rowSub['sLocation'].$locationOpt2."\n";

				$totalPriceRtn2 = $totalPriceRtn2 + $totalPrice;
			}
		}

		$totalPrice = number_format($totalPriceRtn).'원';
		$totalPrice2 = number_format($totalPriceRtn2).'원';
		$totalPrice3 = number_format($totalPriceRtn3).'원';

		if($location2 != ""){
			$location2 .= '       총 합계 : '.number_format($totalPriceRtn2).'원';
		}

		if($location3 != ""){
			$location3 .= '       총 합계 : '.number_format($totalPriceRtn3).'원';
		}

		if($etc != ''){
			$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
		}

		$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 입금대기 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 입실 : '.$selDate.' 오후 2시부터\n  ▶ 퇴실 : '.$lastDate.' 오후 12시까지 ('.$selDay.'박)\n  ▶ 예약위치 : \n'.$location2.'\n'.$etcMsg.'---------------------------------\n  ▶안내사항\n   - 1시간 이내 미입금시 자동취소됩니다.\n   - 야영장 이용시 애견동반금지\n   - 전기사용시 15m이상 릴선이 필요합니다.\n\n  ▶입금계좌\n   농협 351-1079-6271-13 전동한\n\n  ▶문의\n   - '.sendTel('이준영2').'\n   - http://pf.kakao.com/_HxmtMxl';

		$kakaoMsg2 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도글램핑 입금대기 안내입니다.\n\n서프엔조이 죽도글램핑 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 입실 : '.$selDate.' 오후 2시부터\n  ▶ 퇴실 : '.$lastDate.' 오후 12시까지 ('.$selDay.'박)\n  ▶ 예약위치 : \n'.$location3.'\n'.$etcMsg.'---------------------------------\n  ▶안내사항\n   - 1시간 이내 미입금시 자동취소됩니다.\n   - 글램핑 이용시 애견동반금지\n\n  ▶입금계좌\n   신한은행 389-02-188735 이승철\n\n  ▶문의\n - http://pf.kakao.com/_HxmtMxl';

		$campStayName = "campStay1";

		$to = "lud1@naver.com";
		if(strrpos($usermail, "@") > 0){
			$to .= ','.$usermail;
		}

		if($location2 != ""){
			$arrMail = array(
				"campStayName"=> $campStayName
				, "userName"=> $userName
				, "selDate"=> $selDate
				, "lastDate"=> $lastDate
				, "selDay"=> $selDay
				, "ResNumber"=> $ResNumber
				, "gubun"=>"야영장"
				, "userPhone"=>$userPhone
				, "etc"=>$etc
				, "location"=>$location1
				, "totalPrice"=>$totalPrice2
				, "banknum"=>"농협 / 351-1079-6271-13 / 전동한"
			);

			sendMail("surfcamp1@surfenjoy.com", "surfenjoy", sendMailContent($arrMail), $to, $arrMail);

			sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $ResNumber, "campres", "link2", "link3");

			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 입금대기 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 예약위치 : \n'.$location2.'\n'.$etcMsg.'---------------------------------\n  ▶안내사항\n   - 입금 확인 후 승인처리 부탁드립니다.';

			sendKakao('campshop1', "surfenjoy_shop", $kakaoMsg1, sendTel('이준영'), urlencode(encrypt(date("Y-m-d").'|'.$ResNumber)), "campadminkakao", "link2", "link3");
			//sendKakao('campshop1', "surfenjoy_shop", $kakaoMsg1, sendTel('이준영'), date("Y-m-d").'|'.$ResNumber, "campadminkakao", "link2", "link3");
		}

		if($location3 != ""){
			$arrMail = array(
				"campStayName"=> "campStay2"
				, "userName"=> $userName
				, "selDate"=> $selDate
				, "lastDate"=> $lastDate
				, "selDay"=> $selDay
				, "ResNumber"=> $ResNumber
				, "gubun"=>"글램핑"
				, "userPhone"=>$userPhone
				, "etc"=>$etc
				, "location"=>$location0
				, "totalPrice"=>$totalPrice3
				, "banknum"=>"신한은행 389-02-188735 이승철"
			);

			sendMail("surfcamp3@surfenjoy.com", "surfenjoy", sendMailContent($arrMail), $to, $arrMail);

			sendKakao("campStay2", "surfenjoy_res", $kakaoMsg2, $userPhone, $ResNumber, "link1", "link2", "link3");
		}

		echo '<script>alert("야영장 예약이 완료되었습니다.");parent.location.href="/ordersearch?resNumber='.$ResNumber.'";</script>';
	}
}

mysqli_close($conn);
?>
