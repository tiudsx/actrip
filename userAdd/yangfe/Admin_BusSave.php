<?php


include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

include __DIR__.'/../surfencrypt.php';



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


//================= 예약상태 저장 =================
for($i = 0; $i < count($chkCancel); $i++){
	$select_query = "UPDATE `SURF_YANGFE_MAIN` 
		SET ResConfirm = ".$selConfirm[$i]."
		,udpdate = now()
		WHERE intseq = ".$chkCancel[$i].";";
	$result_set = mysqli_query($conn, $select_query);

	if(!$result_set){
		$success = false;
		break;
	}

	if($selConfirm[$i] == 0){ //미입금
		$intseq0 .= $chkCancel[$i].",";
	}else if($selConfirm[$i] == 1){ //입금대기
		$intseq1 .= $chkCancel[$i].",";
	}else if($selConfirm[$i] == 2){ //확정
		$intseq2 .= $chkCancel[$i].",";
	}else if($selConfirm[$i] == 3){ //취소
		$intseq3 .= $chkCancel[$i].",";
	}
}

$intseq0 .= '0';
$intseq1 .= '0';
$intseq2 .= '0';
$intseq3 .= '0';

if(!$success){
	mysqli_query($conn, "ROLLBACK");
	echo 'err';
}else{
	mysqli_query($conn, "COMMIT");

		if($intseq2 != "0"){ //예약 확정처리 : 고객발송
			$select_query_sub = 'SELECT * FROM SURF_YANGFE_MAIN WHERE intseq IN ('.$intseq2.')';
			$resultSite = mysqli_query($conn, $select_query_sub);

			while ($row = mysqli_fetch_assoc($resultSite)){
				$intseq = $row["intseq"];
				$MainNumber = $row["MainNumber"];
				$userGubun = $row["userGubun"];
				$userClub = $row["userClub"];
				$userName = $row["userName"];
				$userSex = $row["userSex"];
				$userPhone = $row["userPhone"];
				$userCarnum = $row["userCarnum"];
				$etc = $row["etc"];

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

				//카카오톡
				$curl = curl_init();

				$tempName = "yangfe1";
				$smsTitle = "2019 양양서핑 페스티벌 입금안내";

				$kakaoMsg = '안녕하세요! ['.$userName.']님\n2019 양양서핑 페스티벌 예약안내입니다.\n\n2019 양양서핑 페스티벌 예약확정\n  ▶ 예약자: '.$userName.'\n  ▶ 예약번호: '.$MainNumber.'\n  ▶ 신청구분: '.$userGubun2.'\n  ▶ 종목: '.$userGubun.'\n  ▶ 소속: '.$userClub.'\n'.$carMsg.$etcMsg.'---------------------------------\n▶ 안내사항\n    - 양양서핑 페스티벌 참가접수가 완료되었습니다. \n\n▶ 문의\n    - 02.512.9879';

				$btnList = '"button1":{"type":"WL","name":"페스티벌 안내","url_mobile":"https://actrip.co.kr/yangfe"},"button2":{"type":"WL","name":"셔틀버스 안내","url_mobile":"https://actrip.co.kr/surfbus"},"button3":{"type":"WL","name":"서핑강습 안내","url_mobile":"https://actrip.co.kr/surfeast"},';

				$arryKakao = '[{"message_type":"at","phn":"82'.substr(str_replace('-', '',$userPhone), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$tempName.'","msg":"'.$kakaoMsg.'",'.$btnList.'"smsKind":"L","msgSms":"'.$kakaoMsg.'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$smsTitle.'","smsOnly":"N"}]';


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
			}
		}

	echo '0';
}


mysqli_close($conn);
?>