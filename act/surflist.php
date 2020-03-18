<!-- area menu script -->
<script type="text/javascript">
    var type = "";
    var btnheight = "";

    $j(document).ready(function() {
        //지도로 보기 - 슬라이드
        $j("#slide1").click(function() {
            fnMapView('');
        });
    });

    function fnMapView(pointname){
        if (btnheight == "") btnheight = $j(".con_footer").height();
        if (type == "down") {
            $j(".con_footer").animate({
                height: btnheight + "px",
            }, {
                duration: 500,
                complete: function() {
                    $j("#slide1 span").html("지도로 보기");
                }
            });
            type = "";
        } else {
            $j(".con_footer").animate({
                height: "100%",
            }, {
                duration: 500,
                complete: function() {
                    $j("#slide1 span").html("지도 닫기");
                    $j(".resbottom").css("height", "100%");

                    if(pointname != ""){
                        var obj = $j("#ifrmMap").get(0);
                        var objDoc = obj.contentWindow || obj.contentDocument;
                        objDoc.mapMove(pointname);
                    }
                }
            });
            type = "down";
        }
    }
    
</script>

<div id="wrap">
<? include '_layout_top.php'; ?>

    <div class="top_area_zone">
        <div id="listWrap">
            
            <? include '_layout_category.php'; ?>

            <section id="popShop">
                <h2><img src="images/icon/moon.svg" alt=""> 인기 서핑샵 추천</h2>
                <ul class="listShop">
                    <li class="listShopbox">
                        <ul class="listItem shop01">
                            <li class="thumbnail">
                                <a href="/surfview"><img src="images/ocean.jpg" alt=""></a>
                                <span>
                                    <img src="images/icon/parking.svg" alt="">
                                    <img src="images/icon/wifi.svg" alt="">
                                    <img src="images/icon/house.svg" alt="">
                                    <img src="images/icon/pet.svg" alt="">
                                    <img src="images/icon/toilet.svg" alt="">
                                </span></li>
                            <li class="contents">

                                <h3><a href="/surfview">이본느비 서프 <i class="fas fa-angle-right"></i></a></h3>
                                <span><a href="javascript:fnMapView('모쿠서프');"><img src="images/icon/map.svg" alt="">위치</a></span>
                                <span>구매 1,040개</span>
                                <p>✓ 죽도해변만의 고퀄리티 입문강습</p>
                                <p>✓ 편안한 게스트하우스</p>
                            </li>
                            <li class="price">
                                <span class="lecture">
                                    <p><span>강습</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span> <span class="rental">
                                    <p><span>렌탈</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span>
                            </li>
                            <li class="event"><span>이벤트</span>10월 12일, 13일 양양 서핑 페스티벌</li>
                        </ul>
                        <ul class="listItem shop02">
                            <li class="thumbnail">
                                <a href="#"><img src="images/joasurf.jpg" alt=""></a>
                                <span>
                                    <img src="images/icon/parking.svg" alt="">
                                    <img src="images/icon/wifi.svg" alt="">
                                    <img src="images/icon/house.svg" alt="">
                                    <img src="images/icon/pet.svg" alt="">
                                    <img src="images/icon/toilet.svg" alt="">
                                </span>
                            </li>
                            <li class="contents">
                                <h3><a href="">이본느비 서프 <i class="fas fa-angle-right"></i></a></h3>
                                <span><a href=""><img src="images/icon/map.svg" alt="">죽도</a></span>
                                <span>구매 1,040개</span>
                                <p>✓ 죽도해변만의 고퀄리티 입문강습</p>
                                <p>✓ 편안한 게스트하우스</p>
                            </li>
                            <li class="price">
                                <span class="lecture">
                                    <p><span>강습</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span> <span class="rental">
                                    <p><span>렌탈</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span>

                            </li>
                            <li class="event"><span>이벤트</span>10월 12일, 13일 양양 서핑 페스티벌</li>
                        </ul>
                    </li>
                </ul>
            </section>
            <section id="allShop">
                <h2>#서핑샵 찾아보기</h2>
                <ul class="listShop">
                    <li class="listShopbox">
                        <ul class="listItem shop01">
                            <li class="thumbnail">
                                <a href="#"><img src="images/ocean.jpg" alt=""></a>
                                <span>
                                    <img src="images/icon/parking.svg" alt="">
                                    <img src="images/icon/wifi.svg" alt="">
                                    <img src="images/icon/house.svg" alt="">
                                    <img src="images/icon/pet.svg" alt="">
                                    <img src="images/icon/toilet.svg" alt="">
                                </span></li>
                            <li class="contents">

                                <h3><a href="">이본느비 서프 <i class="fas fa-angle-right"></i></a></h3>
                                <span><a href=""><img src="images/icon/map.svg" alt="">죽도</a></span>
                                <span>구매 1,040개</span>
                                <p>✓ 죽도해변만의 고퀄리티 입문강습</p>
                                <p>✓ 편안한 게스트하우스</p>
                            </li>
                            <li class="price">
                                <span class="lecture">
                                    <p><span>강습</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span> <span class="rental">
                                    <p><span>렌탈</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span>
                            </li>
                            <li class="event"><span>이벤트</span>10월 12일, 13일 양양 서핑 페스티벌</li>
                        </ul>
                        <ul class="listItem shop02">
                            <li class="thumbnail">
                                <a href="#"><img src="images/joasurf.jpg" alt=""></a>
                                <span>
                                    <img src="images/icon/parking.svg" alt="">
                                    <img src="images/icon/wifi.svg" alt="">
                                    <img src="images/icon/house.svg" alt="">
                                    <img src="images/icon/pet.svg" alt="">
                                    <img src="images/icon/toilet.svg" alt="">
                                </span>
                            </li>
                            <li class="contents">
                                <h3><a href="">이본느비 서프 <i class="fas fa-angle-right"></i></a></h3>
                                <span><a href=""><img src="images/icon/map.svg" alt="">죽도</a></span>
                                <span>구매 1,040개</span>
                                <p>✓ 죽도해변만의 고퀄리티 입문강습</p>
                                <p>✓ 편안한 게스트하우스</p>
                            </li>
                            <li class="price">
                                <span class="lecture">
                                    <p><span>강습</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span> <span class="rental">
                                    <p><span>렌탈</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span>

                            </li>
                            <li class="event"><span>이벤트</span>10월 12일, 13일 양양 서핑 페스티벌</li>
                        </ul>
                        <ul class="listItem shop03">
                            <li class="thumbnail">
                                <a href="#"><img src="images/joasurf.jpg" alt=""></a>
                                <span>
                                    <img src="images/icon/parking.svg" alt="">
                                    <img src="images/icon/wifi.svg" alt="">
                                    <img src="images/icon/house.svg" alt="">
                                    <img src="images/icon/pet.svg" alt="">
                                    <img src="images/icon/toilet.svg" alt="">
                                </span>
                            </li>
                            <li class="contents">
                                <h3><a href="">이본느비 서프 <i class="fas fa-angle-right"></i></a></h3>
                                <span><a href=""><img src="images/icon/map.svg" alt="">죽도</a></span>
                                <span>구매 1,040개</span>
                                <p>✓ 죽도해변만의 고퀄리티 입문강습</p>
                                <p>✓ 편안한 게스트하우스</p>
                            </li>
                            <li class="price">
                                <span class="lecture">
                                    <p><span>강습</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span> <span class="rental">
                                    <p><span>렌탈</span></p>
                                    <p>80,000원</p>
                                    <p>70,000원</p>
                                </span>

                            </li>
                            <li class="event"><span>이벤트</span>10월 12일, 13일 양양 서핑 페스티벌</li>
                        </ul>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</div>
<div class="con_footer">
    <div class="fixedwidth resbottom">
        <button class="reson" id="slide1"><span>지도로 보기</span></button>
        <div id="sildeing" style="display:block;height:100%;padding-top:10px;">
            <iframe scrolling="no" frameborder="0" class="ifrmMap" id="ifrmMap" name="ifrmMap" style="width:100%;height:100%;" src="/act/surf/surfmap.html"></iframe>
        </div>
    </div>
</div>

<? include '_layout_bottom.php'; ?>

<script>
var mapView = 0;
var sLng = "37.9726807";
var sLat = "128.7593755";
var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION2 = {
       '양양서핑페스티벌 - 초급강습'		: [MARKER_SPRITE_X_OFFSET*0, MARKER_SPRITE_Y_OFFSET*3, '37.9723728', '128.7599369', '죽도해변', '#뮤직페스티벌 #서핑강습 #양양서핑페스티벌', 0, 69, 'https://surfenjoy.cdn3.cafe24.com/yangfe2/surfshop_yangyang_500x500.jpg', '죽도'],'당찬패키지 #END'		: [MARKER_SPRITE_X_OFFSET*1, MARKER_SPRITE_Y_OFFSET*3, '37.9726807', '128.7593755', '죽도해변', '#당찬패키지  #해변바베큐파티 #서핑버스 ', 1, 64, 'https://surfenjoy.cdn3.cafe24.com/shop/surfenjoy_new_1.jpg?v=3', '죽도'],'핀스서프&카페'		: [MARKER_SPRITE_X_OFFSET*2, MARKER_SPRITE_Y_OFFSET*3, '37.9735445', '128.75893', '강원 양양군 현남면 인구중앙길 99', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 2, 8, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_fins_500x500.jpg', '죽도'],'서프오션'		: [MARKER_SPRITE_X_OFFSET*3, MARKER_SPRITE_Y_OFFSET*3, '37.9721365', '128.7607446', '강원도 양양군 현남면 새나루길 43', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 3, 53, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_surfocean_500x500.jpg', '죽도'],'씨맨서프'		: [MARKER_SPRITE_X_OFFSET*4, MARKER_SPRITE_Y_OFFSET*3, '37.9718897', '128.7615991', '강원도 양양군 현남면 새나루길 9-9', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 4, 56, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_seaman_500x500.jpg', '죽도'],'배럴서프스쿨'		: [MARKER_SPRITE_X_OFFSET*5, MARKER_SPRITE_Y_OFFSET*3, '37.9726845', '128.7592012', '강원도 양양군 현남면 인구중앙길 91', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 5, 55, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_barrel_500x500.jpg', '죽도'],'서퍼911'		: [MARKER_SPRITE_X_OFFSET*6, MARKER_SPRITE_Y_OFFSET*3, '37.9725146', '128.7591486', '강원 양양군 현남면 인구중앙길 89', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 6, 54, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_surfer911_500x500.jpg', '죽도'],'캔디서프'		: [MARKER_SPRITE_X_OFFSET*7, MARKER_SPRITE_Y_OFFSET*3, '37.972866', '128.7592002', '강원 양양군 현남면 인구중앙길 93 캔디서프', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 7, 7, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_candysurf_500x500.jpg', '죽도'],'조아서프'		: [MARKER_SPRITE_X_OFFSET*8, MARKER_SPRITE_Y_OFFSET*3, '37.9715175', '128.7594324', '강원 양양군 현남면 인구중앙길 79', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 8, 2, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_joasurf_500x500.jpg', '죽도'],'이스트사이드'		: [MARKER_SPRITE_X_OFFSET*9, MARKER_SPRITE_Y_OFFSET*3, '37.9718166', '128.7590159', '강원도 양양군 현남면 창리길 6', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 9, 57, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_eastside_500x500.jpg', '죽도'],'이스트쇼어'		: [MARKER_SPRITE_X_OFFSET*10, MARKER_SPRITE_Y_OFFSET*3, '37.9718335', '128.7623908', '강원도 양양군 현남면 새나루길 27', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 10, 59, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_eastshore_500x500.jpg', '죽도'],'모쿠서프'		: [MARKER_SPRITE_X_OFFSET*11, MARKER_SPRITE_Y_OFFSET*3, '37.9731043', '128.7591667', '강원 양양군 현남면 인구중앙길 89', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 11, 3, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_moku_500x500.jpg', '죽도'],'망고서프'		: [MARKER_SPRITE_X_OFFSET*12, MARKER_SPRITE_Y_OFFSET*3, '37.9732333', '128.7591064', '강원 양양군 현남면 인구중앙길 79', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 12, 4, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_mango_500x500.jpg', '죽도']    };
</script>