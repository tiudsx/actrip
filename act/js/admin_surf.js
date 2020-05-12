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
				}else if(num == 0){
					//fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 0, $j("#shopseq").val());
				}else if(num == 2){
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 0, $j("#shopseq").val());
					fnSearchAdmin("shop/res_surflist_search.php");
				}
				
			}else{
				alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");	   
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

//상태 변경처리 - 건당
function fnConfirmUpdateBus(obj){
	$j("#frmConfirmSel").html($j("#hidInitParam").html());

	var tbObj = $j(obj).parent().parent();
	var chkObj = tbObj.find("input[id=chkCancel]");
	if(!confirm("상태변경 하시겠습니까?")){
		return;
	}
	
	var chkBox = '';
	for (var i = 0; i < chkObj.length; i++) {
		if(chkObj.eq(i).is(":checked")){
			chkBox += '<input type="checkbox" id="chkCancel" name="chkCancel[]" checked="checked" value="' + chkObj.eq(i).val() + '" />';

			selres_confirm = tbObj.find("select[id=selConfirm]").eq(i).val();
			chkBox += '<input type="text" id="selConfirm" name="selConfirm[]" value="' + selres_confirm + '" />';
		}
	}
	chkBox += '<input type="text" id="MainNumber" name="MainNumber" value="' + tbObj.find("input[id=MainNumber]").val() + '" />';
	chkBox += '<textarea id="memo" name="memo">' + tbObj.find("textarea[id=memo]").val() + '</textarea>';

	$j("#frmConfirmSel").append(chkBox);

	var formData = $j("#frmConfirmSel").serializeArray();

	$j.post("/act/admin/bus/res_bus_save.php", formData,
		function(data, textStatus, jqXHR){
		   if(data == 0){
				alert("정상적으로 처리되었습니다.");
				fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 0, 0);
				fnSearchAdmin("bus/res_buslist_search.php");
			}else{
				alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");	   
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

//달력 날짜 클릭
function fnPassengerAdmin(obj, seq) {
	var selDate = obj.attributes.value.value;
    $j("#right_article3 calBox").css("background", "white");
    $j("calBox[sel=yes]").attr("sel", "no");
	$j(obj).css("background", "#efefef");
	$j(obj).attr("sel", "yes");

	$j("#sDate").val(selDate);
	$j("#eDate").val(selDate);
	$j("#hidselDate").val(selDate);

	$j("#schText").val('');

	if(seq == 0){
    	$j("#divResList").load("/act/admin/bus/res_busmng.php?selDate=" + selDate);
		$j("#initText2").css("display", "none");
		var url = "bus/res_buslist_search.php";
	}else{
		var url = "shop/res_surflist_search.php";
	}

	$j("input[id=chkResConfirm]").prop("checked", false);

	var arrGubun = $j(obj).attr("gubunchk").split(',');
	for (var i = 0; i < arrGubun.length; i++) {
		$j("input[id=chkResConfirm][value=" + arrGubun[i] + "]").prop('checked', true);
	}

	fnSearchAdmin(url);
}

function fnCalMoveAdminList(selDate, day, seq) {
	var nowDate = new Date();
	$j("#right_article3").load("/act/admin/shop/res_surfcalendar.php?selDate=" + selDate + "&selDay=" + day + "&seq=" + seq + "&t=" + nowDate.getTime());
	
	if(seq == 0){
		$j("#divResList").html("");
		$j("#initText2").css("display", "");
		var url = "bus/res_buslist_search.php";
	}else{
		var url = "shop/res_surflist_search.php";
	}

	$j("#mngSearch").load("/act/admin/" + url + "?selDate=" + selDate + "&selDay=" + day + "&seq=" + seq + "&t=" + nowDate.getTime());
	
	$j("input[id=chkResConfirm]").prop("checked", false);
	$j("input[id=chkResConfirm]:eq(0)").prop("checked", true);

	var nowYear = selDate.substring(0, 4);
	var nowMon = selDate.substring(4, 6);
	var lastDate = new Date(nowYear, nowMon, "");

	$j("#sDate").val(nowYear + '-' + nowMon + '-01');
	$j("#eDate").val(nowYear + '-' + nowMon + '-' + lastDate.getDate());
	$j("#schText").val('');
}

//카카오톡 예약관리 목록
function fnCalMoveAdmin(selDate, day, seq) {
	var nowDate = new Date();
	$j("#rescontent").load("/act/admin/shop/res_kakao_all.php?selDate=" + selDate + "&selDay=" + day + "&seq=" + seq + "&t=" + nowDate.getTime());
}

function fnSearchAdmin(url){
	var formData = $j("#frmSearch").serializeArray();
	$j.post("/act/admin/" + url, formData,
		function(data, textStatus, jqXHR){
		   $j("#mngSearch").html(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}
// row 클릭
function fnListViewKakao(obj){
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

function fnListView(obj){
	if($j(obj).parent().next().css("display") == "none"){
		$j("tr[name='btnTrList']").removeClass('selTr');
		$j(obj).parent().addClass('selTr');

		$j("tr[name='btnTrList']").next().css("display", "none");
		$j(obj).parent().next().css("display", "");
	}else{
		$j("tr[name='btnTrList']").removeClass('selTr');

		$j(obj).parent().next().css("display", "none");
	}
}

function fnSoldout(){
	var formData = $j("#frmSold").serializeArray();

	if ($j("#strDate").val() == "") {
        alert("날짜를 선택하세요.");
        return;
    }
	if (!($j("#chkSexM").is(':checked') || $j("#chkSexW").is(':checked'))) {
        alert("성별 중 하나이상 선택하세요.");
        return;
    }

	if(!confirm("선택항목을 매진 처리 하시겠습니까?")){
		return;
	}

	$j.post("/act/admin/shop/res_kakao_save.php", formData,
		function(data, textStatus, jqXHR){
			if(data == 1){
				alert("해당 날짜와 항목은 이미 매진처리 되었습니다.\n\n해당 항목을 삭제 후 추가해주세요.");
			}else if(data == 0){
				alert("정상적으로 매진 처리되었습니다.");
				$j("#divSoldOutList").load("/act/admin/shop/res_surflist_soldout.php?chk=1");
			}else{
				alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");
			}
		   
		}).fail(function(jqXHR, textStatus, errorThrown){
	});
}

function fnSoldModify(seq){
	if(!confirm("선택항목을 삭제 처리 하시겠습니까?")){
		return;
	}

	var params = "resparam=soldoutdel&soldoutseq=" + seq;
	$j.ajax({
		type: "POST",
		url: "/act/admin/shop/res_kakao_save.php",
		data: params,
		success: function (data) {
			if (data == 0) {
				alert("정상적으로 매진 처리되었습니다.");
				$j("#divSoldOutList").load("/act/admin/shop/res_surflist_soldout.php?chk=1");
			} else {
				alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");
			}
		}
	});
}

function fnCalSearch(){
	var formData = $j("#frmCal").serializeArray();

	$j.post("/act/admin/shop/res_surflist_cal.php", formData,
		function(data, textStatus, jqXHR){
		   $j("#divCalList").html(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

function fnDateReset(){
	$j("#sDate").val('2020-04-01');
	$j("#eDate").val('2020-10-31');
}

function fnModifyInfo(seq, gubun, obj){
	// $j("tr[name='btnTr']").removeClass('selTr');
	// $j("tr[name='btnTrPoint']").removeClass('selTr');
	// $j(obj).parent().parent().addClass('selTr');

	// if($j(obj).parent().parent().next().attr('name') == 'btnTrPoint'){
	// 	$j(obj).parent().parent().next().addClass('selTr');
	// }

	// $j("#tab3").load(folderBusRoot + "/Admin_BusModify.php?subintseq=" + seq + '&gubun=' + gubun);
	// $j(".tab_content").hide();
	// $j("#tab3").fadeIn();

	$j.blockUI({ message: $j('#res_busmodify'), css: { width: '650px', textAlign:'left', left:'23%', top:'30%'} }); 
}

function fnModifyClose(){
	$j.unblockUI();
}

function fnDataModify(){
	if(!confirm("정보수정을 하시겠습니까?")){
		return;
	}

	var calObj = $j("calBox[sel=yes]");
	var formData = $j("#frmModify").serializeArray();
	// $j("#frmModify #userid").val(userid);

	$j.post("/act/admin/bus/res_bus_save.php", formData,
		function(data, textStatus, jqXHR){
			if(data == 0){
				alert("정상적으로 처리되었습니다.");
				$j("#divResList").load("/act/admin/bus/res_busmng.php?selDate=" + $j("#hidselDate").val());


				if(calObj.attr("value") == null){
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 99);
				}else{
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), calObj.attr("value").split('-')[2]);
				}
			}else{
				alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");	   
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

$j(function () {
    $j("ul.tabs li").click(function () {
        $j("ul.tabs li").removeClass("active").css("color", "#333");
        $j(this).addClass("active").css("color", "darkred");
        //$j(".tab_content").hide();
		$j("div[class=tab_content]").css('display', 'none');
        var activeTab = $j(this).attr("rel");
        //$j("#" + activeTab).fadeIn();

		$j("#" + activeTab).css('display', 'block');
	});
	
});