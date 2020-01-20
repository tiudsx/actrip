<?php
include __DIR__.'/db.php';

include __DIR__.'/func.php';

$param = $_REQUEST["resparam"];

function plusDate($date, $count) {
	$arrdate = explode("-",$date);
	$datDate = date("Y-m-d", mktime(0, 0, 0, $arrdate[1], $arrdate[2], $arrdate[0]));
	$NextDate = date("Y-m-d", strtotime($datDate." +".$count." day"));

	return $NextDate;
}

$success = true;
if($param == "yangfeI"){
	$ResNumber = '9'.time().substr(mt_rand(0, 99) + 100, 1, 2); //예약번호 랜덤생성

	$userGubun = $_REQUEST["userGubun"];
	$userClub = $_REQUEST["userClub"];
	$userName = $_REQUEST["userName"];
	$userSex = $_REQUEST["userSex"];
	$userPhone = $_REQUEST["userPhone1"]."-".$_REQUEST["userPhone2"]."-".$_REQUEST["userPhone3"];
	$userCarnum = $_REQUEST["userCarnum1"]."-".$_REQUEST["userCarnum2"];
	$etc = $_REQUEST["etc"];
	$datetime = date('Y/m/d H:i'); 


	$select_query = 'SELECT userGubun, userSex, COUNT(*) AS Cnt FROM `SURF_YANGFE_MAIN` WHERE ResConfirm IN (0,1,2) GROUP BY userGubun, userSex ORDER BY userGubun, userSex';

	$result_setlist = mysqli_query($conn, $select_query);
	$count = mysqli_num_rows($result_setlist);

	$arrGubunInfo = array();
	//비기너
	$arrGubunInfo['비기너_남'] = 0;
	$arrGubunInfo['비기너_여'] = 0;

	//롱보드 오픈
	$arrGubunInfo['롱보드(오픈)_남'] = 0;
	$arrGubunInfo['롱보드(오픈)_여'] = 0;

	//숏보드 오픈
	$arrGubunInfo['숏보드(오픈)_남'] = 0;
	$arrGubunInfo['숏보드(오픈)_여'] = 0;

	//롱보드 프로
	$arrGubunInfo['롱보드(프로)_남'] = 0;
	$arrGubunInfo['롱보드(프로)_여'] = 0;

	//숏보드 프로
	$arrGubunInfo['숏보드(프로)_남'] = 0;
	$arrGubunInfo['숏보드(프로)_여'] = 0;

	//주니어
	$arrGubunInfo['주니어'] = 0;

	while ($row = mysqli_fetch_assoc($result_setlist)){
		$ChkuserGubun = $row["userGubun"];
		$ChkuserSex = $row["userSex"];
		$Cnt = $row["Cnt"];

		if($ChkuserGubun == "주니어"){
			$arrGubunInfo['주니어'] += $Cnt;
		}else{
			$arrGubunInfo[$ChkuserGubun.'_'.$ChkuserSex] = $Cnt;
		}
	}

	$arrGubunSold = array();
	//비기너
	$arrGubunSold['비기너_남'] = 50;
	$arrGubunSold['비기너_여'] = 50;

	//롱보드 오픈
	$arrGubunSold['롱보드(오픈)_남'] = 80;
	$arrGubunSold['롱보드(오픈)_여'] = 80;

	//숏보드 오픈
	$arrGubunSold['숏보드(오픈)_남'] = 50;
	$arrGubunSold['숏보드(오픈)_여'] = 50;

	//롱보드 프로
	$arrGubunSold['롱보드(프로)_남'] = 50;
	$arrGubunSold['롱보드(프로)_여'] = 50;

	//숏보드 프로
	$arrGubunSold['숏보드(프로)_남'] = 50;
	$arrGubunSold['숏보드(프로)_여'] = 50;

	//주니어
	$arrGubunSold['주니어'] = 50;

	if($userGubun == "참관"){
		$soldUse = 1;
	}else{
		if($userGubun == "주니어"){
			$resCnt = $arrGubunInfo[$userGubun];
			$resSoldCnt = $arrGubunSold[$userGubun];
		}else{
			$resCnt = $arrGubunInfo[$userGubun.'_'.$userSex];
			$resSoldCnt = $arrGubunSold[$userGubun.'_'.$userSex];
		}
		
		if($resCnt >= $resSoldCnt){ //마감
			$soldUse = 0;
		}else{
			$soldUse = 1;
		}
	}

	if($soldUse == 0){
		echo '<script>alert("2019 양양서핑페스티벌 ['.$userGubun.'-'.$userSex.'] 참가신청이 마감되었습니다.\n\n운영사무국에 문의해주세요.");</script>';
		exit;
	}

/*
	$select_query = 'SELECT sLocation FROM `SURF_YANGFE_MAIN` where busDate = "'.$SurfDateBusY[$i].'" AND busNum = "'.$busNumY[$i].'" AND busSeat = "'.$arrSeatY[$i].'" AND DelUse = "N" AND ResConfirm IN (0, 1)';
	$result_setlist = mysqli_query($conn, $select_query);
	$count = mysqli_num_rows($result_setlist);

	if($count > 0){
		echo '<script>alert("['.$SurfDateBusY[$i].'] '.$arrSeatY[$i].'번 좌석은 이미 예약된 자리입니다.\n\n다른좌석을 선택해주세요.");</script>';
		return;
	}
*/
	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$select_query = "INSERT INTO `SURF_YANGFE_MAIN` (`MainNumber`, `userGubun`, `userClub`, `userName`, `userSex`, `userPhone`, `userCarnum`, `Etc`, `ResConfirm`, `insdate`, `udpdate`) VALUES ('$ResNumber', '$userGubun', '$userClub', '$userName', '$userSex', '$userPhone', '$userCarnum', '$etc', 0, '$datetime', '$datetime');";
	$result_set = mysqli_query($conn, $select_query);

	if(!$result_set){
		$success = false;
	}

	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo '<script>alert("참가신청 접수중 오류가 발생하였습니다.\n\n운영사무국에 문의해주세요.");</script>';
	}else{
		mysqli_query($conn, "COMMIT");

		$userGubun2 = "대회참가";
		if($userGubun == '참관'){
			$userGubun2 = "참가(갤러리)";
		}

		if($etc != ''){
			$etcMsg = '  ▶ 비고\n'.$etc.'\n';
		}

		if($userCarnum != '-'){
			$carMsg = '  ▶ 차량번호: '.str_replace('-', ' ', $userCarnum).'\n';
		}

		$curl = curl_init();

		$tempName = "yangfe1";
		$smsTitle = "2019 양양서핑 페스티벌 입금안내";

		$kakaoMsg = '안녕하세요! ['.$userName.']님\n2019 양양서핑 페스티벌 예약안내입니다.\n\n2019 양양서핑 페스티벌 입금대기\n  ▶ 예약자: '.$userName.'\n  ▶ 신청구분: '.$userGubun2.'\n  ▶ 종목: '.$userGubun.'\n  ▶ 소속: '.$userClub.'\n'.$carMsg.$etcMsg.'---------------------------------\n▶ 안내사항\n    - 입금자명과 예약자명이 동일해야합니다.\n    - 입금자명 이외에 다른내용을 적으시면 안됩니다.\n    - 1시간 이내 미입금시 자동취소됩니다.\n\n▶입금계좌\n    - 참가/참관비용 : 4만원\n    - KEB하나은행 109-910025-52604 중앙일보(주).\n\n▶ 문의\n    - 02.512.9879';

		$btnList = '"button1":{"type":"WL","name":"페스티벌 안내","url_mobile":"https://actrip.co.kr/yangfe"},"button2":{"type":"WL","name":"셔틀버스 안내","url_mobile":"https://actrip.co.kr/surfbus"},"button3":{"type":"WL","name":"서핑강습 안내","url_mobile":"https://actrip.co.kr/surfeast"},';

		$arryKakao = '['.$arryKakao.'{"message_type":"at","phn":"82'.substr(str_replace('-', '',$userPhone), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$tempName.'","msg":"'.$kakaoMsg.'",'.$btnList.'"smsKind":"L","msgSms":"'.$kakaoMsg.'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$smsTitle.'","smsOnly":"N"}]';


		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://alimtalk-api.bizmsg.kr/v2/sender/send",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $arryKakao,
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/json", "userId: surfenjoy"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		echo '<script>alert("2019 양양서핑페스티벌 참가신청이 완료되었습니다.");parent.fnReset();</script>';
		//parent.location.href="/yangfe";
	}
}

mysqli_close($conn);
?>
