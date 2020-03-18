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
                <h1>액트립 양양 서핑버스</h1>
                <a class="reviewlink">
                    <span class="reviewcnt">구매 <b>4,662</b>개</span>
                </a>
                <div class="shopsubtitle">서울 - 양양 셔틀버스 운행 : 5월 ~ 9월, 지정좌석제</div>
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
                            <li onclick="fnResViewBus(false, '#view_tab3', 70, this);"><a>셔틀예약</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="view_tab1">
                <div class="noticeline" id="content_tab1">
                    <p class="noticetxt">예약안내</p>
                    <article>
                        <p class="noticesub">셔틀버스 예약안내</p>
                        <ul>
                            <li class="litxt">이용상품 예약 > 입금안내 카톡 발송 > 무통장 입금 > 확정안내 카톡 발송</li>
                            <li class="litxt">무통장 입금시 예약자와 입금자명이 동일해야합니다.</li>
                            <li class="litxt">예약하신 이용일, 탑승정류장, 탑승시간을 꼭 확인해주세요.</li>
                        </ul>
                    </article>
                    <article>
                        <p class="noticesub">탑승 및 이용안내</p>
                        <ul>
                            <li class="litxt">탑승시간 5분전에 예약하신 정류장으로 도착해주세요.</li>
                            <li class="litxt">교통상황으로 인해 셔틀버스가 지연 도착할 수 있으니 양해부탁드립니다.</li>
                            <li class="litxt">사전 신청하지 않는 정류장은 정차 및 하차하지 않습니다.</li>
                            <li class="litxt">기상악화로 인하여 서핑강습이 취소되어도 셔틀버스는 정상운행되며, 기존 환불정책으로 적용됩니다.<br>
                                단, 액트립에서 서핑강습이 사전예약 확정 된 경우 별도 환불정책으로 적용됩니다.</li>
                        </ul>
                    </article>
                </div>
                <div class="contentimg">
                    <img src="https://surfenjoy.cdn3.cafe24.com/bus/res_bus01.jpg" class="placeholder">
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus03.jpg" class="placeholder" style="cursor:pointer;">
                    <img src="https://surfenjoy.cdn3.cafe24.com/bus/res_bus04.jpg" class="placeholder">
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus05.jpg" class="placeholder" style="cursor:pointer;"/>
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus06.jpg" class="placeholder" />
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus07.jpg" class="placeholder" />
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus08.jpg" class="placeholder" />
                </div>
                <div class="noticeline2" id="cancelinfo">
                    <p class="noticetxt">취소/환불 안내</p>
                    <article>
                        <p class="noticesub">취소 안내</p>
                        <ul>
                            <li class="litxt">1시간 이내 미입금시 자동취소됩니다.</li>
                            <li class="litxt">최소인원(25명) 모집이 안될 경우 운행이 취소될 수 있습니다. 운행 취소시 전액 환불됩니다.</li>
                            <li class="litxt">천재지변으로 인하여 셔틀버스 운행이 취소될 경우 전액환불됩니다.</li>
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
<style>
.bd, .bd input, .bd textarea, .bd select, .bd button, .bd table {
    padding: 0px;
}

.bd table {
    border-spacing: 0;
    border-collapse: collapse;
}

.et_vars{width:100%;margin-bottom:8px;}

.et_vars th, .et_vars td {
    padding: 6px;
    border: 1px solid #DDD;
    word-break: break-all;
    word-wrap: break-word;
    line-height: 1.2rem;
}
.et_vars th{
    background-color: #efefef;
}
.et_vars td {
    background: #FFF;
}
.bd_btn:hover, .bd_btn:focus {
    border-color: #AAA;
    box-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.bd .bd_btn{line-height:1.5;padding: 0 10px 10px 10px;}

.bd_btn{height:28px;margin:0;background:linear-gradient(to bottom,#FFF 0%,#F3F3F3 100%);border:1px solid;border-color:#CCC #C6C6C6 #C3C3C3 #CCC;border-radius:3px;white-space:nowrap;cursor:pointer;text-decoration:none !important;text-align:center;text-shadow:0 0px 0 #FFF;box-shadow:inset 0 0 1px 1px #FFF,0 1px 1px rgba(0,0,0,.1);}
</style>
            <div id="view_tab2" style="display: none;min-height: 800px;">
                <div style="display: block;padding-top:5px;">
                    <div class="bd">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="border:0px none;line-height:1.5;">
                                        <strong><font color="#ff0000">※ </font></strong>
                                        <span style="color: rgb(255, 0, 0);font-size:12px;"><strong>정류장 [지도]를 클릭하시면 네이버 지도 및 정류장 위치 사진을 볼 수 있습니다.</strong></span><br>
                                        <font color="#ff0000" style="font-size:12px;"><strong>&nbsp;&nbsp;&nbsp;교통상황으로 인해 셔틀버스가 지연 도착할 수 있으니 양해부탁드립니다.</strong></font><br><br>
                                        <strong>※ </strong><font style="font-size:12px;"><strong>사전 신청하지 않는 정류장은 정차 및 하차하지 않습니다.</strong></font><br><br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bd">
                        <table class="et_vars">
                            <colgroup>
                                <col style="width:33%;">
                                <col style="width:33%;">
                                <col style="width:34%;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th colspan="2" style="text-align: center;">
                                        <strong style="line-height:2;">
                                            ★ 서울 → 양양
                                        </strong>
                                    </th>
                                    <th style="text-align: center;">
                                        <strong style="line-height:2;">
                                            ★ 양양 → 서울
                                        </strong>
                                    </th>
                                </tr>
                                <tr>
                                    <td style="text-align:center;"><input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;background:#1973e1;color:#fff;" value="사당선" onclick="fnBusPoint(this);"></td>
                                    <td style="text-align:center;"><input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="왕십리선" onclick="fnBusPoint(this);"></td>
                                    <td style="text-align:center;"><input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="서울행" onclick="fnBusPoint(this);"></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bd" style="padding:10px 0 0px 0;">	
                        <table view="tbBus1" class="et_vars">
                            <colgroup>
                                <col style="width:90px;">
                                <col style="width:auto;">
                                <col style="width:58px;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td colspan="3" height="28"><b>★ [양양행] 사당선 출발 셔틀버스</b></td>
                                </tr>
                                <tr>
                                    <th style="text-align:center;"></th>
                                    <th style="text-align:center;">탑승장소 및 시간</th>
                                    <th style="text-align:center;">위치</th>
                                </tr>
                                <tr>
                                    <th>여의도</th>
                                    <td>여의도공원 횡단보도<br><font color="red">06시 40분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 1, 1, '여의도', this);"></td>
                                </tr>
                                <tr>
                                    <th>신도림</th>
                                    <td>홈플러스 신도림점 앞<br><font color="red">06시 50분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 2, 1, '신도림', this);"></td>
                                </tr>
                                <tr>
                                    <th>대림역</th>
                                    <td>동대문엽기떡볶이 앞 버스정류장<br><font color="red">07시 05분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 3, 1, '구로디지털단지', this);"></td>
                                </tr>
                                <tr>
                                    <th>봉천역</th>
                                    <td>봉천역 1번출구 앞<br><font color="red">07시 20분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 4, 1, '봉천역', this);"></td>
                                </tr>
                                <tr>
                                    <th>사당역</th>
                                    <td>신한성약국 앞<br><font color="red">07시 30분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 5, 1, '사당역', this);"></td>
                                </tr>
                                <tr>
                                    <th>강남역</th>
                                    <td>강남역 1번출구 버스정류장<br><font color="red">07시 45분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 6, 1, '강남역', this);"></td>
                                </tr>
                                <tr>
                                    <th>종합운동장역</th>
                                    <td>종합운동장역 4번출구 방향 버스정류장<br><font color="red">08시 00분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 7, 1, '종합운동장역', this);"></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table view="tbBus1" class="et_vars">
                            <tbody>
                                <tr>
                                    <td height="28" style="border: 0px solid #DDD;"><b>★ 도착정류장
                                        <br><span style="padding-left:30px;">하조대 &gt; 기사문 &gt; 동산항 &gt; 죽도 &gt; 인구 &gt; 남애3리 &gt; 주문진</span></b></td>
                                </tr>
                            </tbody>
                        </table>                                

                        <table view="tbBus2" class="et_vars" style="display: none;">
                            <colgroup>
                                <col style="width:90px;">
                                <col style="width:auto;">
                                <col style="width:58px;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td colspan="3" height="28"><b>★ [양양행] 왕십리선 출발 셔틀버스</b></td>
                                </tr>
                                <tr>
                                    <th style="text-align:center;"></th>
                                    <th style="text-align:center;">탑승장소 및 시간</th>
                                    <th style="text-align:center;">위치</th>
                                </tr>
                                <tr>
                                    <th>당산역</th>
                                    <td>당산역 13출구 앞<br><font color="red">05시 40분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 1, 2, '당산역', this);"></td>
                                </tr>
                                <tr>
                                    <th>합정역</th>
                                    <td>합정역 3번출구 앞<br><font color="red">05시 45분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 2, 2, '합정역', this);"></td>
                                </tr>
                                <tr>
                                    <th>신촌역</th>
                                    <td>신촌역 5번출구 앞<br><font color="red">05시 55분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 3, 2, '신촌역', this);"></td>
                                </tr>
                                <tr>
                                    <th>충정로역</th>
                                    <td>충정로역 4번출구 앞<br><font color="red">06시 05분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 4, 2, '충정로역', this);"></td>
                                </tr>
                                <tr>
                                    <th>종로3가역</th>
                                    <td>종로3가역 12번출구 새마을금고 앞<br><font color="red">06시 20분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 5, 2, '종로3가역', this);"></td>
                                </tr>
                                <tr>
                                    <th>왕십리역</th>
                                    <td>왕십리역 11번출구 우리은행 앞<br><font color="red">06시 40분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 6, 2, '왕십리역', this);"></td>
                                </tr>
                                <tr>
                                    <th>건대입구역</th>
                                    <td>건대입구역 롯데백화점 스타시티점 입구<br><font color="red">07시 00분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 7, 2, '건대입구역', this);"></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table view="tbBus2" class="et_vars" style="display: none;">
                            <tbody>
                                <tr>
                                    <td height="28" style="border: 0px solid #DDD;"><b>★ 도착정류장<br><span style="padding-left:30px;">하조대 &gt; 기사문 &gt; 동산항 &gt; 죽도 &gt; 인구 &gt; 남애3리 &gt; 주문진</span></b></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table view="tbBus3" class="et_vars" style="display: none;">
                            <colgroup>
                                <col style="width:90px;">
                                <col style="width:auto;">
                                <col style="width:58px;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td colspan="3" height="28"><b>★ [서울행] 서울행 출발 셔틀버스</b></td>
                                </tr>
                                <tr>
                                    <th style="text-align:center;"></th>
                                    <th style="text-align:center;">탑승장소 및 시간</th>
                                    <th style="text-align:center;">위치</th>
                                </tr>
                                <tr>
                                    <th>주문진해변</th>
                                    <td>청시행비치 주차장 입구<br><font color="red">14시 15분 / 17시 15분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('S', 1, 1, '주문진해변', this);"></td>
                                </tr>
                                <tr>
                                    <th>남애해변</th>
                                    <td>남애3리 입구<br><font color="red">14시 30분 / 17시 30분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('S', 2, 1, '남애해변', this);"></td>
                                </tr>
                                <tr>
                                    <th>인구해변</th>
                                    <td>현남보건지소 맞은편<br><font color="red">14시 35분 / 17시 35분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('S', 3, 1, '인구해변', this);"></td>
                                </tr>
                                <tr>
                                    <th>죽도해변</th>
                                    <td>GS25 죽도비치점 맞은편<br><font color="red">14시 40분 / 17시 40분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('S', 4, 1, '죽도해변', this);"></td>
                                </tr>
                                <tr>
                                    <th>동산항해변</th>
                                    <td>동산항해변 입구<br><font color="red">14시 45분 / 17시 45분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('S', 5, 1, '동산항해변', this);"></td>
                                </tr>
                                <tr>
                                    <th>기사문해변</th>
                                    <td>기사문 해변주차장 입구<br><font color="red">14시 50분 / 17시 50분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('S', 6, 1, '기사문해변', this);"></td>
                                </tr>
                                <tr>
                                    <th>하조대해변</th>
                                    <td>서피비치 회전교차로 횡단보도 앞<br><font color="red">15시 00분 / 18시 00분</font></td>
                                    <td><input type="button" class="bd_btn mapviewid" style="padding-top:4px;" value="지도" onclick="fnBusMap('S', 7, 1, '하조대해변, this');"></td>
                                </tr>
                            </tbody>
                        </table>

                        <table view="tbBus3" class="et_vars" style="display: none;">
                            <tbody>
                                <tr>
                                    <td height="28" style="border: 0px solid #DDD;"><b>★ 도착정류장<br><span style="padding-left:30px;">잠실역 > 종합운동장역 > 강남역 > 사당역 > 당산역 > 합정역</span></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <img style="max-width:100%;display:none;padding-bottom:10px;" id="mapimg" src="https://surfenjoy.cdn3.cafe24.com/busimg/Y1_1.JPG">

                    <iframe scrolling="no" frameborder="0" id="ifrmBusMap" name="ifrmBusMap" style="width:100%;height:400px;display:none;" src="surf/surfbusmap.php"></iframe>
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
            '당찬패키지 #END'		: [0, MARKER_SPRITE_Y_OFFSET*3, sLng, sLat, '죽도해변', '#당찬패키지  #해변바베큐파티 #서핑버스 ', 0, 64, 'https://surfenjoy.cdn3.cafe24.com/shop/surfenjoy_new_1.jpg?v=3', '죽도']
        };

    function fnBusPoint(obj) {
        $j("input[btnpoint='point']").css("background", "").css("color", "");
        $j(obj).css("background", "#1973e1").css("color", "#fff");

        $j("table[view='tbBus1']").css("display", "none");
        $j("table[view='tbBus2']").css("display", "none");
        $j("table[view='tbBus3']").css("display", "none");
        
        if($j(obj).val() == "사당선"){
            $j("table[view='tbBus1']").css("display", "");

            fnBusMap('Y', 1, 1, '여의도', ".mapviewid:eq(0)", "false");
        }else if ($j(obj).val() == "왕십리선") {
            $j("table[view='tbBus2']").css("display", "");
            fnBusMap('Y', 1, 2, '당산역', ".mapviewid:eq(7)", "false");
        }else{
            $j("table[view='tbBus3']").css("display", "");
            fnBusMap('S', 1, 1, '주문진해변', ".mapviewid:eq(14)", "false");
        }
    }

    function fnBusMap(gubun, num, busnum, pointname, obj, bool) {
        $j("#mapimg").css("display", "block");
        $j("#mapimg").attr("src", "https://surfenjoy.cdn3.cafe24.com/busimg/" + gubun + busnum + "_" + num + ".JPG");
       
        $j(".mapviewid").css("background", "").css("color", "");
        $j(obj).css("background", "#1973e1").css("color", "#fff");
        
        $j("#ifrmBusMap").css("display", "block");
        var obj = $j("#ifrmBusMap").get(0);
        var objDoc = obj.contentWindow || obj.contentDocument;
        objDoc.mapMove(pointname);

        if(bool != "false"){
            fnMapView('#mapimg', 40);
        }
    }
</script>