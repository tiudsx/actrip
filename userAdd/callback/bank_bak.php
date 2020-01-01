<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

function begin(){
	mysql_query("BEGIN");
}

function rollback(){
	mysql_query("ROLLBACK");
}

function commit(){
	mysql_query("COMMIT");
}

function smsHistory(){

}

$success = true;
$datetime = date('Y/m/d H:i'); 

$content = trim($_REQUEST["content"]);
$keyword = trim($_REQUEST["keyword"]);

mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

if($content == "" || $keyword == ""){
	exit;
}

$content = preg_replace('/\s+/u', ' ', $content);

$bankname = explode("@", $keyword)[0];
$arrSMS = explode("@", $content);

if($bankname == "신한"){
	//[Web발신]@신한 04/09 14:20@389-02-188735@입금         34@이승철
	$banknum = $arrSMS[2];

	$bankprice = explode(" ", $arrSMS[3])[1];
	$bankprice = str_replace(',', '', $bankprice);

	$bankuser = $arrSMS[4];
}else if($bankname == "농협"){
	//[Web발신]@농협 입금130,000원@04/09 14:20 351-****-8484-73 김보미 잔액1,124,000
	$bankprice = explode(" ", $arrSMS[1])[1];
	$bankprice = str_replace(',', '', $bankprice);
	$bankprice = str_replace('입금', '', $bankprice);
	$bankprice = str_replace('원', '', $bankprice);

	$banknum = explode(" ", $arrSMS[2])[2];
	$bankuser = explode(" ", $arrSMS[2])[3];
}else{
	$bankprice = "0";
	$banknum = "";
	$bankuser = "";
}

$select_query = "INSERT INTO `SURF_SMS`(`smscontent`, `keyword`, `shopSeq`, `bankprice`, `bankname`, `banknum`, `bankuser`, `insdate`) VALUES ('$content', '$keyword', 0, '$bankprice', '$bankname', '$banknum', '$bankuser', now())";
$result_set = mysqli_query($conn, $select_query);
$seq = mysqli_insert_id($conn);
//echo $select_query.'<br>';

if(!$result_set){
	mysqli_query($conn, "ROLLBACK");
	echo 'err';
}else{
	/*
	if($banknum == "389-02-188735" && $bankname == "신한"){ //셔틀, 바베큐 계좌 : 서프엔조이
		$resgubun = "surfbus";
		//ex : http://surfenjoy.com/userAdd/callback/bank.php?content=[Web발신]@신한 04/09 14:20@389-02-188735@입금 35100@이승철&keyword=신한@입금
	}else if($banknum == "351-****-8484-73" && $bankname == "농협"){ //야영장 : 이준영
		$resgubun = "camp";
		//ex : http://surfenjoy.com/userAdd/callback/bank.php?content=[Web발신]@농협 입금130,000원@04/09 14:20 351-****-8484-73 김보미 잔액1,124,000&keyword=농협@입금
	}else{
		$resgubun = "surfshop";
	}



	if($resgubun == "surfbus" || $resgubun == "camp"){		
		if($resgubun == "surfbus"){ //서핑버스 or 바베큐
			$subTable = "SURF_BUS_SUB";
			$gubunname = "서핑버스";

			$select_query = "SELECT * FROM SURF_BUS_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price FROM `SURF_BUS_SUB` WHERE ResConfirm = 0 GROUP BY MainNumber HAVING SUM(ResPrice) = $bankprice) as b
								ON a.MainNumber = b.MainNumber
								WHERE a.userName = '$bankuser'";
		}else{ //야영장
			$subTable = "SURF_CAMPING_SUB";
			$gubunname = "야영장";

			$select_query = "SELECT a.userName, b.* FROM SURF_CAMPING_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price, SUM(CASE WHEN ResOptPrice = '1@전기@5000' THEN 5000 ELSE 0 END) AS opt FROM `SURF_CAMPING_SUB` WHERE ResConfirm = 0 GROUP BY MainNumber) as b 
								ON a.MainNumber = b.MainNumber 
								WHERE (price + opt) = $bankprice AND userName = '$bankuser'";
		}
		//echo $select_query;
		$result_setlist = mysqli_query($conn, $select_query);
		$count = mysqli_num_rows($result_setlist);

		//바베큐 쿼리
		$select_query_bbq = "SELECT a.userName, a.shopSeq, b.* FROM SURF_SHOP_RES_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price FROM SURF_SHOP_RES_SUB WHERE ResConfirm = 1 GROUP BY MainNumber) as b 
							ON a.MainNumber = b.MainNumber 
							WHERE a.shopSeq = 5 AND price = $bankprice AND userName = '$bankuser'";
		
		$ResConfirm = 1;
		$shopSeq = 0;
		if($resgubun == "surfbus"){
			if($count == 0){
				$result_setlist = mysqli_query($conn, $select_query_bbq);
				$count = mysqli_num_rows($result_setlist);

				if($count > 0){		
					$resgubun = "surfbbq";
					$subTable = "SURF_SHOP_RES_SUB";
					$gubunname = "바베큐";
					$ResConfirm = 5;
					$shopSeq = 5;
				}
			}else{
				$result_setlist_bbq = mysqli_query($conn, $select_query_bbq);
				$count_bbq = mysqli_num_rows($result_setlist_bbq);
			}			
		}else{
			$count_bbq = 0;
		}

		if($count == 1){			
			while ($row = mysqli_fetch_assoc($result_setlist)){
				$MainNumber = $row['MainNumber'];

				$sql_shopSeq = "";
				if($resgubun == "surfbbq"){
					$sql_shopSeq = " AND ";
				}

				$select_query = "UPDATE ".$subTable." 
							   SET ResConfirm = ".$ResConfirm."
								  ,insdate = now()
								  ,udpdate = now()
								  ,udpuserid = 'autobank'
							WHERE MainNumber = ".$MainNumber." AND ResConfirm = 0;";

				//$result_set = mysqli_query($conn, $select_query);

				if(!$result_set){
					$success = false;
				}else{
					$select_query = "INSERT INTO `SURF_SMS_HISTORY`(`smscontent`, `keyword`, `shopSeq`, `goodstype`, `bankprice`, `bankname`, `banknum`, `bankuser`, `insdate`) VALUES ('$content', '$keyword', $shopSeq, '$resgubun', '$bankprice', '$bankname', '$banknum', '$bankuser', now())";
					$result_set = mysqli_query($conn, $select_query);

					$select_query = "DELETE FROM `SURF_SMS` WHERE seq = ".$seq;
					$result_set = mysqli_query($conn, $select_query);
				}
			}
			echo '<br>';
		}else if ($count > 1){ //같은 금액, 같은 이름 2명 이상
			while ($row = mysqli_fetch_assoc($result_setlist)){
				$MainNumber = $row['MainNumber'];

				$mailcontent .= 'seq : '.$seq.' / 주문번호 : '.$MainNumber.' / 이름 : '.$bankuser.' / 금액 : '.$bankprice.'<br>';
			}

			$select_query = "UPDATE `SURF_SMS` SET goodstype = '$resgubun', shopSeq = $shopSeq WHERE seq = ".$seq;
			$result_set = mysqli_query($conn, $select_query);

			$to = "lud1@naver.com";
			$arrMail = array(
				"campStayName"=> "surfbank"
				,"gubun"=> $gubunname
			);

			sendMail("surfbank@surfenjoy.com", "surfenjoy", $gubunname.'<br>'.$mailcontent, $to, $arrMail);

		}else if ($count == 0){ //금액, 이름이 없을 경우
			$select_query = "UPDATE `SURF_SMS` SET goodstype = '$resgubun', shopSeq = $shopSeq WHERE seq = ".$seq;
			$result_set = mysqli_query($conn, $select_query);

			$to = "lud1@naver.com";
			$arrMail = array(
				"campStayName"=> "surfbanknone"
				,"gubun"=> $gubunname
			);

			$mailcontent = "은행 : $bankname<br>계좌번호 : $banknum<br>입금자명 : $bankuser<br>금액 : $bankprice";

			sendMail("surfbank@surfenjoy.com", "surfenjoy", $gubunname.'<br>'.$mailcontent, $to, $arrMail);
		}

	}else if($resgubun == "surfshop"){ //서핑샵

	}
*/
	if(!$result_set){
		mysqli_query($conn, "ROLLBACK");
		echo 'err';
	}else{
		mysqli_query($conn, "COMMIT");
		echo '0';
	}
}

?>