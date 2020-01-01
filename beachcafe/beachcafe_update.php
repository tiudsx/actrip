<?php

$conn = mysqli_connect('localhost', 'surfenjoy', 'dltmdcjf2@', 'surfenjoy');

$updateType = $_REQUEST["type"];
$result_set = true;

if ($updateType == "cancel") {
    $orderNum = $_REQUEST["orderNum"];
    $select_query = "UPDATE `CAFE_ORDER` SET `STATE`='N' WHERE ORDER_NUM = ".$orderNum;
    $result_set = mysqli_query($conn, $select_query);
}
else if($updateType == "end"){
    $orderNum = $_REQUEST["orderNum"];
    $select_query = "UPDATE `CAFE_ORDER` SET `STATE`='Y' WHERE ORDER_NUM = ".$orderNum;
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