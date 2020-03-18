<link rel="stylesheet" type="text/css" href="css/main.css">
<style>
	/*팝업1*/
	#gpe_divpop1{position:absolute; z-index:49;}
	#gpe_divpop1 .pop_area_out{border:1px solid #b6b6b6;}
	#gpe_divpop1 .pop_area_in{border:2px solid #f6f6f6;}
	#gpe_divpop1 .pop_middle{border:1px solid #fff; background-color:#fff;}
	#gpe_divpop1 .pop_middle img{vertical-align:bottom;}
	#gpe_divpop1 .pop_bott{background-color:#f6f6f6; height:28px;}
	#gpe_divpop1 .pop_bott .pop_bott_1day{float:left; padding:8px 0 0 0;}
	#gpe_divpop1 .pop_bott .pop_bott_1day_txt{float:left; letter-spacing:-0.08em; color:#4e4f55; margin-top:8px; margin-left:3px;}
	#gpe_divpop1 .pop_bott .pop_bott_close a{float:right; display:block; width:34px; height:13px; background:url(/layouts/portal_NOVA/imgs/default/default_02.png) no-repeat -267px -19px; margin:8px 0 0 0;}
</style>

<div id="wrap">

<!--visible / hidden-->
<div id="gpe_divpop1" style="top: 70px;padding:0 10px 0 10px; visibility: hidden;">
<form name="gpe_form1"><input type="hidden" name="error_return_url" value="/index"><input type="hidden" name="act" value=""><input type="hidden" name="mid" value="index"><input type="hidden" name="vid" value=""> 
	<div class="pop_area_out">
		<div class="pop_area_in">
			<div class="pop_middle">
				<a href="http://surfenjoy.com/surfres?seq=64"><img src="http://skinnz.godohosting.com/surfenjoy/shop/surfenjoy_new_4.jpg?v=4" alt="당찬패키지" class="placeholder"></a>
			</div>
			<div class="pop_bott">
				<div class="pop_bott_1day"><input name="event1" type="checkbox" value="checkbox2"></div>
				<div class="pop_bott_1day_txt">오늘 이 창 안뛰우기</div>
				<div class="pop_bott_close"><a href="javascript:gpe_closeWin1();"></a></div>
			</div>
		</div>
	</div>
</form>
</div>

<script> 
	var eventCookie=gpe_getCookie1("act_pop1");
	if ( eventCookie != "no1" ){  
		document.all['gpe_divpop1'].style.visibility = "visible";
	} else if(eventCookie == "no1") {
		document.getElementById('gpe_divpop1').style.display='none'; 
	}
	function gpe_closeWin1() { 
	if ( document.gpe_form1.event1.checked ){ 
		gpe_setCookie1( "act_pop1", "no1" , 1 ); 
	}
	document.getElementById('gpe_divpop1').style.display='none';
	}
</script>

<? include '_layout_top.php'; ?>

	<div class="top_area_zone">
		<div id="mainBox">
			<nav class="iconMenu">
				<ul>
					<li><a href="/surf"><img src="images/icon/isurf.png" alt="">
						</a>
					</li>
					<li><a href="/surfbus"><img src="images/icon/ibus.png" alt="">
						</a></li>
					<li><a href="#"><img src="images/icon/ibbq.png" alt="">
						</a></li>
					<li><a href="#"><img src="images/icon/itent.png" alt="">
						</a></li>
					<li><a href="#"><img src="images/icon/ibed.png" alt="">
						</a></li>
					<li><a href="#"><img src="images/icon/ifood.png" alt="">
						</a></li>
				</ul>
			</nav>
			<div class="sldBnr">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><a href="#"><img src="images/sld1.jpg" alt=""></a></div>
						<div class="swiper-slide"><a href="#"><img src="images/sld2.jpg" alt=""></a></div>
						<div class="swiper-slide"><a href="#"><img src="images/sld1.jpg" alt=""></a></div>
						<div class="swiper-slide"><a href="#"><img src="images/sld2.jpg" alt=""></a></div>
						<div class="swiper-slide"><a href="#"><img src="images/sld1.jpg" alt=""></a></div>
						<div class="swiper-slide"><a href="#"><img src="images/sld2.jpg" alt=""></a></div>
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
			<section id="hashtag">
				<div class="hashtagInner">
					<h2>이달의 Hot Pick</h2>
					<div class="tagBox">
						<a href="#"><span>프로모션 <i class="fas fa-chevron-circle-right"></i></span><img src="images/thumb-promotion-nor.png" alt=""></a>
						<a href="#"><span>프로모션 <i class="fas fa-chevron-circle-right"></i></span><img src="images/thumb-promotion-nor.png" alt=""></a>
						<a href="#"><span>프로모션 <i class="fas fa-chevron-circle-right"></i></span><img src="images/thumb-promotion-nor.png" alt=""></a>
						<a href="#"><span>프로모션 <i class="fas fa-chevron-circle-right"></i></span><img src="images/thumb-promotion-nor.png" alt=""></a>
						<a href="#"><span>프로모션 <i class="fas fa-chevron-circle-right"></i></span><img src="images/thumb-promotion-nor.png" alt=""></a>
						<a href="#"><span>프로모션 <i class="fas fa-chevron-circle-right"></i></span><img src="images/thumb-promotion-nor.png" alt=""></a>
					</div>
					<div class="tag">
						<a href="#">#해시태그</a>
						<a href="#">#해시태그</a>
						<a href="#">#해시태그</a>
					</div>
				</div>
			</section>
			<section id="staticBnr">
				<a class="visual" href="#" style="background-image: url(images/visual.jpg)">비주얼에 대한 내용</a>
			</section>
			<section id="popular">
				<header class="popTitle">
					<h2>인기 액티비티</h2>
					<a href="#">레저/액티비티</a>
				</header>
				<div class="actTab">
					<ul class="tabs">
						<li rel="tab1" class="active">tab1</li>
						<li rel="tab2">tab2</li>
						<li rel="tab3">tab3</li>
						<li rel="tab4">tab4</li>
					</ul>
					<div class="tabContainer">
						<div id="tab1" class="tabContent">
							<ul>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
							</ul>
						</div>
						<div id="tab2" class="tabContent">
							<ul>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
							</ul>
						</div>
						<div id="tab3" class="tabContent">
							<ul>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
							</ul>
						</div>
						<div id="tab4" class="tabContent">
							<ul>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
								<li><a href="#">
										<img src="images/hotel.jpg" alt=""></a>
									<dl>
										<dt>이름이들어감</dt>
										<dd>10,000원</dd>
									</dl>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="viewTheme">
					<span>다른 테마 보기</span>
				</div>
			</section>

			<a href="">더보기</a>
		</div>
	</div>
</div>

<? include '_layout_bottom.php'; ?>

<!-- Initialize Swiper -->
<script>
	var swiper = new Swiper('.swiper-container', {
		pagination: {
			el: '.swiper-pagination',
			dynamicBullets: true,
		},
	});
</script>
<!-- tab -->
<script>
	$j(function() {
		$j(".tabContent").hide();
		$j(".tabContent:first").show();

		$j("ul.tabs li").click(function() {
			$j("ul.tabs li").removeClass("active").css({
				"color": "#333",
				"font-weight": "100"
			});
			$j(this).addClass("active").css({
				"font-weight": "bold"
			});
			$j(".tabContent").hide()
			var activeTab = $j(this).attr("rel");
			$j("#" + activeTab).fadeIn()
		});
	});
</script>