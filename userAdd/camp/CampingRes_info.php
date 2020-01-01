
<div class="gg_first">야영장 이용일수 </div>
    <table class="et_vars exForm bd_tb">
        <tbody>
            <tr>
                <th scope="row">입/퇴실일</th>
                <td width="100%">
					<span id="selInfo"></span>
					 ~ 
					<span id="selInfo2"></span>
					
					&nbsp;<select id="selDay" name="selDay" class="select" onchange="fnDayChange(this.value);">
					<?for($i=1;$i < 11;$i++){?>
						<option value="<?=$i?>" <?=($_REQUEST["daynum"] == $i) ? "selected" : ""?>><?=$i?>박</option>
					<?}?>
					</select>
				</td>
            </tr>
            <tr>
                <th scope="row">이용시간</th>
                <td>입실 : 오후 2시 / 퇴실 : 익일 오후 12시</td>
            </tr>
        </tbody>
    </table>
</div>

<?
$viewtype = $_REQUEST["viewtype"];

//pc 접속
$arrCss = array(
	"bgUrl"=> "background:url(http://skinnz.godohosting.com/surfenjoy/camp/campfull3.jpg);width:649px;height:1043px;border:1px solid #DDD;position:relative;"
	,"tbCss"=> "position:absolute;top:35px;left:245px;"
	,"gCamp1"=> "0"
	,"gCamp2"=> "15"
	,"gCamp3"=> "11"
	,"gCamp4"=> "11"
	,"siteCss"=> "position:absolute;top:153px;left:270px;"
);

//mobile 접속
if($viewtype == 1){
	$arrCss = array(
		"bgUrl"=> "background-image:url(http://skinnz.godohosting.com/surfenjoy/camp/campfullM.jpg);background-repeat:no-repeat;background-position:center;width:320px;height:1075px;border:1px solid #DDD;position:relative;margin:auto;"
		,"tbCss"=> "position:absolute;top:30px;left:88px;"
		,"gCamp1"=> "0"
		,"gCamp2"=> "16"
		,"gCamp3"=> "15"
		,"gCamp4"=> "17"
		,"siteCss"=> "position:absolute;top:193px;left:85px;"
	);
}
?>

<div class="bd" style="padding:0px;">
	<div class="gg_first">
		죽도 야영장 자리선택
	</div>

	<div style="<?=$arrCss["bgUrl"]?>">
	<table class="" style="<?=$arrCss["tbCss"]?>">
		<tbody>
<?
	$selDate1 = ($_REQUEST["selDate"] == "") ? date("Y-m-d") : $_REQUEST["selDate"];
	$selDate2 = ($_REQUEST["selDate"] == "") ? str_replace("-", "", date("Y-m-d")) : str_replace("-", "", $_REQUEST["selDate"]);

	$Mon = substr($selDate2,4,2);
	$onOff = 1;
	if(($Mon >= 1 && $Mon <= 5) || $Mon == 12 || $Mon == 11){
		$onOff = 0;
	}

	$weekNum = date('w', strtotime($selDate1." 0 day"));
	
	$chkDisabled = "disabled='disabled'";
	$onOff = 0;
	if($onOff == 1){
		$chkDisabled = "";
	}
?>
			<!--tr>
				<td class="col-3" style="padding-top:<?=$arrCss["gCamp1"]?>px;padding-left:0px;"><span id="seatA01"><input <?=$chkDisabled?> type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnPrice('g', this);" value="A01"  /></span></td>
			</tr>
			<tr>
				<td class="col-3" style="padding-top:<?=$arrCss["gCamp2"]?>px;padding-left:0px;"><span id="seatA02"><input <?=$chkDisabled?> type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnPrice('g', this);" value="A02" /></span></td>
			</tr>			
			<tr>
				<td class="col-3" style="padding-top:<?=$arrCss["gCamp3"]?>px;padding-left:0px;"><span id="seatA03"><input <?=$chkDisabled?> type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnPrice('g', this);" value="A03" /><b style="font-size:12px;"></b></span></td>
			</tr>
			<tr>
				<td class="col-3" style="padding-top:<?=$arrCss["gCamp4"]?>px;padding-left:0px;"><span id="seatA04"><input <?=$chkDisabled?> type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnPrice('g', this);" value="A04" /><b style="font-size:12px;"></b></span></td>
			</tr-->
		</tbody>
	</table>
	<table class="et_vars bd_tb" style="<?=$arrCss["siteCss"]?>">
		<tbody>
	<?
	for($i=0; $i<=21; $i++){
		$num1 = ($i) + 101;

		if($i > 4){
			$gubun = "C";
			$num2 = ($i) + 122 - 4;
		}else{
			$gubun = "D";
			$num2 = ($i) + 201;
		}

		$imgName = "t_01";
		if($num2 == 205 || $num2 == 204){
			$imgName = "t_02";
		}
	?>
			<tr height="40px">
				<td style="padding:0px;width:105px;border:0px solid #330000;">
				
					<span id="seatC<?=$num1?>" class=""><label><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnPrice('C', this);" value="C<?=$num1?>" /><img src="http://skinnz.godohosting.com/surfenjoy/camp/t_01.jpg" height="27px">&nbsp;</label></span>
				
				</td>
				<td style="padding:0px;border:0px;">

					<span id="seat<?=$gubun.$num2?>" class=""><label><input type="checkbox" id="chkSeat" name="chkSeat[]" onclick="fnPrice('<?=$gubun?>', this);" value="<?=$gubun.$num2?>" <?if($num2 == 205 || $num2 == 204) echo "disabled='disabled'";?> /><img src="http://skinnz.godohosting.com/surfenjoy/camp/<?=$imgName?>.jpg" height="27px">&nbsp;</label></span>

				</td>
			</tr>
	<?
	}
	?>

		</tbody>
	</table>
	</div>

<?include 'CampingRes_infoSub.php';?>

