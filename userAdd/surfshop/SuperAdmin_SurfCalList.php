<?php
include __DIR__.'/../db.php';

session_start();

$Year = ($_REQUEST["selY"] == "") ? date("Y") : $_REQUEST["selY"];
$Mon = ($_REQUEST["selM"] == "") ? (date("m") - 0) : $_REQUEST["selM"];

$shoplist1 = $_REQUEST["shoplistcal1"];
$shoplist2 = $_REQUEST["shoplistcal2"];
$shoplist3 = $_REQUEST["shoplistcal3"];
?>

<script>
function fnCalSearch(){
	var formData = $j("#frmCal").serializeArray();

	$j.post(folderBusRoot + "/SuperAdmin_SurfCalList.php", formData,
		function(data, textStatus, jqXHR){
		   $j("#divCalList").html(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}
</script>

<form name="frmCal" id="frmCal" autocomplete="off">
	<div class="gg_first" style="margin-top:0px;">날짜검색</div>
	<table class='et_vars exForm bd_tb' style="width:100%">
		<colgroup>
			<col style="width:65px;">
			<col style="width:*;">
		</colgroup>
		<tr>
			<th>샵 목록</th>
			<td>
				<select id="shoplistcal1" name="shoplistcal1" class="select" style="padding:1px 2px 4px 2px;" onchange="cateList(this, 'shoplistcal');">
					<option value="ALL">== 전체 ==</option>
					<option value="surfeast">동해-양양</option>
					<option value="surfeast2">동해-고성</option>
					<option value="surfeast3">동해-강릉</option>
					<option value="surfjeju">제주</option>
					<option value="surfsouth">남해</option>
					<option value="surfwest">서해</option>
					<option value="etc">기타</option>
				</select>
				<select id="shoplistcal2" name="shoplistcal2" class="select" style="padding:1px 2px 4px 2px;" onchange="cateList2(this, 'shoplistcal');">
					<option value="ALL">== 전체 ==</option>
				</select>
				<select id="shoplistcal3" name="shoplistcal3" class="select" style="padding:1px 2px 4px 2px;">
					<option value="ALL">== 전체 ==</option>
					<?=$shoplist?>
				</select>
			</td>
		</tr>
		<tr>
			<th>검색날짜</th>
			<td align="center">
				<select id="selY" name="selY" class="select">
				<?for($r=2017;$r<=date("Y");$r++){?>
					<option value="<?=$r?>" <?echo (($Year == $r) ? "selected='selected'" : "")?>><?=$r?></option>
				<?}?>
				</select>년&nbsp;
				<select id="selM" name="selM" class="select">
					<?for($r=1;$r<=12;$r++){?>
					<option value="<?=$r?>" <?echo (($Mon == $r) ? "selected='selected'" : "")?>><?=$r?></option>
				<?}?>
				</select>월
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:60px; height:23px;" value="조회" onclick="fnCalSearch();" /></td>
		</tr>
	</table>
</form>

<?
/*
$select_query = 'SELECT COUNT(*) AS Cnt, ResDate, DAY(ResDate) AS sDay, a.ResConfirm, SUM(ResPrice) AS price, SUM(RtnPrice) AS RtnPrice, b.shopSeq, c.opt_bbq, c.opt_bbq, c.shopname, max(c.shopcharge) as shopcharge FROM `SURF_SHOP_RES_SUB` as a INNER JOIN `SURF_SHOP_RES_MAIN` as b
					ON a.MainNumber = b.MainNumber
				INNER JOIN SURF_SHOP as c
					ON b.shopSeq = c.intseq							
						WHERE a.DelUse = "N"
							AND a.ResConfirm IN (5, 6, 7)
							AND (Year(ResDate) = '.$Year.' AND Month(ResDate) = '.$Mon.')
							AND ((c.opt_bbq = "Y" AND a.ResGubun IN (0,1,2,3)) OR (c.opt_bbq = "N"))
						GROUP BY b.shopSeq, a.ResDate, a.ResConfirm, c.opt_bbq, c.shopname
						ORDER BY a.ResDate,  b.shopSeq, a.ResConfirm';
*/

$select_query = 'SELECT COUNT(*) AS Cnt, ResDate, DAY(ResDate) AS sDay, a.ResConfirm, SUM(ResPrice) AS price, SUM(RtnPrice) AS RtnPrice, b.shopSeq, c.opt_bbq, c.opt_bbq, c.shopname, max(c.shopcharge) as shopcharge FROM `SURF_SHOP_RES_SUB` as a INNER JOIN `SURF_SHOP_RES_MAIN` as b
					ON a.MainNumber = b.MainNumber
				INNER JOIN SURF_SHOP as c
					ON b.shopSeq = c.intseq							
						WHERE a.DelUse = "N"
							AND b.shopSeq NOT IN (64,5)
							AND a.ResConfirm IN (5, 6, 7)
							AND (Year(ResDate) = '.$Year.' AND Month(ResDate) = '.$Mon.')
							AND ((c.opt_bbq = "Y" AND a.ResGubun IN (0,1,2,3)) OR (c.opt_bbq = "N"))
						GROUP BY b.shopSeq, a.ResConfirm, c.opt_bbq, c.shopname
						ORDER BY b.shopSeq, a.ResConfirm';

$result_setlist = mysqli_query($conn, $select_query);

$count = mysqli_num_rows($result_setlist);
?>

<div class="gg_first" style="padding-bottom:7px;"><?=$Year.'년 '.$Mon.'월'?> 정산</div>

<table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
<colgroup>
	<col style="width:*;">
	<col style="width:*;">
	<col style="width:*;">
	<col style="width:*;">
	<col style="width:*;">
	<col style="width:60px;">
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
		<th style="text-align:center;" rowspan="2">샵이름</th>
		<th style="text-align:center;" colspan="3">구분</th>
		<th style="text-align:center;" rowspan="2">정산금액</th>
		<th style="text-align:center;" rowspan="2">처리</th>
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

	$arrShopName = array();
	$arrShopPrice1 = array(); //확정 금액
	$arrShopPrice2 = array(); //수수료 금액
	$arrShopPrice3 = array(); //환불 금액
	$arrShopPrice4 = array(); //정산금액
	while ($row = mysqli_fetch_assoc($result_setlist)){
		$shopcharge = ($row["shopcharge"] / 100); //수수료

		if(array_key_exists($row['shopSeq'], $arrShopPrice1)){
		}else{
			$arrShopName[$row['shopSeq']] = $row['shopname'];
			$arrShopPrice1[$row['shopSeq']] = 0;
			$arrShopPrice2[$row['shopSeq']] = 0;
			$arrShopPrice3[$row['shopSeq']] = 0;
			$arrShopPrice4[$row['shopSeq']] = 0;
		}

		if($row['ResConfirm'] == 5){
			$ResConfirm = "<font color='blue'><b>확정<b/></font>";

			$arrShopPrice1[$row['shopSeq']] += $row["price"];
			$arrShopPrice2[$row['shopSeq']] += ($row["price"] * $shopcharge);
		}else if($row['ResConfirm'] == 6 || $row['ResConfirm'] == 7){
			$ResConfirm = "<font color='red'>환불</font>";
			$arrShopPrice3[$row['shopSeq']] += $row["price"];
		}
	}

	foreach($arrShopName as $i => $i_value) {
		$TotalPrice += $arrShopPrice1[$i];
		$TotalCalPrice += $arrShopPrice2[$i];
		$TotalRtnPrice += $arrShopPrice3[$i];
?>
	<tr>
		<td style="text-align:center;"><?=$arrShopName[$i]?></td>
		<td style="text-align:center;"><?=number_format($arrShopPrice1[$i])?>원</td>
		<td style="text-align:center;"><font color='blue'><?=number_format($arrShopPrice2[$i])?>원</font></td>
		<td style="text-align:center;"><font color='cc6600'><?=number_format($arrShopPrice3[$i])?>원</font></td>
		<td style="text-align:center;"><font color='red'><b><?//=number_format($arrShopPrice2[$i] + $arrShopPrice3[$i])?><?=number_format($arrShopPrice1[$i] - $arrShopPrice2[$i])?>원</b></td>
		<td style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:40px; height:23px;" value="완료" onclick="fnCalSearch();" /></td>
	</tr>
<?
	}
}
?>
</tbody>
</table>

<div class="gg_first" style="padding-bottom:7px;">총 합계안내</div>

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
		<td style="text-align:center;"><font color='red'><b><?//=number_format($TotalCalPrice + $TotalRtnPrice)?><?=number_format($TotalPrice - $TotalCalPrice)?>원</b></font></td>
	</tr>
</tbody>
</table>
