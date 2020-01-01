<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

$MainNumber = $_REQUEST["MainNumber"]; //카카오에서 넘어오는 파라미터

if($MainNumber == ""){
	$paramDate = date("Y-m-d");
}
?>

<div class="bd_tl" style="width:100%;display:;">
	<h1 class="ngeb clear"><i class="bg_color"></i>정산관리 - 전체</h1>
</div>

<link rel="stylesheet" type="text/css" href="Admin_surf.css" />
<script src="Admin_surf.js"></script>

<script>
var userid = "<?=$user_id?>";
$j(document).ready(function(){
});
</script>

<div class="container" id="contenttop">
  <section>
    <article class="right_article4">
		<?include 'SuperAdmin_SurfCalCalendar.php'?>
    </article>
    <aside class="left_article4">
<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <ul class="tabs">
        <li class="active" rel="tab1">정산내용</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <!-- #tab1 -->
        <div id="tab1" class="tab_content">
			<div style="text-align:center;font-size:14px;padding:50px;" id="initText2">
			</div>
			<div id="divResList" ></div>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
  </section>
</div>