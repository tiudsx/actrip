<div class="gg_first">예약정보 <span style="font-size:11px;"></span></div>
<?
$i = 1;
$totalPrice = 0;
$shopbankview = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){
	$chkView = 0;
	$now = date("Y-m-d");

	$surfSeatInfo = "";
	$arrSeatInfo = array();

	$ResColor = "";
	$ResCss = "";
	$RtnPrice = "";
	$chkView = 0;
	$bankUserName = $row['userName'];

	$datDate = substr($row['ResDate'], 0, 10);
	if($datDate >= $now){
		if($row['ResConfirm'] == 0){
			$chkView = 1;
		} else if($row['ResConfirm'] == 5 || $row['ResConfirm'] == 2 || $row['ResConfirm'] == 3 || $row['ResConfirm'] == 4){
			$cancelDate = date("Y-m-d", strtotime($datDate." -1 day"));
			if($row['timeM'] <= 120 || $cancelDate > $now){
				$chkView = 1;
			}else{
				$chkView = 0;
			}
		}
	}

/*
예약구분
-----------
0	미입금
1	취소
2	예약대기
3	임시확정
4	임시취소
5	확정
6	환불요청
7	환불완료
*/

	if($row['ResConfirm'] == 0){
		$ResConfirm = "미입금";
		$totalPrice += $row['ResPrice'];
		$shopbankview++;
	}else if($row['ResConfirm'] == 1){
		$ResConfirm = "취소";
		$ResCss = "rescss";
	}else if($row['ResConfirm'] == 2 || $row['ResConfirm'] == 3 || $row['ResConfirm'] == 4){
		$ResConfirm = "입금완료";
		$ResColor = "rescolor2";
		$totalPrice += $row['ResPrice'];
	}else if($row['ResConfirm'] == 5){
		$ResConfirm = "확정";
		$ResColor = "rescolor1";
		$totalPrice += $row['ResPrice'];
	}else if($row['ResConfirm'] == 6){
		$ResConfirm = "환불요청";
		$totalPrice += $row['ResPrice'];
	}else if($row['ResConfirm'] == 7){
		$ResConfirm = "환불완료";
		$ResCss = "rescss";
		$totalPrice += $row['ResPrice'];
	}

	if($row['RtnPrice'] > 0){
		$RtnPrice = '<br>('.number_format($row['RtnPrice']).'원)';
	}

	if ($datDate < date("Y-m-d", strtotime($now." 0 day")))
	{
		$ResCss = "resper";
	}

	//============= 환불금액 구역 =============
	$RtnBank = '';

	if($row['ResConfirm'] == 6 || $row['ResConfirm'] == 7){
		$RtnPrice = ''.number_format($row['RtnSumPrice']).'원';
		$RtnBank = '<tr class="'.$ResCss.'" name="btnTrPoint">
						<td style="text-align:center;" colspan="2">'.str_replace('|', '&nbsp ', $row['RtnBank']).'</td>
						<td style="text-align:center;" colspan="2"> 환불액 : '.$RtnPrice.'</td>
					</tr>';
	}

	if($row['ResConfirm'] == 6){
		$RtnTotalPrice += $row['RtnSumPrice'];
	}

	//============= 예약항목 구역 =============
	$TimeDate = "";
	if($row['ResGubun'] == 0 || $row['ResGubun'] == 2){
		$TimeDate = '(시간 : '.$row['ResTime'].')';
	}else if($row['ResGubun'] == 3){
		$TimeDate = '(기간 : '.$row['ResDay'].')';
	}

	
	$ResNum = "";
	if($row['ResNumM'] > 0){
		$ResNum = "남:".$row['ResNumM'].'<br>';
	}

	if($row['ResNumW'] > 0){
		$ResNum .= "여:".$row['ResNumW'];
	}

	if($i == 1){
?>
    <table class="et_vars exForm bd_tb">
        <tbody>
			<tr>
                <th>예약번호</th>
                <td width="100%"><strong><?=$row['MainNumber']?></strong><span style="display:none;"> (<?=$row['insdate']?>)</span></td>
            </tr>
			<tr>
                <th>예약자</th>
                <td><?=$row['userName']?><span style="display:;">  (<?=$row['userPhone']?>)</span></td>
            </tr>
            <tr>
                <th colspan="2">[<?=$row['shopCode']?>] 예약정보</th>
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
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="<?=$row['subintseq']?>" style="vertical-align:-3px;" onclick="fnCancelSum(this, 'surf', '<?=$row['MainNumber']?>');" />
				<?}else{?>
					<input type="checkbox" disabled="disabled" />
				<?}?>
					<?=$row['ResDate']?>
					</label>
				</td>

			<?if($row['ResGubun'] == 2){?>
                <td><?=$row['ResDay']?> <span style="padding-left:0px;"><?=$TimeDate?></span></td>
			<?}else{?>
                <td>[<?=$row['codename']?>] <?=$row['ResOptName']?><br><span style="padding-left:40px;"><?=$TimeDate?></span></td>
			<?}?>

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
                <td><?=$row['shopbank']?></td>
            </tr>
			<?}?>
			<?if(!($row['Etc'] == "")){?>
            <tr>
                <th scope="row">특이사항</th>
                <td><textarea id="etc" name="etc" rows="5" style="width: 90%; resize:none;" disabled="disabled"><?=$row['Etc']?></textarea></td>
            </tr>
			<?}?>
		</tbody>
	</table>
<?
	}
	$i++;
}
?>