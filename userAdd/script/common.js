var numPrice = 0;
var tabNum = 0;
var holidays = {
	"0101": { type: 0, title: "신정", year: "" },
	"0301": { type: 0, title: "삼일절", year: "" },
	"0505": { type: 0, title: "어린이날", year: "" },
	"0512": { type: 0, title: "석가탄신일", year: "" },
	"0606": { type: 0, title: "현충일", year: "" },
	"0815": { type: 0, title: "광복절", year: "" },
	"1003": { type: 0, title: "개천절", year: "" },
	"1009": { type: 0, title: "한글날", year: "" },
	"1225": { type: 0, title: "크리스마스", year: "" },

	"0912": { type: 0, title: "추석", year: "2019" },
	"0913": { type: 0, title: "추석", year: "2019" },
	"0914": { type: 0, title: "추석", year: "2019" },
	"0204": { type: 0, title: "설날", year: "2019" },
	"0205": { type: 0, title: "설날", year: "2019" },
	"0206": { type: 0, title: "설날", year: "2019" },
};

jQuery(function () {
    $j(".tab_content").hide();
    $j(".tab_content:first").show();

    $j("ul.tabs li").click(function () {
        $j("ul.tabs li").removeClass("active").css("color", "#333");
        $j(this).addClass("active").css("color", "darkred");
        //$j(".tab_content").hide();
		$j("div[class=tab_content]").css('display', 'none');
        var activeTab = $j(this).attr("rel");
        //$j("#" + activeTab).fadeIn();

		$j("#" + activeTab).css('display', 'block');
    });

	if (jQuery('input[cal=date]').length > 0) {
		jQuery('input[cal=date]').datepicker();
	}

	jQuery('input[cal=sdate]').datepicker({
		minDate : 0
	});

	jQuery('input[cal=sbusdate]').datepicker({
		minDate : new Date('2019-06-01'),
		maxDate : new Date('2019-10-13'),
		onClose: function (selectedDate) {
			if(selectedDate != ""){
				fnBusSearchDate('s');
			}
		},
		beforeShowDay: function(date) {
			var sDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
			sDate.setDate(sDate.getDate() + 1);

			var eDateNow = new Date();
			eDateNow.setDate(eDateNow.getDate() + 280);

			if(sDate < new Date() || eDateNow < date){
				return [false, ""];
			}else{
				var day = date.getDay();

				if(date >= new Date('2019-07-14') && date <= new Date('2019-08-17')){
					if(day == 0){
						return [false, "date-sunday"];
					}else if(day == 6){
						return [true, "date-saturday"];
					}else{
						return [false, ""];
					}
				}else{
					var onoffDay = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
					if(onoffDay == "2019-10-5"){
						return [false, "date-saturday"];
					}else if(onoffDay == "2019-6-6"){
						return [true, "date-sunday"];
					}else{
						if(day == 0){
							return [false, "date-sunday"];
						}else if(day == 6){
							return [true, "date-saturday"];
						}else{
							return [false, ""];
						}
					}
				}
			}
		}
	});
	

	jQuery('input[cal=ebusdate]').datepicker({
		minDate : new Date('2019-06-01'),
		maxDate : new Date('2019-10-13'),
		onClose: function (selectedDate) {
			if(selectedDate != ""){
			fnBusSearchDate('e');
			}
		},
		beforeShowDay: function(date) {
			var sDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
			sDate.setDate(sDate.getDate() + 1);

			var eDateNow = new Date();
			eDateNow.setDate(eDateNow.getDate() + 280);

			if(sDate < new Date() || eDateNow < date){
				return [false, ""];
			}else{
				var day = date.getDay();

				//if(date >= new Date('2019-07-05') && date <= new Date('2019-09-08')){
				if(date >= new Date('2019-06-17') && date <= new Date('2019-08-24')){
					if(date >= new Date('2019-07-14') && date <= new Date('2019-08-17')){
					if(day == 0){
							return [true, "date-sunday"];
						}else if(day == 6){
							return [true, "date-saturday"];
						}else{
							return [false, ""];
						}
					}else{
						if(day == 0){
							return [true, "date-sunday"];
						}else if(day == 6){
							return [true, "date-saturday"];
						}else{
							return [false, ""];
						}
					}
				}else{
					var onoffDay = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();

					if(onoffDay == "2019-10-6"){
						return [false, "date-sunday"];
					}else if(onoffDay == "2019-6-6"){
						return [true, "date-sunday"];
					}else{
						if(day == 0){
							return [true, "date-sunday"];
						}else if(day == 6){
							return [false, "date-saturday"];
						}else{
							return [false, ""];
						}
					}
				}
			}
		}
	});

	jQuery('input[cal=bbqdate]').datepicker({
		minDate : new Date('2019-05-04'),
		maxDate : new Date('2019-09-30'),
		beforeShowDay: function(date) {
			var sDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
			sDate.setDate(sDate.getDate() + 1);

			var day = date.getDay();
			if(sDate < new Date()){
				if(day == 0){
					return [false, "date-sunday"];
				}else if(day == 6){
					return [false, "date-saturday"];
				}else{
					return [false, ""];
				}
			}else{

				if(day == 0){
					return [true, "date-sunday"];
				}else if(day == 6){
					return [true, "date-saturday"];
				}else{
					return [true, ""];
				}
			}
		}
	});

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

	var menu = $j( '.menu,.menuPC' ).offset();
	if(menu != null){
		$j( window ).scroll( function() {
			if ( $j( document ).scrollTop() > menu.top ) {
				$j( '.menu, .menuPC' ).addClass( 'fixedRight' );
			} else {
				$j( '.menu, .menuPC' ).removeClass( 'fixedRight' );
			}
		});
	}
});

function fnStayDate(obj) {
	var sDate = jQuery("#SurfResDate3").val().split('-');
	var eDate = jQuery("#SurfResDate4").val().split('-');

	var sDate1 = new Date(sDate[0], (sDate[1] - 1), sDate[2]);
	var eDate1 = new Date(eDate[0], (eDate[1] - 1), eDate[2]);

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

// 천단위마다 쉼표 넣기
function commify(n) {
    var reg = /(^[+-]?\d+)(\d{3})/;   // 정규식
    n += '';                          // 숫자를 문자열로 변환

    while (reg.test(n)) {
        n = n.replace(reg, '$1' + ',' + '$2');
    }

    return n;
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

function fnResView(bool,objid, topCnt){
	var divLoc = $j(objid).offset();
	$j('html, body').animate({scrollTop: divLoc.top - topCnt}, "slow");
}


function fnRtnText(data, type){
   if(data == "0"){
	   alert("정상적으로 처리되었습니다.");
	   return true;
   }else{
	   alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");	   
	   return false;
   }
}

function maxLengthCheck(object){
	if (object.value.length > object.maxLength){
		object.value = object.value.slice(0, object.maxLength);
	}    
}
