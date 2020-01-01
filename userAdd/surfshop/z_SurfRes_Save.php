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
$datetime = date('Y/m/d H:i'); 

$totalPrice = 0; //총 이용금액
$cancelTotalPrice = 0; //환불수수료
$rtntotalPrice = 0; //환불금액

if($param == "SurfShopI"){
	$ResNumber = '3'.time().substr(mt_rand(0, 99) + 100, 1, 2); //예약번호 랜덤생성
	$resSeq = $_REQUEST["resSeq"]; //예약항목 Seq
	$resDate = $_REQUEST["resDate"]; //이용날짜
	$resTime = $_REQUEST["resTime"]; //이용시간
	$resDay = $_REQUEST["resDay"]; //숙박일
	$resGubun = $_REQUEST["resGubun"]; //예약항목 구분
	$resM = $_REQUEST["resM"]; //예약인원 : 남
	$resW = $_REQUEST["resW"]; //예약인원 : 여

	$resNumAll = $_REQUEST["resNumAll"]; //신청 옵션 전체
	$shopseq = $_REQUEST["shopseq"]; //샵 Seq
	$userName = $_REQUEST["userName"];
	$userId = $_REQUEST["userId"];
	$userPhone = $_REQUEST["userPhone1"]."-".$_REQUEST["userPhone2"]."-".$_REQUEST["userPhone3"];
	$usermail = $_REQUEST["usermail"];
	$etc = $_REQUEST["etc"];

	$select_query = "SELECT a.*, b.groupcode, b.shopcode, b.shopbank, shopname, b.admin_email, b.admin_tel, c.gubun as areagubun, c.codename FROM `SURF_SHOP_OPT` as a INNER JOIN SURF_SHOP as b ON a.shopSeq = b.intseq INNER JOIN SURF_CODE c ON b.cate_3 = c.seq AND b.groupcode in ('surf', 'bbq') where a.shopSeq = $shopseq AND a.opt_YN = 'Y' AND a.intSeq IN ($resNumAll)";
	$result_setlist = mysqli_query($conn, $select_query);

	$arrOpt = array();
	$arrOptVlu = array();
	$arrOptPkg = array();
	while ($rowOpt = mysqli_fetch_assoc($result_setlist)){
		$arrOpt[$rowOpt["intSeq"]] = $rowOpt["opt_Price"];
		$arrOptVlu[$rowOpt["intSeq"]] = $rowOpt["opt_name"];
		$arrOptPkg[$rowOpt["intSeq"]] = $rowOpt["opt_PkgTitle"];

		$shopcode = $rowOpt["shopcode"];
		$shopname = $rowOpt["shopname"];
		$shopbank = $rowOpt["shopbank"];
		$shop_gubun = $rowOpt["areagubun"];
		$codename = $rowOpt["codename"];
		$groupcode = $rowOpt["groupcode"];
		$admin_email = $rowOpt["admin_email"]; //샵 메일주소
		$admin_tel = $rowOpt["admin_tel"]; //카톡 발송 연락처

		$ordersearch = "surfres?seq=".$shopseq;
		if($shop_gubun == "surfeast"){
			$area = "[동해-양양]";
		}else if($shop_gubun = "surfeast2"){
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
			$ordersearch = 'surfBBQ';
		}else{
			$area = "[기타]";
		}
	}

	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$resCnt = count($resSeq);
	$surfshopMsg = "";
	for($i = 0; $i < count($resSeq); $i++){
		$select_query = "SELECT *, year(date_s) as yearS, month(date_s) as monthS, day(date_s) as dayS, year(date_e) as yearE, month(date_e) as monthE, day(date_e) as dayE FROM SURF_SHOP_DAY where shopSeq = $shopseq AND date_s <= '$resDate[$i]' AND date_e >= '$resDate[$i]' AND useYN = 'Y' limit 1";

		//echo $select_query.'<br>';
		$result_cal = mysqli_query($conn, $select_query);
		$row_cal = mysqli_fetch_array($result_cal);


		$eaPrice = ($arrOpt[$resSeq[$i]] + $row_cal["opt_price".$resGubun[$i]]);
		$optName = $arrOptVlu[$resSeq[$i]];
		

		$sumPrice = ($eaPrice * $resM[$i]) + ($eaPrice * $resW[$i]);
		$totalPrice += $sumPrice;
		//echo $resSeq[$i].'|'.$resDate[$i].'|'.$resTime[$i].'|'.$resGubun[$i].'|'.$resDay[$i].'|'.$resM[$i].'|'.$resW[$i].'|'.$sumPrice.'<br>';

		if($resGubun[$i] == 2){
			$optPkg = $arrOptPkg[$resSeq[$i]];
		}else{
			$optPkg = $resDay[$i];
		}

		$select_query = "INSERT INTO `SURF_SHOP_RES_SUB` (`MainNumber`, `ResDate`, `ResTime`, `ResDay`, `ResPrice`, `ResPriceEA`, `ResOptSeq`, `ResOptName`, `ResNumM`, `ResNumW`, `ResConfirm`, `ResGubun`, `RtnPrice`, `RtnBank`, `DelUse`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES ('$ResNumber', '$resDate[$i]', '$resTime[$i]', '$optPkg', '$sumPrice', '$eaPrice', '$resSeq[$i]', '$optName', '$resM[$i]', '$resW[$i]', '0', '$resGubun[$i]', '0', NULL, 'N', 'admin', '$datetime', 'admin', '$datetime');";
		$result_set = mysqli_query($conn, $select_query);
		//echo $select_query.'<br>';

		if(!$result_set){
			$success = false;
			break;
		}

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
	}

	if($success){
		$select_query = "INSERT INTO `SURF_SHOP_RES_MAIN` (`MainNumber`, `Gubun`, `shopSeq`, `shopCode`, `shopbank`, `userID`, `userName`, `userPhone`, `userMail`, `Etc`, `ResConfirm`, `ResTotalPrice`, `DelUse`, `ResCount`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES ('$ResNumber', '$groupcode', '$shopseq', '$shopname', '$shopbank', '$userId', '$userName', '$userPhone', '$usermail', '$etc', '0', '$totalPrice', 'N', '$resCnt',  'admin', '$datetime', 'admin', '$datetime');";
		$result_set = mysqli_query($conn, $select_query);
		//echo $select_query.'<br>';

		if(!$result_set) $success = false;
	}

	if(!$success){
		mysqli_query($conn, "ROLLBACK");

		echo '<script>alert("예약진행 중 오류가 발생하였습니다.\n\n관리자에게 문의해주세요.");</script>';
	}else{
		mysqli_query($conn, "COMMIT");


		//==================== 카카오톡 발송 Start ====================
		$surfshopPrice = '  ▶ 총 합계 : '.number_format($totalPrice).'원\n';

		if($etc != ''){
			$etcMsg = '  ▶ 특이사항\n'.$etc.'\n';
		}

		$campStayName = "surfRes1";
		$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 입금대기 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록\n'.$surfshopMsg.$surfshopPrice.$etcMsg.'---------------------------------\n  ▶ 안내사항\n    - 1시간 이내 미입금시 자동취소됩니다.\n\n  ▶입금계좌\n    - '.$shopbank.'\n\n  ▶ 문의\n    - '.sendTel('이승철').'\n    - http://pf.kakao.com/_HxmtMxl';

		//sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $ResNumber, $ordersearch, "surforder", $shopname);
		//==================== 카카오톡 발송 End ====================


		//==================== 이메일 발송 Start ====================
		$to = "lud1@naver.com";
		if(strrpos($usermail, "@") > 0){
			$to .= ','.$usermail;
		}

		if(strrpos($admin_email, "@") > 0){
			$to .= ','.$admin_email;
		}

		$arrMail = array(
			"campStayName"=> $campStayName
			, "userName"=> $userName
			, "surfInfo"=> str_replace('\n', '<br>', $surfshopMsg)
			, "ResNumber"=> $ResNumber
			, "gubun"=> $shopname
			, "userPhone"=>$userPhone
			, "SurfBBQMem"=>$SurfBBQMem
			, "SurfBBQ"=>$SurfBBQ
			, "etc"=>$etc
			, "banknum"=>$shopbank
			, "totalPrice"=>number_format($totalPrice).'원'
		);

		//sendMail("surfshop1@surfenjoy.com", "surfenjoy", sendMailContentSurf($arrMail), $to, $arrMail);
		//==================== 이메일 발송 End ====================

		//echo '<script>alert("예약이 완료되었습니다.");</script>';
		echo '<script>alert("예약이 완료되었습니다.");parent.location.href="/ordersearch?resNumber='.$ResNumber.'";</script>';
	}
}
?>