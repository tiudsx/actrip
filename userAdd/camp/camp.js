//달력 월 이동
function fnCalMove(selDate) {
    var nowDate = new Date();
	jQuery("#tour_calendar").load(folderRoot + "/CampingRes_Calendar.php?selDate=" + selDate + "&t=" + nowDate.getTime());

    jQuery("#frmRes").html("");
    jQuery("#initText").css("display", "");
    jQuery("#divBtnRes").css("display", "none");
}

//기간 변경
function fnDayChange(daynum){
	$j("#frmRes").load(folderRoot + "/CampingRes_info.php?selDate=" + jQuery("#selDate").val() + "&weeknum=" + jQuery("#selWeek").val() + "&daynum=" + daynum + "&viewtype=" + $j("#hidpcmobile").val());
}

//날짜 클릭후 야영장 구역 표시
function fnPassenger(obj, daynum) {
	var selDate = obj.attributes.value.value;
	$j("#tour_calendar calBox").css("background", "white");
	$j(obj).css("background", "#efefef");

	$j("#frmRes").load(folderRoot + "/CampingRes_info.php?selDate=" + selDate + "&weeknum=" + obj.attributes.weekNum.value + "&daynum=" + daynum + "&viewtype=" + $j("#hidpcmobile").val());
}

//날짜 클릭후 야영장 구역 표시
function fnCalClick(selDate, week, daynum) {
    jQuery("#frmRes").css("display", "");
    jQuery("#initText").css("display", "none");
    jQuery("#divBtnRes").css("display", "");

    jQuery("#selInfo").html(selDate);
    jQuery("#selDate").val(selDate);
    jQuery("#selWeek").val(week);

	var clickDate = $j("#selDate").val().split('-');
	var changeDay = new Date(clickDate[0], (clickDate[1] - 1), clickDate[2]);
	changeDay.setDate(changeDay.getDate() + daynum);

	var ChangeDate = changeDay.getFullYear() + "-" + ((changeDay.getMonth() + 1) < 10 ? "0" + (changeDay.getMonth() + 1) : (changeDay.getMonth() + 1)) + "-" + (changeDay.getDate() < 10 ? "0" + changeDay.getDate() : changeDay.getDate());

    jQuery("#selInfo2").html(ChangeDate);
}

//야영장 예약하기
function fnCampSave() {
	var radioVal = jQuery("input[name='restype1']:checked").val();
	jQuery("#hidrestype").val(radioVal);

    if (jQuery("#userName").val() == "") {
        alert("이름을 입력하세요.");
        return;
    }

    if (jQuery("#userId").val() == "") {
    }

    if (jQuery("#userPhone1").val() == "" || jQuery("#userPhone2").val() == "" || jQuery("#userPhone3").val() == "") {
        alert("연락처를 입력하세요.");
        return;
    }

    var chkVlu = jQuery("input[id=chkSeat]:checked").map(function () { return "'" +jQuery(this).val() + "'"; }).get();
    jQuery("#chkSeatSel").val(chkVlu);

    var chkVlu2 = jQuery("input[id=chkOpt]:checked").map(function () { return jQuery(this).val(); }).get();
    jQuery("#chkOptSel").val(chkVlu2);

    if (chkVlu == "") {
        alert("야영장 자리를 선택하세요.");
        return;
    }

    if (!jQuery("#chk8").is(':checked')) {
        alert("이용안내 규정에 대한 동의를 해주세요.");
        return;
    }

    if (!jQuery("#chk9").is(':checked')) {
        alert("개인정보 취급방침에 동의를 해주세요.");
		fnResView(true, '#infochk', 0);
        return;
    }

    if (!jQuery("#chk7").is(':checked')) {
        alert("취소/환불 규정에 대한 동의를 해주세요.");
        return;
    }

    if (!confirm("죽도 야영장을 예약하시겠습니까?")) {
        return;
    }

    jQuery("#frmRes").submit();
}


//야영장 선택시 계산
function fnPrice(type, obj) {
	var chkVlu = jQuery("input[id=chkSeat]:checked").map(function () { return jQuery(this).val(); }).get();
	chkVlu = chkVlu.toString();
	var aSite = chkVlu.indexOf('A');
	var cSite = chkVlu.indexOf('C');
	var dSite = chkVlu.indexOf('D');

	if(aSite >= 0 && (cSite >= 0 || dSite >= 0)){
		alert('글램핑과 야영장은 동시에 예약이 안됩니다.\n\n따로 예약해주세요.');
		$j(obj).prop('checked', false);
		return;
	}

	var clickDate = $j("#selDate").val().split('-');

	var selDate = new Date(clickDate[0], (clickDate[1] - 1), clickDate[2]);
	var forDate = selDate;
		forDate.setDate(forDate.getDate() - 1);
	
	var lastPrice = numPrice;
	
	var priceDate1 = new Date(selDate.getFullYear(), (07 - 1), 01);
	var priceDate2 = new Date(selDate.getFullYear(), (08 - 1), 31);

	var forNum = $j("#selDay").val();
	var gPrice = 0, cPrice = 0;
	for (var x=0;x < forNum;x++ )
	{
		forDate.setDate(forDate.getDate() + 1);

		//성수기 : true   비수기 : false
		var priceGubun = (forDate >= priceDate1 && forDate <= priceDate2);

		var chkOptText = "전기사용은 1박에 5,000원 입니다.<br>";
		var priceNum = (lastPrice * 10000), priceText = "", priceType = "N";

		for(var i=0;i < $j("input[id=chkSeat]:checked").length; i++){
			var objChk = $j("input[id=chkSeat]:checked").eq(i);

			if(objChk.val().substring(0, 1) == "A"){
				chkOptText += '<input type="checkbox" id="chkOpt" name="chkOpt[]" value="0|' + objChk.val() + '" checked /> 전기사용 (포함) : 글램핑<br/>';
				if(priceGubun){
					gPrice += 150000;
				}else{
					gPrice += 120000;
				}
			}else{
				chkOptText += '<input type="checkbox" id="chkOpt" name="chkOpt[]" value="1|' + objChk.val() + '" /> 전기사용 (' + commify(5000 * forNum) + '원) : (' + objChk.val() + ')<br/>';
				//chkOptText = "전기사용은 1박에 5,000원 입니다.<br>";
				//chkOptText += '<input type="checkbox" id="chkOpt" name="chkOpt[]" value="1|' + objChk.val() + '" /> 전기사용 (' + commify(5000 * forNum) + '원)';
				if(objChk.val().substring(0, 1) == "C"){
					if(priceGubun){
						cPrice += 40000;
					}else{
						cPrice += 30000;
					}
				}else{
					if(priceGubun){
						cPrice += 30000;
					}else{
						cPrice += 20000;
					}
				}
			}
		}

		$j("#resOpt").html(chkOptText);
	}

	$j("#priceSum").val(cPrice);
	$j("#gpriceSum").val(gPrice);

	var rtnText = "";
	if(parseInt($j("#gpriceSum").val(), 10) > 0){
		rtnText = "글램핑 : " + commify($j("#gpriceSum").val()) + "원 (" + forNum + "박)<br>";
	}

	if(parseInt($j("#priceSum").val(), 10) > 0){
		rtnText += "야영장 : " + commify($j("#priceSum").val()) + "원 (" + forNum + "박)";
	}

	$j("#totalPrice").html(rtnText);
}