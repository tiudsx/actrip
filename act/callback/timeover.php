<?php
include __DIR__.'/../db.php';
include __DIR__.'/../surf/surfkakao.php';
include __DIR__.'/../surf/surfmail.php';
include __DIR__.'/../surf/surffunc.php';


$success = true;
$datetime = date('Y/m/d H:i'); 

$user_name = trim(urldecode($_REQUEST["username"]));
$weeknum = trim($_REQUEST["weeknum"]);
$timenum = trim($_REQUEST["timenum"]);
$timestart = trim($_REQUEST["timestart"]);
$timeend = trim($_REQUEST["timeend"]);

$select_query = "DELETE FROM AT_CALL_TIMEOVER WHERE TIMESTAMPDIFF(DAY, insdate, now()) > 8";
$result_set = mysqli_query($conn, $select_query);


$select_query = "INSERT INTO AT_CALL_TIMEOVER(`user_name`, `weeknum`, `timenum`, `insdate`, `stats`, `timestart`, `timeend`, `sqlquery`) VALUES ('$user_name', $weeknum, $timenum, now(), 'OK', $timestart, $timeend, '')";
$result_set = mysqli_query($conn, $select_query);
$seq = mysqli_insert_id($conn);

mysqli_query($conn, "COMMIT");

//============================ 실행 ============================
mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

$errChk = "01";
$countChk = "";

//==== 액트립 예약건 자동취소 : 1시간 체크 ====
$ressubseq = "";
$select_query = 'SELECT a.user_name, a.user_tel, a.etc, b.* 
                    FROM AT_RES_MAIN as a INNER JOIN AT_RES_SUB as b 
                        ON a.resnum = b.resnum 
                    WHERE b.res_confirm = 0
                        AND TIMESTAMPDIFF(MINUTE, b.insdate, now()) > 60
                    ORDER BY b.resnum, b.res_date, b.ressubseq';
$query_log .= '조회 AT_RES_SUB : '.$select_query;

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

$k = 0;
if($count > 0){
	$x = 0;
	$PreMainNumber = "";
	$arrSeatInfo = array();
	while ($rowTime = mysqli_fetch_assoc($result_setlist)){
		$MainNumber = $rowTime['resnum'];

//============================ 실행 단계 ============================
		if($MainNumber != $PreMainNumber && $x > 0){
			if($code == "bus"){
                foreach($arrSeatInfo as $bus) {
                    $busSeatInfo .= $bus;
                }
        
                $resList =' ▶ 좌석안내\n'.$busSeatInfo;
                $subtitlename = '액트립';
            }else{
                $resList =' ▶ 신청목록\n'.$surfshopMsg;
                $subtitlename = $shopname;
            }
        
            $msgTitle = '액트립 '.$shopname.' 자동취소 안내';
            $kakaoMsg = $msgTitle.'\n안녕하세요. '.$userName.'님\n\n'.$subtitlename.' 예약정보 [자동취소]\n ▶ 예약번호 : '.$PreMainNumber.'\n ▶ 예약자 : '.$userName.'\n'.$resList.'---------------------------------\n ▶ 안내사항\n      - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n ▶ 문의\n      - http://pf.kakao.com/_HxmtMxl';
        
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
            // sendKakao($arrKakao);

            $surfshopMsg = "";
			$busSeatInfo = "";
			$arrSeatInfo = array();

			$k++;
		}
//============================ 실행 단계 ============================
        
		$code = $rowTime['code'];
		$userName = $rowTime['user_name'];
		$userPhone = $rowTime['user_tel'];
		$sDate = $rowTime["res_date"];
        $shopname = $rowTime['shopname'];
        $optname = $rowTime["optname"];

        if($code == "bus"){
            if(array_key_exists($sDate.$rowTime['res_bus'], $arrSeatInfo)){
                $arrSeatInfo[$sDate.$rowTime['res_bus']] .= '     - '.$rowTime['res_seat'].'번\n';
            }else{
                $arrSeatInfo[$sDate.$rowTime['res_bus']] = '    ['.$sDate.'] '.fnBusNum($rowTime['res_bus']).'\n     - '.$rowTime['res_seat'].'번\n';
            }
        }else{
            $ResNum = "      - 인원 : ";
            if($rowTime['res_m'] > 0){
                $ResNum .= "남:".$rowTime['res_m'].'명';
            }
            if($rowTime['res_m'] > 0 && $rowTime['res_w'] > 0){
                $ResNum .= ",";
            }
            if($rowTime['res_w'] > 0){
                $ResNum .= "여:".$rowTime['res_w'].'명';
            }
            $ResNum .= '\n';

            $surfshopMsg .= '    ['.$optname.']\n      - 예약일 : '.$sDate.'\n'.$ResNum.'\n';
        }

        $x++;

		$PreMainNumber = $rowTime['resnum'];
		$ressubseq .= $rowTime['ressubseq'].',';
	}
	$ressubseq .= '0';

//============================ 실행 단계 ============================
    if($code == "bus"){
        foreach($arrSeatInfo as $bus) {
            $busSeatInfo .= $bus;
        }

        $resList =' ▶ 좌석안내\n'.$busSeatInfo;
        $subtitlename = '액트립';
    }else{
        $resList =' ▶ 신청목록\n'.$surfshopMsg;
        $subtitlename = $shopname;
    }

    $msgTitle = '액트립 '.$shopname.' 자동취소 안내';
    $kakaoMsg = $msgTitle.'\n안녕하세요. '.$userName.'님\n\n'.$subtitlename.' 예약정보 [자동취소]\n ▶ 예약번호 : '.$MainNumber.'\n ▶ 예약자 : '.$userName.'\n'.$resList.'---------------------------------\n ▶ 안내사항\n      - 입금마감시간이 지나서 자동취소가 되었습니다.\n\n ▶ 문의\n      - http://pf.kakao.com/_HxmtMxl';

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
    // sendKakao($arrKakao);

	$k++;
//============================ 실행 단계 ============================

	$success = true;
	$select_query = "UPDATE `AT_RES_SUB` 
                        SET res_confirm = 7
                            ,upddate = now()
                            ,upduserid = 'timeover'
                        WHERE ressubseq IN (".$ressubseq.")";

	$query_log .= '
                    자동취소 AT_RES_SUB : '.str_replace("'", '"',$select_query);

	$result_set = mysqli_query($conn, $select_query);

	$errChk .= "|07";
    if(!$result_set) $success = false;
    
    $countChk .= "@".$code."|".$k;   
}

$select_query = "UPDATE AT_CALL_TIMEOVER SET success = '".$success."', stats = '".$errChk."', gubuncount = '".$countChk."', sqlquery = '".$query_log."' WHERE seq = ".$seq;
// echo $success.'<br><br>'.$query_log.'<br><br>'.$select_query;
$result_set = mysqli_query($conn, $select_query);

if(!$success){
	mysqli_query($conn, "ROLLBACK");
	$success = 'err';
}else{
	mysqli_query($conn, "COMMIT");
	$success = 'ok';
}
// $query_log = '';

//mysqli_query($conn, "COMMIT");
?>