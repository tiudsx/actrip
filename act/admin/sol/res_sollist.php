<?php 
include __DIR__.'/../../db.php';
include __DIR__.'/../../common/logininfo.php';
?>

<div class="bd_tl" style="width:100%;">
	<h1 class="ngeb clear"><i class="bg_color"></i>솔게스트하우스 예약관리</h1>
</div>

<script>
    var mobileuse = "";
</script>

<link rel="stylesheet" type="text/css" href="/act/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="/act/css/surfview.css">
<link rel="stylesheet" type="text/css" href="/act/css/admin/admin_surf.css">
<link rel="stylesheet" type="text/css" href="/act/css/admin/admin_common.css">
<script type="text/javascript" src="/act/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/act/js/admin_surf.js"></script>
<script type="text/javascript" src="/act/js/admin_sol.js"></script>
<script type="text/javascript" src="/act/js/common.js"></script>

<div class="container" id="contenttop">

	<div id="containerTab" class="areaRight">
		<div id="right_article3" class="right_article4">
			<?include 'res_calendar.php'?>
		</div>

		<ul class="tabs">
			<li class="active" rel="tab1">확정예약</li>
			<li rel="tab2">예약관리</li>
		</ul>
		
		<div class="tab_container">
			<!-- #tab1 -->
			<div id="tab1" class="tab_content">
				<input type="hidden" id="seldate" name="seldate" size="10" value="2020-09-25">
				<div class="gg_first">객실 예약현황 (2020-09-25) <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:80px; height:20px;" value="예약등록" onclick="fnSolInsert();" /></div>
				<table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
					<colgroup>
						<col style="width:25%;">
						<col style="width:25%;">
						<col style="width:25%;">
						<col style="width:25%;">
					</colgroup>
					<tbody>
						<tr>
							<td style="text-align:center;background-color:#efefef;">201호(8명)</td>
							<td style="text-align:center;background-color:#efefef;">202호(10명)</td>
							<td style="text-align:center;background-color:#efefef;">203호(6명)</td>
							<td style="text-align:center;background-color:#efefef;">204호(8명)</td>
						</tr>
						<tr>
							<td style="height:50px;vertical-align: top;">
								이승철(남/1번/1층)<br>
								이승철(남/2번/2층)<br>
								이승철(남/3번/1층)<br>
								이승철(남/4번/2층)<br>
								이승철(남/5번/1층)<br>
								이승철(남/6번/2층)<br>
								이승철(남/7번/1층)<br>
								이승철(남/8번/2층)
							</td>
							<td style="height:50px;vertical-align: top;">
								이승철(남/1번/1층)<br>
								이승철(남/2번/2층)<br>
								이승철(남/3번/1층)<br>
								이승철(남/4번/2층)<br>
								이승철(남/5번/1층)<br>
								이승철(남/6번/2층)<br>
								이승철(남/7번/1층)<br>
								이승철(남/8번/2층)<br>
								이승철(남/9번/1층)<br>
								이승철(남/10번/2층)
							</td>
							<td style="height:50px;vertical-align: top;">
							</td>
							<td style="height:50px;vertical-align: top;">
							</td>
						</tr>
						<tr>
							<td style="text-align:center;background-color:#efefef;" colspan="2">301호(12명)</td>
							<td style="text-align:center;background-color:#efefef;">302호(8명)</td>
							<td style="text-align:center;background-color:#efefef;">303호(10명)</td>
						</tr>
						<tr>
							<td style="height:50px;vertical-align: top;">
								이승철(남/1번/1층)<br>
								이승철(남/2번/2층)<br>
								이승철(남/3번/1층)<br>
								이승철(남/4번/2층)<br>
								이승철(남/5번/1층)<br>
								이승철(남/6번/2층)
							</td>
							<td style="height:50px;vertical-align: top;">
								이승철(남/1번/1층)<br>
								이승철(남/2번/2층)<br>
								이승철(남/3번/1층)<br>
								이승철(남/4번/2층)<br>
								이승철(남/5번/1층)<br>
								이승철(남/6번/2층)
							</td>
							<td style="height:50px;vertical-align: top;">
							</td>
							<td style="height:50px;vertical-align: top;">
								이승철(남/1번/1층)<br>
								이승철(남/2번/2층)<br>
								이승철(남/3번/1층)<br>
								이승철(남/4번/2층)<br>
								이승철(남/5번/1층)<br>
								이승철(남/6번/2층)<br>
								이승철(남/7번/1층)<br>
								이승철(남/8번/2층)<br>
								이승철(남/9번/1층)<br>
								이승철(남/10번/2층)
							</td>
						</tr>
					</tbody>
				</table>
				<div id="mnglist">
					<div class="contentimg bd">
						<div class="gg_first">확정예약 현황 (2020-09-25) <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:80px; height:20px;" value="예약등록" onclick="fnSolInsert();" /></div>
						<table class="et_vars exForm bd_tb tbcenter tdcenter" style="margin-bottom:5px;width:100%;">
							<!-- <colgroup>
								<col width="5%" />
								<col width="*" />
								<col width="12%" />
								<col width="10%" />
								<col width="8%" />
								<col width="18%" />
								<col width="8%" />
								<col width="8%" />
							</colgroup> -->
							<tbody>
								<tr>
									<th></th>
									<th>이름</th>
									<th>연락처</th>
									<th>서핑샵</th>
									<th>숙소명</th>
									<th>바베큐</th>
									<th>펍파티</th>
									<th>요청사항</th>
									<th>직원메모</th>
									<th>알림톡</th>
									<th>체크</th>
									<th>상태</th>
									<th></th>
								</tr>
								<tr>
									<td><input type="checkbox" id="chkKakao" name="chkKakao" value=""></td>
									<td>이승철</td>
									<td>010-1234-4145</td>
									<td>서프팩토리</td>
									<td>솔게하</td>
									<td>참여</td>
									<td></td>
									<td>있음</td>
									<td></td>
									<td>X/0회 발송</td>
									<td>X</td>
									<td>확정</td>
									<td><input type="button" class="gg_btn res_btn_color2" style="width:60px; height:22px;" value="재발송" onclick="fnConfirmUpdate(this, 3);" /></td>
								</tr>
								<tr>
									<td></td>
									<td>이승철</td>
									<td>010-1234-4145</td>
									<td></td>
									<td>솔게하</td>
									<td>참여</td>
									<td></td>
									<td></td>
									<td>있음</td>
									<td>X/0회 발송</td>
									<td>X</td>
									<td>대기</td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
							<tbody>
								<tr>
									<td style="text-align:center;height:50px;">
									<b>달력에서 날짜를 선택하세요~</b>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div id="tab2" class="tab_content" style="display:none;">
				<form name="frmSearch" id="frmSearch" autocomplete="off">
				<div class="gg_first" style="margin-top:0px;">예약관리 검색</div>
				<table class='et_vars exForm bd_tb' style="width:100%">
					<colgroup>
						<col style="width:65px;">
						<col style="width:*;">
						<col style="width:100px;">
					</colgroup>
					<tr>
						<th>구분</th>
						<td>
							<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="0" checked="checked" style="vertical-align:-3px;" />예약대기</label>
							<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="1" checked="checked" style="vertical-align:-3px;" />확정예약</label>
							<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="2" style="vertical-align:-3px;" />환불요청</label>
							<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="3" style="vertical-align:-3px;" />환불완료</label>
							<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="4" style="vertical-align:-3px;" />취소</label>
						</td>
					</tr>
					<tr>
						<th>검색어</th>
						<td><input type="text" id="schText" name="schText" value="" class="itx2" style="width:140px;"></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="검색" onclick="fnSearchAdminSol('sol/res_solflist_search.php', 'mngSearch');" /></td>
					</tr>
				</table>
				</form>
				<div id="mngSearch"></div>
			</div>
		</div>

	</div>
</div> 

<div id="res_modify" style="display:none;padding:5px;"> 
    <form name="frmModify" id="frmModify" autocomplete="off">
    <div class="gg_first" style="margin-top:0px;">솔게스트하우스 예약등록 (<?=date("Y-m-d A h:i:s")?>)</div>
    <table class="et_vars exForm bd_tb" style="width:100%;display:;" id="infomodify">
        <!-- <colgroup>
            <col width="15%" />
            <col width="35%" />
            <col width="15%" />
            <col width="35%" />
        </colgroup> -->
        <tbody>
			<tr>
				<th>관리자</th>
				<td>
					<select id="res_adminname" name="res_adminname" class="select">
                        <option value='이승철'>이승철</option>
                        <option value='정태원'>정태원</option>
                        <option value='김민진'>김민진</option>
                        <option value='정태일'>정태일</option>
                    </select>
				</td>
				<th>이용일</th>
				<td>
					<input type="text" id="resdate" name="resdate" cal="date" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >
				</td>
                <th>이름</th>
                <td><input type="text" id="user_name" name="user_name" size="11" value="" class="itx"></td>
                <th>연락처</th>
				<td>
					<input type="text" id="user_tel1" name="user_tel1" size="4" maxlength="4" value="" class="itx"> -
					<input type="text" id="user_tel2" name="user_tel2" size="5" maxlength="4" value="" class="itx"> -
					<input type="text" id="user_tel3" name="user_tel3" size="5" maxlength="4" value="" class="itx">
				</td>
			</tr>
            <tr>
                <th>서핑강습/렌탈</th>
                <td colspan="7">
					<table class="et_vars exForm bd_tb" style="width:100%">
                        <tbody>
                            <tr>
                                <th style="text-align:center;" rowspan="2">서핑샵</th>
                                <th style="text-align:center;" colspan="4">서핑강습</th>
                                <th style="text-align:center;" colspan="3">장비렌탈</th>
                                <th style="text-align:center;" rowspan="2"></th>
                            </tr>
                            <tr>
                                <th style="text-align:center;">시간</th>
                                <th style="text-align:center;">남</th>
                                <th style="text-align:center;">여</th>
                                <th style="text-align:center;">구분</th>
                                <th style="text-align:center;">종류</th>
                                <th style="text-align:center;">남</th>
                                <th style="text-align:center;">여</th>
							</tr>
							<tr>
								<td>
									<select id="res_surfshop" name="res_surfshop[]" class="select">
										<option value='서프팩토리'>서프팩토리</option>
										<option value='라라서프'>라라서프</option>
										<option value='서퍼랑'>서퍼랑</option>
										<option value='솔게스트하우스'>솔게스트하우스</option>
									</select>
								</td>
								<td>
									<select id="res_surftime" name="res_surftime[]" class="select">
										<option value='9시'>9시</option>
										<option value='11시'>11시</option>
										<option value='13시'>13시</option>
										<option value='15시'>15시</option>
									</select>
								</td>
								<td>
									<select id="res_surfM" name="res_surfM[]" class="select">
									<?for($i=0;$i<=20;$i++){?>
										<option value="<?=$i?>"><?=$i?></option>
									<?}?>
									</select>명
								</td>
								<td>
									<select id="res_surfW" name="res_surfW[]" class="select">
									<?for($i=0;$i<=20;$i++){?>
										<option value="<?=$i?>"><?=$i?></option>
									<?}?>
									</select>명
								</td>
								<td>
									<select id="res_type" name="res_type[]" class="select">
										<option value='일반예약'>일반예약</option>
										<option value='패키지예약'>패키지예약</option>
									</select>
								</td>
								<td>
									<select id="res_surftime" name="res_surftime[]" class="select">
										<option value='보드+슈트'>보드+슈트</option>
										<option value='보드'>보드</option>
										<option value='슈트'>슈트</option>
									</select>
								</td>
								<td>
									<select id="res_rentM" name="res_rentM[]" class="select">
									<?for($i=0;$i<=20;$i++){?>
										<option value="<?=$i?>"><?=$i?></option>
									<?}?>
									</select>명
								</td>
								<td>
									<select id="res_rentW" name="res_rentW[]" class="select">
									<?for($i=0;$i<=20;$i++){?>
										<option value="<?=$i?>"><?=$i?></option>
									<?}?>
									</select>명
								</td>
								<td><input type="button" class="btnsurfadd" style="width:40px;" value="추가" ></td>
							</tr>
                        </tbody>
					</table>
                </td>
            </tr>
            <tr>
                <th>렌탈</th>
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
                <td><input type="text" id="res_totalprice" name="res_totalprice" size="12" value="" class="itx"></td>
            </tr>
            <tr>
                <th>호차</th>
                <td>
                    <select id="res_busnum" name="res_busnum" class="select">
                        <option value="Y1">양양행 1호차</option>
                        <option value="Y2">양양행 2호차</option>
                        <option value="Y3">양양행 3호차</option>
                        <option value="Y4">양양행 4호차</option>
                        <option value="Y5">양양행 5호차</option>
                        <option value="Y6">양양행 6호차</option>
                        <option value="S1">(양양)서울행 2시 1호차</option>
                        <option value="S3">(양양)서울행 2시 2호차</option>
                        <option value="S3">(양양)서울행 2시 3호차</option>
                        <option value="S2">(양양)서울행 5시 1호차</option>
                        <option value="S2">(양양)서울행 5시 2호차</option>
                        <option value="S2">(양양)서울행 5시 3호차</option>
                        <option value="E1">동해행 1호차</option>
                        <option value="E2">동해행 2호차</option>
                        <option value="E3">동해행 3호차</option>
                        <option value="E4">동해행 4호차</option>
                        <option value="E5">동해행 5호차</option>
                        <option value="E6">동해행 6호차</option>
                        <option value="A1">(동해)서울행 2시 1호차</option>
                        <option value="A2">(동해)서울행 2시 2호차</option>
                        <option value="A2">(동해)서울행 2시 3호차</option>
                        <option value="A3">(동해)서울행 5시 1호차</option>
                        <option value="A3">(동해)서울행 5시 2호차</option>
                        <option value="A3">(동해)서울행 5시 3호차</option>
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
                <td colspan="3">
                    <select id="res_spointname" name="res_spointname" class="select">
                        <option value="N">출발</option>
                    </select> →
                    <select id="res_epointname" name="res_epointname" class="select">
                        <option value="N">도착</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="col-02" style="text-align:center;" colspan="4">
                    <input type="hidden" id="res_price" name="res_price" size="10" value="0" class="itx">
                    <input type="hidden" id="gubun" name="gubun" size="10" value="0" class="itx">
                    <input type="hidden" id="resparam" name="resparam" size="10" value="busmodify" class="itx">
                    <input type="hidden" id="userid" name="userid" size="10" value="admin" class="itx">
                    <input type="hidden" id="ressubseq" name="ressubseq" size="10" value="" class="itx">
                    <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="정보수정" onclick="fnDataModify();" />&nbsp;
                    <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="닫기" onclick="fnModifyClose();" />
                </td>
            </tr>
        </tbody>
    </table>
    </form>
</div> 

<script>
$j(function () {
	
});
</script>