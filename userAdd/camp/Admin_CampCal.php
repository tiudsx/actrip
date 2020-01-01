<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';
?>

<link rel="stylesheet" type="text/css" href="camp_admin.css" />
<script src="camp_admin.js"></script>

<script>
var userid = "<?=$user_id?>";
$j(document).ready(function(){
});
</script>

<div class="container" id="contenttop">
  <section>
    <article class="right_article4">
		<?include 'Admin_CampCalCalendar.php'?>
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