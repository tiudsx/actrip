<?
include '../db.php';

$subintseq = $_REQUEST["subintseq"];
$gubun = $_REQUEST["gubun"];

if($gubun == "bus"){
	$select_query = 'SELECT a.*, b.userName, b.userPhone, b.userMail FROM SURF_BUS_SUB as a INNER JOIN SURF_BUS_MAIN as b ON a.MainNumber = b.MainNumber where subintseq = '.$subintseq;
}else{
	$select_query = 'SELECT ResBBQDate, ResBBQPrice, ResBBQ, ResBBQConfirm, MainNumber, insdate FROM `SURF_BBQ` where intseq = '.$subintseq;
}
$result = mysqli_query($conn, $select_query);
$row = mysqli_fetch_array($result);
//$count = mysqli_num_rows($result_setlist);
//echo $select_query;
echo '<form name="frmModify" id="frmModify" autocomplete="off">';
if($gubun == "bus"){
?>

<div class="" id="busmodify">
	<div class="gg_first" style="margin-top:0px;">서핑버스 정보변경 (<?=$row["MainNumber"]?>)</div>
	<table class="et_vars exForm bd_tb" style="width:100%;display:;" id="infomodify">
		<tbody>
			<tr>
				<th>신청일</th>
				<td colspan="3"><input type="text" id="insdate" name="insdate" size="20" value="<?=$row["insdate"]?>" class="itx"></td>
			</tr>
			<tr>
				<th>상태</th>
				<td colspan="3">
					<select id="ResConfirm" name="ResConfirm" class="select">
						<option value="0" <?=($row["ResConfirm"] == 0) ? "selected" : ""?>>미입금</option>
						<option value="1" <?=($row["ResConfirm"] == 1) ? "selected" : ""?>>확정</option>
						<option value="2" <?=($row["ResConfirm"] == 2) ? "selected" : ""?>>취소</option>
						<option value="3" <?=($row["ResConfirm"] == 3) ? "selected" : ""?>>환불요청</option>
						<option value="4" <?=($row["ResConfirm"] == 4) ? "selected" : ""?>>환불완료</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>이름</th>
				<td><input type="text" id="userName" name="userName" size="11" value="<?=$row["userName"]?>" class="itx"></td>
				<th>연락처</th>
				<td><input type="text" id="userPhone" name="userPhone" size="12" value="<?=$row["userPhone"]?>" class="itx"></td>
			</tr>
			<tr>
				<th>이메일</th>
				<td><input type="text" id="userMail" name="userMail" value="<?=$row["userMail"]?>" class="itx" size="18"></td>
				<th>금액</th>
				<td><input type="text" id="ResPrice" name="ResPrice" size="12" value="<?=$row["ResPrice"]?>" class="itx"></td>
			</tr>
			<tr>
				<th>호차</th>
				<td>
					<select id="busNum" name="busNum" class="select" onchange="fnBusPointMove(this.value);">
						<option value="Y1" <?=($row["busNum"] == "Y1") ? "selected" : ""?>>양양행 1호차</option>
						<option value="Y2" <?=($row["busNum"] == "Y2") ? "selected" : ""?>>양양행 2호차</option>
						<option value="Y3" <?=($row["busNum"] == "Y3") ? "selected" : ""?>>양양행 3호차</option>
						<option value="Y4" <?=($row["busNum"] == "Y4") ? "selected" : ""?>>양양행 4호차</option>
						<option value="Y5" <?=($row["busNum"] == "Y5") ? "selected" : ""?>>양양행 5호차</option>
						<option value="Y6" <?=($row["busNum"] == "Y6") ? "selected" : ""?>>양양행 6호차</option>
						<option value="Y7" <?=($row["busNum"] == "Y7") ? "selected" : ""?>>양양행 7호차</option>
						<option value="Y8" <?=($row["busNum"] == "Y8") ? "selected" : ""?>>양양행 8호차</option>
						<option value="S1" <?=($row["busNum"] == "S1") ? "selected" : ""?>>서울행 1호차</option>
						<option value="S2" <?=($row["busNum"] == "S2") ? "selected" : ""?>>서울행 2호차</option>
						<option value="S3" <?=($row["busNum"] == "S3") ? "selected" : ""?>>서울행 3호차</option>
						<option value="S4" <?=($row["busNum"] == "S4") ? "selected" : ""?>>서울행 4호차</option>
					</select>
				</td>
				<th>좌석</th>
				<td><input type="text" id="busSeat" name="busSeat" value="<?=$row["busSeat"]?>" class="itx tel"></td>
			</tr>
			<tr>
				<th>정류장</th>
				<td colspan="3">

<?
$busGubun = substr($row["busNum"], 0, 1);
$busNumber = substr($row["busNum"], 1, 1);
if($busGubun == "Y" && $busNumber > 4){
	$busNumber -= 4;
}else if($busGubun == "S" && $busNumber > 2){
	$busNumber -= 2;
}
$changBus = $busGubun.$busNumber;

/*
$select_queryPoint = 'SELECT * FROM SURF_CODE where gubun IN (\'bus'.$changBus.'\', \'bus'.$busGubun.'\') ORDER BY ordernum';
$result_setlistPoint = mysqli_query($conn, $select_queryPoint);
//echo $select_queryPoint;

$arrOptionS = "";
$arrOptionE = "";
while ($rowPoint = mysqli_fetch_assoc($result_setlistPoint)){
	if($busGubun == "Y"){
		if($rowPoint['gubun'] == "bus".$changBus){
			$arrOptionS .= '<option value=\''.$rowPoint['code'].'\' '.(($row["sLocation"] == $rowPoint['code']) ? "selected" : "").'>'.$rowPoint['codename'].'</option>";';
		}else{
			$arrOptionE .= '<option value=\''.$rowPoint['code'].'\' '.(($row["eLocation"] == $rowPoint['code']) ? "selected" : "").'>'.$rowPoint['codename'].'</option>";';
		}
	}else{
		if($rowPoint['gubun'] == "bus".$changBus){
			$arrOptionE .= '<option value=\''.$rowPoint['code'].'\' '.(($row["eLocation"] == $rowPoint['code']) ? "selected" : "").'>'.$rowPoint['codename'].'</option>";';
		}else{
			$arrOptionS .= '<option value=\''.$rowPoint['code'].'\' '.(($row["sLocation"] == $rowPoint['code']) ? "selected" : "").'>'.$rowPoint['codename'].'</option>";';
		}
	}
}
*/
?>
					<select id="sLocation" name="sLocation" class="select">
						<option value="N">출발</option>
					</select> →
					<select id="eLocation" name="eLocation" class="select">
						<option value="N">도착</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>이용일</th>
				<td><input type="text" id="busDate" name="busDate" size="10" value="<?=$row["busDate"]?>" class="itx"></td>
				<th>문자안내</th>
				<td>
					<select id="msgYN" name="msgYN" class="select">
						<option value="N">미발송</option>
						<option value="Y">발송</option>
					</select>
				</td>
			</tr>
<?}else{?>
<div class="" id="busmodify">
	<div class="gg_first" style="margin-top:0px;">바베큐 정보변경 (<?=$row["MainNumber"]?>)</div>
	<table class="et_vars exForm bd_tb" style="width:100%;display:;" id="infomodify">
		<tbody>
			<tr>
				<th>신청일</th>
				<td colspan="3"><input type="text" id="insdate" name="insdate" size="20" value="<?=$row["insdate"]?>" class="itx"></td>
			</tr>
			<tr>
				<th>상태</th>
				<td>
					<select id="ResBBQConfirm" name="ResBBQConfirm" class="select">
						<option value="0" <?=($row["ResBBQConfirm"] == 0) ? "selected" : ""?>>미입금</option>
						<option value="1" <?=($row["ResBBQConfirm"] == 1) ? "selected" : ""?>>확정</option>
						<option value="2" <?=($row["ResBBQConfirm"] == 2) ? "selected" : ""?>>환불요청</option>
						<option value="3" <?=($row["ResBBQConfirm"] == 3) ? "selected" : ""?>>취소완료</option>
					</select>
				</td>
				<th>인원</th>
				<td><input type="text" id="ResBBQ" name="ResBBQ" size="11" value="<?=$row["ResBBQ"]?>" class="itx"></td>
			</tr>
			<tr>
				<th>이용일</th>
				<td><input type="text" id="ResBBQDate" name="ResBBQDate" size="10" value="<?=$row["ResBBQDate"]?>" class="itx"></td>
				<th>문자안내</th>
				<td>
					<select id="msgYN" name="msgYN" class="select">
						<option value="N">미발송</option>
						<option value="Y">발송</option>
					</select>
				</td>
			</tr>
<?}?>

			<tr>
				<td class="col-02" style="text-align:center;" colspan="4">
					<input type="hidden" id="resparam" name="resparam" size="10" value="<?=$gubun?>" class="itx">
					<input type="hidden" id="gubun" name="gubun" size="10" value="<?=$gubun?>" class="itx">
					<input type="hidden" id="userid" name="userid" size="10" value="" class="itx">
					<input type="hidden" id="subintseq" name="subintseq" size="10" value="<?=$subintseq?>" class="itx">
					<input type="hidden" id="MainNumber" name="MainNumber" size="10" value="<?=$row["MainNumber"]?>" class="itx">
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="정보수정" onclick="fnDataModify();" />
				</td>
			</tr>
		</tbody>
	</table>
</div>
</form>
<div class="wellBtn menu" style="display:none;">
	<div class="resbottom">
		<button class="reson" id="reson1" onclick="fnResView(true, '.right_article2', 20);"><i></i><span>예약정보로 이동</span></button>
	</div>
</div>
<?if($gubun == "bus"){?>
<script>
$j(document).ready(function(){
	fnBusPointSel('<?=$busGubun?>', 'bus<?=$changBus?>', 'bus<?=$busGubun?>', '<?=$row["sLocation"]?>', '<?=$row["eLocation"]?>');
});
</script>
<?}?>