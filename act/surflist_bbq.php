<?php 
include 'db.php';

$resNumber = $_REQUEST["resNumber"];
?>

<script>
$j(document).ready(function(){
    
});
</script>

<script src="js/surfordersearch.js"></script>

<div id="wrap">
    <? include '_layout_top.php'; ?>

    <link rel="stylesheet" type="text/css" href="css/surfbbq.css">

    <div class="top_area_zone">
        <section id="bbq">
            <h2><img src="https://surfenjoy.cdn3.cafe24.com/act_title/bbq.png" alt="액트립 바베큐파티"></h2>
            <span class="coupon"><a href="https://cafe.naver.com/actrip/375" target="_blank"><img src="images/icon/coupon.svg" alt="">액트립 제휴쿠폰 모음<i class="fas fa-angle-right"></i></a></span>
        </section>
        <section id="bbqCat">
            <div class="bbqCatList">
                <ul>
                    <li class="yybbq"><a href="/bbq_yy"><img src="images/button/bbqjukdo.jpg" alt="죽도 바베큐파티"></a></li>
                    <li class="solbbq"><a href="/bbq_dh"><img src="images/button/bbqsol.jpg" alt="동해 바베큐파티"></a></li>
                </ul>
            </div>
        </section>
    </div>
</div>

<? include '_layout_bottom.php'; ?>