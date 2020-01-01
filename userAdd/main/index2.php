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
		pause: 3500, 
		autoDelay: 0,	
		speed: 700, 
		stopAutoOnclick:false,
		randomStart:true
	}); 
}); 
</script> 

<!--div class="mainbxslider"> 
    <div class="bxslider"> 
		<div><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_20181022.jpg" class="mainbanner1"></div>
		<div><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_20181029.jpg" class="mainbanner1"></div> 
    </div> 
</div--> 

<div class="mainbxslider"> 
    <div class="bxslider"> 
		<div style="background:url(http://skinnz.godohosting.com/surfenjoy/banner/main_20181022.jpg) 50% 0 no-repeat;cursor:pointer;" class="mainbanner1" onclick="location.href='/surfbus'"></div>
		<div style="background:url(http://skinnz.godohosting.com/surfenjoy/banner/main_20181029.jpg) 50% 0 no-repeat;display:none;cursor:pointer;" class="mainbanner1"  onclick="location.href='/campres'"></div> 
    </div> 
</div> 

<div class="mainbannerimg1"> 
    <div class="bxslider"> 
		<div><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_20181022_m.jpg" class="" onclick="location.href='/surfbus'"/></div>
		<div><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_20181029_m.jpg" class="" onclick="location.href='/campres'"/></div>
    </div> 
</div>

<!--div style="width:100%;">
	<div class="mainarea1" style="text-align:center;">
		<ul class="cTab">
			<li><a href="/surfevent"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main01.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main01_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main01.png'"></a></li>
			<li><a href="/surfbus"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main02.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main02_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main02.png'"></a></li>
			<li><a href="/surfBBQ"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main07.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main07_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main07.png'"></a></li>
			<li><a href="/campres"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main03.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main03_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main03.png'"></a></li>
			<li><a href="#"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main06.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main06_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main06.png'"></a></li>
			<li><img src="http://skinnz.godohosting.com/surfenjoy/icon/main04.png" ></li>
			<!--li><a href="/stayeast"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main04.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main04_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main04.png'"></a></li>
			<li><a href="#"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main05.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main05_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main05.png'"></a></li-->
		<!--/ul>
	</div>
</div-->

<style>

.row {
	width: 100%;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
	display: inline-block
}

.columns {
	width: 15%;
	float: left;
	font-family: "Source Sans Pro";
	color: #A5A5A5;
	padding-top: 0px;
	padding-bottom: 0px;
	text-align: justify;
	margin-top: 15px;
	margin-bottom: 15px;
	padding-left: 0px;
	padding-right: 0px;
	margin-left: 0px;
	margin-right: 0px;
}

.row .columns p {
	padding-left: 10%;
	padding-right: 10%;
}

.thumbnail_align {
	text-align: center;
}
/*PC 영역*/
@media (min-width: 769px) {
	.columns {
		width: 16%;
		float: left;
		padding-left: 0px;
		padding-top: 0px;
		padding-right: 0px;
		padding-bottom: 0px;
	}
	.container .columns p {
		padding-left: 25px;
		padding-right: 25px;
	}
}

/*모바일 영역*/
@media all and (max-width:768px){
	.columns {
		width: 33%;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
		margin-left: 0px;
		padding-top: 0px;
		padding-right: 0px;
		padding-bottom: 0px;
		padding-left: 0px;
	}
	.columns p {
		padding-left: 14px;
		padding-right: 14px;
	}

	.thumbnail {
		width: 80%;
		margin-left: auto;
	}
}
</style>
<div class="row">
    <div class="columns">
      <p class="thumbnail_align"><a href="/surfevent"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main01.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main01_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main01.png'" class="thumbnail"></a></p>
    </div>
    <div class="columns">
      <p class="thumbnail_align"><a href="/surfbus"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main02.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main02_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main02.png'" class="thumbnail"></a></p>
    </div>
    <div class="columns">
      <p class="thumbnail_align"><a href="/surfBBQ"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main07.png" class="thumbnail" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main07_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main07.png'"></a></p>
	  <!--onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main07_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main07.png'" -->
    </div>
    <div class="columns">
      <p class="thumbnail_align"><a href="/campres"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main03.png" onmouseover="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main03_on.png'" onmouseout="this.src='http://skinnz.godohosting.com/surfenjoy/icon/main03.png'" class="thumbnail"></a></p>
    </div>
    <div class="columns">
      <p class="thumbnail_align"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main06.png" class="thumbnail" style="opacity:0.5"></p>
    </div>
    <div class="columns">
      <p class="thumbnail_align"><img src="http://skinnz.godohosting.com/surfenjoy/icon/main04.png" class="thumbnail"></p>
    </div>
  </div>

<!--div style="width:100%;padding-top:10px;">
	<div style="background-color:#efefef;" class="mainarea1">
		서프엔조이 광고배너<br><br><br><br><br><br><br>
	</div>
</div-->

<style>
.inner {text-align: center;}
.centered {position: relative; display: inline-block; text-align:left;}

.ulcenter li {display:inline-block;zoom:1;*display:inline;}
</style>
<div class="bd_tl inner" style="width:100%;">
	<div class="bd centered max600" style="padding:0px;">

		<div style="margin-top:3px;margin-bottom:3px;" >
			<table class="mainbanner1" style="width:100%;margin-bottom:5px;border-spacing:0;border-collapse:collapse;" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td rowspan="2"><a href="/surfbus"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_1.jpg" class="placeholder2"></a></td>
						<td><a href="/surfevent"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_2.jpg" class="placeholder2"></a></td>
						<td><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_3.jpg" class="placeholder2"></td>
					</tr>
					<tr>
						<td><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_4.jpg" class="placeholder2"></td>
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
						<td><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_3.jpg" class="placeholder2"></td>
					</tr>
					<tr>
						<td><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_4.jpg" class="placeholder2"></td>
						<td><a href="https://www.instagram.com/surfenjoy.sc/" target="_blank"><img src="http://skinnz.godohosting.com/surfenjoy/banner/main_5.jpg" class="placeholder2"></a></td>
					</tr>
				</tbody>
			</table>

		</div>

	</div>
</div>