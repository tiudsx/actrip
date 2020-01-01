<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$param = $_REQUEST["resparam"];
$InsUserID = $_REQUEST["userId"];

function begin(){
	mysql_query("BEGIN");
}

function rollback(){
	mysql_query("ROLLBACK");
}

function commit(){
	mysql_query("COMMIT");
}

function plusDate($date, $count) {
	$arrdate = explode("-",$date);
	$datDate = date("Y-m-d", mktime(0, 0, 0, $arrdate[1], $arrdate[2], $arrdate[0]));
	$NextDate = date("Y-m-d", strtotime($datDate." +".$count." day"));

	return $NextDate;
}

$success = true;
if($param == "BusI"){
	$ResNumber = '2'.time().substr(mt_rand(0, 99) + 100, 1, 2); //예약번호 랜덤생성

	$SurfDateBusY = $_REQUEST["hidbusDateY"]; //양양행 날짜
	$SurfDateBusS = $_REQUEST["hidbusDateS"]; //서울행 날짜
	$busNumY = $_REQUEST["hidbusNumY"]; //양양행 버스번호
	$busNumS = $_REQUEST["hidbusNumS"]; //서울행 버스번호
	$arrSeatY = $_REQUEST["hidbusSeatY"]; //양양행 좌석번호
	$arrSeatS = $_REQUEST["hidbusSeatS"]; //서울행 좌석번호
	$startLocationY = $_REQUEST["startLocationY"]; //양양행 출발 정류장
	$endLocationY = $_REQUEST["endLocationY"]; //양양행 도착 정류장
	$startLocationS = $_REQUEST["startLocationS"]; //양양행 출발 정류장
	$endLocationS = $_REQUEST["endLocationS"]; //양양행 도착 정류장
	
	$SurfBBQ = $_REQUEST["SurfBBQ"];
	$SurfBBQMem = $_REQUEST["SurfBBQMem"];

	$userName = $_REQUEST["userName"];
	$userId = $_REQUEST["userId"];
	$userPhone = $_REQUEST["userPhone1"]."-".$_REQUEST["userPhone2"]."-".$_REQUEST["userPhone3"];
	$usermail = $_REQUEST["usermail"];
	$useShop = $_REQUEST["useShop"];
	$etc = $_REQUEST["etc"];
	$datetime= date('Y/m/d H:i'); 

	$arrYDis = array();
	$arrYDisCnt = array();
	$arrSDis = array();
	$arrSDisCnt = array();

	$y = 0;
	for($i = 0; $i < count($SurfDateBusY); $i++){
		$select_query = 'SELECT sLocation FROM SURF_BUS_SUB where busDate = "'.$SurfDateBusY[$i].'" AND busNum = "'.$busNumY[$i].'" AND busSeat = "'.$arrSeatY[$i].'" AND DelUse = "N" AND ResConfirm IN (0, 1)';
		$result_setlist = mysqli_query($conn, $select_query);
		$count = mysqli_num_rows($result_setlist);

		if($count > 0){
			echo '<script>alert("['.$SurfDateBusY[$i].'] '.$arrSeatY[$i].'번 좌석은 이미 예약된 자리입니다.\n\n다른좌석을 선택해주세요.");</script>';
			return;
		}

		if($arrYDis[$SurfDateBusY[$i]] == null){
			$arrYDis[$SurfDateBusY[$i]] = 1;

			$arrYDisCnt[$y] = $SurfDateBusY[$i];
			$y++;

		}else{
			$arrYDis[$SurfDateBusY[$i]] += 1;
		}
	}

	$y = 0;
	for($i = 0; $i < count($SurfDateBusS); $i++){
		$select_query = 'SELECT sLocation FROM SURF_BUS_SUB where busDate = "'.$SurfDateBusS[$i].'" AND busNum = "'.$busNumS[$i].'" AND busSeat = "'.$arrSeatS[$i].'" AND DelUse = "N" AND ResConfirm IN (0, 1)';
		$result_setlist = mysqli_query($conn, $select_query);
		$count = mysqli_num_rows($result_setlist);

		if($count > 0){
			echo '<script>alert("['.$SurfDateBusS[$i].'] '.$arrSeatS[$i].'번 좌석은 이미 예약된 자리입니다.\n\n다른좌석을 선택해주세요.");</script>';
			return;
		}

		if($arrSDis[$SurfDateBusS[$i]] == null){
			$arrSDis[$SurfDateBusS[$i]] = 1;

			$arrSDisCnt[$y] = $SurfDateBusS[$i];
			$y++;			
		}else{
			$arrSDis[$SurfDateBusS[$i]] += 1;
		}
	}

	$arrDisCnt = array();
	$disCnt = 0;
	$totalDisCnt = 0;

	$busPrice = 20000;
	$bbqPrice = 25000;
	$bbqPriceDC = 0;

	for($i = 0; $i < count($arrYDisCnt); $i++){
		echo '<br>';
		$thisCnt = $arrYDis[$arrYDisCnt[$i]];
		if(array_key_exists($arrYDisCnt[$i], $arrSDis)){
			$nextCnt1 = $arrSDis[$arrYDisCnt[$i]];
		}else{
			$nextCnt1 = 0;
		}

		//echo '<br>arrYDis:'.$arrYDis[$arrYDisCnt[$i]];
		//echo '<br>thisCnt:'.$thisCnt;
		//echo '<br>nextCnt1:'.$nextCnt1;

		if(array_key_exists(plusDate($arrYDisCnt[$i], 1), $arrSDis)){
			$nextCnt2 = $arrSDis[plusDate($arrYDisCnt[$i], 1)];
		}else{
			$nextCnt2 = 0;
		}
		//echo '<br>nextCnt2:'.$nextCnt2;
		//echo '<br>plusDate:'.plusDate($arrYDisCnt[$i], 1);
		$nextCnt = $nextCnt1 + $nextCnt2;
		//echo '<br>thisCnt:'.$thisCnt;
		//echo '<br>nextCnt:'.$nextCnt;

		if($thisCnt >= $nextCnt){
			$disCnt = $thisCnt - ($thisCnt - $nextCnt);
		}else{
			$disCnt = $nextCnt - ($nextCnt - $thisCnt);
			if($nextCnt1 > 0){
				$arrSDis[$arrYDisCnt[$i]] -= 1;
			}else{
				$arrSDis[plusDate($arrYDisCnt[$i], 1)] -= 1;
			}
		}

		if($nextCnt2 == 0){
			$arrDisCnt[$arrYDisCnt[$i]] = $disCnt;
		}else{
			$arrDisCnt[plusDate($arrYDisCnt[$i], 1)] = $disCnt;
		}

		//echo '<br>disCnt:'.$disCnt;

		$totalDisCnt += $disCnt;
		//echo '<br>totalDisCnt:'.$totalDisCnt;
	}

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$busSeatInfo = "";
	$busStopInfo = "";
	$arrSeatInfo = array();
	$arrStopInfo = array();
	$TotalPrice = 0;
	//양양행 좌석예약
	for($i = 0; $i < count($SurfDateBusY); $i++){
		$TotalPrice += $busPrice;
		$select_query = "INSERT INTO `SURF_BUS_SUB` (`MainNumber`, `busSeat`, `sLocation`, `eLocation`, `busNum`, `busDate`, `ResPrice`, `RtnCancelPrice`, `ResConfirm`, `RtnPrice`, `RtnBank`, `DelUse`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES ('$ResNumber', '$arrSeatY[$i]', '$startLocationY[$i]', '$endLocationY[$i]', '$busNumY[$i]', '$SurfDateBusY[$i]', $busPrice, 0, 0, 0, '', 'N', '$InsUserID', '$datetime', '$InsUserID', '$datetime');";
		$result_set = mysqli_query($conn, $select_query);
		//echo $select_query.'<br>';

		if(!$result_set){
			$success = false;
			break;
		}
		if(array_key_exists($SurfDateBusY[$i].$busNumY[$i], $arrSeatInfo)){
			$arrSeatInfo[$SurfDateBusY[$i].$busNumY[$i]] .= '    - '.$arrSeatY[$i].'번 ('.$startLocationY[$i].' -> '.$endLocationY[$i].')\n';
		}else{
			$arrSeatInfo[$SurfDateBusY[$i].$busNumY[$i]] = '   ['.$SurfDateBusY[$i].'] '.fnBusNum($busNumY[$i]).'\n    - '.$arrSeatY[$i].'번 ('.$startLocationY[$i].' -> '.$endLocationY[$i].')\n';
		}

		$arrData = explode("|", fnBusPoint($startLocationY[$i], $busNumY[$i], 0));
		$arrStopInfo[$startLocationY[$i]] = '   ['.$startLocationY[$i].'] '.$arrData[0].'\n    - '.$arrData[1].'\n';
	}

	//서울행 좌석예약
	for($i = 0; $i < count($SurfDateBusS); $i++){
		$disPrice = $busPrice;
		if($arrDisCnt[$SurfDateBusS[$i]] > 0){
			$disPrice = $busPrice - 5000;
			$arrDisCnt[$SurfDateBusS[$i]] -= 1;
		}
		$TotalPrice += $disPrice;
		$select_query = "INSERT INTO `SURF_BUS_SUB` (`MainNumber`, `busSeat`, `sLocation`, `eLocation`, `busNum`, `busDate`, `ResPrice`, `RtnCancelPrice`, `ResConfirm`, `RtnPrice`, `RtnBank`, `DelUse`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES ('$ResNumber', '$arrSeatS[$i]', '$startLocationS[$i]', '$endLocationS[$i]', '$busNumS[$i]', '$SurfDateBusS[$i]', $disPrice, 0, 0, 0, '', 'N', '$InsUserID', '$datetime', '$InsUserID', '$datetime');";
		$result_set = mysqli_query($conn, $select_query);
		//echo $select_query.'<br>';

		if(!$result_set){
			$success = false;
			break;
		}

		if(array_key_exists($SurfDateBusS[$i].$busNumS[$i], $arrSeatInfo)){
			$arrSeatInfo[$SurfDateBusS[$i].$busNumS[$i]] .= '    - '.$arrSeatS[$i].'번 ('.$startLocationS[$i].' -> '.$endLocationS[$i].')\n';
		}else{
			$arrSeatInfo[$SurfDateBusS[$i].$busNumS[$i]] = '   ['.$SurfDateBusS[$i].'] '.fnBusNum($busNumS[$i]).'\n    - '.$arrSeatS[$i].'번 ('.$startLocationS[$i].' -> '.$endLocationS[$i].')\n';
		}

		$arrData = explode("|", fnBusPoint($startLocationS[$i], $busNumS[$i], 0));
		$arrStopInfo[$startLocationS[$i]] = '   ['.$startLocationS[$i].'] '.$arrData[0].'\n    - '.$arrData[1].'\n';
	}

	if($success){
		$ResBBQSalePrice = $SurfBBQMem * ($bbqPrice - $bbqPriceDC);
		$ResBBQDiscountPrice = $SurfBBQMem * $bbqPriceDC;
		$ResBBQPrice = $SurfBBQMem * $bbqPrice;

		$select_query = "INSERT INTO `SURF_BUS_MAIN` (`MainNumber`, `pkgType`, `ResConfirm`, `ResPrice`, `ResShopName`, `userID`, `userName`, `userPhone`, `userMail`, `Etc`, `DelUse`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES ('$ResNumber', 'N', 0, '$TotalPrice', '$useShop', '$userId', '$userName', '$userPhone', '$usermail', '$etc', 'N', '$InsUserID', '$datetime', '$InsUserID', '$datetime');";
		//echo $select_query.'<br>';

		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;

		if($SurfBBQMem > 0 && $success){
			$select_query = "INSERT INTO `SURF_BBQ` (`MainNumber`, `ResBBQDate`, `ResBBQDiscountPrice`, `ResBBQSalePrice`, `ResBBQPrice`, `ResBBQ`, `ResBBQConfirm`, `insdate`, `udpdate`) VALUES ('$ResNumber', '$SurfBBQ', '$ResBBQDiscountPrice', '$ResBBQSalePrice', '$ResBBQPrice', '$SurfBBQMem', 0, '$datetime', '$datetime');";
	
			$result_set = mysqli_query($conn, $select_query);
			if(!$result_set) $success = false;

/*
			$select_query = "INSERT INTO `SURF_SHOP_RES_SUB` (`MainNumber`, `ResDate`, `ResTime`, `ResDay`, `ResPrice`, `ResPriceEA`, `ResOptSeq`, `ResOptName`, `ResNumM`, `ResNumW`, `ResConfirm`, `ResGubun`, `RtnPrice`, `RtnBank`, `DelUse`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES ('$ResNumber', '$resDate[$i]', '$resTime[$i]', '$optPkg', '$sumPrice', '$eaPrice', '$resSeq[$i]', '$optName', '$resM[$i]', '$resW[$i]', '0', '$resGubun[$i]', '0', NULL, 'N', 'admin', '$datetime', 'admin', '$datetime');";

			$result_set = mysqli_query($conn, $select_query);
			if(!$result_set) $success = false;

			if($success){
				$TimeDate = "";
				if($resGubun[$i] == 0 || $resGubun[$i] == 2){
					$TimeDate = '('.$resTime[$i].')';
				}else if($resGubun[$i] == 3){
					$TimeDate = '('.$resDay[$i].')';
				}

				$ResNum = "";
				if($resM[$i] > 0){
					$ResNum = "남:".$resM[$i].'명 ';
				}

				if($resW[$i] > 0){
					$ResNum .= "여:".$resW[$i].'명';
				}

				$surfshopMsg .= '    -  ['.$resDate[$i].'] '.$optName.$TimeDate.' / '.$ResNum.'\n';
				if($resGubun[$i] == 2){
					$surfshopMsg .= '         ('.preg_replace('/\s+/', '', $optPkg).')\n';
				}

				$select_query = "INSERT INTO `SURF_SHOP_RES_MAIN` (`MainNumber`, `Gubun`, `shopSeq`, `shopCode`, `userID`, `userName`, `userPhone`, `userMail`, `Etc`, `ResConfirm`, `ResTotalPrice`, `DelUse`, `ResCount`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES ('$ResNumber', '$groupcode', '$shopseq', '$shopname', '$userId', '$userName', '$userPhone', '$usermail', '$etc', '0', '$totalPrice', 'N', '$resCnt',  'admin', '$datetime', 'admin', '$datetime');";
				$result_set = mysqli_query($conn, $select_query);
				//echo $select_query.'<br>';

				if(!$result_set) $success = false;
			}
*/
		}
	}

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo '<script>alert("예약진행 중 오류가 발생하였습니다.\n\n관리자에게 문의해주세요.");</script>';
	}else{
		mysqli_query($conn, "COMMIT");

		foreach($arrSeatInfo as $x) {
			$busSeatInfo .= $x;
		}

		foreach($arrStopInfo as $x) {
			$busStopInfo .= $x;
		}

		$bbqMsg = '';
		if($SurfBBQMem > 0){
			$bbqMsg .= '  ▶ 바베큐 : ['.$SurfBBQ.'] '.$SurfBBQMem.'명\n';
		}

		$bbqMsg .= '  ▶ 총 합계 : '.number_format($SurfBBQPrice + $TotalPrice).'원\n';

		if($etc != ''){
			$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
		}

		$pointMsg .= '\n  ▶ 탑승시간/위치 안내\n'.$busStopInfo.'\n';

		$campStayName = "busStay1";
		$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 양양셔틀버스 입금대기 안내입니다.\n\n서프엔조이 양양셔틀버스 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 좌석안내\n'.$busSeatInfo.$pointMsg.$bbqMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n    - 1시간 이내 미입금시 자동취소됩니다.\n\n  ▶입금계좌\n    - 신한은행 389-02-188735 이승철\n\n  ▶ 문의\n    - http://pf.kakao.com/_HxmtMxl';

		sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $ResNumber, "surfbus", "link2", "link3");

		$to = "lud1@naver.com,ttenill@naver.com";
		if(strrpos($usermail, "@") > 0){
			$to .= ','.$usermail;
		}

		$arrMail = array(
			"campStayName"=> "busStay1"
			, "userName"=> $userName
			, "busSeatInfo"=> str_replace('\n', '<br>', $busSeatInfo)
			, "busStopInfo"=> str_replace('\n', '<br>', $busStopInfo)
			, "ResNumber"=> $ResNumber
			, "gubun"=>"양양셔틀버스"
			, "userPhone"=>$userPhone
			, "SurfBBQMem"=>$SurfBBQMem
			, "SurfBBQ"=>$SurfBBQ
			, "etc"=>$etc
			, "totalPrice"=>number_format($SurfBBQPrice + $TotalPrice).'원'
			, "banknum"=>"신한은행 / 389-02-188735 / 이승철"
		);

		sendMail("surfbus1@surfenjoy.com", "surfenjoy", sendMailContentBus($arrMail), $to, $arrMail);

		echo '<script>alert("양양 셔틀버스 예약이 완료되었습니다.");parent.location.href="/ordersearch?resNumber='.$ResNumber.'";</script>';
	}


}else if($param == "Cancel"){ //일괄 취소
	//======== 환불 요청
	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$chkCancel = $_REQUEST["chkCancel"];
	$bankName = $_REQUEST["bankName"];
	$bankUserName = $_REQUEST["bankUserName"];
	$bankNum = $_REQUEST["bankNum"];
	$hidtotalPrice = $_REQUEST["hidtotalPrice"];

	$busSeq = "";
	$bbqSeq = "";
	$MainNumber = "";
	$ResConfirm = "";

	for($i = 0; $i < count($chkCancel); $i++){
		$arrData = explode("|",$chkCancel[$i]);
		if($arrData[0] == "bus"){
			$busSeq .= $arrData[1].",";
		}else{
			$bbqSeq .= $arrData[1].",";
		}

		$MainNumber = $arrData[2];
		$userName = $arrData[3];
	}
	$busSeq .= '0';
	$bbqSeq .= '0';

	$TotalPrice = 0; //총 이용금액
	$cancelTotalPrice = 0; //환불수수료
	$rtntotalPrice = 0; //환불금액

	if($InsUserID == ""){
		$InsUserID = $userName;
	}


	$select_query = 'SELECT a.*, b.ResBBQDate, IFNULL(b.ResBBQSalePrice, 0) as ResBBQPrice, b.ResBBQ, b.ResBBQConfirm, b.intseq as bbqseq FROM `SURF_BUS_MAIN` a LEFT JOIN `SURF_BBQ` as b 
		ON a.MainNumber = b.MainNumber
			AND ResBBQConfirm = 1
		WHERE a.MainNumber = '.$MainNumber;
	$result_setlist = mysqli_query($conn, $select_query);
	$row = mysqli_fetch_array($result_setlist);

	$ResNumber = $row["MainNumber"];
	$userName = $row["userName"];
	$etc = $row["Rtc"];
	$userPhone = $row["userPhone"];
	$usermail = $row["userMail"];

	$SurfBBQMem = $row["ResBBQ"];
	$SurfBBQPrice = 0;
	$SurfBBQ = $row["ResBBQDate"];
	$etc = $row["Etc"];

	$chkBbqCnt = $row["ResBBQPrice"]; //바베큐 카운트

	$FullBankText = $bankName."|".$bankNum."|".$bankUserName;

	if($chkBbqCnt > 0){
		$bbqCancelPrice = cancelPrice($row['ResBBQDate'], $row['insdate'], $row['ResBBQPrice'], 2, $row['ResBBQConfirm']);
		$bbqRtnPrice = $row['ResBBQPrice'] - $bbqCancelPrice;

		$TotalPrice += $row['ResBBQPrice'];
		$cancelTotalPrice += $bbqCancelPrice;

		if($success){
			$select_query = "UPDATE `SURF_BBQ` 
						   SET ResBBQConfirm = CASE ResBBQConfirm
													WHEN 0 THEN 3
													WHEN 1 THEN 2
												END
							,RtnCancelPrice = ".$bbqCancelPrice."
							,RtnPrice = ".$bbqRtnPrice."
							,RtnBank = '".$FullBankText."'
							,udpdate = now()
						WHERE intseq IN (".$bbqSeq.");";
			$result_set = mysqli_query($conn, $select_query);
			if(!$result_set) $success = false;
		}
	}
	//================ 셔틀정보 메인 & 바베큐 정보 End ================

	$busSeatInfo = "";
	$busStopInfo = "";
	$bbqMsg = '';
	$arrSeatInfo = array();

	$select_query_sub = 'SELECT * FROM SURF_BUS_SUB where subintseq IN ('.$busSeq.') AND MainNumber = '.$ResNumber.' AND ResConfirm = 1 ORDER BY busDate, busSeat';
	$resultSite = mysqli_query($conn, $select_query_sub);
	$chkSubCnt = mysqli_num_rows($resultSite); //버스 좌석 카운트

	if($chkSubCnt > 0){
		while ($rowSub = mysqli_fetch_assoc($resultSite)){
			if(array_key_exists($rowSub['busDate'].$rowSub['busNum'], $arrSeatInfo)){
				$arrSeatInfo[$rowSub['busDate'].$rowSub['busNum']] .= '    - '.$rowSub['busSeat'].'번\n';
			}else{
				$arrSeatInfo[$rowSub['busDate'].$rowSub['busNum']] = '   ['.$rowSub['busDate'].'] '.fnBusNum($rowSub['busNum']).'\n    - '.$rowSub['busSeat'].'번\n';
			}

			$busCancelPrice = cancelPrice($rowSub['busDate'], $rowSub['insdate'], $rowSub['ResPrice'], 2, $rowSub['ResConfirm']);
			$busRtnPrice = $rowSub['ResPrice'] - $busCancelPrice;

			$TotalPrice += $rowSub['ResPrice'];
			$cancelTotalPrice += $busCancelPrice;

			if($success){
				$select_query = "UPDATE `SURF_BUS_SUB` 
							   SET ResConfirm = CASE ResConfirm
													WHEN 0 THEN 3
													WHEN 1 THEN 2
												END
								,RtnCancelPrice = ".$busCancelPrice."
								,RtnPrice = ".$busRtnPrice."
								,RtnBank = '".$FullBankText."'
								,udpdate = now()
								,udpuserid = '".$InsUserID."'
							WHERE subintseq = ".$rowSub['subintseq'].";";
				$result_set = mysqli_query($conn, $select_query);
				if(!$result_set) $success = false;
			}
		}

		foreach($arrSeatInfo as $x) {
			$busSeatInfo .= $x;
		}

		$busSeatInfo = '  ▶ 취소 좌석안내\n'.$busSeatInfo;
	}

	if($chkBbqCnt > 0){
		$SurfBBQPrice = $row["ResBBQPrice"];
		$bbqMsg = '  ▶ 바베큐 취소\n   ['.$SurfBBQ.'] '.$SurfBBQMem.'명\n';
	}

	$cancelPrice = '  ▶ 환불금액 안내\n   - 총 이용금액 : '.number_format($TotalPrice).'원\n   - 환불수수료 : '.number_format($cancelTotalPrice).'원\n   - 환불금액 : '.number_format($TotalPrice-$cancelTotalPrice).'원\n';

	$rtnBank = '\n   -';
	if($bankName != ''){
		$rtnBank = '\n   - 환불계좌 : '.$bankName.' / '.$bankNum.' / '.$bankUserName;
	}

	//================ 취소/환불요청 정보 업데이트 ================
	if($success && $busSeq != '0'){
		$select_query = "UPDATE `SURF_BUS_SUB` 
					   SET ResConfirm = 3
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE subintseq IN (".$busSeq.") AND ResConfirm = 0;";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}


	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");

		if($chkSubCnt > 0 && $chkBbqCnt > 0){
			$campStayName = "busCancel1";
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 양양셔틀버스 취소/환불요청 안내입니다.\n\n서프엔조이 취소/환불 정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자 : '.$userName.'\n'.$busSeatInfo.$bbqMsg.$cancelPrice.'---------------------------------\n  ▶ 안내사항'.$rtnBank.'\n\n  ▶ 문의\n    - 010.3308.6080\n    - http://pf.kakao.com/_HxmtMxl';

			sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $ResNumber, "surfbus", "link2", "link3");

			$to = "lud1@naver.com,ttenill@naver.com";
			if(strrpos($usermail, "@") > 0){
				$to .= ','.$usermail;
			}

			$arrMail = array(
				"campStayName"=> "busCancel1"
				, "userName"=> $userName
				, "busSeatInfo"=> str_replace('\n', '<br>', $busSeatInfo)
				, "busStopInfo"=> str_replace('\n', '<br>', $busStopInfo)
				, "ResNumber"=> $ResNumber
				, "gubun"=>"양양셔틀버스"
				, "userPhone"=>$userPhone
				, "SurfBBQMem"=>$SurfBBQMem
				, "SurfBBQ"=>$SurfBBQ
				, "etc"=>$etc
				, "banknum"=>$bankName.' / '.$bankNum.' / '.$bankUserName
				, "totalPrice"=>'총 이용금액 : '.number_format($TotalPrice).'원<br>환불수수료 : '.number_format($cancelTotalPrice).'원<br>환불금액 : '.number_format($TotalPrice-$cancelTotalPrice).'원'
			);

			sendMail("surfcancel@surfenjoy.com", "surfenjoy", sendMailContentBus($arrMail), $to, $arrMail);
		}

		echo '0';
	}
}else if($param == "Return"){ //환불요청

}

mysqli_close($conn);
?>
