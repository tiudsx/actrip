<link rel="stylesheet" type="text/css" href="index.css?v=1" />
<link rel="stylesheet" type="text/css" href="jquery.bxslider.css" />
<script src="jquery.bxslider.min.js"></script> 

<script> 
$(document).ready(function(){ 
	var main = $('.bxslider').bxSlider({ 
		mode: 'fade', 
		auto: true,	//자동으로 슬라이드 
		controls : true,	//좌우 화살표	
		autoControls: false,	//stop,play 
		pager:false,	//페이징 
		pause: 2500, 
		autoDelay: 0,	
		speed: 700, 
		stopAutoOnclick:false,
		randomStart:false
	}); 
}); 
</script>

<div class="mainbxslider"> 
    <div class="bxslider"> 
		<div style="background:url(http://skinnz.godohosting.com/surfenjoy/banner/main_20180422.jpg) 50% 0 no-repeat;cursor:pointer;" class="mainbanner1" onclick="location.href='/surfBBQ'"></div>
		<div style="background:url(http://skinnz.godohosting.com/surfenjoy/banner/main_20181022.jpg) 50% 0 no-repeat;cursor:pointer;display:none;" class="mainbanner1" onclick="location.href='/surfbus'"></div>
		<div style="background:url(http://skinnz.godohosting.com/surfenjoy/banner/main_20181029.jpg) 50% 0 no-repeat;display:none;cursor:pointer;" class="mainbanner1"  onclick="location.href='/campres'"></div> 
    </div> 
</div> 

<div class="mainbannerimg1"> 
    <div class="bxslider"> 
		<div><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_20180422_m.jpg" class="" onclick="location.href='/surfBBQ'"/></div>
		<div style="display:none;"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_20181022_m.jpg" class="" onclick="location.href='/surfbus'"/></div>
		<div style="display:none;"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_20181029_m.jpg" class="" onclick="location.href='/campres'"/></div>
    </div> 
</div>

<div style="width:100%;">
	<ul class="ulcenter">
		<li><a href="/surfevent"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main01.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main01_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main01.png'"></a></li>
		<li><a href="/surfbus"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main02.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main02_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main02.png'"></a></li>
		<li><a href="/surfBBQ"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main07.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main07_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main07.png'"></a></li>
		<li><a href="/campres"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main03.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main03_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main03.png'"></a></li>
		<li><img src="http://skinnz.godohosting.com/surfenjoy/icon/main06.png" class="thumbnail" style="opacity:0.5"></li>
		<li><img src="http://skinnz.godohosting.com/surfenjoy/icon/main04.png" ></li>
	</ul>
</div>

<style>
ul{padding-inline-start:0px;padding:0px;}


.inner, .ulcenter, .ulbanner {text-align: center;}
.centered {position: relative; display: inline-block; text-align:left;}
.ulcenter li, .ulbanner li {display:inline-block;zoom:1;*display:inline;}
/*PC 영역*/
@media (min-width: 1001px) {
	.ulcenter li {padding:10px 30px 10px 30px;}
	.ulbanner table{width:100%;}
}
@media (min-width: 876px) and (max-width: 1000px) {
	.ulcenter li {padding:10px 20px 10px 20px;}
	.ulbanner table{width:100%;}
}
@media (min-width: 768px) and (max-width: 875px) {
	.ulcenter li {padding:10px 10px 10px 10px;}
	.ulbanner table{width:100%;}
}
/*모바일 영역*/
@media (max-width:768px){
	.ulcenter img {
		width: 80%;
		margin-left: auto;
	}

	.ulcenter li {padding:5px;}
}
</style>
<div style="width:100%;display:none;">
	<ul class="ulbanner">
		<li><a href="/surfbus"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_1.jpg" class="placeholder2"></a></li>
		<li>
			<table style="border-spacing:0;" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td><a href="/surfevent"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_2.jpg" class="placeholder2"></a></td>
						<td><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_3.jpg" class="placeholder2"></td>
					</tr>
					<tr>
						<td><a href="https://pf.kakao.com/_HxmtMxl" target="_blank"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_4.jpg" class="placeholder2"></a></td>
						<td><a href="https://www.instagram.com/surfenjoy.sc/" target="_blank"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_5.jpg" class="placeholder2"></a></td>
					</tr>
				</tbody>
			</table>
		</li>
	</ul>
</div>

<div class="bd_tl inner" style="width:100%;">
	<div class="bd centered max600" style="padding:0px;">

		<div style="margin-top:3px;margin-bottom:3px;" >
			<table class="mainbanner1" style="width:100%;margin-bottom:5px;border-spacing:0;border-collapse:collapse;" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td rowspan="2"><a href="/surfbus"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_1.jpg" class="placeholder2"></a></td>
						<td><a href="/surfevent"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_2.jpg" class="placeholder2"></a></td>
						<td><a href="/surfBBQ"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_3.jpg" class="placeholder2"></a></td>
					</tr>
					<tr>
						<td><a href="https://pf.kakao.com/_HxmtMxl" target="_blank"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_4.jpg" class="placeholder2"></td>
						<td><a href="https://www.instagram.com/surfenjoy.sc/" target="_blank"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_5.jpg" class="placeholder2"></a></td>
					</tr>
				</tbody>
			</table>

			<table class="mainbannerimg1" style="width:100%;margin-bottom:5px;border-spacing:0;table-layout:fixed;" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td colspan="2"><a href="/surfbus"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_1.jpg" class="placeholder2"></a></td>
					</tr>
					<tr>
						<td><a href="/surfevent"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_2.jpg" class="placeholder2"></a></td>
						<td><a href="/surfBBQ"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_3.jpg" class="placeholder2"></a></td>
					</tr>
					<tr>
						<td><a href="https://pf.kakao.com/_HxmtMxl" target="_blank"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_4.jpg" class="placeholder2"></a></td>
						<td><a href="https://www.instagram.com/surfenjoy.sc/" target="_blank"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_5.jpg" class="placeholder2"></a></td>
					</tr>
				</tbody>
			</table>

		</div>

	</div>
</div>