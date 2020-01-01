<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';

$select_query = "SELECT a.*, b.shopname FROM SURF_SMS as a LEFT JOIN SURF_SHOP as b ON a.shopSeq = b.intseq";
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

//서핑버스 미입금 목록
$select_bus = "SELECT * FROM SURF_BUS_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price FROM `SURF_BUS_SUB` WHERE ResConfirm = 0 GROUP BY MainNumber) as b
					ON a.MainNumber = b.MainNumber
					ORDER BY b.MainNumber";
$result_bus = mysqli_query($conn, $select_bus);
$cntbus = mysqli_num_rows($result_bus);


//야영장 미입금 목록
$select_camp = "SELECT a.userName, a.userPhone, a.insdate, b.*, (price + opt) as totalsum FROM SURF_CAMPING_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price, SUM(CASE WHEN ResOptPrice = '1@전기@5000' THEN 5000 ELSE 0 END) AS opt FROM `SURF_CAMPING_SUB` WHERE ResConfirm = 0 GROUP BY MainNumber) as b 
								ON a.MainNumber = b.MainNumber
								ORDER BY b.MainNumber";
$result_camp = mysqli_query($conn, $select_camp);
$cntcamp = mysqli_num_rows($result_camp);


//죽도해변 바베큐 미입금 목록
$select_bbq = "SELECT a.shopCode, a.shopSeq, a.userName, a.userName, a.userPhone, a.userMail, a.Etc, a.memo, a.insdate, b.* FROM SURF_SHOP_RES_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price FROM SURF_SHOP_RES_SUB WHERE ResConfirm = 0 GROUP BY MainNumber) as b 
								ON a.MainNumber = b.MainNumber 
								WHERE a.shopSeq = 5
								ORDER BY b.MainNumber";
$result_bbq = mysqli_query($conn, $select_bbq);
$cntbbq = mysqli_num_rows($result_bbq);


//서핑샵 미입금 목록
$select_shop = "SELECT a.shopCode, a.shopSeq, a.userName, a.userName, a.userPhone, a.userMail, a.Etc, a.memo, a.insdate, b.* FROM SURF_SHOP_RES_MAIN as a INNER JOIN (SELECT MainNumber, SUM(ResPrice) as price FROM SURF_SHOP_RES_SUB WHERE ResConfirm = 0 GROUP BY MainNumber) as b 
								ON a.MainNumber = b.MainNumber 
								WHERE a.shopSeq != 5
								ORDER BY a.shopSeq, b.MainNumber";
$result_shop = mysqli_query($conn, $select_shop);
$cntshop = mysqli_num_rows($result_shop);
?>

<link rel="stylesheet" type="text/css" href="surfbus_admin.css" />
<script src="surfbus_admin.js"></script>

<script>
function fnMatch(obj, seq){
	$j(obj).prev().val($j.trim($j(obj).prev().val()));
	if($j(obj).prev().val() == ""){
		alert("매칭할 주문번호를 입력하세요.");
		return;
	}else{
		var msg = "입금완료 처리 하시겠습니까?";
		if (confirm(msg)) {

			var params = "resparam=matching&MainNumber=" + $j(obj).prev().val() + "&seq=" + seq + "&gubun=" + $j("#selGubun").val();
			jQuery.ajax({
				type: "POST",
				url: "/userAdd/surfingbus/Admin_AutoBankSave.php",
				data: params,
				success: function (data) {
					if (data == "0") {
						alert("정상적으로 처리되었습니다.");
						location.reload();
					} else if (data == "err") {
						alert("처리중 오류가 발생하였습니다.");
					} else {
						alert("처리중 오류가 발생하였습니다.");
					}
				}
			});
		}

	}
}

function fnSmsDel(obj, seq){
	var msg = "선택하신 문자내용을 삭제하시겠습니까?";
	if (confirm(msg)) {

		var params = "resparam=smsdel&seq=" + seq;
		jQuery.ajax({
			type: "POST",
			url: "/userAdd/surfingbus/Admin_AutoBankSave.php",
			data: params,
			success: function (data) {
				if (data == "0") {
					alert("정상적으로 처리되었습니다.");
					location.reload();
				} else if (data == "err") {
					alert("처리중 오류가 발생하였습니다.");
				} else {
					alert("처리중 오류가 발생하였습니다.");
				}
			}
		});
	}

}
</script>

<meta name="viewport" content="width=device-width, initial-scale=0.6, minimum-scale=0.5, maximum-scale=1, user-scalable=yes" />

<div class="bd_tl" style="width:100%;display:none;">
	<h1 class="ngeb clear"><i class="bg_color"></i>자동입금내역 - 미처리건</h1>
</div>

<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <ul class="tabs">
        <li class="active" rel="tab1">미처리건</li>
        <li rel="tab2">처리완료</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <!-- #tab1 -->
        <div id="tab1" class="tab_content">
		<form name="frmSearch" id="frmSearch" autocomplete="off">
			<div class="gg_first" style="margin-top:0px;">SMS 목록</div>
			<table class='et_vars exForm bd_tb' style="width:100%">
				<colgroup>
					<col style="width:45px;">
					<col style="width:*;">
					<col style="width:45px;">
					<col style="width:110px;">
					<col style="width:78px;">
					<col style="width:*;">
					<col style="width:180px;">
				</colgroup>
				<tr>
					<th style="text-align:center;">seq</th>
					<th style="text-align:center;">SMS 내용</th>
					<th style="text-align:center;">은행</th>
					<th style="text-align:center;">계좌번호</th>
					<th style="text-align:center;">입금자명</th>
					<th style="text-align:center;">결과</th>
					<th style="text-align:center;">매칭 주문번호</th>
				</tr>
				<?if($count == 0){?>
				<tr>
					<td colspan="8">					
						<div style="text-align:center;font-size:14px;padding:50px;" id="initText2">
							<b> 미처리건이 없습니다.</b>
						</div>
					</td>
				</tr>
				<?
				}else{
					while ($row = mysqli_fetch_assoc($result_setlist)){
				?>
				<tr>
					<td style="text-align:center;">
						<?=$row["seq"]?><br>
						<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:40px; height:22px;" value="삭제" onclick="fnSmsDel(this, <?=$row["seq"]?>);" />
					</td>
					<td><?=$row["smscontent"]?></td>
					<td style="text-align:center;"><?=$row["bankname"]?></td>
					<td style="text-align:center;"><?=$row["banknum"]?></td>
					<td style="text-align:center;"><?=$row["bankuser"]?><br>(<?=number_format($row["bankprice"])?>원)</td>
					<td><?=$row["MainNumberList"]?><br><?=$row["shopname"]?></td>
					<td style="text-align:center;">
					<select id="selGubun" name="selGubun" class="select" style="padding:1px 2px 4px 2px;">
						<option value="surfbus">서핑버스</option>
						<option value="surfbbq">바베큐</option>
						<option value="camp">야영장</option>
						<option value="surfshop">서핑샵</option>
					</select>
					<br>
					<input type="text" id="strMainNumber" name="strMainNumber" value="" class="itx2" style="width:90px;">
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:40px; height:22px;" value="매칭" onclick="fnMatch(this, <?=$row["seq"]?>);" /></td>
				</tr>
				<?
					}
				}
				?>
			</table>
		</form>

			<div class="gg_first" style="margin-top:10px;">서핑버스 미입금</div>
			<table class='et_vars exForm bd_tb'>
				<colgroup>
					<col style="width:110px;">
					<col style="width:55px;">
					<col style="width:110px;">
					<col style="width:80px;">
					<col style="width:140px;">
				</colgroup>
				<tr>
					<th style="text-align:center;">주문번호</th>
					<th style="text-align:center;">주문자</th>
					<th style="text-align:center;">연락처</th>
					<th style="text-align:center;">예약금액</th>
					<th style="text-align:center;">예약시간</th>
				</tr>
				<?if($cntbus == 0){?>
				<tr>
					<td colspan="5">					
						<div style="text-align:center;font-size:14px;padding:20px;" id="initText2">
							<b> 미입금 내역이 없습니다.</b>
						</div>
					</td>
				</tr>
				<?
				}else{
					while ($row = mysqli_fetch_assoc($result_bus)){
				?>
				<tr>
					<td style="text-align:center;"><?=$row["MainNumber"]?></td>
					<td style="text-align:center;"><?=$row["userName"]?></td>
					<td style="text-align:center;"><?=$row["userPhone"]?></td>
					<td style="text-align:center;"><?=number_format($row["price"])?>원</td>
					<td style="text-align:center;"><?=$row["insdate"]?></td>
				</tr>
				<?
					}
				}
				?>
			</table>


			<div class="gg_first" style="margin-top:10px;">죽도해변 바베큐 미입금</div>
			<table class='et_vars exForm bd_tb'>
				<colgroup>
					<col style="width:110px;">
					<col style="width:55px;">
					<col style="width:110px;">
					<col style="width:80px;">
					<col style="width:140px;">
				</colgroup>
				<tr>
					<th style="text-align:center;">주문번호</th>
					<th style="text-align:center;">주문자</th>
					<th style="text-align:center;">연락처</th>
					<th style="text-align:center;">예약금액</th>
					<th style="text-align:center;">예약시간</th>
				</tr>
				<?if($cntbbq == 0){?>
				<tr>
					<td colspan="5">					
						<div style="text-align:center;font-size:14px;padding:20px;" id="initText2">
							<b> 미입금 내역이 없습니다.</b>
						</div>
					</td>
				</tr>
				<?
				}else{
					while ($row = mysqli_fetch_assoc($result_bbq)){
				?>
				<tr>
					<td style="text-align:center;"><?=$row["MainNumber"]?></td>
					<td style="text-align:center;"><?=$row["userName"]?></td>
					<td style="text-align:center;"><?=$row["userPhone"]?></td>
					<td style="text-align:center;"><?=number_format($row["price"])?>원</td>
					<td style="text-align:center;"><?=$row["insdate"]?></td>
				</tr>
				<?
					}
				}
				?>
			</table>


			<div class="gg_first" style="margin-top:10px;">야영장 미입금</div>
			<table class='et_vars exForm bd_tb'>
				<colgroup>
					<col style="width:110px;">
					<col style="width:55px;">
					<col style="width:110px;">
					<col style="width:80px;">
					<col style="width:80px;">
					<col style="width:80px;">
					<col style="width:140px;">
				</colgroup>
				<tr>
					<th style="text-align:center;">주문번호</th>
					<th style="text-align:center;">주문자</th>
					<th style="text-align:center;">연락처</th>
					<th style="text-align:center;">사이트</th>
					<th style="text-align:center;">전기</th>
					<th style="text-align:center;">총금액</th>
					<th style="text-align:center;">예약시간</th>
				</tr>
				<?if($cntcamp == 0){?>
				<tr>
					<td colspan="7">					
						<div style="text-align:center;font-size:14px;padding:20px;" id="initText2">
							<b> 미입금 내역이 없습니다.</b>
						</div>
					</td>
				</tr>
				<?
				}else{
					while ($row = mysqli_fetch_assoc($result_camp)){
				?>
				<tr>
					<td style="text-align:center;"><?=$row["MainNumber"]?></td>
					<td style="text-align:center;"><?=$row["userName"]?></td>
					<td style="text-align:center;"><?=$row["userPhone"]?></td>
					<td style="text-align:center;"><?=number_format($row["price"])?>원</td>
					<td style="text-align:center;"><?=number_format($row["opt"])?>원</td>
					<td style="text-align:center;"><?=number_format($row["totalsum"])?>원</td>
					<td style="text-align:center;"><?=$row["insdate"]?></td>
				</tr>
				<?
					}
				}
				?>
			</table>


			<div class="gg_first" style="margin-top:10px;">서핑샵 미입금</div>
			<table class='et_vars exForm bd_tb'>
				<colgroup>
					<col style="width:45px;">
					<col style="width:150px;">
					<col style="width:110px;">
					<col style="width:55px;">
					<col style="width:110px;">
					<col style="width:80px;">
					<col style="width:140px;">
				</colgroup>
				<tr>
					<th style="text-align:center;">샵Seq</th>
					<th style="text-align:center;">서핑샵</th>
					<th style="text-align:center;">주문번호</th>
					<th style="text-align:center;">주문자</th>
					<th style="text-align:center;">연락처</th>
					<th style="text-align:center;">예약금액</th>
					<th style="text-align:center;">예약시간</th>
				</tr>
				<?if($cntshop == 0){?>
				<tr>
					<td colspan="7">					
						<div style="text-align:center;font-size:14px;padding:20px;" id="initText2">
							<b> 미입금 내역이 없습니다.</b>
						</div>
					</td>
				</tr>
				<?
				}else{
					while ($row = mysqli_fetch_assoc($result_shop)){
				?>
				<tr>
					<td style="text-align:center;"><?=$row["shopSeq"]?></td>
					<td style="text-align:center;"><?=$row["shopCode"]?></td>
					<td style="text-align:center;"><?=$row["MainNumber"]?></td>
					<td style="text-align:center;"><?=$row["userName"]?></td>
					<td style="text-align:center;"><?=$row["userPhone"]?></td>
					<td style="text-align:center;"><?=number_format($row["price"])?>원</td>
					<td style="text-align:center;"><?=$row["insdate"]?></td>
				</tr>
				<?
					}
				}
				?>
			</table>
		</div>
        <!-- #tab2 -->
        <div id="tab2" class="tab_content">
			<div style="text-align:center;font-size:14px;padding:50px;" id="initText2">
				<b> 처리 완료된 목록 </b>
			</div>
			<div id="divDaySelect"></div>
			<div id="divResList" ></div>
		</div>

		
        <!-- #tab3 -->
        <div id="tab3" class="tab_content">
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->


<input type="hidden" id="hidselDate" value="">
<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:400px;display:none;"></iframe>
