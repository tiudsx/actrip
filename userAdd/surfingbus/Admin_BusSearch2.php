<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$chkResConfirm = $_REQUEST["chkResConfirm"];
$busNum = $_REQUEST["busNum"];
$sbusDate = $_REQUEST["sDate"];
$ebusDate = $_REQUEST["eDate"];
$schText = trim($_REQUEST["schText"]);

$inResConfirm = "";
for($i = 0; $i < count($chkResConfirm); $i++){
	$inResConfirm .= $chkResConfirm[$i].',';
}
$inResConfirm .= '99';

$busDate = "";
$bbqDate = "";
if($sbusDate == "" && $ebusDate == ""){
}else{
	if($sbusDate != "" && $ebusDate != ""){
		$busDate = ' AND (busDate BETWEEN CAST("'.$sbusDate.'" AS DATE) AND CAST("'.$ebusDate.'" AS DATE))';
		$bbqDate = ' AND (ResBBQDate BETWEEN CAST("'.$sbusDate.'" AS DATE) AND CAST("'.$ebusDate.'" AS DATE))';
	}else if($sbusDate != ""){
		$busDate = ' AND busDate >= CAST("'.$sbusDate.'" AS DATE)';
		$bbqDate = ' AND ResBBQDate >= CAST("'.$sbusDate.'" AS DATE)';
	}else if($ebusDate != ""){
		$busDate = ' AND busDate <= CAST("'.$ebusDate.'" AS DATE)';
		$bbqDate = ' AND ResBBQDate <= CAST("'.$ebusDate.'" AS DATE)';
	}
}

$schSel = '';
$schText = '';
if($_REQUEST["busNum"] != "ALL"){
	$schSel = 'busNum = "'.$_REQUEST["busNum"].'" AND ';
}

if($_REQUEST["schText"] != ""){
	$schText1 = '(MainNumber like "%'.$_REQUEST["schText"].'%") AND ';
	$schText2 = ' WHERE (MainNumber like "%'.$_REQUEST["schText"].'%" OR userName like "%'.$_REQUEST["schText"].'%" OR userPhone like "%'.$_REQUEST["schText"].'%")';
}


/*
$select_query = 'SELECT a.*, b.ResBBQDate, b.ResBBQPrice, b.ResBBQ, b.ResBBQConfirm, b.intseq as bbqseq FROM `SURF_BUS_MAIN` a LEFT JOIN `SURF_BBQ` as b 
	ON a.MainNumber = b.MainNumber 
		AND b.ResBBQConfirm IN ('.$inResConfirm.')
		'.$schText2.'
	where (a.MainNumber IN (SELECT MainNumber FROM SURF_BUS_SUB where '.$schSel.$schText1.' ResConfirm IN ('.$inResConfirm.')'.$busDate.') OR a.MainNumber IN (SELECT MainNumber FROM `SURF_BBQ` where ResBBQConfirm IN ('.$inResConfirm.')'.$bbqDate.'))';
*/
$select_query = 'SELECT * FROM `SURF_BUS_MAIN`'.$schText2;

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
while ($row = mysqli_fetch_assoc($result_setlist)){
	$now = date("Y-m-d");

	$select_query_sub = 'SELECT * FROM `SURF_BUS_SUB` where '.$schSel.' MainNumber = '.$row['MainNumber'].' AND ResConfirm IN ('.$inResConfirm.')'.$busDate.' ORDER BY busDate, busSeat';
	//echo $select_query_sub;
	$resultSite = mysqli_query($conn, $select_query_sub);
	$count_sub = mysqli_num_rows($resultSite);

	$select_query_bbq = 'SELECT * FROM `SURF_BBQ` where MainNumber = '.$row['MainNumber'].' AND ResBBQConfirm IN ('.$inResConfirm.')'.$bbqDate;
	$resultBbq = mysqli_query($conn, $select_query_bbq);
	$count_bbq = mysqli_num_rows($resultBbq);
	$rowBbq = mysqli_fetch_array($resultBbq);

	if($_REQUEST["busNum"] == "ALL"){
		if($count_sub == 0 && $count_bbq == 0){
			continue;
		}
	}else{
		if($count_sub == 0){
			continue;
		}
	}

	$busSeatInfo = "";
	$arrSeatInfo = array();
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
			<col style="width:100px;">
			<col style="width:120px;">
			<col style="width:*;">
			<col style="width:*;">
		</colgroup>
        <tbody>
<?
	$RtnTotalPrice = 0;
	while ($rowSub = mysqli_fetch_assoc($resultSite)){
		$ResColor = "";
		$ResCss = "";
		$datDate = substr($rowSub['busDate'], 0, 10);

		$RtnBankRow = 'rowspan="2"';
		if($rowSub['ResConfirm'] == 0){
			$ResConfirm = "미입금";
		}else if($rowSub['ResConfirm'] == 1){
			$ResConfirm = "확정";
			$ResColor = "rescolor1";
		}else if($rowSub['ResConfirm'] == 2){
			$ResConfirm = "환불요청";
			$ResColor = "rescolor2";
		}else if($rowSub['ResConfirm'] == 3){
			$ResConfirm = "취소완료";
			$ResCss = "rescss";
			$RtnBankRow = 'rowspan="1"';
		}

		if ($datDate < date("Y-m-d", strtotime($now." 0 day")))
		{
			$ResCss = "resper";
		}
		
		$cancelPrice = cancelPrice($rowSub['busDate'], $rowSub['insdate'], $rowSub['ResPrice'], 2);
		$rtnPrice = $rowSub['ResPrice'] - $cancelPrice;

		$RtnPrice = '';
		$RtnBank = '';
		if($rowSub['RtnPrice'] > 0){
			$RtnPrice = '<br>('.number_format($rowSub['RtnPrice']).'원)';

			if($rowSub['ResConfirm'] == 2){
				$RtnBank = '<tr class="'.$ResCss.'" name="btnTrPoint">
								<td style="text-align:center;" colspan="2">'.str_replace('|', '&nbsp ', $rowSub['RtnBank']).'</td>
							</tr>';
				$RtnTotalPrice += $rowSub['RtnPrice'];
			}
		}
?>
			<tr class="<?=$ResCss?>" name="btnTr">
                <td style="text-align:center;" <?=$RtnBankRow?>>
					<label>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="bus|<?=$rowSub['subintseq']?>|<?=$rowSub['MainNumber']?>" style="vertical-align:-3px;" />
					<?=$rowSub['busDate']?>
					</label>
				</td>
                <td style="text-align:center;"><?=fnBusNum($rowSub['busNum'])?> <?=$rowSub['busSeat']?>번</td>
                <td style="text-align:center;">
					<strong class="<?=$ResColor?>"><?=$ResConfirm?></strong>
					<?=$RtnPrice?>
				</td>
				<td style="text-align:center;" <?=$RtnBankRow?>>
					<input type="button" value="수정" class="bd_btn" style="font-family: gulim,Tahoma,Arial,Sans-serif;height:20px;padding:4px 10px 4px 10px" onclick="fnModifyInfo('<?=$rowSub['subintseq']?>', 'bus', this);">
				</td>
            </tr>
			<?if($rowSub['ResConfirm'] == 0 || $rowSub['ResConfirm'] == 1){?>
			<tr class="<?=$ResCss?>" name="btnTrPoint">
				<td style="text-align:center;" colspan="2"><?=$rowSub["sLocation"]?> -> <?=$rowSub["eLocation"]?></td>
			</tr>
			<?}?>
			<?=$RtnBank?>
<?
	}
?>

		<?
		if($rowBbq['ResBBQ'] > 0){
			$ResColor = "";
			$ResCss = "";
			$datDate = substr($rowBbq['ResBBQDate'], 0, 10);

			if($rowBbq['ResBBQConfirm'] == 0){
				$ResConfirm = "미입금";
			}else if($rowBbq['ResBBQConfirm'] == 1){
				$ResConfirm = "확정";
				$ResColor = "rescolor1";
			}else if($rowBbq['ResBBQConfirm'] == 2){
				$ResConfirm = "환불요청";
				$ResColor = "rescolor2";
			}else if($rowBbq['ResBBQConfirm'] == 3){
				$ResConfirm = "취소완료";
				$ResCss = "rescss";
			}

			if ($datDate < $now)
			{
				$ResCss = "resper";
			}

			$cancelPrice = cancelPrice($rowBbq['ResBBQDate'], $rowBbq['insdate'], $rowBbq['ResBBQPrice'], 2);

			$RtnPrice = '';
			$RtnBank = '';
			$RtnBankRow = '';
			if($rowBbq['RtnPrice'] > 0){
				$RtnPrice = '<br>('.number_format($rowBbq['RtnPrice']).'원)';
				if($rowBbq['ResBBQConfirm'] == 2){
					$RtnBank = '<tr class="<?=$ResCss?>">
									<td style="text-align:center;" colspan="3">'.str_replace('|', '&nbsp ', $rowBbq['RtnBank']).'</td>
								</tr>';
					$RtnBankRow = 'rowspan="2"';
					$RtnTotalPrice += $rowBbq['RtnPrice'];
				}
			}
		?>
			<tr class="<?=$ResCss?>" name="btnTr">
                <td style="text-align:center;" <?=$RtnBankRow?>>
					<label>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="bbq|<?=$rowBbq['intseq']?>|<?=$rowBbq['MainNumber']?>" style="vertical-align:-3px;" />
					<?=$rowBbq['ResBBQDate']?>	
					</label>
				</td>
                <td style="text-align:center;">바베큐 <?=$rowBbq['ResBBQ']?> 명</td>
                <td style="text-align:center;"><strong class="<?=$ResColor?>"><?=$ResConfirm?></strong><?=$RtnPrice?></td>
				<td style="text-align:center;">
					<input type="button" value="수정" class="bd_btn" style="font-family: gulim,Tahoma,Arial,Sans-serif;height:20px;padding:4px 10px 4px 10px" onclick="fnModifyInfo('<?=$rowBbq['intseq']?>', 'bbq', this);">
				</td>
            </tr>
			<?=$RtnBank?>
		<?}
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
<?if($row['Etc'] == ""){?>
            <tr>
                <td colspan="4" style="height:2px;padding:0px;background-color:#efefef;"></td>
            </tr>
<?}else{?>
            <tr>
                <th>특이사항</th>
                <td colspan="3"><textarea id="etc" name="etc" rows="3" style="width: 90%; resize:none;" disabled="disabled"><?=$row['Etc']?></textarea></td>
            </tr>
<?}?>
            <tr>
                <td colspan="4" style="text-align:center;font-size:14px;padding:4px;">
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:80px; height:25px;color: #fff !important; background: #008000;" value="확정처리" onclick="fnConfirmUpdate(1, this);" />&nbsp;
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:80px; height:25px;" value="취소처리" onclick="fnConfirmUpdate(3, this);" />
				</td>
            </tr>
		</tbody>
	</table>
<?
}
?>
	<span id="hidInitParam" style="display:none;">
		<input type="hidden" id="resparam" name="resparam" size="10" value="changeConfirm" class="itx">
		<input type="hidden" id="userid" name="userid" size="10" value="" class="itx">
		<input type="hidden" id="changeConfirm" name="changeConfirm" size="10" value="1" class="itx">
	</span>
</form>

<form name="frmConfirmSel" id="frmConfirmSel" style="display:none;">

</form>