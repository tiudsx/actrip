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
                <ul>
                    <li class="regionTit"><a href="/surflist">양양</a></li>
                    <li><a href="/surflist">죽도</a></li>
                    <li><a href="/surflist">동산항</a></li>
                    <li><a href="/surflist">기사문</a></li>
                    <li><a href="/surflist">인구</a></li>
                    <li><a href="/surflist">남애</a></li>
                </ul>
                <ul>
                    <li class="regionTit"><a href="#">강릉</a></li>
                    <li><a href="#">주문진</a></li>
                </ul>
                <ul>
                    <li class="regionTit"><a href="#">동해</a></li>
                    <li><a href="#">대진</a></li>
                </ul>
                <ul class="regionReady">
                    <li><a href="#">준비중..</a></li>
                    <li>
                        <p>더 다양한 샵에서 만나요!</p>
                    </li>
                </ul>
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