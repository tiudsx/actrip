function fnBusPopupReset() {
    $j("#frmModify")[0].reset();

    $j("tr[rowadd=1]").remove();
}

function fnBusInsert() {
    $j.blockUI({
        message: $j('#res_modify'),
        focusInput: false,
        css: { width: '90%', textAlign: 'left', left: '5%', top: '14%' }
    });
}

function fnBusAdd(id) {
    var date = (new Date()).yyyymmdd(); //오늘 날짜
    var objTr = $j("tr[id=" + id + "]").eq(0);

    $j("tr[id=" + id + "]:last").after(objTr.clone());
    $j("tr[id=" + id + "]:last").css("display", "")
    $j("tr[id=" + id + "]:last").find('input[cal=date]').removeClass('hasDatepicker').removeAttr('id').datepicker({
        onClose: function(selectedDate) {
            var date = jQuery(this).datepicker('getDate');
            if (!(date == null)) {
                jQuery(this).next().select();
            }
        }
    });
    $j("tr[id=" + id + "]:last").attr("rowadd", "1");
}

function fnBusModify(resseq) {
    var params = "resparam=busview&resseq=" + resseq;
    $j.ajax({
        type: "POST",
        url: "/act/admin/bus/res_bus_info.php",
        data: params,
        success: function(data) {
            fnBusPopupReset();

            fnBusInsert();

            for (let i = 0; i < data.length; i++) {
                if (i == 0) {
                    $j("#resseq").val(data[i].resseq);
                    if (data[i].admin_user == "" || data[i].admin_user == null) {
                        $j("#res_adminname").val("이승철");
                    } else {
                        $j("#res_adminname").val(data[i].admin_user);
                    }
                    $j("#user_name").val(data[i].user_name);
                    $j("#user_tel").val(data[i].user_tel);
                    $j("#resnumer").text(data[i].resnum);
                    $j("#resnum").val(data[i].resnum);
                    $j("#insdate").val(data[i].insdate);
                    $j("#confirmdate").val(data[i].confirmdate);
                    $j("#res_coupon").val(data[i].res_coupon);
                    $j("#res_price_coupon").val(data[i].res_price_coupon);
                    $j("#res_price").val(data[i].res_price);
                    $j("#etc").val(data[i].etc);
                    $j("#memo").val(data[i].memo);
                    $j("#user_email").val(data[i].user_email);
                }

                fnBusAdd('trbus');

                var objTr = $j("tr[id=trbus]:last");
                objTr.find("#res_confirm").val(data[i].res_confirm);
                objTr.find("#res_confirmText").text(objTr.find("#res_confirm option:selected").text());
                objTr.find("#rtn_charge_yn").val(data[i].rtn_charge_yn);
                objTr.find("#res_seat").val(data[i].res_seat);
                objTr.find("input[calid=res_date]").val(data[i].res_date);
                objTr.find("#ressubseq").val(data[i].ressubseq);
                objTr.find("#res_busnum").val(data[i].res_busnum);
                fnBusPointSel2(objTr, data[i].res_busnum, data[i].res_spointname, data[i].res_epointname, 1);
            }
        }
    });
}

function fnBusPointSel2(obj, objVlu, sname, ename, num) {
    var sPoint = "";
    var ePoint = "";

    var arrObjs = eval("busPoint.sPoint" + objVlu);
    var arrObje = eval("busPoint.ePoint" + objVlu.substring(0, 1));
    arrObjs.forEach(function(el) {
        if (sname == "") {
            sPoint += "<option value='" + el.code + "'>" + el.codename + "</option>";
        } else {
            sPoint += "<option value='" + el.code + "' selected>" + el.codename + "</option>";
        }
    });
    arrObje.forEach(function(el) {
        if (sname == "") {
            ePoint += "<option value='" + el.code + "'>" + el.codename + "</option>";
        } else {
            ePoint += "<option value='" + el.code + "' selected>" + el.codename + "</option>";
        }
    });

    if (num == 2) {
        obj = $j(obj).parents("tr");
    }

    obj.find("#res_spointname").html(sPoint);
    obj.find("#res_epointname").html(ePoint);
}

function fnBusDataAdd(gubun) {
    //공백 제거
    // fnFormTrim("#frmModify");

    if ($j("#user_name").val() == "") {
        alert("예약자이름을 입력하세요~");
        return;
    }

    // if($j("#user_tel1").val() == "" || $j("#user_tel2").val() == "" || $j("#user_tel3").val() == ""){
    //     alert("연락처를 입력하세요~");
    //     return;
    // }
    if ($j("#user_tel").val() == "") {
        alert("연락처를 입력하세요~");
        return;
    }

    if ($j("select[id=res_stayshop]").length == 1 && $j("select[id=res_surfshop]").length == 1) {
        alert("숙박 및 서핑강습 신청 정보가 없습니다.");
        return;
    } else {
        for (let i = 1; i < $j("select[id=res_stayshop]").length; i++) {
            if ($j("select[id=res_stayshop]").eq(i).val() == "N" && $j("select[id=res_bbq]").eq(i).val() == "N") {
                alert("숙박/파티 중 하나이상 선택해주세요~");
                return;
            }

            if ($j("select[id=res_stayshop]").eq(i).val() == "N") {
                $j("input[calid=res_staysdate]").eq(i).val("");
                $j("input[calid=res_stayedate]").eq(i).val("");
            } else {
                if ($j("input[calid=res_staysdate]").eq(i).val() == "" || $j("input[calid=res_stayedate]").eq(i).val() == "") {
                    alert("숙박 이용 날짜를 선택해주세요~");
                    return;
                }
            }

            if ($j("select[id=res_bbq]").eq(i).val() == "N") {
                $j("input[calid=res_bbqdate]").eq(i).val("");
            } else {
                if ($j("input[calid=res_bbqdate]").eq(i).val() == "") {
                    alert("파티 이용 날짜를 선택해주세요~");
                    return;
                }
            }
        }

        for (let i = 1; i < $j("select[id=res_surfshop]").length; i++) {
            if ($j("select[id=res_surfshop]").eq(i).val() == "N" && $j("select[id=res_rent]").eq(i).val() == "N") {
                alert("강습/렌탈 중 하나이상 선택해주세요~");
                return;
            }

            if ($j("input[calid=res_surfdate]").eq(i).val() == "") {
                alert("강습/렌탈 이용 날짜를 선택해주세요~");
                return;
            }

            if ($j("select[id=res_surfshop]").eq(i).val() != "N" && ($j("select[id=res_surfM]").eq(i).val() == "0" && $j("select[id=res_surfW]").eq(i).val() == "0")) {
                alert("강습신청 인원을 선택해주세요~");
                return;
            }

            if ($j("select[id=res_rent]").eq(i).val() != "N" && ($j("select[id=res_rentM]").eq(i).val() == "0" && $j("select[id=res_rentW]").eq(i).val() == "0")) {
                alert("렌탈신청 인원을 선택해주세요~");
                return;
            }
        }
    }

    //$j("#resparam").val(gubun);

    var text1 = "예약등록을 하시겠습니까?";
    var text2 = "예약등록이 완료되었습니다.";
    if (gubun == "modify") {
        text1 = "수정을 하시겠습니까?";
        text2 = "수정이 완료되었습니다.";
    } else {
        $j("#resseq").val("");
    }

    if (!confirm(text1)) {
        return;
    }

    //frmModify
    var formData = $j("#frmModify").serializeArray();
    $j.post("/act/admin/sol/res_sollist_save.php", formData,
        function(data, textStatus, jqXHR) {
            if (data == 0) {
                alert(text2);
                //location.reload();

                var selDate = $j("#listdate").text(); //달력 선택 날짜
                fnSearchAdminSolList(selDate);
                fnCalMoveAdminListSol($j(".tour_calendar_month").text().replace(".", ""));
                fnModifyClose();
                fnSolpopupReset();
            } else {
                var arrRtn = data.split('|');
                if (arrRtn[0] == "err") {
                    alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요." + "\n\n" + arrRtn[1]);
                    $j("#memo2").val(arrRtn[1]);
                } else {
                    alert(arrRtn[1] + "호 " + arrRtn[2] + "번 침대는 예약되어있습니다.\n\n다른 침대 및 호실을 선택해주세요~");
                }
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {});
}

function fnSelChange(obj, num) {
    if ($j(obj).val() == "") {

    } else {
        $j(".allselect" + num).val($j(obj).val());
        $j(obj).val("");
    }
}