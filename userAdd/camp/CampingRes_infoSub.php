	<div class="gg_first campmove">예약자 신청정보 </div>
    <table class="et_vars exForm bd_tb">
        <tbody>
            <tr>
                <th scope="row"><em>*</em> 이름</th>
                <td width="100%">
                    <input type="text" id="userName" name="userName" value="" class="itx" maxlength="15">
                </td>
            </tr>
            <tr style="display:none;">
                <th scope="row"><em>*</em> 아이디</th>
                <td>
                    <input type="text" id="userId" name="userId" value="" class="itx" maxlength="30" readonly>
                </td>
            </tr>
            <tr>
                <th scope="row"><em>*</em> 연락처</th>
                <td>
                    <input type="number" name="userPhone1" id="userPhone1" value="" size="5" maxlength="3" class="tel itx" style="width:50px;" oninput="maxLengthCheck(this)"> - 
                    <input type="number" name="userPhone2" id="userPhone2" value="" size="6" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)"> - 
                    <input type="number" name="userPhone3" id="userPhone3" value="" size="6" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)">
                </td>
            </tr>
            <tr>
                <th scope="row"> 이메일</th>
                <td>
                    <input type="text" id="usermail" name="usermail" value="" class="itx">
                </td>
            </tr>
            <tr>
                <th scope="row">이용요금</th>
                <td>
                    <span id="totalPrice">0원</span>
                    <input type="hidden" id="priceType" name="priceType" value="1" />
                    <input type="hidden" id="priceSum" name="priceSum" value="0" />
                    <input type="hidden" id="gpriceSum" name="gpriceSum" value="0" />
                </td>
            </tr>
            <tr>
                <th scope="row">추가옵션</th>
                <td id="resOpt">
					전기사용은 1박에 5,000원 입니다.
				</td>
            </tr>
            <tr>
                <th scope="row">예약구분</th>
                <td id="resOpt">
					<input type="radio" id="restype1" name="restype1" value="온라인" class="itx" checked> 온라인예약 &nbsp; 
					<input type="radio" id="restype1" name="restype1" value="현장" class="itx"> 현장예약
                    <input type="hidden" id="hidrestype" name="hidrestype" value="온라인" />
				</td>
            </tr>
            <tr>
                <th scope="row">특이사항</th>
                <td>
                    <textarea name="etc" id="etc" rows="8" cols="42" style="margin: 0px; width: 97%; height: 100px;resize:none;"></textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<span style="display:none;">
	<input type="text" id="selDate" name="selDate" />
	<input type="text" id="selWeek" name="selWeek" />
	<input type="text" id="chkSeatSel" name="chkSeatSel" />
	<input type="text" id="chkOptSel" name="chkOptSel" />
	<input type="text" id="resparam" name="resparam" value="CampI" />
</span>

<?php
	include __DIR__.'/../db.php';

	$nextday = explode("-", $_REQUEST["selDate"]);
	$nextDate = date("Y-m-d", mktime(0, 0, 0, $nextday[1], $nextday[2], $nextday[0]));

	$select_query = 'SELECT sLocation FROM `SURF_CAMPING_SUB` where (sDate >= "'.$_REQUEST["selDate"].'" AND sDate < "'.date("Y-m-d", strtotime($nextDate." +".$_REQUEST["daynum"]." day")).'") AND DelUse = "N" AND ResConfirm IN (0, 1) GROUP BY sLocation';
	$result_setlist = mysqli_query($conn, $select_query);
?>

<script type="text/javascript">
    jQuery(document).ready(function () {
		var selDate = "<?=$_REQUEST["selDate"]?>";
		var weeknum = "<?=$_REQUEST["weeknum"]?>";
		
        jQuery("#userName").val(jQuery("#hiduserName").val());
        jQuery("#userId").val(jQuery("#hiduserId").val());
        jQuery("#userPhone1").val(jQuery("#hiduserPhone1").val());
        jQuery("#userPhone2").val(jQuery("#hiduserPhone2").val());
        jQuery("#userPhone3").val(jQuery("#hiduserPhone3").val());
        jQuery("#usermail").val(jQuery("#hidusermail").val());

		fnCalClick(selDate, weeknum, <?=$_REQUEST["daynum"]?>);
		
<?
	while ($row = mysqli_fetch_assoc($result_setlist)){
		echo 'jQuery("#seat'.$row['sLocation'].' input").attr("disabled", true);';
		echo 'jQuery("#seat'.$row['sLocation'].' img").attr("src", "https://surfenjoy.cdn3.cafe24.com/camp/t_02.jpg");';
	}
?>
    });
</script>