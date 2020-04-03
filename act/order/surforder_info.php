<?
$i = 1;
$couponPrice = 0;
$totalPrice = 0;
$shopbankview = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){
	$now = date("Y-m-d");

	$surfSeatInfo = "";
	$arrSeatInfo = array();

	$bankUserName = $row['user_name'];

	$chkView = 0;
	$datDate = $row['res_date'];
	if($datDate >= $now && $row['res_confirm'] == 3){
        $cancelDate = date("Y-m-d", strtotime($datDate." -1 day"));
        if($row['timeM'] <= 120 || $cancelDate > $now){
            $chkView = 1;
        }
	}
/*
예약상태
    0 : 미입금
    1 : 예약대기
    2 : 임시확정
    3 : 확정
    4 : 환불요청
    5 : 환불완료
    6 : 임시취소
    7 : 취소
*/
    $ResColor = "";
    $ResCss = "";
	if($row['res_confirm'] == 0){
		$ResConfirm = "미입금";
		$couponPrice += $row['res_price_coupon'];
		$totalPrice += $row['res_price'];
		$shopbankview++;
	}else if($row['res_confirm'] == 1 || $row['res_confirm'] == 2 || $row['res_confirm'] == 6){
		$ResConfirm = "입금완료";
		$ResColor = "rescolor2";
		$couponPrice += $row['res_price_coupon'];
		$totalPrice += $row['res_price'];
	}else if($row['res_confirm'] == 3){
		$ResConfirm = "확정";
		$ResColor = "rescolor1";
		$couponPrice += $row['res_price_coupon'];
		$totalPrice += $row['res_price'];
	}else if($row['ResConfirm'] == 4){
		$ResConfirm = "환불요청";
		$couponPrice += $row['res_price_coupon'];
        $totalPrice += $row['res_price'];
        
        $RtnTotalPrice += $row['rtn_totalprice']; //환불금액 표시
	}else if($row['ResConfirm'] == 5){
		$ResConfirm = "환불완료";
		$ResCss = "rescss";
		$couponPrice += $row['res_price_coupon'];
		$totalPrice += $row['res_price'];
	}else if($row['res_confirm'] == 7){
		$ResConfirm = "취소";
		$ResCss = "rescss";
	}

	if ($datDate < date("Y-m-d", strtotime($now." 0 day")))
	{
		$ResCss = "resper";
	}

	//============= 환불금액 구역 =============
	$RtnBank = '';
	if($row['res_confirm'] == 4 || $row['res_confirm'] == 5){
		$RtnBank = '<tr class="'.$ResCss.'" name="btnTrPoint">
						<td style="text-align:center;" colspan="2">'.str_replace('|', '&nbsp ', $row['rtn_bankinfo']).'</td>
						<td style="text-align:center;" colspan="2"> 환불액 : '.number_format($row['rtn_totalprice']).'원</td>
                    </tr>';
	}

	//============= 예약항목 구역 =============
	$TimeDate = "";
	// if($row['ResGubun'] == 0 || $row['ResGubun'] == 2){
	// 	$TimeDate = '(시간 : '.$row['ResTime'].')';
	// }else if($row['ResGubun'] == 3){
	// 	$TimeDate = '(기간 : '.$row['ResDay'].')';
	// }

	
    $ResNum = "";
    if($row['res_ea'] == 0){
        if($row['res_m'] > 0){
            $ResNum = "남:".$row['res_m'].'<br>';
        }

        if($row['res_w'] > 0){
            $ResNum .= "여:".$row['res_w'];
        }
    }else{
        $ResNum = "구매수:".$row['res_ea'];
    }

	if($i == 1){
?>
    <table class="et_vars exForm bd_tb">
        <tbody>
			<tr>
                <th>예약번호</th>
                <td width="100%"><strong><?=$row['res_num']?></strong><span style="display:none;"> (<?=$row['insdate']?>)</span></td>
            </tr>
			<tr>
                <th>예약자</th>
                <td><?=$row['user_name']?><span style="display:;">  (<?=$row['user_tel']?>)</span></td>
            </tr>
            <tr>
                <th colspan="2">[<?=$row['shopname']?> / <?=$row['code']?>] 예약정보</th>
            </tr>
			<tr>
				<td colspan="2">

    <table class="et_vars exForm bd_tb" style="width:100%">
        <tbody>
			<colgroup>
				<col style="width:100px;">
				<col style="width:*;">
				<col style="width:55px;">
				<col style="width:70px;">
			</colgroup>
			<tr>
                <th style="text-align:center;">이용일</th>
                <th style="text-align:center;">예약항목</th>
                <th style="text-align:center;">인원</th>
                <th style="text-align:center;">상태</th>
			</tr>
<?	}?>
			<tr class="<?=$ResCss?>">
                <td style="text-align:center;">
					<label>
				<?if($chkView == 1){?>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="<?=$row['ressubseq']?>" style="vertical-align:-3px;" onclick="fnCancelSum(this, 'surf', '<?=$row['res_num']?>');" />
				<?}else{?>
					<input type="checkbox" disabled="disabled" />
				<?}?>
					<?=$row['res_date']?>
					</label>
				</td>
                <td>[<?=$row['optname']?>] <?=$row['optsubname']?><br><span style="padding-left:40px;"><?=$TimeDate?></span></td>
                <td style="text-align:center;"><?=$ResNum?></td>
                <td style="text-align:center;" class="<?=$ResColor?>"><?=$ResConfirm?></td>
			</tr>
			<?=$RtnBank?>
<?
	if($i == $count){?>
		<?
		if($RtnTotalPrice > 0){
		?>
			<tr>
                <th style="text-align:center;">환불금액</th>
                <td style="text-align:left;padding-left:10px;" colspan="3"><b><?=number_format($RtnTotalPrice).'원'?></b></td>
            </tr>
		<?
		}
		?>
		</tbody>
	</table>
				</td>
			</tr>
			<tr>
                <th scope="row">결제금액</th>
                <td><b><?=number_format($totalPrice)?> 원</b></td>
            </tr>
			<?if($shopbankview > 0){?>
			<tr>
                <th scope="row">입금계좌</th>
                <td><?=$row['pay_info']?></td>
            </tr>
			<?}?>
			<?if(!($row['Etc'] == "")){?>
            <tr>
                <th scope="row">특이사항</th>
                <td><textarea id="etc" name="etc" rows="5" style="width: 90%; resize:none;" disabled="disabled"><?=$row['etc']?></textarea></td>
            </tr>
			<?}?>
		</tbody>
	</table>
<?
	}
	$i++;
}
?>