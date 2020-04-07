<?php
include __DIR__.'/../db.php';
include __DIR__.'/../surf/surffunc.php';

//$NextDate = date("Y-m-d", strtotime(date("Y-m-d")." +7 day"));
$NextDate = date("Y-m-d", strtotime(date("Y-m-d")." +1 month"));

echo '<br>서핑버스 할인코드 : https://actrip.co.kr/coupon?coupon='.urlencode(encrypt($NextDate.'|1|BUS'));
echo '<br><br>서핑샵 할인코드 : https://actrip.co.kr/coupon?coupon='.urlencode(encrypt($NextDate.'|2|SURF'));
echo '<br><br>바베큐 할인코드 : https://actrip.co.kr/coupon?coupon='.urlencode(encrypt($NextDate.'|3|BBQ'));
?>