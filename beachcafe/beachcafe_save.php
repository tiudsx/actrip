<?php

$conn = mysqli_connect('localhost', 'surfenjoy', 'dltmdcjf2@', 'surfenjoy');

$orderNum = $_REQUEST["orderNum"];
$drinCode = $_REQUEST["drinCode"];
$drinkCount = $_REQUEST["drinkCount"];
$orderType = $_REQUEST["orderType"];
$turnNum = $_REQUEST["turnNum"];

$select_query = "INSERT INTO `CAFE_ORDER`(`ORDER_NUM`, `DRINK_CODE`, `DRINK_CNT`, `ORDER_TYPE`, `TURN_NUM`) VALUES ('$orderNum','$drinCode','$drinkCount','$orderType','$turnNum')";
$result_set = mysqli_query($conn, $select_query);

if(!$result_set){
    mysqli_query($conn, "ROLLBACK");
    echo 'err';
}else{
    mysqli_query($conn, "COMMIT");
    echo '0';
}


?>