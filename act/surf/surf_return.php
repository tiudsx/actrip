<?php 
include __DIR__.'/../db.php';
include __DIR__.'/../surf/surfkakao.php';
include __DIR__.'/../surf/surfmail.php';
include __DIR__.'/../surf/surffunc.php';

$param = $_REQUEST["resparam"];
$gubun = $_REQUEST["gubun"];
$to = "lud1@naver.com,ttenill@naver.com";

/*
예약상태
    0 : 미입금
    1 : 예약대기
    2 : 임시확정
    3 : 확정
    4 : 환불요청
    5 : 환불완료
    6 : 임시취소
    7 : 취소
    8 : 입금완료
*/
$success = true;
if($param == "RtnPrice"){
	$ressubseq = str_replace("'", "",$_REQUEST["subintseq"]);
	$arrSeq = explode(",",$ressubseq);

	$now = date("Y-m-d");
	$totalPrice = 0;
	$totalFee = 0;
	$totalOpt = 0;
	for($i=0;$i<count($arrSeq);$i++) {
        $select_query_sub = 'SELECT *, TIMESTAMPDIFF(MINUTE, confirmdate, now()) as timeM FROM AT_RES_SUB where ressubseq IN ('.$arrSeq[$i].')';
		$resultSite = mysqli_query($conn, $select_query_sub);
		$count = mysqli_num_rows($resultSite);

		if($count == 0){
			echo $arrSeq[i];
			exit;
		}

		while ($rowSub = mysqli_fetch_assoc($resultSite)){
			$arrOpt = 0;
			$boolConfirm = false;
            $ResConfirm = $rowSub['res_confirm'];
            $ResPrice = $rowSub['res_totalprice'];

            if(!($ResConfirm == "0" || $ResConfirm == "1" || $ResConfirm == "2" || $ResConfirm == "3" || $ResConfirm == "6" || $ResConfirm == "8")){
                echo 'err';
                exit;
            }
            $sDate = $rowSub['res_date'];
            
            if($ResConfirm == "1" || $ResConfirm == "2" || $ResConfirm == "3" || $ResConfirm == "6" || $ResConfirm == "8"){
                $boolConfirm = true;
            }
            
            $rtnFee = cancelPrice($sDate, $rowSub['timeM'], $ResConfirm, $ResPrice);

			if($boolConfirm){
                $totalPrice += $ResPrice;
                $totalFee += $rtnFee;
				$totalOpt += $arrOpt;
			}
		}

		$totalPrice = $totalPrice + $totalOpt;
	}

	echo $totalPrice."|".$totalFee."|".($totalPrice - $totalFee);

}else if($param == "Cancel"){  //환불 및 취소
	$chkCancel = $_REQUEST["chkCancel"];
	$bankName = $_REQUEST["bankName"];
	$bankNum = $_REQUEST["bankNum"];
	$MainNumber = $_REQUEST["MainNumber"];

    for($i = 0; $i < count($chkCancel); $i++){
        $ressubseq .= $chkCancel[$i].",";
    }
    $ressubseq .= '0';
    $select_query = 'SELECT * FROM AT_RES_MAIN WHERE resnum = '.$MainNumber;

    $result_setlist = mysqli_query($conn, $select_query);
    $row = mysqli_fetch_array($result_setlist);

    $ResNumber = $row["resnum"];
    $userName = $row["user_name"];
    $InsUserID = $userName;
    $userPhone = $row["user_tel"];
    $user_email = $row["user_email"];
    $etc = $row["etc"];

    $FullBankText = "";
    if($bankNum != ""){
        $FullBankText = $bankName."|".$bankNum."|".$userName;
    }

    $arrSeatInfo = array();
    $select_query_sub = 'SELECT *, TIMESTAMPDIFF(MINUTE, confirmdate, now()) as timeM FROM AT_RES_SUB where res_confirm IN (0,1,2,3,6) AND ressubseq IN ('.$ressubseq.') AND resnum = '.$ResNumber;
    $resultSite = mysqli_query($conn, $select_query_sub);
    $chkSubCnt = mysqli_num_rows($resultSite); //체크 개수
    if($chkSubCnt == 0){
        // echo '<script>alert("환불신청 가능한 예약내역이 없습니다.\n\n관리자에게 문의해주세요.");</script>';
        echo 'err';
        exit;
    }

    mysqli_query($conn, "SET AUTOCOMMIT=0");
    mysqli_query($conn, "BEGIN");

    $TotalPrice = 0;
    $TotalFee = 0;
    $TotalOpt = 0;
    $arrSeatInfo = array();
    while ($rowSub = mysqli_fetch_assoc($resultSite)){
        if($success){
            $arrOpt = 0;
            $boolConfirm = false;
            
            $sDate = $rowSub['res_date'];
            $ResConfirm = $rowSub['res_confirm'];
            $ResPrice = $rowSub['res_totalprice'];
            $shopname = $rowSub['shopname'];
            $shopSeq = $rowSub['seq']; //입점샵 seq
            $code = $rowSub['code'];

            if($ResConfirm == "2" || $ResConfirm == "3" || $ResConfirm == "6" || $ResConfirm == "8"){
                $boolConfirm = true;
            }

            if($ResConfirm == "0"){ //미입금 상태 취소
                $select_query = "UPDATE AT_RES_SUB 
                                SET res_confirm = 7
                                ,upddate = now()
                                ,upduserid = '".$InsUserID."'
                            WHERE ressubseq = ".$rowSub['ressubseq'].";";
                $result_set = mysqli_query($conn, $select_query);
                if(!$result_set) $success = false;
            }else if($boolConfirm){ //확정 상태 환불요청
                $rtnFee = cancelPrice($sDate, $rowSub['timeM'], $ResConfirm, $ResPrice);                

                $select_query = "UPDATE AT_RES_SUB  
                                SET res_confirm = 4
                                ,rtn_chargeprice = ".$rtnFee."
                                ,rtn_totalprice = ".(($ResPrice + $arrOpt) - $rtnFee)."
                                ,rtn_bankinfo = '".$FullBankText."'
                                ,upddate = now()
                                ,upduserid = '".$InsUserID."'
                            WHERE ressubseq = ".$rowSub['ressubseq'].";";

                $result_set = mysqli_query($conn, $select_query);
                if(!$result_set) $success = false;
                
                $ressubseqInfo .= $rowSub['ressubseq'].",";

                $TotalPrice +=($ResPrice + $arrOpt);
                $TotalFee +=$rtnFee;

                if($code == "bus"){
                    if(array_key_exists($rowSub['res_date'].$rowSub['res_bus'], $arrSeatInfo)){
                        $arrSeatInfo[$rowSub['res_date'].$rowSub['res_bus']] .= '      - '.$rowSub['res_seat'].'번\n';
                    }else{
                        $arrSeatInfo[$rowSub['res_date'].$rowSub['res_bus']] = '    ['.$rowSub['res_date'].'] '.fnBusNum($rowSub['res_bus']).'\n      - '.$rowSub['res_seat'].'번\n';
                    }
                }else{
                    $ResNum = "      - 인원 : ";
                    if($rowSub["res_m"] > 0){
                        $ResNum .= "남:".$rowSub["res_m"].'명';
                    }
                    if($row['res_m'] > 0 && $row['res_w'] > 0){
                        $ResNum .= ",";
                    }
                    if($rowSub["res_w"] > 0){
                        $ResNum .= "여:".$rowSub["res_w"].'명';
                    }
                    $ResNum .= '\n';

                    $optname = $rowSub["optname"];
                    $surfMsg .= '    ['.$optname.']\n      - 예약일 : '.$sDate.'\n'.$ResNum.'\n';
                }
            }else{
                $success = false;
            }
        }
    }

    if(!$success){
        mysqli_query($conn, "ROLLBACK");
        //echo '<script>alert("환불신청 중 오류가 발생하였습니다.\n\n관리자에게 문의해주세요.");</script>';
        echo 'err';
    }else{
        mysqli_query($conn, "COMMIT");

        $rtnText = ' ▶ 환불요청 안내\n       - 결제금액 : '.number_format($TotalPrice).'원\n       - 환불수수료 : '.number_format($TotalFee).'원\n       - 환불금액 : '.number_format($TotalPrice-$TotalFee).'원\n  ▶환불계좌\n       - '.str_replace('|', ' / ', $FullBankText).'\n';

        if($ressubseqInfo != ""){
            if($code == "bus"){
                // 예약좌석 정보
                foreach($arrSeatInfo as $x) {
                    $msgInfo .= $x;
                }

                $msgInfo = " ▶ 좌석안내\n".$msgInfo;
                $mailmsgInfo = $msgInfo;
                $subtitlename = '액트립';
            }else{
                $msgInfo = " ▶ 신청목록\n".$surfMsg;
                $mailmsgInfo = $surfMsg;
                $subtitlename = $shopname;
            }

            $msgTitle = '액트립 '.$shopname.' 환불안내';
            $kakaoMsg = $msgTitle.'\n안녕하세요. '.$userName.'님\n\n'.$subtitlename.' 예약정보 [환불요청]\n ▶ 예약번호 : '.$ResNumber.'\n ▶ 예약자 : '.$userName.'\n'.$msgInfo.$rtnText.'---------------------------------\n ▶ 안내사항\n      - 환불처리기간은 1~7일정도 소요됩니다.\n\n ▶ 문의\n      - http://pf.kakao.com/_HxmtMxl';

            $arrKakao = array(
                "gubun"=> $code
                , "admin"=> "N"
                , "smsTitle"=> $msgTitle
                , "userName"=> $userName
                , "tempName"=> "at_res_step3"
                , "kakaoMsg"=>$kakaoMsg
                , "userPhone"=> $userPhone
                , "link1"=>"event" //공지사항
                , "link2"=>""
                , "link3"=>""
                , "link4"=>""
                , "link5"=>""
                , "smsOnly"=>"N"
            );
            sendKakao($arrKakao);

            // 이메일 발송
            if(strrpos($user_email, "@") > 0){
                $to .= $user_email;
            }

            if($code == "bus"){
                $info1_title = "좌석안내";
                $mailform = "surfbus_return@actrip.co.kr";
            }else{
                $info1_title = "신청목록";
                $mailform = "surfshop_return@actrip.co.kr";
            }
            $info1 = str_replace('      -', '&nbsp;&nbsp;&nbsp;-', str_replace('\n', '<br>', $mailmsgInfo));
            $info2_title = "";
            $info2 = "";

            $arrMail = array(
                "gubun"=> $code
                , "gubun_step" => 4
                , "gubun_title" => $shopname
                , "mailto"=> $to
                , "mailfrom"=> $mailform
                , "mailname"=> "actrip"
                , "userName"=> $userName
                , "ResNumber"=> $ResNumber
                , "userPhone" => $userPhone
                , "etc" => $etc
                , "totalPrice1" => number_format($TotalPrice-$TotalFee)."원"
                , "totalPrice2" => "(결제금액 ".number_format($TotalPrice)."원 - 환불수수료 ".number_format($TotalFee)."원)"
                , "banknum" => str_replace('|', ' / ', $FullBankText)
                , "info1_title"=> $info1_title
                , "info1"=> $info1
                , "info2_title"=> $info2_title
                , "info2"=> $info2
            );
            
            sendMail($arrMail); //메일 발송
            
            if($code != "bus"){
                //카카오톡 업체 발송
                $select_query = 'SELECT * FROM AT_PROD_MAIN WHERE seq = '.$shopSeq;
                $result_setlist = mysqli_query($conn, $select_query);
                $rowshop = mysqli_fetch_array($result_setlist);

                $admin_tel = $rowshop["tel_kakao"];
                // $admin_tel = "010-4437-0009";

                $msgTitle = '액트립 ['.$userName.']님 예약취소';
                $kakaoMsg = $msgTitle.'\n안녕하세요. 액트립 예약취소건 안내입니다.\n\n액트립 예약정보 [예약취소]\n ▶ 예약번호 : '.$ResNumber.'\n ▶ 예약자 : '.$userName.'\n'.$msgInfo.$rtnText.'---------------------------------\n ▶ 안내사항\n      - 예약취소내역 확인부탁드립니다.\n\n';

                $arrKakao = array(
                    "gubun"=> $code
                    , "admin"=> "N"
                    , "smsTitle"=> $msgTitle
                    , "userName"=> $userName
                    , "tempName"=> "at_shop_step1"
                    , "kakaoMsg"=>$kakaoMsg
                    , "userPhone"=> $admin_tel
                    , "link1"=>"surfadminkakao?param=".urlencode(encrypt(date("Y-m-d").'|'.$shopSeq)) //전체 예약목록
                    , "link2"=>"surfadminkakao?param=".urlencode(encrypt(date("Y-m-d").'|'.$ResNumber.'|'.$shopSeq)) //현재 예약건 보기
                    , "link3"=>""
                    , "link4"=>""
                    , "link5"=>""
                    , "smsOnly"=>"N"
                );
                sendKakao($arrKakao);
            }
        }

        //echo '<script>alert("환불신청이 완료되었습니다.");parent.location.href="/";</script>';
        echo '0';
    }
}else if($param == "PointChange"){ //정류장 변경
    $ResNumber = $_REQUEST["MainNumber"];
    $shopseq = $_REQUEST["shopseq"];
    if($shopseq == 7){
        $busTypeY = "Y";
        $busTypeS = "S";
        $busTitleName = "양양";
    }else{
        $busTypeY = "E";
        $busTypeS = "A";    
        $busTitleName = "동해";    
    }

	$ressubseq = $_REQUEST["ressubseq"]; //셔틀버스 예약 시퀀스
    
	$startLocation = $_REQUEST["startLocation"]; //출발 정류장
	$endLocation = $_REQUEST["endLocation"]; //도착 정류장
    
	mysqli_query($conn, "SET AUTOCOMMIT=0");
    mysqli_query($conn, "BEGIN");
    
	for($i = 0; $i < count($ressubseq); $i++){
        $select_query = "UPDATE AT_RES_SUB SET 
                            res_spoint = '$startLocation[$i]', 
                            res_spointname = '$startLocation[$i]', 
                            res_epoint = '$endLocation[$i]', 
                            res_epointname = '$endLocation[$i]', 
                            upddate = now()
                                WHERE ressubseq = ".$ressubseq[$i];
        $result_set = mysqli_query($conn, $select_query);
        if(!$result_set) goto errGo;

        $subseq .= $ressubseq[$i].",";
    }

    $subseq .= '0';

	if(!$success){
        errGo:
		mysqli_query($conn, "ROLLBACK");
		echo '<script>alert("정류장 변경 처리 중 오류가 발생하였습니다.\n\n관리자에게 문의해주세요.");parent.fnPointChangeErr();</script>';
	}else{
		mysqli_query($conn, "COMMIT");

        $select_query = "SELECT a.user_name, a.user_tel, a.etc, a.user_email, b.* 
                            FROM AT_RES_MAIN as a INNER JOIN AT_RES_SUB as b 
                                ON a.resnum = b.resnum 
                            WHERE b.ressubseq IN ($subseq)
                            ORDER BY b.ressubseq";
        $result_setlist = mysqli_query($conn, $select_query);
        $count = mysqli_num_rows($result_setlist);

        if($count > 0){
            $PreMainNumber = "";
            $busStopInfo = "";
            $arrSeatInfo = array();
            while ($rowTime = mysqli_fetch_assoc($result_setlist)){
                $code = $rowTime['code'];
                $userName = $rowTime['user_name'];
                $userPhone = $rowTime['user_tel'];
                $user_email = $rowTime['user_email'];
                $sDate = $rowTime["res_date"];
                $shopname = $rowTime['shopname'];
                $etc = $rowTime["etc"];
                $res_confirm = $rowTime["res_confirm"];
        
                if($code == "bus"){
                    if(array_key_exists($sDate.$rowTime['res_bus'], $arrSeatInfo)){
                        $arrSeatInfo[$sDate.$rowTime['res_bus']] .= '     - '.$rowTime['res_seat'].'번\n';
                    }else{
                        $arrSeatInfo[$sDate.$rowTime['res_bus']] = '    ['.$sDate.'] '.fnBusNum($rowTime['res_bus']).'\n     - '.$rowTime['res_seat'].'번\n';
                    }

                    $arrData = explode("|", fnBusPoint($rowTime['res_spoint'], $rowTime['res_bus']));
                    $arrStopInfo[$rowTime['res_spoint']] = '    ['.$rowTime['res_spoint'].'] '.$arrData[0].'\n      - '.$arrData[1].'\n';
                }else{
                   
                }
            }
        
        //============================ 실행 단계 ============================
            if($code == "bus"){
                foreach($arrSeatInfo as $bus) {
                    $busSeatInfo .= $bus;
                }
                
                // 정류장 정보
                foreach($arrStopInfo as $x) {
                    $busStopInfo .= $x;
                }
        
                $resList =' ▶ 좌석안내\n'.$busSeatInfo;
                $info1_title = "좌석안내";
                $info1 = str_replace('      -', '&nbsp;&nbsp;&nbsp;-', str_replace('\n', '<br>', $busSeatInfo));

                if($res_confirm > 0){
                    $pointMsg = ' ▶ 탑승시간/위치 안내\n'.$busStopInfo;
                    $info2_title = "탑승시간/위치 안내";
                    $info2 = str_replace('      -', '&nbsp;&nbsp;&nbsp;-', str_replace('\n', '<br>', $busStopInfo));
                    
                }
                
                // 카카오톡 알림톡 발송
                $msgTitle = '액트립 '.$shopname.' 정류장변경 안내';
                $kakaoMsg = $msgTitle.'\n안녕하세요. '.$userName.'님\n\n액트립 예약정보 [정류장변경]\n ▶ 예약번호 : '.$ResNumber.'\n ▶ 예약자 : '.$userName.'\n'.$resList.$pointMsg.'---------------------------------\n ▶ 안내사항\n      - 정류장 변경이 완료되었으니 확인해주세요.\n\n ▶ 문의\n      - http://pf.kakao.com/_HxmtMxl';
            
                $arrKakao = array(
                    "gubun"=> "bus"
                    , "admin"=> "N"
                    , "smsTitle"=> $msgTitle
                    , "userName"=> $userName
                    , "tempName"=> "at_res_step1"
                    , "kakaoMsg"=>$kakaoMsg
                    , "userPhone"=> $userPhone
                    , "link1"=>"ordersearch?resNumber=".$ResNumber //예약조회/취소
                    , "link2"=>"eatlist" //제휴업체 목록
                    , "link3"=>"event" //공지사항
                    , "link4"=>""
                    , "link5"=>""
                    , "smsOnly"=>"N"
                );
                
                // 이메일 발송
                if(strrpos($user_email, "@") > 0){
                    $to .= $user_email;
                }

                $arrMail = array(
                    "gubun"=> "bus"
                    , "gubun_step" => 9
                    , "gubun_title" => $shopname
                    , "mailto"=> $to
                    , "mailfrom"=> "surfbus_point@actrip.co.kr"
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
            }else{

            }

            sendKakao($arrKakao); //알림톡 발송

            sendMail($arrMail); //메일 발송
        }
        
        echo '<script>alert("셔틀버스 정류장 변경이 완료되었습니다.");parent.location.href="/ordersearch?resNumber='.$ResNumber.'";</script>';
    }
}
?>