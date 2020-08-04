<?php
include __DIR__.'/../../db.php';

include __DIR__.'/../../surf/surffunc.php';

$schText = $_REQUEST["param"];
$arrChk = explode("|", decrypt($schText));

$dateChk = $arrChk[0];
if(plusDate($dateChk, 2) <= date("Y-m-d")){
	//echo '<div style="text-align:center;font-size:14px;padding:50px 0px 50px 0px;">
	//			<b>빠른예약 조회 기간이 종료되었습니다.<br><br>로그인 후 [서프샵-예약관리] 메뉴를 이용해주세요.</b>
	//		</div>';
	//return;
}
?>
<script>
    var mobileuse = "";
</script>
<div id="wrap">
    <? include __DIR__.'/../../_layout_top.php'; ?>

    <link rel="stylesheet" type="text/css" href="/act/css/surfview.css">
    <link rel="stylesheet" type="text/css" href="/act/css/admin/admin_surf.css">
    <link rel="stylesheet" type="text/css" href="/act/css/jquery-ui.css" />
    
<?
if(count($arrChk) == 3){ //현재 예약건만 보기
    $MainNumber = trim($arrChk[1]);
    $shopseq = trim($arrChk[2]);

    include 'res_kakao_1.php';

}else{ //전체 예약건 임시로 보기
    $shopseq = trim($arrChk[1]);
    
    echo "<div id='rescontent'>";
    include 'res_kakao_all.php';
    echo "</div>";
}
?>
</div>

<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:400px;display:none;"></iframe>

<script type="text/javascript" src="/act/js/admin_surf.js"></script>

<? include __DIR__.'/../../_layout_bottom.php'; ?>