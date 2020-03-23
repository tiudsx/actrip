<? include 'db.php'; ?>

<?
//정렬순서
$select_query = "SELECT a.code as area, a.codename as areaname, b.code, b.codename, b.lat, b.lng
    FROM AT_CODE a INNER JOIN AT_CODE b
        ON a.uppercode = 'surf'
            AND a.code = b.uppercode
            AND a.use_yn = 'Y'
            AND b.use_yn = 'Y'
        ORDER BY a.ordernum, b.ordernum";

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

$precode = "";
$areahtml = "";
while ($row = mysqli_fetch_assoc($result_setlist)){
    if($precode != $row["area"]){
        if($precode != "") $areahtml .= "</ul>";

        $areahtml .= "<ul><li class='regionTit'><a href='/surflist?code=".$row["code"]."'>".$row["areaname"]."</a></li>";
    }

    $areahtml .= "<li><a href='/surflist?code=".$row["code"]."'>".$row["codename"]."</a></li>";
    $precode = $row["area"];
}
$areahtml .= "</ul>";
?>

<!-- area menu script -->
<script type="text/javascript">
    $j(document).ready(function() {
    });
</script>

<div id="wrap">
<? include '_layout_top.php'; ?>
<link rel="stylesheet" type="text/css" href="/act/css/surfshop.css">

    <div class="top_area_zone">
        <section id="shopCat">
            <div class="shopCatTit">
                <h2>서핑강습/렌탈</h2>
                <p>지역·해변별 서핑샵 찾기 <i class="fas fa-caret-down"></i></p>
            </div>
            <div class="shopCatList">
                <?=$areahtml?>
                <!--ul class="regionReady">
                    <li><a href="#">준비중..</a></li>
                    <li>
                        <p>더 다양한 샵에서 만나요!</p>
                    </li>
                </ul-->
            </div>
        </section>
        <section id="popShop">
            <h2><i class="far fa-thumbs-up"></i> 인기서핑샵</h2>
            <div class="popShopSldr">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="#">
                            <img src="images/sample.png" alt="">
                            <p>양양 죽도</p>
                            <p>이본느비서프</p>
                            <p>10,000원</p>
                        </a></div>
                    <div class="swiper-slide"><a href="#">
                            <img src="images/sample.png" alt="">
                            <p>양양 죽도</p>
                            <p>이본느비서프</p>
                            <p>10,000원</p>
                        </a></div>
                    <div class="swiper-slide"><a href="#">
                            <img src="images/sample.png" alt="">
                            <p>양양 죽도</p>
                            <p>이본느비서프</p>
                            <p>10,000원</p>
                        </a></div>
                    <div class="swiper-slide"><a href="#">
                            <img src="images/sample.png" alt="">
                            <p>양양 죽도</p>
                            <p>이본느비서프</p>
                            <p>10,000원</p>
                        </a></div>
                    <div class="swiper-slide"><a href="#">
                            <img src="images/sample.png" alt="">
                            <p>양양 죽도</p>
                            <p>이본느비서프</p>
                            <p>10,000원</p>
                        </a></div>
                    <div class="swiper-slide"><a href="#">
                            <img src="images/sample.png" alt="">
                            <p>양양 죽도</p>
                            <p>이본느비서프</p>
                            <p>10,000원</p>
                        </a></div>

                </div>
            </div>
        </section>
        <section id="popBeach">
            <h2>추천해변</h2>
            <ul>
                <li><a href="#"><span>#</span>죽도해변</a></li>
                <li><a href="#"><span>#</span>인구해변</a></li>
                <li><a href="#"><span>#</span>기사문해변</a></li>
                <li><a href="#"><span>#</span>주문진해변</a></li>
                <li><a href="#"><span>#</span>남애해변</a></li>
            </ul>
        </section>

    </div>
</div>

<? include '_layout_bottom.php'; ?>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.popShopSldr', {
        slidesPerView: 3,
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        }
    });
</script>