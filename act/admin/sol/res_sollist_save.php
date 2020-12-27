<?php
include __DIR__.'/../../db.php';
include __DIR__.'/../../surf/surfkakao.php';
include __DIR__.'/../../surf/surfmail.php';

$success = true;
$datetime = date('Y/m/d H:i'); 

$param = $_REQUEST["resparam"];

$errmsg = "";
$intseq = "";
$intseq3 = "";
$to = "lud1@naver.com,ttenill@naver.com";

mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

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
}else if($param == "solrentyn"){ //렌탈 상태여부 변경
	$subseq = $_REQUEST["subseq"];
	$rentyn = $_REQUEST["rentyn"];

	$select_query = "UPDATE `AT_SOL_RES_SUB` SET surfrentYN = '".$rentyn."'
					WHERE ressubseq = ".$subseq.";";
	$result_set = mysqli_query($conn, $select_query);
	if(!$result_set) goto errGo;
	
	mysqli_query($conn, "COMMIT");

}else if($param == "soladd"){
	$res_adminname = $_REQUEST["res_adminname"];
	$user_name = $_REQUEST["user_name"];
	$user_tel = $_REQUEST["user_tel1"]."-".$_REQUEST["user_tel2"]."-".$_REQUEST["user_tel3"];

	$res_stayshop = $_REQUEST["res_stayshop"];
	$res_staysdate = $_REQUEST["res_staysdate"];
	$res_stayedate = $_REQUEST["res_stayedate"];
	$res_staysex = $_REQUEST["res_staysex"];
	$res_stayM = $_REQUEST["res_stayM"];
	$res_stayroom = $_REQUEST["res_stayroom"];
	$res_staynum = $_REQUEST["res_staynum"];
	$res_company = $_REQUEST["res_company"];
	$res_bbqdate = $_REQUEST["res_bbqdate"];
	$res_bbq = $_REQUEST["res_bbq"];

	$res_surfshop = $_REQUEST["res_surfshop"];
	$res_surfdate = $_REQUEST["res_surfdate"];
	$res_surftime = $_REQUEST["res_surftime"];
	$res_surfM = $_REQUEST["res_surfM"];
	$res_surfW = $_REQUEST["res_surfW"];
	$res_rent = $_REQUEST["res_rent"];
	$res_rentM = $_REQUEST["res_rentM"];
	$res_rentW = $_REQUEST["res_rentW"];

	$memo = $_REQUEST["memo"];
	$memo2 = $_REQUEST["memo2"];
	$res_confirm = $_REQUEST["res_confirm"];
	$res_kakao = $_REQUEST["res_kakao"];

	$kakaocnt = 0;
	if($res_kakao == "Y"){
		$kakaocnt ++;
	}

	//메인 정보 등록
    $select_query = "INSERT INTO `AT_SOL_RES_MAIN`(`admin_user`, `res_confirm`, `res_kakao`, `res_kakao_chk`, `res_room_chk`, `res_company`, `user_name`, `user_tel`, `memo`, `memo2`, `history`, `insdate`) VALUES ('$res_adminname', '$res_confirm', $kakaocnt, 'N', 'N', '$res_company', '$user_name', '$user_tel', '$memo', '$memo2', '', now())";
	$result_set = mysqli_query($conn, $select_query);
	$seq = mysqli_insert_id($conn);
	if(!$result_set) goto errGo;
	

	//숙박 & 바베큐 정보 등록
	for($i = 1; $i < count($res_stayshop); $i++){
		if(!($res_stayshop[$i] == "N" && $res_bbq[$i] == "N")){
			$prod_name = $res_stayshop[$i];
			$sdate = null;
			$edate = null;
			$resdate = null;
			$staysex = $res_staysex[$i];
			$stayroom = null;
			$staynum = null;
			$bbq = $res_bbq[$i];
			$stayM = $res_stayM[$i];

			if($res_stayshop[$i] != "N"){
				$sdate = $res_staysdate[$i];
				$edate = $res_stayedate[$i];
				$stayroom = $res_stayroom[$i];
				$staynum = $res_staynum[$i];

				$eDate2 = date("Y-m-d", strtotime($edate." -1 day"));
				$select_query = "SELECT * FROM AT_SOL_RES_MAIN as a INNER JOIN AT_SOL_RES_SUB as b
									ON a.resseq = b.resseq
									WHERE b.res_type = 'stay' 
										AND b.prod_name = '솔게스트하우스'
										AND b.stayroom = $stayroom
										AND b.staynum = $staynum
										AND a.res_confirm IN ('대기','확정')
										AND (('$sdate' BETWEEN b.sdate AND DATE_ADD(b.edate, INTERVAL -1 DAY) OR '$eDate2' BETWEEN b.sdate AND DATE_ADD(b.edate, INTERVAL -1 DAY))
											OR (b.sdate BETWEEN '$sdate' AND '$eDate2' OR DATE_ADD(b.edate, INTERVAL -1 DAY) BETWEEN '$sdate' AND '$eDate2'))";
				$result_setlist = mysqli_query($conn, $select_query);
				$count = mysqli_num_rows($result_setlist);
				// $errmsg = $select_query;
				// goto errGo;

				if($count > 0){
					goto errGoRoom;
				}
			}

			if($res_bbq[$i] != "N"){
				$resdate = $res_bbqdate[$i];
			}

			$select_query = "INSERT INTO `AT_SOL_RES_SUB`(`resseq`, `res_type`, `prod_name`, `sdate`, `edate`, `resdate`, `staysex`, `stayroom`, `staynum`, `bbq`, `stayM`) VALUES ($seq, 'stay', '$prod_name', '$sdate', '$edate', '$resdate', '$staysex', '$stayroom', '$staynum', '$bbq', $stayM)";
			$result_set = mysqli_query($conn, $select_query);
			if(!$result_set) goto errGo;
		}
	}

	
	//강습 & 렌탈 정보 등록
	for($i = 1; $i < count($res_surfshop); $i++){
		if(!($res_surfshop[$i] == "N" && $res_rent[$i] == "N")){
			$prod_name = $res_surfshop[$i];
			$resdate = null;
			$surfrent = $res_rent[$i];
			$restime = 0;
			$surfM = 0;
			$surfW = 0;
			$surfrentM = 0;
			$surfrentW = 0;

			if($res_surfshop[$i] != "N"){
				$resdate = $res_surfdate[$i];
				$restime = $res_surftime[$i];
				$surfM = $res_surfM[$i];
				$surfW = $res_surfW[$i];
			}

			if($res_rent[$i] != "N"){
				$resdate = $res_surfdate[$i];
				$surfrentM = $res_rentM[$i];
				$surfrentW = $res_rentW[$i];
			}

			$select_query = "INSERT INTO `AT_SOL_RES_SUB`(`resseq`, `res_type`, `prod_name`, `resdate`, `restime`, `surfM`, `surfW`, `surfrent`, `surfrentM`, `surfrentW`, `sdate`, `edate`) VALUES ($seq, 'surf', '$prod_name', '$resdate', '$restime', $surfM, $surfW, '$surfrent', $surfrentM, $surfrentW, '', '')";
			$result_set = mysqli_query($conn, $select_query);
			if(!$result_set) goto errGo;
		}
	}

	mysqli_query($conn, "COMMIT");

	//알림톡 발송 (확정일경우)
	if($res_kakao == "Y"){
	}
}

if(!$success){
	errGo:
	mysqli_query($conn, "ROLLBACK");
	echo "err|$errmsg";
}else if(!$success){
	errGoRoom:
	mysqli_query($conn, "ROLLBACK");
	echo "errRoom|$stayroom|$staynum";
}else{
	echo '0';
}

mysqli_close($conn);
?>
