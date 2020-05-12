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

        $msgTitle = '액트립 '.$shopname.' 예약안내';
		$kakaoMsg = $msgTitle.'\n안녕하세요. '.$userName.'님\n\n액트립 예약정보 [예약확정]\n ▶ 예약번호 : '.$ResNumber.'\n ▶ 예약자 : '.$userName.'\n ▶ 좌석안내\n'.$busSeatInfo.$pointMsg.$etcMsg.'---------------------------------\n ▶ 안내사항\n      - 이용일, 탑승시간, 탑승위치 꼭 확인 부탁드립니다.\n      - 탑승시간 5분전에는 도착해주세요~\n\n ▶ 문의\n      - 010.3308.6080\n      - http://pf.kakao.com/_HxmtMxl';

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
			, "link1"=>"ordersearch?resNumber=".$ResNumber //예약조회/취소
			, "link2"=>"surfbusgps" //셔틀버스 실시간위치 조회
			, "link3"=>"pointlist?resparam=".$resparam //셔틀버스 탑승 위치확인
			, "link4"=>"eatlist" //제휴업체 목록
			, "link5"=>"event" //공지사항
			, "smsOnly"=>"N"
		);
		sendKakao($arrKakao); //알림톡 발송

        if(strrpos($usermail, "@") > 0){
            $to .= ','.$usermail;
		}

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
    //==========================카카오 메시지 발송 End ==========================
}else if($param == "busmodify"){ //셔틀버스 정보 업데이트
	$insdate = $_REQUEST["insdate"];
	$confirmdate = $_REQUEST["confirmdate"];
	$res_confirm = $_REQUEST["res_confirm"];
	$user_name = $_REQUEST["user_name"];
	$uesr_tel = $_REQUEST["uesr_tel"];
	$user_email = $_REQUEST["user_email"];
	$rtn_chargeprice = $_REQUEST["rtn_chargeprice"];
	$res_price_coupon = $_REQUEST["res_price_coupon"];
	$res_price = $_REQUEST["res_price"];
	$res_busnum = $_REQUEST["res_busnum"];
	$res_seat = $_REQUEST["res_seat"];
	$res_spointname = $_REQUEST["res_spointname"];
	$res_epointname = $_REQUEST["res_epointname"];
	$res_date = $_REQUEST["res_date"];

	$msgYN = $_REQUEST["msgYN"];
	$InsUserID = $_REQUEST["userid"];
	$ressubseq = $_REQUEST["ressubseq"];
	$resnum = $_REQUEST["resnum"];

    $select_query = "UPDATE AT_RES_SUB 
                    SET insdate = '".$insdate."'
                        ,confirmdate = '".$confirmdate."'
                        ,res_confirm = '".$res_confirm."'
                        ,rtn_chargeprice = '".$rtn_chargeprice."'
                        ,res_price_coupon = '".$res_price_coupon."'
                        ,res_price = '".$res_price."'
                        ,res_busnum = '".$res_busnum."'
                        ,res_seat = '".$res_seat."'
                        ,res_spointname = '".$res_spointname."'
                        ,res_epointname = '".$res_epointname."'
                        ,res_date = '".$res_date."'
                        ,ResConfirm = ".$res_confirm."
                        ,upddate = now()
                        ,upduserid = '".$InsUserID."'
                        ,confirmdate = '".$confirmdate."'
                WHERE ressubseq = ".$ressubseq." AND resnum = '".$resnum."';";
    $result_set = mysqli_query($conn, $select_query);
    if(!$result_set) goto errGo;

    $select_query = "UPDATE `AT_RES_MAIN` 
                    SET user_name = '".$user_name."'
                        ,ResConfirm = 1
                        ,uesr_tel = '".$uesr_tel."'
                        ,user_email = '".$user_email."'
                        ,upddate = now()
                        ,upduserid = '".$InsUserID."'
                WHERE resnum = '".$resnum."';";
    $result_set = mysqli_query($conn, $select_query);
    if(!$result_set) goto errGo;

	mysqli_query($conn, "COMMIT");
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
