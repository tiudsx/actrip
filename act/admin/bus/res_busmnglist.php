<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$selDate = $_REQUEST["selDate"];
$busNum = $_REQUEST["busNum"];

$select_query_sub = "SELECT a.user_name, a.user_tel, a.etc, b.* FROM 
						`AT_RES_MAIN` as a INNER JOIN `AT_RES_SUB` as b 
							ON a.resnum = b.resnum 
                                AND b.code = 'bus'
						where b.res_date = '$selDate' AND b.res_busnum = '$busNum' AND b.ResConfirm = 3";
//echo $select_query_sub;
$result_setlist = mysqli_query($conn, $select_query_sub);
$count_sub = mysqli_num_rows($result_setlist);

if($count_sub == 0){
	echo '<div style="text-align:center;font-size:14px;padding:50px;" id="initText2">
				<b>예약된 좌석이 없습니다.</b>
			</div>';
	return;
}

echo '<script type="text/javascript">$j(document).ready(function(){';

while ($row = mysqli_fetch_assoc($result_setlist)){
	echo '$j("#seat'.$row['res_seat'].'").removeClass("tab1");';

	echo '$j("#seat'.$row['res_seat'].'").attr("onclick", "fnModifyInfoDay('.$row['ressubseq'].')");';
	echo '$j("#seat'.$row['res_seat'].'").addClass("tab2");';
	echo '$j("#seat'.$row['res_seat'].' input").remove();';

	echo '$j("#seat'.$row['res_seat'].'").parent().append(" <span  '.$cssColor.'></span> <br><b>'.$row["userName"].'</b><br>['.$row["res_spointname"].']<br><span><a href=tel:'.$row["user_tel"].' style=cursor:text;>'.$row["userPhone"].'</a></span>");';
}

echo '});</script>';


$busGubun = substr($busNum, 0, 1);
$busNumber = substr($busNum, 1, 1);

$arrSeatInfo1 = array();
$arrSeatInfo1_1 = array();
$arrSeatInfo2 = array();

if($busGubun == "Y"){
	$busGubunName1 = $busNum;
	$busGubunName2 = $busGubun;
}else{
	$busGubunName1 = $busGubun;
	$busGubunName2 = $busNum;
}

$select_query_sub3 = 'SELECT COUNT(*) AS Cnt, res_spointname, c.ordernum FROM `AT_RES_SUB` as b LEFT JOIN AT_CODE as c
							ON b.res_spointname = c.codename
								AND c.gubun = CONCAT("bus", "'.$busGubunName1.'") 
						where b.busDate = "'.$selDate.'" AND b.busNum = "'.$busNum.'" AND b.ResConfirm = 1 
						GROUP BY sLocation ORDER BY c.ordernum';
//echo $select_query_sub3;
$resultSite3 = mysqli_query($conn, $select_query_sub3);
$i = 0;
while ($row = mysqli_fetch_assoc($resultSite3)){
	if(array_key_exists($row['ordernum'].'.'.$row['sLocation'], $arrSeatInfo1)){
		$arrSeatInfo1[$row['ordernum'].'.'.$row['sLocation']] += $row['Cnt'];
	}else{
		$arrSeatInfo1[$row['ordernum'].'.'.$row['sLocation']] = $row['Cnt'];
		$arrSeatInfo1_1[$row['sLocation']] = $row['sLocation'];
	}
	$i += $row['Cnt'];
}

$select_query_sub3 = 'SELECT COUNT(*) AS Cnt, eLocation, c.ordernum FROM `SURF_BUS_SUB` as b LEFT JOIN SURF_CODE as c
							ON b.eLocation = c.codename
								AND c.gubun = CONCAT("bus", "'.$busGubunName2.'") 
						where b.busDate = "'.$selDate.'" AND b.busNum = "'.$busNum.'" AND b.ResConfirm = 1 
						GROUP BY eLocation ORDER BY c.ordernum';
$resultSite3 = mysqli_query($conn, $select_query_sub3);

while ($row = mysqli_fetch_assoc($resultSite3)){
	if(array_key_exists($row['ordernum'].'.'.$row['eLocation'], $arrSeatInfo2)){
		$arrSeatInfo2[$row['ordernum'].'.'.$row['eLocation']] += $row['Cnt'];
	}else{
		$arrSeatInfo2[$row['ordernum'].'.'.$row['eLocation']] = $row['Cnt'];
	}
}

$arrSeatInfo3 = $arrSeatInfo2;
?>
	<div style="padding-bottom:5px;"></div>

	<input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;margin-bottom:2px;" value="<?=fnBusNum($busNum)?> [총 : <?=$i?>명]" />
    <table class="et_vars exForm bd_tb" width="100%">
        <tbody>
			 <tr>
				<td style="vertical-align:top;">
					<table width="100%">
						<colgroup>
							<col style="width:21%;">
							<col style="width:*;">
							<col style="width:12%;">
						</colgroup>
						<tr>
							<th style="padding:4px;text-align:center;" colspan="2">출발 정류장</th>
							<th style="padding:4px;text-align:center;">인원</th>
						</tr>
					<?
					foreach($arrSeatInfo1 as $key=>$value) {
						$arrData = explode(".",$key);
						$pointname = explode("|",fnBusReturnPoint($arrData[1]));
						$pointtime = explode("|",fnBusPoint($arrData[1], $busNum, ""));
					?>
						<tr>
							<td style="padding:2px;text-align:left;">&nbsp;<?=$key?><br>&nbsp;&nbsp;<b>(<?=$value?> 명)</b></td>
						<?if($busGubun == "Y"){?>
							<td><?=$pointtime[0]?> | <b><?=$pointtime[1]?></b></td>
						<?}else{?>
							<td><?=$pointtime[0]?> | <b><?=$pointname[1]?></b><br>(네비 : <?=$pointname[2]?>)</td>
						<?}?>
							<td style="padding:2px;text-align:center;"><?=$value?> 명</td>
						</tr>
					<?}?>
					</table>
					
					<table width="100%" style="margin-top:10px;">
						<colgroup>
							<col style="width:85px;">
							<col style="width:*;">
						</colgroup>
						<tr>
							<th style="padding:4px;text-align:center;" colspan="2">도착 정류장</th>
						</tr>
					<?if($busGubun == "Y"){?>

						<?foreach($arrSeatInfo3 as $key=>$value) {
							$arrData = explode(".",$key);
							$pointname = explode("|",fnBusReturnPoint($arrData[1]));
						?>
						<tr>
							<td style="padding:2px;text-align:left;height:22px;">&nbsp;<?=$arrData[0]?>.<?=$pointname[0]?><br>&nbsp;&nbsp;<b>(<?=$value?> 명)</b></td>
							<td><b><?=$pointname[1]?></b><br>(네비 : <?=$pointname[2]?>)</td>
						</tr>
						<?}?>
					
					<?}else{?>

						<?foreach($arrSeatInfo3 as $key=>$value) {
							$arrData = explode(".",$key);
						?>
						<tr>
							<td style="padding:2px;text-align:left;height:22px;">&nbsp;<?=$key?> (<?=$value?> 명)</td>
						</tr>
						<?}?>

					<?}?>
						<!--tr>
							<td style="padding:2px;text-align:center;">
							<?foreach($arrSeatInfo2 as $key=>$value) {?>
							<?=$key?> > 
							<?}?>
							</td>
						</tr-->
					</table>

				</td>
				
			</tr>
		</tbody>
	</table>

	<div style="padding-bottom:5px;"></div>

<form name="frmDayConfirm" id="frmDayConfirm" autocomplete="off">
    <div class="gg_first">양양셔틀버스 예약정보
		<span class="calendar_description">
			<span class="calendar_description_list">
				<span class="calendar_description_item"><button type="button" class="tour_cal_type tour_cal_type1">예약가능</button></span>
				<span class="calendar_description_item"><button type="button" class="tour_cal_type tour_cal_type2">예약완료</button></span>
			</span>			
		</span>
	</div>

    <table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
		<colgroup>
			<col style="width:20%;">
			<col style="width:20%;">
			<col style="width:20%;">
			<col style="width:20%;">
			<col style="width:20%;">
		</colgroup>
		<tbody>
	<?
	for($i=0; $i<=10; $i++){
		$num1 = ($i * 4) + 1;
		$num2 = ($i * 4) + 2;
		$num3 = ($i * 4) + 3;
		$num4 = ($i * 4) + 4;
		$num5 = ($i * 4) + 5;

		if($i == 10){
	?>
			<tr height="68">
				<td class="col-3" style="text-align:center;vertical-align:top;"><span id="seat<?=$num1?>" class="tab1"><span style="width:45px;"><label><?=$num1?></label></span></span></td>
				<td class="col-3" style="text-align:center;vertical-align:top;"><span id="seat<?=$num2?>" class="tab1"><span style="width:45px;"><label><?=$num2?></label></span></span></td>
				<td class="col-3" style="text-align:center;vertical-align:top;"><span id="seat<?=$num3?>" class="tab1"><span style="width:45px;"><label><?=$num3?></label></span></span></td>
				<td class="col-3" style="text-align:center;vertical-align:top;"><span id="seat<?=$num4?>" class="tab1"><span style="width:45px;"><label><?=$num4?></label></span></span></td>
				<td class="col-3" style="text-align:center;vertical-align:top;"><span id="seat<?=$num5?>" class="tab1"><span style="width:45px;"><label><?=$num5?></label></span></span></td>
			</tr>
	<?
		}else{
	?>
			<tr height="68">
				<td class="col-3" style="text-align:center;vertical-align:top;"><span id="seat<?=$num1?>" class="tab1"><span style="width:45px;"><label><?=$num1?></label></span></span></td>
				<td class="col-3" style="text-align:center;vertical-align:top;"><span id="seat<?=$num2?>" class="tab1"><span style="width:45px;"><label><?=$num2?></label></span></span></td>
				<td>&nbsp;</td>
				<td class="col-3" style="text-align:center;vertical-align:top;"><span id="seat<?=$num3?>" class="tab1"><span style="width:45px;"><label><?=$num3?></label></span></span></td>
				<td class="col-3" style="text-align:center;vertical-align:top;"><span id="seat<?=$num4?>" class="tab1"><span style="width:45px;"><label><?=$num4?></label></span></span></td>
			</tr>
	<?
		}
	}
	?>

		</tbody>
	</table>
</form>