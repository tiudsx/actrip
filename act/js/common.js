jQuery(function () {
    var date = (new Date()).yyyymmdd(); //오늘 날짜

	jQuery('input[cal=date]').datepicker({
        minDate : plusDate(date, -1)
	});
});

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