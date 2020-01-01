<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';


$select_query = 'SELECT userGubun, userSex, COUNT(*) AS Cnt FROM `SURF_YANGFE_MAIN` WHERE ResConfirm IN (2) GROUP BY userGubun, userSex ORDER BY userGubun, userSex';

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

$arrGubunInfo = array();
//참관
$arrGubunInfo['참관_남'] = 0;
$arrGubunInfo['참관_여'] = 0;

//비기너
$arrGubunInfo['비기너_남'] = 0;
$arrGubunInfo['비기너_여'] = 0;

//롱보드 오픈
$arrGubunInfo['롱보드(오픈)_남'] = 0;
$arrGubunInfo['롱보드(오픈)_여'] = 0;

//숏보드 오픈
$arrGubunInfo['숏보드(오픈)_남'] = 0;
$arrGubunInfo['숏보드(오픈)_여'] = 0;

//롱보드 프로
$arrGubunInfo['롱보드(프로)_남'] = 0;
$arrGubunInfo['롱보드(프로)_여'] = 0;

//숏보드 프로
$arrGubunInfo['숏보드(프로)_남'] = 0;
$arrGubunInfo['숏보드(프로)_여'] = 0;

//주니어
$arrGubunInfo['주니어'] = 0;

while ($row = mysqli_fetch_assoc($result_setlist)){
	$userGubun = $row["userGubun"];
	$userSex = $row["userSex"];
	$Cnt = $row["Cnt"];

	if($userGubun == "주니어"){
		$arrGubunInfo['주니어'] += $Cnt;
	}else{
		$arrGubunInfo[$userGubun.'_'.$userSex] = $Cnt;
	}
}

$arrGubunSold = array();
//비기너
$arrGubunSold['비기너_남'] = 50;
$arrGubunSold['비기너_여'] = 50;

//롱보드 오픈
$arrGubunSold['롱보드(오픈)_남'] = 80;
$arrGubunSold['롱보드(오픈)_여'] = 80;

//숏보드 오픈
$arrGubunSold['숏보드(오픈)_남'] = 50;
$arrGubunSold['숏보드(오픈)_여'] = 50;

//롱보드 프로
$arrGubunSold['롱보드(프로)_남'] = 50;
$arrGubunSold['롱보드(프로)_여'] = 50;

//숏보드 프로
$arrGubunSold['숏보드(프로)_남'] = 50;
$arrGubunSold['숏보드(프로)_여'] = 50;
$arrGubunSold['주니어'] = 50;

$ChkuserGubun = "비기너";
$ChkuserSex = "여";
$resCnt = $arrGubunInfo[$ChkuserGubun.'_'.$ChkuserSex];
$resSoldCnt = $arrGubunSold[$ChkuserGubun.'_'.$ChkuserSex];

if($resCnt >= $resSoldCnt){ //마감
	$soldUse = 0;
}else{
	$soldUse = 1;
}


$chkResConfirm = $_REQUEST["chkResConfirm"];
$chkbusNum = $_REQUEST["chkbusNum"];
$chkResSex = $_REQUEST["chkResSex"];
$schText = trim($_REQUEST["schText"]);

$inResConfirm = "";
for($i = 0; $i < count($chkResConfirm); $i++){
	$inResConfirm .= $chkResConfirm[$i].',';
}
$inResConfirm .= '99';

$inResType = "";
for($i = 0; $i < count($chkbusNum); $i++){
	$inResType .= '"'.$chkbusNum[$i].'",';
}
$inResType .= '99';

$inResSex = "";
for($i = 0; $i < count($chkResSex); $i++){
	$inResSex .= '"'.$chkResSex[$i].'",';
}
$inResSex .= '99';

if($schText != ""){
	$schText = ' AND (MainNumber like "%'.$schText.'%" OR userName like "%'.$schText.'%" OR userPhone like "%'.$schText.'%")';
}

$select_query = 'SELECT * FROM `SURF_YANGFE_MAIN` WHERE ResConfirm IN ('.$inResConfirm.')
						AND userGubun IN ('.$inResType.')
						AND userSex IN ('.$inResSex.')'.$schText.' 
						ORDER BY intseq asc';

//echo $select_query;
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);
?>

    <div class="gg_first" style="padding-bottom:0px;">페스티벌 참가접수 현황</div>
    <table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:500px;">
        <tbody>
			<tr>
				<th>참관</th>
				<th>비기너</th>
				<th>주니어</th>
				<th></th>
			</tr>
			<tr>
				<td>남 : <strong><?=$arrGubunInfo['참관_남']?></strong> 명  / 여 : <strong><?=$arrGubunInfo['참관_여']?></strong> 명</td>
				<td>남 : <strong><?=$arrGubunInfo['비기너_남']?></strong> 명  / 여 : <strong><?=$arrGubunInfo['비기너_여']?></strong> 명</td>
				<td>통합 : <strong><?=$arrGubunInfo['주니어']?></strong> 명</td>
				<td></td>
			</tr>
			<tr>
				<th>롱보드(오픈)</th>
				<th>숏보드(오픈)</th>
				<th>롱보드(프로)</th>
				<th>숏보드(프로)</th>
			</tr>
			<tr>
				<td>남 : <strong><?=$arrGubunInfo['롱보드(오픈)_남']?></strong> 명  / 여 : <strong><?=$arrGubunInfo['롱보드(오픈)_여']?></strong> 명</td>
				<td>남 : <strong><?=$arrGubunInfo['숏보드(오픈)_남']?></strong> 명  / 여 : <strong><?=$arrGubunInfo['숏보드(오픈)_여']?></strong> 명</td>
				<td>남 : <strong><?=$arrGubunInfo['롱보드(프로)_남']?></strong> 명  / 여 : <strong><?=$arrGubunInfo['롱보드(프로)_여']?></strong> 명</td>
				<td>남 : <strong><?=$arrGubunInfo['숏보드(프로)_남']?></strong> 명  / 여 : <strong><?=$arrGubunInfo['숏보드(프로)_여']?></strong> 명</td>
			</tr>
        </tbody>
	</table>

<?
if($count == 0){
	echo '<div style="text-align:center;font-size:14px;padding:50px;">
				<b>예약된 정보가 없습니다.</b>
			</div>';
	return;
}
?>
	

<form name="frmConfirm" id="frmConfirm" autocomplete="off">
    <div class="gg_first" style="padding-bottom:5px;">2019 양양서핑 페스티벌 예약정보 <span style="font-size:12px;"><input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="엑셀다운" onclick="fnAdminExcel();" /></span></div>
    <table class="et_vars exForm bd_tb" style="margin-bottom:5px;width:100%;">
		<colgroup>
			<col style="width:30px;">
			<col style="width:50px;">
			<col style="width:100px;">
			<col style="width:170px;">
			<col style="width:140px;">
			<col style="width:50px;">
			<col style="width:100px;">
			<col style="width:300px;">
			<col style="width:100px;">
		</colgroup>
        <tbody>
			<tr>
				<th></th>
				<th>번호</th>
				<th>신청구분</th>
				<th>이름(연락처)</th>
				<th>소속</th>
				<th>성별</th>
				<th>차량번호</th>
				<th>비고</th>
				<th>상태</th>
			</tr>
<?
$i = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){
	$i++;
	$now = date("Y-m-d");
	$MainNumber = $row['MainNumber'];

	if($row['ResConfirm'] == 0){
		$ResConfirm = "미입금";
	}else if($row['ResConfirm'] == 1){
		$ResConfirm = "입금대기";
		$ResColor = "rescolor1";
	}else if($row['ResConfirm'] == 2){
		$ResConfirm = "확정";
	}else if($row['ResConfirm'] == 3){
		$ResConfirm = "취소";
		$ResColor = "rescolor2";
	}

?>
			<tr>
                <td style="text-align:center;">
					<input type="hidden" id="MainNumber" name="MainNumber" value="<?=$MainNumber?>">
					<label>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="bus@<?=$row['intseq']?>" style="vertical-align:-3px;" />
					</label>
				</td>
				<td><?=$i?></td>
				<td><?=$row['userGubun']?></td>
                <td><!--접수시간:<?=$row['insdate']?><br--><?=$row['userName']?><span style="display:;">  (<?=$row['userPhone']?>)</span></td>
				<td><?=$row['userClub']?></td>
				<td><?=$row['userSex']?></td>
				<td><?=str_replace('-', ' ', $row['userCarnum'])?></td>
				<td><textarea id="etc" name="etc" rows="3" style="width: 90%; resize:none;" disabled="disabled"><?=$row['Etc']?></textarea></td>
                <td style="text-align:center;">
					<select id="selConfirm" name="selConfirm[]" class="select" style="padding:1px 2px 4px 2px;" onchange="fnChangeModify(this, <?=$row['ResConfirm']?>);">
						<option value="0" <?if($row['ResConfirm'] == 0) echo "selected"?>>미입금</option>
						<option value="1" <?if($row['ResConfirm'] == 1) echo "selected"?>>입금대기</option>
						<option value="2" <?if($row['ResConfirm'] == 2) echo "selected"?>>확정</option>
						<option value="3" <?if($row['ResConfirm'] == 3) echo "selected"?>>취소</option>
					</select>
				</td>
            </tr>
<?
}
?>

            <tr>
                <td colspan="9" style="text-align:center;font-size:14px;padding:4px;">
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:80px; height:40px;" value="상태변경하기" onclick="fnConfirmUpdate(1, this);" />
				</td>
            </tr>
		</tbody>
	</table>
</form>
<form name="frmConfirmSel" id="frmConfirmSel" style="display:none;">
</form>