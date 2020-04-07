$j(document).ready(function() {
    $j("#slide1").click(function() {
        $j(".vip-tabnavi li").removeClass("on");
        $j(".vip-tabnavi li").eq(3).addClass("on");

        $j("#view_tab1").css("display", "none");
        $j("#view_tab3").css("display", "block");

        if($j("#view_tab2").length > 0){
            $j("#view_tab2").css("display", "none");
        }

        fnMapView("#view_tab3", 90);
        
        $j(".con_footer").css("display", "none");
    });

    var swiper = new Swiper('.swiper-container', {
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var topBar = $j(".vip-tabwrap").offset();

    $j(window).scroll(function() {
        var docScrollY = $j(document).scrollTop();

        //$j("#test").html(scrollBottom + '/' + bottomBar + '/' + topBar.top + '/' + $j(window).scrollTop());
        if ((docScrollY + 47) > (topBar.top + 0)) {
            $j("#tabnavi").addClass("vip-tabwrap-fixed");
            $j(".vip-tabwrap").addClass("vip-tabwrap-top");
        } else {
            $j("#tabnavi").removeClass("vip-tabwrap-fixed");
            $j(".vip-tabwrap").removeClass("vip-tabwrap-top");
        }

        if (checkVisible($j('.contentimg')) && !isVisible) {
            $j(".vip-tabnavi li").removeClass("on");
            $j(".vip-tabnavi li").eq(0).addClass("on");
        }

        if (checkVisible($j('#shopmap')) && !isVisible) {
            $j(".vip-tabnavi li").removeClass("on");
            $j(".vip-tabnavi li").eq(1).addClass("on");
        }

        if (checkVisible($j('#cancelinfo')) && !isVisible) {
            $j(".vip-tabnavi li").removeClass("on");
            $j(".vip-tabnavi li").eq(2).addClass("on");
        }
    });
});

var isVisible = false;
function fnCoupon(type, gubun, coupon){
    if(coupon == ""){
        alert("쿠폰코드를 입력하세요.")
        return 0;
    }

    var params = "type=" + type + "&gubun=" + gubun + "&coupon=" + coupon;
    var rtn = $j.ajax({
        type: "POST",
        url: "/act/coupon/coupon_load.php",
        data: params,
        success: function (data) {
            return data;
        }
    }).responseText;

    if (rtn == "yes") {
        alert("이미 사용 된 쿠폰입니다.");
        return 0;
    }else if (rtn == "no") {
        alert("사용가능한 쿠폰이 없습니다.");
        return 0;
    }else{
        return rtn;
    }
}

function checkVisible(elm, eval) {
    eval = eval || "object visible";
    var viewportHeight = $j(window).height(), // Viewport Height
        scrolltop = $j(window).scrollTop(), // Scroll Top
        y = $j(elm).offset().top,
        elementHeight = $j(elm).height();
    if (eval == "object visible") return ((y < (viewportHeight + scrolltop)) && (y > (scrolltop - elementHeight)));
    if (eval == "above") return ((y < (viewportHeight + scrolltop)));
}

function fnResViewBus(bool, objid, topCnt, obj) {
    $j(".vip-tabnavi li").removeClass("on");
    $j(obj).addClass("on");

    $j(".con_footer").css("display", "block");
    if(bool){
        $j("#view_tab1").css("display", "block");
        $j("#view_tab2").css("display", "none");
        $j("#view_tab3").css("display", "none");
    }else{
        $j("#view_tab1").css("display", "none");

        if(objid == "#view_tab2"){
            $j("#view_tab2").css("display", "block");
            $j("#view_tab3").css("display", "none");
        }else{
            $j("#view_tab2").css("display", "none");
            $j("#view_tab3").css("display", "block");

            if(objid == "#view_tab3"){
                $j(".con_footer").css("display", "none");
            }
        }
    }

    fnMapView(objid, topCnt);
}

function fnResView(bool, objid, topCnt, obj) {
    $j(".vip-tabnavi li").removeClass("on");
    $j(obj).addClass("on");

    $j(".con_footer").css("display", "block");
    if (bool) {
        $j("#view_tab1").css("display", "block");
        $j("#view_tab3").css("display", "none");
    } else {
        $j("#view_tab1").css("display", "none");
        $j("#view_tab3").css("display", "block");

        if(objid == "#view_tab3"){
            $j(".con_footer").css("display", "none");
        }
    }

    fnMapView(objid, topCnt);
}

function fnMapView(objid, topCnt) {
    var divLoc = $j(objid).offset();
    $j('html, body').animate({
        scrollTop: divLoc.top - topCnt
    }, "slow");
}

//달력 월 이동
function fnCalMove(selDate, seq) {
    var nowDate = new Date();
	$j("#tour_calendar").load("/act/surf/surfview_calendar.php?selDate=" + selDate + "&seq=" + seq + "&t=" + nowDate.getTime());

    $j("#initText").css("display", "");
	$j("#lessonarea").css("display", "none");
	
	$j(".fixed_wrap3 li").removeClass("on3");
	$j("div[area=shopListArea]").css("display", "none");

}

// 강습/렌탈 클릭시 바인딩
function fnSurfList(obj, num){
	$j(".fixed_wrap3 li").removeClass("on3");
	$j(obj).parent().addClass("on3");

	$j("div[area=shopListArea]").css("display", "none");
	$j("div[area=shopListArea]").eq(num).css("display", "block");

	//var lesson_price =  parseInt($j("calbox[value='" + selDate + "']").attr("lesson_price"), 10);
}

//날짜 클릭후 표시
function fnPassenger(obj) {
    var selDate = obj.attributes.value.value;
	$j("#tour_calendar calBox").css("background", "white");
	$j(obj).css("background", "#efefef");

    $j("#initText").css("display", "none");
    $j("#lessonarea").css("display", "");
	$j("#resselDate").val(selDate);
	$j("#strStayDate").val(selDate);
	
	if(!$j(".fixed_wrap3 li").hasClass("on3")){
		$j(".fixed_wrap3 li:eq(0)").addClass("on3");	
		$j("div[area=shopListArea]").eq($j(".fixed_wrap3 li:eq(0)").attr("id")).css("display", "block");	
	}
	$j("#stayText").text("").css("display", "none");

	var bbqText = $j("#selBBQ option:eq(0)").attr("opt_info");
	$j("#bbqText").html(bbqText);

	soldoutchk(selDate, obj);	
}

function plusDate(date, count) {
	var dateArr = date.split("-");
	var changeDay = new Date(dateArr[0], (dateArr[1] - 1), dateArr[2]);

	// count만큼의 미래 날짜 계산
	changeDay.setDate(changeDay.getDate() + count);
	return dateToYYYYMMDD(changeDay);
}

function dateToYYYYMMDD(date){
    function pad(num) {
        num = num + '';
        return num.length < 2 ? '0' + num : num;
    }
    return date.getFullYear() + '-' + pad(date.getMonth()+1) + '-' + pad(date.getDate());
}

Date.prototype.yyyymmdd = function() {
	var yyyy = this.getFullYear().toString();
	var mm = (this.getMonth() + 1).toString();
	var dd = this.getDate().toString();
	return  yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]);
}

// 달력 날짜 클릭 후 매진여부 체크
function soldoutchk(date, obj){
	$j("#sellesson").html($j("#hidsellesson").html());
	$j("#selRent").html($j("#hidselRent").html());
	$j("#selStay").html($j("#hidselStay").html());
	$j("#selBBQ").html($j("#hidselBBQ").html());
	
	$j("#tbsellesson").css("display", "");
	$j("#divsellesson").css("display", "none");
	$j("#tbselRent").css("display", "");
	$j("#divselRent").css("display", "none");
	$j("#tbselStay").css("display", "");
	$j("#divselStay").css("display", "none");
	$j("#tbselBBQ").css("display", "");
	$j("#divselBBQ").css("display", "none");

	$j("#sellessonM").parent().css("display", "");
	$j("#sellessonW").parent().css("display", "");
	$j("#selRentM").parent().css("display", "");
	$j("#selRentW").parent().css("display", "");
	$j("#selRentM").parent().css("display", "");
	$j("#selRentW").parent().css("display", "");
	$j("#selStayM").parent().css("display", "");
	$j("#selStayW").parent().css("display", "");
	$j("#tbselBBQ").css("display", "");
	$j("#divselBBQ").css("display", "none");
	
	if($j(obj).attr("day_type") == 3){
		var nowDate = (new Date()).yyyymmdd(); //오늘 날짜
		var resDate = plusDate(date, -6); //숙소 예약가능한 날짜
		
		if($j(obj).attr("weeknum") == 6 && nowDate > resDate){
			$j("#sellesson option[stay_day=0]").remove();
			$j("#sellesson option[stay_day=1]").remove();
			$j("#sellesson option[stay_day=2]").remove();
		}
	}

	if(main[date] != null){
		for (key in main[date]) {
			if(main[date][key].type == "lesson"){
				delObjid = "#sellesson";
			}else if(main[date][key].type == "rent"){
				delObjid = "#selRent";
			}else if(main[date][key].type == "stay"){
				delObjid = "#selStay";
			}else if(main[date][key].type == "bbq"){
				delObjid = "#selBBQ";
			}
		  
			if(main[date][key].opt_sexM == "Y" && main[date][key].opt_sexW == "Y"){
				$j(delObjid + " option[soldout=" + key + "]").remove();
			}else{
				$j(delObjid + " option[soldout=" + key + "]").attr("opt_sexM", main[date][key].opt_sexM);
				$j(delObjid + " option[soldout=" + key + "]").attr("opt_sexW", main[date][key].opt_sexW);
			}
		}

		if($j("#sellesson option").length == 0){
			$j("#tbsellesson").css("display", "none");
			$j("#divsellesson").css("display", "");
		}else{
			fnResChange(this, 'sellesson');
		}

		if($j("#selRent option").length == 0){
			$j("#tbselRent").css("display", "none");
			$j("#divselRent").css("display", "");
		}else{
			fnResChange(this, 'selRent');
		}

		if($j("#selStay option").length == 0){
			$j("#tbselStay").css("display", "none");
			$j("#divselStay").css("display", "");
		}else{
			fnResChange(this, 'selStay');
		}
        
        if($j("#selBBQ option").length == 0){
			$j("#tbselBBQ").css("display", "none");
			$j("#divselBBQ").css("display", "");
		}else{
			fnResChange(this, 'selBBQ');
		}
	}
}

function fnResChange(obj, key){
	$j("#" + key + "M").val('0');
	$j("#" + key + "W").val('0');
	$j("#" + key + "M").prev().css("display", "none");
	$j("#" + key + "W").prev().css("display", "none");

	if($j("#" + key + " option:selected").attr("opt_sexM") == "Y"){
		$j("#" + key + "M").css("display", "none");
		$j("#" + key + "M").prev().css("display", "");
	}else{
		$j("#" + key + "M").css("display", "");
		$j("#" + key + "M").prev().css("display", "none");
	}

	if($j("#" + key + " option:selected").attr("opt_sexW") == "Y"){
		$j("#" + key + "W").css("display", "none");
		$j("#" + key + "W").prev().css("display", "");
	}else{
		$j("#" + key + "W").css("display", "");
		$j("#" + key + "W").prev().css("display", "none");
	}
	if(key == "sellesson"){
		var stayPlus = $j("#sellesson option:selected").attr("stay_day");
		var dis = "none";
		var stayText = "";
		var resselDate = $j("#resselDate").val();
		if(stayPlus == 0){
			dis = "";
			stayText = "숙박 이용일 : " + resselDate + " ~ " + plusDate(resselDate, +1) + " (1박)";
		}else if(stayPlus == 1){
			dis = "";
			stayText = "숙박 이용일 : " + plusDate(resselDate, -1) + " ~ " + resselDate + " (1박)";
		}else if(stayPlus == 2){
			dis = "";
			stayText = "숙박 이용일 : " + plusDate(resselDate, -1) + " ~ " + plusDate(resselDate, +1) + " (2박)";
		}
		
		$j("#stayText").text(stayText).css("display", dis);
	}else if(key == "selBBQ"){
		var bbqText = $j("#selBBQ option:selected").attr("opt_info");
		$j("#bbqText").html(bbqText);
	}
}

//서핑샵 예약
function fnSurfSave(){
    var chkVlu = $j("input[id=resSeq]").map(function () { return $j(this).val(); }).get();
	if(chkVlu == ""){
		alert("예약 내역이 없습니다.\n\n날짜 선택 후 진행해주세요.");
		return;
	}
	$j("#resNumAll").val(chkVlu);

    if ($j("#userName").val() == "") {
        alert("이름을 입력하세요.");
        return;
    }

    if ($j("#userPhone1").val() == "" || $j("#userPhone2").val() == "" || $j("#userPhone3").val() == "") {
        alert("연락처를 입력하세요.");
        return;
    }

    if (!$j("#chk8").is(':checked')) {
        alert("이용안내 및 취소/환불 규정에 대한 동의를 해주세요.");
        return;
    }

    if (!$j("#chk9").is(':checked')) {
        alert("개인정보 취급방침에 동의를 해주세요.");
        return;
    }

    if (!confirm("신청하신 항목으로 예약하시겠습니까?")) {
        return;
    }

    $j("#frmRes").attr("action", "/act/surf/surf_save.php").submit();
}

// 서핑옵션 신청버튼
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
	}else if(num == 3){
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
}
function fnSurfAppend(num, obj, selDate, gubun){
	$j("#frmRes").css("display", "");

	var addText = "<tr>";
	var lesson_price =  parseInt($j("calbox[value='" + selDate + "']").attr("lesson_price"), 10);
	var rent_price =  parseInt($j("calbox[value='" + selDate + "']").attr("rent_price"), 10);
	var stay_price =  parseInt($j("calbox[value='" + selDate + "']").attr("stay_price"), 10);
	var bbq_price =  parseInt($j("calbox[value='" + selDate + "']").attr("bbq_price"), 10);

	var selSeq = gubun.split('|')[0];
	var selName = gubun.split('|')[1];
	var selPrice = parseInt(gubun.split('|')[2], 10);
	var selTime = "", selDay = "";

	if(num == 0){ //서핑강습
		addText += "<td style='text-align:center;'><b>" + selName + "</b></td>";
		addText += "<td> <b>[" + $j("#resselDate").val() + "]</b> " + $j("#sellessonTime").val() + "</td>";

		selM = $j("#sellessonM").val();
		selW = $j("#sellessonW").val();
		selDate = $j("#resselDate").val();
		selTime = $j("#sellessonTime").val();
		
		var stayPlus = $j("#sellesson option:selected").attr("stay_day");
		if(stayPlus == 0 || stayPlus == 1){
			selPrice = selPrice + stay_price;
		}else if(stayPlus == 2){
			selPrice = selPrice + (stay_price * 2);
		}else{
			selPrice = selPrice + lesson_price;
		}
	}else if(num == 1){ //렌탈
		addText += "<td style='text-align:center;'><b>" + selName + "</b></td>";
		addText += "<td> <b>[" + $j("#resselDate").val() + "]</b></td>";

		selM = $j("#selRentM").val();
		selW = $j("#selRentW").val();
		selDate = $j("#resselDate").val();

		selPrice = selPrice + rent_price;
	}else if(num == 2){ //숙소
		addText += "<td style='text-align:center;'><b>" + selName + "</b></td>";
		addText += "<td> <b>[" + $j("#strStayDate").val() + "]</b> " + $j("#selStayDay").val() + "</td>";

		selM = $j("#selStayM").val();
		selW = $j("#selStayW").val();
		selDate = $j("#strStayDate").val();
		selDay = $j("#selStayDay").val();

		selPrice = selPrice + stay_price;
	}else if(num == 3){ //바베큐
		addText += "<td style='text-align:center;'><b>" + selName + "</b></td>";
		addText += "<td> <b>[" + $j("#strBBQDate").val() + "]</b></td>";

		selM = $j("#selBBQM").val();
		selW = $j("#selBBQW").val();
		selDate = $j("#strBBQDate").val();
		
		selPrice = selPrice + bbq_price;
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
	addText += "<td style='text-align:center;cursor: pointer;' onclick='fnSurfShopDel(this, " + num + ");'><img src='act/images/button/close.png' style='width:18px;vertical-align:middle;' /></td></tr>";

	if(num == 2){
		// addText += "<tr><td colspan='3'>" + selPkgTitle + "</td></tr>";
	}

	$j("#surfAdd").append(addText);
	$j("#stayText").text("").css("display", "none");

	var bbqText = $j("#selBBQ option:eq(0)").attr("opt_info");
	$j("#bbqText").html(bbqText);
	$j("#frmResList")[0].reset();
	
	// $j("#strStayDate").val(selDate);
	// $j("#strBBQDate").val(selDate);

	fnTotalPrice();
	
	$j("ul.tabs li").eq(2).click();

	//fnResView(true, '#reslist', 30);
}

function fnTotalPrice(){
	var sum = 0;
    $j("input[id='selPriceAdd']").each(function(){
        sum += parseInt($j(this).val(), 10);
    });

    $j("#lastPrice").text(commify(sum) + '원');
}

//선택 삭제
function fnSurfShopDel(obj, num){
	if(confirm("해당 항목을 삭제하시겠습니까?")){
		if(num == 2){
			// $j(obj).parents('tr').next().remove();
		}

		$j(obj).parents('tr').remove();

		fnTotalPrice();
	}
}