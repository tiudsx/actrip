<? include 'db.php'; ?>

<div id="wrap">
    <? include '_layout_top.php'; ?>

    <link rel="stylesheet" href="css/surfview.css">

    <div class="top_area_zone">
        <section class="shoptitle">
            <div style="padding:6px;">
                <h1>죽도리비치 바베큐파티</h1>
                <a class="reviewlink">
                    <span class="reviewcnt">구매 <b>4,662</b>개</span>
                </a>
                <div class="shopsubtitle">죽도해변 바베큐파티와 신나는 버스킹공연이 함께해요</div>
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
                    <!-- <p class="noticetxt">예약안내</p> -->
                    <article>
                        <p class="noticesub">예약안내</p>
                        <ul>
                            <li class="litxt">이용상품 예약 > 입금안내 카톡 발송 > 무통장 입금 > 확정안내 카톡 발송</li>
                            <li class="litxt">무통장 입금시 예약자와 입금자명이 동일해야합니다.</li>
                            <li class="litxt">예약하신 이용일, 바베큐파티 장소를 꼭 확인해주세요.</li>
                            <li class="litxt">
                                <span>    
                                액트립 바베큐파티 이용금액은 부가세 별도금액입니다.<br>
                                <span>현금영수증 신청은 이용일 이후 [예약조회] 메뉴에서 신청가능합니다.</span>
                                </span>
                            </li>
                        </ul>
                    </article>
                    <article>
                        <p class="noticesub">바베큐파티 이용안내</p>
                        <ul>
                            <li class="litxt">맥주나 음료는 제공되지 않으나 가지고 오셔서 드셔도 됩니다.</li>
                            <li class="litxt">메뉴는 인원에 따라 변경될 수 있습니다.</li>
                            <li class="litxt">미성년자 이용불가 / 신분증 확인!!</li>
                            <li class="litxt">죽도리비치 바베큐파티는 선착순 진행으로 인원 마감시 참여가 불가능합니다.</li>
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
                <div id="tour_calendar" style="display: block;padding:10px 4px;">
                </div>

                <div id="initText" class="write_table" style="text-align: center;font-size:14px;padding-top:20px;padding-bottom:20px;display:;">
                    <b>예약날짜를 선택하세요.</b>
                </div>
                <div class="bd" style="padding:0 4px;">
                    <p class="restitle">예약자 정보</p>
                    <table class="et_vars exForm bd_tb bustext" style="width:100%;margin-bottom:5px;">
                        <tbody>
                            <tr>
                                <th><em>*</em> 이름</th>
                                <td><input type="text" id="userName" name="userName" value="<?=$user_name?>" class="itx" maxlength="15"></td>
                            </tr>
                            <tr style="display:none;">
                                <th><em>*</em> 아이디</th>
                                <td><input type="text" id="userId" name="userId" value="<?=$user_id?>" class="itx" maxlength="30" readonly></td>
                            </tr>
                            <tr>
                                <th><em>*</em> 연락처</th>
                                <td>
                                    <input type="number" name="userPhone1" id="userPhone1" value="<?=$userphone[0]?>" size="3" maxlength="3" class="tel itx" style="width:50px;" oninput="maxLengthCheck(this)"> - 
                                    <input type="number" name="userPhone2" id="userPhone2" value="<?=$userphone[1]?>" size="4" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)"> - 
                                    <input type="number" name="userPhone3" id="userPhone3" value="<?=$userphone[2]?>" size="4" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"> 이메일</th>
                                <td><input type="text" id="usermail" name="usermail" value="<?=$email_address?>" class="itx"></td>
                            </tr>
                            <tr>
                                <th>특이사항</th>
                                <td>
                                    <textarea name="etc" id="etc" rows="8" cols="42" style="margin: 0px; width: 97%; height: 100px;resize:none;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>총 결제금액</th>
                                <td><span id="lastPrice">0원</span></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="restitle">약관 동의</p>
                    <table class="et_vars exForm bd_tb exForm" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <input type="checkbox" id="chk8" name="chk8"> <strong>예약할 상품설명에 명시된 내용과 사용조건을 확인하였으며, 취소. 환불규정에 동의합니다.</strong> (필수동의)
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" id="chk9" name="chk9"> <strong>개인정보 수집이용 동의 </strong> <a href="/privacy" target="_blank" style="float:none;">[내용확인]</a> (필수동의)
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
$j("#tour_calendar").load("/act/surf/surfview_calendar.php?selDate=<?=str_replace("-", "", date("Y-m-d"))?>&seq=46");

var mapView = 1;
var sLng = "37.9726807";
var sLat = "128.7593755";
var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION2 = {
        '당찬패키지 #END': [0, MARKER_SPRITE_Y_OFFSET * 3, sLng, sLat, '죽도해변', '#당찬패키지  #해변바베큐파티 #서핑버스 ', 0, 64, 'https://surfenjoy.cdn3.cafe24.com/shop/surfenjoy_new_1.jpg?v=3', '죽도']
    };
</script>