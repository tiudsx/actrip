<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';
?>

<script>

$j(document).ready(function(){
});
</script>

<div class="" style="width:100%;display:;">
	<h1 class="ngeb clear" style="font-size:16px;height:35px;"><i class="bg_color"></i>[서울 - 양양] 셔틀버스 정류장 안내</h1>
</div>

<div class="container">
  <section>
    <aside class="left_article2">

<!-- .tab_container -->
<div id="containerTab">
    <ul class="tabs">
        <li class="active" rel="tab1">정류장 안내</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus03.jpg" class="placeholder2" style="cursor:pointer;padding-top:10px;" onclick="fnResView(true, '#tabmove', 30);" />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus04.jpg" class="placeholder2" />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus05.jpg" class="placeholder2" style="cursor:pointer;" onclick="fnResView(true, '#tabmove', 30);"  />
            <img src="http://skinnz.godohosting.com/surfenjoy/content/res_bus06.jpg" class="placeholder2" />

			<span id="tabmove">&nbsp;</span>
			<?include 'BusRes_SubTab3.php';?>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
    <article class="right_article2">
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

