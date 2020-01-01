<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$chkResConfirm = $_REQUEST["chkResConfirm"];
$chkbusNum = $_REQUEST["chkbusNum"];
$sbusDate = $_REQUEST["sDate"];
$ebusDate = $_REQUEST["eDate"];
$schText = trim($_REQUEST["schText"]);

$inResConfirm = "";
for($i = 0; $i < count($chkResConfirm); $i++){
	$inResConfirm .= $chkResConfirm[$i].',';
}
$inResConfirm .= '99';

$inResType = "";
for($i = 0; $i < count($chkbusNum); $i++){
	$inResType .= '"'.$chkbusNum[$i].'",';
}
$inResType .= '99';

$busDate = "";
$bbqDate = "";
if($sbusDate == "" && $ebusDate == ""){
}else{
	if($sbusDate != "" && $ebusDate != ""){
		$busDate = ' AND (busDate BETWEEN CAST("'.$sbusDate.'" AS DATE) AND CAST("'.$ebusDate.'" AS DATE))';
	}else if($sbusDate != ""){
		$busDate = ' AND busDate >= CAST("'.$sbusDate.'" AS DATE)';
	}else if($ebusDate != ""){
		$busDate = ' AND busDate <= CAST("'.$ebusDate.'" AS DATE)';
	}
}

if($schText != ""){
	$schText = ' AND (a.MainNumber like "%'.$schText.'%" OR a.userName like "%'.$schText.'%" OR a.userPhone like "%'.$schText.'%")';
}

$select_query = 'SELECT a.userName, a.userPhone, a.Etc, b.* FROM `SURF_BUS_MAIN` as a INNER JOIN `SURF_BUS_SUB` as b 
					ON a.MainNumber = b.MainNumber 
					WHERE b.ResConfirm IN ('.$inResConfirm.')
						AND busNum IN ('.$inResType.')'.$busDate.$schText.' 
						ORDER BY b.MainNumber, b.busDate, b.subintseq';

//echo $select_query;
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count == 0){
	echo '<div style="text-align:center;font-size:14px;padding:50px;">
				<b>예약된 정보가 없습니다.</b>
			</div>';
	return;
}
?>

<form name="frmConfirm" id="frmConfirm" autocomplete="off">
    <div class="gg_first">양양셔틀버스 예약정보 <span style="font-size:11px;"></span></div>
<?
$i = 0;
$x = 0;
$PreMainNumber = "";
$RtnTotalPrice = 0;
$TotalPrice = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){
	$now = date("Y-m-d");
	$MainNumber = $row['MainNumber'];

	if($MainNumber != $PreMainNumber && $x > 0){
		if($RtnTotalPrice > 0){
		?>
			<tr>
                <th style="text-align:center;">환불금액</th>
                <td style="text-align:left;padding-left:10px;" colspan="3"><b><?=number_format($RtnTotalPrice).'원'?></b></td>
            </tr>
		<?
		}
		?>
		</tbody>
	</table>
				</td>
            </tr>
		<?if($TotalPrice > 0){?>
            <tr>
                <th>결제금액</th>
                <td colspan="3"><?=number_format($TotalPrice).'원'?></td>
            </tr>
		<?}?>
		<?if($etc != ""){?>
            <tr>
                <th>특이사항</th>
                <td colspan="3"><textarea id="etc" name="etc" rows="3" style="width: 90%; resize:none;" disabled="disabled"><?=$etc?></textarea></td>
            </tr>
		<?}?>
            <tr>
                <th>사유 및<br>메모</th>
                <td colspan="3">
					<textarea id="memo" name="memo" rows="3" style="width: 90%; resize:none;"><?=$memo?></textarea>
				</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:center;font-size:14px;padding:4px;">
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:100px; height:25px;" value="상태변경하기" onclick="fnConfirmUpdate(1, this);" />
				</td>
            </tr>
		</tbody>
	</table>
<?
	}

	if($MainNumber == $PreMainNumber){
		$i++;
	}else{
		$RtnTotalPrice = 0;
		$TotalPrice = 0;
		$i = 0;
	}

	$x++;
	$PreMainNumber = $row['MainNumber'];
	$etc = $row['Etc'];

	if($i == 0){
?>
	<div style="margin-bottom:5px;width:100%;padding-top:11px;font-size:12px;">
		<span><strong><?=$row['MainNumber']?></strong> (<?=$row['insdate']?>)</span>
	</div>
    <table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
        <tbody>
			<tr>
                <th>예약자</th>
                <td><?=$row['userName']?><span style="display:;">  (<?=$row['userPhone']?>)</span></td>
				<th></th>
                <td></td>
            </tr>
			<tr>
				<td colspan="4">

    <table class="et_vars exForm bd_tb" style="width:100%">
		<colgroup>
			<col style="width:80px;">
			<col style="width:*;">
			<col style="width:100px;">
		</colgroup>
        <tbody>
<?
	}
/*
예약구분
-----------
0	미입금
1	확정
2	취소
3	환불요청
4	환불완료
*/

	$ResColor = "";
	$ResCss = "";
	$datDate = substr($row['busDate'], 0, 10);

	$RtnBankRow = 'rowspan="2"';
	if($row['ResConfirm'] == 0){
		$ResConfirm = "미입금";
	}else if($row['ResConfirm'] == 1){
		$ResConfirm = "확정";
		$ResColor = "rescolor1";
	}else if($row['ResConfirm'] == 2){
		$ResConfirm = "취소완료";
	}else if($row['ResConfirm'] == 3){
		$ResConfirm = "환불요청";
		$ResColor = "rescolor2";
	}else if($row['ResConfirm'] == 4){
		$ResConfirm = "환불완료";
	}

	if ($datDate < date("Y-m-d", strtotime($now." 0 day")))
	{
		$ResCss = "resper";
	}

	$RtnPrice = '';
	$RtnBank = '';
	if($row['ResConfirm'] == 3 || $row['ResConfirm'] == 4){
		$RtnPrice = ''.number_format($row['RtnSumPrice']).'원';
		$RtnBank = '<tr class="'.$ResCss.'" name="btnTrPoint">
						<td style="text-align:center;" colspan="3">'.str_replace('|', '&nbsp ', $row['RtnBank']).' | 환불액 : '.$RtnPrice.'</td>
					</tr>';
	}

	if($row['ResConfirm'] == 3){
		$RtnTotalPrice += $row['RtnSumPrice'];
	}

	if($row['ResConfirm'] == 0){
		$TotalPrice += $row['ResPrice'];
	}
?>
			<tr class="<?=$ResCss?>" name="btnTr">
                <td style="text-align:center;" rowspan="2">
					<input type="hidden" id="MainNumber" name="MainNumber" value="<?=$MainNumber?>">
					<label>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="bus@<?=$row['subintseq']?>" style="vertical-align:-3px;" /><br>
					<?=$row['busDate']?>
					</label>
				</td>
                <td style="text-align:center;cursor:pointer;" onclick="fnModifyInfo('<?=$row['subintseq']?>', 'bus', this);">[<?=fnBusNum($row['busNum'])?>] <b><?=$row['busSeat']?>번</b></td>
                <td style="text-align:center;">
					<strong class="<?=$ResColor?>"><?=$ResConfirm?></strong>
				</td>
				
            </tr>
			<tr class="<?=$ResCss?>" name="btnTrPoint">
				<td style="text-align:center;"><?=$row["sLocation"]?> -> <?=$row["eLocation"]?></td>
				<td style="text-align:center;">
					<select id="selConfirm" name="selConfirm[]" class="select" style="padding:1px 2px 4px 2px;" onchange="fnChangeModify(this, <?=$row['ResConfirm']?>);">
						<option value="0" <?if($row['ResConfirm'] == 0) echo "selected"?>>미입금</option>
						<option value="1" <?if($row['ResConfirm'] == 1) echo "selected"?>>확정</option>
						<option value="2" <?if($row['ResConfirm'] == 2) echo "selected"?>>취소</option>
						<option value="3" <?if($row['ResConfirm'] == 3) echo "selected"?>>환불요청</option>
						<option value="4" <?if($row['ResConfirm'] == 4) echo "selected"?>>환불완료</option>
					</select>
				</td>
			</tr>
			<?=$RtnBank?>
<?
}

if($RtnTotalPrice > 0){
?>
			<tr>
                <th style="text-align:center;">환불금액</th>
                <td style="text-align:left;padding-left:10px;" colspan="3"><b><?=number_format($RtnTotalPrice).'원'?></b></td>
            </tr>
<?
}
?>



		</tbody>
	</table>
				</td>
            </tr>
		<?if($TotalPrice > 0){?>
            <tr>
                <th>결제금액</th>
                <td colspan="3"><?=number_format($TotalPrice).'원'?></td>
            </tr>
		<?}?>
		<?if($etc != ""){?>
            <tr>
                <th>특이사항</th>
                <td colspan="3"><textarea id="etc" name="etc" rows="3" style="width: 90%; resize:none;" disabled="disabled"><?=$etc?></textarea></td>
            </tr>
		<?}?>
            <tr>
                <td colspan="4" style="text-align:center;font-size:14px;padding:4px;">
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:100px; height:25px;" value="상태변경하기" onclick="fnConfirmUpdate(1, this);" />
				</td>
            </tr>
		</tbody>
	</table>

	<span id="hidInitParam" style="display:none;">
		<input type="hidden" id="resparam" name="resparam" size="10" value="changeConfirm" class="itx">
		<input type="hidden" id="userid" name="userid" size="10" value="" class="itx">
		<input type="hidden" id="changeConfirm" name="changeConfirm" size="10" value="1" class="itx">
	</span>
</form>

<form name="frmConfirmSel" id="frmConfirmSel" style="display:none;">

</form>