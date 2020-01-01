<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';

$select_query = 'SELECT * FROM SURF_SHOP_AD where gubun = "surfad" AND adUseYN = "Y" ORDER BY  area'; //  AND intSeq NOT IN (1,2) ORDER BY rand()
$result_setlist = mysqli_query($conn, $select_query);

$adList_1 = "";
$adList_2 = "";

$i = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){

	if($i % 2 == 1){
		$adList_2 .= '
				<li class="list_2 adcno2">
					<a href="'.$row["adLink"].'">
						<p class="pic">
							<img class="lazy align" src="'.$row["shopImg"].'" style="display: block;">
						</p>
						<div class="stage gra_black_vertical">
							<div class="evt_info"><span>'.$row["adTitle"].'</span></div>
							<div class="name">
								<div class="badge"><span class="build_badge" style="color: rgba(255,255,255,1); background-color: rgba(97,95,184,1);">추천</span></div>
								<strong>'.$row["adTitle2"].'</strong>
								<p class="score">
									<em></em><span>'.$row["adTitle3"].'</span>&nbsp;
								</p>
								<!--p>양양 | 죽도해변</p-->
							</div>
							<div class="price">
								<!--div class="map_html">
									<p><em class="mark"><span><b>1개</b><i>&nbsp;</i></span></em><b>600,000원</b></p>
								</div-->
								<p><em class="mark"><span><!--b>1개</b--><i>&nbsp;</i></span></em><b>'.$row["adPrice"].'</b></p>
							</div>
						</div>
					</a>
				</li>
		';
	}else{
		$adList_1 .= '
				<li class="list_2 adcno2">
					<a href="'.$row["adLink"].'">
						<p class="pic">
							<img class="lazy align" src="'.$row["shopImg"].'" style="display: block;">
						</p>
						<div class="stage gra_black_vertical">
							<div class="evt_info"><span>'.$row["adTitle"].'</span></div>
							<div class="name">
								<div class="badge"><span class="build_badge" style="color: rgba(255,255,255,1); background-color: rgba(97,95,184,1);">추천</span></div>
								<strong>'.$row["adTitle2"].'</strong>
								<p class="score">
									<em></em><span>'.$row["adTitle3"].'</span>&nbsp;
								</p>
								<!--p>양양 | 죽도해변</p-->
							</div>
							<div class="price">
								<!--div class="map_html">
									<p><em class="mark"><span><b>1개</b><i>&nbsp;</i></span></em><b>600,000원</b></p>
								</div-->
								<p><em class="mark"><span><!--b>1개</b--><i>&nbsp;</i></span></em><b>'.$row["adPrice"].'</b></p>
							</div>
						</div>
					</a>
				</li>
		';
	}

$i++;
}

?>

<link rel="stylesheet" type="text/css" href="surfshop_event.css?v=2" />

<div class="container" id="contenttop">
  <section>
    <aside class="left_article" style="padding-bottom:0px;">
		<div class="event1">
			<div class="adtitle">
				<span><img src="http://skinnz.godohosting.com/surfenjoy/icon/cate_01.jpg"></span>
			</div>

			<li class="list_2 adcno2" style="display:none;">
				<a href="/surfbus">
					<p class="pic">
						<img class="lazy align" src="http://skinnz.godohosting.com/surfenjoy/shop/02_600x300.jpg" style="display: block;">
					</p>
					<div class="stage gra_black_vertical">
						<div class="evt_info"><span>[서프엔조이] 양양해변으로 편하게 가즈아~</span></div>
						<div class="name">
							<div class="badge"><span class="build_badge" style="color: rgba(255,255,255,1); background-color: rgba(97,95,184,1);">추천</span></div>
							<strong>서울-양양 셔틀버스로 편하게 서핑하자</strong>
							<p class="score">
								<em></em><span>서울 - 양양 | 죽도해변</span>&nbsp;
							</p>
							<!--p>양양 | 죽도해변</p-->
						</div>
						<div class="price">
							<!--div class="map_html">
								<p><em class="mark"><span><b>1개</b><i>&nbsp;</i></span></em><b>600,000원</b></p>
							</div-->
							<p><em class="mark"><span><!--b>1개</b--><i>&nbsp;</i></span></em><b>20,000원</b></p>
						</div>
					</div>
				</a>
			</li>

			<?=$adList_1?>

		</div>
	</aside>
    <article class="right_article">
		<div class="event1">
			<div class="adtitle2" style="height:58px;">
				<span>&nbsp;</span>
			</div>
	
			<li class="list_2 adcno2" style="display:none;">
				<a href="/surfBBQ">
					<p class="pic">
						<img class="lazy align" src="http://skinnz.godohosting.com/surfenjoy/shop/01_600x300.jpg" style="display: block;">
					</p>
					<div class="stage gra_black_vertical">
						<div class="evt_info"><span>[서프엔조이] 죽도해변에서 즐기는 BBQ</span></div>
						<div class="name">
							<div class="badge"><span class="build_badge" style="color: rgba(255,255,255,1); background-color: rgba(97,95,184,1);">추천</span></div>
							<strong>죽도해변 BBQ 파티</strong>
							<p class="score">
								<em></em><span>TIME : 19:00 ~ 22:00</span>&nbsp;
							</p>
							<!--p>양양 | 죽도해변</p-->
						</div>
						<div class="price">
							<!--div class="map_html">
								<p><em class="mark"><span><b>1개</b><i>&nbsp;</i></span></em><b>600,000원</b></p>
							</div-->
							<p><em class="mark"><span><!--b>1개</b--><i>&nbsp;</i></span></em><b>25,000원</b></p>
						</div>
					</div>
				</a>
			</li>

			<?=$adList_2?>

		</div>
		
    </article>
  </section>
</div>
