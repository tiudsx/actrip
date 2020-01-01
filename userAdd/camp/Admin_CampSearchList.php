<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$selDate = $_REQUEST["selDate"];
?>

<form name="frmConfirm" id="frmConfirm" autocomplete="off">
    <div class="gg_first">죽도야영장 예약정보
		<span class="calendar_description">
			<span class="calendar_description_list">
				<span class="calendar_description_item"><button type="button" class="tour_cal_type tour_cal_type1">예약가능</button></span>
				<span class="calendar_description_item"><button type="button" class="tour_cal_type tour_cal_type2">예약완료</button></span>
			</span>			
		</span>
	</div>

    <table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
		<colgroup>
			<col style="width:50%;">
			<col style="width:50%;">
		</colgroup>
		<tbody>
	<?
	for($i=0; $i<=21; $i++){
		$num1 = ($i) + 101;
		$num2 = ($i) + 118;
	?>
			<tr>
				<td class="col-3" style="text-align:center;"><span id="seatC<?=$num1?>" class="tab1"><span style="width:45px;"><label>C<?=$num1?></label></span></span></td>
				<td class="col-3" style="text-align:center;">
				<?if($i > 4){?>
					<span id="seatC<?=$num2?>" class="tab1"><span style="width:45px;"><label>C<?=$num2?></label></span></span>
				<?}else{?>
					<span id="seatD<?=$num2 + 83?>" class="tab1"><span style="width:45px;"><label>D<?=$num2 + 83?></label></span></span>
				<?}?>
				</td>
			</tr>
	<?
	}
	?>

		</tbody>
	</table>
</form>

<?
$select_query = 'SELECT a.userName, a.userPhone, b.sLocation, b.ResOptPrice, a.ResShower, a.intseq, b.ResConfirm, b.subintseq FROM SURF_CAMPING_MAIN as a INNER JOIN SURF_CAMPING_SUB as b 
	ON a.MainNumber = b.MainNumber 
	WHERE b.sDate = "'.$selDate.'"
		 AND b.ResConfirm IN (0, 1)
	ORDER BY b.MainNumber, b.sDate, b.sLocation, b.subintseq';
//echo $select_query;
$result_setlist = mysqli_query($conn, $select_query);

$select_query2 = 'SELECT a.userName, a.userPhone, b.sLocation FROM SURF_CAMPING_MAIN as a INNER JOIN SURF_CAMPING_SUB as b 
	ON a.MainNumber = b.MainNumber 
	WHERE b.sDate = "'.date("Y-m-d", strtotime($selDate." -1 day")).'"
		 AND b.ResConfirm IN (1)
	ORDER BY b.MainNumber, b.sDate, b.sLocation, b.subintseq';
$result_setlist2 = mysqli_query($conn, $select_query2);

$arrResPre = array();
while ($row2 = mysqli_fetch_assoc($result_setlist2)){
	$arrResPre[$row2["userName"].$row2["userPhone"].$row2["sLocation"]] = "1";
}


echo '<script type="text/javascript">';

while ($row = mysqli_fetch_assoc($result_setlist)){
	$preUse = "";
	if($arrResPre[$row["userName"].$row["userPhone"].$row["sLocation"]] != ""){
		$preUse = "<span style=color:red;>[연박] </span>";
	}
	$arrOpt = explode("@",$row['ResOptPrice']);
	$locationOpt2 = "";
	if($arrOpt[2] > 0){
		$locationOpt2 = " (".$arrOpt[1].")";
	}

	if($row['ResConfirm'] == "1"){
		echo '$j("#seat'.$row['sLocation'].'").removeClass("tab1");';

		echo '$j("#seat'.$row['sLocation'].'").attr("onclick", "fnModifyInfoDay('.$row['subintseq'].')");';
		echo '$j("#seat'.$row['sLocation'].'").addClass("tab2");';
		echo '$j("#seat'.$row['sLocation'].' input").remove();';
		$cssColor = "onclick='fnShower(".$row["intseq"].", this);'";
		$cssText = "X";
		if($row["ResShower"] == "1"){
			$cssColor = " style='color:#d4d4d4;'";
			$cssText = "O";
		}

		echo '$j("#seat'.$row['sLocation'].'").parent().append(" <span  '.$cssColor.'>[샤워 '.$cssText.' ]</span> <br>'.$preUse.'<b>'.$row["userName"].$locationOpt2.'<br><span onclick=document.location.href=&apos;tel:'.$row["userPhone"].'&apos;>'.$row["userPhone"].'</span></b>");';
	}else{
		echo '$j("#seat'.$row['sLocation'].'").removeClass("tab1");';
		echo '$j("#seat'.$row['sLocation'].'").addClass("tab2");';
		echo '$j("#seat'.$row['sLocation'].' input").remove();';
		echo '$j("#seat'.$row['sLocation'].'").parent().append(" <span style=color:red;>[입금대기]</span> <br>'.$preUse.''.$row["userName"].$locationOpt2.'<br><span onclick=document.location.href=&apos;tel:'.$row["userPhone"].'&apos;>'.$row["userPhone"].'</span>");';
	}
}

echo '</script>';
?>

<script type="text/javascript">
	function fnShower(intSeq, obj){
        var msg = "샤워쿠폰 발급 완료 하시겠습니까?";

        if (confirm(msg)) {
            var params = "resparam=AdminShower&intSeq=" + intSeq;
            $j.ajax({
                type: "POST",
                url: folderRoot + "/Admin_CampSave.php",
                data: params,
                error: whenError,
                success: function (data) {
                    if (data == "0") {
                        alert("정상적으로 처리되었습니다.");

						$j(obj).css("color", "#d4d4d4").html('[샤워 O ]').removeAttr("onclick");
                    } else if (data == "err") {
                        alert("처리중 오류가 발생하였습니다.");
                    } else {
                        alert("처리중 오류가 발생하였습니다.");
                    }
                }
            });
        }
	}
</script>
