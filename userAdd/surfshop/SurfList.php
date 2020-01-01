<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';

if($_REQUEST["area"] != ""){
	$areaCode = $_REQUEST["area"];
	$areaSql = 'cate_3 = "'.$areaCode.'" AND ';
}

//$select_query = 'SELECT * FROM SURF_SHOP a INNER JOIN SURF_CODE b ON b.gubun = "'.$param.'" AND a.cate_3 = b.seq AND a.groupcode = "surf" where '.$areaSql.' intSeq IN (SELECT shopSeq FROM SURF_SHOP_AD WHERE gubun = "surflist" AND adUseYN = "Y" AND intSeq NOT IN (7)) AND a.useYN = "Y" ORDER BY rand()';

//추천목록 랜덤조회
//$select_query = 'SELECT * FROM SURF_SHOP a INNER JOIN SURF_CODE b ON b.gubun = "'.$param.'" AND a.cate_3 = b.seq AND a.groupcode = "surf" where intSeq IN (SELECT shopSeq FROM SURF_SHOP_AD WHERE gubun = "surflist" AND adUseYN = "Y") AND a.useYN = "Y" ORDER BY rand()';


//정렬순서
$select_query = 'SELECT * FROM SURF_SHOP a INNER JOIN SURF_CODE b ON b.gubun = "'.$param.'" AND a.cate_3 = b.seq AND a.groupcode = "surf" where intSeq IN (SELECT shopSeq FROM SURF_SHOP_AD WHERE gubun = "surflist" AND adUseYN = "Y") AND a.useYN = "Y" ORDER BY a.shoporder';

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);
//echo $select_query;
if($count == 0){
	$adDisplay = "none";
}

//if($_REQUEST["area"] != "") $adDisplay = "none";
?>
<link rel="stylesheet" type="text/css" href="surfshop_list.css" />

<div class="container" id="contenttop">
  <section>
    <aside class="left_article3">

		<div class="adtitle" style="display:<?=$adDisplay?>;">
			<span><img src="http://skinnz.godohosting.com/surfenjoy/icon/cate_02.jpg"></span>
		</div>

		<div class="around-content content" style="display:<?=$adDisplay?>;margin-bottom:20px;">
			<ul class="pc recommends-list">
<?
$mapNum = 0;
$arrMapList = array();
$sLng = "";
while ($row = mysqli_fetch_assoc($result_setlist)){
	//if($_REQUEST["area"] != "") continue;

	if($sLng == ""){// && $areaCode == $row["cate_3"]){
		$firstMap = $row["shopname"];
		//$sLng = $row["shop_lat"];
		//$sLat = $row["shop_lng"];
	}

	//if($areaCode == $row["cate_3"]){
		$arrMapList[$mapNum] = $row['shopname'].'|'.$row['shop_lng'].'|'.$row['shop_lat'].'|'.$row['shop_addr'].'|'.$row['shop_tag'].'|'.$mapNum.'|'.$row['intseq'].'|'.$row['shop_mainimg'].'|'.$row['codename'];
		$mapNum++;
	//}
?>
				<li class="recommend-item " tabindex="-1">
					<div class="item-inner">
						<div class="image-box">
							<a href="/surfres?seq=<?=$row["intseq"]?>"><img src="<?=$row['shop_listimg']?>" onerror="this.src='http://skinnz.godohosting.com/surfenjoy/shop/none_200x188.jpg'"></a>
							<div class="badge-rap">
								<div class="icon-topinner">
									<span class="badge-myroom">&nbsp;추천&nbsp;</span><!--span class="badge-coupon">10% 할인</span-->
								</div>
							</div>	
							<div class="txt-distance" onclick="fnMapShopView(this, '<?=$row["shopname"]?>');" style="padding-top:5px;">
								<i class="icon-staylist icon-staylist-distance"></i>
								<em>서핑샵 위치</em>
							</div>
						</div>
							
						<div class="info-box">
							<div class="title-rap">
								<a href="/surfres?seq=<?=$row["intseq"]?>">
									<div>
										<strong class="title-text">
											<span style="display: block; position: relative; overflow: hidden;padding-top:1px;">
												<span style="width: 100%;">[<?=$row["codename"]?>] <?=$row["shopname"]?></span>
											</span>
										</strong>
									</div>
								</a>
							</div>
							
							<div class="price-rap">
								<?
								$c = 0;
								$shop_price = explode('@', $row["shop_price"]);
								foreach($shop_price as $value){

									$arrValue = explode('|', $value);
								?>
								<div class="price-item">
									<i class="price-type"><b><?=$arrValue[0]?></b><small><?=$arrValue[1]?></small></i>
									<span>
										<?if($c == 0){?>
										<i class="price-label label-reserve">예약가</i>
										<?}else{?>
										<i class="price-label label-member" style="background-color:#18d0c5;">예약가</i>
										<?}?>
										<span>
											<em></em>
											<?if($arrValue[2] > 0){?>
											<small class="underline"><?=number_format($arrValue[2])?>원</small>
											<?}?>
											<em><?=number_format($arrValue[3])?><i>원</i></em>
										</span>
									</span>
								</div>
								<?
								$c++;
								}
								?>
							</div>
							
							<div class="hashtag-rap">
								<em><?=$row["shop_tag"]?></em>
								<?
								$shop_info = explode('@', $row["shop_info"]);
								foreach($shop_info as $value){
									echo '<p>'.$value.'</p>';
								}
								?>
							</div>
						</div>
					</div>
				</li>
<?
}

//if($_REQUEST["area"] != "" || $count == 0){
	if($_REQUEST["area"] == "" && $count == 0){
		echo '<script>$j("li[area='.$areaCodeNone.']").addClass("on3");</script>';
	}else{
		//임시제거
		//$areaCodeNone = $areaCode;
	}

	if($_REQUEST["area"] != ""){
		$areaCodeNone = $areaCode;
	}
	
	$select_query = 'SELECT * FROM SURF_SHOP a INNER JOIN SURF_CODE b ON a.cate_3 = b.seq AND a.groupcode = "surf" where cate_3 = "'.$areaCodeNone.'" AND intSeq NOT IN (SELECT shopSeq FROM SURF_SHOP_AD WHERE gubun = "surflist" AND a.cate_3 = SURF_SHOP_AD.area AND adUseYN = "Y") AND a.useYN = "Y" ORDER BY rand()'; // ORDER BY shoporder //rand()
	//$select_query = 'SELECT * FROM SURF_SHOP a INNER JOIN SURF_CODE b ON a.cate_3 = b.seq AND a.groupcode = "surf" where cate_3 = "'.$areaCodeNone.'" AND a.useYN = "Y" ORDER BY rand()';
	$result_setlist = mysqli_query($conn, $select_query);
	$count = mysqli_num_rows($result_setlist);
//echo $select_query;
	$adDisplay = "";
	if($count == 0){
		$adDisplay = "none";
	}
?>

			</ul>
		</div>

		<div class="adtitle" style="display:<?=$adDisplay?>;">
			<span><img src="http://skinnz.godohosting.com/surfenjoy/icon/cate_03.jpg"></span>
		</div>

		<div class="around-content content">
			<ul class="pc recommends-list">
<?
while ($row = mysqli_fetch_assoc($result_setlist)){
	if($sLng == ""){
		$firstMap = $row["shopname"];
		$sLng = $row["shop_lat"];
		$sLat = $row["shop_lng"];
	}

	$arrMapList[$mapNum] = $row['shopname'].'|'.$row['shop_lng'].'|'.$row['shop_lat'].'|'.$row['shop_addr'].'|'.$row['shop_tag'].'|'.$mapNum.'|'.$row['intseq'].'|'.$row['shop_mainimg'].'|'.$row['codename'];
	$mapNum++;
?>
				<li class="recommend-item " tabindex="-1">
					<div class="item-inner">
						<div class="image-box">
							<a href="/surfres?seq=<?=$row["intseq"]?>"><img src="<?=$row['shop_listimg']?>" onerror="this.src='http://skinnz.godohosting.com/surfenjoy/shop/none_200x188.jpg'"></a>
							<div class="txt-distance" onclick="fnMapShopView(this, '<?=$row["shopname"]?>');" style="padding-top:5px;">
								<i class="icon-staylist icon-staylist-distance"></i>
								<em>서핑샵 위치</em>
							</div>
						</div>
							
						<div class="info-box">
							<div class="title-rap">
								<a href="/surfres?seq=<?=$row["intseq"]?>">
									<div>
										<strong class="title-text">
											<span style="display: block; position: relative; overflow: hidden;padding-top:1px;">
												<span style="width: 100%;">[<?=$row["codename"]?>] <?=$row["shopname"]?></span>
											</span>
										</strong>
									</div>
								</a>
							</div>
							
							<div class="price-rap">
								<?
								$c = 0;
								$shop_price = explode('@', $row["shop_price"]);
								foreach($shop_price as $value){

									$arrValue = explode('|', $value);
								?>
								<div class="price-item">
									<i class="price-type"><b><?=$arrValue[0]?></b><small><?=$arrValue[1]?></small></i>
									<span>
										
										<?if($c == 0){?>
										<i class="price-label label-reserve">예약가</i>
										<?}else{?>
										<i class="price-label label-member" style="background-color:#18d0c5;">예약가</i>
										<?}?>
										<span>
											<em></em>
											<?if($arrValue[2] > 0){?>
											<small class="underline"><?=number_format($arrValue[2])?></small>
											<?}?>
											<em><?=number_format($arrValue[3])?><i>원 ~</i></em>
										</span>
									</span>
								</div>
								<?
								$c++;
								}
								?>
							</div>
							
							<div class="hashtag-rap">
								<em><?=$row["shop_tag"]?></em>
								<?
								$shop_info = explode('@', $row["shop_info"]);
								foreach($shop_info as $value){
									echo '<p>'.$value.'</p>';
								}
								?>
							</div>
						</div>
					</div>
				</li>
<?}
//}
?>
			</ul>
		</div>

	</aside>
    <article class="right_article3" style="z-index: 1;">
		<div class="layer pop_map surfPC" id="layerView">
			<div class="title"><span>지도보기</span><button type="button" onclick="close_layer('layerView')">닫기</button></div>
			<iframe scrolling="no" frameborder="0" class="ifrmMap" id="ifrmMap" name="ifrmMap" style="width:100%;display:;" src="SurfList_Map.php"></iframe>
		</div>

		<div class="wellBtn menu">
			<div class="resbottom">
				<button class="reson" id="reson1" onclick="fnMapView('<?=$firstMap?>');"><i></i><span>지도로 보기</span></button>
			</div>
		</div>
    </article>
  </section>
</div>

<style>
@media all and (max-width:839px){
	.layer {
		position: fixed;
		top: 0px;
		right: 0;
		bottom: 0;
		left: 0;
		z-index: 3;
		background: #fff;
		height:100%;
		width:100%;
		display:none;
	}

	.layer .title {
		position: fixed;
		top: 0px;
		left: 0;
		right: 0;
		z-index: 200;
		height: 44px;
		border-bottom: none;
		background: #fff;
		font-size: 18px;
		line-height: 44px;
		text-align: center;
		display:block;
		z-index: 1;
	}

	.layer .title button {
		position: absolute;
		top: 0px;
		right: 16px;
		width: 40px;
		height: 44px;
		border: none;
		background: url(//image.goodchoice.kr/images/web_v3/ico_close.png) 50% 50% no-repeat;
		background-size: 24px auto;
		text-indent: -9999px;
	}
}
@media (min-width: 840px) {
	.layer {
		width:409px;height:602px;
	}

	.layer .title {
		display:none;
	}

	.fixedRightSurf {	position: fixed;	top: 40px;width:409px;height:602px;}
}
</style>


<?
if($sLng == ""){
	$select_query = 'SELECT * FROM SURF_CODE where seq = '.$areaCode;
	$result_setlist = mysqli_query($conn, $select_query);

	$row = mysqli_fetch_array($result_setlist);

	$sLng = $row["lat"];
	$sLat = $row["lng"];
}

$mapList = "";
foreach($arrMapList as $value){
	$arrMapList = explode('|', $value);
	
	$mapList .= "'$arrMapList[0]'		: [MARKER_SPRITE_X_OFFSET*$arrMapList[5], MARKER_SPRITE_Y_OFFSET*3, '$arrMapList[2]', '$arrMapList[1]', '$arrMapList[3]', '$arrMapList[4]', $arrMapList[5], $arrMapList[6], '$arrMapList[7]', '$arrMapList[8]'],";

}
$mapList = rtrim($mapList, ',');
?>

<script>
$j(document).ready(function(){
	var menu = $j( '.surfPC' ).offset();
	$j( window ).scroll( function() {
		if ( $j( document ).scrollTop() > menu.top ) {
			$j( '.surfPC' ).addClass( 'fixedRightSurf' );
		} else {
			$j( '.surfPC' ).removeClass( 'fixedRightSurf' );
		}
	});
});


function fnMapShopView(obj, shopname){
	$j("#layerView").css("display", "block");

	if($j("#layerView .title").css("display") != "none"){
		$j(".gpe_movetop").css("display", "none");
		$j(".gnb1_area_wrap00").css("display", "none");
		$j(".footer_Util_wrap00").css("display", "none");
	}

	fnBusMap(shopname);
}

function fnMapView(shopname){
	$j("#layerView").css("display", "block");

	if($j("#layerView .title").css("display") != "none"){
		$j(".gpe_movetop").css("display", "none");
		$j(".gnb1_area_wrap00").css("display", "none");
		$j(".notice_MQarea").css("display", "none");
	}

	//fnBusMap(shopname);
}

function fnBusMap(pointname){
	var obj = $j("#ifrmMap").get(0);
	var objDoc = obj.contentWindow || obj.contentDocument;
	objDoc.mapMove(pointname);
}

function close_layer(obj){
	$j("#" + obj).css("display", "none");
	$j(".gpe_movetop").css("display", "block");
	$j(".gnb1_area_wrap00").css("display", "block");
	$j(".footer_Util_wrap00").css("display", "block");
	$j(".notice_MQarea").css("display", "block");
}

var sLng = "<?=$sLng?>";
var sLat = "<?=$sLat?>";
var mapView = 0;
var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION2 = {
       <?=$mapList?>
    };
</script>