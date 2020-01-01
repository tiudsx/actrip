function fnResSel2() {
    if ($j.trim($j("#resNumber").val()) == "") {
        alert("예약번호를 입력하세요.");
        return;
    }
    $j("#surfSelOk").load(folderRoot + "/SearchMain_OK.php?resNumber=" + $j.trim($j("#resNumber").val().replace(/ /g, '')));
}

function fnResSel3() {
	$j("#surfSel").css("display", "");
	$j("#surfSelOk").css("display", "none");
}

function fnResSel4() {
	$j("#surfSel").css("display", "none");
	$j("#surfSelOk").css("display", "");
}

//취소/환불 신청
function fnRefund(gubun) {
	if($j("input[id=chkCancel]:checked").length == 0){
		alert("선택된 항목이 없습니다.");
		return;
	}

	if($j("#hidtotalPrice").val() > 0){
		if($j("#bankName").val() == ""){
			alert("은행이름을 입력하세요.");
			return;
		}

		if($j("#bankNum").val() == ""){
			alert("계좌번호를 입력하세요.");
			return;
		}
	}

	$j("#userId").val(userid);
	var msg = "신청 하시겠습니까?";
    if (confirm(msg)) {
		var formData = $j("#frmCancel").serializeArray();

		$j.post(folderRoot + "/SearchMain_Save.php", formData,
			function(data, textStatus, jqXHR){
			   if(fnRtnText(data, 0)){
				   fnResSel2();
			   }
			}).fail(function(jqXHR, textStatus, errorThrown){
		 
		});
    }
}

//환불 수수료 계산
function fnCancelSum(obj, gubun, MainNumber){
	var chkVlu = $j("input[id=chkCancel]:checked").map(function () { return $j(this).val(); }).get();

	$j("#tdCancel1").html("0");
	$j("#tdCancel2").html("0");
	$j("#tdCancel3").html("0");
	$j("#hidtotalPrice").val("0");
	$j("#gubun").val(gubun);
	$j("#MainNumber").val(MainNumber);

	if(chkVlu == ""){
		$j('#bankName').val('');
		$j('#bankUserName').val('');
		$j('#bankNum').val('');
		$j('#returnBank').css('display', 'none');
	}else{
		var resParam = "RtnPrice";
		if(gubun == "bus" || gubun == "bbq"){
			resParam = "RtnPrice2";
		}

		var formData = {"resparam":resParam, "gubun":gubun, "subintseq":"'" + chkVlu + "'"};

		$j.post(folderRoot + "/SearchMain_Save.php", formData,
			function(data, textStatus, jqXHR){
			   if(data == "0"){
				   alert("환불 수수료 계산 중 오류가 발생하였습니다.\n\n다시 체크 하시거나 관리자에게 문의주세요.");
				   $j("input[id=chkCancel]").prop("checked", false);
			   }else{
				   var arrData = data.split('|');

					$j("#tdCancel1").html(commify(arrData[0]));
					$j("#tdCancel2").html(commify(arrData[1]));
					$j("#tdCancel3").html(commify(arrData[2]));
					$j("#hidtotalPrice").val(arrData[2]);

					if(arrData[2] > 0){
						$j('#returnBank').css('display', '');
					}else{
						$j('#bankName').val('');
						$j('#bankUserName').val('');
						$j('#bankNum').val('');
						$j('#returnBank').css('display', 'none');
					}

			   }
			}).fail(function(jqXHR, textStatus, errorThrown){
		 
		});
	}
}