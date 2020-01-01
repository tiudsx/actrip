<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

$select_query_admin = 'SELECT a.*, b.gubun, b.codename, b.code FROM `SURF_SHOP` as a LEFT JOIN SURF_CODE as b ON a.cate_3 = b.seq ORDER BY shoporder';
$resultAdmin = mysqli_query($conn, $select_query_admin);

$shoplist2 = "";
$shoplist3 = "";
$shopcate3 = "";

$arrShopCateT = array();
$arrShopT = array();
while ($rowAdmin = mysqli_fetch_assoc($resultAdmin)){
	$intseq = $rowAdmin["intseq"];
	$groupcode = $rowAdmin["groupcode"];
	$shopname = $rowAdmin["shopname"];
	$useYN = $rowAdmin["useYN"];
	$shopcode = $rowAdmin["shopcode"];
	
	$gubun = $rowAdmin["gubun"];
	$codename = $rowAdmin["codename"];
	$code = $rowAdmin["code"];

	$shoplist2 .= "shopList2.$gubun.$code = '$codename';";
	$shopcate3 .= "shopList3.$code = {};";

	$shoplist3 .= 'shopList3.'.$code.'["'.$intseq.'"] = "'.$shopname.'";';

}

$typeT = [0,1,2,3,4];
?>

<meta name="viewport" content="width=device-width, initial-scale=0.7, minimum-scale=0.5, maximum-scale=1, user-scalable=yes" />

<div class="bd_tl" style="width:100%;display:;">
	<h1 class="ngeb clear"><i class="bg_color"></i>상품관리 - 목록</h1>
</div>

<link rel="stylesheet" type="text/css" href="Admin_surf.css?v=3" />
<script src="SuperAdmin_surf.js?v=1"></script>

<script>
var userid = "<?=$user_id?>";

$j(document).ready(function(){
	fnAdminSearch();
	
	<?=$shoplist2?>

	<?=$shopcate3?>

	<?=$shoplist3?>
});
</script>
<?php
/*
session_start(); // 세션 ID 발급됨
echo '<br>1:'.session_id(); // 세션 ID 출력

$_SESSION['m1'] = '2';

echo '<br>2:'.$_SESSION['m1']; // 세션 ID 출력
echo '<br>3:'.(isset($_SESSION["m1"])); // 세션 ID 있음
echo '<br>4:'.(isset($_SESSION["m12"])); // 세션 ID 없음
*/
?>
<div class="container" id="contenttop">
  <section>
    <aside class="left_article3">
<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <ul class="tabs">
        <li class="active" rel="tab1">상품목록</li>
        <li rel="tab2">상품수정</li>
        <li rel="tab3">상품등록</li>
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
						<!--label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="3" checked="checked" style="vertical-align:-3px;" />임시확정</label-->
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="5" style="vertical-align:-3px;" />확정</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="1" style="vertical-align:-3px;" />취소</label><br>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="4" checked="checked" style="vertical-align:-3px;" />임시취소</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="6" checked="checked" style="vertical-align:-3px;" />환불요청</label>
						<label><input type="checkbox" id="chkResConfirm" name="chkResConfirm[]" value="7" style="vertical-align:-3px;" />환불완료</label>
					</td>
				</tr>
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
					<th>샵 목록</th>
					<td>
						<select id="shoplist1" name="shoplist1" class="select" style="padding:1px 2px 4px 2px;" onchange="cateList(this, 'shoplist');">
							<option value="ALL">== 전체 ==</option>
							<option value="surfeast">동해-양양</option>
							<option value="surfeast2">동해-고성</option>
							<option value="surfeast3">동해-강릉</option>
							<option value="surfjeju">제주</option>
							<option value="surfsouth">남해</option>
							<option value="surfwest">서해</option>
							<option value="etc">기타</option>
						</select>
						<select id="shoplist2" name="shoplist2" class="select" style="padding:1px 2px 4px 2px;" onchange="cateList2(this, 'shoplist');">
							<option value="ALL">== 전체 ==</option>
						</select>
						<select id="shoplist3" name="shoplist3" class="select" style="padding:1px 2px 4px 2px;">
							<option value="ALL">== 전체 ==</option>
							<?=$shoplist?>
						</select>
					</td>
				</tr>
				<tr>
					<th>검색기간</th>
					<td align="center">
						<input type="text" id="sDate" name="sDate" cal="date" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >&nbsp;~
						<input type="text" id="eDate" name="eDate" cal="date" readonly="readonly" style="width:66px;" value="" class="itx2" maxlength="7" >
						<input type="button" class="bd_btn" style="padding-top:4px;font-family: gulim,Tahoma,Arial,Sans-serif;" value="전체" onclick="fnDateReset();" />
					</td>
				</tr>
				<tr>
					<th>검색어</th>
					<td><input type="text" id="schText" name="schText" value="" class="itx2" style="width:140px;"></td>
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
				<b>날짜를 선택하세요.</b>
			</div>
			<div id="divDaySelect"></div>
			<div id="divResList" ></div>
		</div>

		
        <!-- #tab3 -->
        <div id="tab3" class="tab_content">
		</div>

		<?if($user_id == "surfenjoy"){?>
		<div id="tab4" class="tab_content">			
			<div id="divCalList">
				<?include 'SuperAdmin_SurfCalList.php'?>
			</div>
		</div>
		<?}?>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
  </section>
</div>

<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:400px;display:none;"></iframe>
