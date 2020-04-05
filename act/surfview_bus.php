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

//연락처 모바일 여부
if(Mobile::isMobileCheckByAgent()) $inputtype = "number"; else $inputtype = "text";
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
                            <li class="litxt">
                                <span>    
                                액트립 서핑버스 이용금액은 부가세 별도금액입니다.<br>
                                <span>현금영수증 신청은 이용일 이후 [예약조회] 메뉴에서 신청가능합니다.</span>
                                </span>
                            </li>
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
            <form id="frmRes" method="post" target="ifrmResize" autocomplete="off">
                <span style="display:none;">
                    <br>resparam<input type="text" id="resparam" name="resparam" value="BusI" />
                    <br>userId<input type="text" id="userId" name="userId" value="<?=$user_id?>">
                </span>
                
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
                    <?if($param == "surfbus"){?>
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
                    <?}else{?>
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
                    <?}?>
                    </ul>
                </div>

                <div class="bd" style="padding:0 4px;">
                    <p class="restitle">예약자 정보</p>
                    <table class="et_vars exForm bd_tb bustext" style="width:100%;margin-bottom:5px;">
                        <tbody>
                            <tr>
                                <th><em>*</em> 이름</th>
                                <td><input type="text" id="userName" name="userName" value="" class="itx" maxlength="15"></td>
                            </tr>
                            <tr>
                                <th><em>*</em> 연락처</th>
                                <td>
                                    <input type="<?=$inputtype?>" name="userPhone1" id="userPhone1" value="" size="3" maxlength="3" class="tel itx" style="width:50px;" oninput="maxLengthCheck(this)"> - 
                                    <input type="<?=$inputtype?>" name="userPhone2" id="userPhone2" value="" size="4" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)"> - 
                                    <input type="<?=$inputtype?>" name="userPhone3" id="userPhone3" value="" size="4" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"> 이메일</th>
                                <td><input type="text" id="usermail" name="usermail" value="" class="itx"></td>
                            </tr>
                            <tr>
                                <th scope="row"> 쿠폰코드</th>
                                <td>
                                    <input type="text" id="coupon" name="coupon" value="" class="itx" maxlength="10">
                                    <input type="hidden" id="couponcode" name="couponcode" value="">
                                    <input type="hidden" id="couponprice" name="couponprice" value="0">
                                    <input type="button" class="gg_btn gg_btn_grid gg_btn_color" style="width:50px; height:24px;" value="적용" onclick="fnCouponCheck(this);" />
                                    <span id="coupondis" style="display:none;"><br></span>
                                </td>
                            </tr>
                            <tr>
                                <th>특이사항</th>
                                <td>
                                    <textarea name="etc" id="etc" rows="8" cols="42" style="margin: 0px; width: 97%; height: 100px;resize:none;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>총 결제금액</th>
                                <td><span id="lastPrice" style="font-weight:700;color:red;">0원</span><span id="lastcouponprice"></span></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="restitle">약관 동의</p>
                    <table class="et_vars exForm bd_tb exForm" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <input type="checkbox" id="chk8" name="chk8" checked="checked"> <strong>예약할 상품설명에 명시된 내용과 사용조건을 확인하였으며, 취소. 환불규정에 동의합니다.</strong> (필수동의)
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" id="chk9" name="chk9" checked="checked"> <strong>개인정보 수집이용 동의 </strong> <a href="/privacy" target="_blank" style="float:none;">[내용확인]</a> (필수동의)
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="padding:10px;display:; text-align:center;" id="divBtnRes">
                    <div>
                        <input type="button" class="gg_btn gg_btn_grid gg_btn_color" style="width:200px; height:44px;" value="예약하기" onclick="fnBusSave();" />
                    </div>
                </div>
            </form>
            </div>
        </section>
    </div>
</div>
<iframe id="ifrmResize" name="ifrmResize" style="width:100%;height:400px;display:none;"></iframe>
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
    $j('.busSeat').block({ message: null }); 
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
</script>