var numPrice = 0;
function fnPassenger(obj, num) {
	numPrice = num;
	var selDate = obj.attributes.value.value;
    jQuery("#tour_calendar calBox").css("background", "white");
	jQuery(obj).css("background", "#efefef");

	if(jQuery("#hidpcmobile").val() == "1"){
		jQuery("#frmRes").load("/userAdd/camping/CampingRes_infoM.php?selDate=" + selDate + "&weeknum=" + obj.attributes.weekNum.value);
	}else{
		jQuery("#frmRes").load("/userAdd/camping/CampingRes_info.php?selDate=" + selDate + "&weeknum=" + obj.attributes.weekNum.value);
	}
}

function fnCalClick(selDate, week) {
    jQuery("#frmRes").css("display", "");
    jQuery("#initText").css("display", "none");
    jQuery("#divBtnRes").css("display", "");

    jQuery("#selInfo").html(selDate + " (1박)");
    jQuery("#selDate").val(selDate);
    jQuery("#selWeek").val(week);
}

function fnCalMove(selDate) {
    var nowDate = new Date();
	jQuery("#tour_calendar").load("/userAdd/camping/Calendar.php?selDate=" + selDate + "&t=" + nowDate.getTime());

    jQuery("#frmRes").html("");
    jQuery("#initText").css("display", "");
    jQuery("#divBtnRes").css("display", "none");
}

function fnBusSave() {
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
    if (!jQuery("#chk7").is(':checked')) {
        alert("취소/환불 규정에 대한 동의를 해주세요.");
        return;
    }

    if (!confirm("죽도 야영장을 예약하시겠습니까?")) {
        return;
    }

    jQuery("#frmRes").submit();
}

function fnResSel() {
    if (jQuery("#SurfResDate").val() == "") {
        alert("예약날짜를 선택하세요.");
        return;
    }

    if (jQuery("#userName").val() == "") {
        alert("이름을 입력하세요.");
        return;
    }

    if (jQuery("#userPhone1").val() == "" || jQuery("#userPhone2").val() == "" || jQuery("#userPhone3").val() == "") {
        alert("연락처를 입력하세요.");
        return;
    }

	var userPhone = jQuery("#userPhone1").val() + '-' + jQuery("#userPhone2").val() + '-' + jQuery("#userPhone3").val();
    jQuery("#busSelOk").load("/userAdd/camping/CampingSel_Ok.php?formType=0&SurfResDate=" + jQuery("#SurfResDate").val() + "&userName=" + encodeURIComponent(jQuery("#userName").val()) + "&userPhone=" + userPhone);
}

function fnResSel2() {
    if (jQuery("#resNumber").val() == "") {
        alert("예약번호를 입력하세요.");
        return;
    }
    jQuery("#busSelOk").load("/userAdd/camping/CampingSel_Ok.php?formType=1&resNumber=" + jQuery("#resNumber").val());
}

function fnResSel3() {
	$j("#busSel").css("display", "");
	$j("#busSelOk").css("display", "none");
	$j("#busSelOk2").css("display", "none");
	$j("#busSelOk3").css("display", "none");
}

function fnResSel4() {
	$j("#busSel").css("display", "none");
	$j("#busSelOk").css("display", "");
	$j("#busSelOk2").css("display", "");
	$j("#busSelOk3").css("display", "");
}

function fnRefundDis(obj) {
	jQuery(obj).prev().css("display", "");
	jQuery(obj).prev().prev().css("display", "");
	jQuery(obj).css("display", "none");
}

function fnRefund(obj, gubun) {
    var intSeq = jQuery(obj).attr("numSeq");
	var paramData = jQuery(obj).attr("selDate").split('|');

	var iObj = jQuery(obj).parent();
	if(iObj.find("#ResMemo1").val() == ""){
		alert("은행이름을 입력하세요.");
		return;
	}

	if(iObj.find("#ResMemo2").val() == ""){
		alert("예금자명을 입력하세요.");
		return;
	}

	if(iObj.find("#ResMemo3").val() == ""){
		alert("계좌번호를 입력하세요.");
		return;
	}

    var msg = "취소처리 하시겠습니까?";
    if (gubun == 2) {
        msg = "예약취소 및 환불요청 하시겠습니까?";
    }
    if (confirm(msg)) {

        var params = "resparam=Return&userName=" + paramData[0] + "&userYear=" + paramData[1] + "&userPhone=" + paramData[2] + "&intSeq=" + intSeq + "&selType=" + gubun + "&ResMemo1=" + iObj.find("#ResMemo1").val() + "&ResMemo2=" + iObj.find("#ResMemo2").val() + "&ResMemo3=" + iObj.find("#ResMemo3").val();
        jQuery.ajax({
            type: "POST",
            url: "/userAdd/camping/Admin_SurfBusRes_Save.php",
            data: params,
            error: whenError,
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

function fnPassengerAdmin(obj, selType) {
	var selDate = obj.attributes.value.value;
    jQuery("#initText").css("display", "none");
    jQuery("#tour_calendar calBox").css("background", "white");
	jQuery(obj).css("background", "#efefef");

    jQuery("#frmRes").load("/userAdd/camping/Admin_SurfBusRes_info.php?selDate=" + selDate + "&selType=" + selType);
}


function fnShopSel(vlu) {
    jQuery("#useShop").val(vlu);
}

function whenError(x, e) {
    if (x.status == 0) {
        alert('You are offline!!\n Please Check Your Network.');
    } else if (x.status == 404) {
        alert('Requested URL not found.');
    } else if (x.status == 500) {
        alert('Internel Server Error.');
    } else if (e == 'parsererror') {
        alert('Error.\nParsing JSON Request failed.');
    } else if (e == 'timeout') {
        alert('Request Time out.');
    } else {
        alert('Unknow Error.\n' + x.responseText);
    }
}

// 천단위마다 쉼표 넣기
function commify(n) {
    var reg = /(^[+-]?\d+)(\d{3})/;   // 정규식
    n += '';                          // 숫자를 문자열로 변환

    while (reg.test(n)) {
        n = n.replace(reg, '$1' + ',' + '$2');
    }

    return n;
}

var holidays = {
	"0101": { type: 0, title: "신정", year: "" },
	"0301": { type: 0, title: "삼일절", year: "" },
	"0505": { type: 0, title: "어린이날", year: "" },
	"0606": { type: 0, title: "현충일", year: "" },
	"0815": { type: 0, title: "광복절", year: "" },
	"1003": { type: 0, title: "개천절", year: "" },
	"1009": { type: 0, title: "한글날", year: "" },
	"1225": { type: 0, title: "크리스마스", year: "" },

	"1004": { type: 0, title: "추석", year: "2017" },
	"1005": { type: 0, title: "추석", year: "2017" },
	"1006": { type: 0, title: "대체휴일", year: "2017" },
	"0215": { type: 0, title: "설날", year: "2018" },
	"0216": { type: 0, title: "설날", year: "2018" },
	"0217": { type: 0, title: "설날", year: "2018" },
	"0505": { type: 0, title: "어린이날", year: "2018" },
	"0507": { type: 0, title: "대체휴일", year: "2018" },
	"0522": { type: 0, title: "석가탄신일", year: "2018" },
	//"0613": { type: 0, title: "지방선거", year: "2018" },
	"0924": { type: 0, title: "추석", year: "2018" },
	"0925": { type: 0, title: "추석", year: "2018" },
	"0926": { type: 0, title: "대체휴일", year: "2018" },
};


jQuery(function () {
	if (jQuery('input[cal=date]').length > 0) {
		jQuery('input[cal=date]').datepicker();
	}

	jQuery('#SurfResDate3').datepicker({
		onClose: function (selectedDate) {
			// 시작일(fromDate) datepicker가 닫힐때
			// 종료일(toDate)의 선택할수있는 최소 날짜(minDate)를 선택한 시작일로 지정 
			var date = jQuery(this).datepicker('getDate');

			date.setDate(date.getDate()); // Add 7 days
			jQuery("#SurfResDate4").datepicker("option", "minDate", date);

			//날짜 변경시 숙박 조회 데이터 초기화
			jQuery("tr[id=trstay1]").remove();

			if (jQuery("#SurfResDate4").val() != "") {
				fnStayDate();
			}
		}
	});
	jQuery('#SurfResDate4').datepicker({
		onClose: function (selectedDate) {
			// 종료일(toDate) datepicker가 닫힐때
			// 시작일(fromDate)의 선택할수있는 최대 날짜(maxDate)를 선택한 종료일로 지정 
			var date = jQuery(this).datepicker('getDate');

			date.setDate(date.getDate()); // Add 7 days
			jQuery("#SurfResDate3").datepicker("option", "maxDate", date);

			if (jQuery("#SurfResDate3").val() != "") {
				fnStayDate();
			}
		}
	});
});

function fnStayDate(obj) {
	var sDate = jQuery("#SurfResDate3").val().split('-');
	var eDate = jQuery("#SurfResDate4").val().split('-');

	var sDate1 = new Date(sDate[1] + "/" + sDate[2] + "/" + sDate[0] + " 00:00:00");
	var eDate1 = new Date(eDate[1] + "/" + eDate[2] + "/" + eDate[0] + " 00:00:00");

	var oneDay = 24 * 60 * 60 * 1000;
	var dayChk = Math.round(Math.abs((sDate1.getTime() - eDate1.getTime()) / (oneDay)));
}


jQuery(function ($) {
	$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)', '2월(FEB)', '3월(MAR)', '4월(APR)', '5월(MAY)', '6월(JUN)', '7월(JUL)', '8월(AUG)', '9월(SEP)', '10월(OCT)', '11월(NOV)', '12월(DEC)'],
		monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
		dayNames: ['일', '월', '화', '수', '목', '금', '토'],
		dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
		dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		yearSuffix: '년',
		showMonthAfterYear: true,  /* 연도를 월보다 앞에 표시 */
		changeYear: false,  /* 연도 수정 가능 */
		changeMonth: false  /* 월 수정 가능 */,
		showOn: "focus", /* focus/button/both 달력이 나타나는 이벤트 */
		//buttonImage: "/img/common/icon_calrendar.png",
		//buttonImageOnly: true,
		//buttonText: '선택',
		showOtherMonths: false, /* 이전/다음달의 여분 날짜 보이기 */
		selectOtherMonths: false, /* 이전/다음달의 여분 날짜 선택 유무 */
		beforeShowDay: function (day) { //공휴일 설정
			var result;
			var holiday = holidays[$.datepicker.formatDate("mmdd", day)];
			var thisYear = $.datepicker.formatDate("yy", day);

			if (holiday) {
				if (thisYear == holiday.year || holiday.year == "") {
					result = [true, "date-sunday", holiday.title];
				}
			}

			if (!result) {
				switch (day.getDay()) {
					case 0: // is sunday?
						result = [true, "date-sunday"];
						break;
					case 6: // is saturday?
						result = [true, "date-saturday"];
						break;
					default:
						result = [true, ""];
						break;
				}
			}

			return result;
		}
	};
	$.datepicker.setDefaults($.datepicker.regional['ko']);
});

function fnAdminSearch(){
    jQuery("#frmRes2").load("/userAdd/camping/Admin_SurfBusRes_info_Search.php?selDate1=" + jQuery("#SurfResDate3").val() + "&selDate2=" + jQuery("#SurfResDate4").val() + "&schSel=" + jQuery("#schSel").val() + "&schText=" + encodeURIComponent(jQuery("#schText").val()));
}