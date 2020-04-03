<?php
include __DIR__.'/../db.php';
include __DIR__.'/../surf/surfkakao.php';
include __DIR__.'/../surf/surfmail.php';

$param = $_REQUEST["resparam"];
$InsUserID = ($_REQUEST["userId"] == "") ? $_REQUEST["userName"] : $_REQUEST["userId"];

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
	}else{
		return '서울행 '.$busNumber.'호차';
	}
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
*/

$success = true;
if($param == "BusI"){
	$ResNumber = '2'.time().substr(mt_rand(0, 99) + 100, 1, 2); //예약번호 랜덤생성

	$SurfDateBusY = $_REQUEST["hidbusDateY"]; //양양행 날짜
    $SurfDateBusS = $_REQUEST["hidbusDateS"]; //서울행 날짜
    
	$busNumY = $_REQUEST["hidbusNumY"]; //양양행 버스번호
    $busNumS = $_REQUEST["hidbusNumS"]; //서울행 버스번호
    
	$arrSeatY = $_REQUEST["hidbusSeatY"]; //양양행 좌석번호
    $arrSeatS = $_REQUEST["hidbusSeatS"]; //서울행 좌석번호
    
	$startLocationY = $_REQUEST["startLocationY"]; //양양행 출발 정류장
	$endLocationY = $_REQUEST["endLocationY"]; //양양행 도착 정류장
	$startLocationS = $_REQUEST["startLocationS"]; //서울행 출발 정류장
	$endLocationS = $_REQUEST["endLocationS"]; //서울행 도착 정류장

	$userName = $_REQUEST["userName"];
	$userId = $_REQUEST["userId"];
	$userPhone = $_REQUEST["userPhone1"]."-".$_REQUEST["userPhone2"]."-".$_REQUEST["userPhone3"];
	$usermail = $_REQUEST["usermail"];
	$etc = $_REQUEST["etc"];
	$datetime= date('Y/m/d H:i'); 

	$arrYDis = array();
	$arrYDisCnt = array();
	$arrSDis = array();
    $arrSDisCnt = array();
    
	$y = 0;
	for($i = 0; $i < count($SurfDateBusY); $i++){
        $select_query = 'SELECT res_spoint FROM AT_RES_SUB where res_date = "'.$SurfDateBusY[$i].'" AND res_bus = "'.$busNumY[$i].'" AND res_seat = "'.$arrSeatY[$i].'" AND res_confirm IN (0, 1, 2, 3)';
        //echo $select_query;
        $result_setlist = mysqli_query($conn, $select_query);
		$count = mysqli_num_rows($result_setlist);

		if($count > 0){
			echo '<script>alert("['.$SurfDateBusY[$i].'] '.$arrSeatY[$i].'번 좌석은 이미 예약된 자리입니다.\n\n다른좌석을 선택해주세요.");</script>';
			return;
		}

		if($arrYDis[$SurfDateBusY[$i]] == null){
			$arrYDis[$SurfDateBusY[$i]] = 1;

			$arrYDisCnt[$y] = $SurfDateBusY[$i];
			$y++;

		}else{
			$arrYDis[$SurfDateBusY[$i]] += 1;
		}
	}

	$y = 0;
	for($i = 0; $i < count($SurfDateBusS); $i++){
		$select_query = 'SELECT res_spoint FROM AT_RES_SUB where res_date = "'.$SurfDateBusS[$i].'" AND res_bus = "'.$busNumS[$i].'" AND res_seat = "'.$arrSeatS[$i].'" AND res_confirm IN (0, 1, 2, 3)';
		$result_setlist = mysqli_query($conn, $select_query);
		$count = mysqli_num_rows($result_setlist);

		if($count > 0){
			echo '<script>alert("['.$SurfDateBusS[$i].'] '.$arrSeatS[$i].'번 좌석은 이미 예약된 자리입니다.\n\n다른좌석을 선택해주세요.");</script>';
			return;
		}

		if($arrSDis[$SurfDateBusS[$i]] == null){
			$arrSDis[$SurfDateBusS[$i]] = 1;

			$arrSDisCnt[$y] = $SurfDateBusS[$i];
			$y++;			
		}else{
			$arrSDis[$SurfDateBusS[$i]] += 1;
		}
    }
    
	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$busSeatInfo = "";
	$busStopInfo = "";
	$arrSeatInfo = array();
	$arrStopInfo = array();
    $TotalPrice = 0;    

    $res_Price = 20000;
    $res_price_coupon = 0;
    $res_coupon = 0;
    $res_totalprice = $res_Price - $res_price_coupon;

    //양양행 좌석예약
    for($i = 0; $i < count($SurfDateBusY); $i++){
        $TotalPrice += $res_totalprice;
        $select_query = "INSERT INTO `AT_RES_SUB` (`resnum`, `code`, `seq`, `optseq`, `shopname`, `sub_title`, `optname`, `optsubname`, `res_date`, `res_time`, `res_bus`, `res_busnum`, `res_seat`, `res_spoint`, `res_spointname`, `res_epoint`, `res_epointname`, `res_confirm`, `res_price`, `res_price_coupon`, `res_coupon`, `res_totalprice`, `res_ea`, `res_m`, `res_w`, `rtn_charge_yn`, `rtn_chargeprice`, `rtn_totalprice`, `rtn_bankinfo`, `cashreceipt_yn`, `insuserid`, `insdate`, `upduserid`, `upddate`)  VALUES ('$ResNumber', 'bus', 7, null, '양양서핑버스', null, null, null, '$SurfDateBusY[$i]', null, '$busNumY[$i]', '$busNumY[$i]', '$arrSeatY[$i]', '$startLocationY[$i]', '$startLocationY[$i]', '$endLocationY[$i]', '$endLocationY[$i]', 0, $res_Price, $res_price_coupon, $res_coupon, $res_totalprice, 1, 0, 0, 'Y', 0, 0, null, 'N', '$InsUserID', '$datetime', '$InsUserID', '$datetime');";
        $result_set = mysqli_query($conn, $select_query);
        //echo $select_query.'<br>';
        if(!$result_set) goto errGo;
    
        if(array_key_exists($SurfDateBusY[$i].$busNumY[$i], $arrSeatInfo)){
            $arrSeatInfo[$SurfDateBusY[$i].$busNumY[$i]] .= '      - '.$arrSeatY[$i].'번 ('.$startLocationY[$i].' -> '.$endLocationY[$i].')\n';
        }else{
            $arrSeatInfo[$SurfDateBusY[$i].$busNumY[$i]] = '    ['.$SurfDateBusY[$i].'] '.fnBusNum($busNumY[$i]).'\n      - '.$arrSeatY[$i].'번 ('.$startLocationY[$i].' -> '.$endLocationY[$i].')\n';
        }

        $arrData = explode("|", fnBusPoint($startLocationY[$i], $busNumY[$i], 0));
        $arrStopInfo[$startLocationY[$i]] = '    ['.$startLocationY[$i].'] '.$arrData[0].'\n      - '.$arrData[1].'\n';
    }
    
    //서울행 좌석예약
    for($i = 0; $i < count($SurfDateBusS); $i++){
        $TotalPrice += $res_totalprice;
        $select_query = "INSERT INTO `AT_RES_SUB` (`resnum`, `code`, `seq`, `optseq`, `shopname`, `sub_title`, `optname`, `optsubname`, `res_date`, `res_time`, `res_bus`, `res_busnum`, `res_seat`, `res_spoint`, `res_spointname`, `res_epoint`, `res_epointname`, `res_confirm`, `res_price`, `res_price_coupon`, `res_coupon`, `res_totalprice`, `res_ea`, `res_m`, `res_w`, `rtn_charge_yn`, `rtn_chargeprice`, `rtn_totalprice`, `rtn_bankinfo`, `cashreceipt_yn`, `insuserid`, `insdate`, `upduserid`, `upddate`)  VALUES ('$ResNumber', 'bus', 7, null, '양양서핑버스', null, null, null, '$SurfDateBusS[$i]', null, '$busNumS[$i]', '$busNumS[$i]', '$arrSeatS[$i]', '$startLocationS[$i]', '$startLocationS[$i]', '$endLocationS[$i]', '$endLocationS[$i]', 0, $res_Price, $res_price_coupon, $res_coupon, $res_totalprice, 1, 0, 0, 'Y', 0, 0, null, 'N', '$InsUserID', '$datetime', '$InsUserID', '$datetime');";
        $result_set = mysqli_query($conn, $select_query);
        //echo $select_query.'<br>';
        if(!$result_set) goto errGo;

        if(array_key_exists($SurfDateBusS[$i].$busNumS[$i], $arrSeatInfo)){
            $arrSeatInfo[$SurfDateBusS[$i].$busNumS[$i]] .= '      - '.$arrSeatS[$i].'번 ('.$startLocationS[$i].' -> '.$endLocationS[$i].')\n';
        }else{
            $arrSeatInfo[$SurfDateBusS[$i].$busNumS[$i]] = '    ['.$SurfDateBusS[$i].'] '.fnBusNum($busNumS[$i]).'\n      - '.$arrSeatS[$i].'번 ('.$startLocationS[$i].' -> '.$endLocationS[$i].')\n';
        }

        $arrData = explode("|", fnBusPoint($startLocationS[$i], $busNumS[$i], 0));
        $arrStopInfo[$startLocationS[$i]] = '    ['.$startLocationS[$i].'] '.$arrData[0].'\n      - '.$arrData[1].'\n';
    }

    $select_query = "INSERT INTO `AT_RES_MAIN` (`resnum`, `pay_type`, `pay_info`, `user_id`, `user_name`, `user_tel`, `user_email`, `etc`, `insuserid`, `insdate`) VALUES ('$ResNumber', 'B', '무통장입금', '$InsUserID', '$userName', '$userPhone', '$usermail', '$etc', '$InsUserID', '$datetime');";
    //echo $select_query.'<br>';
    $result_set = mysqli_query($conn, $select_query);
    if(!$result_set) goto errGo;

	if(!$success){
        errGo:
		mysqli_query($conn, "ROLLBACK");
		echo '<script>alert("예약진행 중 오류가 발생하였습니다.\n\n관리자에게 문의해주세요.");</script>';
	}else{
		mysqli_query($conn, "COMMIT");

        // 예약좌석 정보
		foreach($arrSeatInfo as $x) {
			$busSeatInfo .= $x;
		}

        // 정류장 정보
		foreach($arrStopInfo as $x) {
			$busStopInfo .= $x;
		}

		$pointMsg = ' ▶ 탑승시간/위치 안내\n'.$busStopInfo;
		if($etc != ''){
			$etcMsg = ' ▶ 특이사항\n      '.$etc.'\n';
		}
        
        $kakaoMsg = '액트립 양양서핑버스 예약안내\n안녕하세요. '.$userName.'님\n\n액트립 예약정보 [입금대기]\n ▶ 예약번호 : '.$ResNumber.'\n ▶ 예약자 : '.$userName.'\n ▶ 좌석안내\n'.$busSeatInfo.$pointMsg.$etcMsg.'---------------------------------\n ▶ 안내사항\n      - 1시간 이내 미입금시 자동취소됩니다.\n\n ▶ 입금계좌\n      - 우리은행 / 1002-845-467316 / 이승철\n\n ▶ 문의\n      - http://pf.kakao.com/_HxmtMxl';

        $arrKakao = array(
            "gubun"=> "bus"
            , "admin"=> "N"
            , "smsTitle"=> "양양서핑버스 입금대기 안내"
            , "userName"=> "이승철"
            , "tempName"=> "at_res_step1"
            , "kakaoMsg"=>$kakaoMsg
            , "userPhone"=> "010-4437-0009"
            , "link1"=>"ordersearch"
            , "link2"=>"ordersearch"
            , "link3"=>"notice"
            , "link4"=>""
            , "link5"=>""
        );
        sendKakao($arrKakao);

		// $to = "lud1@naver.com,ttenill@naver.com";
		// if(strrpos($usermail, "@") > 0){
		// 	$to .= ','.$usermail;
		// }

		// $arrMail = array(
		// 	"campStayName"=> "busStay1"
		// 	, "userName"=> $userName
		// 	, "busSeatInfo"=> str_replace('\n', '<br>', $busSeatInfo)
		// 	, "busStopInfo"=> str_replace('\n', '<br>', $busStopInfo)
		// 	, "ResNumber"=> $ResNumber
		// 	, "gubun"=>"양양셔틀버스"
		// 	, "userPhone"=>$userPhone
		// 	, "etc"=>$etc
		// 	, "totalPrice"=>number_format($TotalPrice).'원'
		// 	, "banknum"=>"신한은행 / 389-02-188735 / 이승철"
		// );

		//endMail("surfbus1@surfenjoy.com", "surfenjoy", sendMailContentBus($arrMail), $to, $arrMail);
        echo '<script>alert("양양 셔틀버스 예약이 완료되었습니다.");parent.location.href="/ordersearch?resNumber='.$ResNumber.'";</script>';
	}


}else if($param == "Cancel"){ //일괄 취소
	//======== 환불 요청
	mysqli_query($conn, "SET AUTOCOMMIT=0");
	mysqli_query($conn, "BEGIN");

	$chkCancel = $_REQUEST["chkCancel"];
	$bankName = $_REQUEST["bankName"];
	$bankUserName = $_REQUEST["bankUserName"];
	$bankNum = $_REQUEST["bankNum"];
	$hidtotalPrice = $_REQUEST["hidtotalPrice"];

	$busSeq = "";
	$MainNumber = "";
	$ResConfirm = "";

	for($i = 0; $i < count($chkCancel); $i++){
		$arrData = explode("|",$chkCancel[$i]);
        $busSeq .= $arrData[1].",";

		$MainNumber = $arrData[2];
		$userName = $arrData[3];
	}
	$busSeq .= '0';

	$TotalPrice = 0; //총 이용금액
	$cancelTotalPrice = 0; //환불수수료
	$rtntotalPrice = 0; //환불금액

	if($InsUserID == ""){
		$InsUserID = $userName;
	}
	//================ 셔틀정보 메인 & 바베큐 정보 End ================

	$busSeatInfo = "";
	$busStopInfo = "";
	$arrSeatInfo = array();

	$select_query_sub = 'SELECT * FROM SURF_BUS_SUB where subintseq IN ('.$busSeq.') AND MainNumber = '.$ResNumber.' AND ResConfirm = 1 ORDER BY busDate, busSeat';
	$resultSite = mysqli_query($conn, $select_query_sub);
	$chkSubCnt = mysqli_num_rows($resultSite); //버스 좌석 카운트

	if($chkSubCnt > 0){
		while ($rowSub = mysqli_fetch_assoc($resultSite)){
			if(array_key_exists($rowSub['busDate'].$rowSub['busNum'], $arrSeatInfo)){
				$arrSeatInfo[$rowSub['busDate'].$rowSub['busNum']] .= '    - '.$rowSub['busSeat'].'번\n';
			}else{
				$arrSeatInfo[$rowSub['busDate'].$rowSub['busNum']] = '   ['.$rowSub['busDate'].'] '.fnBusNum($rowSub['busNum']).'\n    - '.$rowSub['busSeat'].'번\n';
			}

			$busCancelPrice = cancelPrice($rowSub['busDate'], $rowSub['insdate'], $rowSub['ResPrice'], 2, $rowSub['ResConfirm']);
			$busRtnPrice = $rowSub['ResPrice'] - $busCancelPrice;

			$TotalPrice += $rowSub['ResPrice'];
			$cancelTotalPrice += $busCancelPrice;

			if($success){
				$select_query = "UPDATE `SURF_BUS_SUB` 
							   SET ResConfirm = CASE ResConfirm
													WHEN 0 THEN 3
													WHEN 1 THEN 2
												END
								,RtnCancelPrice = ".$busCancelPrice."
								,RtnPrice = ".$busRtnPrice."
								,RtnBank = '".$FullBankText."'
								,udpdate = now()
								,udpuserid = '".$InsUserID."'
							WHERE subintseq = ".$rowSub['subintseq'].";";
				$result_set = mysqli_query($conn, $select_query);
				if(!$result_set) $success = false;
			}
		}

		foreach($arrSeatInfo as $x) {
			$busSeatInfo .= $x;
		}

		$busSeatInfo = '  ▶ 취소 좌석안내\n'.$busSeatInfo;
    }
    
	$cancelPrice = '  ▶ 환불금액 안내\n   - 총 이용금액 : '.number_format($TotalPrice).'원\n   - 환불수수료 : '.number_format($cancelTotalPrice).'원\n   - 환불금액 : '.number_format($TotalPrice-$cancelTotalPrice).'원\n';

	$rtnBank = '\n   -';
	if($bankName != ''){
		$rtnBank = '\n   - 환불계좌 : '.$bankName.' / '.$bankNum.' / '.$bankUserName;
	}

	//================ 취소/환불요청 정보 업데이트 ================
	if($success && $busSeq != '0'){
		$select_query = "UPDATE `SURF_BUS_SUB` 
					   SET ResConfirm = 3
						  ,udpdate = now()
						  ,udpuserid = '".$InsUserID."'
					WHERE subintseq IN (".$busSeq.") AND ResConfirm = 0;";
		$result_set = mysqli_query($conn, $select_query);
		if(!$result_set) $success = false;
	}


	if(!$success){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");

		if($chkSubCnt > 0){
			$campStayName = "busCancel1";
			$kakaoMsg1 = '안녕하세요! 서프엔조이입니다.\n예약하신 양양셔틀버스 취소/환불요청 안내입니다.\n\n서프엔조이 취소/환불 정보\n  ▶ 예약번호 : '.$ResNumber.'\n  ▶ 예약자 : '.$userName.'\n'.$busSeatInfo.$cancelPrice.'---------------------------------\n  ▶ 안내사항'.$rtnBank.'\n\n  ▶ 문의\n    - 010.3308.6080\n    - http://pf.kakao.com/_HxmtMxl';

			sendKakao($campStayName, "surfenjoy_res", $kakaoMsg1, $userPhone, $ResNumber, "surfbus", "link2", "link3");

			$to = "lud1@naver.com,ttenill@naver.com";
			if(strrpos($usermail, "@") > 0){
				$to .= ','.$usermail;
			}

			$arrMail = array(
				"campStayName"=> "busCancel1"
				, "userName"=> $userName
				, "busSeatInfo"=> str_replace('\n', '<br>', $busSeatInfo)
				, "busStopInfo"=> str_replace('\n', '<br>', $busStopInfo)
				, "ResNumber"=> $ResNumber
				, "gubun"=>"양양셔틀버스"
				, "userPhone"=>$userPhone
				, "etc"=>$etc
				, "banknum"=>$bankName.' / '.$bankNum.' / '.$bankUserName
				, "totalPrice"=>'총 이용금액 : '.number_format($TotalPrice).'원<br>환불수수료 : '.number_format($cancelTotalPrice).'원<br>환불금액 : '.number_format($TotalPrice-$cancelTotalPrice).'원'
			);

			sendMail("surfcancel@surfenjoy.com", "surfenjoy", sendMailContentBus($arrMail), $to, $arrMail);
		}

		echo '0';
	}
}else if($param == "Return"){ //환불요청

}

mysqli_close($conn);
?>
