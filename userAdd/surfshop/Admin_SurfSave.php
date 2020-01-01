<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

include __DIR__.'/../surfencrypt.php';

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

$chkCancel = $_REQUEST["chkCancel"];
$selConfirm = $_REQUEST["selConfirm"];
$MainNumber = $_REQUEST["MainNumber"];
$memo = $_REQUEST["memo"];
$shopseq = $_REQUEST["shopSeq"];

$intseq = "";
$intseq2 = "";
$intseq5 = "";

if($param == "soldoutdel"){ //매진 삭제 : 서핑샵
	session_start();

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$shopseq = $_SESSION['shopseq']; //샵 seq
	$seq = $_REQUEST['seq'];

	$select_query = "DELETE FROM `SURF_SHOP_SOLDOUT` WHERE shopSeq = $shopseq AND intseq = $seq";
	$result_set = mysqli_query($conn, $select_query);

	if(!$result_set){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");
		echo '0';
	}

}else if($param == "soldout"){ //매진 처리 : 서핑샵
	session_start();

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$shopseq = $_SESSION['shopseq']; //샵 seq
	$InsUserID = $_SESSION['userid'];

	$strDate = $_REQUEST["strDate"];
	$selItem = $_REQUEST["selItem"];

	$chkSexM = "N";
	$chkSexW = "N";
	if($_REQUEST["chkSexM"] == 1) $chkSexM = "Y";
	if($_REQUEST["chkSexW"] == 1) $chkSexW = "Y";

	$select_query = 'SELECT * FROM `SURF_SHOP_SOLDOUT` WHERE shopSeq = '.$shopseq.' AND soldoutdate = "'.$strDate.'" AND optseq = '.$selItem;
	$result = mysqli_query($conn, $select_query);
	$count = mysqli_num_rows($result);

	if($count != 0){
		echo '1';
		exit;
	}


	$select_query = "INSERT INTO `SURF_SHOP_SOLDOUT`(`gubun`, `shopSeq`, `soldoutdate`, `optseq`, `opttype`, `optsexM`, `optsexW`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES ('surf', $shopseq, '$strDate', $selItem, 0, '$chkSexM', '$chkSexW', '$InsUserID', now(), '$InsUserID', now())";
	$result_set = mysqli_query($conn, $select_query);

	if(!$result_set){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");
		echo '0';
	}
}else if($param == "changeShopConfirm"){ //상태 정보 업데이트 : 서핑샵
	session_start();

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$shopseq = $_SESSION['shopseq']; //샵 seq
	$InsUserID = $_SESSION['userid'];

	for($i = 0; $i < count($chkCancel); $i++){
		$intseq .= $chkCancel[$i].",";
	}
	$intseq .= '0';

	if($intseq == '0'){
		$select_query = 'SELECT * FROM SURF_SHOP_RES_MAIN as a INNER JOIN SURF_SHOP_RES_SUB as b ON a.MainNumber = b.MainNumber 
							WHERE a.MainNumber = '.$MainNumber.' 
								AND a.shopSeq = '.$shopseq;

	}else{
		$select_query = 'SELECT * FROM SURF_SHOP_RES_MAIN as a INNER JOIN SURF_SHOP_RES_SUB as b ON a.MainNumber = b.MainNumber 
							WHERE a.MainNumber = '.$MainNumber.' 
								AND a.shopSeq = '.$shopseq.'
								AND b.subintseq in ('.$intseq.')';
	}
	$result = mysqli_query($conn, $select_query);
	$count = mysqli_num_rows($result);

	if($count == 0){
		echo 'err';
		exit;
	}

//================= 메모만 저장 =================
	if($intseq == '0'){
		$select_query = "UPDATE SURF_SHOP_RES_MAIN 
					   SET memo = '".$memo."'
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE MainNumber = ".$MainNumber.";";

		$result_set = mysqli_query($conn, $select_query);

		if(!$result_set){
			mysqli_query($conn, "ROLLBACK");
			echo 'err';
		}else{
			mysqli_query($conn, "COMMIT");
			echo '0';
		}
		exit;
	}

//================= 예약상태 및 메모 저장 =================
	$select_query = "UPDATE SURF_SHOP_RES_MAIN 
				   SET memo = '".$memo."'
					  ,udpdate = now()
					  ,udpuserid = '".$InsUserID."'
				WHERE MainNumber = ".$MainNumber.";";
	$result_set = mysqli_query($conn, $select_query);

	for($i = 0; $i < count($chkCancel); $i++){
		$select_query = "UPDATE `SURF_SHOP_RES_SUB` 
					   SET ResConfirm = ".$selConfirm[$i]."
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE subintseq = ".$chkCancel[$i].";";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set){
			$success = false;
			break;
		}


		if($selConfirm[$i] == 2){ //입금확인
			$intseq2 .= $chkCancel[$i].",";
		}else if($selConfirm[$i] == 4){ //임시취소
			$intseq4 .= $chkCancel[$i].",";
		}else if($selConfirm[$i] == 5){ //확정
			$intseq5 .= $chkCancel[$i].",";
		}
	}

	$intseq2 .= '0';
	$intseq4 .= '0';
	$intseq5 .= '0';

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");

		$arrSeatInfo = array();
		$arrStopInfo = array();

		$select_query = 'SELECT userName, userPhone, userMail, Etc, memo FROM `SURF_SHOP_RES_MAIN` WHERE MainNumber = '.$MainNumber;
		$result = mysqli_query($conn, $select_query);
		$row = mysqli_fetch_array($result);

		$userName = $row["userName"];
		$userPhone = $row["userPhone"];
		$userMail = $row["userMail"];
		$etc = $row["Etc"];
		$memo = $row["memo"];

		$select_query = 'SELECT a.*,b.gubun, b.codename FROM `SURF_SHOP` a INNER JOIN SURF_CODE b ON a.cate_3 = b.seq AND a.groupcode in ("surf", "bbq")  WHERE a.intseq = '.$shopseq;
		$result_shop = mysqli_query($conn, $select_query);
		$rowshop = mysqli_fetch_array($result_shop);

		$shopname = $rowshop["shopname"]; //샵 정보
		$admin_tel = $rowshop["admin_tel"]; //카톡 발송 연락처
		$shop_addr = $rowshop["shop_addr"]; //샵 주소
		$shop_gubun = $rowshop["gubun"]; //샵 구분
		$admin_email = $rowshop["admin_email"]; //샵 메일주소
		$codename = $rowshop["codename"]; //샵 해변
		$groupcode = $rowshop["groupcode"];

		if($intseq2 != "0"){ //입금완료 : 서프엔조이에게 발송
			$select_query_sub = 'SELECT * FROM `SURF_SHOP_RES_SUB` where subintseq IN ('.$intseq2.') AND MainNumber = '.$MainNumber.' ORDER BY ResDate, subintseq';
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
					//$bbqMsg = "  ▶ 바베큐 정보\n    - 위치 : 죽도해변 관리실 앞\n    - 시간 : 19:00 ~ 21:30까지\n";
				}
			}

			if($etc != ''){
				$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
			}

			//======== 고객 알림톡 발송 =========
			$campStayName = "surfshop6";
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 입금완료 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록\n'.$surfMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n   - 예약하신 샵에서 예약가능 여부 확인 후 확정 및 취소가 진행됩니다.\n   - 예약항목이 매진되어 예약이 불가능 할 경우 취소 될 수 있으니 참고부탁드립니다.\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';
			sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $MainNumber, "surfres?seq=".$shopseq, "surforder", $shopname);


			//서프엔조이에게만 발송
			$to = "lud1@naver.com";
			$arrMail = array(
				"campStayName"=> "surfshop3"
				, "userName"=> $userName
				, "surfInfo"=> str_replace('\n', '<br>', $surfMsg)
				, "surfInfoAddr"=> str_replace('\n', '<br>', $shopname)
				, "ResNumber"=> $MainNumber
				, "gubun"=>$shopname
				, "userPhone"=>$userPhone
				, "etc"=>$etc
				, "memo"=> $row["memo"]
			);

			sendMail("surfshop4@surfenjoy.com", "surfenjoy", sendMailContentSurf($arrMail), $to, $arrMail);
		}

		if($intseq4 != "0"){ //임시취소 : 서프엔조이에게 발송
			//서프엔조이에게만 발송
			$to = "lud1@naver.com,ttenill@naver.com";
			$arrMail = array(
				"campStayName"=> "surfshop2"
				, "userName"=> $userName
				, "surfInfo"=> str_replace('\n', '<br>', $surfMsg)
				, "surfInfoAddr"=> str_replace('\n', '<br>', $shopname)
				, "ResNumber"=> $MainNumber
				, "gubun"=>$shopname
				, "userPhone"=>$userPhone
				, "etc"=>$etc
				, "memo"=> $row["memo"]
			);

			sendMail("surfshop4@surfenjoy.com", "surfenjoy", sendMailContentSurf($arrMail), $to, $arrMail);
		}

		if($intseq5 != "0"){ //예약 확정처리 : 고객발송
			$select_query_sub = 'SELECT * FROM `SURF_SHOP_RES_SUB` where subintseq IN ('.$intseq5.') AND MainNumber = '.$MainNumber.' ORDER BY ResDate, subintseq';
			$resultSite = mysqli_query($conn, $select_query_sub);

			$surfMsg = "";
			$surfshopMsg = "";
			$bbqMsg = "";
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
					//$bbqMsg = "  ▶ 바베큐 정보\n    - 위치 : 죽도해변 관리실 앞\n    - 시간 : 19:00 ~ 21:30까지\n";
				}
			}

			if($etc != ''){
				$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
			}

			if($shop_gubun == "surfeast"){
				$area = "[동해-양양]";
			}else if($shop_gubun == "surfeast2"){
				$area = "[동해-고성]";
			}else if($shop_gubun == "surfeast3"){
				$area = "[동해-강릉]";
			}else if($shop_gubun == "surfjeju"){
				$area = "[제주]";
			}else if($shop_gubun == "surfsouth"){
				$area = "[남해]";
			}else if($shop_gubun == "surfwest"){
				$area = "[서해]";
			}else if($shop_gubun == "etc"){
				$area = "[기타]";
			}else{
				$area = "[기타]";
			}

			$area .= " : ".$codename;

			if($surfshopMsg != ""){
				$shopInfo = '  ▶ 서핑샵 정보\n    - '.$area.'\n    - '.$shop_addr.'\n';
				$shopInfo2 = '    '.$area.'\n    '.$shop_addr.'\n';
			}

			$kakaoTitle = " 확정완료";
			$kakaoInfo = "    - 신청내역이 확정완료 되었습니다.";

			$campStayName = "surfshop2";
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 확정완료 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록\n'.$surfMsg.$shopInfo.$bbqMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n   - 예약샵, 이용일, 이용시간 꼭 확인부탁드립니다.\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';
			sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $MainNumber, "surfres?seq=".$shopseq, "surforder", $shopname);

			//if($groupcode == "surf"){
			if($surfshopMsg != ""){
				$campStayName = "surfshop1";
				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$userName.']님'.$kakaoTitle.' 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 연락처: '.$userPhone.'\n  ▶ 신청목록\n'.$surfshopMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n'.$kakaoInfo.'\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';

				sendKakao($campStayName, "surfenjoy_shop3", $kakaoMsg1, $admin_tel, urlencode(encrypt(date("Y-m-d").'|'.$MainNumber.'|'.$shopseq)), $shopname, $userName, "link3");
				//sendKakao($campStayName, "surfenjoy_shop", $kakaoMsg1, $admin_tel, $MainNumber, $shopname, $userName, "link3");
			}
			//}

			$to = "lud1@naver.com,ttenill@naver.com";
			if(strrpos($userMail, "@") > 0){
				$to .= ','.$userMail;
			}

			if(strrpos($admin_email, "@") > 0){
				$to .= ','.$admin_email;
			}

			$arrMail = array(
				"campStayName"=> "surfshop1"
				, "userName"=> $userName
				, "surfInfo"=> str_replace('\n', '<br>', $surfMsg)
				, "surfInfoAddr"=> str_replace('\n', '<br>', $shopInfo2)
				, "ResNumber"=> $MainNumber
				, "gubun"=>$shopname
				, "userPhone"=>$userPhone
				, "etc"=>$etc
			);

			sendMail("surfshop2@surfenjoy.com", "surfenjoy", sendMailContentSurf($arrMail), $to, $arrMail);
		}
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

//================= 메모만 저장 =================
	if($intseq == '0'){
		$select_query = "UPDATE SURF_SHOP_RES_MAIN 
					   SET memo = '".$memo."'
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE MainNumber = ".$MainNumber.";";

		$result_set = mysqli_query($conn, $select_query);

		if(!$result_set){
			mysqli_query($conn, "ROLLBACK");
			echo 'err';
		}else{
			mysqli_query($conn, "COMMIT");
			echo '0';
		}
		exit;
	}

//================= 예약상태 및 메모 저장 =================
	$select_query = "UPDATE SURF_SHOP_RES_MAIN 
				   SET memo = '".$_REQUEST["memo"]."'
					  ,udpdate = now()
					  ,udpuserid = '".$InsUserID."'
				WHERE MainNumber = ".$MainNumber.";";
	$result_set = mysqli_query($conn, $select_query);

	for($i = 0; $i < count($chkCancel); $i++){
		$insdate1 = "";
		if($selConfirm[$i] == 5){
			$insdate1 = ",insdate = now()";
		}

		$select_query = "UPDATE `SURF_SHOP_RES_SUB` 
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

		if($selConfirm[$i] == 2){ //입금확인
			$intseq2 .= $chkCancel[$i].",";
		}else if($selConfirm[$i] == 5){ //확정
			$intseq5 .= $chkCancel[$i].",";
		}
	}

	$intseq2 .= '0';
	$intseq5 .= '0';

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");

		$arrSeatInfo = array();
		$arrStopInfo = array();

		$select_query = 'SELECT userName, userPhone, userMail, Etc, memo FROM `SURF_SHOP_RES_MAIN` WHERE MainNumber = '.$MainNumber;
		$result = mysqli_query($conn, $select_query);
		$row = mysqli_fetch_array($result);

		$userName = $row["userName"];
		$userPhone = $row["userPhone"];
		$userMail = $row["userMail"];
		$etc = $row["Etc"];

		//==========================카카오 메시지 발송 ==========================
		$select_query = 'SELECT a.*, b.gubun, b.codename FROM `SURF_SHOP` a INNER JOIN SURF_CODE b ON a.cate_3 = b.seq AND a.groupcode in ("surf", "bbq")  WHERE a.intseq = '.$shopseq;
		$result_shop = mysqli_query($conn, $select_query);
		$rowshop = mysqli_fetch_array($result_shop);

		$shopname = $rowshop["shopname"]; //샵 정보
		$admin_tel = $rowshop["admin_tel"]; //카톡 발송 연락처
		$shop_addr = $rowshop["shop_addr"]; //샵 주소
		$shop_gubun = $rowshop["gubun"]; //샵 구분
		$admin_email = $rowshop["admin_email"]; //샵 메일주소
		$codename = $rowshop["codename"]; //샵 해변
		$groupcode = $rowshop["groupcode"];
		$opt_bbq = $rowshop["opt_bbq"]; //서프엔조이 바베큐 여부

		if($intseq2 != "0"){ //예약 입금완료 : 업체발송
			$select_query_sub = 'SELECT * FROM `SURF_SHOP_RES_SUB` where subintseq IN ('.$intseq2.') AND MainNumber = '.$MainNumber.' ORDER BY ResDate, subintseq';
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
				$campStayName = "surfshop6";
				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 입금완료 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록\n'.$surfMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n   - 예약하신 샵에서 예약가능 여부 확인 후 확정 및 취소가 진행됩니다.\n   - 예약항목이 매진되어 예약이 불가능 할 경우 취소 될 수 있으니 참고부탁드립니다.\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';
				sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $MainNumber, "surfres?seq=".$shopseq, "surforder", $shopname);


				$kakaoTitle = " 입금완료";
				$kakaoInfo = "    - 예약내역 확인 후 승인처리 부탁드립니다.\n    - 매진되어 예약이 불가할 경우 임시취소 및 사유작성해주시면 별도로 처리해드리겠습니다.\n    - [예약관리] 메뉴에서 매진처리 진행하시면 해당날짜는 예약불가 처리됩니다.";

				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$userName.']님'.$kakaoTitle.' 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록\n'.$surfshopMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n'.$kakaoInfo.'\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';

				sendKakao("surfshop4", "surfenjoy_shop2", $kakaoMsg1, $admin_tel, urlencode(encrypt(date("Y-m-d").'|'.$MainNumber.'|'.$shopseq)), $shopname, $userName, "link3");
				//sendKakao($campStayName, "surfenjoy_shop", $kakaoMsg1, $admin_tel, $MainNumber, $shopname, $userName, "link3");


				if(strrpos($admin_email, "@") > 0){
					$to = $admin_email;

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


			}
		}

		if($intseq5 != "0"){ //예약 확정처리 : 고객발송
			$select_query_sub = 'SELECT * FROM `SURF_SHOP_RES_SUB` where subintseq IN ('.$intseq5.') AND MainNumber = '.$MainNumber.' ORDER BY ResDate, subintseq';
			$resultSite = mysqli_query($conn, $select_query_sub);

			$surfMsg = "";
			$surfshopMsg = "";
			$bbqMsg = "";
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
					$bbqMsg = "  ▶ 바베큐 정보\n    - 위치 : 죽도해변 관리실 앞\n    - 시간 : 19:00 ~ 21:30까지\n";
					$bbqMsgMail = "  - 위치 : 죽도해변 관리실 앞<br> - 시간 : 19:00 ~ 21:30까지";
				}
			}

			if($etc != ''){
				$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
			}

			$kakaoTitle = " 확정완료";
			$kakaoInfo = "    - 신청내역이 확정완료 되었습니다.";

			if($shop_gubun == "surfeast"){
				$area = "[동해-양양]";
			}else if($shop_gubun == "surfeast2"){
				$area = "[동해-고성]";
			}else if($shop_gubun == "surfeast3"){
				$area = "[동해-강릉]";
			}else if($shop_gubun == "surfjeju"){
				$area = "[제주]";
			}else if($shop_gubun == "surfsouth"){
				$area = "[남해]";
			}else if($shop_gubun == "surfwest"){
				$area = "[서해]";
			}else if($shop_gubun == "etc"){
				$area = "[기타]";
			}else{
				$area = "[기타]";
			}

			$area .= " : ".$codename;

			if($surfshopMsg != ""){
				$shopInfo = '  ▶ 서핑샵 정보\n    - '.$area.'\n    - '.$shop_addr.'\n';
				$shopInfo2 = '    '.$area.'\n    '.$shop_addr.'\n';
			}

			$campStayName = "surfshop2";
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 확정완료 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록\n'.$surfMsg.$shopInfo.$bbqMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n   - 예약샵, 이용일, 이용시간 꼭 확인부탁드립니다.\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';
			sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $MainNumber, "surfres?seq=".$shopseq, "surforder", $shopname);

			//if($groupcode == "surf"){
			if($surfshopMsg != ""){
				$campStayName = "surfshop1";
				$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$userName.']님'.$kakaoTitle.' 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$MainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 연락처: '.$userPhone.'\n  ▶ 신청목록\n'.$surfshopMsg.$etcMsg.'---------------------------------\n  ▶ 안내사항\n'.$kakaoInfo.'\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';

				sendKakao($campStayName, "surfenjoy_shop3", $kakaoMsg1, $admin_tel, urlencode(encrypt(date("Y-m-d").'|'.$MainNumber.'|'.$shopseq)), $shopname, $userName, "link3");
				//sendKakao($campStayName, "surfenjoy_shop", $kakaoMsg1, $admin_tel, $MainNumber, $shopname, $userName, "link3");
			}
			//}

			$to = "lud1@naver.com";
			if(strrpos($userMail, "@") > 0){
				$to .= ','.$userMail;
			}

			if(strrpos($admin_email, "@") > 0){
				$to .= ','.$admin_email;
			}

			$arrMail = array(
				"campStayName"=> "surfshop1"
				, "userName"=> $userName
				, "surfInfo"=> str_replace('\n', '<br>', $surfMsg)
				, "surfInfoAddr"=> str_replace('\n', '<br>', $shopInfo2).$bbqMsgMail
				, "ResNumber"=> $MainNumber
				, "gubun"=>$shopname
				, "userPhone"=>$userPhone
				, "etc"=>$etc
			);

			sendMail("surfshop2@surfenjoy.com", "surfenjoy", sendMailContentSurf($arrMail), $to, $arrMail);
		}
		//==========================카카오 메시지 발송 End ==========================

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
