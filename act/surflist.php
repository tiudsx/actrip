<!-- area menu script -->
<script type="text/javascript">
    $j(document).ready(function() {
        //지도로 보기 - 슬라이드
        var type = "";
        var btnheight = "";
        $j("#slide1").click(function() {
            if (btnheight == "") btnheight = $j(".con_footer").height();
            if (type == "down") {
                $j(".con_footer").animate({
                    height: btnheight + "px",
                }, {
                    duration: 500,
                    complete: function() {}
                });
                type = "";
            } else {
                $j(".con_footer").animate({
                    height: "100%",
                }, {
                    duration: 500,
                    complete: function() {}
                });
                type = "down";
            }
        });
    });
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
                                <span><a href="/surfview"><img src="images/icon/map.svg" alt="">죽도</a></span>
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

<div class="layG_kakao">
    <div class="fixedwidth kakaobtn" style="padding-right:15px;"><a href="https://pf.kakao.com/_HxmtMxl" target="_blank" rel="noopener"><img src="https://surfenjoy.cdn3.cafe24.com/icon/kakako.png?v=1" style="width: 38px;height: 38px;"></a>
    </div>
</div>
<div class="con_footer">
    <div class="fixedwidth resbottom">
        <button class="reson" id="slide1"><span>지도로 보기</span></button>
    </div>
    <div id="sildeing" style="position:absolute;bottom:80px;display: none;">
    </div>
</div>

<? include '_layout_bottom.php'; ?>