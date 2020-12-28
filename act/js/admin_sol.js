function fnSolpopupReset(){
    $j("#frmModify")[0].reset();
    $j("#SolAdd").css("display", "");
    $j("#SolModify").css("display", "none");

    $j("tr[rowadd=1]").remove();
}

function fnSolInsert(){
    $j.blockUI({
        message: $j('#res_modify'), 
        focusInput: false,
        css: { width: '90%', textAlign:'left', left:'5%', top:'7%'} 
    }); 
}

function fnSolAdd(obj, id){
    var date = (new Date()).yyyymmdd(); //오늘 날짜

    var objTr = $j("tr[id=" + id + "]").eq(0);

    $j("tr[id=" + id + "]:last").after(objTr.clone());
    $j("tr[id=" + id + "]:last").css("display", "")
    $j("tr[id=" + id + "]:last").find('input[cal=date]').removeClass('hasDatepicker').removeAttr('id').datepicker({
        minDate : plusDate(date, -1)
    });
    $j("tr[id=" + id + "]:last").attr("rowadd", "1");
}

function fnSolDel(obj){
    $j(obj).parent().parent().remove();
}

function fnSolModify(resseq){
    var params = "resparam=solview&resseq=" + resseq;
    $j.ajax({
        type: "POST",
        url: "/act/admin/sol/res_sollist_info.php",
        data: params,
        success: function (data) {
            fnSolpopupReset();

            fnSolInsert();

            $j("#SolAdd").css("display", "none");
            $j("#SolModify").css("display", "");

            for (let i = 0; i < data.length; i++) {
                if(i == 0){
                    $j("#resseq").val(data[i].resseq);
                    $j("#res_adminname").val(data[i].admin_user);
                    $j("#user_name").val(data[i].user_name);
                    var arrTel = data[i].user_tel.split("-");
                    $j("#user_tel1").val(arrTel[0]);
                    $j("#user_tel2").val(arrTel[1]);
                    $j("#user_tel3").val(arrTel[2]);
                    $j("#res_company").val(data[i].res_company);
                    $j("#res_confirm").val(data[i].res_confirm);
                    $j("#memo").val(data[i].memo);
                    $j("#memo2").val(data[i].memo2);
                }

                if(data[i].res_type == "stay"){ //숙박&바베큐
                    fnSolAdd(null, 'trstay');
                    
                    var objTr = $j("tr[id=trstay]:last");
                    objTr.find("#stayseq").val(data[i].ressubseq);
                    objTr.find("#staytype").val("U");
                    objTr.find("#res_staysex").val(data[i].staysex);
                    objTr.find("#res_stayM").val(data[i].stayM);
                    
                    if(data[i].prod_name != "N"){
                        objTr.find("#res_stayshop").val(data[i].prod_name);
                        objTr.find("input[calid=res_staysdate]").val(data[i].sdate);
                        objTr.find("input[calid=res_stayedate]").val(data[i].edate);

                        if(data[i].stayroom != ""){  
                            objTr.find("#res_stayroom").val(data[i].stayroom);

                            fnRoomNum2(objTr.find("#res_staynum"), data[i].staynum);
                        }
                    }
                    if(data[i].bbq != "N"){
                        objTr.find("input[calid=res_bbqdate]").val(data[i].resdate);
                        objTr.find("#res_bbq").val(data[i].bbq);
                    }
                }else{ //강습&렌탈
                    fnSolAdd(null, 'trsurf');

                    var objTr = $j("tr[id=trsurf]:last");
                    objTr.find("#surfseq").val(data[i].ressubseq);
                    objTr.find("#surftype").val("U");
                    objTr.find("input[calid=res_surfdate]").val(data[i].resdate);
                    if(data[i].prod_name != "N"){
                        objTr.find("#res_surfshop").val(data[i].prod_name);
                        objTr.find("#res_surftime").val(data[i].restime);
                        objTr.find("#res_surfM").val(data[i].surfM);
                        objTr.find("#res_surfW").val(data[i].surfW);
                    }
                    if(data[i].surfrent != "N"){
                        objTr.find("#res_rent").val(data[i].surfrent);
                        objTr.find("#res_rentM").val(data[i].surfrentM);
                        objTr.find("#res_rentW").val(data[i].surfrentW);
                    }
                }
            }
        }
    });

}

function fnSolDataAdd(gubun){
    //공백 제거
    fnFormTrim("#frmModify");

    if($j("#user_name").val() == ""){
        alert("예약자이름을 입력하세요~");
        return;
    }

    if($j("#user_tel1").val() == "" || $j("#user_tel2").val() == "" || $j("#user_tel3").val() == ""){
        alert("연락처를 입력하세요~");
        return;
    }

    if($j("select[id=res_stayshop]").length == 1 && $j("select[id=res_surfshop]").length == 1){
        alert("숙박 및 서핑강습 신청 정보가 없습니다.");
        return;
    }else{
        for (let i = 1; i < $j("select[id=res_stayshop]").length; i++) {
            if($j("select[id=res_stayshop]").eq(i).val() == "N" && $j("select[id=res_bbq]").eq(i).val() == "N"){
                alert("숙박/파티 중 하나이상 선택해주세요~");
                return;
            }
            
            if($j("select[id=res_stayshop]").eq(i).val() == "N"){
                $j("input[calid=res_staysdate]").eq(i).val("");
                $j("input[calid=res_stayedate]").eq(i).val("");
            }else{
                if($j("input[calid=res_staysdate]").eq(i).val() == "" || $j("input[calid=res_stayedate]").eq(i).val() == ""){
                    alert("숙박 이용 날짜를 선택해주세요~");
                    return;
                }
            }

            if($j("select[id=res_bbq]").eq(i).val() == "N"){
                $j("input[calid=res_bbqdate]").eq(i).val("");
            }else{
                if($j("input[calid=res_bbqdate]").eq(i).val() == ""){
                    alert("파티 이용 날짜를 선택해주세요~");
                    return;
                }
            }
        }

        for (let i = 1; i < $j("select[id=res_surfshop]").length; i++) {
            if($j("select[id=res_surfshop]").eq(i).val() == "N" && $j("select[id=res_rent]").eq(i).val() == "N"){
                alert("강습/렌탈 중 하나이상 선택해주세요~");
                return;
            }

            if($j("input[calid=res_surfdate]").eq(i).val() == ""){
                alert("강습/렌탈 이용 날짜를 선택해주세요~");
                return;
            }

            if($j("select[id=res_surfshop]").eq(i).val() != "N" && ($j("select[id=res_surfM]").eq(i).val() == "0" && $j("select[id=res_surfW]").eq(i).val() == "0")){
                alert("강습신청 인원을 선택해주세요~");
                return;
            }

            if($j("select[id=res_rent]").eq(i).val() != "N" && ($j("select[id=res_rentM]").eq(i).val() == "0" && $j("select[id=res_rentW]").eq(i).val() == "0")){
                alert("렌탈신청 인원을 선택해주세요~");
                return;
            }
        }
    }

    //$j("#resparam").val(gubun);
    
    var text1 = "예약등록을 하시겠습니까?";
    var text2 = "예약등록이 완료되었습니다.";
    if(gubun == "modify"){
        text1 = "수정을 하시겠습니까?";
        text2 = "수정이 완료되었습니다.";
    }else{
        $j("#resseq").val("");
    }

	if(!confirm(text1)){
		return;
	}

    //frmModify
    var formData = $j("#frmModify").serializeArray();
	$j.post("/act/admin/sol/res_sollist_save.php", formData,
		function(data, textStatus, jqXHR){
			if(data == 0){
				alert(text2);
                //location.reload();

                var selDate = $j("#listdate").text(); //달력 선택 날짜
                fnSearchAdminSolList(selDate);
                fnModifyClose();
                fnSolpopupReset();
			}else{
                var arrRtn = data.split('|');
                if(arrRtn[0] == "err"){
                    alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요." + "\n\n" + arrRtn[1]);
                    $j("#memo2").val(arrRtn[1]);
                }else{
                    alert(arrRtn[1] + "호 " + arrRtn[2] + "번 침대는 예약되어있습니다.\n\n다른 침대 및 호실을 선택해주세요~");
                }
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
	});
}

function fnRoomNum(obj){
    var objNext = $j(obj).next();
    objNext.find("option").remove();

    var roomnum = 0;
    switch ($j(obj).val()) {
        case "201":
            roomnum = 8;
            break;
        case "202":
            roomnum = 10;
            break;
        case "203":
            roomnum = 6;
            break;
        case "204":
            roomnum = 8;
            break;
        case "301":
            roomnum = 12;
            break;
        case "302":
            roomnum = 8;
            break;
        case "303":
            roomnum = 10;
            break;
    }

    if(roomnum == 0){
        objNext.append("<option value=''>-------</optoin>");
    }else{
        for (var i = 1; i <= roomnum; i++) {
            var roombad = "번 (2층)";
            if((i % 2) == 1){
                roombad = "번 (1층)";
            }
            objNext.append("<option value='" + i + "'>" + i + roombad + "</optoin>");
        }
    }
}

function fnRoomNum2(obj, val){
    obj.find("option").remove();

    var roomnum = 0;
    switch (obj.prev().val()) {
        case "201":
            roomnum = 8;
            break;
        case "202":
            roomnum = 10;
            break;
        case "203":
            roomnum = 6;
            break;
        case "204":
            roomnum = 8;
            break;
        case "301":
            roomnum = 12;
            break;
        case "302":
            roomnum = 8;
            break;
        case "303":
            roomnum = 10;
            break;
    }

    if(roomnum == 0){
        objNext.append("<option value=''>-------</optoin>");
    }else{
        for (var i = 1; i <= roomnum; i++) {
            var roombad = "번 (2층)";
            if((i % 2) == 1){
                roombad = "번 (1층)";
            }

            var sel = "";
            if(i == val){
                sel = "selected";
            }
            obj.append("<option value='" + i + "' " + sel + ">" + i + roombad + "</optoin>");
        }
    }
}

//달력 날짜 클릭
function fnPassengerAdminSol(obj) {
	var selDate = obj.attributes.value.value;
    $j("#right_article3 calBox").css("background", "white");
    $j("calBox[sel=yes]").attr("sel", "no");
	$j(obj).css("background", "#efefef");
	$j(obj).attr("sel", "yes");

	// $j("#sDate").val(selDate);
	// $j("#eDate").val(selDate);
	// $j("#hidselDate").val(selDate);

	// $j("#schText").val('');

	// if(seq == 0){
    // 	$j("#divResList").load("/act/admin/bus/" + mobileuse + "res_busmng.php?selDate=" + selDate);
	// 	$j("#initText2").css("display", "none");
	// 	var url = "bus/" + mobileuse + "res_buslist_search.php";
	// }else if(seq == -1){
	// 	var url = "act_admin/res_surflist_search.php";
	// }else{
	// 	var url = "shop/res_surflist_search.php";
	// }

	// $j("input[id=chkResConfirm]").prop("checked", false);

	// var arrGubun = $j(obj).attr("gubunchk").split(',');
	// for (var i = 0; i < arrGubun.length; i++) {
	// 	$j("input[id=chkResConfirm][value=" + arrGubun[i] + "]").prop('checked', true);
	// }

    fnSearchAdminSolList(selDate);
}

function fnCalMoveAdminListSol(selDate, day) {
	var nowDate = new Date();
	
    $j("#right_article3").load("/act/admin/sol/res_calendar.php?selDate=" + selDate + "&selDay=" + day + "&t=" + nowDate.getTime());
    //fnSearchAdminSolList("");
}

function fnSearchAdminSolList(selDate){
    $j("#mnglist").css("display", "inline-block");
    $j("#mnglistStay").css("display", "none");
    $j("#mnglistSurf").css("display", "none");

	var formData = {"selDate": selDate};
	$j.post("/act/admin/sol/res_sollist_search.php", formData,
		function(data, textStatus, jqXHR){
           $j("#mnglist").html(data);
           $j("#roomdate").text($j("#listdate").text());

           if($j("#hidrowcnt").length > 0 && $j("#hidrowcnt").val() != ""){
                var arrRowCnt = $j("#hidrowcnt").val().split('|');
                var nextrowCnt = 2;
                for (let i = 0; i < (arrRowCnt.length - 1); i++) {
                    var rowCnt = arrRowCnt[i];

                    if(rowCnt > 1){
                        $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(0).attr("rowspan", rowCnt);
                        $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(1).attr("rowspan", rowCnt);
                        $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(12).attr("rowspan", rowCnt);
                        $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(13).attr("rowspan", rowCnt);
                        $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(14).attr("rowspan", rowCnt);
                        $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(15).attr("rowspan", rowCnt);
                        $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(16).attr("rowspan", rowCnt);
                        $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(17).attr("rowspan", rowCnt);
                        for (let x = 1; x < rowCnt; x++) {
                            nextrowCnt++;
                            $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(17).remove();
                            $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(16).remove();
                            $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(15).remove();
                            $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(14).remove();
                            $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(13).remove();
                            $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(12).remove();
                            $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(1).remove();
                            $j("#tbSolList tr").eq(nextrowCnt).find('td').eq(0).remove();
                        }
                    }
                    nextrowCnt++;
                }
            }
            //1|2|1|1|1|2|

           $j("td[room]").html("");
           $j("td[room]").prev().css("color", "#c0c0c0");
           $j("td[room]").removeAttr("onclick");
           $j("td[room]").css("cursor", "");
           
           if($j("td[stayinfo]").length > 0){
               for (let i = 0; i < $j("td[stayinfo]").length; i++) {
                    var arrInfo = $j("td[stayinfo]").eq(i).attr("stayinfo").split('|');
                    if(arrInfo[2] == "솔게하"){
                        //$user_name|$user_name|$prod_name|$staysex|$stayroom|$staynum|".$row['eDateDiff']."|$eDay|$resseq
                        var tbID = arrInfo[4];
                        // if(arrInfo[4] == "301"){
                        //     if(arrInfo[5] < 7){
                        //         tbID = "3011";
                        //     }else{
                        //         tbID = "3012";
                        //     }
                        // }else{
                            
                        // }

                        //((arrInfo[6] > 1) ? "(" + arrInfo[6] + "박)" : "")
                        $j("#" + tbID + arrInfo[5]).prev().css("color", "black");
                        $j("#" + tbID + arrInfo[5]).css("color", "black").css("cursor", "pointer");
                        $j("#" + tbID + arrInfo[5]).attr("onclick", "fnSolModify(" + arrInfo[8] + ");");
                        //
                        $j("#" + tbID + arrInfo[5]).html((($j("#" + tbID + arrInfo[5]).text() == "" ? "" : $j("#" + tbID + arrInfo[5]).text() + "<br>")) + arrInfo[0] + "(" + arrInfo[3] + ") / " + arrInfo[7] + "일" + "(" + arrInfo[6] + "박)");
                    }
               }
           }
		}).fail(function(jqXHR, textStatus, errorThrown){
            alert(textStatus);
	 
	});
}

function fnSearchAdminSolListTab(selDate, url){
	var formData = {"selDate": selDate};
	$j.post("/act/admin/sol/" + url, formData,
		function(data, textStatus, jqXHR){
           $j("#mnglist").html(data);
		}).fail(function(jqXHR, textStatus, errorThrown){
            alert(textStatus);
	 
	});
}

function fnKakaoSend(seq){

}

function fnListTab(gubun, obj){
    var selDate = $j("#listdate").text(); //달력 선택 날짜

    if(gubun == "all"){
        // $j("#mnglist").css("display", "inline-block");
        // $j("#mnglistStay").css("display", "none");
        // $j("#mnglistSurf").css("display", "none");
        
        fnSearchAdminSolList(selDate);
    }else if(gubun == "stay"){
        // $j("#mnglist").css("display", "none");
        // $j("#mnglistStay").css("display", "inline-block");
        // $j("#mnglistSurf").css("display", "none");

        fnSearchAdminSolListTab(selDate, "res_sollist_search_stay.php");
    }else if(gubun == "surf"){
        // $j("#mnglist").css("display", "none");
        // $j("#mnglistStay").css("display", "none");
        // $j("#mnglistSurf").css("display", "inline-block");
        
        fnSearchAdminSolListTab(selDate, "res_sollist_search_surf.php");
    }
}

//숙박,강습 정보 엑셀 다운
function fnExcelDown(){
    var selDate = $j("#listdate").text(); //달력 선택 날짜

    if(!confirm("선택날짜 : " + selDate + "\n\n해당날짜의 정보를 엑셀다운로드 하시겠습니까?")){
       
        return;
    }
}

function fnRentYN(obj, subseq) {
    if(!confirm("렌탈 사용여부를 변경하시겠습니까?")){
        if($j(obj).val() == "Y")
            $j(obj).val("N");
        else
            $j(obj).val("Y");
        return;
    }
    
    var formData = {"resparam":"solrentyn","subseq": subseq, "rentyn": $j(obj).val()};
	$j.post("/act/admin/sol/res_sollist_save.php", formData,
		function(data, textStatus, jqXHR){
            var selDate = $j("#listdate").text(); //달력 선택 날짜
            fnSearchAdminSolListTab(selDate, "res_sollist_search_surf.php");
		}).fail(function(jqXHR, textStatus, errorThrown){
            alert(textStatus);
	});
}

function mergeTable(target, index) {
    var loop = null;
    var start_idx = 0;  //최초 td테그의 인덱스를 담을 변수 입니다.
    var add_num = 1;    //마지막 td 테그의 인덱스를 담을 변수 입니다.
    $j(target).find('tr').each(function (idx) {
        var target_text = $j(this).find('td').eq(index).text();
        if (!loop) {  //최초 동작이면
            loop = target_text;
            start_idx = idx;
        } else if (target_text == loop) {  //같은 열이 발견된 것 이라면
            add_num++;
            //같은열이긴 한데 근데 마지막이면
            if (idx == $j(target).find('tr').length - 1) {
                $j(target).find('tr').eq(start_idx).find('td').eq(index).attr("rowSpan", add_num).css('vertical-align', 'middle');
                for (var i = start_idx + 1; i < start_idx + add_num; i++) {
                    $j(target).find('tr').eq(i).find('td').eq(index).hide(); //hide로 변경
                }
            }
        } else { //다른 텍스트가 발견된 것 이라면
            if (add_num != 1) {    //머지가 필요한 경우라면
                $j(target).find('tr').eq(start_idx).find('td').eq(index).attr("rowSpan", add_num).css('vertical-align', 'middle');
                for (var i = start_idx + 1; i < start_idx + add_num; i++) {
                    $j(target).find('tr').eq(i).find('td').eq(index).hide(); //hide로 변경
                }
            }
            start_idx = idx;
            loop = target_text;
            add_num = 1;
        }
    });
}