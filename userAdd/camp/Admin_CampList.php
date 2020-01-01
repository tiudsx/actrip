<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';

$MainNumber = $_REQUEST["MainNumber"]; //카카오에서 넘어오는 파라미터
?>

<link rel="stylesheet" type="text/css" href="camp_admin.css" />
<script src="camp_admin.js"></script>

<script>
var userid = "<?=$user_id?>";
$j(document).ready(function(){
	fnAdminSearch();
});
</script>

<div class="container" id="contenttop">
  <section>
    <article class="right_article3">
		<?include 'Admin_CampListCalendar.php'?>
    </article>
    <aside class="left_article3">
<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <ul class="tabs">
        <li class="active" rel="tab1">예약목록</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <!-- #tab1 -->
        <div id="tab1" class="tab_content">
			<div style="text-align:center;font-size:14px;padding:50px;" id="initText2">
				<b>달력에서 날짜를 클릭하세요.</b>
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