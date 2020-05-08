<?php 
include __DIR__.'/../../db.php';
include __DIR__.'/../../common/logininfo.php';

session_start();

if($_SESSION['shopseq'] == ""){
	$select_query_admin = 'SELECT * FROM `AT_PROD_MAIN` where seq="'.$surftype.'" limit 1';
	$resultAdmin = mysqli_query($conn, $select_query_admin);
	$countAdmin = mysqli_num_rows($resultAdmin);
	$rowAdmin = mysqli_fetch_array($resultAdmin);

	if($countAdmin == 0){
		echo '<script>alert("관리자 권한이 없습니다.");history.back();</script>';
		exit;
	}

	$_SESSION['userid'] = $user_id;
	$_SESSION['shopseq'] = $rowAdmin["seq"];
	$_SESSION['shopname'] = $rowAdmin["shopname"];

	$shopseq = $rowAdmin["seq"];
}else{
	$shopseq = $_SESSION['shopseq'];
}
?>

<div class="bd_tl" style="width:100%;display:;">
	<h1 class="ngeb clear"><i class="bg_color"></i>[<?=$_SESSION['shopname']?>] 예약관리</h1>
</div>

<script>
    var busDateinit = "2020-04-01";
</script>
<link rel="stylesheet" type="text/css" href="/act/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="/act/css/surfview.css">
<link rel="stylesheet" type="text/css" href="/act/css/admin/admin_surf.css">
<link rel="stylesheet" type="text/css" href="/act/css/admin/admin_common.css">
<script type="text/javascript" src="/act/js/admin_surf.js"></script>
<script type="text/javascript" src="/act/js/surfview_bus.js"></script>

<div class="container" id="contenttop">
  <section>
    <article class="right_article3">
		<?include 'res_surfcalendar.php'?>
    </article>
    <aside class="left_article3">
<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <ul class="tabs">
        <li class="active" rel="tab1">예약관리</li>
        <li rel="tab2">매진처리</li>
        <li rel="tab3">정산관리</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <!-- #tab1 -->
        <div id="tab1" class="tab_content">
		<form name="frmSearch" id="frmSearch" autocomplete="off">
			<div class="gg_first" style="margin-top:0px;">예약검색</div>
			<table class='et_vars exForm bd_tb' style="width:100%">
				<colgroup>
					<col style="width:65px;">
					<col style="width:*;">
					<col style="width:100px;">
				</colgroup>
				<tr>
					<th>구분</th>
					<td>
						<!-- <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="0" checked="checked" style="vertical-align:-3px;" />미입금</label> -->
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="8" checked="checked" style="vertical-align:-3px;" />입금완료</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="3" style="vertical-align:-3px;" />확정</label>
						<!-- <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="7" style="vertical-align:-3px;" />취소</label><br> -->
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="2" style="vertical-align:-3px;" />임시확정</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="6" style="vertical-align:-3px;" />임시취소</label>
						<!-- <label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="4" checked="checked" style="vertical-align:-3px;" />환불요청</label> -->
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="5" style="vertical-align:-3px;" />취소</label>
					</td>
				</tr>
				<tr>
					<th>검색기간</th>
					<td>
						<input type="text" id="sDate" name="sDate" cal="sdate" readonly="readonly" value="<?=$datDate?>" class="itx2" maxlength="7" style="width:66px;" >&nbsp;~
						<input type="text" id="eDate" name="eDate" cal="edate" readonly="readonly" value="<?=$Year?>-<?=$Mon?>-<?=$s_t?>" class="itx2" maxlength="7" style="width:66px;" >
						<input type="hidden" id="seq" name="seq" size="10" value="<?=$shopseq?>" class="itx">
					</td>
					
				</tr>
				<tr>
					<th>검색어</th>
					<td><input type="text" id="schText" name="schText" value="" class="itx2" style="width:140px;"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="검색" onclick="fnSearchAdmin();" /></td>
				</tr>
			</table>
		</form>
		<div id="mngSearch"><?include 'res_surflist_search.php'?></div>
		</div>

		<div id="tab2" class="tab_content" style="display:none;">
<?
$select_query = "SELECT a.*, b.codename FROM `AT_PROD_OPT` a INNER JOIN `AT_CODE` b
					ON a.optcode = b.code
						AND b.uppercode = 'surfres'
 					WHERE a.seq = ".$_SESSION['shopseq']." 
						AND a.use_yn = 'Y' 
					ORDER BY a.optcode, a.ordernum";
$result_opt = mysqli_query($conn, $select_query);
?>
			<form name="frmSold" id="frmSold" autocomplete="off">
				<div class="gg_first" style="margin-top:0px;">매진항목 추가</div>
				<table class='et_vars exForm bd_tb' style="width:100%">
					<colgroup>
						<col style="width:65px;">
						<col style="width:*;">
					</colgroup>
					
					<tr>
						<th>날짜</th>
						<td>
							<input type="text" id="strDate" name="strDate" readonly="readonly" value="" class="itx2" cal="date" style="width:66px;">
							<input type="hidden" id="resparam" name="resparam" size="10" value="soldout" class="itx">
							<input type="hidden" id="userid" name="userid" size="10" value="<?=$user_id?>" class="itx">
						</td>
					</tr>
					<tr>
						<th>항목</th>
						<td>
							<select id="selItem" name="selItem" class="select">
							<?while ($rowOpt = mysqli_fetch_assoc($result_opt)){?>
								<option value="<?=$rowOpt["optseq"]?>">[<?=$rowOpt["codename"]?>] <?=$rowOpt["optname"]?></option>
							<?}?>
							</select>
						</td>
					</tr>
					<tr>
						<th>성별</th>
						<td>
							<label><input type="checkbox" id="chkSexM" name="chkSexM" value="1" checked="checked" style="vertical-align:-3px;" />남</label>&nbsp;
							<label><input type="checkbox" id="chkSexW" name="chkSexW" value="1" checked="checked" style="vertical-align:-3px;" />여</label>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;" colspan="2"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:100px; height:30px;" value="매진 추가" onclick="fnSoldout();" /></td>
					</tr>
				</table>
			</form>
			<div id="divSoldOutList">
				<?include 'res_surflist_soldout.php'?>
			</div>
		</div>

		<div id="tab3" class="tab_content" style="display:none;">
			<div id="divCalList">
				<?include 'res_surflist_cal.php'?>
			</div>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
  </section>
</div>