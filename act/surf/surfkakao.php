<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

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
	}else if($arrKakao["tempName"] == "at_res_step2"){ //서핑 예약확정 정보
        $btnList = '"button1":{"type":"WL","name":"예약조회/취소","url_mobile":"http://actrip.co.kr/'.$arrKakao["link1"].'"},"button2":{"type":"WL","name":"지도로 위치확인","url_mobile":"http://actrip.co.kr/'.$arrKakao["link2"].'"},"button3":{"type":"WL","name":"제휴업체 목록","url_mobile":"http://actrip.co.kr/'.$arrKakao["link3"].'"},"button4":{"type":"WL","name":"공지사항","url_mobile":"http://actrip.co.kr/'.$arrKakao["link4"].'"},';
	}else if($arrKakao["tempName"] == "at_res_step3"){ //입금대기 기본정보
		$btnList = '"button1":{"type":"WL","name":"공지사항","url_mobile":"http://actrip.co.kr/'.$arrKakao["link1"].'"},';
	}else if($arrKakao["tempName"] == "at_shop_step1"){ //입점샵 예약안내
		$btnList = '"button1":{"type":"WL","name":"전체 예약목록","url_mobile":"http://actrip.co.kr/'.$arrKakao["link1"].'"},"button2":{"type":"WL","name":"현재 예약건 보기","url_mobile":"http://actrip.co.kr/'.$arrKakao["link2"].'"},';
	}else if($arrKakao["tempName"] == "at_res_bus1"){ //셔틀버스 예약확정 정보
        $btnList = '"button1":{"type":"WL","name":"예약조회/취소","url_mobile":"http://actrip.co.kr/'.$arrKakao["link1"].'"},"button2":{"type":"WL","name":"셔틀버스 실시간위치 조회","url_mobile":"http://actrip.co.kr/'.$arrKakao["link2"].'"},"button3":{"type":"WL","name":"셔틀버스 탑승 위치확인","url_mobile":"http://actrip.co.kr/'.$arrKakao["link3"].'"},"button4":{"type":"WL","name":"제휴업체 목록","url_mobile":"http://actrip.co.kr/'.$arrKakao["link4"].'"},"button5":{"type":"WL","name":"공지사항","url_mobile":"http://actrip.co.kr/'.$arrKakao["link5"].'"},';
	}

	$arryKakao = '';
    $arryKakao .= '['.$arryKakao.'{"message_type":"at","phn":"82'.substr(str_replace('-', '',$arrKakao["userPhone"]), 1).'","profile":"70f9d64c6d3b9d709c05a6681a805c6b27fc8dca","tmplId":"'.$arrKakao["tempName"].'","msg":"'.$arrKakao["kakaoMsg"].'",'.$btnList.'"smsKind":"L","msgSms":"'.$arrKakao["kakaoMsg"].'","smsSender":"'.str_replace('-', '',$userPhone).'","smsLmsTit":"'.$arrKakao["smsTitle"].'","smsOnly":"'.$arrKakao["smsOnly"].'"}]';
    
    return $arryKakao;
}

function mailMsg($arrMail){
	$gubun = $arrMail["gubun"];
	$gubun_step = $arrMail["gubun_step"];
	$gubun_title = $arrMail["gubun_title"];

	$userName = $arrMail["userName"];
	$userPhone = $arrMail["userPhone"];
	$ResNumber = $arrMail["ResNumber"];
	$etc = $arrMail["etc"];
	$totalPrice1 = $arrMail["totalPrice1"];
	$totalPrice2 = $arrMail["totalPrice2"];
	$totalPrice2_display = "display:none;";
	$banknum = $arrMail["banknum"];

	$info1_title = $arrMail["info1_title"];
	$info1 = $arrMail["info1"];
	$info2_title = $arrMail["info2_title"];
	$info2 = $arrMail["info2"];
	$info2_display = "display:none;"; //탑승시간 안내
	$info3 = "입금계좌";
	$info3_display = "display:none;"; //입금계좌 안내
	$info4_display = "display:none;"; //추가정보 항목
	$totalinfo = "입금금액";

	$gubun_title1 = $gubun_title."를(을) 예약해 주셔서 진심으로 감사드립니다.";
	$gubun_title2 = "아래의 예약정보 내역확인 후 이용 부탁드립니다.";
	$gubun_title3 = "예약정보";
	$info5_display = ""; //기본정보

	$gubun_subtitle = " 예약안내";

	if($gubun == "bus"){
		if($gubun_step == 0){ //미입금 - 입금대기
			$info3_display = "";
			$info4_display = "";
		}else if($gubun_step == 3){ //확정안내
			$info2_display = "";
		}else if($gubun_step == 4){ //환불요청
			$gubun_subtitle = " 환불요청안내";
			$gubun_title1 = $gubun_title."를(을) 환불요청하셨습니다.";
			$gubun_title2 = "아래의 환불요청 내역 확인 부탁드립니다.";
			$gubun_title3 = "환불요청 정보";

			$info3 = "환불계좌";
			$info3_display = "";
			$info4_display = "";
			$totalPrice2_display = "";
			$totalinfo = "환불금액";
		}else if($gubun_step == 9){ //정류장 변경
			if($info2_title != ""){
				$info2_display = "";
			}

		}
	}else if($gubun == "surf"){
		if($gubun_step == 0){ //미입금 - 입금대기
			$state_title = "입금대기";
		}else if($gubun_step == 1){ //예약대기
			$state_title = "예약대기";
		}else if($gubun_step == 2){ //임시확정
			$state_title = "임시확정";
		}else if($gubun_step == 3){ //확정
			$state_title = "예약확정";
		}else if($gubun_step == 4){ //환불요청
			$state_title = "환불요청";
		}else if($gubun_step == 6){ //임시취소
			$state_title = "임시취소";
		}
		$state_title .= " (".$arrMail["userName"].")";;
	}else if($gubun == "bank"){
		if($gubun_step == 0){
			$gubun_subtitle = " : 동일 이름, 금액건 발생";
		}else if($gubun_step == 1){
			$gubun_subtitle = " : 동일 금액건 발생";
		}else if($gubun_step == 2){
			$gubun_subtitle = " : 동일 이름건 발생";
		}else if($gubun_step == 3){
			$gubun_subtitle = " : 매칭내역 없음";
		}
		$gubun_title1 = "예약건 매칭오류가 발생하였습니다.";
		$gubun_title2 = $etc;
		$info5_display = "display:none;"; //기본정보
	}
	
	$gubun_title .= $gubun_subtitle;

	$returnMsg = "<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;background-color:#f8f8f9;letter-spacing:-1px\">
		<tbody>
			<tr>
				<td align=\"center\">
					<div style=\"max-width:595px; margin:0 auto\">
						<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"max-width:595px;width:100%;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;background-color:#fff;-webkit-text-size-adjust:100%;text-align:left\">
							<tbody>
								<tr>
									<td height=\"30\"></td>
								</tr>
								<tr>
									<td style=\"padding-right:27px; padding-left:21px\">
										<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
											<tbody>
												<tr>
													<td style=\"\" width=\"61\"> <a href=\"https://actrip.co.kr\" target=\"_blank\"><img src=\"https://surfenjoy.cdn3.cafe24.com/logo/weblogo01.png\"></a> </td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td height=\"13\"></td>
								</tr>
								<tr>
									<td style=\"padding-right:27px; padding-left:18px;line-height:38px;font-size:29px;color:#424240;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> 액트립 예약안내 메일입니다.<br><span style=\"color:#1ec800\">$gubun_title</span> </td>
								</tr>
								<tr>
									<td height=\"22\"></td>
								</tr>
								<tr>
									<td height=\"1\" style=\"background-color: #e5e5e5;\"></td>
								</tr>
								<tr>
									<td style=\"padding-top:24px; padding-right:27px; padding-bottom:32px; padding-left:20px\">
										<table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\">
											<tbody>											
												<tr>
													<td style=\"font-size:14px;color:#696969;line-height:30px;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> 안녕하세요. <span style=\"color:#009E25\">$userName</span> 고객님. 
													<br><strong> $gubun_title1</strong><br>
													$gubun_title2 </td>
												</tr>
												<tr style=\"$info5_display\">
													<td height=\"24\"></td>
												</tr>
												<tr style=\"$info5_display\">
													<td style=\"font-size:14px;color:#696969;line-height:24px;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\">
														<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;margin:0;padding:0\">
															<tbody>
																<tr>
																	<td height=\"23\" style=\"font-weight:bold;color:#000;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> $gubun_title3 </td>
																</tr>
																<tr>
																	<td height=\"2\" style=\"background:#424240\"></td>
																</tr>
																<tr>
																	<td height=\"20\"></td>
																</tr>
																<tr>
																	<td>
																		<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;margin:0;padding:0\">
																			<tbody>
																				<tr>
																					<td width=\"105\" style=\"padding-bottom:5px;color:#696969;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> 예 약 자 </td>
																					<td style=\"padding-bottom:5px;color:#000;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> $userName ($userPhone) </td>
																				</tr>
																				<tr>
																					<td style=\"padding-bottom:5px;color:#696969;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> 예약번호 </td>
																					<td style=\"padding-bottom:5px;;color:#000;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> $ResNumber </td>
																				</tr>
																				<tr>
																					<td style=\"padding-bottom:5px;color:#696969;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> $info1_title </td>
																					<td style=\"padding-bottom:5px;;color:#000;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\">$info1</td>
																				</tr>
																				<tr style=\"$info2_display\">
																					<td style=\"padding-bottom:5px;color:#696969;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> $info2_title </td>
																					<td style=\"padding-bottom:5px;;color:#000;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\">$info2</td>
																				</tr>
																				<tr>
																					<td style=\"padding-bottom:5px;color:#696969;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> 특이사항 </td>
																					<td style=\"padding-bottom:5px;padding-top:5px;color:#000;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"><textarea cols=\"42\" disabled=\"\" rows=\"8\" name=\"etc\" style=\"margin: 0px; width: 97%; height: 80px; resize: none;\">$etc</textarea></td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height=\"10\"></td>
																</tr>
																<tr>
																	<td height=\"1\" style=\"background:#d5d5d5\"></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr style=\"$info4_display\">
													<td height=\"24\"></td>
												</tr>
												<tr style=\"$info4_display\">
													<td style=\"font-size:14px;color:#696969;line-height:24px;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\">
														<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;margin:0;padding:0\">
															<tbody>
																<tr>
																	<td height=\"23\" style=\"font-weight:bold;color:#000;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> 추가정보 </td>
																</tr>
																<tr>
																	<td height=\"2\" style=\"background:#424240\"></td>
																</tr>
																<tr>
																	<td height=\"20\"></td>
																</tr>
																<tr>
																	<td>
																		<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;margin:0;padding:0\">
																			<tbody>
																				<tr style=\"$info3_display\">
																					<td width=\"105\" style=\"padding-bottom:5px;color:#696969;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> $info3</td>
																					<td style=\"padding-bottom:5px;color:#000;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\">$banknum </td>
																				</tr>
																				<tr>
																					<td width=\"105\" style=\"padding-bottom:5px;color:#696969;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\">$totalinfo</td>
																					<td style=\"padding-bottom:5px;;color:#000;line-height:23px;vertical-align:top;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\">$totalPrice1 <span style=\"font-size:12px;$totalPrice2_display\">$totalPrice2</span></td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height=\"10\"></td>
																</tr>
																<tr>
																	<td height=\"1\" style=\"background:#d5d5d5\"></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr style=\"$info5_display\">
													<td height=\"24\"></td>
												</tr>
												<tr style=\"$info5_display\">
													<td style=\"font-size:14px;color:#696969;line-height:24px;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\"> <strong>예약관련 문의사항은 <a href=\"https://pf.kakao.com/_HxmtMxl\" target=\"_blank\" style=\"text-decoration:underline;color:#009e25\" rel=\"noreferrer noopener\">카카오톡 채널</a>을 이용해주세요.</strong> </td>
												</tr>
												<tr style=\"$info5_display\">
													<td style=\"font-size:14px;color:#696969;line-height:24px;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;\">더욱 편리한 서비스를 제공하기 위해 항상 최선을 다하겠습니다. </td>
												</tr>
												<tr style=\"$info5_display\">
													<td style=\"height:34px;font-size:14px;color:#696969;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;text-align:center;\"> <a href=\"https://actrip.co.kr/ordersearch?resNumber=$ResNumber\" style=\"display:inline-block;padding:10px 30px 10px; margin-top:10px; background-color:#08a600; color:#fff;text-align: center; text-decoration: none;\" target=\"_blank\" rel=\"noreferrer noopener\">예약조회</a></td>
												</tr>
												
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td style=\"padding-top:26px;padding-left:21px;padding-right:21px;padding-bottom:13px;background:#f9f9f9;font-size:12px;font-family:'나눔고딕',NanumGothic,'맑은고딕',Malgun Gothic,'돋움',Dotum,Helvetica,'Apple SD Gothic Neo',Sans-serif;color:#696969;line-height:17px\"> 본 메일은 발신전용 메일이므로 회신되지 않습니다.<br>액트립 서비스관련 궁금하신 사항은  <a href=\"https://pf.kakao.com/_HxmtMxl\" style=\"color:#696969;font-weight:bold;text-decoration:underline\" rel=\"noreferrer noopener\" target=\"_blank\">카카오톡 채널</a>에서 확인해주세요. </td>
								</tr>
								<tr>
									<td style=\"padding-left:21px;padding-right:21px;padding-bottom:57px;background:#f9f9f9;font-size:12px;font-family:Helvetica;color:#696969;line-height:17px\"> Copyright ⓒ <strong>ACTRIP</strong> Corp. All Rights Reserved. </td>
								</tr>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
		</tbody>
	</table>";

	return $returnMsg;
}

function sendMail($arrMail){
	$admin_email = $arrMail["mailfrom"];
	$admin_name  = $arrMail["mailname"];
	$mailto = $arrMail["mailto"];
	$gubun = $arrMail["gubun"];
	$gubun_step = $arrMail["gubun_step"];
	$gubun_title = $arrMail["gubun_title"];

	$header  = "Return-Path: ".$admin_email."\n";
	$header .= "From: =?EUC-KR?B?".base64_encode($admin_name)."?= <".$admin_email.">\n";
	$header .= "MIME-Version: 1.0\n";
	$header .= "X-Priority: 3\n";
	$header .= "X-MSMail-Priority: Normal\n";
	$header .= "X-Mailer: FormMailer\n";
	$header .= "Content-Transfer-Encoding: base64\n";
	$header .= "Content-Type: text/html;\n \tcharset=UTF-8\n";

	if($gubun == "bus"){
		if($gubun_step == 0){ //미입금 - 입금대기
			$state_title = "입금대기";
		}else if($gubun_step == 3){ //확정안내
			$state_title = "예약확정";
		}else if($gubun_step == 4){ //환불요청
			$state_title = "환불요청";
		}else if($gubun_step == 9){ //정류장 변경
			$state_title = "정류장 변경";
		}
	}else if($gubun == "surf"){
		if($gubun_step == 0){ //미입금 - 입금대기
			$state_title = "입금대기";
		}else if($gubun_step == 1){ //예약대기
			$state_title = "예약대기";
		}else if($gubun_step == 2){ //임시확정
			$state_title = "임시확정";
		}else if($gubun_step == 3){ //확정
			$state_title = "예약확정";
		}else if($gubun_step == 4){ //환불요청
			$state_title = "환불요청";
		}else if($gubun_step == 6){ //임시취소
			$state_title = "임시취소";
		}
		$state_title .= " (".$arrMail["userName"].")";;
	}else if($gubun == "bank"){
		if($gubun_step == 0){
			$state_title = "동일 금액, 예약건 발생";
		}else if($gubun_step == 1){
			$state_title = "동일 금액건 발생";
		}else if($gubun_step == 2){
			$state_title = "동일 이름건 발생";
		}else if($gubun_step == 3){
			$state_title = "매칭내역 없음";
		}
	}

	$subject = "[액트립] ".$gubun_title." 예약안내 - ".$state_title;

	$message = base64_encode(mailMsg($arrMail));
	flush();
	@mail($mailto, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
}
?>