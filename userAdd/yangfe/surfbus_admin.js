function fnPassengerAdmin(obj) {
	var selDate = obj.attributes.value.value;
    $j(".right_article calBox").css("background", "white");
    $j("calBox[sel=yes]").attr("sel", "no");
	$j(obj).css("background", "#efefef");
	$j(obj).attr("sel", "yes");

	$j("#sDate").val(selDate);
	$j("#eDate").val(selDate);

	$j("#schText").val('');

    $j("#divDaySelect").load(folderBusRoot + "/Admin_Bus_Day.php?selDate=" + selDate);

	//$j("ul.tabs li").eq(1).click();
	$j("#initText2").css("display", "none");
	//$j("#initText3").css("display", "none");

	$j("#hidselDate").val(selDate);

	fnBusSearch();

	if($j("#tab3").css("display") == "block"){
		$j("ul.tabs li").eq(0).click();
	}
}

function fnCalMoveAdmin(selDate, day) {
	var nowDate = new Date();
	$j(".right_article").load(folderBusRoot + "/Admin_BusCalendar.php?selDate=" + selDate + "&selDay=" + day + "&t=" + nowDate.getTime());
	
	if(day == "0"){
		$j("#divDaySelect").html("");
		$j("#initText2").css("display", "");
		$j("#initText3").css("display", "");
	}
}

function fnCalMoveAdminCal(selDate, day) {
	var nowDate = new Date();
	$j("#tab3").load(folderBusRoot + "/Admin_BusCalendarCal.php?selDate=" + selDate + "&selDay=" + day + "&t=" + nowDate.getTime());

}

function fnBusSearch(){
	var formData = $j("#frmSearch").serializeArray();

	$j.post(folderBusRoot + "/Admin_BusSearch.php", formData,
		function(data, textStatus, jqXHR){
		   $j("#mngSearch").html(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

function fnDateReset(){
	$j("#sDate").val('');
	$j("#eDate").val('');
}

function fnModifyInfo(seq, gubun, obj){
	$j("tr[name='btnTr']").removeClass('selTr');
	$j("tr[name='btnTrPoint']").removeClass('selTr');
	$j(obj).parent().parent().addClass('selTr');

	if($j(obj).parent().parent().next().attr('name') == 'btnTrPoint'){
		$j(obj).parent().parent().next().addClass('selTr');
	}

	$j("#tab3").load(folderBusRoot + "/Admin_BusModify.php?subintseq=" + seq + '&gubun=' + gubun);
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

	$j.post(folderBusRoot + "/Admin_BusSave.php", formData,
		function(data, textStatus, jqXHR){
		   if(fnRtnText(data, 0)){
				fnBusSearch();
				$j("ul.tabs li").eq(0).click();

				$j("#divResList").load(folderBus + "/Admin_Bus_Day.php?selDate=" + $j("#hidselDate").val());


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

			chkBox += '<input type="checkbox" id="chkCancel" name="chkCancel[]" checked="checked" value="' + chkObj.eq(i).val().split("@")[1] + '" />';
			chkBox += '<input type="text" id="selConfirm" name="selConfirm[]" value="' + tbObj.find("select[id=selConfirm]").eq(i).val() + '" />';
		}
	}
	chkBox += '<input type="text" id="MainNumber" name="MainNumber" value="' + tbObj.find("input[id=MainNumber]").val() + '" />';

	$j("#frmConfirmSel").append(chkBox);

	var formData = $j("#frmConfirmSel").serializeArray();

	$j.post(folderBusRoot + "/Admin_BusSave.php", formData,
		function(data, textStatus, jqXHR){

		   if(fnRtnText(data, 0)){
				fnBusSearch();

				//$j("#divResList").load(folderBus + "/Admin_Bus_Day.php?selDate=" + $j("#hidselDate").val());

				if(calObj.attr("value") == null){
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 99);
				}else{
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), calObj.attr("value").split('-')[2]);
				}
		   }
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

function fnChangeModify(obj, confirmVlu){

	var trObj = $j(obj).parents('tr');

	if(confirmVlu == $j(obj).val()){
		trObj.find("input[id=chkCancel]").prop("checked", false);
	}else{
		trObj.find("input[id=chkCancel]").prop("checked", true);
	}
}

function fnBusPointSel(gubun, sBus, eBus, sSel, eSel){
	if(gubun == "Y"){
		$j("#sLocation").html('<option value="N">출발</option>' + eval(sBus + 'Point'));
		$j("#eLocation").html('<option value="N">도착</option>' + eval(eBus + 'Point'));
	}else{
		$j("#sLocation").html('<option value="N">출발</option>' + eval(eBus + 'Point'));
		$j("#eLocation").html('<option value="N">도착</option>' + eval(sBus + 'Point'));
	}

	$j("#sLocation").val(sSel);
	$j("#eLocation").val(eSel);
}

function fnBusPointMove(vlu){
	var busGubun = vlu.substring(0, 1);
	var busNumber = vlu.substring(1, 2);

	if(busGubun == "Y" && busNumber > 4){
		busNumber -= 4;
	}else if(busGubun == "S" && busNumber > 2){
		busNumber -= 2;
	}

	fnBusPointSel(busGubun, 'bus'+busGubun+busNumber, 'bus'+busGubun, 'N', 'N');
}

function fnAdminExcel(){
	var chkResConfirm = $j("input[id=chkResConfirm]:checked").map(function () { return $j(this).val(); }).get();
	var chkbusNum = $j("input[id=chkbusNum]:checked").map(function () { return "'"+$j(this).val()+"'"; }).get();
	var chkResSex = $j("input[id=chkResSex]:checked").map(function () { return "'"+$j(this).val()+"'"; }).get();

	if(chkResConfirm == '') chkResConfirm = -1;
	if(chkbusNum == '') chkbusNum = -1;
	if(chkResSex == '') chkResSex = -1;

	var schText = $j("#schText").val();
	if(schText == '') schText = -1;

	location.href = folderBusRoot + "/Admin_Excel.php?chkResConfirm=" + chkResConfirm + "&chkbusNum=" + chkbusNum + "&chkResSex=" + chkResSex + "&schText=" + schText;
}