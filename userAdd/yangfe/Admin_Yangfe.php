<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';
?>

<link rel="stylesheet" type="text/css" href="surfbus_admin.css" />
<script src="surfbus_admin.js"></script>

<script>
var userid = "<?=$user_id?>";
$j(document).ready(function(){
	fnBusSearch();
});
</script>

<meta name="viewport" content="width=device-width, initial-scale=0.7, minimum-scale=0.5, maximum-scale=1, user-scalable=yes" />

<div class="bd_tl" style="width:100%;display:none;">
	<h1 class="ngeb clear"><i class="bg_color"></i>서울 - 양양 셔틀버스 예약하기</h1>
</div>

<div class="container" id="contenttop">
  <section>
    <aside class="left_article">
<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <ul class="tabs">
        <li class="active" rel="tab1">검색관리</li>
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
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" checked="checked" value="0" style="vertical-align:-3px;" />미입금</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" checked="checked" value="1" style="vertical-align:-3px;" />입금대기</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="2" style="vertical-align:-3px;" />확정</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="3" style="vertical-align:-3px;" />취소</label>
					</td>
				</tr>
				<tr>
					<th>신청구분</th>
					<td>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="참관" style="vertical-align:-3px;" />참관</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="비기너" style="vertical-align:-3px;" />비기너</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="주니어" style="vertical-align:-3px;" />주니어</label><br>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="롱보드(오픈)" style="vertical-align:-3px;" />롱보드(오픈)</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="숏보드(오픈)" style="vertical-align:-3px;" />숏보드(오픈)</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="롱보드(프로)" style="vertical-align:-3px;" />롱보드(프로)</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="숏보드(프로)" style="vertical-align:-3px;" />숏보드(프로)</label>
					</td>
				</tr>
				<tr>
					<th>성별</th>
					<td>
						<label><input type="checkbox" id="chkResSex" name="chkResSex[]" checked="checked" value="남" style="vertical-align:-3px;" />남</label>
						<label><input type="checkbox" id="chkResSex" name="chkResSex[]" checked="checked" value="여" style="vertical-align:-3px;" />여</label>
					</td>
				</tr>
				<tr>
					<th>검색어</th>
					<td><input type="text" id="schText" name="schText" value="" class="itx2" style="width:100px;"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="검색" onclick="fnBusSearch();" /></td>
				</tr>
			</table>
		</form>

			<div id="mngSearch"></div>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
  </section>
</div>

<input type="hidden" id="hidselDate" value="">
<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:400px;display:none;"></iframe>

<script>
<?
$select_queryPoint = 'SELECT * FROM SURF_CODE where groupcode = "bus" ORDER BY gubun, ordernum';
$result_setlistPoint = mysqli_query($conn, $select_queryPoint);

$arrPoint = array();
while ($rowPoint = mysqli_fetch_assoc($result_setlistPoint)){
	if($arrPoint[$rowPoint['gubun']] == null){
		$arrPoint[$rowPoint['gubun']] = '0';
		echo 'var '.$rowPoint['gubun'].'Point = "<option value=\''.$rowPoint['code'].'\'>'.$rowPoint['codename'].'</option>";';
	}else{
		echo $rowPoint['gubun'].'Point += "<option value=\''.$rowPoint['code'].'\'>'.$rowPoint['codename'].'</option>";';
	}
}
?>
</script>