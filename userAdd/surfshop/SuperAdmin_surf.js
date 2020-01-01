var shopList2 = {
	"surfeast" : {},
	"surfeast2" : {},
	"surfeast3" : {},
	"surfjeju" : {},
	"surfsouth" : {},
	"surfwest" : {},
	"etc" : {}
};
var shopList3 = {};

function cateList(obj, objName){
	$j("#" + objName + "2").html('<option value="ALL">== 전체 ==</option>');
	$j("#" + objName + "3").html('<option value="ALL">== 전체 ==</option>');
	if($j(obj).val() != "ALL"){
		$j.each(shopList2[$j(obj).val()], function(key, vlu) {
			$j("#" + objName + "2").append('<option value="' + key + '">' + vlu + '</option>');
		});
	}
}

function cateList2(obj, objName){
	$j("#" + objName + "3").html('<option value="ALL">== 전체 ==</option>');
	if($j(obj).val() != "ALL"){
		$j.each(shopList3[$j(obj).val()], function(key, vlu) {
			$j("#" + objName + "3").append('<option value="' + key + '">' + vlu + '</option>');
		});
	}
}

function fnChangeModify(obj, confirmVlu){
	var trObj = $j(obj).parents('tr').prev();

	if(confirmVlu == $j(obj).val()){
		trObj.find("input[id=chkCancel]").prop("checked", false);
	}else{
		trObj.find("input[id=chkCancel]").prop("checked", true);
	}
}

function fnPassengerAdmin(obj) {
	var selDate = obj.attributes.value.value;
    $j(".right_article3 calBox").css("background", "white");
    $j("calBox[sel=yes]").attr("sel", "no");
	$j(obj).css("background", "#efefef");
	$j(obj).attr("sel", "yes");

	$j("#sDate").val(selDate);
	$j("#eDate").val(selDate);

	$j("#schText").val('');

//    $j("#divResList").load(folderRoot + "/Admin_SurfSearchList.php?selDate=" + selDate);

	$j("#initText2").css("display", "none");

	$j("input[id=chkResConfirm]").prop("checked", false);

	var arrGubun = $j(obj).attr("gubunchk").split(',');
	for (var i = 0; i < arrGubun.length; i++) {
		if(arrGubun[i] != 7){
			$j("input[id=chkResConfirm][value=" + arrGubun[i] + "]").prop('checked', true);
		}
	}

	fnAdminSearch();
}

function fnCalMoveAdmin(selDate, day) {
	var nowDate = new Date();
	$j(".right_article3").load(folderBusRoot + "/SuperAdmin_SurfCalendar.php?selDate=" + selDate + "&selDay=" + day + "&t=" + nowDate.getTime());
	
	if(day == "0"){
		$j("#divDaySelect").html("");
		$j("#initText2").css("display", "");
		$j("#initText3").css("display", "");
	}
}

function fnAdminSearch(){
	var formData = $j("#frmSearch").serializeArray();

	$j.post(folderBusRoot + "/SuperAdmin_SurfSearch.php", formData,
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
		//alert("선택된 항목이 없습니다.");
		//return;
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
	chkBox += '<input type="text" id="shopSeq" name="shopSeq" value="' + tbObj.find("input[id=shopSeq]").val() + '" />';
	chkBox += '<input type="text" id="Gubun" name="Gubun" value="' + tbObj.find("input[id=Gubun]").val() + '" />';
	chkBox += '<textarea id="memo" name="memo">' + tbObj.find("textarea[id=memo]").val() + '</textarea>';

	$j("#frmConfirmSel").append(chkBox);

	var formData = $j("#frmConfirmSel").serializeArray();

	$j.post(folderBusRoot + "/Admin_SurfSave.php", formData,
		function(data, textStatus, jqXHR){
		   if(fnRtnText(data, 0)){
				fnAdminSearch();

				if(calObj.attr("value") == null){
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 99);
				}else{
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), calObj.attr("value").split('-')[2]);
				}
		   }
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}