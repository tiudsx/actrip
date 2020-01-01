<?php
header("Content-Type: text/html; charset=UTF-8");

header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.


  	$curl = curl_init();

echo '[{"userId":"surfenjoy","message_type":"at","phn":"821044370009","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"surfenjoy_res1","msg":"안녕하세요! 서프엔조이입니다.\n예약하신 [조아서프] 자동취소 안내입니다.\n\n서프엔조이 [조아서프] 예약정보\n ▶ 예약번호 : 3155355713292\n ▶ 예약자: 이승철\n ▶ 신청목록 : \n - [2019-03-26] 입문강습(9시) / 남:1 \n\n---------------------------------\n ▶안내사항\n - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n ▶문의\n - 010-3308-6080\n - http://pf.kakao.com/_HxmtMxl","button1":{"type":"WL","name":"자주묻는질문","url_mobile":"http://surfenjoy.com/surfFAQ"},"smsKind":"L","msgSms":"안녕하세요! 서프엔조이입니다.\n예약하신 [조아서프] 자동취소 안내입니다.\n\n서프엔조이 [조아서프] 예약정보\n ▶ 예약번호 : 3155355713292\n ▶ 예약자: 이승철\n ▶ 신청목록 : \n - [2019-03-26] 입문강습(9시) / 남:1 \n\n---------------------------------\n ▶안내사항\n - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n ▶문의\n - 010-3308-6080\n - http://pf.kakao.com/_HxmtMxl","smsSender":"01044370009","smsLmsTit":"서프엔조이 자동취소 안내","smsOnly":"N"}]';

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://alimtalk-api.bizmsg.kr/v2/sender/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => '[{"userId":"surfenjoy","message_type":"at","phn":"821044370009","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"surfenjoy_res1","msg":"안녕하세요! 서프엔조이입니다.\n예약하신 [조아서프] 자동취소 안내입니다.\n\n서프엔조이 [조아서프] 예약정보\n ▶ 예약번호 : 3155355713292\n ▶ 예약자: 이승철\n ▶ 신청목록 : \n - [2019-03-26] 입문강습(9시) / 남:1 \n\n---------------------------------\n ▶안내사항\n - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n ▶문의\n - 010-3308-6080\n - http://pf.kakao.com/_HxmtMxl","button1":{"type":"WL","name":"자주묻는질문","url_mobile":"http://surfenjoy.com/surfFAQ"},"smsKind":"L","msgSms":"안녕하세요! 서프엔조이입니다.\n예약하신 [조아서프] 자동취소 안내입니다.\n\n서프엔조이 [조아서프] 예약정보\n ▶ 예약번호 : 3155355713292\n ▶ 예약자: 이승철\n ▶ 신청목록 : \n - [2019-03-26] 입문강습(9시) / 남:1 \n\n---------------------------------\n ▶안내사항\n - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n ▶문의\n - 010-3308-6080\n - http://pf.kakao.com/_HxmtMxl","smsSender":"01044370009","smsLmsTit":"서프엔조이 자동취소 안내","smsOnly":"N"}]',
	  CURLOPT_HTTPHEADER => array(
		"content-type: application/json"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
?> 