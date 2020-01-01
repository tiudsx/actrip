<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

session_start();

$selDate = $_REQUEST["selDate"];

$select_query = 'SELECT opt_bbq FROM `SURF_SHOP` WHERE intseq = '.$_SESSION['shopseq'];
$result_shop = mysqli_query($conn, $select_query);
$rowshop = mysqli_fetch_array($result_shop);

$opt_bbq = $rowshop["opt_bbq"]; //서프엔조이 바베큐 여부

$bbqSql = "";
if($opt_bbq == "Y"){
	$bbqSql = "AND b.ResGubun != 4";
}

$select_query = 'SELECT a.userName, a.userPhone, a.Etc, a.memo, b.*, c.codename FROM `SURF_SHOP_RES_MAIN` as a INNER JOIN `SURF_SHOP_RES_SUB` as b 
					ON a.MainNumber = b.MainNumber 
				INNER JOIN SURF_CODE as c
					ON cast(b.ResGubun as char(1)) = c.code						
					WHERE shopSeq = '.$_SESSION['shopseq'].'
						'.$bbqSql.'
						AND b.ResDate = CAST("'.$selDate.'" AS DATE)
						AND b.ResConfirm = 5
						ORDER BY b.MainNumber, b.subintseq';

//echo $select_query;
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count == 0){
	echo '<div style="text-align:center;font-size:14px;padding:50px;">
				<b>확정 예약된 정보가 없습니다.</b>
			</div>';
	return;
}
?>

<form name="frmConfirm" id="frmConfirm" autocomplete="off">
    <div class="gg_first" style="padding-bottom:7px;">서핑샵 예약정보 - <?=$_SESSION['shopname']?> <span style="font-size:11px;"><input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="엑셀다운" onclick="fnAdminExcel(1);" /></span></div>
<?
$i = 0;
$x = 0;
$PreMainNumber = "";
$TotalPrice = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){
	$now = date("Y-m-d");
	$MainNumber = $row['MainNumber'];
	$etc = $row['Etc'];
	$memo = $row['memo'];

	if($MainNumber != $PreMainNumber && $x > 0){
		?>
		</tbody>
	</table>
				</td>
            </tr>
		<?if($TotalPrice > 0){?>
            <tr>
                <th>확정금액</th>
                <td colspan="3"><?=number_format($TotalPrice).'원'?></td>
            </tr>
		<?}?>
		<?if($etc != ""){?>
            <tr>
                <th>특이사항</th>
                <td colspan="3"><textarea id="etc" name="etc" rows="3" style="width: 90%; resize:none;" disabled="disabled"><?=$etc?></textarea></td>
            </tr>
		<?}?>
		<?if($memo != ""){?>
           <tr>
                <th>사유 및<br>메모</th>
                <td colspan="3">
					<textarea id="memo" name="memo" rows="3" style="width: 90%; resize:none;" disabled="disabled"><?=$memo?></textarea>
				</td>
            </tr>
		<?}?>
		</tbody>
	</table>
<?
	}

	if($MainNumber == $PreMainNumber){
		$i++;
	}else{
		$i = 0;
		$TotalPrice = 0;
	}

	$x++;
	$PreMainNumber = $row['MainNumber'];

	if($i == 0){
?>

	<div style="margin-bottom:5px;width:100%;padding-top:11px;font-size:12px;">
		<span><strong><?=$row['MainNumber']?></strong> (<?=$row['insdate']?>)</span>
	</div>
    <table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
		<colgroup>
			<col style="width:60px;">
			<col style="width:100px;">
			<col style="width:60px;">
			<col style="width:*;">
		</colgroup>
        <tbody>
			<tr>
                <th>예약자</th>
                <td><?=$row['userName']?></td>
				<th>연락처</th>
                <td><?=$row['userPhone']?></td>
            </tr>
			<tr>
				<td colspan="4">

    <table class="et_vars exForm bd_tb" style="width:100%">
		<colgroup>
			<col style="width:80px;">
			<col style="width:*;">
			<col style="width:40px;">
		</colgroup>
        <tbody>
<?
	}
/*
예약구분
-----------
0	미입금
1	취소
2	예약대기
3	임시확정
4	임시취소
5	확정
6	환불요청
7	환불완료
*/

	$ResColor = "";
	$ResCss = "";
	$MainNumber = $row['MainNumber'];
	$datDate = substr($row['ResDate'], 0, 10);

	if($row['ResConfirm'] == 5){
		$ResConfirm = "확정";
		$ResColor = "rescolor1";
	}

	if ($datDate < $now)
	{
		//$ResCss = "resper";
	}

	if($row['ResConfirm'] == 5){
		$TotalPrice += $row['ResPrice'];
	}

	$TimeDate = "";
	if($row['ResGubun'] == 0 || $row['ResGubun'] == 2){
		$TimeDate = '('.$row['ResTime'].')';
	}else if($row['ResGubun'] == 3){
		$TimeDate = '('.$row['ResDay'].')';
	}
	
	$ResNum = "";
	if($row['ResNumM'] > 0){
		$ResNum = "남:".$row['ResNumM'].'&nbsp;';
	}

	if($row['ResNumW'] > 0){
		$ResNum .= "여:".$row['ResNumW'];
	}

?>
			<tr class="<?=$ResCss?>" name="btnTr">
                <td style="text-align:center;">
					<input type="hidden" id="MainNumber" name="MainNumber" value="<?=$MainNumber?>">
					<label>
					<?if($row['ResConfirm'] == 2 || $row['ResConfirm'] == 3 || $row['ResConfirm'] == 4){?>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="<?=$row['subintseq']?>" style="vertical-align:-3px;" /><br>
					<?}?>
					<?=$row['ResDate']?>
					</label>
				</td>
				<td>
			<?if($row['ResGubun'] == 2){?>
                <?=$row['ResDay']?> <span style="padding-left:0px;"><br><?=$TimeDate?></span>
			<?}else{?>
               [<?=$row['codename']?>] <?=$row['ResOptName']?> <span style="padding-left:0px;"><?=$TimeDate?></span>
			<?}?>
				/ <?=$ResNum?></td>
                <td style="text-align:center;">
					<strong class="<?=$ResColor?>"><?=$ResConfirm?></strong>
				</td>
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
                <th>확정금액</th>
                <td colspan="3"><?=number_format($TotalPrice).'원'?></td>
            </tr>
		<?}?>
		<?if($etc != ""){?>
             <tr>
                <th>특이사항</th>
                <td colspan="3"><textarea id="etc" name="etc" rows="3" style="width: 90%; resize:none;" disabled="disabled"><?=$etc?></textarea></td>
            </tr>
		<?}?>
		<?if($memo != ""){?>
            <tr>
                <th>사유 및<br>메모</th>
                <td colspan="3">
					<textarea id="memo" name="memo" rows="3" style="width: 90%; resize:none;" disabled="disabled"><?=$memo?></textarea>
				</td>
            </tr>
 		<?}?>
		</tbody>
	</table>

	<span id="hidInitParam" style="display:none;">
		<input type="hidden" id="sDate1" name="sDate1" size="10" value="<?=$selDate?>" class="itx">
	</span>
</form>