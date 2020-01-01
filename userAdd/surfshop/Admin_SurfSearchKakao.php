<?php
include 'menu_top.php';

include __DIR__.'/../surfencrypt.php';

function plusDate($date, $count) {
	$arrdate = explode("-",$date);
	$datDate = date("Y-m-d", mktime(0, 0, 0, $arrdate[1], $arrdate[2], $arrdate[0]));
	$NextDate = date("Y-m-d", strtotime($datDate." +".$count." day"));

	return $NextDate;
}

//$schText = urldecode($_REQUEST["MainNumber"]);
$schText = $_REQUEST["MainNumber"];
$arrChk = explode("|", decrypt($schText));

//$schText = urldecode($_REQUEST["MainNumber"]);
//$arrChk = explode("|", $schText);

$dateChk = $arrChk[0];
$MainNumberChk = trim($arrChk[1]);
$shopseq = trim($arrChk[2]);

if(plusDate($dateChk, 2) <= date("Y-m-d")){
	//echo '<div style="text-align:center;font-size:14px;padding:50px 0px 50px 0px;">
	//			<b>빠른예약 조회 기간이 종료되었습니다.<br><br>로그인 후 [서프샵-예약관리] 메뉴를 이용해주세요.</b>
	//		</div>';
	//return;
}


$select_query = 'SELECT opt_bbq, shopname FROM `SURF_SHOP` WHERE intseq = '.$shopseq;
$result_shop = mysqli_query($conn, $select_query);
$rowshop = mysqli_fetch_array($result_shop);

$opt_bbq = $rowshop["opt_bbq"]; //서프엔조이 바베큐 여부
$shopname = $rowshop["shopname"];

$bbqSql = "";
if($opt_bbq == "Y"){
	$bbqSql = "AND b.ResGubun != 4";
}

$select_query = 'SELECT a.userName, a.userPhone, a.Etc, a.memo, b.*, c.codename FROM `SURF_SHOP_RES_MAIN` as a INNER JOIN `SURF_SHOP_RES_SUB` as b 
					ON a.MainNumber = b.MainNumber 
				INNER JOIN SURF_CODE as c
					ON cast(b.ResGubun as char(1)) = c.code
					WHERE shopSeq = '.$shopseq.'
						'.$bbqSql.'
						AND b.MainNumber = '.$MainNumberChk.'
						ORDER BY b.MainNumber, b.ResDate, b.subintseq';

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count == 0){
	echo '<div style="text-align:center;font-size:14px;padding:50px;">
				<b>예약된 정보가 없습니다.</b>
			</div>';
	return;
}
?>
<link rel="stylesheet" type="text/css" href="Admin_surf.css?v=1" />
<script src="Admin_surf.js?v=1"></script>

<div class="container" id="contenttop">
	<!-- #container -->
    <div class="tab_container">
    

<form name="frmConfirm" id="frmConfirm" autocomplete="off">
    <div class="gg_first">서핑샵 예약정보 - <?=$shopname?><span style="font-size:11px;"></span></div>
<?
$i = 0;
$x = 0;
$PreMainNumber = "";
$TotalPrice = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){
	$now = date("Y-m-d");
	$MainNumber = $row['MainNumber'];

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
            <tr>
                <th>사유 및<br>메모</th>
                <td colspan="3">
					<textarea id="memo" name="memo" rows="3" style="width: 90%; resize:none;"><?=$memo?></textarea>
				</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:center;font-size:14px;padding:4px;">
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:90px; height:25px;" value="상태변경하기" onclick="fnConfirmUpdate2(1, this);" />
				</td>
            </tr>
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
	$etc = $row['Etc'];
	$memo = $row['memo'];

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
			<col style="width:85px;">
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
		$ResCss = "rescss";
	}

	if ($datDate < date("Y-m-d", strtotime($now." 0 day")))
	{
		$ResCss = "predate";
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
                <td style="text-align:center;" rowspan="2">
					<input type="hidden" id="MainNumber" name="MainNumber" value="<?=$MainNumber?>">
					<label>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="<?=$row['subintseq']?>" style="vertical-align:-3px;display:none;" />
					<?=$row['ResDate']?>
					</label>
				</td>
				<td colspan="2">
			<?if($row['ResGubun'] == 2){?>
                <?=$row['ResDay']?> <span style="padding-left:0px;"><br><?=$TimeDate?></span>
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
				<?if(!($row['ResConfirm'] == 1 || $row['ResConfirm'] == 6 || $row['ResConfirm'] == 7)){?>
					<select id="selConfirm" name="selConfirm[]" class="select" style="padding:1px 2px 4px 2px;" onchange="fnChangeModify(this, <?=$row['ResConfirm']?>);">
						<option value="0" <?if($row['ResConfirm'] == 0) echo "selected"?>>미입금</option>
						<option value="2" <?if($row['ResConfirm'] == 2) echo "selected"?>>입금완료</option>
						<option value="4" <?if($row['ResConfirm'] == 4) echo "selected"?>>임시취소</option>
						<option value="5" <?if($row['ResConfirm'] == 5) echo "selected"?>>확정</option>
					</select>
				<?}?>
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
            <tr>
                <th>사유 및<br>메모</th>
                <td colspan="3">
					<textarea id="memo" name="memo" rows="3" style="width: 90%; resize:none;"><?=$memo?></textarea>
				</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:center;font-size:14px;padding:4px;">
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:90px; height:25px;" value="상태변경하기" onclick="fnConfirmUpdate2(1, this);" />
				</td>
            </tr>
		</tbody>
	</table>

	<span id="hidInitParam" style="display:none;">
		<input type="hidden" id="resparam" name="resparam" size="10" value="changeConfirm" class="itx">
		<input type="hidden" id="userid" name="userid" size="10" value="kakao" class="itx">
	</span>
</form>
<form name="frmConfirmSel" id="frmConfirmSel" style="display:none;"></form>

	</div>
<!-- #container -->
</div>

<input type="hidden" id="hidselDate" value="">
<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:400px;display:none;"></iframe>