<?php 
$seq = 5;

include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';
?>

<script>
$j(document).ready(function(){
	var nowMonth = '<?=str_replace("-", "", date("Ym"))?>';
	fnCalMove(nowMonth, <?=$seq?>);
});
</script>

<?
$select_query = 'SELECT * FROM SURF_SHOP where intseq = '.$seq.' AND useYN = "Y"';
$result = mysqli_query($conn, $select_query);
$rowMain = mysqli_fetch_array($result);
$count = mysqli_num_rows($result);

if($count == 0){
	echo '<script>alert("예약이 불가능한 상품입니다.");history.back();</script>';
	exit;
}

$select_query = 'SELECT * FROM `SURF_SHOP_OPT` where shopSeq = '.$seq.' AND opt_YN = "Y" ORDER BY opt_order';
$result_setlist = mysqli_query($conn, $select_query);

$arrOpt = array();
while ($rowOpt = mysqli_fetch_assoc($result_setlist)){
	$arrOpt[$rowOpt["opt_type"]][$rowOpt["intSeq"]] = array("intSeq" => $rowOpt["intSeq"], "opt_name" => $rowOpt["opt_name"], "opt_time" => $rowOpt["opt_time"], "opt_sexM" => $rowOpt["opt_sexM"], "opt_sexW" => $rowOpt["opt_sexW"], "opt_Price" => $rowOpt["opt_Price"], "opt_PkgTitle" => $rowOpt["opt_PkgTitle"]);
}
?>

<div class="" style="width:100%;display:;">
	<h1 class="ngeb clear" style="font-size:16px;height:25px;"><i class="bg_color"></i>[죽도] <?=$rowMain["shopname"]?></h1>
</div>

<div class="container" id="contenttop">
  <section>
    <aside class="left_article"><img src="<?=$rowMain["shop_mainimg"]?>" alt="" width="400" height="200" class="placeholder"/> </aside>
    <article class="right_article">
		<div style="padding-left:10px;">
		
			<div id="tour_calendar" style="display: block;">
			</div>

			<div id="initText" class="write_table" style="text-align: center;font-size:14px;padding-top:20px;padding-bottom:10px;display:;">
				<b>예약날짜를 선택하세요.</b>
			</div>

			<div id="lessonarea" style="display:none;">
			<form id="frmResList">
				<div class="fixed_wrap3" style="display:none;">
					<ul class="cnb3 btnColor">
						<li class="on3"><a onclick="fnSurfList(this, 0);">바베큐</a></li>
					</ul>
				</div>

				<div area="shopListArea" style="display:;">
					<div class="gg_first" style="padding-top:10px;">바베큐예약</div>
					<table class="et_vars exForm bd_tb" style="width:100%;">
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
										$sel1 .= '<option value="'.$arrlesson["intSeq"].'|'.$arrlesson["opt_name"].'|'.$arrlesson["opt_Price"].'">'.$arrlesson["opt_name"].'</option>';
										
										if($i == 0){
											$sel3 = $arrlesson["opt_sexM"];
											$sel4 = $arrlesson["opt_sexW"];
										}
									
										$i++;
									}
									?>
									<select id="selBBQ" name="selBBQ" class="select">
										<?=$sel1?>
									</select>
									<input type="hidden" id="strBBQDate" name="strBBQDate" readonly="readonly" value="" class="itx" cal="sdate" size="7" maxlength="7">		
								</td>
								<td style="text-align:center;line-height:2.5;">
									남 : <select id="selBBQM" name="selBBQM" class="select">
									<?for($i=0;$i<=$sel3;$i++){?>
										<option value="<?=$i?>"><?=$i?></option>
									<?}?>
									</select>명 / 
									여 : <select id="selBBQW" name="selBBQW" class="select">
									<?for($i=0;$i<=$sel4;$i++){?>
										<option value="<?=$i?>"><?=$i?></option>
									<?}?>
									</select>명
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

		</div>		
    </article>
  </section>
</div>

<div class="container">
  <section>
    <aside class="left_article2">

<!-- .tab_container -->
<div id="containerTab">
    <ul class="tabs">
        <li rel="tab1">바베큐 안내</li>
        <li rel="tab2" style="display:none;">예약정보</li>
        <li rel="tab3">예약정보</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <!-- #tab1 -->
        <div id="tab1" class="tab_content" style="line-height:0;">
			<?include __DIR__.'/../contentbanner.php';?>
			<img src="http://surfenjoy.cdn3.cafe24.com/bbq/res_bbq01.jpg" class="placeholder2" />
			<img src="http://skinnz.godohosting.com/surfenjoy/content/res_bbq05.jpg" class="placeholder2" />

			<!--div class="gg_first" style="padding-left:5px;font-size:17px;"><?=$rowMain["shopname"]?> <span style="font-size:12px;">(강원 양양군 현남면 시변리 죽도해변)</span></div>

			<div id="shopview_2">
				<iframe scrolling="no" frameborder="0" id="ifrmMap" name="ifrmMap" style="width:100%;height:300px;display:;" src="SurfList_Map.php"></iframe>
			</div-->

			<div class="gg_first" style="padding-left:5px;font-size:17px;">서프엔조이 고객센터</div>
			<div style="padding-bottom:15px;padding-left:5px;font-size:12px;line-height: 25px;">
				<strong>문의전화 : 010-3308-6080</strong><br>
				<strong>입금계좌 : 신한은행 / 389-02-188735 / 이승철</strong><br>
				<a href="http://pf.kakao.com/_HxmtMxl" target="_blank"><img src="http://skinnz.godohosting.com/surfenjoy/button/KakaoTalk_link.png" class="placeholder3"/></a>
			</div>
		</div>
        <div id="tab2" class="tab_content">
		</div>
        <!-- #tab2 -->
        <div id="tab3" class="tab_content">
			<?include 'SurfRes_SubTab3.php';?>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
    <article class="right_article2" style="z-index: 1;">
		<div class="bd_tl inner" style="width:100%;">
			<div class="bd max600 centered" style="padding:0px;" id="infochk">

				<div style="margin-top:3px;margin-bottom:3px;display:;" class="max600">
					<div class="gg_first">이용안내 안내 </div>
					<table class="et_vars exForm bd_tb" width="100%">
						<tbody>
							<tr>
								<th>
									<strong>서핑샵 예약/이용안내</strong>
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
								▶ 서프엔조이 이용금액은 부가세 별도금액입니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 현금영수증 신청은 이용일 또는 이후 [고객센터-현금영수증] 메뉴에서 신청가능합니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 천재지변으로 이용이 불가능할 경우 전액환불해드립니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 우천시 바베큐 파티는 취소됩니다.
								</td>
							</tr>
							<tr>
								<th>
									<input type="checkbox" id="chk8" name="chk8"> <strong>서핑샵 예약/이용안내 동의</strong> (필수동의)
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
		</div>

	</article>
  </section>
</div>
<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:600px;display:none;"></iframe>

<script>
var mapView = 1;
var sLng = "37.9728785";
var sLat = "128.7596793";

var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION2 = {
        '죽도해변 바베큐파티'		: [0, MARKER_SPRITE_Y_OFFSET*3, sLng, sLat, '죽도해변샤워장 앞에서 진행됩니다', '바베큐타임 : 오후 7:00 ~ 오후 9:30', 0]
    };
</script>