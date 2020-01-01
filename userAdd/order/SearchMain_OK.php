<?php 
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$resNumber = str_replace(' ', '', $_REQUEST["resNumber"]);

$gubun = substr($resNumber, 0, 1);

if($gubun == "1"){ //야영장

	$select_query = 'SELECT * FROM SURF_CAMPING_MAIN where MainNumber = "'.$resNumber.'" GROUP by MainNumber, sType';

}else if($gubun == "2"){ //서핑버스

	$select_query = 'SELECT a.*, b.ResBBQDate, b.ResBBQSalePrice, b.ResBBQ, b.ResBBQConfirm, b.intseq as bbqintSeq, b.RtnPrice FROM `SURF_BUS_MAIN` a LEFT JOIN `SURF_BBQ` as b ON a.MainNumber = b.MainNumber where a.MainNumber = "'.$resNumber.'"';

}else if($gubun == "3"){ //서프샵

	$select_query = 'SELECT *, TIMESTAMPDIFF(MINUTE, b.insdate, now()) as timeM FROM `SURF_SHOP_RES_MAIN` a LEFT JOIN `SURF_SHOP_RES_SUB` as b 
							ON a.MainNumber = b.MainNumber 
						INNER JOIN SURF_CODE as c
							ON cast(b.ResGubun as char(1)) = c.code
						where a.MainNumber = "'.$resNumber.'"
						ORDER BY a.MainNumber, b.subintseq';

}else{
	echo "<script>alert('예약된 정보가 없습니다.');fnResSel3();</script>";
	return;
}

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count == 0){
	echo "<script>alert('예약된 정보가 없습니다.');fnResSel3();</script>";
	return;
}else{
	echo "<script>fnResSel4();</script>";
}

echo '<form name="frmCancel" id="frmCancel">';

if($gubun == "1"){ //야영장

	include_once("SearchCamp.php");

}else if($gubun == "2"){ //서핑버스

	include_once("SearchBus.php");

}else if($gubun == "3"){ //서프샵

	include_once("SearchSurf.php");

}

echo '
	<div class="write_table" style="padding-top:5px;display:;">
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
	<div class="write_table" style="padding-top:5px;display:;">
	※ 취소신청 시간에 따라 환불수수료 예정금액과 차이가 있을 수 있습니다.
	</div>

	<span id="returnBank" style="display:none;">
    <div class="gg_first">환불 계좌</div>
    <table class="et_vars exForm bd_tb" style="width:100%">
        <tbody>
			<tr>
                <th style="text-align:center;">예금자명</th>
                <th style="text-align:center;">은행이름</th>
                <th style="text-align:center;">계좌번호</th>
            </tr>
			<tr>
				<td style="text-align:center;"><input type="hidden" id="bankUserName" name="bankUserName" value="'.$bankUserName.'" class="itx2" style="width:50px;">'.$bankUserName.'</td>
				<td style="text-align:center;">
					<input type="hidden" id="gubun" name="gubun" value="">
					<input type="hidden" id="hidtotalPrice" name="hidtotalPrice" value="0">
					<input type="hidden" id="resparam" name="resparam" value="Cancel">
					<input type="hidden" id="userId" name="userId" value="">
					<input type="hidden" id="MainNumber" name="MainNumber" value="">
					<input type="text" id="bankName" name="bankName" value="" class="itx2" style="width:80px;">
				</td>
				<td style="text-align:center;"><input type="text" id="bankNum" name="bankNum" value="" class="itx2" style="width:130px;"></td>
			</tr>
		</tbody>
	</table>
	</span>

	<div class="write_table" style="padding-top:15px; text-align:center;display:;">
		<input type="button" class="gg_btn gg_btn_grid large" style="width:140px; height:40px;color: #fff !important; background: #008000;" value="취소/환불 신청" onclick="fnRefund(0);" />&nbsp;
		<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:140px; height:40px;" value="돌아가기" onclick="fnResSel3();" />
	</div>


</form>';
?>