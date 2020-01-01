<?php

$conn = mysqli_connect('localhost', 'surfenjoy', 'dltmdcjf2@', 'surfenjoy');

$select_query = "SELECT MAX(ORDER_NUM)+1 AS MAXNUM FROM `CAFE_ORDER` WHERE `REG_DATE` > CURDATE()";
$result_setlist = mysqli_query($conn, $select_query);
$orderNum = mysqli_fetch_array($result_setlist)["MAXNUM"];

echo $orderNum;


?>