<?php
include __DIR__.'/../db.php';

session_start();

$Year = ($_REQUEST["selY"] == "") ? date("Y") : $_REQUEST["selY"];
$Mon = ($_REQUEST["selM"] == "") ? (date("m") - 1) : $_REQUEST["selM"];
?>

<form name="frmCal" id="frmCal" autocomplete="off">
	<div class="gg_first" style="margin-top:0px;">날짜검색</div>
	<table class='et_vars exForm bd_tb' style="width:100%">
		<colgroup>
			<col style="width:65px;">
			<col style="width:*;">
			<col style="width:100px;">
		</colgroup>
		
		<tr>
			<th>검색날짜</th>
			<td align="center">
				<select id="selY" name="selY" class="select">
				<?for($r=2019;$r<=date("Y");$r++){?>
					<option value="<?=$r?>" <?echo (($Year == $r) ? "selected='selected'" : "")?>><?=$r?></option>
				<?}?>
				</select>년&nbsp;
				<select id="selM" name="selM" class="select">
					<?for($r=1;$r<=12;$r++){?>
					<option value="<?=$r?>" <?echo (($Mon == $r) ? "selected='selected'" : "")?>><?=$r?></option>
				<?}?>
				</select>월
			</td>
			<td style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:60px; height:23px;" value="조회" onclick="fnCalSearch();" /></td>
		</tr>
	</table>
</form>

<?
$select_query = 'SELECT opt_bbq, shopcharge FROM `SURF_SHOP` WHERE intseq = '.$_SESSION['shopseq'];
$result_shop = mysqli_query($conn, $select_query);
$rowshop = mysqli_fetch_array($result_shop);

$opt_bbq = $rowshop["opt_bbq"]; //서프엔조이 바베큐 여부
$shopcharge = ($rowshop["shopcharge"] / 100); //수수료

$bbqSql = "";
if($opt_bbq == "Y"){
	$bbqSql = "AND a.ResGubun != 4";
}

$select_query = 'SELECT COUNT(*) AS Cnt, ResDate, DAY(ResDate) AS sDay, a.ResConfirm, SUM(ResPrice) AS price, SUM(RtnPrice) AS RtnPrice, d.opt_bbq FROM `SURF_SHOP_RES_SUB` as a INNER JOIN `SURF_SHOP_RES_MAIN` as b
					ON a.MainNumber = b.MainNumber
			INNER JOIN SURF_SHOP as d
				ON b.shopSeq = d.intseq
						WHERE a.DelUse = "N"
							'.$bbqSql.'
							AND b.shopSeq = '.$_SESSION['shopseq'].'
							AND a.ResConfirm IN (5, 6, 7)
							AND (Year(ResDate) = '.$Year.' AND Month(ResDate) = '.$Mon.')
						GROUP BY a.ResDate, a.ResConfirm, d.opt_bbq';
$result_setlist = mysqli_query($conn, $select_query);

$count = mysqli_num_rows($result_setlist);
?>

<div class="gg_first" style="padding-bottom:7px;">[<?=$_SESSION['shopname']?>] - <?=$Year.'년 '.$Mon.'월'?> 정산</div>

<table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
<colgroup>
	<col style="width:100px;">
	<col style="width:*;">
	<col style="width:*;">
	<col style="width:*;">
	<col style="width:*;">
</colgroup>
<tbody>

<?
if($count == 0){
	echo '<tr><td><div style="text-align:center;font-size:14px;padding:50px;">
				<b>정산내역이 없습니다.</b>
			</div></td></tr>';
}else{
?>
	<tr>
		<th style="text-align:center;" rowspan="2">날짜</th>
		<th style="text-align:center;" colspan="3">구분</th>
		<th style="text-align:center;" rowspan="2">정산금액</th>
	</tr>
	<tr>
		<th style="text-align:center;">확정</th>
		<th style="text-align:center;">수수료</th>
		<th style="text-align:center;">환불</th>
	</tr>
<?
	$TotalPrice = 0;
	$TotalCalPrice = 0;
	$TotalRtnPrice = 0;

	$arrShopDate = array();
	$arrShopPrice1 = array(); //확정 금액
	$arrShopPrice2 = array(); //수수료 금액
	$arrShopPrice3 = array(); //환불 금액
	$arrShopPrice4 = array(); //정산금액
	while ($row = mysqli_fetch_assoc($result_setlist)){
		if(array_key_exists($row['ResDate'], $arrShopPrice1)){
		}else{
			$arrShopDate[$row['ResDate']] = $row['ResDate'];
			$arrShopPrice1[$row['ResDate']] = 0;
			$arrShopPrice2[$row['ResDate']] = 0;
			$arrShopPrice3[$row['ResDate']] = 0;
			$arrShopPrice4[$row['ResDate']] = 0;
		}

		if($row['ResConfirm'] == 5){
			$ResConfirm = "<font color='blue'><b>확정<b/></font>";

			$arrShopPrice1[$row['ResDate']] += $row["price"];
			$arrShopPrice2[$row['ResDate']] += ($row["price"] * $shopcharge);
		}else if($row['ResConfirm'] == 6 || $row['ResConfirm'] == 7){
			$ResConfirm = "<font color='red'>환불</font>";
			$arrShopPrice3[$row['ResDate']] += $row["price"];
		}
	}

foreach($arrShopDate as $x => $x_value) {
	$TotalPrice += $arrShopPrice1[$x];
	$TotalCalPrice += $arrShopPrice2[$x];
	$TotalRtnPrice += $arrShopPrice3[$x];
?>
	<tr>
		<td style="text-align:center;"><?=$arrShopDate[$x]?></td>
		<td style="text-align:center;"><?=number_format($arrShopPrice1[$x])?>원</td>
		<td style="text-align:center;"><font color='blue'><?=number_format($arrShopPrice2[$x])?>원</font></td>
		<td style="text-align:center;"><font color='cc6600'><?=number_format($arrShopPrice3[$x])?>원</font></td>
		<td style="text-align:center;"><font color='red'><b><?=number_format($arrShopPrice2[$x] + $arrShopPrice3[$x])?>원</b></td>
	</tr>
<?
	}
}
?>
</tbody>
</table>

<div class="gg_first" style="padding-bottom:7px;">총 합계안내 - [정산여부 : 미정산]</div>

<table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
<colgroup>
	<col style="width:25%;">
	<col style="width:25%;">
	<col style="width:25%;">
	<col style="width:25%;">
</colgroup>
<tbody>
	<tr>
		<th style="text-align:center;">확정</th>
		<th style="text-align:center;">수수료(A)</th>
		<th style="text-align:center;">환불(B)</th>
		<th style="text-align:center;">정산금액(A + B)</th>
	</tr>
	<tr>
		<td style="text-align:center;"><?=number_format($TotalPrice)?>원</td>
		<td style="text-align:center;"><font color='blue'><?=number_format($TotalCalPrice)?>원</font></td>
		<td style="text-align:center;"><font color='cc6600'><?=number_format($TotalRtnPrice)?>원</font></td>
		<td style="text-align:center;"><font color='red'><b><?=number_format($TotalCalPrice + $TotalRtnPrice)?>원</b></font></td>
	</tr>
</tbody>
</table>
