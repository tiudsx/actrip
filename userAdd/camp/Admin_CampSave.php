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

function encrypt($plaintext){
	$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);

	$ciphertext = $iv . $ciphertext;
	$ciphertext_base64 = base64_encode($ciphertext);

	return $ciphertext_base64;
}


$success = true;

$chkCancel = $_REQUEST["chkCancel"];
$selConfirm = $_REQUEST["selConfirm"];
$MainNumber = $_REQUEST["MainNumber"];

$intseq = "";
$intseq1 = "";
$intseq2 = "";

if($param == "AdminShower"){ //샤워쿠폰 발급
	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$select_query = "UPDATE SURF_CAMPING_MAIN 
					   SET ResShower = 1
						  ,udpdate = now()
						  ,udpuserid = 'Shower'
					WHERE intseq = ".$_REQUEST["intSeq"].";";
	$result_set = mysqli_query($conn, $select_query);

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");
		echo '0';
	}

}else if($param == "changeConfirm"){ //상태 정보 업데이트 : 관리자
	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$Gubun = $_REQUEST["Gubun"];

	for($i = 0; $i < count($chkCancel); $i++){
		$intseq .= $chkCancel[$i].",";
	}
	$intseq .= '0';

//================= 예약상태 및 메모 저장 =================
	for($i = 0; $i < count($chkCancel); $i++){
		$insdate1 = "";
		if($selConfirm[$i] == 1){
			$insdate1 = ",insdate = now()";
		}

		$select_query = "UPDATE SURF_CAMPING_SUB 
					   SET ResConfirm = ".$selConfirm[$i]."
						".$insdate1."
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE subintseq = ".$chkCancel[$i].";";

		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set){
			$success = false;
			break;
		}

		if($selConfirm[$i] == 1){ //확정
			$intseq1 .= $chkCancel[$i].",";
		}else if($selConfirm[$i] == 2){ //취소
			$intseq2 .= $chkCancel[$i].",";
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

		$select_query = 'SELECT userName, userPhone, userMail, Etc, sDate, eDate, stay FROM `SURF_CAMPING_MAIN` WHERE MainNumber = '.$MainNumber;
		$result = mysqli_query($conn, $select_query);
		$row = mysqli_fetch_array($result);

		$userName = $row["userName"];
		$userPhone = $row["userPhone"];
		$userMail = $row["userMail"];
		$etc = $row["Etc"];
		$selDay = $row["stay"];

		//==========================카카오 메시지 발송 ==========================
		if($intseq1 != "0"){ //예약 확정처리 : 고객발송
			$i = 0;
			$select_query_sub = 'SELECT * FROM `SURF_CAMPING_SUB` where subintseq IN ('.$intseq1.') AND MainNumber = '.$MainNumber.' ORDER BY sDate, sLocation';
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
					$coupon = "   - [이벤트] 7월 12일 ~ 8월 25일까지 이용시 1박당 샤워쿠폰 2매드립니다. 관리실에 문의주세요.\n";
				}

				$i++;
			}
			$lastDate = date("Y-m-d", strtotime($sDate." +1 day"));

			$totalPrice2 = number_format($totalPriceRtn2).'원';

			if($etc != ''){
				$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
			}

			$campStayName = "campOk1";
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 확정완료 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 입실 : '.$selDate.' 오후 2시부터\n  ▶ 퇴실 : '.$lastDate.' 오후 12시까지\n  ▶ 예약위치 : \n'.$location2.'\n'.$etcMsg.'---------------------------------\n  ▶안내사항\n'.$coupon.'   - 야영장 이용시 애견동반금지\n   - 전기사용시 15m이상 릴선이 필요합니다.\n   - 23시 이후로는 주변에 피해가 안가도록 대화소리를 작게 해주세요.\n\n  ▶문의\n   - '.sendTel('이준영2').'\n   - http://pf.kakao.com/_HxmtMxl';

			sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $MainNumber, "campres", "link2", "link3");

			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 확정완료 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 예약위치 : \n'.$location2.'\n'.$etcMsg.'---------------------------------\n  ▶안내사항\n   - 확정예약 완료되었습니다.';

			//sendKakao('campshop1', "surfenjoy_shop", $kakaoMsg1, sendTel('이준영'), urlencode(encrypt(date("Y-m-d").'|'.$MainNumber)), "campadminkakao", "link2", "link3");
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

		}
		//==========================카카오 메시지 발송 End ==========================

		echo '0';
	}


}else if($param == "adminmodify"){ //건당 정보 업데이트
	$insdate = $_REQUEST["insdate"];
	$ResConfirm = $_REQUEST["ResConfirm"];
	$userName = $_REQUEST["userName"];
	$userPhone = $_REQUEST["userPhone"];
	$userMail = $_REQUEST["userMail"];
	$chkOpt = $_REQUEST["chkOpt"];
	$sDate = $_REQUEST["resDate"];
	$sLocation = $_REQUEST["sLocation"];

	$subintseq = $_REQUEST["subintseq"];
	$MainNumber = $_REQUEST["MainNumber"];

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	if($success){
		if($chkOpt == "1"){
			$chkOpt = "1@전기@5000";
		}else{
			$chkOpt = "";
		}

		$select_query = "UPDATE `SURF_CAMPING_SUB` 
					   SET insdate = '".$insdate."'
						  ,sLocation = '".$sLocation."'
						  ,sDate = '".$sDate."'
						  ,ResOptPrice = '".$chkOpt."'
						  ,ResConfirm = ".$ResConfirm."
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE subintseq = ".$subintseq." AND MainNumber = '".$MainNumber."';";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}

	if($success){
		$select_query = "UPDATE `SURF_CAMPING_MAIN` 
					   SET userName = '".$userName."'
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
