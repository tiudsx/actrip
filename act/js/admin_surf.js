//셀렉트 박스 상태 변경
function fnChangeModify(obj, confirmVlu){
	var trObj = $j(obj).parent().parent();

	if(confirmVlu == $j(obj).val()){
		trObj.find("#chkCancel").prop("checked", false);
	}else{
		trObj.find("#chkCancel").prop("checked", true);
	}
}

//상태 변경처리 - 건당
function fnConfirmUpdate(obj, num){
	$j("#frmConfirmSel").html($j("#hidInitParam").html());

	if(num == 1){
		var tbObj = $j("#frmConfirm");
	}else{
		var tbObj = $j(obj).parent().parent();
	}

	var chkObj = tbObj.find("input[id=chkCancel]");
	// if(tbObj.find("input[id=chkCancel]:checked").length == 0){
	// 	alert("승인처리 설정이 안된 항목이 있습니다.");
	// 	return;
	// }
	var chk_cnt = tbObj.find("input[id=chkCancel]:not(:checked)").length;
	var res_cnt = tbObj.find("select[id=selConfirm] option:selected[value=3]").length;

	if(chk_cnt > 0){
		alert("승인처리 변경이 안된 항목이 있습니다.");
		return;
	}

	if(!confirm("상태변경 하시겠습니까?")){
		return;
	}
	

	if(res_cnt == tbObj.find("input[id=chkCancel]:checked").length){ // 전체 확정 처리
		var res_confirm = 3;
	}else{ //부분 확정처리
		var res_confirm = 2;
	}
	
	var chkBox = '';
	for (var i = 0; i < chkObj.length; i++) {
		if(chkObj.eq(i).is(":checked")){
			chkBox += '<input type="checkbox" id="chkCancel" name="chkCancel[]" checked="checked" value="' + chkObj.eq(i).val() + '" />';

			if(tbObj.find("select[id=selConfirm]").eq(i).val() == 3){
				selres_confirm = res_confirm;
			}else{
				selres_confirm = tbObj.find("select[id=selConfirm]").eq(i).val();
			}
			chkBox += '<input type="text" id="selConfirm" name="selConfirm[]" value="' + selres_confirm + '" />';
		}
	}
	chkBox += '<input type="text" id="MainNumber" name="MainNumber" value="' + tbObj.find("input[id=MainNumber]").val() + '" />';
	chkBox += '<textarea id="memo" name="memo">' + tbObj.find("textarea[id=memo]").val() + '</textarea>';

	$j("#frmConfirmSel").append(chkBox);

	// $j("#frmConfirmSel").attr("action", "/act/admin/shop/res_kakao_save.php").submit();
	var formData = $j("#frmConfirmSel").serializeArray();

	$j.post("/act/admin/shop/res_kakao_save.php", formData,
		function(data, textStatus, jqXHR){
		   if(data == 0){
				alert("정상적으로 처리되었습니다.");
				if(num == 1){
					setTimeout('location.reload();', 500);
				}else{
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 0, $j("#shopseq").val());
				}
				
			}else{
				alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");	   
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}


//상태 변경처리 - 전체보기
function fnConfirmUpdateAll(obj){
	$j("#frmConfirmSel").html($j("#hidInitParam").html());

	var tbObj = $j(obj).parent().parent();
	var chkObj = tbObj.find("input[id=chkCancel]");

	var chk_cnt = tbObj.find("input[id=chkCancel]:not(:checked)").length;
	var res_cnt = tbObj.find("select[id=selConfirm] option:selected[value=3]").length;

	if(chk_cnt > 0){
		alert("승인처리 변경이 안된 항목이 있습니다.");
		return;
	}

	if(!confirm("상태변경 하시겠습니까?")){
		return;
	}

	if(res_cnt == tbObj.find("input[id=chkCancel]:checked").length){ // 전체 확정 처리
		var res_confirm = 3;
	}else{ //부분 확정처리
		var res_confirm = 2;
	}

	var chkBox = '';
	for (var i = 0; i < chkObj.length; i++) {
		if(chkObj.eq(i).is(":checked")){
			chkBox += '<input type="checkbox" id="chkCancel" name="chkCancel[]" checked="checked" value="' + chkObj.eq(i).val() + '" />';
			chkBox += '<input type="text" id="selConfirm" name="selConfirm[]" value="' + tbObj.find("select[id=selConfirm]").eq(i).val() + '" />';
		}
	}
	chkBox += '<input type="text" id="MainNumber" name="MainNumber" value="' + tbObj.find("input[id=MainNumber]").val() + '" />';
	chkBox += '<textarea id="memo" name="memo">' + tbObj.find("textarea[id=memo]").val() + '</textarea>';

	$j("#frmConfirmSel").append(chkBox);

	var formData = $j("#frmConfirmSel").serializeArray();

	$j.post(folderBusRoot + "/Admin_SurfSave.php", formData,
		function(data, textStatus, jqXHR){
		   if(fnRtnText(data, 0)){
                fnSearchAdmin();

				if(calObj.attr("value") == null){
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 99);
				}else{
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), calObj.attr("value").split('-')[2]);
				}
		   }
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

//달력 날짜 클릭
function fnPassengerAdmin(obj) {
	var selDate = obj.attributes.value.value;
    $j(".right_article3 calBox").css("background", "white");
    $j("calBox[sel=yes]").attr("sel", "no");
	$j(obj).css("background", "#efefef");
	$j(obj).attr("sel", "yes");

	$j("#sDate").val(selDate);
	$j("#eDate").val(selDate);

	$j("#schText").val('');

    $j("#divResList").load("/act/admin/Admin_SurfSearchList.php?selDate=" + selDate);

	$j("#initText2").css("display", "none");

	$j("input[id=chkResConfirm]").prop("checked", false);

	var arrGubun = $j(obj).attr("gubunchk").split(',');
	for (var i = 0; i < arrGubun.length; i++) {
		$j("input[id=chkResConfirm][value=" + arrGubun[i] + "]").prop('checked', true);
	}

	// fnSearchAdmin();
}


function fnCalMoveAdmin(selDate, day, seq) {
	var nowDate = new Date();
	$j("#rescontent").load("/act/admin/shop/res_kakao_all.php?selDate=" + selDate + "&selDay=" + day + "&seq=" + seq + "&t=" + nowDate.getTime());
	
	// if(day == "0"){
	// 	$j("#divResList").html("");
	// 	$j("#initText2").css("display", "");
	// }
}

function fnSearchAdmin(){
	var formData = $j("#frmSearch").serializeArray();

	$j.post(folderBusRoot + "/Admin_SurfSearch.php", formData,
		function(data, textStatus, jqXHR){
		   $j("#mngSearch").html(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

// row 클릭
function fnListView(obj){
	if($j(obj).next().css("display") == "none"){
		$j("tr[name='btnTrList']").removeClass('selTr');
		$j(obj).addClass('selTr');

		$j("tr[name='btnTrList']").next().css("display", "none");
		$j(obj).next().css("display", "");
	}else{
		$j("tr[name='btnTrList']").removeClass('selTr');

		$j(obj).next().css("display", "none");
	}
}