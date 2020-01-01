
function fnReset(obj){
	var trObj = $j(obj).parents('table').find("select[id=selConfirm]");

	for (var x=0;x < trObj.length;x++ ){
		trObj.eq(x).val(trObj.eq(x).attr("ori"));

		$j(obj).parents('table').find("input[id=chkCancel]").prop("checked", false);
	}
}

function fnChangeModify(obj, confirmVlu){
	var trObj = $j(obj).parent().parent();
	if(confirmVlu == $j(obj).val()){
		trObj.find("input[id=chkCancel]").prop("checked", false);
	}else{
		trObj.find("input[id=chkCancel]").prop("checked", true);
	}
}

function fnPassengerAdmin(obj) {
	var selDate = obj.attributes.value.value;
    $j(".right_article calBox").css("background", "white");
    $j("calBox[sel=yes]").attr("sel", "no");
	$j(obj).css("background", "#efefef");
	$j(obj).attr("sel", "yes");

	$j("#sDate").val(selDate);
	$j("#eDate").val(selDate);

	$j("#schText").val('');

    $j("#divResList").load(folderRoot + "/Admin_CampSearchList.php?selDate=" + selDate);

	$j("#initText2").css("display", "none");

	$j("#hidselDate").val(selDate);

	fnAdminSearch();

	if($j("#tab3").css("display") == "block"){
		$j("ul.tabs li").eq(0).click();
	}
}

function fnCalMoveAdmin(selDate, day) {
	var nowDate = new Date();
	$j(".right_article").load(folderRoot + "/Admin_CampCalendar.php?selDate=" + selDate + "&selDay=" + day + "&t=" + nowDate.getTime());
	
	if(day == "0"){
		$j("#divResList").html("");
		$j("#initText2").css("display", "");
	}
}

function fnPassengerAdminList(obj) {
	var selDate = obj.attributes.value.value;
    $j(".right_article calBox").css("background", "white");
    $j("calBox[sel=yes]").attr("sel", "no");
	$j(obj).css("background", "#efefef");
	$j(obj).attr("sel", "yes");

    $j("#divResList").load(folderRoot + "/Admin_CampSearchList.php?selDate=" + selDate);

	$j("#initText2").css("display", "none");
}

function fnCalMoveAdminList(selDate, day) {
	var nowDate = new Date();
	$j(".right_article").load(folderRoot + "/Admin_CampListCalendar.php?selDate=" + selDate + "&selDay=" + day + "&t=" + nowDate.getTime());
	
	if(day == "0"){
		$j("#divResList").html("");
		$j("#initText2").css("display", "");
	}
}

function fnCalMoveAdminCal(selDate, day) {
	var nowDate = new Date();
	$j(".right_article4").load(folderRoot + "/Admin_CampCalCalendar.php?selDate=" + selDate + "&selDay=" + day + "&t=" + nowDate.getTime());
	
	if(day == "0"){
		$j("#divResList").html("");
		$j("#initText2").css("display", "");
	}
}

function fnAdminSearch(){
	var formData = $j("#frmSearch").serializeArray();

	$j.post(folderRoot + "/Admin_CampSearch.php", formData,
		function(data, textStatus, jqXHR){
		   $j("#mngSearch").html(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

function fnDateReset(){
	$j("#sDate").val('');
	$j("#eDate").val('');
}

function fnModifyInfo(seq, obj){
	$j("tr[name='btnTr']").removeClass('selTr');
	$j("tr[name='btnTrPoint']").removeClass('selTr');
	$j(obj).parent().parent().addClass('selTr');

	if($j(obj).parent().parent().next().attr('name') == 'btnTrPoint'){
		$j(obj).parent().parent().next().addClass('selTr');
	}

	//$j("ul.tabs li").eq(1).click();

	
	$j("#tab3").load(folderRoot + "/Admin_CampModify.php?subintseq=" + seq);
	$j(".tab_content").hide();
	$j("#tab3").fadeIn();
}

function fnDataModify(){
	if(!confirm("진행하시겠습니까?")){
		return;
	}

	var calObj = $j("calBox[sel=yes]");
	var formData = $j("#frmModify").serializeArray();
	$j("#frmModify #userid").val(userid);

	$j.post(folderRoot + "/Admin_CampSave.php", formData,
		function(data, textStatus, jqXHR){
		   if(fnRtnText(data, 0)){
				fnAdminSearch();
				$j("ul.tabs li").eq(0).click();

				$j("#divResList").load(folderRoot + "/Admin_CampSearchList.php?selDate=" + $j("#hidselDate").val());

				if(calObj.attr("value") == null){
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 99);
				}else{
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), calObj.attr("value").split('-')[2]);
				}
		   }
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

function fnConfirmUpdate(num, obj){
	var calObj = $j("calBox[sel=yes]");

	$j("#frmConfirmSel").html($j("#hidInitParam").html());
	$j("#frmConfirmSel #userid").val(userid);

	var tbObj = $j(obj).parents('table');
	var chkObj = tbObj.find("input[id=chkCancel]");
	if(tbObj.find("input[id=chkCancel]:checked").length == 0){
		alert("선택된 항목이 없습니다.");
		return;
	}

	if(!confirm("진행하시겠습니까?")){
		return;
	}

	var chkBox = '';
	for (var i = 0; i < chkObj.length; i++) {
		if(chkObj.eq(i).is(":checked")){
			chkBox += '<input type="checkbox" id="chkCancel" name="chkCancel[]" checked="checked" value="' + chkObj.eq(i).val() + '" />';
			chkBox += '<input type="text" id="selConfirm" name="selConfirm[]" value="' + tbObj.find("select[id=selConfirm]").eq(i).val() + '" />';
		}
	}
	chkBox += '<input type="text" id="MainNumber" name="MainNumber" value="' + tbObj.find("input[id=MainNumber]").val() + '" />';
	$j("#frmConfirmSel").append(chkBox);

	var formData = $j("#frmConfirmSel").serializeArray();

	$j.post(folderRoot + "/Admin_CampSave.php", formData,
		function(data, textStatus, jqXHR){
		   if(fnRtnText(data, 0)){
				fnAdminSearch();

				$j("#divResList").load(folderRoot + "/Admin_CampSearchList.php?selDate=" + $j("#hidselDate").val());

				if(calObj.attr("value") == null){
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 99);
				}else{
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), calObj.attr("value").split('-')[2]);
				}
		   }
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

function fnConfirmUpdate2(num, obj){
	$j("#frmConfirmSel").html($j("#hidInitParam").html());

	var tbObj = $j(obj).parents('table');
	var chkObj = tbObj.find("input[id=chkCancel]");
	if(tbObj.find("input[id=chkCancel]:checked").length == 0){
		alert("선택된 항목이 없습니다.");
		return;
	}

	if(!confirm("진행하시겠습니까?")){
		return;
	}

	var chkBox = '';
	for (var i = 0; i < chkObj.length; i++) {
		if(chkObj.eq(i).is(":checked")){
			chkBox += '<input type="checkbox" id="chkCancel" name="chkCancel[]" checked="checked" value="' + chkObj.eq(i).val() + '" />';
			chkBox += '<input type="text" id="selConfirm" name="selConfirm[]" value="' + tbObj.find("select[id=selConfirm]").eq(i).val() + '" />';
		}
	}
	chkBox += '<input type="text" id="MainNumber" name="MainNumber" value="' + tbObj.find("input[id=MainNumber]").val() + '" />';
	$j("#frmConfirmSel").append(chkBox);

	var formData = $j("#frmConfirmSel").serializeArray();

	$j.post(folderRoot + "/Admin_CampSave.php", formData,
		function(data, textStatus, jqXHR){
		   if(fnRtnText(data, 0)){
				location.reload();
		   }
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}