<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$param = $_REQUEST["resparam"];
$InsUserID = $_REQUEST["userid"];

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

$intseq = "";
$intseq1 = "";
$intseq2 = "";

if($param == "changeConfirm"){ //상태 정보 업데이트
	$chkCancel = $_REQUEST["chkCancel"];
	$selConfirm = $_REQUEST["selConfirm"];
	$MainNumber = $_REQUEST["MainNumber"];
	$ResNumber = $_REQUEST["MainNumber"];

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	for($i = 0; $i < count($chkCancel); $i++){
		$arrCancel = explode("@",$chkCancel[$i]);

		$intseq .= $arrCancel[1].",";
	}
	$intseq .= '0';

	for($i = 0; $i < count($chkCancel); $i++){
		$arrCancel = explode("@",$chkCancel[$i]);

		$insdate1 = "";
		if($selConfirm[$i] == 1){
			$insdate1 = ",insdate = now()";
		}

		$select_query = "UPDATE `SURF_BUS_SUB` 
					   SET ResConfirm = ".$selConfirm[$i]."
						".$insdate1."
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE subintseq = ".$arrCancel[1].";";

		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set){
			$success = false;
			break;
		}

		if($selConfirm[$i] == 1){ //확정
			$intseq1 .= $arrCancel[1].",";
		}else if($selConfirm[$i] == 2){ //취소
			$intseq2 .= $arrCancel[1].",";
		}
	}

	$intseq1 .= '0';
	$intseq2 .= '0';
	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");

		$arrSeatInfo = array();
		$arrStopInfo = array();

		$select_query = 'SELECT userName, userPhone, userMail, Etc FROM `SURF_BUS_MAIN` WHERE MainNumber = '.$MainNumber;
		$result = mysqli_query($conn, $select_query);
		$row = mysqli_fetch_array($result);

		$userName = $row["userName"];
		$userPhone = $row["userPhone"];
		$userMail = $row["userMail"];
		$etc = $row["Etc"];

		//==========================카카오 메시지 발송 ==========================
		if($intseq1 != "0"){ //예약 확정처리 : 고객발송
			$select_query_sub = 'SELECT * FROM `SURF_BUS_SUB` where subintseq IN ('.$intseq1.') AND MainNumber = '.$MainNumber.' ORDER BY busDate, sLocation';
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

			$busSeatInfo = $busSeatInfo;
			$pointMsg = '\n  ▶ 탑승시간/위치 안내\n'.$busStopInfo.'\n';

			if($etc != ''){
				$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
			}

			$campStayName = "busConfirm1";
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 양양셔틀버스 예약확정 안내입니다.\n\n서프엔조이 양양셔틀버스 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자 : '.$userName.'\n  ▶ 좌석안내\n'.$busSeatInfo.$pointMsg.'---------------------------------\n  ▶ 안내사항\n   - 이용일, 탑승시간, 탑승위치 꼭 부탁드립니다.\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';

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
				, "SurfBBQMem"=>$SurfBBQMem
				, "SurfBBQ"=>$SurfBBQ
				, "etc"=>$etc
				, "totalPrice"=>number_format($SurfBBQPrice + $TotalPrice).'원'
				, "banknum"=>"신한은행 / 389-02-188735 / 이승철"
			);

			sendMail("surfbus2@surfenjoy.com", "surfenjoy", sendMailContentBus($arrMail), $to, $arrMail);

		}
		//==========================카카오 메시지 발송 End ==========================

		echo '0';
	}
}else if($param == "changeConfirm_tmp"){ //상태 정보 업데이트 - 이전소스
	$chkCancel = $_REQUEST["chkCancel"];
	$changeConfirm = $_REQUEST["changeConfirm"];

	$busSeq = "";
	$bbqSeq = "";
	$busMainNumber = "";
	$bbqMainNumber = "";
	$MainNumber = "";

	for($i = 0; $i < count($chkCancel); $i++){
		$arrData = explode("|",$chkCancel[$i]);
		if($arrData[0] == "bus"){
			$busSeq .= $arrData[1].",";
			if(strpos($busMainNumber, $arrData[2]) === false){
				$busMainNumber .= $arrData[2].",";
			}
		}else{
			$bbqSeq .= $arrData[1].",";
			if(strpos($bbqMainNumber, $arrData[2]) === false){
				$bbqMainNumber .= $arrData[2].",";
			}
		}

		if(strpos($MainNumber, $arrData[2]) === false){
			$MainNumber .= $arrData[2].",";
		}		
	}
	$busSeq .= '0';
	$bbqSeq .= '0';
	$busMainNumber .= '0';
	$bbqMainNumber .= '0';
	$MainNumber .= '0';

	if($success){
		$insdate1 = "";
		if($changeConfirm == 1){
			$insdate1 = ",insdate = now()";
		}

		$select_query = "UPDATE `SURF_BUS_SUB` 
					   SET ResConfirm = ".$changeConfirm."
						   ".$insdate1."
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE subintseq IN (".$busSeq.");";

		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}

	if($success){
		$select_query = "UPDATE `SURF_BBQ` 
					   SET ResBBQConfirm = ".$changeConfirm."
						   ".$insdate1."
						  ,udpdate = now()
					WHERE intseq IN (".$bbqSeq.");";

		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}

	if($success){
		$select_query = "UPDATE `SURF_BUS_MAIN` 
					   SET ResConfirm = 1
						  ,udpdate = now()
						WHERE MainNumber IN (".$MainNumber.") AND ResConfirm = 0;";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}
	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");
	$arrResOpt = array();

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");

		if($changeConfirm == 1){ //예약 확정처리

			//================ 셔틀정보 메인 & 바베큐 정보 Start ================
			$select_query = 'SELECT a.*, b.ResBBQDate, IFNULL(b.ResBBQSalePrice, 0) as ResBBQPrice, b.ResBBQ, b.ResBBQConfirm, b.intseq as bbqseq FROM `SURF_BUS_MAIN` a LEFT JOIN `SURF_BBQ` as b 
				ON a.MainNumber = b.MainNumber 
				WHERE a.MainNumber IN ('.$MainNumber.')';
			$result_setlist = mysqli_query($conn, $select_query);

			while ($row = mysqli_fetch_assoc($result_setlist)){
				$ResNumber = $row["MainNumber"];
				$userName = $row["userName"];
				$userPhone = $row["userPhone"];
				$usermail = $row["userMail"];

				$SurfBBQMem = $row["ResBBQ"];
				$SurfBBQPrice = $row["ResBBQPrice"];
				$SurfBBQ = $row["ResBBQDate"];
				$etc = $row["Etc"];
				//================ 셔틀정보 메인 & 바베큐 정보 End ================

				$busSeatInfo = "";
				$busStopInfo = "";
				$bbqMsg = '';
				$pointMsg = '';
				$arrSeatInfo = array();
				$arrStopInfo = array();

			if(strpos($busMainNumber, $ResNumber) !== false){
				$select_query_sub = 'SELECT * FROM SURF_BUS_SUB where subintseq IN ('.$busSeq.') AND MainNumber = '.$ResNumber.' ORDER BY busDate, busSeat';
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
			}

			if(strpos($bbqMainNumber, $ResNumber) !== false){
				if($SurfBBQMem > 0){
					$bbqMsg = '  ▶ 바베큐 : ['.$SurfBBQ.'] '.$SurfBBQMem.'명\n';
				}
			}

				$campStayName = "busConfirm1";
				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 양양셔틀버스 예약확정 안내입니다.\n\n서프엔조이 양양셔틀버스 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자 : '.$userName.'\n'.$busSeatInfo.$pointMsg.$bbqMsg.'---------------------------------\n  ▶ 안내사항\n   - 이용일, 탑승시간, 탑승위치 꼭 부탁드립니다. \n   - 자세한 정류장 위치는 https://actrip.co.kr/surfbus 에서 확인하세요.\n\n  ▶ 문의\n    - 010.3308.6080\n    - http://pf.kakao.com/_HxmtMxl';

				sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $ResNumber, "surfbus", "link2", "link3");

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
					, "SurfBBQMem"=>$SurfBBQMem
					, "SurfBBQ"=>$SurfBBQ
					, "etc"=>$etc
					, "totalPrice"=>number_format($SurfBBQPrice + $TotalPrice)
					, "banknum"=>"신한은행 / 389-02-188735 / 이승철"
				);

				sendMail("surfbus2@surfenjoy.com", "surfenjoy", sendMailContentBus($arrMail), $to, $arrMail);
			}
		}
		echo '0';
	}


}else if($param == "bbq"){ //바베큐 정보 업데이트
	$insdate = $_REQUEST["insdate"];
	$ResBBQConfirm = $_REQUEST["ResBBQConfirm"];
	$SurfBBQMem = $_REQUEST["ResBBQ"];
	$ResBBQDate = $_REQUEST["ResBBQDate"];
	$msgYN = $_REQUEST["msgYN"];
	$subintseq = $_REQUEST["subintseq"];
	$MainNumber = $_REQUEST["MainNumber"];

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	if($success){
		$bbqPrice = 30000;
		$bbqPriceDC = 3000;

		$ResBBQSalePrice = $SurfBBQMem * ($bbqPrice - $bbqPriceDC);
		$ResBBQDiscountPrice = $SurfBBQMem * $bbqPriceDC;
		$ResBBQPrice = $SurfBBQMem * $bbqPrice;

		$select_query = "UPDATE `SURF_BBQ` 
					   SET insdate = '".$insdate."'
						  ,ResBBQConfirm = ".$ResBBQConfirm."
						  ,ResBBQ = ".$SurfBBQMem."
						  ,ResBBQDiscountPrice = ".$ResBBQDiscountPrice."
						  ,ResBBQSalePrice = ".$ResBBQSalePrice."
						  ,ResBBQPrice = ".$ResBBQPrice."
						  ,ResBBQDate = '".$ResBBQDate."'
						  ,udpdate = now()
					WHERE intseq = ".$subintseq." AND MainNumber = '".$MainNumber."';";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");
		echo '0';
	}
}else if($param == "bus"){ //셔틀버스 정보 업데이트
	$insdate = $_REQUEST["insdate"];
	$ResConfirm = $_REQUEST["ResConfirm"];
	$userName = $_REQUEST["userName"];
	$userPhone = $_REQUEST["userPhone"];
	$userMail = $_REQUEST["userMail"];
	$busNum = $_REQUEST["busNum"];
	$busSeat = $_REQUEST["busSeat"];
	$sLocation = $_REQUEST["sLocation"];
	$eLocation = $_REQUEST["eLocation"];
	$busDate = $_REQUEST["busDate"];
	$ResPrice = $_REQUEST["ResPrice"];

	$msgYN = $_REQUEST["msgYN"];
	$subintseq = $_REQUEST["subintseq"];
	$MainNumber = $_REQUEST["MainNumber"];

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	if($success){
		$select_query = "UPDATE SURF_BUS_SUB 
					   SET insdate = '".$insdate."'
						  ,busNum = '".$busNum."'
						  ,busSeat = '".$busSeat."'
						  ,sLocation = '".$sLocation."'
						  ,eLocation = '".$eLocation."'
						  ,busDate = '".$busDate."'
						  ,ResPrice = '".$ResPrice."'
						  ,ResConfirm = ".$ResConfirm."
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE subintseq = ".$subintseq." AND MainNumber = '".$MainNumber."';";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}

	if($success){
		$select_query = "UPDATE `SURF_BUS_MAIN` 
					   SET userName = '".$userName."'
						  ,ResConfirm = 1
						  ,userPhone = '".$userPhone."'
						  ,userMail = '".$userMail."'
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE MainNumber = '".$MainNumber."';";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");
		echo '0';
	}

}

mysqli_close($conn);
?>
