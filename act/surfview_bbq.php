<div id="wrap">
    <? include '_layout_top.php'; ?>

    <link rel="stylesheet" href="css/surfview.css">

    <div class="top_area_zone">
        <section id="viewSlide">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="swiperimg swiper-slide" style="background-image:url(https://yaimg.yanolja.com/resize/place/v4/2017/08/24/06/640/599df9c8524630.94491845.jpg);">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiperimg swiper-slide" style="background-image:url(https://yaimg.yanolja.com/v5/2017/12/07/16/640/5a28f3efb2b4b6.48098605.jpg);">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiperimg swiper-slide" style="background-image:url(https://yaimg.yanolja.com/v5/2017/12/07/16/640/5a28f3f0f19e82.75213230.jpg);">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiperimg swiper-slide" style="background-image:url(https://yaimg.yanolja.com/v5/2017/12/07/16/640/5a28f3f234b378.27602610.jpg);">
                        </div>
                    </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
        <section class="shoptitle">
            <div style="padding:6px;">
                <h1>죽도해변 루프탑 바베큐파티</h1>
                <a class="reviewlink">
                    <span class="reviewcnt">구매 <b>4,662</b>개</span>
                </a>
                <div class="shopsubtitle">오션뷰 루프탑 바베큐파티와 함께 버스킹공연이 함께해요</div>
            </div>
        </section>

        <section class="notice">
            <div class="vip-tabwrap">
                <div id="tabnavi" class="fixed1" style="top: 49px;">
                    <div class="vip-tabnavi">
                        <ul>
                            <li class="on"onclick="fnResViewBus(true, '#content_tab1', 70, this);"><a>상세설명</a></li class="on">
                            <li onclick="fnResViewBus(false, '#view_tab2', 70, this);"><a>정류장안내</a></li>
                            <li onclick="fnResViewBus(true, '#cancelinfo', 70, this);"><a>취소/환불</a></li>
                            <li onclick="fnResViewBus(false, '#view_tab3', 70, this);"><a>예약하기</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="view_tab1">
                <div class="noticeline" id="content_tab1">
                    <p class="noticetxt">예약안내</p>
                    <article>
                        <p class="noticesub">예약안내</p>
                        <ul>
                            <li class="litxt">이용상품 예약 > 입금안내 카톡 발송 > 무통장 입금 > 확정안내 카톡 발송</li>
                            <li class="litxt">무통장 입금시 예약자와 입금자명이 동일해야합니다.</li>
                            <li class="litxt">예약하신 이용일, 바베큐파티장소를 꼭 확인해주세요.</li>
                        </ul>
                    </article>
                    <article>
                        <p class="noticesub">바베큐파티 이용안내</p>
                        <ul>
                            <li class="litxt">맥주나 음료는 제공되지 않으나 가지고 오셔서 드셔도 됩니다.</li>
                            <li class="litxt">메뉴는 인원에 따라 변경될 수 있습니다.</li>
                            <li class="litxt">미성년자 이용불가 / 신분증 확인!!</li>
                            <li class="litxt">루프탑 바베큐파티는 선착순 진행으로 인원 마감시 참여가 불가능합니다.</li>
                        </ul>
                    </article>
                </div>
                <div class="contentimg">
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus07.jpg" class="placeholder" />
                </div>
                <div id="shopmap">
                    <iframe scrolling="no" frameborder="0" id="ifrmMap" name="ifrmMap" style="width:100%;height:490px;" src="surf/surfmap.html"></iframe>

                    <div style="padding:10px 0 5px 0;font-size:12px;">
                        <a href="http://pf.kakao.com/_HxmtMxl" target="_blank" rel="noopener"><img src="images/kakaochat.jpg" class="placeholder"></a>
                    </div>
                </div>
                <div class="noticeline2" id="cancelinfo">
                    <p class="noticetxt">취소/환불 안내</p>
                    <article>
                        <p class="noticesub">취소 안내</p>
                        <ul>
                            <li class="litxt">1시간 이내 미입금시 자동취소됩니다.</li>
                            <li class="litxt">우천시 바베큐파티는 취소 될 수 있습니다.</li>
                            <li class="litxt">기상악화 및 천재지변으로 인하여 이용이 불가능할 경우 전액환불됩니다.</li>
                        </ul>
                    </article>
                    <article>
                        <p class="noticesub">환불 규정안내</p>
                        <ul>
                            <li class="refund"><img src="images/refund.jpg" alt=""></li>
                        </ul>
                    </article>
                </div>
            </div>
            <div id="view_tab3" class="view_tab3" style="min-height: 800px;display:none;">
                test
            </div>
        </section>
    </div>
</div>

<div class="con_footer">
    <div class="fixedwidth resbottom">
        <img src="https://surfenjoy.cdn3.cafe24.com/button/btnReserve.png" id="slide1"> 
    </div>
    <div id="sildeing" style="position:absolute;bottom:80px;display: none;">
    </div>
</div>

<? include '_layout_bottom.php'; ?>

<script src="js/surfview.js"></script>
<script>
var mapView = 1;
var sLng = "37.9726807";
var sLat = "128.7593755";
var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION2 = {
        '당찬패키지 #END': [0, MARKER_SPRITE_Y_OFFSET * 3, sLng, sLat, '죽도해변', '#당찬패키지  #해변바베큐파티 #서핑버스 ', 0, 64, 'https://surfenjoy.cdn3.cafe24.com/shop/surfenjoy_new_1.jpg?v=3', '죽도']
    };
</script>