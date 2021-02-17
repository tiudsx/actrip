//셀렉트 박스 상태 변경
function fnChangeModify(obj, confirmVlu){
	if(mobileuse == "m"){
		var trObj = $j(obj).parents("tbody");
	}else{
		var trObj = $j(obj).parent().parent();
	}
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
	var sel_cnt = tbObj.find("select[id=selConfirm] option:selected[value=8]").length;

	if(num < 3){
		//if(chk_cnt > 0){
		if(sel_cnt > 0){
			alert("승인처리 변경이 안된 항목이 있습니다.");
			return;
		}
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
	if(num == 3){
		chkBox += '<input type="text" id="shopseq" name="shopseq" value="' + tbObj.find("input[id=shopseq]").val() + '" />';
	}

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
					fnCalMoveAdmin($j(".tour_calendar_month").text().replace('.', ''), 0, $j("#shopseq").val());
				}else if(num == 2){
					//fnCalMoveAdminList($j(".tour_calendar_month").text().replace('.', ''), 0, $j("#shopseq").val());
					fnSearchAdmin("shop/res_surflist_search.php");
				}else if(num == 3){
					//fnCalMoveAdminList($j(".tour_calendar_month").text().replace('.', ''), 0, -1);
					fnSearchAdmin("act_admin/res_surflist_search.php");
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
				
				//fnCalMoveAdminList($j(".tour_calendar_month").text().replace('.', ''), 0, 0);
				fnSearchAdmin("bus/" + mobileuse + "res_buslist_search.php");
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
    	$j("#divResList").load("/act/admin/bus/" + mobileuse + "res_busmng.php?selDate=" + selDate);
		$j("#initText2").css("display", "none");
		var url = "bus/" + mobileuse + "res_buslist_search.php";
	}else if(seq == -1){
		var url = "act_admin/res_surflist_search.php";
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

	//$j("input[id=chkResConfirm]").prop("checked", false);
	if(seq == 0){ //서핑버스
		$j("#divResList").html("");
		$j("#initText2").css("display", "");
		var url = "bus/" + mobileuse + "res_buslist_search.php";
		if(mobileuse == "m"){
			// var calurl = "bus/mres_buslist_2_calendar.php";
			var calurl = "shop/res_surfcalendar.php";
		}else{
			var calurl = "shop/res_surfcalendar.php";
		}
		
		// $j("input[id=chkResConfirm]:eq(0)").prop("checked", true);
		// $j("input[id=chkResConfirm]:eq(1)").prop("checked", true);
		// $j("input[id=chkResConfirm]:eq(2)").prop("checked", true);
		// $j("input[id=chkResConfirm]:eq(5)").prop("checked", true);
	}else if(seq == -1){ //입점샵 전체
		var url = "act_admin/res_surflist_search.php";
		var calurl = "act_admin/res_surfcalendar.php";
		
		// $j("input[id=chkResConfirm]:eq(0)").prop("checked", true);
		// $j("input[id=chkResConfirm]:eq(1)").prop("checked", true);
		// $j("input[id=chkResConfirm]:eq(2)").prop("checked", true);
		// $j("input[id=chkResConfirm]:eq(4)").prop("checked", true);
		// $j("input[id=chkResConfirm]:eq(6)").prop("checked", true);
		// $j("input[id=chkResConfirm]:eq(8)").prop("checked", true);

		//fnSearchAdmin("act_admin/res_surflist_search.php");
	}else if(seq == -2){ //솔 목록
		var url = "sol/res_sollist_search.php";
		var calurl = "sol/res_calendar.php";
	}else{ //입점샵 일반
		var url = "shop/res_surflist_search.php";
		var calurl = "shop/res_surfcalendar.php";
	
		$j("input[id=chkResConfirm]:eq(1)").prop("checked", true);
	}
	
	$j("#right_article3").load("/act/admin/" + calurl + "?selDate=" + selDate + "&selDay=" + day + "&seq=" + seq + "&t=" + nowDate.getTime());
	//$j("#mngSearch").load("/act/admin/" + url + "?selDate=" + selDate + "&selDay=" + day + "&seq=" + seq + "&t=" + nowDate.getTime());

	var nowYear = selDate.substring(0, 4);
	var nowMon = selDate.substring(4, 6);
	var lastDate = new Date(nowYear, nowMon, "");

	$j("#sDate").val(nowYear + '-' + nowMon + '-01');
	$j("#eDate").val(nowYear + '-' + nowMon + '-' + lastDate.getDate());
	$j("#schText").val('');
	
	fnSearchAdmin(url);
}

//카카오톡 예약관리 목록
function fnCalMoveAdmin(selDate, day, seq) {
	var nowDate = new Date();
	$j("#rescontent").load("/act/admin/shop/res_kakao_all.php?selDate=" + selDate + "&selDay=" + day + "&seq=" + seq + "&t=" + nowDate.getTime());
}

function fnSearchAdmin(url){
	$j.blockUI({message: "<br><br><br><h1>데이터 검색 중...</h1>", focusInput: false,css: { width: '650px', height:"350px", textAlign:'center', left:'23%', top:'20%'} }); 

	var formData = $j("#frmSearch").serializeArray();
	$j.post("/act/admin/" + url, formData,
		function(data, textStatus, jqXHR){
			$j("#mngSearch").html(data);
			setTimeout('fnModifyClose();', 500);
		}).fail(function(jqXHR, textStatus, errorThrown){
			setTimeout('fnModifyClose();', 500);
	});
}

function fnSearchAdminSol(url, objid){
	var formData = $j("#" + objid).prev().serializeArray();
	$j.post("/act/admin/" + url, formData,
		function(data, textStatus, jqXHR){
		   $j("#" + objid).html(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

// row 클릭
function fnListViewKakao(obj){
	if(mobileuse == "m"){
		var objNext = $j(obj).next().next();
		$j("tr[name='btnTrList']").removeClass('selTr');
		$j("tr[name='btnTrList']").next().removeClass('selTr');
		if(objNext.css("display") == "none"){
			$j(obj).addClass('selTr');
			$j(obj).next().addClass('selTr');

			$j("tr[name='btnTrList']").next().next().css("display", "none");
			objNext.css("display", "");
		}else{

			objNext.css("display", "none");
		}
	}else{
		var objNext = $j(obj).next();
		$j("tr[name='btnTrList']").removeClass('selTr');
		if(objNext.css("display") == "none"){
			$j(obj).addClass('selTr');

			$j("tr[name='btnTrList']").next().css("display", "none");
			objNext.css("display", "");
		}else{

			objNext.css("display", "none");
		}
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

function fnCalSearch(url){
	var formData = $j("#frmCal").serializeArray();

	$j.post("/act/admin/" + url, formData,
		function(data, textStatus, jqXHR){
		   $j("#divCalList").html(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
	 
	});
}

function fnDateReset(){
	$j("#sDate").val('');
	$j("#eDate").val('');
}

function fnModifyInfo(type, seq, gubun, obj){
	// $j("tr[name='btnTr']").removeClass('selTr');
	// $j("tr[name='btnTrPoint']").removeClass('selTr');
	// $j(obj).parent().parent().addClass('selTr');

	// if($j(obj).parent().parent().next().attr('name') == 'btnTrPoint'){
	// 	$j(obj).parent().parent().next().addClass('selTr');
	// }

	// $j("#tab3").load(folderBusRoot + "/Admin_BusModify.php?subintseq=" + seq + '&gubun=' + gubun);
	// $j(".tab_content").hide();
	// $j("#tab3").fadeIn();
	if(type == "surf"){

	}else if(type == "bus"){
		var params = "resparam=busmodify&ressubseq=" + seq;
		$j.ajax({
			type: "POST",
			url: "/act/admin/bus/res_bus_info.php",
			data: params,
			success: function (data) {
				if (data == "err") {
					alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");
				} else {
					$j("#gubun").val(gubun); //구분코드
					$j("#resnum").val(data.resnum); //예약번호
					$j("#ressubseq").val(data.ressubseq);
					$j("#insdate").val(data.insdate);
					$j("#confirmdate").val(data.confirmdate);
					$j("#res_confirm").val(data.res_confirm);
					$j("#res_date").val(data.res_date);
					$j("#user_name").val(data.user_name);
					$j("#user_tel").val(data.user_tel);
					$j("#user_email").val(data.user_email);
					$j("#rtn_charge_yn").val(data.rtn_charge_yn);
					$j("#res_price_coupon").val(data.res_price_coupon); //쿠폰
					$j("#res_totalprice").val(data.res_totalprice); //최종가격
					$j("#res_price").val(data.res_price); //기본가격
					$j("#res_busnum").val(data.res_busnum); //호차
					$j("#res_seat").val(data.res_seat);
					$j("#res_spointname").val(data.res_seat); //출발 정류장
					$j("#res_epointname").val(data.res_seat); //도착 정류장

					if(mobileuse == ""){
						$j.blockUI({ message: $j('#res_busmodify'), css: { width: '650px', textAlign:'left', left:'23%', top:'20%'} }); 
					}else{
						if($j('#res_busmodify').length != 0){
							$j.blockUI({ message: $j('#res_busmodify'), css: { width: '90%', textAlign:'left', left:'5%', top:'5%'} }); 
						}
					}
				}
			}
		});

		
	}
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

var shopList2 = {
	"surfeast1" : {},
	"surfeast2" : {},
	"surfeast3" : {},
	"surfjeju" : {},
	"surfsouth" : {},
	"surfwest" : {},
	"bbqparty" : {},
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

//서핑샵 변경
function fnChangeShop(){
	var shopseq = $j("#selShop").val();
	
	location.href = "/shopadmin?seq="+shopseq;
}

//서핑버스 정산
function fnCalMoveAdminCal(selDate, day) {
	var nowDate = new Date();
	$j("#tab3").load("/act/admin/bus/res_bus_cal.php?selDate=" + selDate + "&selDay=" + day + "&t=" + nowDate.getTime());

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