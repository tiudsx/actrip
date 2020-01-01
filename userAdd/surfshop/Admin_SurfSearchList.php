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

<div class="gg_first" style="padding-bottom:7px;">[<?=$_SESSION['shopname']?>] : <?=$selDate?> 확정예약 목록 &nbsp;<span style="font-size:11px;"><input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="엑셀다운" onclick="fnAdminExcel(1);" /></span></div>

<table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
<colgroup>
	<col style="width:*;">
	<col style="width:*;">
	<col style="width:*;">
	<col style="width:*;">
</colgroup>
<tbody>
	<tr>
		<th style="text-align:center;">예약번호</th>
		<th style="text-align:center;">이름(연락처)</th>
		<th style="text-align:center;">금액</th>
		<th style="text-align:center;">건수</th>
	</tr>
<?
$i = 0;
$x = 0;
$PreMainNumber = "";
$TotalPrice = 0;
$reslist = '';
while ($row = mysqli_fetch_assoc($result_setlist)){
	$now = date("Y-m-d");
	$MainNumber = $row['MainNumber'];

	if($MainNumber != $PreMainNumber && $x > 0){
		?>
	<tr name="btnTrList">
		<td style="text-align:center;"><?=$PreMainNumber?></td>
		<td style="text-align:center;"><?=$userName?>(<a href="tel:<?=$userPhone?>" style="cursor:text;"><?=$userPhone?></a>)</td>
		<td style="text-align:center;"><?=number_format($TotalPrice).'원'?></td>
		<td style="text-align:center;cursor:pointer;" onclick="fnListView(this);"><b><?=($i + 1)?>건</b></td>
	</tr>
	<tr style="display:none;">
		<td colspan="4">

    <table class="et_vars exForm bd_tb" style="width:100%">
		<colgroup>
			<col style="width:80px;">
			<col style="width:*;">
			<col style="width:80px;">
		</colgroup>
        <tbody>
		<?=$reslist?>
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
		
		</td>
	</tr>
<?
	}

	if($MainNumber == $PreMainNumber){
		$i++;
	}else{
		$i = 0;
		$TotalPrice = 0;
		$reslist = '';
	}

	$x++;
	$PreMainNumber = $row['MainNumber'];
	$etc = $row['Etc'];
	$memo = $row['memo'];
	$userName = $row['userName'];
	$userPhone = $row['userPhone'];

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


$reslist .= '
			<tr class="'.$ResCss.'" name="btnTr">
                <td colspan="2">
					<input type="hidden" id="MainNumber" name="MainNumber" value="'.$MainNumber.'">
					<label>';
					if($row['ResConfirm'] == 2 || $row['ResConfirm'] == 3 || $row['ResConfirm'] == 4){
						$reslist .= '<input type="checkbox" id="chkCancel" name="chkCancel[]" value="'.$row['subintseq'].'" style="vertical-align:-3px;" /><br>';
					}
$reslist .= '	<strong>';
			if($row['ResGubun'] == 2){
               $reslist .= $row["ResDay"].' <span style="padding-left:0px;"> '.$TimeDate.'</span>';
			}else{
               $reslist .= '['.$row['codename'].'] '.$row['ResOptName'].' <span style="padding-left:0px;">'.$TimeDate.'</span>';
			}
$reslist .= '
					</strong>
					</label>
				</td>
                <td style="text-align:center;">
					'.$ResNum.'
				</td>
            </tr>';
}
?>

	<tr name="btnTrList">
		<td style="text-align:center;"><?=$PreMainNumber?></td>
		<td style="text-align:center;"><?=$userName?>(<a href="tel:<?=$userPhone?>" style="cursor:text;"><?=$userPhone?></a>)</td>
		<td style="text-align:center;"><?=number_format($TotalPrice).'원'?></td>
		<td style="text-align:center;cursor:pointer;" onclick="fnListView(this);"><b><?=($i + 1)?>건</b></td>
	</tr>
	<tr style="display:none;">
		<td colspan="4">

    <table class="et_vars exForm bd_tb" style="width:100%">
		<colgroup>
			<col style="width:80px;">
			<col style="width:*;">
			<col style="width:80px;">
		</colgroup>
        <tbody>
		<?=$reslist?>
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
		
		</td>
	</tr>
</tbody>
</table>

<span id="hidInitParam" style="display:none;">
	<input type="hidden" id="sDate1" name="sDate1" size="10" value="<?=$selDate?>" class="itx">
</span>