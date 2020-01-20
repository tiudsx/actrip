<?php
include __DIR__.'/../db.php';

$busNum = $_REQUEST["busNum"];
$busGubun = substr($busNum, 0, 1);
$busNumber = substr($busNum, 1, 1);

$selDate = $_REQUEST["selDate"];
$x = explode("-", $selDate);
$s_n = date("N",mktime(0,0,0, $x[1], $x[2],$x[0])); //1:월   6:토   7:일

$select_query = 'SELECT * FROM `SURF_BUS_SUB` where busDate = "'.$selDate.'" AND DelUse = "N" AND ResConfirm IN (0, 1) AND busNum = "'.$busNum.'"';
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($busGubun == "Y"){
	$busNumName = '양양행 '.$busNumber.'호차';
}else{
	$busNumName = '서울행 '.$busNumber.'호차';
}
?>

<script>
	var selDate = '<?=$_REQUEST["selDate"]?>';
	var busNum = '<?=$busNum?>';
	var busNumName = '<?=$busNumName?>';
	var busType = '<?=$busGubun?>';
</script>
<link rel="stylesheet" type="text/css" href="surfshop_btn.css" />
  <style>
  .surfbtn li {
    list-style: none;
    float: left;
    font-size: 13px;
    padding-right: 5px;
}

.surfbtn a {
    display: block;
    overflow: hidden;
    padding: 7px 20px;
    margin: 2px;
    border: 1px solid #4f83bd;
    border-radius: 49px;
    white-space: nowrap;
    text-overflow: ellipsis;
    text-decoration: none !important;
    text-align: center;
    color: #4f83bd;
	letter-spacing: -0.5px;

}

.surfarea .surfbtn a:hover {
    background-color: #4f83bd;
    color: #fff;    
    background-position: 28px 16px;
    background-repeat: no-repeat;
}

.surfbtn .on2 > a {
    border-color: #4f83bd;
    background: #4f83bd;
    color: #fff;
}


  </style>
	<div class="surfarea" style="width:100%">
		<ul class="surfbtn clear">
			<li><a href="javascript:fnAreaView();">정류장 선택하기<i class="filter-icon filter-icon__arrow_bottom"></i></a></li>
		</ul>
	</div>
	<div class="" style="width:100%;display:;">
		<h1 class="ngeb clear"></h1>
	</div>

	<div class="gg_first" style="margin-top:0px;padding-top:0px;">
		[<?=$_REQUEST["selDate"]?>] <?=$busNumName?>
		&nbsp;
		<span class="calendar_description">
			<span class="calendar_description_list">
				<span class="calendar_description_item"><button type="button" class="tour_cal_type tour_cal_type11">예약가능</button></span>
				<span class="calendar_description_item"><button type="button" class="tour_cal_type tour_cal_type2">예약완료</button></span>
			</span>
		</span>
	</div>

	<div style="background:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_0.jpg);background-repeat:no-repeat;background-position:center;width:325px;height:1000px;border:0px solid #DDD;position:relative;text-align:center;margin:auto;">
	<div style="padding-bottom:155px;"></div>
	<table class="" style="width:308px;margin-left:9px;">
		<colgroup>
			<col style="width:60px;height:68px;">
			<col style="width:60px;height:68px;">
			<col style="width:60px;height:68px;">
			<col style="width:60px;height:68px;">
			<col style="width:60px;height:68px;">
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
				<td style="background-image:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_1.png);background-repeat:no-repeat;background-position:center;padding:2px;" valign="top"><br><span id="seat<?=$num1?>"><span><label><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnSeatSelectedDang(this);" value="<?=$num1?>" style="vertical-align:-3px;" /><?=$num1?></label></span></span></td>
				<td style="background-image:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_1.png);background-repeat:no-repeat;background-position:center;padding:2px;" valign="top"><br><span id="seat<?=$num2?>"><span><label><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnSeatSelectedDang(this);" value="<?=$num2?>" style="vertical-align:-3px;" /><?=$num2?></label></span></span></td>
				<td style="background-image:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_1.png);background-repeat:no-repeat;background-position:center;padding:2px;" valign="top"><br><span id="seat<?=$num3?>"><span><label><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnSeatSelectedDang(this);" value="<?=$num3?>" style="vertical-align:-3px;" /><?=$num3?></label></span></span></td>
				<td style="background-image:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_1.png);background-repeat:no-repeat;background-position:center;padding:2px;" valign="top"><br><span id="seat<?=$num4?>"><span><label style=""><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnSeatSelectedDang(this);" value="<?=$num4?>" style="vertical-align:-3px;" /><?=$num4?></label></span></span></td>
				<td style="background-image:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_2.jpg);background-repeat:no-repeat;background-position:center;padding:2px;" valign="top"><br><span id="seat<?=$num5?>"><span><label style="color:#808080"><!--input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnSeatSelectedDang(this);" value="<?=$num5?>" style="vertical-align:-3px;" /--><?=$num5?></label></span></span></td>
			</tr>
	<?
		}else{
	?>
			<tr height="68">
				<td style="background-image:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_1.png);background-repeat:no-repeat;background-position:center;padding:2px;" valign="top"><br><span id="seat<?=$num1?>"><span><label><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnSeatSelectedDang(this);" value="<?=$num1?>" style="vertical-align:-3px;" /><?=$num1?></label></span></span></td>
				<td style="background-image:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_1.png);background-repeat:no-repeat;background-position:center;padding:2px;" valign="top"><br><span id="seat<?=$num2?>"><span><label><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnSeatSelectedDang(this);" value="<?=$num2?>" style="vertical-align:-3px;" /><?=$num2?></label></span></span></td>
				<td>&nbsp;</td>
				<td style="background-image:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_1.png);background-repeat:no-repeat;background-position:center;padding:2px;" valign="top"><br><span id="seat<?=$num3?>"><span><label><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnSeatSelectedDang(this);" value="<?=$num3?>" style="vertical-align:-3px;" /><?=$num3?></label></span></span></td>
				<td style="background-image:url(https://surfenjoy.cdn3.cafe24.com/bus/bus_1.png);background-repeat:no-repeat;background-position:center;padding:2px;" valign="top"><br><span id="seat<?=$num4?>"><span><label style=""><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnSeatSelectedDang(this);" value="<?=$num4?>" style="vertical-align:-3px;" /><?=$num4?></label></span></span></td>
			</tr>
	<?
		}

	}
	?>

		</tbody>
	</table>
	</div>

<span style="display:none;">
	<input type="text" id="resparam" name="resparam" value="BusI" />
</span>

<?
if($busGubun == "Y" && $busNumber > 4){
	$busNumber -= 4;
}else if($busGubun == "S" && $busNumber > 2){
	$busNumber -= 2;
}
$changBus = $busGubun.$busNumber;

$select_queryPoint = 'SELECT * FROM SURF_CODE where gubun IN (\'bus'.$changBus.'\', \'bus'.$busGubun.'\') ORDER BY ordernum';
$result_setlistPoint = mysqli_query($conn, $select_queryPoint);
?>
<script type="text/javascript">
	var sPoint = "", ePoint = "";	
	
<?
	while ($rowPoint = mysqli_fetch_assoc($result_setlistPoint)){
		if($busGubun == "Y"){
			$pointName1 = "s";
			$pointName2 = "e";
		}else{
			$pointName1 = "e";
			$pointName2 = "s";
		}

		//if($busGubun == "Y" && $rowPoint['codename'] == "인구") continue;
		if($rowPoint['codename'] == "설악" || $rowPoint['codename'] == "동호" || $rowPoint['codename'] == "하조대" || $rowPoint['codename'] == "죽도" || $rowPoint['codename'] == "주문진" || $rowPoint['codename'] == "동산항" || $rowPoint['codename'] == "인구" || $rowPoint['codename'] == "남애3리") continue;

		if($rowPoint['gubun'] == "bus".$changBus){
			echo $pointName1.'Point += "<option value=\''.$rowPoint['code'].'\'>'.$rowPoint['codename'].'</option>";';
		}else{
			echo $pointName2.'Point += "<option value=\''.$rowPoint['code'].'\'>'.$rowPoint['codename'].'</option>";';
		}
	}
?>

    var arrySeat = new Array(45);

<?
	while ($row = mysqli_fetch_assoc($result_setlist)){
		echo 'arrySeat['.$row['busSeat'].'] = "ok";';
	}

?>
    jQuery(document).ready(function () {
		if($j("#tb" + selDate + '_' + busNum).length > 0){
			var forObj = $j("#" + selDate + '_' + busNum + ' tr');
			for (var i = 1; i < forObj.length; i++) {
				var seatNum = forObj.eq(i).attr("id").split("_")[2];
				$j("input[id=chkSeat][value=" + seatNum + "]").prop('checked', true);
			}
		}

		for (var i = 0; i < arrySeat.length; i++) {
			if (arrySeat[i] == null) {
			} else {
				jQuery("#seat" + i).parent().css("background-image", 'url("https://surfenjoy.cdn3.cafe24.com/bus/bus_2.jpg")');
				jQuery("#seat" + i + " label").css("color", "#808080");
				jQuery("#seat" + i + " input").remove();
			}
		}


		fnResView(true, '.surfarea', 30);
    });
</script>

