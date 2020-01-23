<?
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$timechk = (int)date("H");
if(($timechk >= 22 && $timechk <= 24) || ($timechk >= 1 && $timechk <= 8)){
	$count = 0;
}else{
	//3시간 지난 데이터 취소처리
	$select_query = 'SELECT a.userName, a.userPhone, a.ResPrice as TotalPrice, a.ResOptPrice as TotalOptPrice, a.Etc, a.stay, a.sDate as startDate, a.eDate as endDate, b.* 
		FROM SURF_CAMPING_MAIN as a INNER JOIN SURF_CAMPING_SUB as b 
			ON a.MainNumber = b.MainNumber 
		WHERE b.ResConfirm = 0
			AND TIMESTAMPDIFF(MINUTE, b.insdate, now()) > 180
		ORDER BY b.MainNumber, b.sDate, b.sLocation, b.subintseq';

	$result_setlist = mysqli_query($conn, $select_query);
	$count = mysqli_num_rows($result_setlist);
}

if($count > 0){
	$x = 0;
	$PreMainNumber = "";

	while ($rowTime = mysqli_fetch_assoc($result_setlist)){
		$MainNumber = $rowTime['MainNumber'];

//============================ 실행 단계 ============================
		if($MainNumber != $PreMainNumber && $x > 0){
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 자동취소 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$PreMainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 예약위치 : \n'.$location2.'\n---------------------------------\n  ▶안내사항\n   - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n  ▶문의\n - '.sendTel('이준영').'\n - http://pf.kakao.com/_HxmtMxl';

			sendKakao("campTime", "surfenjoy_res1", $kakaoMsg1, $userPhone, $PreMainNumber, "campres", "link2", "link3");

			$location2 = "";
		}
//============================ 실행 단계 ============================
		$sDate = $rowTime["sDate"];
		$userName = $rowTime['userName'];
		$userPhone = $rowTime['userPhone'];

		$arrOpt = explode("@",$rowTime['ResOptPrice']);
		$locationOpt2 = "";
		if($arrOpt[2] > 0){
			$locationOpt2 = "(".$arrOpt[1].")";
		}
		$location2 .= "       - [".$sDate."] ".$rowTime['sLocation'].$locationOpt2."\n";

		$x++;
		$PreMainNumber = $rowTime['MainNumber'];
		$subintseq .= $rowTime['subintseq'].',';
	}
	$subintseq .= '0';

//============================ 실행 단계 ============================
	$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 죽도야영장 자동취소 안내입니다.\n\n서프엔조이 죽도야영장 예약정보\n  ▶ 예약번호 : '.$PreMainNumber.'\n  ▶ 예약자: '.$userName.'\n  ▶ 예약위치 : \n'.$location2.'\n---------------------------------\n  ▶안내사항\n   - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n  ▶문의\n - '.sendTel('이준영').'\n - http://pf.kakao.com/_HxmtMxl';

	sendKakao("campTime", "surfenjoy_res1", $kakaoMsg1, $userPhone, $PreMainNumber, "campres", "link2", "link3");
//============================ 실행 단계 ============================

	$success = true;
	$select_query = "
				UPDATE SURF_CAMPING_SUB 
				   SET ResConfirm = 2
					  ,udpdate = now()
					  ,udpuserid = 'timeover'
				WHERE subintseq IN (".$subintseq.")";

	$result_set = mysqli_query($conn, $select_query);

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
	}else{
		mysqli_query($conn, "COMMIT");
	}
}

$divSize = "width:650px;padding-left:80px;padding-top:15px;";
$divSize2 = "";

if($pcmobile){

//============ Mobile 영역 Start =============
	$divSize = "";
	$divSize2 = "margin-top:15px;";
?>
<style>

</style>
<?
//============ Mobile 영역 End =============


}else{


//============ PC 영역 Start =============
?>
<style>

</style>

<?
}
//============ PC 영역 End =============

$folderUrl = "/userAdd/camp";
?>
<script>
	var folderRoot = "/userAdd/camp";
</script>
<link rel="stylesheet" type="text/css" href="/userAdd/script/common.css?v=1" />
<link rel="stylesheet" type="text/css" href="camp.css?v=1" />
<link rel="stylesheet" type="text/css" href="/userAdd/script/calendar.css" />
<link rel="stylesheet" type="text/css" href="/userAdd/script/jquery-ui.css" />
<script src="/userAdd/script/jquery-ui.js"></script>
<script src="/userAdd/script/common.js"></script>
<script src="camp.js?v=2"></script>