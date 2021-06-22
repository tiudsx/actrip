<?php
include __DIR__.'/../../db.php';
include __DIR__.'/../../surf/surfkakao.php';
include __DIR__.'/../../surf/surfmail.php';
include __DIR__.'/../../surf/surffunc.php';

$success = true;
$datetime = date('Y/m/d H:i'); 

$param = $_REQUEST["resparam"];
$InsUserID = $_REQUEST["userid"];

$intseq = "";
$intseq3 = "";
//$to = "lud1@naver.com";
$to = "lud1@naver.com,ttenill@naver.com";

mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

// $rtn = $param.'/'.$_REQUEST["chkCancel"].'/'.$_REQUEST["selConfirm"].'/'.$_REQUEST["MainNumber"].'/'.$_REQUEST["memo"];
if($param == "changeConfirm"){ //상태 정보 업데이트
    $chkCancel = $_REQUEST["chkCancel"];
    $selConfirm = $_REQUEST["selConfirm"];
    $resnum = $_REQUEST["MainNumber"];
    $memo = $_REQUEST["memo"];

	//================= 예약상태 및 메모 저장 =================
	$select_query = "UPDATE AT_RES_MAIN SET memo = '$memo' WHERE resnum = $resnum";
	$result_set = mysqli_query($conn, $select_query);
 	if(!$result_set) goto errGo;

	for($i = 0; $i < count($chkCancel); $i++){
		$insdate1 = "";
		if($selConfirm[$i] == 3){
			$insdate1 = ",confirmdate = now()";
			$intseq3 .= $chkCancel[$i].",";
		}

		$select_query = "UPDATE `AT_RES_SUB` 
					   SET res_confirm = ".$selConfirm[$i]."
						".$insdate1."
						  ,upddate = now()
						  ,upduserid = '".$InsUserID."'
					WHERE ressubseq = ".$chkCancel[$i].";";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) goto errGo;
	}

    $intseq3 .= '0';
    mysqli_query($conn, "COMMIT");

    $arrSeatInfo = array();
    $arrStopInfo = array();

    $select_query = "SELECT user_name, user_tel, user_email, etc, memo FROM `AT_RES_MAIN` WHERE resnum = $resnum";

    $result = mysqli_query($conn, $select_query);
    $rowMain = mysqli_fetch_array($result);

    $ResNumber = $resnum;
	$userName = $rowMain["user_name"];
	$etc = $rowMain["etc"];
	$userPhone = $rowMain["user_tel"];
	$usermail = $rowMain["user_email"];

    //==========================카카오 메시지 발송 ==========================
    if($intseq3 != "0"){ //예약 확정처리 : 고객발송
        $select_query_sub = "SELECT * FROM AT_RES_SUB WHERE ressubseq IN ($intseq3) ORDER BY res_date, ressubseq";
        $resultSite = mysqli_query($conn, $select_query_sub);

        while ($rowSub = mysqli_fetch_assoc($resultSite)){
            $shopSeq = $rowSub['seq'];
			$shopname = $rowSub['shopname'];
			$coupon = $rowSub['res_coupon'];

            if(array_key_exists($rowSub['res_date'].$rowSub['res_busnum'], $arrSeatInfo)){
                $arrSeatInfo[$rowSub['res_date'].$rowSub['res_busnum']] .= '      - '.$rowSub['res_seat'].'번 ('.$rowSub['res_spointname'].' -> '.$rowSub['res_epointname'].')\n';
            }else{
                $arrSeatInfo[$rowSub['res_date'].$rowSub['res_busnum']] = '    ['.$rowSub['res_date'].'] '.fnBusNum($rowSub['res_busnum']).'\n      - '.$rowSub['res_seat'].'번 ('.$rowSub['res_spointname'].' -> '.$rowSub['res_epointname'].')\n';
            }

            $arrData = explode("|", fnBusPoint($rowSub['res_spointname'], $rowSub['res_busnum'], 0));
            $arrStopInfo[$rowSub['res_spointname']] = '    ['.$rowSub['res_spointname'].'] '.$arrData[0].'\n      - '.$arrData[1].'\n';
        }
        
        foreach($arrSeatInfo as $x) {
            $busSeatInfo .= $x;
        }

        foreach($arrStopInfo as $x) {
            $busStopInfo .= $x;
        }

        $busSeatInfo = $busSeatInfo;
        $pointMsg = '  ▶ 탑승시간/위치 안내\n'.$busStopInfo;

        if($etc != ''){
            $etcMsg = '  ▶ 특이사항\n      '.$etc.'\n';
        }

		$infomsg = "\n      - 이용일, 탑승시간, 탑승위치 꼭 확인 부탁드립니다.\n      - 탑승시간 5분전에는 도착해주세요~";
		if($coupon == "NABUSA" || $coupon == "NABUSB"){
			$infomsg .= "\n      - 취소 및 환불신청은 네이버에서 해주세요~";
		}else if($coupon == "NABUSC"){
			$infomsg .= "\n      - 취소 및 환불신청은 프립에서 해주세요~";
		}

        $msgTitle = '액트립 '.$shopname.' 예약안내';
		$kakaoMsg = $msgTitle.'\n안녕하세요. '.$userName.'님\n\n액트립 예약정보 [예약확정]\n ▶ 예약번호 : '.$ResNumber.'\n ▶ 예약자 : '.$userName.'\n ▶ 좌석안내\n'.$busSeatInfo.$pointMsg.$etcMsg.'---------------------------------\n ▶ 안내사항'.$infomsg.'\n\n ▶ 문의\n      - 010.3308.6080\n      - http://pf.kakao.com/_HxmtMxl';

		if($shopSeq == 7){
			$resparam = "surfbus_yy";
		}else{
			$resparam = "surfbus_dh";			
        }
        $arrKakao = array(
			"gubun"=> "bus"
			, "admin"=> "N"
			, "smsTitle"=> $msgTitle
			, "userName"=> $userName
			, "tempName"=> "at_res_bus1"
			, "kakaoMsg"=>$kakaoMsg
			, "userPhone"=> $userPhone
			, "link1"=>"orderview?num=1&resNumber=".$ResNumber //예약조회/취소
			, "link2"=>"surfbusgps" //셔틀버스 실시간위치 조회
			, "link3"=>"pointlist?resparam=".$resparam //셔틀버스 탑승 위치확인
			, "link4"=>"eatlist" //제휴업체 목록
			, "link5"=>"event" //공지사항
			, "smsOnly"=>"N"
		);
		sendKakao($arrKakao); //알림톡 발송

        if(strrpos($usermail, "@") > 0){
            // $to .= ','.$usermail;
			$to = $usermail;

			$info1_title = "좌석안내";
			$info1 = str_replace('      -', '&nbsp;&nbsp;&nbsp;-', str_replace('\n', '<br>', $busSeatInfo));
			$info2_title = "탑승시간/위치 안내";
			$info2 = str_replace('      -', '&nbsp;&nbsp;&nbsp;-', str_replace('\n', '<br>', $busStopInfo));

			$arrMail = array(
				"gubun"=> "bus"
				, "gubun_step" => 3
				, "gubun_title" => $shopname
				, "mailto"=> $to
				, "mailfrom"=> "surfbus_res@actrip.co.kr"
				, "mailname"=> "actrip"
				, "userName"=> $userName
				, "ResNumber"=> $ResNumber
				, "userPhone" => $userPhone
				, "etc" => $etc
				, "totalPrice1" => ""
				, "totalPrice2" => ""
				, "banknum" => ""
				, "info1_title"=> $info1_title
				, "info1"=> $info1
				, "info2_title"=> $info2_title
				, "info2"=> $info2
			);
			sendMail($arrMail); //메일 발송
		}
    }
    //==========================카카오 메시지 발송 End ==========================
}else if($param == "busmodify"){ //셔틀버스 정보 업데이트
	$res_date = $_REQUEST["res_date"];
	$res_busnum = $_REQUEST["res_busnum"];
	$res_seat = $_REQUEST["res_seat"];
	$res_spointname = $_REQUEST["res_spointname"];
	$res_epointname = $_REQUEST["res_epointname"];
	$res_confirm = $_REQUEST["res_confirm"];
	$res_price = $_REQUEST["res_price"];
	$res_price_coupon = $_REQUEST["res_price_coupon"];
	$rtn_charge_yn = $_REQUEST["rtn_charge_yn"];
	$insdate = $_REQUEST["insdate"];
	$confirmdate = $_REQUEST["confirmdate"];

	$user_name = $_REQUEST["user_name"];
	$user_tel = $_REQUEST["user_tel"];
	$user_email = $_REQUEST["user_email"];
	$memo = $_REQUEST["memo"];

	//$msgYN = $_REQUEST["msgYN"];
	$ressubseq = $_REQUEST["ressubseq"];
	$resnum = $_REQUEST["resnum"];

	if($res_price_coupon <= 100){ //퍼센트 할인
		$res_totalprice = $res_price * (1 - ($res_price_coupon / 100));
	}else{ //금액할인
		$res_totalprice = $res_price - $res_price_coupon;
	}
	
    $select_query = "UPDATE AT_RES_SUB 
                    SET res_date = '".$res_date."'
                        ,res_bus = '".$res_busnum."'
                        ,res_busnum = '".$res_busnum."'
                        ,res_seat = ".$res_seat."
                        ,res_spoint = '".$res_spointname."'
                        ,res_spointname = '".$res_spointname."'
                        ,res_epoint = '".$res_epointname."'
                        ,res_epointname = '".$res_epointname."'
                        ,res_confirm = '".$res_confirm."'
                        ,res_price = '".$res_price."'
                        ,res_price_coupon = '".$res_price_coupon."'
                        ,res_totalprice = '".$res_totalprice."'
                        ,rtn_charge_yn = '".$rtn_charge_yn."'
                        ,insdate = '".$insdate."'
                        ,upddate = now()
                        ,upduserid = 'admin'
                        ,confirmdate = '".$confirmdate."'
                WHERE ressubseq = ".$ressubseq." AND resnum = '".$resnum."';";
    $result_set = mysqli_query($conn, $select_query);
    if(!$result_set) goto errGo;

    $select_query = "UPDATE `AT_RES_MAIN` 
                    SET user_name = '".$user_name."'
                        ,memo = '".$memo."'
                        ,user_tel = '".$user_tel."'
                        ,user_email = '".$user_email."'
                WHERE resnum = '".$resnum."';";
    $result_set = mysqli_query($conn, $select_query);
    if(!$result_set) goto errGo;

	mysqli_query($conn, "COMMIT");
}else if($param == "reskakao"){ //버스 예약안내 카톡 : 타채널예약건
    $userName = $_REQUEST["username"];
    $userPhone = $_REQUEST["userphone"];
    $reschannel = $_REQUEST["reschannel"];

	/*
	7 : 네이버쇼핑
	10 : 네이버예약
	11 : 프립
	*/
	function RandString($len){
		$return_str = "";
	
		for ( $i = 0; $i < $len; $i++ ) {
			mt_srand((double)microtime()*1000000);
			$return_str .= substr('123456789ABCDEFGHIJKLMNPQRSTUVWXYZ', mt_rand(0,33), 1);
		}
	
		return $return_str;
	}

	$coupon_code = RandString(5);
	$user_ip = $_SERVER['REMOTE_ADDR'];
    $add_date = date("Y-m-d");

	$select_query = "INSERT INTO `AT_COUPON_CODE` (`couponseq`, `coupon_code`, `seq`, `use_yn`, `add_ip`, `add_date`, `insdate`) VALUES ('$reschannel', '$coupon_code', 'BUS', 'N', '$user_ip', '$add_date', now());";
	$result_set = mysqli_query($conn, $select_query);
 	if(!$result_set) goto errGo;

	mysqli_query($conn, "COMMIT");


	$infomsg = "\n      - [예약하기] 버튼을 클릭해서 좌석을 예약해주세요.";
	$infomsg .= "\n      - 예약화면에서 안내된 쿠폰코드를 입력해주세요.";
	$infomsg .= "\n\n      - 예약하신 건수와 동일한 좌석수로 예약해주세요.";

	if($reschannel == 7){

	}else if($reschannel == 10){

	}if($reschannel == 11){

	}

	$msgTitle = '액트립 셔틀버스 예약안내';
	$kakaoMsg = $msgTitle.'\n\n안녕하세요. '.$userName.'님\n액트립 셔틀버스 좌석예약 안내입니다\n\n액트립 셔틀버스 예약코드\n ▶ 예약번호 : -\n ▶ 예약자 : '.$userName.'\n ▶ 쿠폰코드 : '.$coupon_code.'\n---------------------------------\n ▶ 안내사항'.$infomsg.'\n\n ▶ 문의\n      - 010.3308.6080\n      - http://pf.kakao.com/_HxmtMxl';
		
	$arrKakao = array(
		"gubun"=> "bus"
		, "admin"=> "N"
		, "smsTitle"=> $msgTitle
		, "userName"=> $userName
		, "tempName"=> "at_bus_kakao"
		, "kakaoMsg"=>$kakaoMsg
		, "userPhone"=> $userPhone
		, "link1"=>"surfbus_yy?param=".urlencode(encrypt(date("Y-m-d").'|'.$coupon_code))
		, "link2"=>""
		, "link3"=>""
		, "link4"=>"" //제휴업체 목록
		, "link5"=>"" //공지사항
		, "smsOnly"=>"N"
	);
	sendKakao($arrKakao); //알림톡 발송
	 
	echo $coupon_code." / ";
}

if(!$success){
	errGo:
	mysqli_query($conn, "ROLLBACK");
	echo 'err';
}else{
	echo '0';
}

mysqli_close($conn);
?>
