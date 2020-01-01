function fnAreaView(obj){
	if($j("#areaView").css('display') == "none"){
		$j("#areaView").css('display', '');
	}else{
		$j("#areaView").css('display', 'none');
	}
}

//달력 월 이동
function fnCalMove(selDate, seq) {
    var nowDate = new Date();
	$j("#tour_calendar").load(folderBusRoot + "/SurfRes_Calendar.php?selDate=" + selDate + "&seq=" + seq + "&t=" + nowDate.getTime());

    $j("#initText").css("display", "");
    $j("#lessonarea").css("display", "none");
}

//날짜 클릭후 표시
function fnPassenger(obj, daynum) {
	var selDate = obj.attributes.value.value;
	$j("#tour_calendar calBox").css("background", "white");
	$j(obj).css("background", "#efefef");

    $j("#initText").css("display", "none");
    $j("#lessonarea").css("display", "");
	$j("#resselDate").val(selDate);

	$j("#strStayDate").val(selDate);
	$j("#strBBQDate").val(selDate);

	soldoutchk(selDate);	
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
		$j("#totalPrice").html(commify(cnt * 20000) + "원");
	}else{
		$j("#totalPrice2").html(commify(obj.value * 27000) + "원");
	}
}

function fnUpDown(obj, idName){
	if($j(obj).attr('class') == "fa fa-chevron-down"){
		$j(obj).removeClass("fa-chevron-down");
		$j(obj).addClass("fa-chevron-up");

		$j("#" + idName).css('display', 'block');
	}else{
		$j(obj).removeClass("fa-chevron-up");
		$j(obj).addClass("fa-chevron-down");

		$j("#" + idName).css('display', 'none');
	}
}

function fnSurfList(obj, num){
	$j(".fixed_wrap3 li").removeClass("on3");
	$j(obj).parent().addClass("on3");

	$j("div[area=shopListArea]").css("display", "none");
	$j("div[area=shopListArea]").eq(num).css("display", "block");
}

//선택 삭제
function fnSurfShopDel(obj, num){
	if(confirm("해당 항목을 삭제하시겠습니까?")){
		if(num == 2){
			$j(obj).parents('tr').next().remove();
		}

		$j(obj).parents('tr').remove();

		fnTotalPrice();
	}
}

function fnTotalPrice(){
	var sum = 0;
    $j("input[id='selPriceAdd']").each(function(){
        sum += parseInt($j(this).val(), 10);
    });

    $j("#totalPrice").text(commify(sum) + '원');
}

//패키지 셀렉트 설명
function fnDayChange(vlu){
	$j("#pkgText").html(vlu.split('|')[3]);
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

//서핑샵 예약
function fnSurfSave(){
	var rtnBool = false;
    var chkVlu = $j("input[id=resSeq]").map(function () { return $j(this).val(); }).get();
	if(chkVlu == ""){
		alert("예약 내역이 없습니다.\n\n날짜 선택 후 진행해주세요.");
		return;
	}

	var arrStay = new Array();
	var arrLesson = new Array();

	var arrStayDate = new Array();
	var arrLessonDate = new Array();

	//var objGubun = $j("input[id=resGubun]").filter("[value=3]");
	var objGubun = $j("input[id=resGubun]");
/*
	var x = 0;
	var y = 0;
	for(var i=0;i<objGubun.length;i++){
		var objDate = $j("input[id=resDate]").eq(i).val();
		var objresMem = parseInt($j("input[id=resM]").eq(i).val(), 10) + parseInt($j("input[id=resW]").eq(i).val(), 10);

		if(objGubun.eq(i).val() == 3){ //숙소
			if(arrStay[objDate] == null){
				arrStay[objDate] = objresMem;

				arrStayDate[x] = objDate;
				x++;
			}else{
				arrStay[objDate] += objresMem;
			}
		}else if(objGubun.eq(i).val() == 0){ //강습
			if(arrLesson[objDate] == null){
				arrLesson[objDate] = objresMem;

				arrLessonDate[y] = objDate;
				y++;
			}else{
				arrLesson[objDate] += objresMem;
			}
		}
	}

	var disCnt = 0;
	var totalDisCnt = 0;
	for(var i=0;i<arrStayDate.length;i++){
		var thisCnt = arrStay[arrStayDate[i]];
		var nextCnt1 = ((arrLesson[arrStayDate[i]] == null) ? 0 : arrLesson[arrStayDate[i]]);
		var nextCnt2 = ((arrLesson[plusDate(arrStayDate[i], -1)] == null) ? 0 : arrLesson[plusDate(arrStayDate[i], -1)]);
		var nextCnt = nextCnt1 + nextCnt2;

		if(thisCnt >= nextCnt){
			disCnt = thisCnt - (thisCnt - nextCnt);
		}else{
			disCnt = nextCnt - (nextCnt - thisCnt);
			if(nextCnt1 > 0){
				arrLesson[arrStayDate[i]] -= 1;
			}else{
				arrLesson[plusDate(arrStayDate[i], -11)] -= 1;
			}
		}

		totalDisCnt += disCnt;

		alert('숙소 : ' + arrStayDate[i] + ' / ' + plusDate(arrStayDate[i], -1) + " / " + thisCnt + "\n\n강습 :  / " + arrLessonDate[i] + ' / ' + nextCnt + "\n\n개수 :  " + disCnt);
	}
*/
    if ($j("#userName").val() == "") {
        alert("이름을 입력하세요.");
        return;
    }

    if ($j("#userPhone1").val() == "" || $j("#userPhone2").val() == "" || $j("#userPhone3").val() == "") {
        alert("연락처를 입력하세요.");
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


	$j("#resNumAll").val(chkVlu);

    if (!confirm("신청하신 항목으로 예약하시겠습니까?")) {
        return;
    }

    $j("#frmRes").submit();
}


function soldoutchk(date){
	$j("#sellesson").html($j("#hidsellesson").html());
	$j("#selRent").html($j("#hidselRent").html());
	$j("#selPkg").html($j("#hidselPkg").html());
	$j("#selStay").html($j("#hidselStay").html());
	$j("#selBBQ").html($j("#hidselBBQ").html());
	
	$j("#tbsellesson").css("display", "");
	$j("#divsellesson").css("display", "none");
	$j("#tbselRent").css("display", "");
	$j("#divselRent").css("display", "none");
	$j("#tbselPkg").css("display", "");
	$j("#divselPkg").css("display", "none");
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
	$j("#selBBQM").parent().css("display", "");
	$j("#selBBQW").parent().css("display", "");

	if(main[date] != null){
		for (key in main[date]) {
			if(main[date][key].type == 0){
				delObjid = "#sellesson";
			}else if(main[date][key].type == 1){
				delObjid = "#selRent";
			}else if(main[date][key].type == 2){
				delObjid = "#selPkg";
			}else if(main[date][key].type == 3){
				delObjid = "#selStay";
			}else if(main[date][key].type == 4){
				delObjid = "#selBBQ";
			}
		  
			if(main[date][key].optsexM == "Y" && main[date][key].optsexW == "Y"){
				$j(delObjid + " option[soldout=" + key + "]").remove();
			}else{
				$j(delObjid + " option[soldout=" + key + "]").attr("optsexM", main[date][key].optsexM);
				$j(delObjid + " option[soldout=" + key + "]").attr("optsexW", main[date][key].optsexW);
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

		if($j("#selPkg option").length == 0){
			$j("#tbselPkg").css("display", "none");
			$j("#divselPkg").css("display", "");
		}else{
			fnResChange(this, 'selPkg');
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

	if($j("#" + key + " option:selected").attr("optsexM") == "Y"){
		$j("#" + key + "M").css("display", "none");
		$j("#" + key + "M").prev().css("display", "");
	}else{
		$j("#" + key + "M").css("display", "");
		$j("#" + key + "M").prev().css("display", "none");
	}

	if($j("#" + key + " option:selected").attr("optsexW") == "Y"){
		$j("#" + key + "W").css("display", "none");
		$j("#" + key + "W").prev().css("display", "");
	}else{
		$j("#" + key + "W").css("display", "");
		$j("#" + key + "W").prev().css("display", "none");
	}
}