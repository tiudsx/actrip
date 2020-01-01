<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';
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
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="1" style="vertical-align:-3px;" />확정</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="2" style="vertical-align:-3px;" />취소</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" checked="checked" value="3" style="vertical-align:-3px;" />환불요청</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="4" style="vertical-align:-3px;" />환불완료</label>
					</td>
				</tr>
				<tr>
					<th>양양행</th>
					<td>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="Y1" style="vertical-align:-3px;" />1호차</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="Y2" style="vertical-align:-3px;" />2호차</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="Y3" style="vertical-align:-3px;" />3호차</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="Y4" style="vertical-align:-3px;" />4호차</label><br>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="Y5" style="vertical-align:-3px;" />5호차</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" value="Y6" style="vertical-align:-3px;" />6호차</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" value="Y7" style="vertical-align:-3px;" />7호차</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" value="Y8" style="vertical-align:-3px;" />8호차</label>
					</td>
				</tr>
				<tr>
					<th>서울행</th>
					<td>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="S1" style="vertical-align:-3px;" />1호차</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="S2" style="vertical-align:-3px;" />2호차</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" checked="checked" value="S3" style="vertical-align:-3px;" />3호차</label>
						<label><input type="checkbox" id="chkbusNum" name="chkbusNum[]" value="S4" style="vertical-align:-3px;" />4호차</label>
					</td>
				</tr>
				<tr>
					<th>검색기간</th>
					<td align="center">
						<input type="text" id="sDate" name="sDate" cal="date" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >&nbsp;~
						<input type="text" id="eDate" name="eDate" cal="date" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >
						<input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="전체" onclick="fnDateReset();" />
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