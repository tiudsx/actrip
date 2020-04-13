<?php
function plusDate($date, $count) {
	$arrdate = explode("-",$date);
	$datDate = date("Y-m-d", mktime(0, 0, 0, $arrdate[1], $arrdate[2], $arrdate[0]));
	$NextDate = date("Y-m-d", strtotime($datDate." +".$count." day"));

	return $NextDate;
}

function fnBusNum($vlu){
	$busGubun = substr($vlu, 0, 1);
	$busNumber = substr($vlu, 1, 1);

	if($busGubun == 'Y'){
		return '양양행 '.$busNumber.'호차';
	}else if($busGubun == 'E'){
		return '동해행 '.$busNumber.'호차';
	}else{
        $busTime = substr($vlu, 1, 1);
        $busNumber = substr($vlu, 2, 1);
		return '서울행 '.$busTime.'시 '.$busNumber.'호차';
	}
}

function fnBusPoint($vlu, $busNumber){	
	$busData = array(
		"Y1_신도림"=> "06:50|홈플러스 신도림점 앞"
		, "Y1_대림역"=> "07:05|동대문엽기떡볶이 앞 버스정류장"
		, "Y1_봉천역"=> "07:20|봉천역 1번출구 앞"
		, "Y1_사당역"=> "07:30|사당역 6번출구 방향 신한성약국 앞"
		, "Y1_강남역"=> "07:45|강남역 1번출구 버스정류장"
		, "Y1_종합운동장역"=> "08:00|종합운동장역 4번출구 방향 버스정류장"
		, "Y2_당산역"=> "06:40|여의도공원 횡단보도"
		, "Y2_합정역"=> "06:45|동대문엽기떡볶이 앞 버스정류장"
		, "Y2_종로3가역"=> "07:20|사당역 6번출구 방향 신한성약국 앞"
		, "Y2_왕십리역"=> "07:40|강남역 1번출구 버스정류장"
		, "Y2_건대입구역"=> "08:00|종합운동장역 4번출구 방향 버스정류장"
		, "Y2_종합운동장역"=> "08:00|종합운동장역 4번출구 방향 버스정류장"
		, "S1_청시행비치"=> "13:45|청시행비치 주차장 입구"
		, "S1_남애3리"=> "14:00|남애3리 입구"
		, "S1_인구"=> "14:05|현남보건지소 맞은편"
		, "S1_죽도"=> "14:10|GS25 죽도비치점 맞은편"
		, "S1_동산항"=> "14:15|동산항해변 입구"
		, "S1_기사문"=> "14:20|기사문 해변주차장 입구"
		, "S1_서피비치"=> "14:30|서피비치 회전교차로 횡단보도 앞"
		, "S1_청시행비치"=> "17:15|청시행비치 주차장 입구"
		, "S2_남애3리"=> "17:30|남애3리 입구"
		, "S2_인구"=> "17:35|현남보건지소 맞은편"
		, "S2_죽도"=> "17:40|GS25 죽도비치점 맞은편"
		, "S2_동산항"=> "17:45|동산항해변 입구"
		, "S2_기사문"=> "17:50|기사문 해변주차장 입구"
		, "S2_서피비치"=> "18:00|서피비치 회전교차로 횡단보도 앞"
		, "E1_신도림"=> "06:50|홈플러스 신도림점 앞"
		, "E1_대림역"=> "07:05|동대문엽기떡볶이 앞 버스정류장"
		, "E1_봉천역"=> "07:20|봉천역 1번출구 앞"
		, "E1_사당역"=> "07:30|사당역 6번출구 방향 신한성약국 앞"
		, "E1_강남역"=> "07:45|강남역 1번출구 버스정류장"
		, "E1_종합운동장역"=> "08:00|종합운동장역 4번출구 방향 버스정류장"
		, "A1_솔서프"=> "14:00|솔서프 입구"
		, "A1_대진항"=> "14:05|대진항 입구"
		, "A1_금진해변"=> "14:30|금진해변 공영주차장 입구"
		, "A2_솔서프"=> "17:30|솔서프 입구"
		, "A2_대진항"=> "17:35|대진항 입구"
		, "A2_금진해변"=> "18:00|금진해변 공영주차장 입구"
	);

	if($busNumber == "Y1" || $busNumber == "Y3" || $busNumber == "Y5"){
		$busType = "Y1";
	}else if($busNumber == "Y2" || $busNumber == "Y4" || $busNumber == "Y6"){
		$busType = "Y2";
	}else if($busNumber == "E1" || $busNumber == "E2" || $busNumber == "E3"){
		$busType = "E1";
	}else if($busNumber == "S21" || $busNumber == "S22" || $busNumber == "S23"){
		$busType = "S1";
	}else if($busNumber == "S51" || $busNumber == "S52" || $busNumber == "S53"){
		$busType = "S2";
	}else if($busNumber == "A21" || $busNumber == "A22"){
		$busType = "A1";
	}else if($busNumber == "A51" || $busNumber == "A52"){
		$busType = "A2";
	}

	if($busData[$busType.'_'.$vlu] == null){
		return '|';
	}else{
		return $busData[$busType.'_'.$vlu];
	}
}

function cancelPrice($regDate, $timeM, $ResConfirm, $ResPrice){
	$now = date("Y-m-d");
	$resDate = date("Y-m-d", strtotime(substr($regDate, 0, 10)));
	$resNow = (strtotime($resDate)-strtotime($now)) / (60*60*24);

	$cancelPrcie = 0;

	//2시간 이내 또는 미입금 상태
	if($timeM <= 130 || $ResConfirm == "0"){

	}else{
		if($resNow == 8){
			$cancelPrcie = $ResPrice * 0.1;
		}else if($resNow == 7){
			$cancelPrcie = $ResPrice * 0.2;
		}else if($resNow == 6){
			$cancelPrcie = $ResPrice * 0.3;
		}else if($resNow == 5){
			$cancelPrcie = $ResPrice * 0.4;
		}else if($resNow == 4){
			$cancelPrcie = $ResPrice * 0.5;
		}else if($resNow == 3){
			$cancelPrcie = $ResPrice * 0.6;
		}else if($resNow == 2){
			$cancelPrcie = $ResPrice * 0.7;
		}else if($resNow == 0 || $resNow == 1){
			$cancelPrcie = $ResPrice;
		}else{
			$cancelPrcie = 0;
		}
	}

	return $cancelPrcie;
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

function decrypt($plaintext){
	$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	$ciphertext_dec = base64_decode($plaintext);
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	$iv_dec = substr($ciphertext_dec, 0, $iv_size);
	$ciphertext_dec = substr($ciphertext_dec, $iv_size);
	$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

	return $plaintext_dec;
}
?>