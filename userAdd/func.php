<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.


function sendTel($gubun){
	$rtnVlu = "010-3308-6080";
	if($gubun == "이준영"){
		//$rtnVlu = "010-9990-9666";
		$rtnVlu = "010-8412-9699";
		//$rtnVlu = "010-3308-6080";
	}else if($gubun == "이준영2"){
		$rtnVlu = "010-8412-9699";
	}else if($gubun == "이승철"){
		$rtnVlu = "010-3308-6080";
	}

	return $rtnVlu;
}

function sendKakao($gubun, $tempName, $kakaoMsg, $userPhone, $ResNumber, $link1, $link2, $link3){
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
		$btnList = '"button1":{"type":"WL","name":"자주묻는질문","url_mobile":"http://surfenjoy.com/surfFAQ"},';
	}else if($tempName == "surfenjoy_res2"){
		$btnList = '"button1":{"type":"WL","name":"이용안내","url_mobile":"http://surfenjoy.com/'.$link1.'"},"button2":{"type":"WL","name":"예약조회/취소","url_mobile":"http://surfenjoy.com/ordersearch?resNumber='.$ResNumber.'"},"button3":{"type":"WL","name":"정류장안내","url_mobile":"http://surfenjoy.com/buspoint"},"button4":{"type":"WL","name":"자주묻는질문","url_mobile":"http://surfenjoy.com/surfFAQ"},';
	}else if($tempName == "surfenjoy_shop1"){
		$btnList = '"button1":{"type":"WL","name":"취소확인","url_mobile":"http://surfenjoy.com/surfadminkakao?MainNumber='.$ResNumber.'"},';
	}else if($tempName == "surfenjoy_shop2"){
		$btnList = '"button1":{"type":"WL","name":"승인처리","url_mobile":"http://surfenjoy.com/surfadminkakao?MainNumber='.$ResNumber.'"},';
	}else if($tempName == "surfenjoy_shop3"){
		$btnList = '"button1":{"type":"WL","name":"확정 확인","url_mobile":"http://surfenjoy.com/surfadminkakao?MainNumber='.$ResNumber.'"},';
	}else if($tempName == "surfenjoy_shop"){
		$btnList = '"button1":{"type":"WL","name":"예약목록","url_mobile":"http://surfenjoy.com/camplist"},"button2":{"type":"WL","name":"예약건 승인","url_mobile":"http://surfenjoy.com/'.$link1.'?MainNumber='.$ResNumber.'"},';
	}else if($tempName == "surfenjoy_busres1"){
		$btnList = '"button1":{"type":"WL","name":"이용안내","url_mobile":"http://surfenjoy.com/'.$link1.'"},"button2":{"type":"WL","name":"예약조회/취소","url_mobile":"http://surfenjoy.com/ordersearch?resNumber='.$ResNumber.'"},"button3":{"type":"WL","name":"정류장안내","url_mobile":"http://surfenjoy.com/buspoint"},"button4":{"type":"WL","name":"서핑버스 위치보기","url_mobile":"http://surfenjoy.com/busgps"},"button5":{"type":"WL","name":"자주묻는질문","url_mobile":"http://surfenjoy.com/surfFAQ"},';
	}else{
		if($gubun == "busStay1_sol"){
			$orderUrl = "solguestorder";
		}else{
			$orderUrl = "ordersearch";
		}
			$btnList = '"button1":{"type":"WL","name":"이용안내","url_mobile":"http://surfenjoy.com/'.$link1.'"},"button2":{"type":"WL","name":"예약조회/취소","url_mobile":"http://surfenjoy.com/'.$orderUrl.'?resNumber='.$ResNumber.'"},"button3":{"type":"WL","name":"자주묻는질문","url_mobile":"http://surfenjoy.com/surfFAQ"},';
	}

	$arryKakao .= '['.$arryKakao.'{"message_type":"at","phn":"82'.substr(str_replace('-', '',$userPhone), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$tempName.'","msg":"'.$kakaoMsg.'",'.$btnList.'"smsKind":"L","msgSms":"'.$kakaoMsg.'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$smsTitle.'","smsOnly":"N"}]';

/*
	if($gubun == "surfshop1" || $gubun == "surfshop3"){
		$arryKakao .= '['.$arryKakao.'{"userId":"surfenjoy","message_type":"at","phn":"82'.substr(str_replace('-', '',$userPhone), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$tempName.'","msg":"'.$kakaoMsg.'","button1":{"type":"WL","name":"예약목록","url_mobile":"http://surfenjoy.com/surfshopadmin"},"button2":{"type":"WL","name":"예약건 승인","url_mobile":"http://surfenjoy.com/surfadminkakao?MainNumber='.$ResNumber.'"},"smsKind":"L","msgSms":"'.$kakaoMsg.'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$smsTitle.'","smsOnly":"N"}]';
	}else if($gubun == "campshop1" || $gubun == "campshop2" || $gubun == "campshop3"){
		$arryKakao .= '['.$arryKakao.'{"userId":"surfenjoy","message_type":"at","phn":"82'.substr(str_replace('-', '',$userPhone), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$tempName.'","msg":"'.$kakaoMsg.'","button1":{"type":"WL","name":"예약목록","url_mobile":"http://surfenjoy.com/camplist"},"button2":{"type":"WL","name":"예약건 승인","url_mobile":"http://surfenjoy.com/'.$link1.'?MainNumber='.$ResNumber.'"},"smsKind":"L","msgSms":"'.$kakaoMsg.'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$smsTitle.'","smsOnly":"N"}]';
	}else{
		if($tempName == "surfenjoy_res1"){
			$btnList = '"button1":{"type":"WL","name":"자주묻는질문","url_mobile":"http://surfenjoy.com/surfFAQ"},';
		}else{
			$btnList = '"button1":{"type":"WL","name":"이용안내","url_mobile":"http://surfenjoy.com/'.$link1.'"},"button2":{"type":"WL","name":"예약조회/취소","url_mobile":"http://surfenjoy.com/ordersearch?resNumber='.$ResNumber.'"},"button3":{"type":"WL","name":"자주묻는질문","url_mobile":"http://surfenjoy.com/surfFAQ"},';
		}

		$arryKakao .= '['.$arryKakao.'{"userId":"surfenjoy","message_type":"at","phn":"82'.substr(str_replace('-', '',$userPhone), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$tempName.'","msg":"'.$kakaoMsg.'",'.$btnList.'"smsKind":"L","msgSms":"'.$kakaoMsg.'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$smsTitle.'","smsOnly":"N"}]';
	}
*/
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

function sendMail($EMAIL, $NAME, $CONTENT, $mailto, $arrMail){
	$admin_email = $EMAIL;
	$admin_name  = $NAME;

	$header  = "Return-Path: ".$admin_email."\n";
	$header .= "From: =?EUC-KR?B?".base64_encode($admin_name)."?= <".$admin_email.">\n";
	$header .= "MIME-Version: 1.0\n";
	$header .= "X-Priority: 3\n";
	$header .= "X-MSMail-Priority: Normal\n";
	$header .= "X-Mailer: FormMailer\n";
	$header .= "Content-Transfer-Encoding: base64\n";
	$header .= "Content-Type: text/html;\n \tcharset=UTF-8\n";

	if($arrMail["campStayName"] == "campStay1"){
		$subject = "[서프엔조이] 죽도야영장 예약안내 - 입금대기 (".$arrMail["userName"]."/".$arrMail["selDate"]."~".$arrMail["lastDate"].")";
	}else if($arrMail["campStayName"] == "campStay2"){
		$subject = "[서프엔조이] 죽도글램핑 예약안내 - 입금대기 (".$arrMail["userName"]."/".$arrMail["selDate"]."~".$arrMail["lastDate"].")";
	}else if($arrMail["campStayName"] == "campOk1"){
		$subject = "[서프엔조이] 죽도야영장 예약안내 - 예약확정 (".$arrMail["userName"]."/".$arrMail["selDate"]."~".$arrMail["lastDate"].")";
	}else if($arrMail["campStayName"] == "campCancel1"){
		$subject = "[서프엔조이] 죽도야영장 예약안내 - 환불요청 (".$arrMail["userName"].")";
	}else if($arrMail["campStayName"] == "busStay1"){
		$subject = "[서프엔조이] 양양셔틀버스 예약안내 - 입금대기 (".$arrMail["userName"].")";
	}else if($arrMail["campStayName"] == "busConfirm1"){
		$subject = "[서프엔조이] 양양셔틀버스 예약안내 - 예약확정 (".$arrMail["userName"].")";
	}else if($arrMail["campStayName"] == "busCancel1"){
		$subject = "[서프엔조이] 양양셔틀버스 예약안내 - 취소/환불요청 (".$arrMail["userName"].")";
	}else if($arrMail["campStayName"] == "surfRes1"){
		$subject = "[서프엔조이] ".$arrMail['gubun']." 예약안내 - 입금대기 (".$arrMail["userName"].")";
	}else if($arrMail["campStayName"] == "surfshop1"){
		$subject = "[서프엔조이] ".$arrMail['gubun']." 예약안내 - 예약확정 (".$arrMail["userName"].")";
	}else if($arrMail["campStayName"] == "surfshop2"){
		$subject = "[서프엔조이] ".$arrMail['gubun']." 예약안내 - 임시취소 (".$arrMail["userName"].")";
	}else if($arrMail["campStayName"] == "surfshop3"){
		$subject = "[서프엔조이] ".$arrMail['gubun']." 예약안내 - 입금완료 (".$arrMail["userName"].")";
	}else if($arrMail["campStayName"] == "surfCancel1"){
		$subject = "[서프엔조이] ".$arrMail['gubun']." 예약안내 - 취소/환불요청 (".$arrMail["userName"].")";
	}else if($arrMail["campStayName"] == "surfbank"){
		$subject = "[서프엔조이] ".$arrMail['gubun']." - 동일 금액, 입금자명 확인필요";
	}else if($arrMail["campStayName"] == "surfbanknone"){
		$subject = "[서프엔조이] ".$arrMail['gubun']." - 주문내역없음 확인필요";
	}else if($arrMail["campStayName"] == "yangbanknone"){
		$subject = "[입금오류] ".$arrMail['gubun']." - 입금내역과 일치하는 예약내역이 없음.";
	}else if($arrMail["campStayName"] == "yangbank"){
		$subject = "[예약중복] ".$arrMail['gubun']." - 동일 예약자명 존재. 확인필요.";
	}

	$message = base64_encode($CONTENT);
	flush();
	@mail($mailto, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
}

function sendMailContentSurf($arrMail){
	$title = "예약안내";
	$subtitle = "예약해 주셔서 진심으로 감사드립니다.";
	if($arrMail['campStayName'] == "surfCancel1"){
		$title = "환불요청안내";
		$subtitle = "다음에 이용부탁드립니다. 감사드립니다.";
	}

	$contents = "<table width='720' align='center' border='0' cellspacing='0' cellpadding='0'>
    <tbody>
        <tr>
            <td height='58' valign='bottom' style='padding-bottom: 2px;'>
                <a href='http://surfenjoy.com/' target='_blank'><img alt='' src='http://skinnz.godohosting.com/surfenjoy/logo/surfenjoylogo.png' border='0'></a>
            </td>
        </tr>
		<tr>
			<td style='height: 3px; line-height: 0; font-size: 0px; background-color: rgb(83, 83, 83);'>&nbsp;</td>
		</tr>
        <tr>
            <td><br>
                <span style='color: rgb(51, 51, 51); font-family:굴림체; font-size: 30px; font-weight: bold;'>서프엔조이 ".$title." 메일입니다.</span><br>
				<p style='color: rgb(51, 51, 51); font-family: ; font-size: 16px; font-weight: bold; margin-bottom: 11px;'>안녕하세요. <strong>".$arrMail['userName']."</strong> 고객님.</p>
				".$arrMail['gubun']."를(을) ".$subtitle."				
            </td>
        </tr>
        <tr>
            <td height='35'></td>
        </tr>
        <tr>
            <td style=\"background: url('http://www.smartix.co.kr/joinmail_img/bg.gif') no-repeat right bottom; padding-bottom: 10px;\">
                <img src='http://www.smartix.co.kr/joinmail_img/05.png'>
                <b>예약정보</b></td>
        </tr>
        <tr>
            <td style='padding-top: 7px;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tbody>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 예&nbsp;약&nbsp;자 </td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['userName']." (".$arrMail['userPhone'].")</td>
                        </tr>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 예약번호</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='color: rgb(222, 119, 118); padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['ResNumber']." <a href='http://surfenjoy.com/ordersearch?resNumber=".$arrMail['ResNumber']."' target='_blank'>[예약조회]</a>
                            </td>
                        </tr>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 신청목록</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px;padding-top: 8px;padding-bottom: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['surfInfo']."</td>
                        </tr>";
if(!($arrMail['campStayName'] == "surfCancel1")){
           $contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 특이사항</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; padding-top:5px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'><textarea name='etc' id='etc' style='margin: 0px; width: 97%; height: 80px; resize: none;' rows='8' cols='42' disabled='disabled'>".$arrMail['etc']."</textarea></td>
                        </tr>";
}

if(!($arrMail['memo'] == "")){
           $contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 메모</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; padding-top:5px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'><textarea name='memo' id='memo' style='margin: 0px; width: 97%; height: 80px; resize: none;' rows='8' cols='42' disabled='disabled'>".$arrMail['memo']."</textarea></td>
                        </tr>";
}

if($arrMail['campStayName'] == "surfshop1" || $arrMail['campStayName'] == "surfshop2"){
           $contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 샵정보</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px;padding-top: 8px;padding-bottom: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['surfInfoAddr']."</td>
                        </tr>";
}

if(!($arrMail['campStayName'] == "surfRes1" || $arrMail['campStayName'] == "surfCancel1")){
			$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 문의전화</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'> ".sendTel('이승철')."</td>
                        </tr>
						<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 플러스친구</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'><a href='http://pf.kakao.com/_HxmtMxl' target='_blank'>http://pf.kakao.com/_HxmtMxl</a></td>
                        </tr>";
}

$contents .= "		</tbody>
               </table>
            </td>
        </tr>
		<tr>
            <td height='35'></td>
        </tr>";

if($arrMail['campStayName'] == "surfCancel1"){
$contents .= "<tr>
            <td style=\"background: url('http://www.smartix.co.kr/joinmail_img/bg.gif') no-repeat right bottom; padding-bottom: 10px;\">
                <img src='http://www.smartix.co.kr/joinmail_img/05.png'>
                <b>결제정보</b></td>
        </tr>
        <tr>
            <td style='padding-top: 7px;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tbody>
                        <tr>
							<td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 환불금액</td>
							<td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
								<img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
							<td style='color: rgb(222, 119, 118); padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['totalPrice']."</td>
						</tr>
						<tr>
							<td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 환불계좌</td>
							<td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
								<img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
							<td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'><font color='#8000ff'><b>".$arrMail['banknum']."</b></font>
							</td>
						</tr>
						<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 문의전화</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'> ".sendTel('이승철')."</td>
                        </tr>
						<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 플러스친구</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'><a href='http://pf.kakao.com/_HxmtMxl' target='_blank'>http://pf.kakao.com/_HxmtMxl</a></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>";

}

if($arrMail['campStayName'] == "surfRes1"){
$contents .= "<tr>
            <td style=\"background: url('http://www.smartix.co.kr/joinmail_img/bg.gif') no-repeat right bottom; padding-bottom: 10px;\">
                <img src='http://www.smartix.co.kr/joinmail_img/05.png'>
                <b>결제정보</b></td>
        </tr>
        <tr>
            <td style='padding-top: 7px;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tbody>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 입금계좌</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'><font color='#8000ff'><b>".$arrMail['banknum']."</b></font>
                            </td>
                        </tr>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 입금금액</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='color: rgb(222, 119, 118); padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['totalPrice']."</td>
                        </tr>
						<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 문의전화</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'> ".sendTel('이승철')."</td>
                        </tr>
						<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 플러스친구</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'><a href='http://pf.kakao.com/_HxmtMxl' target='_blank'>http://pf.kakao.com/_HxmtMxl</a></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>";
}

$contents .= "<tr>
            <td height='30' align='center' style='padding: 10px 0px 30px;'><a href='http://surfenjoy.com/ordersearch?resNumber=".$arrMail['ResNumber']."' target='_blank'>
                <img src='http://www.smartix.co.kr/joinmail_img/03.png' border='0'></a>
            </td>
        </tr>
        <tr>
            <td style='height: 3px; line-height: 0; font-size: 0px; background-color: rgb(83, 83, 83);'>&nbsp;</td>
        </tr>
        <tr>
            <td align='center' style='padding-top: 25px; font-family: ;'>본 메일은 <span style='color: rgb(235, 75, 95);'>발신전용</span> 메일이므로 회신되지 않습니다.</td>
        </tr>
    </tbody>
</table>";

	return $contents;
}

function sendMailContent($arrMail){
	$title = "예약안내";
	$subtitle = "예약해 주셔서 진심으로 감사드립니다.";
	if($arrMail['campStayName'] == "campCancel1"){
		$title = "환불요청안내";
		$subtitle = "다음에 이용부탁드립니다. 감사드립니다.";
	}

	$contents = "<table width='720' align='center' border='0' cellspacing='0' cellpadding='0'>
    <tbody>
        <tr>
            <td height='58' valign='bottom' style='padding-bottom: 2px;'>
                <a href='http://surfenjoy.com/' target='_blank'><img alt='' src='http://skinnz.godohosting.com/surfenjoy/logo/surfenjoylogo.png' border='0'></a>
            </td>
        </tr>
		<tr>
			<td style='height: 3px; line-height: 0; font-size: 0px; background-color: rgb(83, 83, 83);'>&nbsp;</td>
		</tr>
        <tr>
            <td><br>
                <span style='color: rgb(51, 51, 51); font-family:굴림체; font-size: 30px; font-weight: bold;'>서프엔조이 ".$title." 메일입니다.</span><br>
				<p style='color: rgb(51, 51, 51); font-family: ; font-size: 16px; font-weight: bold; margin-bottom: 11px;'>안녕하세요. <strong>".$arrMail['userName']."</strong> 고객님.</p>
				죽도 ".$arrMail['gubun']."을 ".$subtitle."				
            </td>
        </tr>
        <tr>
            <td height='35'></td>
        </tr>
        <tr>
            <td style=\"background: url('http://www.smartix.co.kr/joinmail_img/bg.gif') no-repeat right bottom; padding-bottom: 10px;\">
                <img src='http://www.smartix.co.kr/joinmail_img/05.png'>
                <b>예약정보</b></td>
        </tr>
        <tr>
            <td style='padding-top: 7px;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tbody>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 예&nbsp;약&nbsp;자 </td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['userName']." (".$arrMail['userPhone'].")</td>
                        </tr>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 예약번호</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='color: rgb(222, 119, 118); padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['ResNumber']." <a href='http://surfenjoy.com/ordersearch?resNumber=".$arrMail['ResNumber']."' target='_blank'>[예약조회]</a>
                            </td>
                        </tr>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 예약장소</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>죽도해변 ".$arrMail['gubun']."</td>
                        </tr>";
		if($arrMail['campStayName'] != "campCancel1"){
			$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 이용일</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['selDate']." 오후 2시 ~ ".$arrMail['lastDate']." 오후 12시까지</td>
                        </tr>";
		}
			$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 예약위치</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['location']."</td>
                        </tr>";
		if($arrMail['campStayName'] != "campCancel1"){
			$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 특이사항</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; padding-top:5px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'><textarea name='etc' id='etc' style='margin: 0px; width: 97%; height: 80px; resize: none;' rows='8' cols='42' disabled='disabled'>".$arrMail['etc']."</textarea></td>
                        </tr>";
		}
		$contents .= "</tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td height='35'></td>
        </tr>
        <tr>
            <td style=\"background: url('http://www.smartix.co.kr/joinmail_img/bg.gif') no-repeat right bottom; padding-bottom: 10px;\">
                <img src='http://www.smartix.co.kr/joinmail_img/05.png'>
                <b>결제정보</b></td>
        </tr>
        <tr>
            <td style='padding-top: 7px;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tbody>";

		if(!($arrMail['campStayName'] == "campOk1" || $arrMail['campStayName'] == "campCancel1")){
			$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 입금계좌</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'><font color='#8000ff'><b>".$arrMail['banknum']."</b></font>
                            </td>
                        </tr>
						<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 입금금액</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='color: rgb(222, 119, 118); padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['totalPrice']."</td>
                        </tr>";
		}
		if($arrMail['campStayName'] == "campCancel1"){
			$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 환불금액</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='color: rgb(222, 119, 118); padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['totalPrice']."</td>
                        </tr>
						<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 환불계좌</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'><font color='#8000ff'><b>".$arrMail['banknum']."</b></font>
                            </td>
                        </tr>";
		}
		if($arrMail['gubun'] == "야영장"){
			$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 문의전화</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'> ".sendTel('이준영')."</td>
                        </tr>";
		}
           	$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 플러스친구</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'><a href='http://pf.kakao.com/_HxmtMxl' target='_blank'>http://pf.kakao.com/_HxmtMxl</a></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td height='30' align='center' style='padding: 10px 0px 30px;'><a href='http://surfenjoy.com/ordersearch?resNumber=".$arrMail['ResNumber']."' target='_blank'>
                <img src='http://www.smartix.co.kr/joinmail_img/03.png' border='0'></a>
            </td>
        </tr>
        <tr>
            <td style='height: 3px; line-height: 0; font-size: 0px; background-color: rgb(83, 83, 83);'>&nbsp;</td>
        </tr>
        <tr>
            <td align='center' style='padding-top: 25px; font-family: ;'>본 메일은 <span style='color: rgb(235, 75, 95);'>발신전용</span> 메일이므로 회신되지 않습니다.</td>
        </tr>
    </tbody>
</table>";

	return $contents;
}

function sendMailContentBus($arrMail){
	$addText1 = " 참석";
	$addText2 = "";
	if($arrMail["campStayName"] == "busCancel1"){
		$addText1 = " 취소";
		$addText2 = "취소 ";
	}

	$contents = "<table width='720' align='center' border='0' cellspacing='0' cellpadding='0'>
    <tbody>
        <tr>
            <td height='58' valign='bottom' style='padding-bottom: 2px;'>
                <a href='http://surfenjoy.com/' target='_blank'><img alt='' src='http://skinnz.godohosting.com/surfenjoy/logo/surfenjoylogo.png' border='0'></a>
            </td>
        </tr>
		<tr>
			<td style='height: 3px; line-height: 0; font-size: 0px; background-color: rgb(83, 83, 83);'>&nbsp;</td>
		</tr>
        <tr>
            <td><br>
                <span style='color: rgb(51, 51, 51); font-family:굴림체; font-size: 30px; font-weight: bold;'>서프엔조이 예약안내 메일입니다.</span><br>
				<p style='color: rgb(51, 51, 51); font-family: ; font-size: 16px; font-weight: bold; margin-bottom: 11px;'>안녕하세요. <strong>".$arrMail['userName']."</strong> 고객님.</p>
				".$arrMail['gubun']."를 예약해 주셔서 진심으로 감사드립니다.				
            </td>
        </tr>
        <tr>
            <td height='35'></td>
        </tr>
        <tr>
            <td style=\"background: url('http://www.smartix.co.kr/joinmail_img/bg.gif') no-repeat right bottom; padding-bottom: 10px;\">
                <img src='http://www.smartix.co.kr/joinmail_img/05.png'>
                <b>예약정보</b></td>
        </tr>
        <tr>
            <td style='padding-top: 7px;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tbody>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 예&nbsp;약&nbsp;자 </td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['userName']." (".$arrMail['userPhone'].")</td>
                        </tr>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 예약번호</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='color: rgb(222, 119, 118); padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['ResNumber']." <a href='http://surfenjoy.com/ordersearch?resNumber=".$arrMail['ResNumber']."' target='_blank'>[예약조회]</a>
                            </td>
                        </tr>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- ".$addText2."좌석안내</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px;padding-top: 8px;padding-bottom: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['busSeatInfo']."</td>
                        </tr>";
		if($arrMail["campStayName"] != "busCancel1"){
			$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 탑승시간/위치 안내</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px;padding-top: 8px;padding-bottom: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['busStopInfo']."</td>
                        </tr>";
		}

		if($arrMail['SurfBBQMem'] > 0){
			$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 바베큐 ".$addText1."</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>[".$arrMail['SurfBBQ']."] ".$arrMail['SurfBBQMem']."명</td>
                        </tr>";
		}
           $contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 특이사항</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; padding-top:5px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'><textarea name='etc' id='etc' style='margin: 0px; width: 97%; height: 80px; resize: none;' rows='8' cols='42' disabled='disabled'>".$arrMail['etc']."</textarea></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>";

if($arrMail["campStayName"] == "busStay1"){
$contents .= "<tr>
            <td height='35'></td>
        </tr>
        <tr>
            <td style=\"background: url('http://www.smartix.co.kr/joinmail_img/bg.gif') no-repeat right bottom; padding-bottom: 10px;\">
                <img src='http://www.smartix.co.kr/joinmail_img/05.png'>
                <b>결제정보</b></td>
        </tr>
        <tr>
            <td style='padding-top: 7px;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tbody>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 입금계좌</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'><font color='#8000ff'><b>".$arrMail['banknum']."</b></font>
                            </td>
                        </tr>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 입금금액</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='color: rgb(222, 119, 118); padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['totalPrice']."</td>
                        </tr>";
           	$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 플러스친구</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'><a href='http://pf.kakao.com/_HxmtMxl' target='_blank'>http://pf.kakao.com/_HxmtMxl</a></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>";
}else if($arrMail["campStayName"] == "busCancel1"){
$contents .= "<tr>
            <td height='35'></td>
        </tr>
        <tr>
            <td style=\"background: url('http://www.smartix.co.kr/joinmail_img/bg.gif') no-repeat right bottom; padding-bottom: 10px;\">
                <img src='http://www.smartix.co.kr/joinmail_img/05.png'>
                <b>환불정보</b></td>
        </tr>
        <tr>
            <td style='padding-top: 7px;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tbody>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 환불금액</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['totalPrice']."
                            </td>
                        </tr>
                        <tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 환불계좌</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>".$arrMail['banknum']."
                            </td>
                        </tr>";
           	$contents .= "<tr>
                            <td width='130' height='27' style='padding-left: 8px; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>- 플러스친구</td>
                            <td width='1' style='border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;'>
                                <img src='http://www.smartix.co.kr/joinmail_img/tap.gif'></td>
                            <td style='padding-left: 15px; font-weight: bold; border-bottom-color: rgb(226, 226, 226); border-bottom-width: 1px; border-bottom-style: solid;' height='45'><a href='http://pf.kakao.com/_HxmtMxl' target='_blank'>http://pf.kakao.com/_HxmtMxl</a></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>";

}

$contents .= "<tr>
            <td height='30' align='center' style='padding: 10px 0px 30px;'><a href='http://surfenjoy.com/ordersearch?resNumber=".$arrMail['ResNumber']."' target='_blank'>
                <img src='http://www.smartix.co.kr/joinmail_img/03.png' border='0'></a>
            </td>
        </tr>
        <tr>
            <td style='height: 3px; line-height: 0; font-size: 0px; background-color: rgb(83, 83, 83);'>&nbsp;</td>
        </tr>
        <tr>
            <td align='center' style='padding-top: 25px; font-family: ;'>본 메일은 <span style='color: rgb(235, 75, 95);'>발신전용</span> 메일이므로 회신되지 않습니다.</td>
        </tr>
    </tbody>
</table>";

	return $contents;
}

function fnReturnText($gubun, $display){
	$rtn = '
		<div style="margin-top:3px;margin-bottom:3px;display:'.$display.';" id="tbInfo1">
		<div class="gg_first">취소/환불 안내</div>
			<div style="margin-top:3px;margin-bottom:3px;">
				<table class="et_vars exForm bd_tb" width="100%">
					<colgroup>
						<col style="width:118px;">
						<col style="width:*;">
					</colgroup>
					<tbody>';
	if($gubun == 1){
		$rtn .= '
						<tr>
							<th colspan="2">
								<strong>취소/환불 규정안내
								<br><br><span style="padding-left:0px;">재정경제부 고시 예약/취소 환불정책을 준수하고 있습니다.</span>
							</th>
						</tr>';
	}

	$rtn .= '
						<tr>
							<th scope="row">이용 9일 전</th>
							<td>총 결제금액의 100% 환불</td>
						</tr>
						<tr>
							<th scope="row">
								이용 8일 전
							</th>
							<td>총 결제금액의 90% 환불</td>
						</tr>
						<tr>
							<th scope="row">
								이용 7일 전
							</th>
							<td>총 결제금액의 80% 환불</td>
						</tr>
						<tr>
							<th scope="row">이용 6일 전</th>
							<td>총 결제금액의 70% 환불</td>
						</tr>
						<tr>
							<th scope="row">이용 5일 전</th>
							<td>총 결제금액의 60% 환불</td>
						</tr>
						<tr>
							<th scope="row">이용 4일 전</th>
							<td>총 결제금액의 50% 환불</td>
						</tr>
						<tr>
							<th scope="row">이용 3일 전</th>
							<td>총 결제금액의 40% 환불</td>
						</tr>
						<tr>
							<th scope="row">이용 2일 전</th>
							<td>총 결제금액의 30% 환불</td>
						</tr>
						<tr>
							<th scope="row">이용 당일~이용 1일 전</th>
							<td>취소 및 환불 불가</td>
						</tr>
						<tr>
							<td colspan="2">▶ 8일전 확정예약 후 취소시 위의 취소수수료가 부과되므로 신중히 예약하시기 바랍니다.<br>▶ 단, 확정예약 후 2시간 이내 취소시 수수료가 없습니다.</td>
						</tr>';

	if($gubun == 1){
		$rtn .= '
						<tr>
							<th colspan="2">
								<input type="checkbox" id="chk7" name="chk7"> <strong>취소/환불 규정에 대한 동의</strong> (필수동의)
							</th>
						</tr>';
	}
	$rtn .= '
					</tbody>
				</table>
			</div>
		</div>';

	return $rtn;
}

function fnInfoMemo($gubun, $display){
	if($gubun == 0){
		$rtn = '
		<div style="margin-top:3px;margin-bottom:3px;display:'.$display.';" id="tbInfo2">
			<div class="gg_first">죽도야영장 운영안내 </div>
			<div style="margin-top:3px;margin-bottom:3px;">
			<table class="et_vars exForm bd_tb" width="100%">
				<tbody>
					<tr>
						<td colspan="3">
		 ▶ 입/퇴실 안내<br/>
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;입실 : 오후 2시 / 퇴실 : 익일 오후 12시<br />

						</td>
					</tr>
					<tr>
						<th style="text-align:center;" rowspan="2"><strong>이용기간</strong></th>
						<th style="text-align:center;" colspan="2"><strong>야영장 이용요금</strong></th>
					</tr>
					<tr>
						<th style="text-align:center;"><strong>C구역</strong></th>
						<th style="text-align:center;"><strong>D구역</strong></th>
					</tr>
					<tr>
						<td width="40%" style="text-align:center;">비수기<br>(3월 ~ 6월, 9월 ~ 11월)</td>
						<td width="30%" style="text-align:center;">30,000원</td>
						<td width="30%" style="text-align:center;">20,000원</td>
					</tr>
					<tr>
						<td style="text-align:center;">성수기<br>(7월 ~ 8월)</td>
						<td style="text-align:center;">40,000원</td>
						<td style="text-align:center;">30,000원</td>
					</tr>
				</tbody>
			</table>
			</div>

			<table class="et_vars exForm bd_tb" width="100%">
				<tbody>
					<tr>
						<td>
			<div class="gg_first" style="padding-left:5px;font-size:17px;margin-top:0px;">서프엔조이 고객센터</div>
			<div style="padding-bottom:15px;padding-left:5px;font-size:12px;line-height: 25px;">
				<strong>문의전화 : '.sendTel('이준영').'</strong><br>
				<strong>입금계좌 : 농협 / 351-1079-6271-13 / 전동한</strong><br>
				<a href="http://pf.kakao.com/_HxmtMxl" target="_blank" style="padding-top:5px;"><img src="http://skinnz.godohosting.com/surfenjoy/button/KakaoTalk_link.png" class="placeholder3"/></a>
			</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="et_vars exForm bd_tb" width="100%" style="display:none;">
				<tbody>
					<tr>
						<td>
<strong>무통장입금 계좌안내</strong><br>
&nbsp;&nbsp;&nbsp;▶ 야영장 : 농협 / 351-1079-6271-13 / 전동한 <br>
<!--&nbsp;&nbsp;&nbsp;▶ 글램핑 : 신한은행 / 389-02-188735 / 이승철 <br>--><br>

<strong>연락처 안내</strong><br>
&nbsp;&nbsp;&nbsp;▶ 연락처 : '.sendTel('이준영').' <br>
&nbsp;&nbsp;&nbsp;▶ 카카오톡 플러스친구 : <a href="http://pf.kakao.com/_HxmtMxl" target="_blank" style="float:none;">http://pf.kakao.com/_HxmtMxl</a><br><br>

<!--strong>★ 필독 사항★</strong><br>
&nbsp;&nbsp;&nbsp;예약신청 후 바로 입금 부탁드립니다.<br>
&nbsp;&nbsp;&nbsp;1시간 이내 미입금시 예약은 취소될 수 있습니다. <br-->

						</td>
					</tr>
				</tbody>
			</table>
		</div>

		';
	}else if($gubun == 1){
		$rtn = '
		<div style="margin-top:3px;margin-bottom:3px;display:'.$display.';" id="tbInfo2">
			<div class="gg_first">양양 셔틀버스 운영안내 </div>
			<div style="margin-top:3px;margin-bottom:3px;">
			<table class="et_vars exForm bd_tb" width="100%">
				<tbody>
					<tr>
						<td colspan="3">
		 ▶ 양양 셔틀버스 운행기간 : 5월 ~ 9월<br>
		 ▶ 죽도해변 루프탑 바베큐 파티 : 5월 ~ 9월<br/>
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;오후 7시 30분 ~ 오후 10시<br />

						</td>
					</tr>
					<tr>
						<th style="text-align:center;"><strong>죽도해변<br> 루프탑 바베큐 파티</strong></th>
						<th style="text-align:center;" colspan="2"><strong>양양 셔틀버스 이용요금</strong></th>
					</tr>
					<tr>
						<td width="30%" style="text-align:center;"><strong>1인 : 25,000원</strong></td>
						<td style="text-align:center;"><strong>편도 : 20,000원</strong></td>
						<td style="text-align:center;"><strong>왕복 : 35,000원</strong></td>
					</tr>
				</tbody>
			</table>
			</div>
			<table class="et_vars exForm bd_tb" width="100%">
				<tbody>
					<tr>
						<td>
<strong>무통장입금 계좌안내</strong><br>
&nbsp;&nbsp;&nbsp;▶ 신한은행 / 389-02-188735 / 이승철 <br><br>

<strong>문의 안내</strong><br>
&nbsp;&nbsp;&nbsp;▶ 카카오톡 플러스친구 : <a href="http://pf.kakao.com/_HxmtMxl" target="_blank" style="float:none;">http://pf.kakao.com/_HxmtMxl</a><br><br>

<!--strong>★ 필독 사항★</strong><br>
&nbsp;&nbsp;&nbsp;예약신청 후 바로 입금 부탁드립니다.<br>
&nbsp;&nbsp;&nbsp;1시간 이내 미입금시 예약은 취소될 수 있습니다. <br-->

						</td>
					</tr>
				</tbody>
			</table>
		</div>';
	}else if($gubun == 3){
		$rtn = '
			<div class="gg_first" style="padding-left:5px;font-size:17px;">서프엔조이 고객센터</div>
			<div style="padding-bottom:15px;padding-left:5px;font-size:12px;line-height: 25px;">
				<strong>문의전화 : 010-3308-6080</strong><br>
				<strong>입금계좌 : 신한은행 / 389-02-188735 / 이승철</strong><br>
				<a href="http://pf.kakao.com/_HxmtMxl" target="_blank"><img src="http://skinnz.godohosting.com/surfenjoy/button/KakaoTalk_link.png" class="placeholder3"/></a>
			</div>';
	}else if($gubun == 2){
		$rtn = '
		<div style="margin-top:3px;margin-bottom:3px;display:'.$display.';" id="tbInfo2">
			<div class="gg_first">입금 계좌안내 </div>
			<table class="et_vars exForm bd_tb" width="100%">
				<tbody>
					<tr>
						<td>
<strong>무통장입금 계좌안내</strong><br>
&nbsp;&nbsp;&nbsp;▶ 신한은행 / 389-02-188735 / 이승철 <br><br>

<strong>문의 안내</strong><br>
&nbsp;&nbsp;&nbsp;▶ 카카오톡 플러스친구 : <a href="http://pf.kakao.com/_HxmtMxl" target="_blank" style="float:none;">http://pf.kakao.com/_HxmtMxl</a><br><br>

<!--strong>★ 필독 사항★</strong><br>
&nbsp;&nbsp;&nbsp;예약신청 후 바로 입금 부탁드립니다.<br>
&nbsp;&nbsp;&nbsp;1시간 이내 미입금시 예약은 취소될 수 있습니다. <br-->

						</td>
					</tr>
				</tbody>
			</table>
		</div>';
	}
	return $rtn;
}

function fnBusNum($vlu){
	$busGubun = substr($vlu, 0, 1);
	$busNumber = substr($vlu, 1, 1);

	if($busGubun == 'Y'){
		return '양양행 '.$busNumber.'호차';
	}else{
		return '서울행 '.$busNumber.'호차';
	}
}

function fnBusReturnPoint($vlu, $busNumber, $gubun){
	if($vlu == '남애3리'){
		$rtnVlu =  '남애해변|남애3리 입구|남애3리';
	}else if($vlu == '인구'){
		$rtnVlu =  '인구해변|현남보건지소 앞|현남보건지소';
	}else if($vlu == '죽도'){
		$rtnVlu =  '죽도해변|하나로마트 또는 GS편의점 앞|두창시변리마을노인회관';
	}else if($vlu == '동산항'){
		$rtnVlu =  '동산항해변|모닝비치 가기전 굴다리 밑|모닝비치';
	}else if($vlu == '기사문'){
		$rtnVlu =  '기사문해변|기사문 해변주차장 입구|기사문해변';
	}else if($vlu == '하조대'){
		$rtnVlu =  '하조대해변|서피비치 회전교차로 횡단보도 앞|서피비치주차장';
	}else if($vlu == '주문진'){
		$rtnVlu =  '주문진해변|청시행비치 주차장 입구 사거리|청시행비치';
	}else if($vlu == '동호'){
		$rtnVlu =  '15:05|동호해변 버스정류장';
	}else if($vlu == '설악'){
		$rtnVlu =  '15:15|설악해변 주차장입구';
	}

	return $rtnVlu;
}

function fnBusPoint($vlu, $busNumber, $gubun){
	$rtnVlu = '|';
	if($busNumber == "Y1" || $busNumber == "Y5"){
		if($vlu == '여의도'){
			$rtnVlu =  '05:40|여의도공원 횡단보도';
		}else if($vlu == '신도림'){
			$rtnVlu =  '05:50|홈플러스 신도림점 앞';
		}else if($vlu == '구로디지털단지'){
			$rtnVlu =  '06:05|동대문엽기떡볶이 앞 버스정류장';
		}else if($vlu == '봉천역'){
			$rtnVlu =  '06:20|봉천역 1번출구 앞';
		}else if($vlu == '사당역'){
			$rtnVlu =  '06:30|사당역 6번출구 방향 신한성약국 앞';
		}else if($vlu == '강남역'){
			$rtnVlu =  '06:45|강남역 1번출구 버스정류장';
		}else if($vlu == '종합운동장역'){
			$rtnVlu =  '07:00|종합운동장역 4번출구 방향 버스정류장';
		}
	}else if($busNumber == "Y2" || $busNumber == "Y6"){
		if($vlu == '당산역'){
			$rtnVlu =  '05:40|당산역 13출구 IBK기업은행 앞';
		}else if($vlu == '합정역'){
			$rtnVlu =  '05:45|합정역 3번출구 앞';
		}else if($vlu == '신촌역'){
			$rtnVlu =  '05:55|신촌역 5번출구 앞';
		}else if($vlu == '충정로역'){
			$rtnVlu =  '06:05|충정로역 4번출구 앞';
		}else if($vlu == '종로3가역'){
			$rtnVlu =  '06:20|종로3가역 12번출구 방향 새마을금고 앞';
		}else if($vlu == '왕십리역'){
			$rtnVlu =  '06:40|왕십리역 11번출구 방향 우리은행 앞';
		}else if($vlu == '건대입구역'){
			$rtnVlu =  '07:00|건대입구역 롯데백화점 스타시티점 입구';
		}
	}else if($busNumber == "Y3" || $busNumber == "Y7"){
		if($vlu == '목동역'){
			$rtnVlu =  '05:30|목동역 5번출구 방향 버스정류장';
		}else if($vlu == '영등포역'){
			$rtnVlu =  '05:45|영등포역입구 택시승강장 뒤쪽';
		}else if($vlu == '흑석역'){
			$rtnVlu =  '06:05|흑석역 3번출구 CU편의점 앞';
		}else if($vlu == '신반포역'){
			$rtnVlu =  '06:15|신반포역 4번출구';
		}else if($vlu == '논현역'){
			$rtnVlu =  '06:25|논현역 1번출구 영동가구 앞';
		}else if($vlu == '강남구청역'){
			$rtnVlu =  '06:35|강남구청역 1번출구';
		}else if($vlu == '종합운동장역'){
			$rtnVlu =  '07:00|종합운동장역 4번출구 방향 버스정류장';
		}
	}else if($busNumber == "Y4" || $busNumber == "Y8"){
		if($vlu == '시청역'){
			$rtnVlu =  '06:00|시청역 2번출구';
		}else if($vlu == '신용산역'){
			$rtnVlu =  '06:20|신용산역 4번출구';
		}else if($vlu == '사당역'){
			$rtnVlu =  '06:45|사당역 10번출구 방향 버거킹';
		}else if($vlu == '강남역'){
			$rtnVlu =  '07:10|강남역 1번출구 버스정류장';
		}else if($vlu == '종합운동장역'){
			$rtnVlu =  '07:30|종합운동장역 4번출구 방향 버스정류장';
		}else if($vlu == '잠실역'){
			$rtnVlu =  '07:40|롯데마트 잠실점 정문 앞';
		}
	}else if($busNumber == "S1" || $busNumber == "S3"){
		if($vlu == '주문진'){
			$rtnVlu =  '14:15|청시행비치 주차장 입구';
		}else if($vlu == '남애3리'){
			$rtnVlu =  '14:30|남애3리 입구';
		}else if($vlu == '인구'){
			$rtnVlu =  '14:35|현남보건지소 맞은편';
		}else if($vlu == '죽도'){
			$rtnVlu =  '14:40|죽도오토캠핑장 입구';
		}else if($vlu == '동산항'){
			$rtnVlu =  '14:45|동산항 해수욕장 입구';
		}else if($vlu == '기사문'){
			$rtnVlu =  '14:50|기사문 해변주차장 입구';
		}else if($vlu == '하조대'){
			//$rtnVlu =  '14:55|군부대 횡단보도 앞';
			$rtnVlu =  '15:00|서피비치 회전교차로 횡단보도 앞';
		}else if($vlu == '동호'){
			$rtnVlu =  '15:05|동호해변 버스정류장';
		}else if($vlu == '설악'){
			$rtnVlu =  '15:15|설악해변 주차장입구';
		}
	}else if($busNumber == "S2"){
		if($vlu == '주문진'){
			$rtnVlu =  '17:15|청시행비치 주차장 입구';
		}else if($vlu == '남애3리'){
			$rtnVlu =  '17:30|남애3리 입구';
		}else if($vlu == '인구'){
			$rtnVlu =  '17:35|현남보건지소 맞은편';
		}else if($vlu == '죽도'){
			$rtnVlu =  '17:40|죽도오토캠핑장 입구';
		}else if($vlu == '동산항'){
			$rtnVlu =  '17:45|동산항 해수욕장 입구';
		}else if($vlu == '기사문'){
			$rtnVlu =  '17:50|기사문 해변주차장 입구';
		}else if($vlu == '하조대'){
			//$rtnVlu =  '17:55|군부대 횡단보도 앞';
			$rtnVlu =  '18:00|서피비치 회전교차로 횡단보도 앞';
		}else if($vlu == '동호'){
			$rtnVlu =  '18:05|동호해변 버스정류장';
		}else if($vlu == '설악'){
			$rtnVlu =  '18:15|설악해변 주차장입구';
		}
	}

	return $rtnVlu;
}

function cancelPrice2($regDate, $insDate, $ResPrice, $gubun, $ResConfirm){
	$now = date("Y-m-d");
	$resDate = date("Y-m-d", strtotime(substr($regDate, 0, 10)));
	$todayDate = date("Y-m-d", strtotime(substr($insDate, 0, 10)));

	if($gubun > 0){
		$now2 = date("Y-m-d H:i");
		$todayDate2 = date("Y-m-d H:i", strtotime($insDate));
		$toNow = (strtotime($now2)-strtotime($todayDate2)) / (60*60);
	}else{
		$toNow = (strtotime($now)-strtotime($todayDate)) / (60*60*24);
	}

	$resNow = (strtotime($resDate)-strtotime($now)) / (60*60*24);

	$cancelPrcie = 0;
	if($ResConfirm == 1){
		if($toNow <= $gubun){
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
	}

	return $cancelPrcie;
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
?>