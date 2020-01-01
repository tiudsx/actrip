<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';

$MainNumber = $_REQUEST["MainNumber"]; //카카오에서 넘어오는 파라미터
?>

<link rel="stylesheet" type="text/css" href="camp_admin.css" />
<script src="camp_admin.js"></script>

<script>
var userid = "<?=$user_id?>";
$j(document).ready(function(){
	fnAdminSearch();
});



function fnModifyInfoDay(seq){
	$j("tr[name='btnTr']").removeClass('selTr');
	$j("tr[name='btnTrPoint']").removeClass('selTr');
	$j("#tab3").load(folderRoot + "/Admin_CampModify.php?subintseq=" + seq);
	$j(".tab_content").hide();
	$j("#tab3").fadeIn();
}
</script>

<div class="container" id="contenttop">
  <section>
    <article class="right_article">
		<?include 'Admin_CampCalendar.php'?>
    </article>
    <aside class="left_article">
<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <ul class="tabs">
        <li class="active" rel="tab1">검색관리</li>
        <li rel="tab2">예약목록</li>
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
					<th>검색기간</th>
					<td align="center">
						<input type="text" id="sDate" name="sDate" cal="date" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >&nbsp;~
						<input type="text" id="eDate" name="eDate" cal="date" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >
						<input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="전체" onclick="fnDateReset();" />
					</td>
					
				</tr>
				<tr>
					<th>검색어</th>
					<td><input type="text" id="schText" name="schText" value="<?=$MainNumber?>" class="itx2" style="width:100px;"></td>
				</tr>
				<tr>
					<th>현장구분</th>
					<td>
						<label><input type="checkbox" id="chkResType" name="chkResType[]" checked="checked" value="현장" style="vertical-align:-3px;" />현장</label>
						<label><input type="checkbox" id="chkResType" name="chkResType[]" checked="checked" value="온라인" style="vertical-align:-3px;" />온라인</label>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="검색" onclick="fnAdminSearch();" /></td>
				</tr>
			</table>
		</form>

			<div id="mngSearch"></div>
		</div>

        <!-- #tab2 -->
        <div id="tab2" class="tab_content">
			<div style="text-align:center;font-size:14px;padding:50px;" id="initText2">
				<b>달력에서 날짜를 클릭하세요.</b>
			</div>
			<div id="divResList" ></div>
		</div>
        <div id="tab3" class="tab_content">
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