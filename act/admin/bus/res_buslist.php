<?php 
include __DIR__.'/../../db.php';
include __DIR__.'/../../common/logininfo.php';
$shopseq = 0;
?>

<link rel="stylesheet" type="text/css" href="/act/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="/act/css/surfview.css">
<link rel="stylesheet" type="text/css" href="/act/css/admin/admin_surf.css">
<link rel="stylesheet" type="text/css" href="/act/css/admin/admin_common.css">
<script type="text/javascript" src="/act/js/admin_surf.js"></script>
<script type="text/javascript" src="/act/js/surfview_bus.js"></script>
<script type="text/javascript" src="/act/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/act/js/surfview_busday.js"></script>

<div class="bd_tl" style="width:100%;">
	<h1 class="ngeb clear"><i class="bg_color"></i>액트립 셔틀버스 예약관리</h1>
</div>

<script>
    var mobileuse = "";
</script>

<div class="container" id="contenttop">
<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <section>
        <aside id="right_article3" class="left_article5">
            <?include __DIR__.'/../shop/res_surfcalendar.php'?>
        </aside>
        <article class="right_article5">
            <ul class="tabs" style="margin-left:5px;">
                <li class="active" rel="tab1">검색관리</li>
                <li rel="tab2">예약관리</li>
                <li rel="tab3">정산관리</li>
                <li rel="tab4">타채널예약</li>
            </ul>

            <!-- #container -->
            <div class="tab_container" style="margin-left:5px;">
                <!-- #tab1 -->
                <div id="tab1" class="tab_content">
                    <form name="frmSearch" id="frmSearch" autocomplete="off">
                    <table class='et_vars exForm bd_tb' style="width:100%">
                        <colgroup>
                            <col style="width:100px;">
                            <col style="width:80px;">
                            <col style="width:*;">
                            <col style="width:100px;">
                            <col style="width:80px;">
                            <col style="width:*;">
                        </colgroup>
                        <tr>
                            <th><label><input type="checkbox" id="chkGubun" onclick="fnChkAll(this, 'chkResConfirm')">구분</label></th>
                            <td colspan="5">
                                <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" checked="checked" value="0" style="vertical-align:-3px;" />미입금</label>
                                <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" checked="checked" value="1" style="vertical-align:-3px;" />예약대기</label>
                                <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" checked="checked" value="8" style="vertical-align:-3px;" />입금완료</label>
                                <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="3" style="vertical-align:-3px;" />확정</label>
                                <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="7" style="vertical-align:-3px;" />취소</label>
                                <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" checked="checked" value="4" style="vertical-align:-3px;" />환불요청</label>
                                <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="5" style="vertical-align:-3px;" />환불완료</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                양양행
                            </td>
                        </tr>
                        <tr>
                            <th rowspan="2"><label><input type="checkbox" id="chkBusY1" name="chkBus[]" checked="checked" value="7" style="vertical-align:-3px;" onclick="fnChkBusAll(this, 'Y1')" />서울-양양행</label></th>
                            <th>사당선</th>
                            <td>
                                <label><input type="checkbox" id="chkbusNumY1" name="chkbusNum[]" checked="checked" value="Y1" style="vertical-align:-3px;" />1호차</label>
                                <label><input type="checkbox" id="chkbusNumY1" name="chkbusNum[]" checked="checked" value="Y3" style="vertical-align:-3px;" />3호차</label>
                                <label><input type="checkbox" id="chkbusNumY1" name="chkbusNum[]" checked="checked" value="Y5" style="vertical-align:-3px;" />5호차</label>
                            </td>
                            <th rowspan="2"><label><input type="checkbox" id="chkBusY2" name="chkBus[]" checked="checked" value="7" style="vertical-align:-3px;" onclick="fnChkBusAll(this, 'Y2')" />양양-서울행</label></th>
                            <th>오후 2시</th>
                            <td>
                                <label><input type="checkbox" id="chkbusNumY2" name="chkbusNum[]" checked="checked" value="S21" style="vertical-align:-3px;" />1호차</label>
                                <label><input type="checkbox" id="chkbusNumY2" name="chkbusNum[]" checked="checked" value="S22" style="vertical-align:-3px;" />2호차</label>
                                <label><input type="checkbox" id="chkbusNumY2" name="chkbusNum[]" checked="checked" value="S23" style="vertical-align:-3px;" />3호차</label>
                            </td>
                        </tr>
                        <tr>
                            <th>종로선</th>
                            <td>
                                <label><input type="checkbox" id="chkbusNumY1" name="chkbusNum[]" checked="checked" value="Y2" style="vertical-align:-3px;" />2호차</label>
                                <label><input type="checkbox" id="chkbusNumY1" name="chkbusNum[]" checked="checked" value="Y4" style="vertical-align:-3px;" />4호차</label>
                                <label><input type="checkbox" id="chkbusNumY1" name="chkbusNum[]" checked="checked" value="Y6" style="vertical-align:-3px;" />6호차</label>
                            </td>
                            <th>오후 5시</th>
                            <td>
                                <label><input type="checkbox" id="chkbusNumY2" name="chkbusNum[]" checked="checked" value="S51" style="vertical-align:-3px;" />1호차</label>
                                <label><input type="checkbox" id="chkbusNumY2" name="chkbusNum[]" checked="checked" value="S52" style="vertical-align:-3px;" />2호차</label>
                                <label><input type="checkbox" id="chkbusNumY2" name="chkbusNum[]" checked="checked" value="S53" style="vertical-align:-3px;" />3호차</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                               동해행
                            </td>
                        </tr>
                        <tr>
                            <th rowspan="2"><label><input type="checkbox" id="chkBusD1" name="chkBus[]" checked="checked" value="14" style="vertical-align:-3px;" onclick="fnChkBusAll(this, 'D1')" />서울-동해행</label></th>
                            <th rowspan="2">사당선</th>
                            <td>
                                <label><input type="checkbox" id="chkbusNumD1" name="chkbusNum[]" checked="checked" value="E1" style="vertical-align:-3px;" />1호차</label>
                                <label><input type="checkbox" id="chkbusNumD1" name="chkbusNum[]" checked="checked" value="E2" style="vertical-align:-3px;" />2호차</label>
                                <label><input type="checkbox" id="chkbusNumD1" name="chkbusNum[]" checked="checked" value="E3" style="vertical-align:-3px;" />3호차</label>
                            </td>
                            <th rowspan="2"><label><input type="checkbox" id="chkBusD2" name="chkBus[]" checked="checked" value="14" style="vertical-align:-3px;" onclick="fnChkBusAll(this, 'D2')" />동해-서울행</label></th>
                            <th>오후 2시</th>
                            <td>
                                <label><input type="checkbox" id="chkbusNumD2" name="chkbusNum[]" checked="checked" value="A21" style="vertical-align:-3px;" />1호차</label>
                                <label><input type="checkbox" id="chkbusNumD2" name="chkbusNum[]" checked="checked" value="A22" style="vertical-align:-3px;" />2호차</label>
                                <label><input type="checkbox" id="chkbusNumD2" name="chkbusNum[]" checked="checked" value="A23" style="vertical-align:-3px;" />3호차</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label><input type="checkbox" id="chkbusNumD1" name="chkbusNum[]" checked="checked" value="E4" style="vertical-align:-3px;" />4호차</label>
                                <label><input type="checkbox" id="chkbusNumD1" name="chkbusNum[]" checked="checked" value="E5" style="vertical-align:-3px;" />5호차</label>
                                <label><input type="checkbox" id="chkbusNumD1" name="chkbusNum[]" checked="checked" value="E6" style="vertical-align:-3px;" />6호차</label>
                            </td>
                            <th>오후 5시</th>
                            <td>
                                <label><input type="checkbox" id="chkbusNumD2" name="chkbusNum[]" checked="checked" value="A51" style="vertical-align:-3px;" />1호차</label>
                                <label><input type="checkbox" id="chkbusNumD2" name="chkbusNum[]" checked="checked" value="A52" style="vertical-align:-3px;" />2호차</label>
                                <label><input type="checkbox" id="chkbusNumD2" name="chkbusNum[]" checked="checked" value="A53" style="vertical-align:-3px;" />3호차</label>
                            </td>
                        </tr>
                        <tr>
                            <th>검색기간</th>
                            <td colspan="5">
                                <input type="hidden" id="hidsearch" name="hidsearch" value="init">
                                <input type="text" id="sDate" name="sDate" cal="sdate" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >&nbsp;~
                                <input type="text" id="eDate" name="eDate" cal="edate" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >
                                <input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="전체" onclick="fnDateReset();" />
                            </td>
                            
                        </tr>
                        <tr>
                            <th>검색어</th>
                            <td colspan="5"><input type="text" id="schText" name="schText" value="" class="itx2" style="width:100px;"></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="검색" onclick="fnSearchAdmin('bus/res_buslist_search.php');" /></td>
                        </tr>
                    </table>
                    </form>                
                </div>

                <!-- #tab2 -->
                <div id="tab2" class="tab_content" style="display:none;">
                    <div style="text-align:center;font-size:14px;padding:50px;" id="initText2">
                        <b>달력 날짜를 선택하세요.</b>
                    </div>
                    <div id="divResList"></div>
                </div>
                
                <!-- #tab3 -->
                <div id="tab3" class="tab_content" style="display:none;">
                    <?include 'res_bus_cal.php'?>
                </div>

                <!-- #tab3 -->
                <div id="tab4" class="tab_content" style="display:none;">
                    <form name="frmResKakao" id="frmResKakao" autocomplete="off">
                    <table class='et_vars exForm bd_tb'>
                        <tr>
                            <td colspan="5">
                                알림톡 발송 번호
                            </td>
                        </tr>
                        <tr>
                            <th>채널</th>
                            <th>이름</th>
                            <th>연락처</th>
                            <th>이용일 (서울>양양)</th>
                            <th>이용일 (양양>서울)</th>
                        </tr>
                        <tr>
                            <td>
                                <select id="reschannel">
                                    <option value="7">네이버쇼핑</option>
                                    <option value="10">네이버예약</option>
                                    <option value="11">프립</option>
                                    <option value="12">마이리얼트립</option>
                                    <option value="14">망고패키지</option>
                                </select>
                            </td>
                            <td><input type="text" id="username" name="username" style="width:66px;" value="" class="itx2" maxlength="7" ></td>
                            <td><input type="text" id="userphone" name="userphone" style="width:150px;" value="" class="itx2" maxlength="15"></td>
                            <td>
                                <input type="text" id="resDate1" name="resDate1" cal="date" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >
                                <select id="resbusseat1">
                                <?for ($i=0; $i < 20; $i++) { 
                                    echo '<option value="'.$i.'">'.$i.'명</option>';
                                }?>
                                </select>
                            </td>
                            <td>
                                <input type="text" id="resDate2" name="resDate2" cal="date" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >
                                <select id="resbusseat2">
                                <?for ($i=0; $i < 20; $i++) { 
                                    echo '<option value="'.$i.'">'.$i.'명</option>';
                                }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="알림톡 발송" onclick="fnResKakaoAdmin();" /></td>
                        </tr>
                    </table>
                    </form>
<?
    $select_query = "SELECT * FROM `AT_COUPON_CODE` WHERE couponseq = 14 AND use_yn = 'N'";
    $result_setlist = mysqli_query($conn, $select_query);
    $count = mysqli_num_rows($result_setlist);
?>

<div class="gg_first">알림톡 발송 정보</div>
    <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
        <colgroup>
            <col width="14%"/>
            <col width="13%"/>
            <col width="17%"/>
            <col width="18%"/>
            <col width="18%"/>
            <col width="auto"/>
        </colgroup>
        <tbody>
            <tr>
                <th>채널</th>
                <th>이름</th>
                <th>연락처</th>
                <th>이용일 (서울>양양)</th>
                <th>이용일 (양양>서울)</th>
                <th>예약여부</th>
            </tr>
<?while ($row = mysqli_fetch_assoc($result_setlist)){
	$coupon_code = $row['coupon_code'];
	$userinfo = $row['userinfo'];

    $arrChk = explode("|", $userinfo);
    ?>
            <tr>
                <td>망고 패키지</td>
                <td><?=$arrChk[0]?></td>
                <td><?=$arrChk[1]?></td>
                <td><?=$arrChk[2]?> (<?=$arrChk[3]?>명)</td>
                <td><?=$arrChk[4]?> (<?=$arrChk[5]?>명)</td>
                <td>X</td>
            </tr>
<?}?>
        </tbody>
    </table>
</div>


                </div>
            </div>
            <!-- .tab_container -->
        </article>
    </section>

<script>
function fnResKakaoAdmin(){
    if($j("#username").val() == ""){
        alert("이름을 입력하세요.");
        return;
    }
    
    if($j("#userphone").val() == ""){
        alert("연락처를 입력하세요.");
        return;
    }

    if(!confirm("알림톡 발송을 하시겠습니까?")){
        return;
    }

    var params = "resparam=reskakao&username=" + $j("#username").val() + "&userphone=" + $j("#userphone").val() + "&reschannel=" + $j("#reschannel").val() + "&resDate1=" + $j("#resDate1").val() + "&resDate2=" + $j("#resDate2").val() + "&resbusseat1=" + $j("#resbusseat1").val() + "&resbusseat2=" + $j("#resbusseat2").val();
    $j.ajax({
        type: "POST",
        url: "/act/admin/bus/res_bus_save.php",
        data: params,
        success: function (data) {
            if(data == "err"){
                alert("오류가 발생하였습니다.");
            }else{
                $j("#userphone").val("");
                $j("#username").val("");
                alert("예약 알림톡 발송이 완료되었습니다.");
                // alert(data + "\n\n발송이 완료되었습니다.");
            }
        }
    });
}
</script>


    <div>
        <div id="mngSearch" style="display:inline-block;width:100%"><?include 'res_buslist_search.php'?></div>
    </div>
</div>
<!-- #container -->
</div>

<input type="hidden" id="hidselDate" value="">
<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:400px;display:none;"></iframe>

<div id="res_busmodify" style="display:none;padding:5px;"> 
    <form name="frmModify" id="frmModify" autocomplete="off">
    <div class="gg_first" style="margin-top:0px;">서핑버스 정보변경</div>
    <table class="et_vars exForm bd_tb" style="width:100%;display:;" id="infomodify">
        <colgroup>
            <col width="15%" />
            <col width="40%" />
            <col width="15%" />
            <col width="30%" />
        </colgroup>
        <tbody>
            <tr>
                <th>신청일</th>
                <td colspan="3">
                    <input type="text" id="insdate" name="insdate" size="20" value="" class="itx">
                    <input type="hidden" id="resnum" name="resnum" size="10" value="" class="itx">
                </td>
            </tr>
            <tr>
                <th>확정일</th>
                <td colspan="3"><input type="text" id="confirmdate" name="confirmdate" size="20" value="" class="itx"></td>
            </tr>
            <tr>
                <th>상태</th>
                <td>
                    <select id="res_confirm" name="res_confirm" class="select">
                        <option value='0'>미입금</option>
                        <option value='1'>예약대기</option>
                        <option value='3'>확정</option>
                        <option value='4'>환불요청</option>
                        <option value='5'>환불완료</option>
                        <option value='7'>취소</option>
                        <option value='8'>입금완료</option>
                    </select>
                </td>
                <th>이용일</th>
                <td><input type="text" id="res_date" name="res_date" cal="date" size="10" value="<?=$row["busDate"]?>" class="itx"></td>
            </tr>
            <tr>
                <th>이름</th>
                <td><input type="text" id="user_name" name="user_name" size="11" value="" class="itx"></td>
                <th>연락처</th>
                <td><input type="text" id="user_tel" name="user_tel" size="12" value="" class="itx"></td>
            </tr>
            <tr>
                <th>이메일</th>
                <td><input type="text" id="user_email" name="user_email" value="" class="itx" size="18"></td>
                <th>수수료여부</th>
                <td>
                    <select id="rtn_charge_yn" name="rtn_charge_yn" class="select">
                        <option value="Y">있음</option>
                        <option value="N">없음</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>할인금액</th>
                <td><input type="text" id="res_price_coupon" name="res_price_coupon" value="" class="itx" size="18"></td>
                <th>이용금액</th>
                <td><input type="text" id="res_price" name="res_price" size="12" value="" class="itx"></td>
            </tr>
            <tr>
                <th>호차</th>
                <td>
                    <select id="res_busnum" name="res_busnum" class="select" onchange="fnBusPointSel(this.value, '', '');">
                        <option value="Y1">양양행 1호차</option>
                        <option value="Y2">양양행 2호차</option>
                        <option value="Y3">양양행 3호차</option>
                        <option value="Y4">양양행 4호차</option>
                        <option value="Y5">양양행 5호차</option>
                        <option value="Y6">양양행 6호차</option>
                        <option value="S21">(양양)서울행 2시 1호차</option>
                        <option value="S23">(양양)서울행 2시 2호차</option>
                        <option value="S23">(양양)서울행 2시 3호차</option>
                        <option value="S51">(양양)서울행 5시 1호차</option>
                        <option value="S52">(양양)서울행 5시 2호차</option>
                        <option value="S53">(양양)서울행 5시 3호차</option>
                        <option value="E1">동해행 1호차</option>
                        <option value="E2">동해행 2호차</option>
                        <option value="E3">동해행 3호차</option>
                        <option value="E4">동해행 4호차</option>
                        <option value="E5">동해행 5호차</option>
                        <option value="E6">동해행 6호차</option>
                        <option value="A21">(동해)서울행 2시 1호차</option>
                        <option value="A22">(동해)서울행 2시 2호차</option>
                        <option value="A22">(동해)서울행 2시 3호차</option>
                        <option value="A51">(동해)서울행 5시 1호차</option>
                        <option value="A52">(동해)서울행 5시 2호차</option>
                        <option value="A53">(동해)서울행 5시 3호차</option>
                    </select>
                </td>
                <th>좌석</th>
                <td>
                    <select id="res_seat" name="res_seat" class="select">
                    <?for ($i=1; $i < 46; $i++) { 
                        echo "<option value='$i'>$i</option>";
                    }?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>정류장</th>
                <td>
                    <select id="res_spointname" name="res_spointname" class="select">
                        <option value="N">출발</option>
                    </select> →
                    <select id="res_epointname" name="res_epointname" class="select">
                        <option value="N">도착</option>
                    </select>
                </td>
                <th></th>
                <td>
                </td>
            </tr>
            <tr>
                <td class="col-02" style="text-align:center;" colspan="4">
                    <input type="hidden" id="gubun" name="gubun" size="10" value="0" class="itx">
                    <input type="hidden" id="resparam" name="resparam" size="10" value="busmodify" class="itx">
                    <input type="hidden" id="userid" name="userid" size="10" value="admin" class="itx">
                    <input type="hidden" id="ressubseq" name="ressubseq" size="10" value="" class="itx">
                    <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;background:green;" value="정보수정" onclick="fnDataModify();" />&nbsp;
                    <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="닫기" onclick="fnModifyClose();" />
                </td>
            </tr>
        </tbody>
    </table>
    </form>
</div> 