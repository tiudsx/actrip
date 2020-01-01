<div class="inner" style="width:100%;">
	<div class="bd centered" style="padding:0px;">

		<div class="max600">
		<form id="frmRes" action="<?=$folderUrl?>/SurfRes_Save.php" method="post" style="display:;" target="ifrmResize" autocomplete="off">
			<span class="spanresinfo_temp">
				<span style="display:;">
					<input type="hidden" id="resselDate" name="resselDate" value="" />
					<input type="hidden" id="resparam" name="resparam" value="SurfShopI" />
					<input type="hidden" id="resshopcode" name="resshopcode" value="<?=$rowMain["shopcode"]?>" />
					<input type="hidden" id="shopseq" name="shopseq" value="<?=$seq?>" />
					<input type="hidden" id="resNumAll" name="resNumAll" value="" />
				</span>

				<div style="padding-top:10px;line-height: 21px;" id="reslist">
					<b style="font-size:12px;">※ 서프엔조이 예약금액은 부가세별도입니다.</b><br>
					&nbsp;&nbsp;- 이용일 이후 부가세분에 대해 추가 결제해주셔야 현금영수증 발행이 됩니다.<br>
					<b style="font-size:12px;">※ 강습 예약시 주의사항</b><br>
					&nbsp;&nbsp;- 숙소만 예약은 불가능하며, 강습예약 인원만큼 숙소예약이 가능합니다.<br>
					&nbsp;&nbsp;- 숙소만 또는 강습인원보다 숙소인원이 초과할 경우 취소될 수 있습니다.
				</div>

				<div class="gg_first">신청한 예약 정보</div>
				<div style="margin-top:3px;margin-bottom:3px;">
					<table class="et_vars exForm bd_tb " style="width:100%;margin-bottom:5px;">
						<colgroup>
							<col style="width:90px;">
							<col style="width:120px;">
							<col style="width:*;">
							<col style="width:40px;">
						</colgroup>
						<tbody id="surfAdd">
							<tr>
								<th style='text-align:center;'>예약종류</th>
								<th style='text-align:center;'>날짜/시간</th>
								<th style='text-align:center;'>예약인원</th>
								<th></th>
							</tr>
						</tbody>
					</table>
				</div>


				<div class="gg_first">예약자 정보</div>
				<div style="margin-top:3px;margin-bottom:3px;">
					<table class="et_vars exForm bd_tb " style="width:100%;margin-bottom:5px;">
						<colgroup>
							<col style="width:90px;">
							<col style="width:*;">
						</colgroup>
						<tbody>
							<tr>
								<th><em>*</em> 이름</th>
								<td><input type="text" id="userName" name="userName" value="<?=$user_name?>" class="itx" maxlength="15"></td>
							</tr>
							<tr style="display:none;">
								<th><em>*</em> 아이디</th>
								<td><input type="text" id="userId" name="userId" value="<?=$user_id?>" class="itx" maxlength="30" readonly></td>
							</tr>
							<tr>
								<th><em>*</em> 연락처</th>
								<td>
									<input type="number" name="userPhone1" id="userPhone1" value="<?=$userphone[0]?>" size="3" maxlength="3" class="tel itx" style="width:50px;" oninput="maxLengthCheck(this)"> - 
									<input type="number" name="userPhone2" id="userPhone2" value="<?=$userphone[1]?>" size="4" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)"> - 
									<input type="number" name="userPhone3" id="userPhone3" value="<?=$userphone[2]?>" size="4" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)">
								</td>
							</tr>
							<tr>
								<th scope="row"> 이메일</th>
								<td><input type="text" id="usermail" name="usermail" value="<?=$email_address?>" class="itx"></td>
							</tr>
							<tr>
								<th>특이사항
								
							<?
							if($seq == "64"){
							?>
								<br><br>및 <br><br>
								과거 예약번호
							<?
							}
							?>
								</th>
								<td>
									<textarea name="etc" id="etc" rows="8" cols="42" style="margin: 0px; width: 97%; height: 100px;resize:none;"></textarea>

							<?
							if($seq == "64"){
							?>
								<br>
								<span style="color:red;">
									* <b>[당찬 서핑풀패키지2]</b> 이용시 과거 이용했던 예약번호를 적어주세요.
								</span>
							<?
							}
							?>
								</td>
							</tr>
							<tr>
								<th>이용요금</th>
								<td><span id="totalPrice">0원</span></td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</span>
		</form>
		</div>

		<div style="padding:10px; text-align:center;" class="divBtnRes1">
			<div>
				<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:200px; height:44px;" value="예약하기" onclick="fnSurfSave();" />
			</div>
		</div>

	</div>
</div>

<script>
function fnSurfAdd(num, obj){
	var selDate = $j("#resselDate").val();

	if(num == 0){
		if($j("#sellessonM").val() == 0 && $j("#sellessonW").val() == 0){
			alert("예약 인원을 선택해주세요.");
			return;
		}

		gubun = $j("#sellesson").val();
		mNum = $j("#sellessonM").val();
		wNum = $j("#sellessonW").val();
	}else if(num == 1){
		if($j("#selRentM").val() == 0 && $j("#selRentW").val() == 0){
			alert("예약 인원을 선택해주세요.");
			return;
		}

		gubun = $j("#selRent").val();
		mNum = $j("#selRentM").val();
		wNum = $j("#selRentW").val();
	}else if(num == 2){		
		if($j("#selPkgM").val() == 0 && $j("#selPkgW").val() == 0){
			alert("예약 인원을 선택해주세요.");
			return;
		}

		gubun = $j("#selPkg").val();
		mNum = $j("#selPkgM").val();
		wNum = $j("#selPkgW").val();
	}else if(num == 3){
		if($j("#strStayDate").val() == ''){
			alert("숙소 이용날짜를 선택해주세요.");
			return;
		}

		if($j("#selStayM").val() == 0 && $j("#selStayW").val() == 0){
			alert("예약 인원을 선택해주세요.");
			return;
		}

		gubun = $j("#selStay").val();
		mNum = $j("#selStayM").val();
		wNum = $j("#selStayW").val();
	}else if(num == 4){
		if($j("#selBBQ").val() == ''){
			alert("바베큐 이용날짜를 선택해주세요.");
			return;
		}

		if($j("#selBBQM").val() == 0 && $j("#selBBQW").val() == 0){
			alert("예약 인원을 선택해주세요.");
			return;
		}

		gubun = $j("#selBBQ").val();
		mNum = $j("#selBBQM").val();
		wNum = $j("#selBBQW").val();
	}

	fnSurfAppend(num, obj, selDate, gubun);
/*
	var params = "resparam=selprice&num=" + num + "&selDate=" + selDate + "&shopcode=" + $j("#resshopcode").val() + "&gubun=" + encodeURIComponent(gubun) + "&mNum=" + mNum + "&wNum=" + wNum;
	$j.ajax({
		type: "POST",
		url: "<?=$folderUrl?>/SurfRes_Save.php",
		data: params,
		error: whenError,
		success: function (data) {                
			if (data == "err") {
				alert("처리중 오류가 발생하였습니다.");
			} else {
				fnSurfAppend(num, obj, selDate, data);
			}
		}
	});
	*/
}
function fnSurfAppend(num, obj, selDate, gubun){
	var addText = "<tr>";
	var addPrice0 =  parseInt($j("calbox[value='" + selDate + "']").attr("price0"), 10);
	var addPrice1 =  parseInt($j("calbox[value='" + selDate + "']").attr("price1"), 10);
	var addPrice2 =  parseInt($j("calbox[value='" + selDate + "']").attr("price2"), 10);
	var addPrice3 =  parseInt($j("calbox[value='" + selDate + "']").attr("price3"), 10);
	var addPrice4 =  parseInt($j("calbox[value='" + selDate + "']").attr("price4"), 10);

	var selSeq = gubun.split('|')[0];
	var selName = gubun.split('|')[1];
	var selPrice = parseInt(gubun.split('|')[2], 10);
	var selPkgTitle = gubun.split('|')[3];
	var selTime = "", selDay = "";

	if(num == 0){ //서핑강습
		addText += "<td style='text-align:center;'><b>" + selName + "</b></td>";
		addText += "<td> <b>[" + $j("#resselDate").val() + "]</b> " + $j("#sellessonTime").val() + "</td>";

		selM = $j("#sellessonM").val();
		selW = $j("#sellessonW").val();
		selDate = $j("#resselDate").val();
		selTime = $j("#sellessonTime").val();

		selPrice = selPrice + addPrice0;
	}else if(num == 1){ //렌탈
		addText += "<td style='text-align:center;'><b>" + selName + "</b></td>";
		addText += "<td> <b>[" + $j("#resselDate").val() + "]</b></td>";

		selM = $j("#selRentM").val();
		selW = $j("#selRentW").val();
		selDate = $j("#resselDate").val();

		selPrice = selPrice + addPrice1;
	}else if(num == 2){ //패키지
		addText += "<td style='text-align:center;' rowspan='2'><b>" + selName + "</b></td>";
		addText += "<td> <b>[" + $j("#resselDate").val() + "]</b> " + $j("#selPkgTime").val() + "</td>";

		selM = $j("#selPkgM").val();
		selW = $j("#selPkgW").val();
		selDate = $j("#resselDate").val();
		selTime = $j("#selPkgTime").val();
		
		selPrice = selPrice + addPrice2;
	}else if(num == 3){ //숙소
		addText += "<td style='text-align:center;'><b>" + selName + "</b></td>";
		addText += "<td> <b>[" + $j("#strStayDate").val() + "]</b> " + $j("#selStayDay").val() + "</td>";

		selM = $j("#selStayM").val();
		selW = $j("#selStayW").val();
		selDate = $j("#strStayDate").val();
		selDay = $j("#selStayDay").val();

		selPrice = selPrice + addPrice3;
	}else if(num == 4){ //바베큐
		addText += "<td style='text-align:center;'><b>" + selName + "</b></td>";
		addText += "<td> <b>[" + $j("#strBBQDate").val() + "]</b></td>";

		selM = $j("#selBBQM").val();
		selW = $j("#selBBQW").val();
		selDate = $j("#strBBQDate").val();
		
		selPrice = selPrice + addPrice4;
	}


	addText += "<td style='text-align:center;'>";
	if(selM > 0){
		addText += "남:" + selM + "&nbsp;";
	}
	if(selW > 0){
		addText += "여:" + selW + "&nbsp;";
	}

	selPrice = (selPrice * selM) + (selPrice * selW);

	addText += "<input type='hidden' id='selPriceAdd' name='selPriceAdd[]' value='" + selPrice + "' >" +
				"<input type='hidden' id='resSeq' name='resSeq[]' value='" + selSeq + "' >" +
				"<input type='hidden' id='resDate' name='resDate[]' value='" + selDate + "' >" +
				"<input type='hidden' id='resTime' name='resTime[]' value='" + selTime + "' >" +
				"<input type='hidden' id='resDay' name='resDay[]' value='" + selDay + "' >" +
				"<input type='hidden' id='resGubun' name='resGubun[]' value='" + num + "' >" +
				"<input type='hidden' id='resM' name='resM[]' value='" + selM + "' >" +
				"<input type='hidden' id='resW' name='resW[]' value='" + selW + "' >";

	addText += "<br>(" + commify(selPrice) + "원)</td>";
	addText += "<td style='text-align:center;cursor: pointer;' onclick='fnSurfShopDel(this, " + num + ");'><img src='/userAdd/del.jpg' width='20' /></td></tr>";

	if(num == 2){
		addText += "<tr><td colspan='3'>" + selPkgTitle + "</td></tr>";
	}

	$j("#surfAdd").append(addText);

	$j("#frmResList")[0].reset();
	
	$j("#strStayDate").val(selDate);
	$j("#strBBQDate").val(selDate);

	fnTotalPrice();
	
	$j("ul.tabs li").eq(2).click();

	fnResView(true, '#reslist', 30);
}
</script>