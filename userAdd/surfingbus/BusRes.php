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
	<h1 class="ngeb clear" style="font-size:16px;height:25px;"><i class="bg_color"></i>서울 - 양양 셔틀버스 예약하기</h1>
</div>

<div class="" style="width:100%;display:;">
	<h1 class="ngeb clear" style="font-size:16px;height:25px;"><i class="bg_color"></i>[서울 - 양양] 서핑버스 예약하기</h1>
</div>

<div class="container" id="contenttop">
  <section>
    <aside class="left_article"><img src="https://surfenjoy.cdn3.cafe24.com/bus/busmain.jpg" alt="" width="400" height="200" class="placeholder"/> </aside>
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
        <li rel="tab3">정류장 안내</li>
        <li rel="tab2" style="display:none;">바베큐 안내</li>
        <li rel="tab4">좌석선택</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <div id="tab1" class="tab_content" style="line-height:0;">
			<center>
			<h2 style="font-size:18px;padding-bottom:12px;line-height:30px;">2019 양양서핑 페스티벌이 곧 열립니다.<br>페스티벌 기간인 10월 12일~10월 13일에 셔틀버스 추가운행 됩니다.
			</h2>
			</center><br>
			<?include __DIR__.'/../contentbanner.php';?>
            <img src="https://surfenjoy.cdn3.cafe24.com/bus/res_bus01.jpg" class="placeholder2" />
            <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus03.jpg" class="placeholder2" style="cursor:pointer;" onclick="fnTabMove(1);" />
            <img src="https://surfenjoy.cdn3.cafe24.com/bus/res_bus04.jpg" class="placeholder2" />
            <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus05.jpg" class="placeholder2" style="cursor:pointer;" onclick="fnTabMove(1);"  />
            <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus06.jpg?v=2" class="placeholder2" />
            <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus07.jpg" class="placeholder2" />
            <img src="https://surfenjoy.cdn3.cafe24.com/content/res_bus08.jpg" class="placeholder2" />

			<?=fnInfoMemo(3, ''); //양양셔틀버스 이용안내?>
        </div>
        <!-- #tab1 -->
        <div id="tab2" class="tab_content" style="line-height:0;">
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq01.jpg" class="placeholder2" />
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq02.jpg" class="placeholder2" />
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq03.jpg" class="placeholder2" />
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq04.jpg" class="placeholder2" />
			<img src="https://surfenjoy.cdn3.cafe24.com/content/res_bbq05.jpg" class="placeholder2" />
		</div>
        <!-- #tab2 -->
        <div id="tab3" class="tab_content">
			<?include 'BusRes_SubTab3.php';?>
		</div>
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
			<?include 'BusRes_SubInfo.php';?>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
    <article class="right_article2">
		<?include 'BusRes_SubTab4.php';?>
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

