<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$selDate = $_REQUEST["selDate"];

$select_query_bus = 'SELECT busNum, ResConfirm, COUNT(*) AS CntBus FROM `SURF_BUS_SUB` where busDate = "'.$selDate.'" AND ResConfirm = 1 GROUP BY LEFT(busNum, 1) DESC,  RIGHT(busNum, 1), ResConfirm';
$result_bus = mysqli_query($conn, $select_query_bus);

$arrBus = array();
while ($rowSub = mysqli_fetch_assoc($result_bus)){
	$arrBus[$rowSub['busNum']][$rowSub['ResConfirm']] = $rowSub['CntBus'];
}
?>

<form name="frmDaySearch" id="frmDaySearch" autocomplete="off">
<div class="gg_first" style="margin-top:0px;">예약목록</div>
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
				<input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="<?=fnBusNum($key)?> [<?=$value[1]?>명]" onclick="fnDayList('<?=$key?>');" /> <br>
			<?}?>
			<!--select id="busNum" name="busNum" class="select" style="padding:1px 2px 4px 2px;" onchange="fnDayList(this.value);">
				<option value="ALL">== 호차 ==</option>
			
			</select-->
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

		$j.post(folderBusRoot + "/Admin_Bus_DayList.php", formData,
			function(data, textStatus, jqXHR){
			   $j("#dayList").html(data);
			}).fail(function(jqXHR, textStatus, errorThrown){
		 
		});
	}
}

function fnModifyInfoDay(seq){
	$j("tr[name='btnTr']").removeClass('selTr');
	$j("tr[name='btnTrPoint']").removeClass('selTr');
	$j("#tab3").load(folderBusRoot + "/Admin_BusModify.php?subintseq=" + seq + '&gubun=bus');
	$j(".tab_content").hide();
	$j("#tab3").fadeIn();
}

</script>