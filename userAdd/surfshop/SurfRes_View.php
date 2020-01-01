<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';
?>

<script>

$j(document).ready(function(){

});
</script>

<div class="bd_tl" style="width:100%;display:none;">
	<h1 class="ngeb clear"><i class="bg_color"></i>서울 - 양양 셔틀버스 예약하기</h1>
</div>

<div class="container" id="contenttop">
  <section>
    <aside class="left_article"><img src="http://skinnz.godohosting.com/surfenjoy/bus/busmain.jpg" alt="" width="400" height="200" class="placeholder"/> </aside>
    <article class="right_article">
		<div style="padding-left:10px;">
		<?include 'BusRes_SubDate.php';?>
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
        <li class="active" rel="tab1">셔틀버스 안내</li>
        <li rel="tab2">바베큐 안내</li>
        <li rel="tab3">정류장 안내</li>
        <li rel="tab4">약관동의</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <div id="tab1" class="tab_content" style="line-height:0;">
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus01.png" class="placeholder2" />
        </div>
		<div id="tab5" class="tab_content">
   			<div class="bd_tl inner" style="width:100%;">
				<div id="busSeat" class="bd max600 centered" style="padding:0px;">
				</div>
			</div>
        </div>
        <!-- #tab1 -->
        <div id="tab2" class="tab_content" style="line-height:0;">
			<img src="http://skinnz.godohosting.com/surfenjoy/sol/sol3_11.jpg" class="placeholder2" />
			<img src="http://skinnz.godohosting.com/surfenjoy/sol/sol3_12.jpg" class="placeholder2" />
			<img src="http://skinnz.godohosting.com/surfenjoy/sol/sol3_14.jpg" class="placeholder2" />
			<img src="http://skinnz.godohosting.com/surfenjoy/sol/sol3_15.jpg" class="placeholder2" />
			<img src="http://skinnz.godohosting.com/surfenjoy/sol/sol3_16.jpg" class="placeholder2" />
		</div>
        <!-- #tab2 -->
        <div id="tab3" class="tab_content">
			<?include 'BusRes_SubTab3.php';?>
		</div>
        <div id="tab4" class="tab_content">
			<?include 'BusRes_SubTab4.php';?>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
    <article class="right_article2">
		<?include 'BusRes_SubInfo.php';?>
	</article>
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

