<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$chkResConfirm = $_REQUEST["chkResConfirm"];
$chkResType = $_REQUEST["chkResType"];
$shopSeq = $_REQUEST["shopSeq"];
$sDate = $_REQUEST["sDate"];
$eDate = $_REQUEST["eDate"];
$schText = trim($_REQUEST["schText"]);

$shoplist1 = $_REQUEST["shoplist1"];
$shoplist2 = $_REQUEST["shoplist2"];
$shoplist3 = $_REQUEST["shoplist3"];

$inResConfirm = "";
for($i = 0; $i < count($chkResConfirm); $i++){
	$inResConfirm .= $chkResConfirm[$i].',';
}
$inResConfirm .= '99';


$inResType = "";
for($i = 0; $i < count($chkResType); $i++){
	$inResType .= $chkResType[$i].',';
}
$inResType .= '99';

$ResDate = "";
if($sDate == "" && $eDate == ""){
}else{
	if($sDate != "" && $eDate != ""){
		$ResDate = ' AND (ResDate BETWEEN CAST("'.$sDate.'" AS DATE) AND CAST("'.$eDate.'" AS DATE))';
	}else if($sDate != ""){
		$ResDate = ' AND ResDate >= CAST("'.$sDate.'" AS DATE)';
	}else if($eDate != ""){
		$ResDate = ' AND ResDate <= CAST("'.$eDate.'" AS DATE)';
	}
}

$shopcate = "";
$shopJoin = "";
if($shoplist1 != "ALL"){
	$shopcate .= " AND f.gubun = '".$shoplist1."'";
}
if($shoplist2 != "ALL"){
	$shopcate .= " AND f.code = '".$shoplist2."'";
}
if($shoplist3 != "ALL"){
	$shopcate .= " AND a.shopSeq = '".$shoplist3."'";
}

if($shopcate != ""){
	$shopJoin = "LEFT JOIN (SELECT d.intseq, e.gubun, e.code FROM SURF_SHOP as d INNER JOIN SURF_CODE as e ON d.cate_3 = e.seq) as f ON a.shopSeq = f.intseq";
}

if($schText != ""){
	$schText = ' AND (a.MainNumber like "%'.$schText.'%" OR a.userName like "%'.$schText.'%" OR a.userPhone like "%'.$schText.'%")';
}

$select_query = 'SELECT a.userName, a.userPhone, a.Etc, a.memo, a.shopSeq, a.Gubun, a.shopCode, b.*, c.codename FROM `SURF_SHOP_RES_MAIN` as a INNER JOIN `SURF_SHOP_RES_SUB` as b 
					ON a.MainNumber = b.MainNumber 
				LEFT JOIN SURF_CODE as c
					ON cast(b.ResGubun as char(1)) = c.code	
					'.$shopJoin.'
					WHERE b.MainNumber IN (SELECT DISTINCT MainNumber FROM `SURF_SHOP_RES_SUB` WHERE ResConfirm IN ('.$inResConfirm.') AND ResGubun IN ('.$inResType.')'.$ResDate.')
						'.$schText.$shopcate.'
						ORDER BY b.MainNumber, b.ResDate, b.subintseq';

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
    <div class="gg_first">서핑샵 예약정보 <span style="font-size:11px;"></span></div>
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
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:90px; height:25px;" value="상태변경하기" onclick="fnConfirmUpdate(1, this);" />
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
	$shopSeq = $row['shopSeq'];
	$Gubun = $row['Gubun'];

	$etc = $row['Etc'];
	$memo = $row['memo'];
	$shopCode = $row['shopCode'];

	if($i == 0){
?>

	<div style="margin-bottom:5px;width:100%;padding-top:11px;font-size:12px;">
		<span>[<?=$row['shopCode']?>] - <strong><?=$row['MainNumber']?></strong> (<?=$row['insdate']?>)</span>
	</div>
    <table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
		<colgroup>
			<col style="width:100px;">
			<col style="width:*;">
			<col style="width:*;">
			<col style="width:*;">
		</colgroup>
        <tbody>
			<tr>
                <th>예약자</th>
                <td><?=$row['userName']?><span style="display:;">  <a href="tel:<?=$row['userPhone']?>">(<?=$row['userPhone']?>)</a></span></td>
				<th></th>
                <td><!--b><?=number_format($row['ResTotalPrice'])?> 원</b--></td>
            </tr>
			<tr>
				<td colspan="4">

    <table class="et_vars exForm bd_tb" style="width:100%">
		<colgroup>
			<col style="width:80px;">
			<col style="width:*;">
			<col style="width:*;">
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
3	임시확정/예약중
4	임시취소/예약불가
5	확정
6	환불요청
7	환불완료
*/
	$ResColor = "";
	$ResCss = "";
	$datDate = substr($row['ResDate'], 0, 10);

	if($row['ResConfirm'] == 0){
		$ResConfirm = "미입금";
	}else if($row['ResConfirm'] == 1){
		$ResConfirm = "취소";
	}else if($row['ResConfirm'] == 2){
		$ResConfirm = "입금완료";
	}else if($row['ResConfirm'] == 3){
		$ResConfirm = "임시확정";
		$ResColor = "rescolor2";
	}else if($row['ResConfirm'] == 4){
		$ResConfirm = "임시취소";
		$ResColor = "rescolor2";
	}else if($row['ResConfirm'] == 5){
		$ResConfirm = "확정";
	}else if($row['ResConfirm'] == 6){
		$ResConfirm = "환불요청";
		$ResColor = "rescolor1";
	}else if($row['ResConfirm'] == 7){
		$ResConfirm = "환불완료";
		$ResColor = "rescolor1";
		$ResCss = "rescss";
	}

	if ($datDate < date("Y-m-d", strtotime($now." 0 day")))
	{
		$ResCss = "predate";
	}
	
	$RtnPrice = '';
	$RtnBank = '';
	if($row['ResConfirm'] == 6 || $row['ResConfirm'] == 7){
		$RtnPrice = ''.number_format($row['RtnSumPrice']).'원';
		$RtnBank = '<tr class="'.$ResCss.'" name="btnTrPoint">
						<td style="text-align:center;" colspan="2">'.str_replace('|', '&nbsp ', $row['RtnBank']).'</td>
						<td style="text-align:center;" colspan="2"> 환불액 : '.$RtnPrice.'</td>
					</tr>';
	}

	if($row['ResConfirm'] == 6){
		$RtnTotalPrice += $row['RtnSumPrice'];
	}

	if($row['ResConfirm'] == 0 || $row['ResConfirm'] == 5){
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
                <td style="text-align:center;" rowspan="2">
					<input type="hidden" id="MainNumber" name="MainNumber" value="<?=$MainNumber?>">
					<input type="hidden" id="shopSeq" name="shopSeq" value="<?=$shopSeq?>">
					<input type="hidden" id="Gubun" name="Gubun" value="<?=$Gubun?>">
					<label>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="<?=$row['subintseq']?>" style="vertical-align:-3px;" /><br>
					<?=$row['ResDate']?>
					</label>
				</td>
				<td colspan="2">
			<?if($row['ResGubun'] == 2){?>
                <?=$row['ResDay']?> <span style="padding-left:0px;"> <?=$TimeDate?></span>
			<?}else{?>
               [<?=$row['codename']?>] <?=$row['ResOptName']?> <span style="padding-left:0px;"><?=$TimeDate?></span>
			<?}?>
				/ <?=$ResNum?></td>
			</tr>
			<tr class="<?=$ResCss?>" name="btnTr">
                <td style="text-align:center;">
					<strong class="<?=$ResColor?>"><?=$ResConfirm?></strong>
				</td>
				<td style="text-align:center;">
					<select id="selConfirm" name="selConfirm[]" class="select" style="padding:1px 2px 4px 2px;" onchange="fnChangeModify(this, <?=$row['ResConfirm']?>);">
						<option value="0" <?if($row['ResConfirm'] == 0) echo "selected"?>>미입금</option>
						<option value="2" <?if($row['ResConfirm'] == 2) echo "selected"?>>입금완료</option>
						<!--option value="3" <?if($row['ResConfirm'] == 3) echo "selected"?>>임시확정</option-->
						<option value="4" <?if($row['ResConfirm'] == 4) echo "selected"?>>임시취소</option>
						<option value="5" <?if($row['ResConfirm'] == 5) echo "selected"?>>확정</option>
						<option value="1" <?if($row['ResConfirm'] == 1) echo "selected"?>>취소</option>
						<option value="6" <?if($row['ResConfirm'] == 6) echo "selected"?>>환불요청</option>
						<option value="7" <?if($row['ResConfirm'] == 7) echo "selected"?>>환불완료</option>
					</select>
				</td>
				<!--td style="text-align:center;">
					<input type="button" value="수정" class="bd_btn" style="font-family: gulim,Tahoma,Arial,Sans-serif;height:20px;padding:3px 8px 4px 8px" onclick="fnModifyInfo('<?=$row['subintseq']?>', 'bus', this);">
				</td-->
            </tr>
			<?=$RtnBank?>
<?
}

	if($RtnTotalPrice > 0){
?>
			<tr>
                <th style="text-align:center;" colspan="2">총 환불액</th>
                <td style="text-align:left;padding-left:10px;" colspan="2"><b><?=number_format($RtnTotalPrice).'원'?></b></td>
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
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:90px; height:25px;" value="상태변경하기" onclick="fnConfirmUpdate(1, this);" />
				</td>
            </tr>
		</tbody>
	</table>

	<span id="hidInitParam" style="display:none;">
		<input type="hidden" id="resparam" name="resparam" size="10" value="changeConfirm" class="itx">
		<input type="hidden" id="userid" name="userid" size="10" value="" class="itx">
	</span>
</form>
<form name="frmConfirmSel" id="frmConfirmSel" style="display:none;">

</form>