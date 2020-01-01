<?
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

//$timechk = (int)date("H");
//if(($timechk >= 22 && $timechk <= 24) || ($timechk >= 1 && $timechk <= 7)){
//	$count = 0;
//}else{
	//3시간 지난 데이터 취소처리
	$select_query = 'SELECT a.userName, a.userPhone, a.Etc, a.shopCode, b.* 
		FROM SURF_SHOP_RES_MAIN as a INNER JOIN SURF_SHOP_RES_SUB as b 
			ON a.MainNumber = b.MainNumber 
		WHERE b.ResConfirm = 0
			AND TIMESTAMPDIFF(MINUTE, b.insdate, now()) > 120
		ORDER BY b.MainNumber, b.ResDate, b.subintseq';

	$result_setlist = mysqli_query($conn, $select_query);
	$count = mysqli_num_rows($result_setlist);
//}
echo '자동취소 : '.$count.'건';
if($count > 0){
	$x = 0;
	$PreMainNumber = "";

	while ($rowTime = mysqli_fetch_assoc($result_setlist)){
		$MainNumber = $rowTime['MainNumber'];

//============================ 실행 단계 ============================
		if($MainNumber != $PreMainNumber && $x > 0){
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 자동취소 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$PreMainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록 : \n'.$surfshopMsg.'\n---------------------------------\n  ▶안내사항\n   - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n  ▶문의\n - 010.8412.9699\n - http://pf.kakao.com/_HxmtMxl';

			sendKakao("surfTime", "surfenjoy_res1", $kakaoMsg1, $userPhone, $PreMainNumber, "link1", "link2", "link3");

			$surfshopMsg = "";
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

//============================ 실행 단계 ============================
	$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 ['.$shopname.'] 자동취소 안내입니다.\n\n서프엔조이 ['.$shopname.'] 예약정보\n  ▶ 예약번호 : '.$PreMainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 신청목록 : \n'.$surfshopMsg.'\n---------------------------------\n  ▶안내사항\n   - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n  ▶문의\n - '.sendTel('이승철').'\n - http://pf.kakao.com/_HxmtMxl';

	sendKakao("surfTime", "surfenjoy_res1", $kakaoMsg1, $userPhone, $PreMainNumber, "link1", "link2", "link3");
//============================ 실행 단계 ============================

	$success = true;
	$select_query = "
				UPDATE SURF_SHOP_RES_SUB 
				   SET ResConfirm = 1
					  ,udpdate = now()
					  ,udpuserid = 'timeover'
				WHERE  ResConfirm IN (".$subintseq.")";

	$result_set = mysqli_query($conn, $select_query);

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
	}else{
		mysqli_query($conn, "COMMIT");
	}
	
}
?>