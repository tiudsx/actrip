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
/*
GPS 오프 : OFF
GPS 미수신 : UNKNOWN
GPS 수신 : ON
*/
$success = true;
$datetime = date('Y/m/d H:i'); 

$lat = trim($_REQUEST["lat"]);
$lng = trim($_REQUEST["lng"]);
$user_name = trim(urldecode($_REQUEST["username"]));
$weeknum = trim($_REQUEST["weeknum"]);
$timenum = trim($_REQUEST["timenum"]);
$stats = trim($_REQUEST["stats"]);
$timestart = trim($_REQUEST["timestart"]);
$timeend = trim($_REQUEST["timeend"]);

mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

if($lat == "" || $lng == ""){
	//exit;
}

$select_query = "INSERT INTO SURF_BUS_GPS(`lat`, `lng`, `user_name`, `weeknum`, `timenum`, `insdate`, `stats`, `timestart`, `timeend`) VALUES ('$lat', '$lng', '$user_name', $weeknum, $timenum, now(), '$stats', $timestart, $timeend)";
$result_set = mysqli_query($conn, $select_query);
$seq = mysqli_insert_id($conn);
//echo $select_query.'<br>';

if($result_set){
	$select_query = "DELETE FROM SURF_BUS_GPS_BUS WHERE user_name = '$user_name' OR TIMESTAMPDIFF(MINUTE, insdate, now()) > 20";
	$result_set = mysqli_query($conn, $select_query);

	$select_query = "INSERT INTO SURF_BUS_GPS_BUS(`lat`, `lng`, `user_name`, `weeknum`, `timenum`, `insdate`, `stats`, `timestart`, `timeend`) VALUES ('$lat', '$lng', '$user_name', $weeknum, $timenum, now(), '$stats', $timestart, $timeend)";
	$result_set = mysqli_query($conn, $select_query);
}


if(!$result_set){
	mysqli_query($conn, "ROLLBACK");
	echo 'err';
}else{
	mysqli_query($conn, "COMMIT");
	echo '0';
}

?>