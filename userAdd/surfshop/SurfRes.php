<?php 
if($_REQUEST["seq"] == ""){
	echo '<script>location.href="surfevent";</script>';
	exit;
}

$seq = $_REQUEST["seq"];

include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';

$select_query = 'SELECT *, b.opt_type, b.opt_name FROM `SURF_SHOP_SOLDOUT` as a INNER JOIN SURF_SHOP_OPT as b
					ON a.shopSeq = b.shopSeq
						AND a.optseq = b.intSeq
					WHERE a.shopSeq = '.$seq.' ORDER BY a.soldoutdate, a.optseq';
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count > 0){
	$SoldoutList = "";
	$Presoldoutdate = "";
	$x = 0;

	while ($rowSold = mysqli_fetch_assoc($result_setlist)){
		$soldoutdate = $rowSold['soldoutdate'];

		if($soldoutdate != $Presoldoutdate && $x > 0){
			$SoldoutList .= "main['".$Presoldoutdate."'] = sub;";
		}

		if($soldoutdate == $Presoldoutdate){
			$i++;
		}else{
			$i = 0;
		}

		$x++;
		$Presoldoutdate = $rowSold['soldoutdate'];

		if($i == 0){
			$SoldoutList .= "sub = new Object();";
		}

		$soldoutdate = $rowSold["soldoutdate"];
		$optseq = $rowSold["optseq"];
		$optsexM = $rowSold["optsexM"];
		$optsexW = $rowSold["optsexW"];
		$opt_type = $rowSold["opt_type"];
		$opt_name = $rowSold["opt_name"];
		
		$SoldoutList .= "sub['$optseq'] = {type: $opt_type, optsexM: '$optsexM', optsexW: '$optsexW', optseq: $optseq, optname: '$opt_name' }; ";
	}
	
	$SoldoutList .= "main['".$Presoldoutdate."'] = sub;";
}

$select_query = 'SELECT * FROM `SURF_SHOP_OPT` where shopSeq = '.$seq.' AND opt_YN = "Y" ORDER BY opt_order';
$result_setlist = mysqli_query($conn, $select_query);

$arrOpt = array();
$arrOptT = array();
while ($rowOpt = mysqli_fetch_assoc($result_setlist)){
	$arrOpt[$rowOpt["opt_type"]][$rowOpt["intSeq"]] = array("intSeq" => $rowOpt["intSeq"], "opt_name" => $rowOpt["opt_name"], "opt_time" => $rowOpt["opt_time"], "opt_sexM" => $rowOpt["opt_sexM"], "opt_sexW" => $rowOpt["opt_sexW"], "opt_Price" => $rowOpt["opt_Price"], "opt_PkgTitle" => $rowOpt["opt_PkgTitle"]);

	$arrOptT[$rowOpt["opt_type"]] = $rowOpt["opt_type"];
}


$sLng = $rowMain["shop_lat"];
$sLat = $rowMain["shop_lng"];

$startTab = 5;
if($arrOptT[0] != null){
	$startTab = 0;
}

if($arrOptT[1] != null && $startTab == 5){
	$startTab = 1;
}

if($arrOptT[2] != null && $startTab == 5){
	$startTab = 2;
}

if($arrOptT[3] != null && $startTab == 5){
	$startTab = 3;
}

if($arrOptT[4] != null && $startTab == 5){
	$startTab = 4;
}

?>

<script>
var startTab = <?=$startTab?>;

function fnSurfList2(num){
	$j(".fixed_wrap3 li").removeClass("on3");
	$j("#resTab" + num).addClass("on3");

	$j("div[area=shopListArea]").css("display", "none");
	$j("div[area=shopListArea]").eq(num).css("display", "block");
}


$j(document).ready(function(){
	$j("#btnres").css("display", "block");
	fnSurfList2(startTab);

	<?
	if($seq == "64"){
	?>
		$j('calbox[value="2019-09-28"]').click();
	<?
	}
	?>

	<?
	if($seq == "69"){
	?>
		$j('calbox[value="2019-10-12"]').click();
	<?
	}
	?>
});

var mapView = 1;

var main = new Object();
</script>
<div class="" style="width:100%;display:;padding-top:6px;">
	<h1 class="ngeb clear" style="font-size:16px;height:25px;"><i class="bg_color"></i>[<?=$rowMain["codename"]?>] <?=$rowMain["shopname"]?></h1>
</div>

<div class="container" id="contenttop">
  <section>
    <aside class="left_article"><img src="<?=$rowMain["shop_mainimg"]?>" onerror="this.src='https://surfenjoy.cdn3.cafe24.com/shop/none_500x500.jpg'" alt="" width="400" height="200" class="placeholder"/> </aside>
    <article class="right_article">
		<div style="padding-left:10px;">
		
			<div id="tour_calendar" style="display: block;">
				<?include 'SurfRes_Calendar.php';?>
			</div>

			<div id="initText" class="write_table" style="text-align: center;font-size:14px;padding-top:20px;padding-bottom:10px;display:;">
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

		</div>		
    </article>
  </section>
</div>

<link rel="stylesheet" type="text/css" href="surfshop_view.css" />
<link rel="stylesheet" type="text/css" href="surfshop_content.css" />

<div class="container">
  <section>
    <aside class="left_article2">

<!-- .tab_container -->
<div id="containerTab">
    <ul class="tabs">
        <li class="active" rel="tab1">샵 안내</li>
        <li rel="tab2" <?if($area != "1") echo "style='display:none;'"?>>바베큐 안내</li>
        <li rel="tab3">예약정보</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <!-- #tab1 -->
        <div id="tab1" class="tab_content" style="line-height:0;padding:0px;">
			<?
			if($rowMain["intseq"] != "64"){
			?>
			<?include __DIR__.'/../contentbanner.php';?>
			<?}?>
			<?
			if($rowMain["shop_contentfile"] == "image"){
				echo $rowMain["shop_content"];
			}else{
				include 'shopview/'.$rowMain["shop_contentfile"];
			}
			?>

			<div style="padding-left:5px;padding-top:10px;font-size:17px;border-bottom: 1px solid #6f7d7d;margin-bottom: 3px;margin-top: 10px;font-size:14px;font-weight:bold;display:none;"><?=$rowMain["shopname"]?> <span style="font-size:12px;">(<?=$rowMain["shop_addr"]?>)</span></div>

			<div id="shopview_2">
				<iframe scrolling="no" frameborder="0" id="ifrmMap" name="ifrmMap" style="width:100%;height:390px;display:;" src="SurfList_Map.php"></iframe>
			</div>

			<?include 'SurfRes_Customer.php';?>
        </div>
        <!-- #tab2 -->
        <div id="tab2" class="tab_content" style="line-height:0;">
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq01.jpg" class="placeholder2" />
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq02.jpg" class="placeholder2" />
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq03.jpg" class="placeholder2" />
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq04.jpg" class="placeholder2" />
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq05.jpg" class="placeholder2" />

			<?include 'SurfRes_Customer.php';?>
		</div>
        <!-- #tab3 -->
        <div id="tab3" class="tab_content">
			<?include 'SurfRes_SubTab3.php';?>

			<?include 'SurfRes_Customer.php';?>
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
								▶ 현금영수증 신청은 이용일 또는 이후 예약하신 서핑샵에서 신청가능합니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 숙소만 예약은 불가능하며, 강습이 포함되어야 예약 가능합니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 천재지변으로 인하여 예약이 취소될 경우 전액환불해드립니다.
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

		<!--div class="wellBtn menu">
			<div>
				<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:200px; height:44px;" value="서핑샵 예약" onclick="fnBusSave();" />
			</div>
		</div-->

	</article>
  </section>
</div>
<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:600px;display:none;"></iframe>


<script>
var sLng = "<?=$sLng?>";
var sLat = "<?=$sLat?>";

var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION2 = {
        '<?=$rowMain["shopname"]?>'		: [0, MARKER_SPRITE_Y_OFFSET*3, sLng, sLat, '<?=$rowMain["shop_addr"]?>', '<?=$rowMain["shop_tag"]?>', 0, <?=$rowMain["intseq"]?>, '<?=$rowMain["shop_mainimg"]?>', '<?=$rowMain["codename"]?>']
    };

<?=$SoldoutList?>
</script>

