<? include 'db.php'; ?>

<?
$param_mid = $_REQUEST["mid"];

if($param_mid == ""){
	$param = str_replace("/", "", $_SERVER["REQUEST_URI"]);

	if (!empty(strpos($_SERVER["REQUEST_URI"], '?'))){
		$param = substr($param, 0, strpos($_SERVER["REQUEST_URI"], '?') - 1);
	}

	$param = explode('_', $param)[0];
}else{
	$param = $param_mid;
}

if($param == "surfbus"){ //양양 셔틀버스
    $bustitle = "액트립 양양 서핑버스";
    $bussubinfo = "서울 - 양양 셔틀버스 운행 : 5월 ~ 9월, 지정좌석제";
    $pointurl = "surf/surfview_bus_tab3.html";
    $busgubun = "Y";
    $sbusDate = "2020-05-01";
}else{ //동해 셔틀버스
    $bustitle = "액트립 동해 서핑버스";
    $bussubinfo = "서울 - 동해 셔틀버스 운행 : 6월 ~ 8월, 지정좌석제";
    $pointurl = "surf/surfview_bus_tab3_2.html";
    $busgubun = "E";
    $sbusDate = "2020-06-01";
}

$select_query = "SELECT * FROM AT_PROD_MAIN WHERE seq = 7 AND use_yn = 'Y'";
$result = mysqli_query($conn, $select_query);
$rowMain = mysqli_fetch_array($result);
?>
<div id="wrap">
    <? include '_layout_top.php'; ?>

    <link rel="stylesheet" type="text/css" href="css/surfview.css">
    <link rel="stylesheet" type="text/css" href="css/surfview_bus.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />

    <div class="top_area_zone">
        <section class="shoptitle">
            <div style="padding:6px;">
                <h1><?=$bustitle?></h1>
                <a class="reviewlink">
                    <span class="reviewcnt">구매 <b><?=number_format($rowMain["sell_cnt"])?></b>개</span>
                </a>
                <div class="shopsubtitle"><?=$bussubinfo?></div>
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
                <?if($param == "surfbus"){?>
                    <img src="https://surfenjoy.cdn3.cafe24.com/bus/res_bus01.jpg" class="placeholder">
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus03.jpg" class="placeholder" style="cursor:pointer;">
                    <img src="https://surfenjoy.cdn3.cafe24.com/bus/res_bus04.jpg" class="placeholder">
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus05.jpg" class="placeholder" style="cursor:pointer;"/>
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus06.jpg" class="placeholder" />
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus07.jpg" class="placeholder" />
                    <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus08.jpg" class="placeholder" />
                <?}else{?>

                <?}?>
                </div>
                <div id="shopmap">
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
            
                <? include $pointurl; ?>

            </div>
            <div id="view_tab3" class="view_tab3" style="min-height: 800px;display:none;">            
                <div class="busOption01" style="padding-bottom: 0px;">
                    <ul class="destination" style="margin-bottom: 0px;">
                        <li><img src="images/viewicon/route.svg" alt="">행선지</li>
                    <?if($param == "surfbus"){?>
                        <li class="toYang on" onclick="fnBusGubun('Y', this);">양양행<i class="fas fa-chevron-right"></i></li>
                        <li class="toYang" onclick="fnBusGubun('S', this);">서울행<i class="fas fa-chevron-right"></i></li>
                    <?}else{?>
                        <li class="toYang on" onclick="fnBusGubun('E', this);">동해행<i class="fas fa-chevron-right"></i></li>
                        <li class="toYang" onclick="fnBusGubun('A', this);">서울행<i class="fas fa-chevron-right"></i></li>
                    <?}?>
                    </ul>
                </div>
                <div id="layerbus1" class="busOption01" style="padding-top: 10px;">
                    <ul class="busDate">
                        <li><img src="images/viewicon/calendar.svg" alt="">이용일</li>
                        <li class="calendar"><input type="text" id="SurfBus" name="SurfBus" readonly="readonly" class="itx" cal="busdate" gubun="<?=$busgubun?>" ></li>
                    </ul>
                    <ul class="busStop" id="busnotdate">
                        <li>서핑버스 이용날짜를 선택하세요.</li>
                    </ul>
                    <ul class="busLine" style="display: none;">
                        <li><img src="images/viewicon/bus.svg" alt="">노선</li>
                    </ul>
                    <ul class="busStop" id="buspointlist" style="display: none;">
                        <li id="buspointtext"></li>
                    </ul>
                </div>
                <div class="busOption02">
                    <ul class="busSeat">
                        <div class="busSeatTable">
                            <div style="padding-bottom:155px;"></div>
                            <table style="width:312px;margin-left:7px;" id="tbSeat">
                                <colgroup>
                                    <col style="width:60px;height:68px;">
                                    <col style="width:60px;height:68px;">
                                    <col style="width:60px;height:68px;">
                                    <col style="width:60px;height:68px;">
                                    <col style="width:60px;height:68px;">
                                </colgroup>
                                <tbody>

                                <?
                                $chkSeat = "";
                                for($i=0; $i<=10; $i++){
                                    $num1 = ($i * 4) + 1;
                                    $num2 = ($i * 4) + 2;
                                    $num3 = ($i * 4) + 3;
                                    $num4 = ($i * 4) + 4;
                                    $num5 = ($i * 4) + 5;

                                    if($i == 10){
                                ?>
                                    <tr height="68" id="busSeatLast">
                                        <td class="busSeatList busSeatListN" valign="top" onclick="fnSeatSelected(this);" style="font-weight: 700;" busSeat="<?=$num1?>"><br><?=$num1?></td>
                                        <td class="busSeatList busSeatListN" valign="top" onclick="fnSeatSelected(this);" style="font-weight: 700;" busSeat="<?=$num2?>"><br><?=$num2?></td>
                                        <td class="busSeatList busSeatListN" valign="top" onclick="fnSeatSelected(this);" style="font-weight: 700;" busSeat="<?=$num3?>"><br><?=$num3?></td>
                                        <td class="busSeatList busSeatListN" valign="top" onclick="fnSeatSelected(this);" style="font-weight: 700;" busSeat="<?=$num4?>"><br><?=$num4?></td>
                                        <td class="busSeatList busSeatListN" valign="top" onclick="fnSeatSelected(this);" style="font-weight: 700;" busSeat="<?=$num5?>"><br><?=$num5?></td>
                                    </tr>
                                <?
                                    }else{
                                ?>
                                    <tr height="68">
                                        <td class="busSeatList busSeatListN" valign="top" onclick="fnSeatSelected(this);" style="font-weight: 700;" busSeat="<?=$num1?>"><br><?=$num1?></td>
                                        <td class="busSeatList busSeatListN" valign="top" onclick="fnSeatSelected(this);" style="font-weight: 700;" busSeat="<?=$num2?>"><br><?=$num2?></td>
                                        <td>&nbsp;</td>
                                        <td class="busSeatList busSeatListN" valign="top" onclick="fnSeatSelected(this);" style="font-weight: 700;" busSeat="<?=$num3?>"><br><?=$num3?></td>
                                        <td class="busSeatList busSeatListN" valign="top" onclick="fnSeatSelected(this);" style="font-weight: 700;" busSeat="<?=$num4?>"><br><?=$num4?></td>
                                    </tr>
                                <?
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </ul>
                    <ul class="selectStop" style="padding:0 4px;">
                        <li><img src="images/button/btn061.png" alt="양양행 서핑버스"></li>
                        <li>
                            <div id="selBusY" class="bd" style="padding-top:2px;">
                            </div>
                        </li>
                        <li><img src="images/button/btn062.png" alt="서울행 서핑버스"></li>
                        <li>
                            <div id="selBusS" class="bd" style="padding-top:2px;">
                            </div>
                        </li>
                        <li><img src="images/button/btn061.png" alt="양양행 서핑버스"></li>
                        <li>
                            <div id="selBusE" class="bd" style="padding-top:2px;">
                            </div>
                        </li>
                        <li><img src="images/button/btn062.png" alt="서울행 서핑버스"></li>
                        <li>
                            <div id="selBusA" class="bd" style="padding-top:2px;">
                            </div>
                        </li>
                    </ul>
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
<script src="js/surfview_busday.js"></script>
<script>
    var busDateinit = "<?=$sbusDate?>";
    var busData = {};
    
    var objParam = {
        "code":"busday",
        "bus":"<?=$busgubun?>"
    }
    $j.getJSON("/act/surf/surfbus_day.php", objParam,
        function (data, textStatus, jqXHR) {
            busData = data;
        }
    );

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