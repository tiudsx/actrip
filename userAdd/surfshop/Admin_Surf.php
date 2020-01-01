<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

session_start();

if($_SESSION['shopseq'] == ""){
	$select_query_admin = 'SELECT * FROM `SURF_SHOP` where shopcode="'.$surftype.'" limit 1';
	$resultAdmin = mysqli_query($conn, $select_query_admin);
	$countAdmin = mysqli_num_rows($resultAdmin);
	$rowAdmin = mysqli_fetch_array($resultAdmin);

	if($countAdmin == 0){
		echo '<script>alert("관리자 권한이 없습니다.");history.back();</script>';
		exit;
	}

	$_SESSION['userid'] = $user_id;
	$_SESSION['shopseq'] = $rowAdmin["intseq"];
	$_SESSION['shopname'] = $rowAdmin["shopname"];
	$_SESSION['opt_reslist'] = $rowAdmin["opt_reslist"];
}

$typeT = explode(",", $_SESSION['opt_reslist']);

$MainNumber = $_REQUEST["MainNumber"]; //카카오에서 넘어오는 파라미터

if($MainNumber == ""){
	$paramDate = date("Y-m-d");
}
?>

<div class="bd_tl" style="width:100%;display:;">
	<h1 class="ngeb clear"><i class="bg_color"></i>[<?=$_SESSION['shopname']?>] 예약관리</h1>
</div>

<link rel="stylesheet" type="text/css" href="Admin_surf.css?v=4" />
<script src="Admin_surf.js"></script>

<script>
var userid = "<?=$user_id?>";
$j(document).ready(function(){
	fnAdminSearch();
});

function fnListView(obj){
	if($j(obj).parent().next().css("display") == "none"){
		$j("tr[name='btnTrList']").removeClass('selTr');
		$j(obj).parent().addClass('selTr');

		$j("tr[name='btnTrList']").next().css("display", "none");
		$j(obj).parent().next().css("display", "");
	}else{
		$j("tr[name='btnTrList']").removeClass('selTr');

		$j(obj).parent().next().css("display", "none");
	}
}
</script>

<div class="container" id="contenttop">
  <section>
    <article class="right_article3">
		<?include 'Admin_SurfCalendar.php'?>
    </article>
    <aside class="left_article3">
<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <ul class="tabs">
        <li class="active" rel="tab1">검색관리</li>
        <li rel="tab2">예약확정</li>
        <li rel="tab3">매진처리</li>
        <li rel="tab4">정산관리</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <!-- #tab1 -->
        <div id="tab1" class="tab_content">
		<form name="frmSearch" id="frmSearch" autocomplete="off">
			<div class="gg_first" style="margin-top:0px;">예약검색</div>
			<table class='et_vars exForm bd_tb' style="width:100%">
				<colgroup>
					<col style="width:65px;">
					<col style="width:*;">
					<col style="width:100px;">
				</colgroup>
				<tr>
					<th>구분</th>
					<td>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="0" checked="checked" style="vertical-align:-3px;" />미입금</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="2" checked="checked" style="vertical-align:-3px;" />입금완료</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="5" style="vertical-align:-3px;" />확정</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="1" style="vertical-align:-3px;" />취소</label><br>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="4" style="vertical-align:-3px;" />임시취소</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="6" checked="checked" style="vertical-align:-3px;" />환불요청</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="7" style="vertical-align:-3px;" />환불완료</label>
					</td>
				</tr>
				<!--tr>
					<th>구분</th>
					<td>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" checked="checked" value="2" style="vertical-align:-3px;" />예약대기</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="3" style="vertical-align:-3px;" />임시확정</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="4" style="vertical-align:-3px;" />임시취소</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" checked="checked" value="5" style="vertical-align:-3px;" />확정</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" <?if($MainNumber != "") echo 'checked="checked"'?> value="6,7" style="vertical-align:-3px;" />취소</label>
					</td>
				</tr-->
				<tr>
					<th>종류</th>
					<td>
					<?
					foreach($typeT as $item){
						switch($item){
							case 0:
								$itemname = "강습";
								break;
							case 1:
								$itemname = "렌탈";
								break;
							case 2:
								$itemname = "패키지";
								break;
							case 3:
								$itemname = "숙소";
								break;
							case 4:
								$itemname = "바베큐";
								break;
						}


						echo '<label><input type="checkbox" id="chkResType" name="chkResType[]" checked="checked" value="'.$item.'" style="vertical-align:-3px;" />'.$itemname.'</label>&nbsp;';
					}
					?>
					</td>
				</tr>
				<tr>
					<th>검색기간</th>
					<td align="center">
						<input type="text" id="sDate" name="sDate" cal="date" readonly="readonly" value="" class="itx2" maxlength="7" style="width:66px;" >&nbsp;~
						<input type="text" id="eDate" name="eDate" cal="date" readonly="readonly" value="" class="itx2" maxlength="7" style="width:66px;" >
						<input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="전체" onclick="fnDateReset();" />
					</td>
					
				</tr>
				<tr>
					<th>검색어</th>
					<td><input type="text" id="schText" name="schText" value="<?=$MainNumber?>" class="itx2" style="width:140px;"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:120px; height:40px;" value="검색" onclick="fnAdminSearch();" /></td>
				</tr>
			</table>
		</form>
		<div id="mngSearch"></div>
		</div>

        <!-- #tab2 -->
        <div id="tab2" class="tab_content">
			<div style="text-align:center;font-size:14px;padding:50px;" id="initText2">
				<b>달력에서 날짜를 클릭하세요.</b>
			</div>
			<div id="divResList" ></div>
		</div>

		<div id="tab3" class="tab_content">
<?
$select_query = 'SELECT opt_bbq, shopcharge FROM `SURF_SHOP` WHERE intseq = '.$_SESSION['shopseq'];
$result_shop = mysqli_query($conn, $select_query);
$rowshop = mysqli_fetch_array($result_shop);

$opt_bbq = $rowshop["opt_bbq"]; //서프엔조이 바베큐 여부

$bbqSql = "";
if($opt_bbq == "Y"){
	$bbqSql = " AND opt_type != 4";
}

$select_query = 'SELECT * FROM `SURF_SHOP_OPT` WHERE shopSeq = '.$_SESSION['shopseq'].$bbqSql.' ORDER BY opt_type, opt_order';
$result_opt = mysqli_query($conn, $select_query);
?>
<script>
function fnSoldout(){
	var formData = $j("#frmSold").serializeArray();

	if ($j("#strDate").val() == "") {
        alert("날짜를 선택하세요.");
        return;
    }
	if (!($j("#chkSexM").is(':checked') || $j("#chkSexW").is(':checked'))) {
        alert("성별 중 하나이상 선택하세요.");
        return;
    }

	if(!confirm("선택항목을 매진 처리 하시겠습니까?")){
		return;
	}

	$j.post(folderBusRoot + "/Admin_SurfSave.php", formData,
		function(data, textStatus, jqXHR){
			if(data == "1"){
				alert("해당 날짜와 항목은 이미 매진처리 되었습니다.\n\n해당 항목을 삭제 후 추가해주세요.");
			}else if(data == "0"){
				alert("정상적으로 매진 처리되었습니다.");
				$j("#divSoldOutList").load(folderBusRoot + "/Admin_SurfSoldOut.php");
			}else{
				alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");
			}
		   
		}).fail(function(jqXHR, textStatus, errorThrown){
	});
}

function fnSoldModify(seq){
	if(!confirm("선택항목을 삭제 처리 하시겠습니까?")){
		return;
	}

	var params = "resparam=soldoutdel&seq=" + seq;
	jQuery.ajax({
		type: "POST",
		url: folderBusRoot + "/Admin_SurfSave.php",
		data: params,
		success: function (data) {                
			if (data == "0") {
				alert("정상적으로 매진 처리되었습니다.");
				$j("#divSoldOutList").load(folderBusRoot + "/Admin_SurfSoldOut.php");
			} else {
				alert("처리 중 에러가 발생하였습니다.\n\n관리자에게 문의하세요.");
			}
		}
	});
}
</script>

<form name="frmSold" id="frmSold" autocomplete="off">
	<div class="gg_first" style="margin-top:0px;">매진항목 추가</div>
	<table class='et_vars exForm bd_tb' style="width:100%">
		<colgroup>
			<col style="width:65px;">
			<col style="width:*;">
			<col style="width:65px;">
			<col style="width:*;">
		</colgroup>
		
		<tr>
			<th>날짜</th>
			<td align="center">
				<input type="text" id="strDate" name="strDate" readonly="readonly" value="" class="itx2" cal="sdate" style="width:66px;">
				<input type="hidden" id="resparam" name="resparam" size="10" value="soldout" class="itx">
				<input type="hidden" id="userid" name="userid" size="10" value="<?=$user_id?>" class="itx">
			</td>
			<th>항목</th>
			<td align="center">
				<select id="selItem" name="selItem" class="select">
				<?while ($rowOpt = mysqli_fetch_assoc($result_opt)){?>
					<option value="<?=$rowOpt["intSeq"]?>"><?=$rowOpt["opt_name"]?></option>
				<?}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>성별</th>
			<td align="center" colspan="3">
				<label><input type="checkbox" id="chkSexM" name="chkSexM" value="1" checked="checked" style="vertical-align:-3px;" />남</label>&nbsp;
				<label><input type="checkbox" id="chkSexW" name="chkSexW" value="1" checked="checked" style="vertical-align:-3px;" />여</label>
			</td>
		</tr>
		<tr>
			<td style="text-align:center;" colspan="4"><input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:100px; height:30px;" value="매진 추가" onclick="fnSoldout();" /></td>
		</tr>
	</table>
</form>


			<div id="divSoldOutList">
				<?include 'Admin_SurfSoldOut.php'?>
			</div>
		</div>

		<div id="tab4" class="tab_content">
			<div id="divCalList">
				<?include 'Admin_SurfCalList.php'?>
			</div>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
  </section>
</div>