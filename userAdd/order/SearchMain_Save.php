<?php 
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

include __DIR__.'/../surfencrypt.php';

$param = $_REQUEST["resparam"];
$gubun = $_REQUEST["gubun"];

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

if($param == "RtnPrice"){
	$subintseq = str_replace("'", "",$_REQUEST["subintseq"]);

	if($gubun == "camp"){
		$select_table = 'SURF_CAMPING_SUB';
	}else if($gubun == "surf"){
		$select_table = 'SURF_SHOP_RES_SUB';
	}

	$select_query_sub = 'SELECT *, TIMESTAMPDIFF(MINUTE, insdate, now()) as timeM FROM '.$select_table.' where subintseq IN ('.$subintseq.')';

	$resultSite = mysqli_query($conn, $select_query_sub);
	$count = mysqli_num_rows($resultSite);

	if($count == 0){
		echo 'err';
		exit;
	}
/*
예약구분
-----------
0	미입금
1	확정
2	취소
3	환불요청
4	환불완료
*/

	$now = date("Y-m-d");
	$totalPrice = 0;
	$totalFee = 0;
	$totalOpt = 0;
	while ($rowSub = mysqli_fetch_assoc($resultSite)){

		$arrOpt = 0;
		$boolConfirm = false;
		if($gubun == "camp"){
			$ResConfirm = $rowSub['ResConfirm'];
			$ResPrice = $rowSub['ResPrice'];

			if(!($ResConfirm == "0" || $ResConfirm == "1")){
				echo 'err';
				exit;
			}
			$sDate = $rowSub['sDate'];
			$arrOpt = explode("@",$rowSub['ResOptPrice'])[2];
			
			if($ResConfirm == "1"){
				$boolConfirm = true;
			}

		}else if($gubun == "surf"){
			$ResConfirm = $rowSub['ResConfirm'];
			$ResPrice = $rowSub['ResPrice'];

			if(!($ResConfirm == "0" || $ResConfirm == "2" || $ResConfirm == "3" || $ResConfirm == "4" || $ResConfirm == "5")){
				echo 'err';
				exit;
			}
			$sDate = $rowSub['ResDate'];
			
			if($ResConfirm == "2" || $ResConfirm == "3" || $ResConfirm == "4" || $ResConfirm == "5"){
				$boolConfirm = true;
			}
		}
		
		$rtnFee = cancelPrice($sDate, $rowSub['timeM'], $ResConfirm, $ResPrice);

		if($boolConfirm){
			$totalPrice += $ResPrice;
			$totalFee += $rtnFee;
			$totalOpt += $arrOpt;
		}
	}


	$totalPrice = $totalPrice + $totalOpt;

	echo $totalPrice."|".$totalFee."|".($totalPrice - $totalFee);

}else if($param == "RtnPrice2"){
	$subintseq = str_replace("'", "",$_REQUEST["subintseq"]);
	$arrSeq = explode(",",$subintseq);

	$now = date("Y-m-d");
	$totalPrice = 0;
	$totalFee = 0;
	$totalOpt = 0;
	for($i=0;$i<count($arrSeq);$i++) {
		$arrGubun = explode("@", $arrSeq[$i]);
		$gubun = $arrGubun[0];
		$subintseq = $arrGubun[1];

		if($gubun == "bus"){
			$select_table = 'SURF_BUS_SUB';
		}else if($gubun == "bbq"){
			$select_table = 'SURF_BBQ';
		}

		if($gubun == "bbq"){
			$select_query_sub = 'SELECT *, TIMESTAMPDIFF(MINUTE, insdate, now()) as timeM FROM '.$select_table.' where intseq IN ('.$subintseq.')';
		}else{
			$select_query_sub = 'SELECT *, TIMESTAMPDIFF(MINUTE, insdate, now()) as timeM FROM '.$select_table.' where subintseq IN ('.$subintseq.')';
		}

		$resultSite = mysqli_query($conn, $select_query_sub);
		$count = mysqli_num_rows($resultSite);

		if($count == 0){
			echo $arrSeq[i];
			exit;
		}

		while ($rowSub = mysqli_fetch_assoc($resultSite)){

			$arrOpt = 0;
			$boolConfirm = false;
			if($gubun == "bus"){
				$ResConfirm = $rowSub['ResConfirm'];
				$ResPrice = $rowSub['ResPrice'];

				if(!($ResConfirm == "0" || $ResConfirm == "1")){
					echo 'err';
					exit;
				}
				$sDate = $rowSub['busDate'];
				
				if($ResConfirm == "1"){
					$boolConfirm = true;
				}
			}else if($gubun == "bbq"){
				$ResConfirm = $rowSub['ResBBQConfirm'];
				$ResPrice = $rowSub['ResBBQSalePrice'];

				if(!($ResConfirm == "0" || $ResConfirm == "1")){
					echo 'err';
					exit;
				}
				$sDate = $rowSub['ResBBQDate'];
				
				if($rowSub['ResBBQConfirm'] == "1"){
					$boolConfirm = true;
				}
			}
			
			$rtnFee = cancelPrice($sDate, $rowSub['timeM'], $ResConfirm, $ResPrice);

			if($boolConfirm){
				$totalPrice += $ResPrice;
				$totalFee += $rtnFee;
				$totalOpt += $arrOpt;
			}
		}

		$totalPrice = $totalPrice + $totalOpt;
	}

	echo $totalPrice."|".$totalFee."|".($totalPrice - $totalFee);

}else if($param == "Cancel"){  //환불 및 취소
	$chkCancel = $_REQUEST["chkCancel"];
	$bankName = $_REQUEST["bankName"];
	$bankNum = $_REQUEST["bankNum"];
	$MainNumber = $_REQUEST["MainNumber"];
	$InsUserID = $_REQUEST["userId"];

	if($gubun == "bus" || $gubun == "bbq"){
		//셔틀버스 + 바베큐 환불 및 취소 로직
		for($i = 0; $i < count($chkCancel); $i++){
			$arrCancel = explode("@",$chkCancel[$i]);

			$subintSeq .= $arrCancel[1].",";
		}
		$subintSeq .= '0';

		$select_table = 'SURF_BUS_MAIN';
		$select_tablesub = 'SURF_BUS_SUB';

		$select_query = 'SELECT * FROM '.$select_table.' WHERE MainNumber = '.$MainNumber;

		$result_setlist = mysqli_query($conn, $select_query);
		$row = mysqli_fetch_array($result_setlist);

		$ResNumber = $row["MainNumber"];
		$userName = $row["userName"];
		$userPhone = $row["userPhone"];
		$usermail = $row["userMail"];
		$etc = $row["Etc"];

		if($InsUserID == ""){
			$InsUserID = $userName;
		}

		$FullBankText = "";
		if($bankNum != ""){
			$FullBankText = $bankName."|".$bankNum."|".$userName;
		}

		$arrSeatInfo = array();
		$select_query_sub = 'SELECT *, TIMESTAMPDIFF(MINUTE, insdate, now()) as timeM FROM '.$select_tablesub.' where subintseq IN ('.$subintSeq.') AND MainNumber = '.$ResNumber;
		$resultSite = mysqli_query($conn, $select_query_sub);
		$chkSubCnt = mysqli_num_rows($resultSite); //체크 개수

		if($chkSubCnt == 0){
			echo 'err';
			exit;
		}

		mysqli_query($conn, "SET AUTOCOMMIT=0");
		mysqli_query($conn, "BEGIN");

		$TotalPrice = 0;
		$TotalFee = 0;
		$TotalOpt = 0;
		$arrSeatInfo = array();
		while ($rowSub = mysqli_fetch_assoc($resultSite)){
			if($success){
				$arrOpt = 0;
				$boolConfirm = false;
				
				$sDate = $rowSub['busDate'];
				$confirm0 = 2; //취소
				$confirm1 = 3; //환불요청
				
				if($rowSub['ResConfirm'] == "1"){
					$boolConfirm = true;
				}

				if($rowSub['ResConfirm'] == "0"){ //미입금 상태 취소
					$select_query = "UPDATE ".$select_tablesub." 
								   SET ResConfirm = ".$confirm0."
									,udpdate = now()
									,udpuserid = '".$InsUserID."'
								WHERE subintseq = ".$rowSub['subintseq'].";";
					$result_set = mysqli_query($conn, $select_query);
					if(!$result_set) $success = false;
				}else if($boolConfirm){ //확정 상태 환불요청
					$rtnFee = cancelPrice($sDate, $rowSub['timeM'], $rowSub['ResConfirm'], $rowSub['ResPrice']);

					$select_query = "UPDATE ".$select_tablesub."  
								   SET ResConfirm = ".$confirm1."
									,RtnTotalPrice = ".($rowSub['ResPrice'] + $arrOpt)."
									,RtnPrice = ".$rtnFee."
									,RtnSumPrice = ".(($rowSub['ResPrice'] + $arrOpt) - $rtnFee)."
									,RtnBank = '".$FullBankText."'
									,udpdate = now()
									,udpuserid = '".$InsUserID."'
								WHERE subintseq = ".$rowSub['subintseq'].";";

					$result_set = mysqli_query($conn, $select_query);
					if(!$result_set) $success = false;
					
					$subintSeqInfo .= $rowSub['subintseq'].",";

					$TotalPrice +=($rowSub['ResPrice'] + $arrOpt);
					$TotalFee +=$rtnFee;

					if(array_key_exists($rowSub['busDate'].$rowSub['busNum'], $arrSeatInfo)){
						$arrSeatInfo[$rowSub['busDate'].$rowSub['busNum']] .= '    - '.$rowSub['busSeat'].'번 ('.$rowSub['sLocation'].' -> '.$rowSub['eLocation'].')\n';
					}else{
						$arrSeatInfo[$rowSub['busDate'].$rowSub['busNum']] = '   ['.$rowSub['busDate'].'] '.fnBusNum($rowSub['busNum']).'\n    - '.$rowSub['busSeat'].'번 ('.$rowSub['sLocation'].' -> '.$rowSub['eLocation'].')\n';
					}
				}else{
					$success = false;
				}
			}
		}

		
		$rtnText = '  ▶ 환불요청 안내\n       - 결제금액 : '.number_format($TotalPrice).'원\n       - 환불수수료 : '.number_format($TotalFee).'원\n       - 환불금액 : '.number_format($TotalPrice-$TotalFee).'원\n  ▶환불계좌\n       - '.str_replace('|', ' / ', $FullBankText).'\n';

		if(!$success){
			mysqli_query($conn, "ROLLBACK");
			echo 'err';
		}else{
			mysqli_query($conn, "COMMIT");

			if($subintSeqInfo != ""){
				foreach($arrSeatInfo as $x) {
					$busSeatInfo .= $x;
				}

				$to = "lud1@naver.com";
				if(strrpos($usermail, "@") > 0){
					$to .= ','.$usermail;
				}

				//카카오톡, 메일 고객 발송
				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 양양셔틀버스 환불요청 안내입니다.\n\n서프엔조이 양양셔틀버스 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 취소좌석 : \n'.$busSeatInfo.$rtnText.'---------------------------------\n  ▶안내사항\n    - 환불처리기간은 1~7일정도 소요됩니다.\n\n  ▶문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';
				sendKakao("busCancel1", "surfenjoy_res1", $kakaoMsg1, $userPhone, $ResNumber, "link1", "link2", "link3");

				$arrMail = array(
					"campStayName"=> "busCancel1"
					, "userName"=> $userName
					, "surfInfo"=> str_replace('\n', '<br>', $busSeatInfo)
					, "ResNumber"=> $MainNumber
					, "gubun"=>$shopcode
					, "userPhone"=>$userPhone
					, "totalPrice"=>number_format($TotalPrice-$TotalFee).'원'
					, "banknum"=> str_replace('|', ' / ', $FullBankText)
					, "etc"=>$etc
				);
				sendMail("surfshop3@surfenjoy.com", "surfenjoy", sendMailContentSurf($arrMail), $to, $arrMail);
			}

			echo '0';
		}
	}else{
		for($i = 0; $i < count($chkCancel); $i++){
			$subintSeq .= $chkCancel[$i].",";
		}
		$subintSeq .= '0';

		if($gubun == "camp"){
			$select_table = 'SURF_CAMPING_MAIN';
			$select_tablesub = 'SURF_CAMPING_SUB';
		}else if($gubun == "surf"){
			$select_table = 'SURF_SHOP_RES_MAIN as a INNER JOIN SURF_SHOP as b ON a.shopSeq = b.intseq';
			$select_tablesub = 'SURF_SHOP_RES_SUB';
		}
		$select_query = 'SELECT * FROM '.$select_table.' WHERE MainNumber = '.$MainNumber;

		$result_setlist = mysqli_query($conn, $select_query);
		$row = mysqli_fetch_array($result_setlist);

		$ResNumber = $row["MainNumber"];
		$userName = $row["userName"];
		$userPhone = $row["userPhone"];
		$usermail = $row["userMail"];
		$etc = $row["Etc"];

		if($gubun == "surf"){
			$shopcode = $row["shopCode"];
			$opt_bbq = $row["opt_bbq"];
		}

		if($InsUserID == ""){
			$InsUserID = $userName;
		}

		$FullBankText = "";
		if($bankNum != ""){
			$FullBankText = $bankName."|".$bankNum."|".$userName;
		}

		$arrSeatInfo = array();
		$select_query_sub = 'SELECT *, TIMESTAMPDIFF(MINUTE, insdate, now()) as timeM FROM '.$select_tablesub.' where subintseq IN ('.$subintSeq.') AND MainNumber = '.$ResNumber;
		$resultSite = mysqli_query($conn, $select_query_sub);
		$chkSubCnt = mysqli_num_rows($resultSite); //체크 개수

		if($chkSubCnt == 0){
			echo 'err';
			exit;
		}

		mysqli_query($conn, "SET AUTOCOMMIT=0");
		mysqli_query($conn, "BEGIN");

		$TotalPrice = 0;
		$TotalFee = 0;
		$TotalOpt = 0;
		while ($rowSub = mysqli_fetch_assoc($resultSite)){
			if($success){

				$arrOpt = 0;
				$boolConfirm = false;
				if($gubun == "camp"){
					$arrOpt = explode("@",$rowSub['ResOptPrice'])[2];
					$sDate = $rowSub['sDate'];
					$confirm0 = 2;
					$confirm1 = 3;

					if($rowSub['ResConfirm'] == "1"){
						$boolConfirm = true;
					}
				}else if($gubun == "surf"){
					$select_tablesub = 'SURF_SHOP_RES_SUB';
					$sDate = $rowSub['ResDate'];
					$confirm0 = 1;
					$confirm1 = 6;
					
					if($rowSub['ResConfirm'] == "2" || $rowSub['ResConfirm'] == "3" || $rowSub['ResConfirm'] == "4" || $rowSub['ResConfirm'] == "5"){
						$boolConfirm = true;
					}
				}

				if($rowSub['ResConfirm'] == "0"){ //미입금 상태 취소
					$select_query = "UPDATE ".$select_tablesub." 
								   SET ResConfirm = ".$confirm0."
									,udpdate = now()
									,udpuserid = '".$InsUserID."'
								WHERE subintseq = ".$rowSub['subintseq'].";";
					$result_set = mysqli_query($conn, $select_query);
					if(!$result_set) $success = false;
				}else if($boolConfirm){ //확정 상태 환불요청
					$rtnFee = cancelPrice($sDate, $rowSub['timeM'], $rowSub['ResConfirm'], $rowSub['ResPrice']);

					$select_query = "UPDATE ".$select_tablesub."  
								   SET ResConfirm = ".$confirm1."
									,RtnTotalPrice = ".($rowSub['ResPrice'] + $arrOpt)."
									,RtnPrice = ".$rtnFee."
									,RtnSumPrice = ".(($rowSub['ResPrice'] + $arrOpt) - $rtnFee)."
									,RtnBank = '".$FullBankText."'
									,udpdate = now()
									,udpuserid = '".$InsUserID."'
								WHERE subintseq = ".$rowSub['subintseq'].";";

					$result_set = mysqli_query($conn, $select_query);
					if(!$result_set) $success = false;
					
					$subintSeqInfo .= $rowSub['subintseq'].",";

					$TotalPrice +=($rowSub['ResPrice'] + $arrOpt);
					$TotalFee +=$rtnFee;

					$locationOpt2 = "";
					if($arrOpt > 0){
						$locationOpt2 = "(전기)";
					}

					if($gubun == "camp"){
						$location2 .= "       - [".$sDate."] ".$rowSub['sLocation'].$locationOpt2."\n";
					}else if($gubun == "surf"){
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

						$surfMsg .= '    -  ['.$sDate.'] '.$rowSub["ResOptName"].$TimeDate.' / '.$ResNum.'\n';
						if($rowSub["ResGubun"] == 2){
							$surfMsg .= '         ('.preg_replace('/\s+/', '', $rowSub["ResDay"]).')\n';
						}

						if(!($opt_bbq == "Y" && $rowSub["ResGubun"] == 4)){
							$surfshopMsg .= '    -  ['.$sDate.'] '.$rowSub["ResOptName"].$TimeDate.' / '.$ResNum.'\n';
							if($rowSub["ResGubun"] == 2){
								$surfshopMsg .= '         ('.preg_replace('/\s+/', '', $rowSub["ResDay"]).')\n';
							}
						}
					}
				}else{
					$success = false;
				}
			}
		}

		
		$rtnText = '  ▶ 환불요청 안내\n       - 결제금액 : '.number_format($TotalPrice).'원\n       - 환불수수료 : '.number_format($TotalFee).'원\n       - 환불금액 : '.number_format($TotalPrice-$TotalFee).'원\n  ▶환불계좌\n       - '.str_replace('|', ' / ', $FullBankText).'\n';

		if(!$success){
			mysqli_query($conn, "ROLLBACK");
			echo 'err';
		}else{
			mysqli_query($conn, "COMMIT");

			if($subintSeqInfo != ""){
				$to = "lud1@naver.com";
				if(strrpos($usermail, "@") > 0){
					$to .= ','.$usermail;
				}

				//카카오톡, 메일 고객 발송
				if($gubun == "camp"){
					$campStayName = "campCancel1";
					$kakaoLink1 = "campres";
					$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 환불요청 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 예약위치 : \n'.$location2.$rtnText.'---------------------------------\n  ▶안내사항\n    - 환불처리기간은 1~7일정도 소요됩니다.\n\n  ▶문의\n    - '.sendTel('이준영2').'\n    - http://pf.kakao.com/_HxmtMxl';

					$arrMail = array(
						"campStayName"=> $campStayName
						, "userName"=> $userName
						, "ResNumber"=> $MainNumber
						, "rtnText"=> $rtnText
						, "banknum"=> str_replace('|', ' / ', $FullBankText)
						, "gubun"=>"야영장"
						, "userPhone"=>$userPhone
						, "totalPrice"=>number_format($TotalPrice-$TotalFee).'원'
						, "location"=>str_replace('\n', '<br>', $location2)
					);

					sendMail("surfcamp3@surfenjoy.com", "surfenjoy", sendMailContent($arrMail), $to, $arrMail);
				}else if($gubun == "surf"){
					$campStayName = "surfCancel1";
					$kakaoLink1 = "surfevent";
					$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopcode.'] 환불요청 안내입니다.\n\n서프엔조이 ['.$shopcode.'] 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록 : \n'.$surfMsg.$rtnText.'---------------------------------\n  ▶안내사항\n    - 환불처리기간은 1~7일정도 소요됩니다.\n\n  ▶문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';

					$arrMail = array(
						"campStayName"=> $campStayName
						, "userName"=> $userName
						, "surfInfo"=> str_replace('\n', '<br>', $surfMsg)
						, "ResNumber"=> $MainNumber
						, "gubun"=>$shopcode
						, "userPhone"=>$userPhone
						, "totalPrice"=>number_format($TotalPrice-$TotalFee).'원'
						, "banknum"=> str_replace('|', ' / ', $FullBankText)
						, "etc"=>$etc
					);
					sendMail("surfshop3@surfenjoy.com", "surfenjoy", sendMailContentSurf($arrMail), $to, $arrMail);
				}

				sendKakao($campStayName, "surfenjoy_res1", $kakaoMsg1, $userPhone, $ResNumber, $kakaoLink1, "link2", "link3");

				//카카오톡 업체 발송
				if($gubun == "camp"){
					$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 환불요청 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 예약위치 : \n'.$location2.$rtnText.'---------------------------------\n  ▶안내사항\n   - 환불금액 입금 후 환불완료 처리 부탁드립니다.';

					sendKakao('campshop2', "surfenjoy_shop", $kakaoMsg1, sendTel('이준영'), date("Y-m-d").'|'.$MainNumber, "campadminkakao", "link2", "link3");
				}else if($gubun == "surf"){
					if($surfshopMsg != ""){
						$select_query = 'SELECT * FROM SURF_SHOP WHERE intseq = '.$row["shopSeq"];

						$result_setlist = mysqli_query($conn, $select_query);
						$rowshop = mysqli_fetch_array($result_setlist);

						$admin_tel = $rowshop["admin_tel"];

						$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$userName.']님 예약취소 안내입니다.\n\n서프엔조이 ['.$shopcode.'] 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록 : \n'.$surfshopMsg.'---------------------------------\n  ▶안내사항\n   - 예약취소내역 확인부탁드립니다.';

						sendKakao('surfshop3', "surfenjoy_shop1", $kakaoMsg1, $admin_tel, urlencode(encrypt(date("Y-m-d").'|'.$ResNumber.'|'.$row["shopSeq"])), $shopcode, $userName, "link3");
					}
				}
			}

			echo '0';
		}
	}


}
?>