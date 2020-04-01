<? include 'db.php'; ?>

<?
$reqSeq = $_REQUEST["seq"];

if($reqSeq == ""){
    echo '<script>alert("잘못된 접속 경로입니다.");location.href="/surf";</script>';
	exit;
}
$select_query = "SELECT * FROM AT_PROD_MAIN 
                    WHERE seq = $reqSeq 
                        AND use_yn = 'Y'";
$result = mysqli_query($conn, $select_query);
$rowMain = mysqli_fetch_array($result);
$count = mysqli_num_rows($result);

if($count == 0){
    echo '<script>alert("예약이 불가능한 상품입니다.");location.href="surfevent";</script>';
    exit;
}

$reqCode = $rowMain["category"];
?>

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
                <h1><?=$rowMain["shopname"]?></h1>
                <a class="reviewlink">
                    <span class="reviewcnt">구매 <b><?=number_format($rowMain["sell_cnt"])?></b>개</span>
                </a>
                <div class="shopsubtitle"><?=$rowMain["shop_resinfo"]?></div>
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
                        <p class="noticesub">예약 및 방문 안내</p>
                        <ul>
                            <li class="litxt">이용상품 예약 > 입금안내 카톡 발송 > 무통장 입금 > 확정안내 카톡 발송</li>
                            <li class="litxt">무통장 입금시 예약자와 입금자명이 동일해야 합니다.</li>
                            <li class="litxt">예약하신 이용일 샵 방문 시 확정안내 카톡 또는 이름/전화번호를 알려주시면 됩니다.</li>
                            <li class="litxt">강습 예약 시 강습시간 10분 전에 샵에 방문해주세요.</li>
                            <li class="litxt">현금영수증 신청은 이용당일 예약하신 서핑샵에 방문하셔서 신청가능합니다.</li>
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
                    <?
                    if($rowMain["content_type"] == "html"){
                        echo $rowMain["content"];
                    }else{
                        include 'surfview/'.$rowMain["content"];
                    }
                    ?>
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
                            <li class="litxt">우천시 정상적으로 서핑강습이 진행됩니다.</li>
                            <li class="litxt">기상악화 및 천재지변으로 인하여 예약이 취소될 경우 전액환불해드립니다.</li>
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
                <div id="tour_calendar" style="display: block;padding:10px 4px;">
                </div>

                <div id="initText" class="write_table" style="text-align: center;font-size:14px;padding-top:20px;padding-bottom:20px;display:;">
                    <b>예약날짜를 선택하세요.</b>
                </div>

                <div id="lessonarea" style="display:none;">
                <form id="frmResList">
                    <div class="fixed_wrap3" style="display:;">
                        <ul class="cnb3 btnColor">
                        <?if($arrOptT[0] != null){?>
                            <li class="on3" id="resTab0"><a onclick="fnSurfList(this, 0);" style="padding:10px 15px 0px 15px;">강습</a></li>
                        <?}
                        
                        if($arrOptT[1] != null){?>
                            <li id="resTab1"><a onclick="fnSurfList(this, 1);" style="padding:10px 15px 0px 15px;">렌탈</a></li>
                        <?}
                        
                        if($arrOptT[2] != null){?>
                            <li id="resTab2"><a onclick="fnSurfList(this, 2);" style="padding:10px 15px 0px 15px;">패키지</a></li>
                        <?}
                        
                        if($arrOptT[3] != null){?>
                            <li id="resTab3"><a onclick="fnSurfList(this, 3);" style="padding:10px 15px 0px 15px;">숙소</a></li>
                        <?}
                        
                        if($arrOptT[4] != null && $rowMain["opt_bbq"] == "N"){?>
                            <li id="resTab4"><a onclick="fnSurfList(this, 4);" style="padding:10px 15px 0px 15px;">바베큐</a></li>
                        <?}?>
                        </ul>
                    </div>

                    <div area="shopListArea" style="display:none;">
                        <div class="gg_first" style="padding-top:10px;">강습예약</div>
                        <div id="divsellesson" style="text-align:center;font-size:14px;padding:50px;display:none;">
                            <b>강습이 매진되어 예약이 불가능합니다.</b>
                        </div>
                        <table class="et_vars exForm bd_tb" style="width:100%;" id="tbsellesson">
                            <colgroup>
                                <col style="width:100px;">
                                <col style="width:90px;">
                                <col style="width:*;">
                                <col style="width:45px;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th style="text-align:center;">강습종류</th>
                                    <th style="text-align:center;">시간</th>
                                    <th style="text-align:center;">인원</th>
                                    <th style="text-align:center;"></th>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">
                                        <?
                                        $i = 0;
                                        foreach($arrOpt[0] as $arrlesson){
                                            $sel1 .= '<option soldout="'.$arrlesson["intSeq"].'" optsexM="N" optsexW="N" value="'.$arrlesson["intSeq"].'|'.$arrlesson["opt_name"].'|'.$arrlesson["opt_Price"].'">'.$arrlesson["opt_name"].'</option>';
                                            
                                            if($i == 0){
                                                foreach(explode("|", $arrlesson["opt_time"]) as $arrtime){
                                                    if($arrtime != ""){
                                                        $sel2 .= '<option value="'.$arrtime.'">'.$arrtime.'</option>';
                                                    }
                                                }

                                                $sel3 = $arrlesson["opt_sexM"];
                                                $sel4 = $arrlesson["opt_sexW"];
                                            }
                                        
                                            $i++;
                                        }
                                        ?>
                                        <select id="sellesson" name="sellesson" class="select" onchange="fnResChange(this, 'sellesson');">
                                            <?=$sel1?>
                                        </select>

                                        <select id="hidsellesson" style="display:none;">
                                            <?=$sel1?>
                                        </select>
                                    </td>
                                    <td style="text-align:center;">
                                        <select id="sellessonTime" name="sellessonTime" class="select">
                                            <?=$sel2?>
                                        </select>							
                                    </td>
                                    <td style="text-align:center;line-height:2.5;">
                                        <span>
                                            남 : 
                                            <span style="display:none;"><select class="select" class="soldsel"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="sellessonM" name="sellessonM" class="select">
                                            <?for($i=0;$i<=$sel3;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명<br>
                                        </span>
                                        <span>
                                            여 : 
                                            <span style="display:none;"><select class="select" class="soldsel"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="sellessonW" name="sellessonW" class="select">
                                            <?for($i=0;$i<=$sel4;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="button" class="gg_btn gg_btn_grid large gg_btn_color btnsize1" value="신청" onclick="fnSurfAdd(0, this);">
                                    </td>
                                </tr>
                            <tbody>
                        </table>
                    </div>

                    <div area="shopListArea" style="display:none;">
                        <div class="gg_first" style="padding-top:10px;">렌탈예약</div>
                        <div id="divselRent" style="text-align:center;font-size:14px;padding:50px;display:none;">
                            <b>렌탈예약이 매진되어 예약이 불가능합니다.</b>
                        </div>
                        <table class="et_vars exForm bd_tb" style="width:100%;" id="tbselRent">
                            <colgroup>
                                <col style="width:100px;">
                                <col style="width:*;">
                                <col style="width:45px;">

                            </colgroup>
                            <tbody>
                                <tr>
                                    <th style="text-align:center;">렌탈종류</th>
                                    <th style="text-align:center;">인원</th>
                                    <th style="text-align:center;"></th>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">
                                        <?
                                        $i = 0;
                                        $sel1 = "";
                                        foreach($arrOpt[1] as $arrlesson){
                                            $sel1 .= '<option soldout="'.$arrlesson["intSeq"].'" optsexM="N" optsexW="N" value="'.$arrlesson["intSeq"].'|'.$arrlesson["opt_name"].'|'.$arrlesson["opt_Price"].'">'.$arrlesson["opt_name"].'</option>';
                                            
                                            if($i == 0){
                                                $sel3 = $arrlesson["opt_sexM"];
                                                $sel4 = $arrlesson["opt_sexW"];
                                            }
                                        
                                            $i++;
                                        }
                                        ?>

                                        <select id="selRent" name="selRent" class="select" onchange="fnResChange(this, 'selRent');">
                                            <?=$sel1?>
                                        </select>
                                        <select id="hidselRent" style="display:none;">
                                            <?=$sel1?>
                                        </select>
                                    </td>
                                    <td style="text-align:center;">
                                        <span>
                                            남 : 
                                            <span style="display:none;"><select class="select" class="soldsel"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="selRentM" name="selRentM" class="select">
                                            <?for($i=0;$i<=$sel3;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명<br>
                                        </span>
                                        <span>
                                            여 : 
                                            <span style="display:none;"><select class="select" class="soldsel"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="selRentW" name="selRentW" class="select">
                                            <?for($i=0;$i<=$sel4;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="button" class="gg_btn gg_btn_grid large gg_btn_color btnsize1" value="신청" onclick="fnSurfAdd(1, this);">
                                    </td>
                                </tr>
                            <tbody>
                        </table>
                    </div>
                    
                    <div area="shopListArea" style="display:none;">
                        <div class="gg_first" style="padding-top:10px;">패키지예약</div>
                        <div id="divselPkg" style="text-align:center;font-size:14px;padding:50px;display:none;">
                            <b>패키지예약이 매진되어 예약이 불가능합니다.</b>
                        </div>
                        <table class="et_vars exForm bd_tb" style="width:100%;" id="tbselPkg">
                            <colgroup>
                                <col style="width:90px;">
                                <col style="width:90px;">
                                <col style="width:*;">
                                <col style="width:45px;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th style="text-align:center;">패키지종류</th>
                                    <th style="text-align:center;">시간</th>
                                    <th style="text-align:center;">인원</th>
                                    <th style="text-align:center;"></th>
                                </tr>
                                <tr>
                                    <td style="text-align:center;" rowspan="2">
                                        <?
                                        $i = 0;
                                        $sel1 = "";
                                        $sel2 = "";
                                        foreach($arrOpt[2] as $arrlesson){
                                            $sel1 .= '<option soldout="'.$arrlesson["intSeq"].'" optsexM="N" optsexW="N" value="'.$arrlesson["intSeq"].'|'.$arrlesson["opt_name"].'|'.$arrlesson["opt_Price"].'|'.$arrlesson["opt_PkgTitle"].'">'.$arrlesson["opt_name"].'</option>';
                                            
                                            if($i == 0){
                                                foreach(explode("|", $arrlesson["opt_time"]) as $arrtime){
                                                    if($arrtime != ""){
                                                        $sel2 .= '<option value="'.$arrtime.'">'.$arrtime.'</option>';
                                                    }
                                                }

                                                $sel3 = $arrlesson["opt_sexM"];
                                                $sel4 = $arrlesson["opt_sexW"];
                                                $sel5 = $arrlesson["opt_PkgTitle"];
                                            }
                                        
                                            $i++;
                                        }
                                        ?>
                                        <select id="selPkg" name="selPkg" class="select" onchange="fnDayChange(this.value);fnResChange(this, 'selPkg');">
                                            <?=$sel1?>
                                        </select>

                                        <select id="hidselPkg" style="display:none;">
                                            <?=$sel1?>
                                        </select>
                                    </td>
                                    <td style="text-align:center;">
                                        <select id="selPkgTime" name="selPkgTime" class="select">
                                            <?=$sel2?>
                                        </select>
                                    </td>
                                    <td style="text-align:center;line-height:2.5;">
                                        
                                        <span>
                                            남 : 
                                            <span style="display:none;"><select class="select"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="selPkgM" name="selPkgM" class="select">
                                            <?for($i=0;$i<=$sel3;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명<br>
                                        </span>
                                        <span>
                                            여 : 
                                            <span style="display:none;"><select class="select"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="selPkgW" name="selPkgW" class="select">
                                            <?for($i=0;$i<=$sel4;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="button" class="gg_btn gg_btn_grid large gg_btn_color btnsize1" value="신청" onclick="fnSurfAdd(2, this);">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" id="pkgText"><?=$sel5?></td>
                                </tr>
                            <tbody>
                        </table>
                    </div>

                    <div area="shopListArea" style="display:none;">
                        <div class="gg_first" style="padding-top:10px;">숙소예약</div>
                        <div id="divselStay" style="text-align:center;font-size:14px;padding:50px;display:none;">
                            <b>숙소예약이 매진되어 예약이 불가능합니다.</b>
                        </div>
                        <table class="et_vars exForm bd_tb" style="width:100%;" id="tbselStay">
                            <colgroup>
                                <col style="width:100px;">
                                <col style="width:70px;">
                                <col style="width:*;">
                                <col style="width:45px;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th style="text-align:center;">숙소종류</th>
                                    <th style="text-align:center;">날짜</th>
                                    <th style="text-align:center;">인원</th>
                                    <th style="text-align:center;"></th>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">
                                        <?
                                        $i = 0;
                                        $sel1 = "";
                                        foreach($arrOpt[3] as $arrlesson){
                                            $sel1 .= '<option soldout="'.$arrlesson["intSeq"].'" optsexM="N" optsexW="N" value="'.$arrlesson["intSeq"].'|'.$arrlesson["opt_name"].'|'.$arrlesson["opt_Price"].'">'.$arrlesson["opt_name"].'</option>';
                                            
                                            if($i == 0){
                                                $sel3 = $arrlesson["opt_sexM"];
                                                $sel4 = $arrlesson["opt_sexW"];
                                            }
                                        
                                            $i++;
                                        }
                                        ?>
                                        <select id="selStay" name="selStay" class="select" onchange="fnResChange(this, 'selStay');">
                                            <?=$sel1?>
                                        </select>

                                        <select id="hidselStay" style="display:none;">
                                            <?=$sel1?>
                                        </select>
                                    </td>
                                    <td style="text-align:center;line-height:2.5;">
                                        <input type="text" id="strStayDate" name="strStayDate" readonly="readonly" value="" class="itx" cal="sdate" size="7" maxlength="7">
                                        <select id="selStayDay" name="selStayDay" class="select" style="display:none;">
                                            <?for($i=1;$i<=5;$i++){?>
                                                <option value="<?=$i?>박"><?=$i?> 박</option>
                                            <?}?>
                                        </select>						
                                    </td>
                                    <td style="text-align:center;line-height:2.5;">
                                        <span>
                                            남 : 
                                            <span style="display:none;"><select class="select" class="soldsel"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="selStayM" name="selStayM" class="select">
                                            <?for($i=0;$i<=$sel3;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명<br>
                                        </span>
                                        <span>
                                            여 : 
                                            <span style="display:none;"><select class="select" class="soldsel"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="selStayW" name="selStayW" class="select">
                                            <?for($i=0;$i<=$sel4;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="button" class="gg_btn gg_btn_grid large gg_btn_color btnsize1" value="신청" onclick="fnSurfAdd(3, this);">
                                    </td>
                                </tr>
                            <tbody>
                        </table>
                    </div>

                    <div area="shopListArea" style="display:none;">
                        <div class="gg_first" style="padding-top:10px;">바베큐예약</div>
                        <div id="divselBBQ" style="text-align:center;font-size:14px;padding:50px;display:none;">
                            <b>바베큐예약이 매진되어 예약이 불가능합니다.</b>
                        </div>
                        <table class="et_vars exForm bd_tb" style="width:100%;" id="tbselBBQ">
                            <colgroup>
                                <col style="width:100px;">
                                <col style="width:*;">
                                <col style="width:45px;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th style="text-align:center;">종류</th>
                                    <th style="text-align:center;">인원</th>
                                    <th style="text-align:center;"></th>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">
                                        <?
                                        $i = 0;
                                        $sel1 = "";
                                        foreach($arrOpt[4] as $arrlesson){
                                            $sel1 .= '<option soldout="'.$arrlesson["intSeq"].'" optsexM="N" optsexW="N" value="'.$arrlesson["intSeq"].'|'.$arrlesson["opt_name"].'|'.$arrlesson["opt_Price"].'">'.$arrlesson["opt_name"].'</option>';
                                            
                                            if($i == 0){
                                                $sel3 = $arrlesson["opt_sexM"];
                                                $sel4 = $arrlesson["opt_sexW"];
                                            }
                                        
                                            $i++;
                                        }
                                        ?>
                                        <select id="selBBQ" name="selBBQ" class="select" onchange="fnResChange(this, 'selBBQ');">
                                            <?=$sel1?>
                                        </select>

                                        <select id="hidselBBQ" style="display:none;">
                                            <?=$sel1?>
                                        </select>
                                        <input type="hidden" id="strBBQDate" name="strBBQDate" readonly="readonly" value="" class="itx" cal="sdate" size="7" maxlength="7">		
                                    </td>
                                    <td style="text-align:center;line-height:2.5;">
                                        <span>
                                            남 : 
                                            <span style="display:none;"><select class="select" class="soldsel"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="selBBQM" name="selBBQM" class="select">
                                            <?for($i=0;$i<=$sel3;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명&nbsp;&nbsp;
                                        </span>
                                        <span>
                                            여 : 
                                            <span style="display:none;"><select class="select" class="soldsel"><option value="0" style="color:red; background:#EEFF00;">매진</option></select></span>
                                            <select id="selBBQW" name="selBBQW" class="select">
                                            <?for($i=0;$i<=$sel4;$i++){?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                            <?}?>
                                            </select>명
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="button" class="gg_btn gg_btn_grid large gg_btn_color btnsize1" value="신청" onclick="fnSurfAdd(4, this);">
                                    </td>
                                </tr>
                            <tbody>
                        </table>
                    </div>
                </form>
                </div>

                <div class="bd" style="padding:0 4px;">
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
$j("#tour_calendar").load("/act/surf/surfview_calendar.php?selDate=<?=str_replace("-", "", date("Y-m-d"))?>&seq=<?=$reqSeq?>");

var mapView = 1;
var sLng = "37.9726807";
var sLat = "128.7593755";
var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION2 = {
        '당찬패키지 #END': [0, MARKER_SPRITE_Y_OFFSET * 3, sLng, sLat, '죽도해변', '#당찬패키지  #해변바베큐파티 #서핑버스 ', 0, 64, 'https://surfenjoy.cdn3.cafe24.com/shop/surfenjoy_new_1.jpg?v=3', '죽도']
    };
</script>