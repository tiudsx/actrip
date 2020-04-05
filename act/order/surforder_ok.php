<?php 
include __DIR__.'/../db.php';
include __DIR__.'/../surf/surffunc.php';


$resNumber = str_replace(' ', '', $_REQUEST["resNumber"]);

$gubun = substr($resNumber, 0, 1);

$select_query = 'SELECT *, a.resnum as res_num, TIMESTAMPDIFF(MINUTE, b.insdate, now()) as timeM FROM `AT_RES_MAIN` a LEFT JOIN `AT_RES_SUB` as b 
ON a.resnum = b.resnum 
where a.resnum = "'.$resNumber.'"
ORDER BY a.resnum, b.ressubseq';

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count == 0){
	echo "<script>alert('예약된 정보가 없습니다.');fnResSel3();</script>";
	return;
}else{
	echo "<script>fnOrderDisplay(1);</script>";
}

echo '<form name="frmCancel" id="frmCancel" target="ifrmResize" autocomplete="off">';

include_once("surforder_info.php");

echo '
	<div class="write_table" style="padding-top:2px;padding-bottom:15px;">
	※ 이용 1일전에는 취소/환불이 안됩니다.
	</div>

    <div class="gg_first">취소/환불 수수료 예정금액</div>
    <table class="et_vars exForm bd_tb" style="width:100%">
        <tbody>
			<tr>
                <th style="text-align:center;">총 이용금액</th>
                <th style="text-align:center;">환불수수료</th>
                <th style="text-align:center;">환불금액</th>
            </tr>
			<tr>
				<td style="text-align:center;"><span id="tdCancel1">0</span> 원</td>
				<td style="text-align:center;"><span id="tdCancel2">0</span> 원</td>
				<td style="text-align:center;"><span id="tdCancel3">0</span> 원</td>
			</tr>
		</tbody>
	</table>
	<div class="write_table" style="padding-top:5px;padding-bottom:15px;">
	※ 취소신청 시간에 따라 환불수수료 예정금액과 차이가 있을 수 있습니다.
	</div>

	<span id="returnBank" style="display:none;">
    <div class="gg_first">환불 계좌 <span style="font-weight:100;font-size:12px;font-family:Tahoma,Geneva,sans-serif;">(예약자와 동일한 명의의 계좌번호로 환불가능합니다.)</span></div>
    <table class="et_vars exForm bd_tb" style="width:100%">
        <tbody>
			<tr>
                <th style="text-align:center;">예금자명</th>
                <th style="text-align:center;">은행이름</th>
                <th style="text-align:center;">계좌번호</th>
            </tr>
			<tr>
				<td style="text-align:center;"><input type="hidden" id="bankUserName" name="bankUserName" value="'.$bankUserName.'" class="itx" style="width:50px;">'.$bankUserName.'</td>
				<td style="text-align:center;">
					<input type="hidden" id="gubun" name="gubun" value="">
					<input type="hidden" id="hidtotalPrice" name="hidtotalPrice" value="0">
					<input type="hidden" id="resparam" name="resparam" value="Cancel">
					<input type="hidden" id="userId" name="userId" value="">
					<input type="hidden" id="MainNumber" name="MainNumber" value="">
					<input type="text" id="bankName" name="bankName" value="" class="itx" style="width:80px;">
				</td>
				<td style="text-align:center;"><input type="text" id="bankNum" name="bankNum" value="" class="itx" style="width:130px;"></td>
			</tr>
		</tbody>
	</table>
	</span>

	<div class="write_table" style="padding-top:15px; text-align:center;display:;">
		<input type="button" class="gg_btn gg_btn_grid large" style="width:140px; height:40px;color: #fff !important; background: #008000;" value="취소/환불 신청" onclick="fnRefund(0);" />&nbsp;
		<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:140px; height:40px;" value="돌아가기" onclick="fnOrderDisplay(0);" />
	</div>
</form>';
?>