<? include 'db.php'; ?>

<link rel="stylesheet" type="text/css" href="/act/css/main.css">
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
	function gpe_getCookie1(name) { 
		var Found = false 
		var start, end 
		var i = 0 
		while(i <= document.cookie.length) { 
			start = i 
			end = start + name.length 
			if(document.cookie.substring(start, end) == name) { 
				Found = true 
				break 
			} 
			i++ 
		} 
		
		if(Found == true) { 
			start = end + 1 
			end = document.cookie.indexOf(";", start) 

			if(end < start) 
				end = document.cookie.length 

			return document.cookie.substring(start, end) 
		} 
		return "" 
	} 

	function gpe_setCookie1( name, value, expiredays ) { 
		var todayDate = new Date(); 
		todayDate.setDate( todayDate.getDate() + expiredays ); 
		document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
	}

	//var eventCookie=gpe_getCookie1("act_pop1");
	// if ( eventCookie != "no1" ){  
	// 	document.all['gpe_divpop1'].style.visibility = "visible";
	// } else if(eventCookie == "no1") {
	// 	document.getElementById('gpe_divpop1').style.display='none'; 
	// }
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
					<li><a href="/bbq"><img src="images/icon/ibbq.png" alt="">
						</a></li>
					<li><a href="/camp"><img src="images/icon/itent.png" alt="">
						</a></li>
					<li><a href="/staylist"><img src="images/icon/ibed.png" alt="">
						</a></li>
					<li><a href="/eatlist"><img src="images/icon/ifood.png" alt="">
						</a></li>
				</ul>
			</nav>
			<div class="sldBnr">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><a href="#"><img src="images/banner/banefit.jpg" alt=""></a></div>
						<div class="swiper-slide"><a href="#"><img src="images/banner/reviewSurf.jpg" alt=""></a></div>
						<div class="swiper-slide"><a href="#"><img src="images/banner/reviewBus.jpg" alt=""></a></div>
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
			<section id="hashtag">
				<div class="hashtagInner">
					<h2>알면 알수록 좋은~</h2>
					<div class="tagBox">
						<a href="/event"><span>이벤트모음 <i class="fas fa-chevron-circle-right"></i></span><img src="images/mainImg/mainEvent.png" alt=""></a>
						<a href="https://cafe.naver.com/actrip/178" target="_blank"><span>맛도락 제휴식당 <i class="fas fa-chevron-circle-right"></i></span><img src="images/mainImg/mainFood.png" alt=""></a>
						<a href="https://cafe.naver.com/ArticleList.nhn?search.clubid=29998302&search.menuid=40&search.boardtype=L" target="_blank"><span>이용후기 <i class="fas fa-chevron-circle-right"></i></span><img src="images/mainImg/mainReview.png" alt=""></a>
						<a href="https://cafe.naver.com/ArticleList.nhn?search.clubid=29998302&search.menuid=21&search.boardtype=W" target="_blank"><span>서핑정보/팁 <i class="fas fa-chevron-circle-right"></i></span><img src="images/mainImg/mainSurf.png" alt=""></a>
					</div>
					<div class="tag">
						<a>#액트립</a>
						<a>#여행은액티비티다</a>
						<a>#혜택빵빵</a>
						<a>#서핑배우기</a>
					</div>
				</div>
			</section>
			<section id="staticBnr">
				<a class="visual" href="/surfbus"><img src=images/banner/bnrBus.jpg></a>
			</section>
			<!-- <section id="popular">
				<header class="popTitle">
					<h2>인기 액티비티</h2>
				</header>
				<div class="actTab">
					<ul class="tabs">
						<li rel="tab1" class="active">추천</li>
						<li rel="tab2">양양</li>
						<li rel="tab3">고성</li>
						<li rel="tab4">동해</li>
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
			</section> -->
			<section id="promo">
				<div class="promoInner">
					<h2>기획전</h2>
					<div class="promoBox">
						<a href="/surfview?seq=2"><img src="images/mainImg/promobg.png" alt=""><span>액트립 당찬패키지 <i class="fas fa-chevron-circle-right"></i><span class="subinst">서핑강습 한방에 해결!! 올인원 패키지~</span></span></a>
						<a href="/bbq"><img src="images/mainImg/promobg.png" alt=""><span>액트립 바베큐파티 <i class="fas fa-chevron-circle-right"></i><span class="subinst">새로운 만남과 신나는 버스킹공연♪</span></span></a>
						<a href="/surfbus"><img src="images/mainImg/promobg.png" alt=""><span>서울-양양, 동해 서핑버스  <i class="fas fa-chevron-circle-right"></i><span class="subinst">이보다 더 편한 셔틀버스는 없다</span></span></a>
						<a href="/eatlist"><img src="images/mainImg/promobg.png" alt=""><span>양양 맛도락 여행 <i class="fas fa-chevron-circle-right"></i><span class="subinst">서핑 후엔 맛집에서 체력충전!</span></span></a>
					</div>
				</div>
			</section>

		</div>
	</div>
</div>

<? include '_layout_bottom.php'; ?>

<!-- Initialize Swiper -->
<script>
	var swiper = new Swiper('.swiper-container', {
		loop: true,
		autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
		pagination: {
			el: '.swiper-pagination',
			dynamicBullets: true,
		},
	});

	$j(".swiper-container").hover(
		function() {
			swiper.autoplay.stop();
		}, 
		function() {
			swiper.autoplay.start();
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