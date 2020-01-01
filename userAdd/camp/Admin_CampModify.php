<?
include '../db.php';

$subintseq = $_REQUEST["subintseq"];

$select_query = 'SELECT a.*, b.userName, b.userPhone, b.userMail FROM SURF_CAMPING_SUB as a INNER JOIN SURF_CAMPING_MAIN as b ON a.MainNumber = b.MainNumber where subintseq = '.$subintseq;
$result = mysqli_query($conn, $select_query);
$row = mysqli_fetch_array($result);
$count = mysqli_num_rows($result_setlist);
//echo $select_query;

$arrOpt = explode("@",$row['ResOptPrice']);
if($arrOpt[0] == "1"){
	$arrOptChk = "checked";
}
?>
<form name="frmModify" id="frmModify" autocomplete="off">
<div class="" id="busmodify">
	<div class="gg_first" style="margin-top:0px;">야영장 정보변경 (<?=$row["MainNumber"]?>)</div>
	<table class="et_vars exForm bd_tb" style="width:100%;display:;" id="infomodify">
		<tbody>
			<tr>
				<th>신청일</th>
				<td colspan="3"><input type="text" id="insdate" name="insdate" size="17" value="<?=$row["insdate"]?>" class="itx"></td>
			</tr>
			<tr>
				<th>사이트</th>
				<td><input type="text" id="sLocation" name="sLocation" value="<?=$row["sLocation"]?>" class="itx tel"></td>
				<th>옵션</th>
				<td><input type="checkbox" id="chkOpt" name="chkOpt" <?=$arrOptChk?> value="1" /> 전기사용</td>
			</tr>
			<tr>
				<th>이용일</th>
				<td><input type="text" id="resDate" name="resDate" size="10" value="<?=$row["sDate"]?>" class="itx"></td>
				<th>상태</th>
				<td>
					<select id="ResConfirm" name="ResConfirm" class="select">
						<option value="0" <?if($row['ResConfirm'] == 0) echo "selected"?>>미입금</option>
						<option value="1" <?if($row['ResConfirm'] == 1) echo "selected"?>>확정</option>
						<option value="2" <?if($row['ResConfirm'] == 2) echo "selected"?>>취소</option>
						<option value="3" <?if($row['ResConfirm'] == 3) echo "selected"?>>환불요청</option>
						<option value="4" <?if($row['ResConfirm'] == 4) echo "selected"?>>환불완료</option>
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
				<td colspan="3"><input type="text" id="userMail" name="userMail" value="<?=$row["userMail"]?>" class="itx" size="20"></td>
			</tr>
			<tr>
				<td class="col-02" style="text-align:center;" colspan="4">
					<input type="hidden" id="resparam" name="resparam" size="10" value="adminmodify" class="itx">
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