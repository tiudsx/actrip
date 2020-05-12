<?php
include __DIR__.'/../../db.php';
include __DIR__.'/../../surf/surffunc.php';

$selDate = $_REQUEST["selDate"];

$select_query_bus = "SELECT seq, shopname, res_busnum, res_confirm, COUNT(*) AS CntBus FROM `AT_RES_SUB` 
						WHERE code = 'bus'
							AND res_date = '$selDate' 
							AND res_confirm = 3 
						GROUP BY seq, shopname, LEFT(res_busnum, 1) DESC, 
							(CASE WHEN LEFT(res_busnum, 1) = 'Y'  OR LEFT(res_busnum, 1) = 'E' 
								THEN RIGHT(res_busnum, 1) 
								ELSE RIGHT(res_busnum, 2) END), res_confirm";
$result_bus = mysqli_query($conn, $select_query_bus);
$count = mysqli_num_rows($result_bus);

if($count == 0){
?>
	<div class="contentimg bd">
	<div class="gg_first">셔틀버스 예약정보</div>
	<table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
		<colgroup>
			<col width="*" />
		</colgroup>
		<tbody>
			<tr>
				<td colspan="5" style="text-align:center;height:50px;">
				<b>예약된 목록이 없습니다.</b>
				</td>
			</tr>
		</tbody>
	</table>
</div>
	
<?
	return;
}

$arrBus = array();
while ($rowSub = mysqli_fetch_assoc($result_bus)){
	$arrBus[$rowSub['res_busnum']][$rowSub['res_confirm']] = $rowSub['CntBus'];
}
?>

<form name="frmDaySearch" id="frmDaySearch" autocomplete="off">
<div class="gg_first" style="margin-top:0px;">셔틀버스 예약정보</div>
<table class='et_vars exForm bd_tb' style="width:100%;display:;">
	<colgroup>
		<col style="width:16%;">
		<col style="width:*;">
	</colgroup>
	<tr>
		<th>버스종류</th>
		<td colspan="3" style="line-height:35px;">
			<input type="hidden" id="selDate" name="selDate" value="<?=$selDate?>">
			<input type="hidden" id="busNum" name="busNum" value="">
			<?foreach($arrBus as $key=>$value){?>
				<input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="<?=fnBusNum($key)?> [<?=$value[3]?>명]" onclick="fnDayList('<?=$key?>');" /> <br>
			<?}?>
		</td>
	</tr>
</table>
</form>

<div id="dayList">
	<div style="text-align:center;font-size:14px;padding:50px;">
		<b>버스종류를 선택하세요.</b>
	</div>
</div>

<script>
function fnDayList(vlu){
	if(vlu == "ALL"){
		$j("#dayList").html('<div style="text-align:center;font-size:14px;padding:50px;"><b>버스종류를 선택하세요.</b></div>');
	}else{
		$j("#busNum").val(vlu);

		var formData = $j("#frmDaySearch").serializeArray();

		$j.post("/act/admin/bus/res_busmnglist.php", formData,
			function(data, textStatus, jqXHR){
			   $j("#dayList").html(data);
			}).fail(function(jqXHR, textStatus, errorThrown){
		 
		});
	}
}

function fnModifyInfoDay(seq){
	$j("tr[name='btnTr']").removeClass('selTr');
	$j("tr[name='btnTrPoint']").removeClass('selTr');
	$j("#tab3").load("/Admin_BusModify.php?subintseq=" + seq + '&gubun=bus');
	$j(".tab_content").hide();
	$j("#tab3").fadeIn();
}

</script>