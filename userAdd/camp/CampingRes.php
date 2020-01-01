<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';
?>

<div class="bd_tl">
	<h1 class="ngeb clear"><i class="bg_color"></i><a href="/campres">죽도 야영장 예약하기</a></h1>

	<div style="width:100%;">
	<div style="<?=$divSize?>">
		<div id="resView" style="<?=$divSize2?>">
			<div class="tour_hide_option" id="tour_calendar" style="display: block;">
				<?php
					include 'CampingRes_Calendar.php';
				?>
			</div>

			<div id="initText" class="write_table" style="text-align: center;font-size:14px;padding-bottom:10px;display:;">
				<b>죽도 야영장 예약날짜를 선택하세요.</b>
			</div>

			<form id="frmRes" action="<?=$folderUrl?>/CampingRes_Save.php" method="post" style="display:none;" target="ifrmResize">
			</form>

			<div class="bd" style="padding:0px;">

				<?=fnInfoMemo(0, ''); //죽도야영장 이용안내?>

				<div class="gg_first">이용안내 안내 </div>

				<div style="margin-top:3px;margin-bottom:3px;display:;">
					<table class="et_vars exForm bd_tb" width="100%">
						<tbody>
							<tr>
								<th>
									<strong>죽도야영장 예약/이용안내</strong>
								</th>
							</tr>
							<tr>
								<td>
								▶ 1시간 이내 미입금시 자동취소됩니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 예약자와 입금자명이 동일해야합니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 죽도야영장 이용시 애견동반금지입니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 전기사용시 15m이상 릴선이 필요합니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 23시 이후로는 주변에 피해가 안가도록 대화소리를 작게 해주세요.
								</td>
							</tr>
							<tr>
								<td>
								▶ 죽도야영장 불포함 내역 : 전기(<span style="color: rgb(231, 76, 60);">유료</span>), 샤워장(<span style="color: rgb(231, 76, 60);">유료</span>)<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7월 ~ 8월 25일까지 : 해변 유료샤워장 이용쿠폰 2매 제공
								</td>
							</tr>
							<tr>
								<td>
								▶ 샤워장 이용안내<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7월 ~ 8월 : 서핑샵, 해변 유료샤워장 이용<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4월 ~ 6월, 9월 ~ 11월 : 서핑샵 유료샤워장 이용
								</td>
							</tr>
							<tr>
								<th>
									<input type="checkbox" id="chk8" name="chk8"> <strong>죽도야영장 예약/이용안내 동의</strong> (필수동의)
								</th>
							</tr>
							<tr>
								<th>
									<input type="checkbox" id="chk9" name="chk9"> <strong>개인정보 수집이용 동의 </strong> <a href="/notice/237" target="_blank" style="float:none;">[내용확인]</a> (필수동의)
								</th>
							</tr>
						</tbody>
					</table>
				</div>

				<?=fnReturnText(1, ''); //환불안내?>

			</div>

			<div class="write_table" style="padding-top:5px;display:none; text-align:center;" id="divBtnRes">
				<div>
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:70%; height:50px;" value="야영장 예약" onclick="fnCampSave();" />
				</div>
			</div>
		</div>
	</div>
	</div>

	<div class="wellBtn menu">
		<div class="resbottom">
			<button class="reson" id="reson1" onclick="fnResView(true, '.campmove', 20);"><i></i><span>예약신청으로 이동</span></button>
		</div>
	</div>

</div>

<span id="hidUserInfo" style="display:none;">
	<input type="text" id="hidpcmobile" name="hidpcmobile" value="<?=$pcmobile?>" class="itx" maxlength="15">
	<input type="text" id="hiduserName" name="hiduserName" value="<?=$user_name?>" class="itx" maxlength="15">
	<input type="text" id="hiduserId" name="hiduserId" value="<?=$user_id?>" class="itx" maxlength="30" readonly>
	<input type="text" name="hiduserPhone1" id="hiduserPhone1" value="<?=$userphone[0]?>" size="4" maxlength="4" class="tel itx">
	<input type="text" name="hiduserPhone2" id="hiduserPhone2" value="<?=$userphone[1]?>" size="5" maxlength="4" class="tel itx" style="width:50px;">
	<input type="text" name="hiduserPhone3" id="hiduserPhone3" value="<?=$userphone[2]?>" size="5" maxlength="4" class="tel itx" style="width:50px;">
	<input type="text" id="hidusermail" name="hidusermail" value="<?=$email_address?>" class="itx" maxlength="30" readonly>
</span>

<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height800px;display:none;"></iframe>
