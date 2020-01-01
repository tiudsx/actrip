<div class="gg_first">양양셔틀버스  예약정보 <span style="font-size:11px;"></span></div>
<?
while ($row = mysqli_fetch_assoc($result_setlist)){
	$chkView = 0;
	$now = date("Y-m-d");

	$bankUserName = $row['userName'];

	$select_query_sub = 'SELECT *, TIMESTAMPDIFF(MINUTE, insdate, now()) as timeM FROM `SURF_BUS_SUB` where MainNumber = "'.$row["MainNumber"].'" ORDER BY busDate, LEFT(busNum, 1) DESC,  RIGHT(busNum, 1), busSeat';
	$resultSite = mysqli_query($conn, $select_query_sub);
	$busSeatInfo = "";
	$arrSeatInfo = array();
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
                <th colspan="2">양양셔틀버스 좌석정보</th>
            </tr>
			<tr>
				<td colspan="2">

    <table class="et_vars exForm bd_tb" style="width:100%">
        <tbody>
			<colgroup>
				<col style="width:80px;">
				<col style="width:80px;">
				<col style="width:80px;">
				<col style="width:80px;">
				<col style="width:*;">
			</colgroup>
			<tr>
                <th style="text-align:center;" rowspan="2">이용일</th>
                <th style="text-align:center;">호차</th>
                <th style="text-align:center;">좌석</th>
                <th style="text-align:center;" rowspan="2">상태</th>
			</tr>
			<tr>
                <th style="text-align:center;" colspan="2">출발/도착 정류장</th>
			</tr>
<?
	$totalPrice = 0;
	while ($rowSub = mysqli_fetch_assoc($resultSite)){
		$ResColor = "";
		$ResCss = "";

		if($rowSub['ResConfirm'] == 0){
			$ResConfirm = "미입금";
			$totalPrice += $rowSub['ResPrice'];
		}else if($rowSub['ResConfirm'] == 1){
			$ResConfirm = "확정";
			$ResColor = "rescolor1";
			$totalPrice += $rowSub['ResPrice'];
		}else if($rowSub['ResConfirm'] == 2){
			$ResConfirm = "취소";
			$ResCss = "rescss";
		}else if($rowSub['ResConfirm'] == 3){
			$ResConfirm = "환불요청";
			$totalPrice += $rowSub['ResPrice'];
			$ResColor = "rescolor2";
		}else if($rowSub['ResConfirm'] == 4){
			$ResConfirm = "환불완료";
			$totalPrice += $rowSub['ResPrice'];
			$ResCss = "rescss";
		}

		$datDate = substr($rowSub['busDate'], 0, 10);

		if ($datDate < date("Y-m-d", strtotime($now." 0 day")))
		{
			$ResCss = "resper";
		}

		if($rowSub['ResConfirm'] == 0){
			$chkView = 1;
		} else if($rowSub['ResConfirm'] == 1){
			if($datDate >= $now){
				$cancelDate = date("Y-m-d", strtotime($datDate." -1 day"));
				if($rowSub['timeM'] <= 130 || $cancelDate > $now){
					$chkView = 1;
				}else{
					$chkView = 0;
				}
			}
		}

		$RtnBank = '';
		
		if($rowSub['ResConfirm'] == 3 || $rowSub['ResConfirm'] == 4){
			$RtnPrice = ''.number_format($rowSub['RtnSumPrice']).'원';
			$RtnBank = '<tr class="'.$ResCss.'" name="btnTrPoint">
							<td style="text-align:center;" colspan="4">'.str_replace('|', '&nbsp ', $rowSub['RtnBank']).' <b>(환불액 : '.$RtnPrice.')</b></td>
						</tr>';
		}

		if($rowSub['ResConfirm'] == 3){
			$RtnTotalPrice += $rowSub['RtnSumPrice'];
		}
?>
			<tr class="<?=$ResCss?>">
                <td style="text-align:center;" rowspan="2">
					<label>
				<?if($chkView == 1){?>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="bus@<?=$rowSub['subintseq']?>" style="vertical-align:-3px;" onclick="fnCancelSum(this, 'bus', '<?=$row['MainNumber']?>');" />
				<?}else{?>
					<input type="checkbox" disabled="disabled" />
				<?}?>
					<?=$rowSub['busDate']?>
					</label>
				</td>
                <td style="text-align:center;"><?=fnBusNum($rowSub['busNum'])?></td>
                <td style="text-align:center;"><?=$rowSub['busSeat']?> 번</td>
                <td style="text-align:center;" rowspan="2">
					<strong class="<?=$ResColor?>"><?=$ResConfirm?> </strong>
				</td>
            </tr>
			<tr class="<?=$ResCss?>">
                <td style="text-align:center;" colspan="2"><?=$rowSub['sLocation']?> -> <?=$rowSub['eLocation']?></td>
            </tr>
			<?=$RtnBank?>
<?
	}
?>
			<!--tr>
                <th style="text-align:center;">이용요금</th>
                <td colspan="3"><b><?=number_format($row['ResPrice'])?> 원</b></td>
            </tr-->
		</tbody>
	</table>
				</td>
			</tr>

		<?
		if($row['ResBBQ'] > 0){
			$ResColor = "";
			$ResCss = "";
			$RtnPrice = "";
			$chkViewBBq = 0;
			$datDate = substr($row['ResBBQDate'], 0, 10);
			if($datDate >= $now){
				if($row['ResBBQConfirm'] == 0){
					$chkViewBBq = 1;
				} else if($row['ResBBQConfirm'] == 1){
					$cancelDate = date("Y-m-d", strtotime($datDate." -1 day"));
					if($cancelDate > $now){
						$chkViewBBq = 1;
					}else{
						$chkViewBBq = 2;
					}
				}
			}

			if($row['ResBBQConfirm'] == 0){
				$ResConfirm = "미입금";
			}else if($row['ResBBQConfirm'] == 1){
				$ResConfirm = "예약완료";
				$ResColor = "rescolor1";
			}else if($row['ResBBQConfirm'] == 2){
				$ResConfirm = "취소";
				$ResColor = "rescolor2";
			}else if($row['ResBBQConfirm'] == 3){
				$ResConfirm = "환불요청";
				$ResCss = "rescss";
			}else if($rowSub['ResConfirm'] == 4){
				$ResConfirm = "환불완료";
				$ResColor = "rescolor2";
			}

			if($row['RtnPrice'] > 0){
				$RtnPrice = '<br>('.number_format($row['RtnPrice']).'원)';
			}

			if ($datDate < $now)
			{
				$ResCss = "resper";
			}

			$cancelPrice = cancelPrice($row['ResBBQDate'], $row['insdate'], $row['ResBBQSalePrice'], 2, $row['ResBBQConfirm']);
		?>
            <tr>
                <th colspan="2">죽도해변 루프탑 바베큐 파티</th>
            </tr>
			<tr>
                <td colspan="2">
    <table class="et_vars exForm bd_tb" style="width:100%">
        <tbody>
			<colgroup>
				<col style="width:*;">
				<col style="width:*;">
				<col style="width:*;">
				<col style="width:*;">
			</colgroup>
			<tr>
                <th style="text-align:center;">이용일</th>
                <th style="text-align:center;">인원</th>
                <th style="text-align:center;">이용요금</th>
                <th style="text-align:center;">상태</th>
			</tr>
			<tr class="<?=$ResCss?>">
                <td style="text-align:center;">
					<label>
				<?if($chkViewBBq == 1){?>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="bbq@<?=$row['bbqintSeq']?>" style="vertical-align:-3px;" onclick="fnCancelSum(this, 'bbq', '<?=$row['MainNumber']?>');" />
				<?}else{?>
					<input type="checkbox" disabled="disabled" />
				<?}?>
				<?=$row['ResBBQDate']?>
					</label>
				</td>
                <td style="text-align:center;"><?=$row['ResBBQ']?> 명</td>
                <td style="text-align:center;"> <?=number_format($row['ResBBQSalePrice'])?> 원</td>
                <td style="text-align:center;" rowspan="2">
					<strong class="<?=$ResColor?>"><?=$ResConfirm?> </strong><?=$RtnPrice?>
				</td>
            </tr>
		</tbody>
	</table>

				</td>
            </tr>
		<?}?>

			<tr>
                <th scope="row">결제금액</th>
                <td><b><?=number_format($totalPrice)?>원</b></td>
            </tr>
			<?if(!($row['Etc'] == "")){?>
            <tr>
                <th scope="row">특이사항</th>
                <td><textarea id="etc" name="etc" rows="3" style="width: 90%; resize:none;" disabled="disabled"><?=$row['Etc']?></textarea></td>
            </tr>
			<?}?>
		</tbody>
	</table>
<?
}
?>