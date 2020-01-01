<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';
?>

<script>
function fnBusPointMon(gubun, num, obj, pointname){
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

	$j("#mapimg").css("display", "none");
	$j("#ifrmBusMap").css("display", "none");

	fnBusMap2(gubun, 6, num, pointname);
}

//날짜 클릭후 서핑버스 좌석 표시
function fnBusSeatMon(gubun, num) {
	var sDate = $j("#hidSurfBus" + gubun).val();

    $j("#busSeat").load(folderBusRoot + "/Mon_BusRes_info.php?selDate=" + sDate + "&busNum=" + (gubun + num));

	$j("ul.tabs li").eq(3).click();
}

function fnBusSeatViewMon(){
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

//서핑버스 선택시 계산
function fnSeatSelectedMon(obj){
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
							'					<td style="text-align:center;" onclick="fnSeatDelMon(this, ' + obj.value + ');"><img src="/userAdd/del.jpg" width="20" /></td>' +
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
							'					<td style="text-align:center;" onclick="fnSeatDelMon(this, ' + obj.value + ');"><img src="/userAdd/del.jpg" width="20" /></td>' +
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
	fnPriceSumMon('', 1);
}

function fnPriceSumMon(obj, num){
	if(num == 1){
		var cnt = $j("input[id=hidbusSeatY]").length + $j("input[id=hidbusSeatS]").length;

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
		}

		var strDis = "";
		
		$j("#totalPrice").html(commify((cnt * 16000) - (totalDisCnt * 0)) + "원" + strDis);
		$j("#lastbusPrice").html((cnt * 16000) - (totalDisCnt * 0));
	}

	$j("#lastPrice").html(commify(Number($j("#lastbusPrice").html()) + Number($j("#lastbbqPrice").html(), 10)) + "원");
}

//서핑버스 좌석선택 삭제
function fnSeatDelMon(obj, num){
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

	fnPriceSumMon('', 1);
}

//서핑버스 예약하기
function fnBusSaveMon() {
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
</script>

<div class="" style="width:100%;display:;">
	<h1 class="ngeb clear" style="font-size:16px;height:25px;"><i class="bg_color"></i>몬스터서퍼스 셔틀버스 예약하기</h1>
</div>

<div class="container" id="contenttop">
  <section>
    <aside class="left_article"><img src="http://skinnz.godohosting.com/surfenjoy/bus/busmain.jpg" alt="" width="400" height="200" class="placeholder"/> </aside>
    <article class="right_article">
		<div style="padding-left:10px;">
		<?include 'Mon_BusRes_SubDate.php';?>
		</div>
    </article>
  </section>
</div>

<div class="container">
  <section>
    <aside class="left_article2">

<!-- .tab_container -->
<div id="containerTab">
    <ul class="tabs">
        <li rel="tab1" style="display:none;">셔틀버스 안내</li>
        <li class="active" rel="tab3">정류장 안내</li>
        <li rel="tab2" style="display:none;">바베큐 안내</li>
        <li rel="tab4">좌석선택</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <div id="tab3" class="tab_content">
			<?include 'Mon_BusRes_SubTab3.php';?>

			<?=fnInfoMemo(3, ''); //양양셔틀버스 이용안내?>
		</div>
        <div id="tab1" class="tab_content" style="line-height:0;">
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus01.jpg" class="placeholder2" />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus02.jpg" class="placeholder2" />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus03.jpg" class="placeholder2" style="cursor:pointer;" onclick="fnTabMove(1);" />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus04.jpg?v=2" class="placeholder2" />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus05.jpg" class="placeholder2" style="cursor:pointer;" onclick="fnTabMove(1);"  />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus06.jpg?v=2" class="placeholder2" />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus07.jpg" class="placeholder2" />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus08.jpg" class="placeholder2" />

			<?=fnInfoMemo(3, ''); //양양셔틀버스 이용안내?>
        </div>
        <!-- #tab1 -->
        <div id="tab2" class="tab_content" style="line-height:0;">
			<img src="http://skinnz.godohosting.com/surfenjoy/content/res_bbq01.jpg" class="placeholder2" />
			<img src="http://skinnz.godohosting.com/surfenjoy/content/res_bbq02.jpg" class="placeholder2" />
			<img src="http://skinnz.godohosting.com/surfenjoy/content/res_bbq03.jpg" class="placeholder2" />
			<img src="http://skinnz.godohosting.com/surfenjoy/content/res_bbq04.jpg" class="placeholder2" />
			<img src="http://skinnz.godohosting.com/surfenjoy/content/res_bbq05.jpg" class="placeholder2" />
		</div>
        <!-- #tab2 -->
        <div id="tab4" class="tab_content">

			<div style="padding-top:10px;line-height: 21px;" id="reslist">
				<b style="font-size:12px;">※ 서프엔조이 예약금액은 부가세별도입니다.</b><br>
				&nbsp;&nbsp;- 서핑버스 이용일 이후 부가세분에 대해 추가 결제해주셔야 현금영수증 발행이 됩니다.<br>
			</div>

   			<div class="bd_tl inner" style="width:100%;">
				<div class="bd centered" style="padding:0px;">
					<div class="max600">
						<div class="restab1">
							<div id="tmpBusY"></div>
							<div id="tmpBusS"></div>
						</div>
					</div>
				</div>
			</div>

   			<div class="bd_tl inner" style="width:100%;">
				<div id="busSeat" class="bd max600 centered" style="padding:0px;">
				</div>
			</div>
			<?include 'Mon_BusRes_SubInfo.php';?>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
    <article class="right_article2">
		<div class="bd_tl inner" style="width:100%;">
			<div class="bd max600 centered" style="padding:0px;" id="infochk">
				<div style="margin-top:3px;margin-bottom:3px;display:;" class="max600" id="cancelView">
					<div class="gg_first">이용안내 안내 </div>
					<table class="et_vars exForm bd_tb" width="100%">
						<tbody>
							<tr>
								<th>
									<strong>양양셔틀버스 예약/이용안내</strong>
								</th>
							</tr>
							<tr>
								<td>
								▶ 1시간 이내 미입금시 자동취소됩니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 예약자와 입금자명이 동일해야합니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 서프엔조이 이용금액은 부가세 별도금액입니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 현금영수증 신청은 이용일 또는 이후 [고객센터-현금영수증] 메뉴에서 신청가능합니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 천재지변 및 사전예약 인원수에 따라 셔틀버스 운행이 취소될 수 있습니다.<br>
								&nbsp;&nbsp;&nbsp;취소 될 경우 전액환불해드립니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 셔틀버스 이용 날짜 변경은 7일 이전에만 가능합니다.
								</td>
							</tr>
							<tr>
								<td>
								▶ 탑승/하차 정류장 변경 원하실 경우 플러스친구로 연락주시면 변경가능합니다.
								</td>
							</tr>
							<tr>
								<th>
									<input type="checkbox" id="chk8" name="chk8"> <strong>양양셔틀버스 예약/이용안내 동의</strong> (필수동의)
								</th>
							</tr>
							<tr>
								<th>
									<input type="checkbox" id="chk9" name="chk9"> <strong>개인정보 수집이용 동의 </strong> <a href="/notice/237" target="_blank" style="float:none;">[내용확인]</a> (필수동의)
								</th>
							</tr>
						</tbody>
					</table>
				</div>

				<?=fnReturnText(1, ''); //환불안내?>

			</div>
		</div>	</article>
  </section>
</div>

<!--div id="tallContent" style="display:none;overflow-y:scroll;">
	<iframe id="ifrmBusRes" name="ifrmBusRes" style="width:100%;height:400px;display:none;"></iframe>
	
</div-->

<script>
/*
$j(document).ready(function() { 
    $j('#demo3').click(function() { 
	    jQuery("#busSeat").load("/userAdd/" + folderBus + "/BusRes_info.php?selDate=2018-09-21&weeknum=0&busadd=1&stayCnt=1");

        $j("ul.tabs li").removeClass("active").css("color", "#333");
        $j(".tab_content").hide()
        $j("#tab5").fadeIn()
		
       // $j.blockUI({ 
     //       message: $j('#tallContent'), 
   //         css: { top: '50px', width: '360px', left: '5%' } 
 //       }); 
 
        //setTimeout($j.unblockUI, 2000); 
	});
});
*/
</script>

<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:400px;display:none;"></iframe>

