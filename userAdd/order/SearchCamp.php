<div class="gg_first">죽도 야영장 예약정보 <span style="font-size:11px;"></span></div>
<?
while ($row = mysqli_fetch_assoc($result_setlist)){
	$chkView = 0;
	$now = date("Y-m-d");
	//$now = date("Y-m-d", strtotime(date("Y-m-d")." +1 day"));


	$select_query_sub = 'SELECT *, TIMESTAMPDIFF(MINUTE, insdate, now()) as timeM FROM SURF_CAMPING_SUB where MainNumber = "'.$row["MainNumber"].'" ORDER BY sDate';
	$resultSite = mysqli_query($conn, $select_query_sub);

	$siteType = "죽도야영장";
	$siteBank = "(농협 / 351-0962-8484-73 / 두창시변리마을회)";
	if($row["sType"] == "A"){
		$siteType = "죽도글램핑";
		$siteBank = "(신한은행 / 01044370009 / 이승철)";
	}

	$bankUserName = $row['userName'];
?>
    <table class="et_vars exForm bd_tb">
        <tbody>
			<tr>
                <th scope="row">예약번호</th>
                <td width="100%"><?=$siteType?> <strong>(<?=$row['MainNumber']?>)</strong></td>
            </tr>
            <tr>
                <th scope="row">예약자</th>
                <td><?=$row['userName']?> (<?=$row['userPhone']?>)</td>
            </tr>
			<tr>
                <th scope="row">이용일</th>
                <td width="100%">입실 : <?=substr($row['sDate'], 0, 10)?> 오후 2시 ~<br>퇴실 : <?=substr($row['eDate'], 0, 10)?> 오후 12시까지</td>
            </tr>
			<tr>
				<td colspan="2">

    <table class="et_vars exForm bd_tb" style="width:100%">
        <tbody>
			<colgroup>
				<col style="width:100px;">
				<col style="width:*;">
				<col style="width:50px;">
				<col style="width:*;">
			</colgroup>
			<tr>
                <th style="text-align:center;">이용일</th>
                <th style="text-align:center;">구역</th>
                <th style="text-align:center;">옵션</th>
                <th style="text-align:center;">상태</th>
			</tr>

	<?
/*
예약구분
-----------
0	미입금
1	확정
2	취소
3	환불요청
4	환불완료
*/

	$totalPrice = 0;
	$btnType = $row["ResConfirm"];
	while ($rowSub = mysqli_fetch_assoc($resultSite)){

		$ResCss = "";

		$arrOpt = explode("@",$rowSub['ResOptPrice']);

		if($rowSub['ResConfirm'] == 0){
			$ResConfirm = "미입금";
			$totalPrice += $rowSub['ResPrice'] + $arrOpt[2];
		}else if($rowSub['ResConfirm'] == 1){
			$ResConfirm = "확정";
			$totalPrice += $rowSub['ResPrice'] + $arrOpt[2];
		}else if($rowSub['ResConfirm'] == 2){
			$ResConfirm = "취소";
			$ResCss = "rescss";
		}else if($rowSub['ResConfirm'] == 3){
			$ResConfirm = "환불요청";
			$totalPrice += $rowSub['ResPrice'] + $arrOpt[2];
		}else if($rowSub['ResConfirm'] == 4){
			$ResConfirm = "환불완료";
			$totalPrice += $rowSub['ResPrice'] + $arrOpt[2];
			$ResCss = "rescss";
		}

		$sDate = substr($rowSub['sDate'], 0, 10);

		if ($sDate < date("Y-m-d", strtotime($now." 0 day")))
		{
			$ResCss = "resper";
		}

		if($rowSub['ResConfirm'] == "0"){
			$chkView = 1;
		}else if($rowSub['ResConfirm'] == "1"){
			if($sDate >= $now){
				$cancelDate = date("Y-m-d", strtotime($sDate." -1 day"));
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
							<td style="text-align:center;" colspan="2">'.str_replace('|', '&nbsp ', $rowSub['RtnBank']).'</td>
							<td style="text-align:center;" colspan="2"> 환불액 : '.$RtnPrice.'</td>
						</tr>';
		}

		if($rowSub['ResConfirm'] == 3){
			$RtnTotalPrice += $rowSub['RtnSumPrice'];
		}
		?>
			<tr class="<?=$ResCss?>">
                <td style="text-align:center;">
					<label>
				<?if($chkView == 1){?>
					<input type="checkbox" id="chkCancel" name="chkCancel[]" value="<?=$rowSub['subintseq']?>" style="vertical-align:-3px;" onclick="fnCancelSum(this, 'camp', '<?=$row['MainNumber']?>');" />
				<?}else{?>
					<input type="checkbox" disabled="disabled" />
				<?}?>
					<?=$rowSub['sDate']?>
					</label>
				</td>
                <td style="text-align:center;"><strong><?=$rowSub['sLocation']?></strong></td>
                <td style="text-align:center;"><?=$arrOpt[1]?></td>
                <td style="text-align:center;"><?=$ResConfirm?></td>
            </tr>
			<?=$RtnBank?>

	<?
	}
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