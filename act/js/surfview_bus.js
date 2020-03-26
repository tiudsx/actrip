var holidays = {    
	"0101": { type: 0, title: "신정", year: "" },
	"0301": { type: 0, title: "삼일절", year: "" },
	"0505": { type: 0, title: "어린이날", year: "" },
	"0606": { type: 0, title: "현충일", year: "" },
	"0815": { type: 0, title: "광복절", year: "" },
	"1003": { type: 0, title: "개천절", year: "" },
	"1009": { type: 0, title: "한글날", year: "" },
	"1225": { type: 0, title: "크리스마스", year: "" },

    "0415": { type: 0, title: "선거", year: "2020" },
    "0430": { type: 0, title: "석가탄신일", year: "2020" },
    
	"0930": { type: 0, title: "추석", year: "2020" },
	"1001": { type: 0, title: "추석", year: "2020" },
    "1002": { type: 0, title: "추석", year: "2020" },
    
	"0211": { type: 0, title: "설날", year: "2021" },
	"0212": { type: 0, title: "설날", year: "2021" },
	"0213": { type: 0, title: "설날", year: "2021" }
};

var rtnBusDate = function(day, getDay, json, bus){
    var holiday = holidays[$j.datepicker.formatDate("mmdd", day)];
    var thisYear = $j.datepicker.formatDate("yy", day);

    var onoffDay = json[bus + ((day.getMonth() + 1) + 100).toString().substring(1, 3) + (day.getDate() + 100).toString().toString().substring(1, 3)];

    var cssRes = "";
    if (holiday) {
        if (thisYear == holiday.year || holiday.year == "") {
            cssRes = "date-sunday";
        }
    }

    var result;
    if(getDay == 0){
        cssRes = "date-sunday";
    }else if(getDay == 6){
        if(cssRes == "") cssRes = "date-saturday";
    }else{
        cssRes == "";
    }

    if (onoffDay) {
        result = [true, cssRes];
    }else{
        result = [false, cssRes];
    }

    return result;
}

jQuery(function () {
	jQuery('input[cal=busdate]').datepicker({
		minDate : new Date('2020-03-01'),
		maxDate : new Date('2020-09-30'),
		onClose: function (selectedDate) {
			if(selectedDate != ""){
				//fnBusSearchDate('s');
			}
		},
		beforeShowDay: function(date) {
            return rtnBusDate(date, date.getDay(), sbusDate, $j(this).attr("gubun"));
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
});

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
            }else{            
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