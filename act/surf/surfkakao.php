<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

function sendKakao2($gubun, $tempName, $kakaoMsg, $userPhone, $ResNumber, $link1, $link2, $link3){
	$curl = curl_init();

	if($tempName == "tempName" || $tempName == ""){
		$tempName = "surfenjoy_res";
	}
	if($gubun == "campStay1" || $gubun == "campshop1"){
		$smsTitle = "죽도야영장 입금대기 안내";
	}else if($gubun == "campStay2"){
		$smsTitle = "죽도글램핑 입금대기 안내";
	}else if($gubun == "campOk1" || $gubun == "campshop3"){
		$smsTitle = "죽도야영장 확정완료 안내";
	}else if($gubun == "campCancel1" || $gubun == "campshop2"){
		$smsTitle = "죽도야영장 환불요청 안내";
	}else if($gubun == "campTime" || $gubun == "busTime" || $gubun == "surfTime"){
		$smsTitle = "서프엔조이 자동취소 안내";
	}else if($gubun == "busStay1" || $gubun == "busStay1_sol"){
		$smsTitle = "양양셔틀버스 입금대기 안내";
	}else if($gubun == "busConfirm1"){
		$smsTitle = "양양셔틀버스 예약확정 안내";
	}else if($gubun == "busCancel1"){
		$smsTitle = "양양셔틀버스 환불요청 안내";
	}else if($gubun == "surfRes1"){
		$smsTitle = $link3." 입금대기 안내";
	}else if($gubun == "surfshop1"){
		$smsTitle = "[".$link1."] ".$link2."님 예약확인 안내";
	}else if($gubun == "surfshop2"){
		$smsTitle = "[".$link3."] 확정완료 안내";
	}else if($gubun == "surfshop4"){
		$smsTitle = "[".$link1."] ".$link2."님 입금완료 안내";
	}else if($gubun == "surfshop6"){
		$smsTitle = $link3." 입금완료 안내";
	}else if($gubun == "surfshop5"){
		$smsTitle = "[".$link1."] ".$link2."님 임시취소 안내";
	}else if($gubun == "surfCancel1"){
		$smsTitle = "[".$link3."] 환불요청 안내";
	}else if($gubun == "surfCancel2" || $gubun == "surfshop3"){
		$smsTitle = "[".$link1."] ".$link2."님 취소 안내";
	}
	
	$arryKakao = '';
	
	if($tempName == "surfenjoy_res1"){
		$btnList = '"button1":{"type":"WL","name":"자주묻는질문","url_mobile":"https://actrip.co.kr/surfFAQ"},';
	}else if($tempName == "surfenjoy_res2"){
		$btnList = '"button1":{"type":"WL","name":"이용안내","url_mobile":"https://actrip.co.kr/'.$link1.'"},"button2":{"type":"WL","name":"예약조회/취소","url_mobile":"https://actrip.co.kr/ordersearch?resNumber='.$ResNumber.'"},"button3":{"type":"WL","name":"정류장안내","url_mobile":"https://actrip.co.kr/buspoint"},"button4":{"type":"WL","name":"자주묻는질문","url_mobile":"https://actrip.co.kr/surfFAQ"},';
	}else if($tempName == "surfenjoy_shop1"){
		$btnList = '"button1":{"type":"WL","name":"취소확인","url_mobile":"https://actrip.co.kr/surfadminkakao?MainNumber='.$ResNumber.'"},';
	}else if($tempName == "surfenjoy_shop2"){
		$btnList = '"button1":{"type":"WL","name":"승인처리","url_mobile":"https://actrip.co.kr/surfadminkakao?MainNumber='.$ResNumber.'"},';
	}else if($tempName == "surfenjoy_shop3"){
		$btnList = '"button1":{"type":"WL","name":"확정 확인","url_mobile":"https://actrip.co.kr/surfadminkakao?MainNumber='.$ResNumber.'"},';
	}else if($tempName == "surfenjoy_shop"){
		$btnList = '"button1":{"type":"WL","name":"예약목록","url_mobile":"https://actrip.co.kr/camplist"},"button2":{"type":"WL","name":"예약건 승인","url_mobile":"https://actrip.co.kr/'.$link1.'?MainNumber='.$ResNumber.'"},';
	}else if($tempName == "surfenjoy_busres1"){
		$btnList = '"button1":{"type":"WL","name":"이용안내","url_mobile":"https://actrip.co.kr/'.$link1.'"},"button2":{"type":"WL","name":"예약조회/취소","url_mobile":"https://actrip.co.kr/ordersearch?resNumber='.$ResNumber.'"},"button3":{"type":"WL","name":"정류장안내","url_mobile":"https://actrip.co.kr/buspoint"},"button4":{"type":"WL","name":"서핑버스 위치보기","url_mobile":"https://actrip.co.kr/busgps"},"button5":{"type":"WL","name":"자주묻는질문","url_mobile":"https://actrip.co.kr/surfFAQ"},';
	}else{
		if($gubun == "busStay1_sol"){
			$orderUrl = "solguestorder";
		}else{
			$orderUrl = "ordersearch";
		}
			$btnList = '"button1":{"type":"WL","name":"이용안내","url_mobile":"https://actrip.co.kr/'.$link1.'"},"button2":{"type":"WL","name":"예약조회/취소","url_mobile":"https://actrip.co.kr/'.$orderUrl.'?resNumber='.$ResNumber.'"},"button3":{"type":"WL","name":"자주묻는질문","url_mobile":"https://actrip.co.kr/surfFAQ"},';
	}

	$arryKakao .= '['.$arryKakao.'{"message_type":"at","phn":"82'.substr(str_replace('-', '',$userPhone), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$tempName.'","msg":"'.$kakaoMsg.'",'.$btnList.'"smsKind":"L","msgSms":"'.$kakaoMsg.'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$smsTitle.'","smsOnly":"N"}]';

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

function sendKakao($arrKakao){
	$curl = curl_init();

    $rtnMsg = kakaoMsg($arrKakao);
    
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://alimtalk-api.bizmsg.kr/v2/sender/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => $rtnMsg,
	  CURLOPT_HTTPHEADER => array(
		"content-type: application/json", "userId: surfenjoy"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

    // echo '<br>res : '.$response;
    // echo '<br>err : '.$err;

	curl_close($curl);
}

function kakaoMsg($arrKakao){
    if($arrKakao["tempName"] == "at_res_step1"){ //입금대기 기본정보
        $btnList = '"button1":{"type":"WL","name":"예약조회/취소","url_mobile":"http://actrip.co.kr/'.$arrKakao["link1"].'"},"button2":{"type":"WL","name":"제휴업체 목록","url_mobile":"http://actrip.co.kr/'.$arrKakao["link2"].'"},"button3":{"type":"WL","name":"공지사항","url_mobile":"http://actrip.co.kr/'.$arrKakao["link3"].'"},';
	}else if($arrKakao["tempName"] == "at_res_step3"){ //입금대기 기본정보
		$btnList = '"button1":{"type":"WL","name":"공지사항","url_mobile":"http://actrip.co.kr/'.$arrKakao["link1"].'"},';
	}else if($arrKakao["tempName"] == "at_shop_step1"){ //입점샵 예약안내
		$btnList = '"button1":{"type":"WL","name":"전체 예약목록","url_mobile":"http://actrip.co.kr/'.$arrKakao["link1"].'"},"button2":{"type":"WL","name":"현재 예약건 보기","url_mobile":"http://actrip.co.kr/'.$arrKakao["link2"].'"},';
	}else if($arrKakao["tempName"] == "at_res_bus1"){ //셔틀버스 예약확정 정보
        $btnList = '"button1":{"type":"WL","name":"예약조회/취소","url_mobile":"http://actrip.co.kr/'.$arrKakao["link1"].'"},"button2":{"type":"WL","name":"셔틀버스 실시간위치 조회","url_mobile":"http://actrip.co.kr/'.$arrKakao["link2"].'"},"button3":{"type":"WL","name":"셔틀버스 탑승 위치확인","url_mobile":"http://actrip.co.kr/'.$arrKakao["link3"].'"},"button4":{"type":"WL","name":"제휴업체 목록","url_mobile":"http://actrip.co.kr/'.$arrKakao["link3"].'"},"button5":{"type":"WL","name":"공지사항","url_mobile":"http://actrip.co.kr/'.$arrKakao["link3"].'"},';
	}

	$arryKakao = '';
    $arryKakao .= '['.$arryKakao.'{"message_type":"at","phn":"82'.substr(str_replace('-', '',$arrKakao["userPhone"]), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$arrKakao["tempName"].'","msg":"'.$arrKakao["kakaoMsg"].'",'.$btnList.'"smsKind":"L","msgSms":"'.$arrKakao["kakaoMsg"].'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$arrKakao["smsTitle"].'","smsOnly":"'.$arrKakao["smsOnly"].'"}]';
    
    return $arryKakao;
}
?>