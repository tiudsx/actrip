function fnTabMove(num){
	$j("ul.tabs li").eq(num).click();
	fnResView(true, '#tab3', 30);
}

//날짜 클릭후 서핑버스 좌석 표시
function fnBusSeat(gubun, num) {
	var sDate = $j("#hidSurfBus" + gubun).val();

    $j("#busSeat").load(folderBusRoot + "/BusRes_info.php?selDate=" + sDate + "&busNum=" + (gubun + num));

	$j("ul.tabs li").eq(3).click();
}

//서핑버스 예약하기
function fnBusSave() {
    var chkVluY = $j("input[id=hidbusSeatY]").map(function () { return $j(this).val(); }).get();
    var chkVluS = $j("input[id=hidbusSeatS]").map(function () { return $j(this).val(); }).get();

    var chksLocationY = $j("select[id=startLocationY]").map(function () { return $j(this).val(); }).get();
    var chkeLocationY = $j("select[id=endLocationY]").map(function () { return $j(this).val(); }).get();
    var chksLocationS = $j("select[id=startLocationS]").map(function () { return $j(this).val(); }).get();
    var chkeLocationS = $j("select[id=endLocationS]").map(function () { return $j(this).val(); }).get();

	if(chkVluY == "" && chkVluS == ""){
		alert("양양행 또는 서울행 좌석을 선택해 주세요.");

		fnResView(true, '#contenttop', 30);
		return;
	}

	if(chksLocationY.indexOf('N') != -1 || chkeLocationY.indexOf('N') != -1){
		alert('양양행 정류장을 선택해주세요.');
		return;
	}
	if(chksLocationS.indexOf('N') != -1 || chkeLocationS.indexOf('N') != -1){
		alert('서울행 정류장을 선택해주세요.');
		return;
	}

    if ($j("#userName").val() == "") {
        alert("이름을 입력하세요.");
        return;
    }

    if ($j("#userPhone1").val() == "" || $j("#userPhone2").val() == "" || $j("#userPhone3").val() == "") {
        alert("연락처를 입력하세요.");
        return;
    }

	if($j("#SurfBBQ").val() == "" && $j("#SurfBBQMem").val() > 0){
		alert("참석일 날짜를 선택하세요.");
		return;
	}

	if($j("#SurfBBQ").val() != "" && $j("#SurfBBQMem").val() == 0){
		alert("참석인원을 선택하세요.");
		return;
	}

    if (!jQuery("#chk8").is(':checked')) {
        alert("이용안내 규정에 대한 동의를 해주세요.");
		fnResView(true, '#infochk', 0);
        return;
    }

    if (!jQuery("#chk9").is(':checked')) {
        alert("개인정보 취급방침에 동의를 해주세요.");
		fnResView(true, '#infochk', 0);
        return;
    }

    if (!jQuery("#chk7").is(':checked')) {
        alert("취소/환불 규정에 대한 동의를 해주세요.");
		fnResView(true, '#tbInfo1', 0);
        return;
    }

    if (!confirm("서울-양양 셔틀버스를 예약하시겠습니까?")) {
        return;
    }

    $j("#frmRes").submit();
}

function fnBusChange(vlu){
	if(vlu == "A"){
		$j("#trY").css("display", "");
		$j("#trS").css("display", "");
	}else if(vlu == "Y"){
		$j("#trY").css("display", "");
		$j("#trS").css("display", "none");

	}else if(vlu == "S"){
		$j("#trY").css("display", "none");
		$j("#trS").css("display", "");
	}

	$j("#SurfBusY").val("");
	$j("#SurfBusS").val("");

	$j("#eBusArea1").css("display", "none");
	$j("#sBusArea1").css("display", "none");
}

Date.prototype.yyyymmdd = function() {
	var yyyy = this.getFullYear().toString();
	var mm = (this.getMonth() + 1).toString();
	var dd = this.getDate().toString();
	return  yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]);
}

var bus1_s1 = (new Date('2019-05-03')).yyyymmdd(); // 1호차 운행 시작일
var bus1_e1 = (new Date('2019-06-17')).yyyymmdd(); // 1호차 운행 종료일

var bus1_s2 = (new Date('2019-08-30')).yyyymmdd(); // 1호차 운행 시작일
var bus1_e2 = (new Date('2019-09-30')).yyyymmdd(); // 1호차 운행 종료일

var bus1_s3 = (new Date('2019-06-06')).yyyymmdd(); // 1호차 운행일 - 시작/종료

var bus2_s1 = (new Date('2019-06-03')).yyyymmdd(); // 1, 2호차 운행 시작일
var bus2_e1 = (new Date('2019-07-11')).yyyymmdd(); // 1, 2호차 운행 종료일
var bus2_s1_1 = (new Date('2019-08-24')).yyyymmdd(); // 1, 2호차 운행 종료일

var bus2_s2 = (new Date('2019-06-03')).yyyymmdd(); // 2호차 운행 시작일
var bus2_e2 = (new Date('2019-07-13')).yyyymmdd(); // 2호차 운행 종료일

var bus3_s1 = (new Date('2019-07-12')).yyyymmdd(); // 1, 2, 3호차 운행 시작일
var bus3_e1 = (new Date('2019-08-19')).yyyymmdd(); // 1, 2, 3호차 운행 종료일
var bus3_s2 = (new Date('2019-08-15')).yyyymmdd();
var bus3_e2 = (new Date('2019-09-01')).yyyymmdd();

var bus4_s1 = (new Date('2019-07-20')).yyyymmdd(); // 1, 2, 3, 4호차 운행 시작일
var bus4_s2 = (new Date('2019-08-24')).yyyymmdd(); // 1, 2, 3, 4호차 운행 시작일
var bus4_s3 = (new Date('2019-09-08')).yyyymmdd(); // 1, 2, 5호차 운행 시작일
var bus4_s4 = (new Date('2019-10-12')).yyyymmdd(); // 1, 2, 5호차 운행 시작일
var bus4_s5 = (new Date('2019-09-07')).yyyymmdd(); // 1, 2, 5호차 운행 시작일
var bus4_e1 = (new Date('2019-07-21')).yyyymmdd(); // 1, 2, 3호차 운행 시작일
var bus4_e2 = (new Date('2019-07-28')).yyyymmdd(); // 1, 2, 3호차 운행 시작일
var bus4_e2 = (new Date('2019-07-28')).yyyymmdd(); // 1, 2, 3호차 운행 시작일
var bus4_e3 = (new Date('2019-08-04')).yyyymmdd(); // 1, 2, 3호차 운행 시작일
var bus4_e4 = (new Date('2019-08-11')).yyyymmdd(); // 1, 2, 3호차 운행 시작일
var bus4_e5 = (new Date('2019-08-18')).yyyymmdd(); // 1, 2, 3호차 운행 시작일
var bus4_e6 = (new Date('2019-08-25')).yyyymmdd(); // 1, 2, 3호차 운행 시작일
var bus4_e7 = (new Date('2019-10-13')).yyyymmdd(); // 1, 2, 3호차 운행 시작일

function fnBusSearchDate(gubun){
	$j("#hidbusStop").val($j("#busStop").val());
	$j("#hidSurfBusY").val($j("#SurfBusY").val());
	$j("#hidSurfBusS").val($j("#SurfBusS").val());

	$j("#spanBusDateY").html($j("#SurfBusY").val());
	$j("#spanBusDateS").html($j("#SurfBusS").val());

	if(gubun == "s"){ //양양행
		$j("#sBusArea1").css("display", "");

/*
		var yDate = $j("#SurfBusY").val().split('-');
		var yDate1 = new Date(yDate[0], (yDate[1] - 1), yDate[2]);
		var rtnVlu = "";
		if(yDate1 >= new Date('2019-05-03') && yDate1 <= new Date('2019-05-30') || yDate1 >= new Date('2019-09-20') && yDate1 <= new Date('2019-09-30')){
			rtnVlu = "1";
		}else if(yDate1 == new Date('2019-06-06')){
			rtnVlu = "1";
		}else if((yDate1 >= new Date('2019-05-30') && yDate1 <= new Date('2019-06-30')) && yDate1 != new Date('2019-06-06')){
			rtnVlu = "1,2";
		}else{
			if(yDate1.getDay() >= 0 && yDate1.getDay() <= 5){
				rtnVlu = "4";
			}else{
				rtnVlu = "1,2,3";
			}
		}
*/
		var yDate1 = $j("#SurfBusY").val();

		var yDate = $j("#SurfBusY").val().split('-');
		var yDate2 = new Date(yDate[0], (yDate[1] - 1), yDate[2]);

		var rtnVlu = "";
		if(yDate1 >= bus4_s1 && yDate1 <= bus4_s2){ //특정일 버스 추가 운행
			rtnVlu = "1,2,3,5";
		}else if(yDate1 == bus4_s3){
			rtnVlu = "1,2,5";
		}else if(yDate1 == bus4_s4 ){
			rtnVlu = "1";
		}else if(yDate1 >= bus1_s1 && yDate1 <= bus1_e1 || yDate1 >= bus1_s2 && yDate1 <= bus1_e2){
			rtnVlu = "1";
		}else if(yDate1 == bus1_s3){ //특정 당일 운행(이벤트)
			rtnVlu = "1";
		}else if((yDate1 >= bus2_s1 && yDate1 <= bus2_e1) || yDate1 == bus2_s1_1){
			rtnVlu = "1,2";
		}else{
			if(yDate2.getDay() >= 0 && yDate2.getDay() <= 5){
				rtnVlu = "4";
			}else{
				rtnVlu = "1,2,3";
			}
		}


		$j("tr[trId=BusY]").css("display", "none");

		var arrVlu = rtnVlu.split(',');
		for(var i=0;i<arrVlu.length;i++){
			$j("tr[id=busY" + arrVlu[i] + "]").css("display", "");
		}
	}else{ //서울행
		$j("#eBusArea1").css("display", "");

/*
		var sDate = jQuery("#SurfBusS").val().split('-');
		var sDate1 = new Date(sDate[0], (sDate[1] - 1), sDate[2]);
		var rtnVlu = "";
		if(sDate1 >= new Date('2019-05-03') && sDate1 <= new Date('2019-05-30') || sDate1 >= new Date('2019-09-20') && sDate1 <= new Date('2019-09-30')){
			rtnVlu = "1";
		}else if(sDate1 == new Date('2019-06-06')){
			rtnVlu = "2";
		}else if(sDate1 >= new Date('2019-06-01') && sDate1 <= new Date('2019-06-30')){
			rtnVlu = "1,2";
		}else if((sDate1 >= new Date('2019-07-05') && sDate1 <= new Date('2019-07-14')) || (sDate1 >= new Date('2019-08-15') && sDate1 <= new Date('2019-09-08'))){
			if(sDate1.getDay() >= 1 && sDate1.getDay() <= 5){
				rtnVlu = "1";
			}else if(sDate1.getDay() == 6){
				rtnVlu = "2";
			}else{
				rtnVlu = "1,2";
			}
		}else{
			if(sDate1.getDay() >= 1 && sDate1.getDay() <= 5){
				rtnVlu = "1";
			}else{
				rtnVlu = "1,2";
			}
		}
*/
		var sDate1 = jQuery("#SurfBusS").val();

		var sDate = jQuery("#SurfBusS").val().split('-');
		var sDate2 = new Date(sDate[0], (sDate[1] - 1), sDate[2]);

		var rtnVlu = "";
		if(sDate1 == bus4_e1 || sDate1 == bus4_e2 || sDate1 == bus4_e3 || sDate1 == bus4_e4 || sDate1 == bus4_e5 || sDate1 == bus4_e6){
			rtnVlu = "1,2,3";
		}else if(sDate1 == bus1_s3){
			rtnVlu = "2";
		}else if(sDate1 == bus4_e7){
			rtnVlu = "2";
		}else if(sDate1 >= bus1_s1 && sDate1 <= bus1_e1 || sDate1 >= bus1_s2 && sDate1 <= bus1_e2){
			rtnVlu = "1";
		}else if(sDate1 >= bus2_s2 && sDate1 <= bus2_e2){
			if(sDate2.getDay() == 6){
				rtnVlu = "2";
			}else{
				rtnVlu = "1";
			}
		}else if((sDate1 >= bus3_s1 && sDate1 <= bus3_e1)){
		//}else if((sDate1 >= bus3_s1 && sDate1 <= bus3_e1) || (sDate1 >= bus3_s2 && sDate1 <= bus3_e2)){
			if(sDate2.getDay() >= 1 && sDate2.getDay() <= 5){
				rtnVlu = "1";
			}else if(sDate2.getDay() == 6){
				rtnVlu = "2";
			}else{
				rtnVlu = "1,2";
			}
		}else{
			if(sDate2.getDay() >= 1 && sDate2.getDay() <= 5){
				rtnVlu = "1";
			}else{
				rtnVlu = "1,2";
			}
		}


		$j("table[tbId=BusS]").css("display", "none");
		var arrVlu = rtnVlu.split(',');
		for(var i=0;i<arrVlu.length;i++){
			$j("table[id=busS" + arrVlu[i] + "]").css("display", "");	
		}
	}
}

function fnBusSearch(){
	if($j("#busStop").val() == "A"){
		if($j("#SurfBusY").val() == "" || $j("#SurfBusS").val() == ""){
			alert("양양행/서울행 날짜를 선택하세요.");
			return;
		}
	}else if($j("#busStop").val() == "Y" && $j("#SurfBusY").val() == ""){
		alert("양양행 날짜를 선택하세요.");
		return;
	}else if($j("#busStop").val() == "S" && $j("#SurfBusS").val() == ""){
		alert("서울행 날짜를 선택하세요.");
		return;
	}

	$j("#hidbusStop").val($j("#busStop").val());
	$j("#hidSurfBusY").val($j("#SurfBusY").val());
	$j("#hidSurfBusS").val($j("#SurfBusS").val());

	$j("#spanBusDateY").html($j("#SurfBusY").val());
	$j("#spanBusDateS").html($j("#SurfBusS").val());

	if($j("#busStop").val() == "A"){
		$j("#sBusArea1").css("display", "");
		$j("#eBusArea1").css("display", "");
	}else if($j("#busStop").val() == "Y"){
		$j("#sBusArea1").css("display", "");
		$j("#eBusArea1").css("display", "none");
	}else if($j("#busStop").val() == "S"){
		$j("#sBusArea1").css("display", "none");
		$j("#eBusArea1").css("display", "");
	}

	if($j("#SurfBusY").val() != ""){
		var yDate = jQuery("#SurfBusY").val().split('-');
		var yDate1 = new Date(yDate[0], (yDate[1] - 1), yDate[2]);
		var rtnVlu = "";
		if(yDate1 >= new Date('2019-05-03') && yDate1 <= new Date('2019-05-30') || yDate1 >= new Date('2019-09-20') && yDate1 <= new Date('2019-09-30')){
			rtnVlu = "1";
		}else if(yDate1 >= new Date('2019-05-30') && yDate1 <= new Date('2019-06-30')){
			rtnVlu = "1,2";
		}else{
			if(yDate1.getDay() >= 0 && yDate1.getDay() <= 5){
				rtnVlu = "4";
			}else{
				rtnVlu = "1,2,3";
			}
		}

		$j("tr[trId=BusY]").css("display", "none");

		var arrVlu = rtnVlu.split(',');
		for(var i=0;i<arrVlu.length;i++){
			$j("tr[id=busY" + arrVlu[i] + "]").css("display", "");
		}
	}

	if($j("#SurfBusS").val() != ""){
		var sDate = jQuery("#SurfBusS").val().split('-');
		var sDate1 = new Date(sDate[0], (sDate[1] - 1), sDate[2]);
		var rtnVlu = "";
		if(sDate1 >= new Date('2019-05-03') && sDate1 <= new Date('2019-05-30') || sDate1 >= new Date('2019-09-20') && sDate1 <= new Date('2019-09-30')){
			rtnVlu = "1";
		}else if(sDate1 >= new Date('2019-06-01') && sDate1 <= new Date('2019-06-30')){
			rtnVlu = "1,2";
		}else{
			if(sDate1.getDay() >= 1 && sDate1.getDay() <= 5){
				rtnVlu = "1";
			}else{
				rtnVlu = "1,2";
			}
		}

		$j("table[tbId=BusS]").css("display", "none");
		var arrVlu = rtnVlu.split(',');
		for(var i=0;i<arrVlu.length;i++){
			$j("table[id=busS" + arrVlu[i] + "]").css("display", "");	
		}
	}
}

function fnBusReset(){
	$j("#BusArea").css("display", "");
	$j("#BusBtn").css("display", "none");

	$j("#sBusArea1").css("display", "none");
	$j("#eBusArea1").css("display", "none");
}

function fnBusPoint(gubun, num, obj, pointname){
	$j("input[btnpoint='point']").css("background","").css("color","");
	$j(obj).css("background","#1973e1").css("color","#fff");

	$j("table[view='tbBusY']").css("display", "");
	$j("table[view='tbBusS']").css("display", "");

	$j("table[view='tbBusY']").css("display", "none");
	$j("table[view='tbBusS']").css("display", "none");

	var lastNum = num;
	if(gubun == "Y"){
		if(num < 5){

		}else{
			lastNum = num - 4;
		}
	}else{
		if(num < 3){

		}else{
			lastNum = num - 2;
		}
	}
	$j("#pointnum" + gubun + "0" + lastNum).html(num);
	$j("#pointnum" + gubun + lastNum).html(num);
	$j("table[view='tbBus" + gubun + "']").eq(lastNum-1).css("display", "");

//	fnBusMap(gubun, 1, lastNum, pointname);

	$j("#mapimg").css("display", "none");
	$j("#ifrmBusMap").css("display", "none");

	fnBusMap2(gubun, 1, num, pointname);
}


function fnBusMap2(gubun, num, busnum, pointname){
	$j("#mapimg").css("display", "block");
	$j("#ifrmBusMap").css("display", "block");
	$j("#mapimg").attr("src", "https://surfenjoy.cdn3.cafe24.com/busimg/" + (gubun + busnum).replace('S2', 'S1') + "_" + num + ".JPG?v=6");

	var obj = $j("#ifrmBusMap").get(0);
	var objDoc = obj.contentWindow || obj.contentDocument;
	objDoc.mapMove(pointname);

	fnResView(true, '#businit', 40);
}

function fnBusMap(gubun, num, busnum, pointname){
	$j("#mapimg").css("display", "block");
	$j("#ifrmBusMap").css("display", "block");
	$j("#mapimg").attr("src", "https://surfenjoy.cdn3.cafe24.com/busimg/" + gubun + busnum + "_" + num + ".JPG?v=7");

	var obj = $j("#ifrmBusMap").get(0);
	var objDoc = obj.contentWindow || obj.contentDocument;
	objDoc.mapMove(pointname);

	fnResView(true, '#ifrmBusMap', 40);
}

//서핑버스 선택시 계산
function fnSeatSelected(obj){
	var tbCnt = $j("#tb" + selDate + '_' + busNum).length;
	if($j(obj).is(':checked')){
		if(tbCnt == 0){
			var insHtml = '		<table class="et_vars exForm bd_tb " style="width:100%;margin-bottom:5px;" id="tb' + selDate + '_' + busNum + '">' +
							'			<colgroup>' +
							'				<col style="width:38px;">' +
							'				<col style="width:*;">' +
							'			</colgroup>' +
							'			<tbody id="' + selDate + '_' + busNum + '">' +
							'				<tr>' +
							'					<th colspan="3">[' + selDate + '] ' + busNumName +
							'					</th>' +
							'				</tr>' +
							'				<tr id="' + selDate + '_' + busNum + '_' + obj.value + '">' +
							'					<th style="padding:4px 6px;text-align:center;">' + obj.value + '번</th>' +
							'					<td style="line-height:2;">' +
							'						<select id="startLocation' + busType + '" name="startLocation' + busType + '[]" class="select" onchange="fnBusTime(this.value, \'' + busNum + '\');">' +
							'							<option value="N">출발</option>' + sPoint +
							'						</select> →' +
							'						<select id="endLocation' + busType + '" name="endLocation' + busType + '[]" class="select">' +
							'							<option value="N">도착</option>' + ePoint +
							'						</select><br>' +
							'						<span id="stopLocation"></span>' +
							'						<input type="hidden" id="hidbusSeat' + busType + '" name="hidbusSeat' + busType + '[]" value="' + obj.value + '" />' +
							'						<input type="hidden" id="hidbusDate' + busType + '" name="hidbusDate' + busType + '[]" value="' + selDate + '" />' +
							'						<input type="hidden" id="hidbusNum' + busType + '" name="hidbusNum' + busType + '[]" value="' + busNum + '" />' +
							'					</td>' +
							'					<td style="text-align:center;" onclick="fnSeatDel(this, ' + obj.value + ');"><img src="/userAdd/del.jpg" width="20" /></td>' +
							'				</tr>' +
							'			</tbody>' +
							'		</table>';
			$j("#selBus" + busType).append(insHtml);
		}else{
			var insHtml = '				<tr id="' + selDate + '_' + busNum + '_' + obj.value + '">' +
							'					<th style="padding:4px 6px;text-align:center;">' + obj.value + '번</th>' +
							'					<td style="line-height:2;">' +
							'						<select id="startLocation' + busType + '" name="startLocation' + busType + '[]" class="select" onchange="fnBusTime(this.value, \'' + busNum + '\');">' +
							'							<option value="N">출발</option>' + sPoint +
							'						</select> →' +
							'						<select id="endLocation' + busType + '" name="endLocation' + busType + '[]" class="select">' +
							'							<option value="N">도착</option>' + ePoint +
							'						</select><br>' +
							'						<span id="stopLocation"></span>' +
							'						<input type="hidden" id="hidbusSeat' + busType + '" name="hidbusSeat' + busType + '[]" value="' + obj.value + '" />' +
							'						<input type="hidden" id="hidbusDate' + busType + '" name="hidbusDate' + busType + '[]" value="' + selDate + '" />' +
							'						<input type="hidden" id="hidbusNum' + busType + '" name="hidbusNum' + busType + '[]" value="' + busNum + '" />' +
							'					</td>' +
							'					<td style="text-align:center;" onclick="fnSeatDel(this, ' + obj.value + ');"><img src="/userAdd/del.jpg" width="20" /></td>' +
							'				</tr>';
			$j("#" + selDate + '_' + busNum).append(insHtml);
		}
	}else{
		if($j("#" + selDate + '_' + busNum + ' tr').length == 2){
			$j("#tb" + selDate + '_' + busNum).remove();
		}else{
			$j("#" + selDate + '_' + busNum + '_' + obj.value).remove();
		}
	}

	if($j.trim($j("#selBusY").text()) == ""){
		$j("#busTitle0").css("display", "none");
	}else{
		$j("#busTitle0").css("display", "");
	}

	if($j.trim($j("#selBusS").text()) == ""){
		$j("#busTitle1").css("display", "none");
	}else{
		$j("#busTitle1").css("display", "");
	}
	fnPriceSum('', 1);
}

function fnBusTime(obj, num){

}


//서핑버스 좌석선택 삭제
function fnSeatDel(obj, num){
	var arrId = $j(obj).parents('tbody').attr('id').split('_');
	if(selDate == arrId[0] && busNum == arrId[1]){
		$j("input[value=" + num + "]").prop('checked', false);
	}

	if($j(obj).parents('tbody').find('tr').length == 2){
		$j(obj).parents('table').remove();
	}else{
		$j(obj).parents('tr').remove();
	}

	if($j.trim($j("#selBusY").text()) == ""){
		$j("#busTitle0").css("display", "none");
	}else{
		$j("#busTitle0").css("display", "");
	}

	if($j.trim($j("#selBusS").text()) == ""){
		$j("#busTitle1").css("display", "none");
	}else{
		$j("#busTitle1").css("display", "");
	}

	fnPriceSum('', 1);
}

function fnBBQYN(vlu){
	if(vlu == "N"){
		$j("tr[id=trBBQYN]").css("display", "none");
		$j("#SurfBBQ").val('');
		$j("#SurfBBQMem").val('0');
		$j("#totalPrice2").html("0원");
	}else{
		$j("tr[id=trBBQYN]").css("display", "");
	}
}

function fnPriceSum(obj, num){
	if(num == 1){
		var cnt = $j("input[id=hidbusSeatY]").length + $j("input[id=hidbusSeatS]").length;
		//$j("#totalPrice").html(commify(cnt * 20000) + "원");

		var arrYDis = new Array();
		var arrYDisCnt = new Array();
		var arrSDis = new Array();
		var arrSDisCnt = new Array();

		var x = 0;
		for(var i=0;i<$j("input[id=hidbusDateY]").length;i++){
			if(arrYDis[$j("input[id=hidbusDateY]").eq(i).val()] == null){
				arrYDis[$j("input[id=hidbusDateY]").eq(i).val()] = 1;

				arrYDisCnt[x] = $j("input[id=hidbusDateY]").eq(i).val();
				x++;			
			}else{
				arrYDis[$j("input[id=hidbusDateY]").eq(i).val()] += 1;
			}
		}
		
		x = 0;
		for(var i=0;i<$j("input[id=hidbusDateS]").length;i++){
			if(arrSDis[$j("input[id=hidbusDateS]").eq(i).val()] == null){
				arrSDis[$j("input[id=hidbusDateS]").eq(i).val()] = 1;

				arrSDisCnt[x] = $j("input[id=hidbusDateS]").eq(i).val();
				x++;			
			}else{
				arrSDis[$j("input[id=hidbusDateS]").eq(i).val()] += 1;
			}
		}

		var disCnt = 0;
		var totalDisCnt = 0;
		for(var i=0;i<arrYDisCnt.length;i++){
			//alert('양양행:' + arrYDis[arrYDisCnt[i]]);

			var DateY = new Date(arrYDisCnt[i]);

			var thisCnt = arrYDis[arrYDisCnt[i]];
			var nextCnt1 = ((arrSDis[arrYDisCnt[i]] == null) ? 0 : arrSDis[arrYDisCnt[i]]);
			var nextCnt2 = ((arrSDis[plusDate(arrYDisCnt[i], 1)] == null) ? 0 : arrSDis[plusDate(arrYDisCnt[i], 1)]);
			var nextCnt = nextCnt1 + nextCnt2;

			if(thisCnt >= nextCnt){
				disCnt = thisCnt - (thisCnt - nextCnt);
			}else{
				disCnt = nextCnt - (nextCnt - thisCnt);
				if(nextCnt1 > 0){
					arrSDis[arrYDisCnt[i]] -= 1;
				}else{
					arrSDis[plusDate(arrYDisCnt[i], 1)] -= 1;
				}
			}

			totalDisCnt += disCnt;
			//alert(arrYDisCnt[i] + ' / ' + plusDate(arrYDisCnt[i], 1) + " / " + thisCnt + " / " + nextCnt + " / " + disCnt);
		}

		var strDis = "";
		if(totalDisCnt > 0){
			//임시제거
			//strDis = " (할인:" + commify(totalDisCnt * 5000) + "원)";
		}
		$j("#totalPrice").html(commify((cnt * 20000) - (totalDisCnt * 5000)) + "원" + strDis);
		$j("#lastbusPrice").html((cnt * 20000) - (totalDisCnt * 5000));
	}else{
		$j("#totalPrice2").html(commify(obj.value * 25000) + "원");
		$j("#lastbbqPrice").html(obj.value * 25000);
	}

	$j("#lastPrice").html(commify(Number($j("#lastbusPrice").html()) + Number($j("#lastbbqPrice").html(), 10)) + "원");
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

function fnBusSeatView(){
	if($j("#busStop").val() == "A"){
		if($j("#SurfBusY").val() == "" || $j("#SurfBusS").val() == ""){
			alert("양양행/서울행 날짜를 선택하세요.");
			return;
		}
	}else if($j("#busStop").val() == "Y" && $j("#SurfBusY").val() == ""){
		alert("양양행 날짜를 선택하세요.");
		return;
	}else if($j("#busStop").val() == "S" && $j("#SurfBusS").val() == ""){
		alert("서울행 날짜를 선택하세요.");
		return;
	}

	var sDate = $j("#hidSurfBus" + gubun).val();

    $j("#busSeat").load(folderBusRoot + "/BusRes_info.php?selDate=" + sDate + "&busNum=" + (gubun + num));

	$j("ul.tabs li").eq(3).click();
}

function fnAreaView(){
    var chkVluY = $j("input[id=hidbusSeatY]").map(function () { return $j(this).val(); }).get();
    var chkVluS = $j("input[id=hidbusSeatS]").map(function () { return $j(this).val(); }).get();

	if(chkVluY == "" && chkVluS == ""){
		alert("양양행 또는 서울행 좌석을 선택해 주세요.");

		fnResView(true, '.surfarea', 30);
		return;
	}

	fnResView(true, '#selBusY', 30);
}