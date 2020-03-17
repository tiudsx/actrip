<div id="wrap">
    <? include '_layout_top.php'; ?>

    <link rel="stylesheet" href="css/surfview.css">

    <div class="top_area_zone">
        <? include '_layout_category.php'; ?>

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
                <h1>망고서프</h1>
                <a class="reviewlink">
                    <span class="reviewcnt">구매 <b>4,662</b>개</span>
                </a>
                <div class="shopsubtitle">입문강습 2시간 : 이론, 해변실습, 해양실습</div>
            </div>
        </section>

        <section class="notice">
            <div class="vip-tabwrap">
                <div id="tabnavi" class="fixed1" style="top: 49px;">
                    <div class="vip-tabnavi">
                        <ul>
                            <li class="on"><a onclick="fnResView(true, '#content_tab1', 69, this);">상세설명</a></li>
                            <li onclick="fnResView(true, '#shopmap', 500, this);"><a>위치안내</a></li>
                            <li onclick="fnResView(true, '#cancelinfo', 69, this);"><a>취소/환불</a></li>
                            <li onclick="fnResView(false, '#view_tab3', 69, this);"><a>예약하기</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="view_tab1">
                <div class="noticeline" id="content_tab1">
                    <p class="noticetxt">예약안내</p>
                    <article>
                        <p class="noticesub">예약 및 방문 안내</p>
                        <ul>
                            <li class="litxt">이용상품 예약 > 입금안내 카톡 발송 > 무통장 입금 > 확정안내 카톡 발송</li>
                            <li class="litxt">무통장 입금시 예약자와 입금자명이 동일해야 합니다.</li>
                            <li class="litxt">예약하신 이용일 샵 방문 시 확정안내 카톡 또는 이름/전화번호를 알려주시면 됩니다.</li>
                            <li class="litxt">강습 예약 시 강습시간 10분 전에 샵에 방문해주세요.</li>
                        </ul>
                    </article>
                    <article>
                        <p class="noticesub">서핑강습 준비물</p>
                        <ul>
                            <li class="litxt">슈트 안에 입을 수영복, 비키니, 래시가드 등</li>
                            <li class="litxt">개인 세면도구 (수건은 기본 한장 제공됩니다)</li>
                            <li class="litxt">선케어제품 (워터프루프 썬스틱 추천합니다)</li>
                            <li class="litxt">슬리퍼 (해변에서 물에 들어가기 위해 이동 시 필요합니다)</li>
                        </ul>
                    </article>
                </div>
                <div class="contentimg">
                    <img src="https://surfenjoy.cdn3.cafe24.com/surfshop/res_mangosurf_01.jpg?v=10" class="placeholder">
                </div>
                <div id="shopmap">
                    <iframe scrolling="no" frameborder="0" id="ifrmMap" name="ifrmMap" style="width:100%;height:390px;" src="surf/surfmap.html"></iframe>

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
                            <li class="litxt">우천시 정상적으로 서핑강습이 진행됩니다.</li>
                            <li class="litxt">천재지변으로 인하여 예약이 취소될 경우 전액환불해드립니다.</li>
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
            <div id="view_tab3" class="view_tab3" style="min-height: 800px;display: none;">
                test
            </div>
        </section>
    </div>
</div>

<div class="layG_kakao">
    <div class="fixedwidth kakaobtn" style="padding-right:15px;"><a href="https://pf.kakao.com/_HxmtMxl" target="_blank" rel="noopener"><img src="https://surfenjoy.cdn3.cafe24.com/icon/kakako.png?v=1" style="width: 38px;height: 38px;"></a>
    </div>
</div>
<div class="con_footer">
    <div class="fixedwidth resbottom">
        <button class="reson" id="slide1"><span>예약하기</span></button>
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