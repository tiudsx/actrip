<div id="wrap">
    <? include '_layout_top.php'; ?>

    <link rel="stylesheet" type="text/css" href="css/surfview.css">
    <link rel="stylesheet" type="text/css" href="css/surfview_bus.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />

    <div class="top_area_zone">
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
                    <!-- <p class="noticetxt">예약안내</p> -->
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
                            <li class="litxt">
                                <span>    
                                기상악화로 인하여 서핑강습이 취소되어도 셔틀버스는 정상운행되며, 기존 환불정책으로 적용됩니다.<br>
                                <span style="color:red;">단, 액트립에서 서핑강습이 사전예약 확정 된 경우 별도 환불정책으로 적용됩니다.</span>
                                </span>
                            </li>
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
                            <li class="litxt">최소인원(25명) 모집이 안될 경우 운행이 취소될 수 있으며, 전액 환불됩니다.</li>
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
            <div id="view_tab2" style="display: none;min-height: 800px;">
            
                <? include 'surf/surfview_bus_tab3.html'; ?>

            </div>
            <div id="view_tab3" class="view_tab3" style="min-height: 800px;display:none;">            
                <div class="busOption01">
                    <ul class="destination">
                        <li><img src="images/viewicon/route.svg" alt="">행선지</li>
                        <li class="toYang">양양행<i class="fas fa-chevron-right"></i></li>
                        <li class="toSeoul">서울행<i class="fas fa-chevron-right"></i></li>
                    </ul>
                    <ul class="busDate">
                        <li><img src="images/viewicon/calendar.svg" alt="">이용일</li>
                        <li class="calendar">
                            <input type="text" id="SurfBusY" name="SurfBusY" readonly="readonly" cal="busdate" gubun="y">
                            <input type="text" id="SurfBusS" name="SurfBusS" readonly="readonly" cal="busdate" gubun="s">
                        </li>
                    </ul>
                    <ul class="busLine">
                        <li><img src="images/viewicon/bus.svg" alt="">노선</li>
                        <li>사당선 1호</li>
                        <li>종로선 2호</li>
                        <li>사당선 3호</li>
                        <li>사당선 3호</li>
                        <li>사당선 3호</li>
                    </ul>
                    <ul class="busStop">
                        <li>여의도 &gt; 신도림 &gt; 구로디지털단지 &gt; 봉천역 &gt; 사당역 &gt; 강남역 &gt; 종합운동장역</li>
                        <li style="display: none;">여의도 &gt; 신도림 &gt; 구로디지털단지 &gt; 봉천역 &gt; 사당역 &gt; 강남역 &gt; 종합운동장역</li>
                        <li style="display: none;">여의도 &gt; 신도림 &gt; 구로디지털단지 &gt; 봉천역 &gt; 사당역 &gt; 강남역 &gt; 종합운동장역</li>
                    </ul>
                </div>
                <div class="busOption02">
                    <ul class="busSeat">버스 좌석 선택자리</ul>
                    <ul class="selectStop">
                        <li><img src="images/button/btn061.png" alt="양양행 서핑버스"></li>
                        <li>버스 정류장 선택자리</li>
                        <li><img src="images/button/btn062.png" alt="서울행 서핑버스"></li>
                        <li>버스 정류장 선택자리</li>
                    </ul>
                    </div>
                </div>
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

<script src="js/surfview_bus.js"></script>
<script src="js/surfview.js"></script>
<script src="js/jquery-ui.js"></script>
<script>
    var sbusDate = {
        "y0328":{type:0},
        "y0404":{type:0},
        "y0405":{type:0},
        "y0411":{type:0},
        "y0601":{type:0},
        "s0329":{type:0},
        "s0402":{type:0},
        "s0405":{type:0},
        "s0411":{type:0},
        "s0606":{type:0}
    };

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