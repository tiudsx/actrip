<? include 'db.php'; ?>

<?
$reqCode = ($_REQUEST["code"] == "") ? "jukdo" : $_REQUEST["code"];
?>

<!-- area menu script -->
<script type="text/javascript">
    var type = "";
    var btnheight = "";

    $j(document).ready(function() {
        //지도로 보기 - 슬라이드
        $j("#slide1").click(function() {
            fnMapView('');
        });
    });    
</script>

<?
//서핑샵 정보 가져오기
$select_query = "SELECT * FROM AT_PROD_MAIN 
                    WHERE code = 'surf'
                        AND category = '$reqCode'
                        AND use_yn = 'Y' 
                        AND view_yn = 'Y'
                    ORDER BY rand()";
$result_shopadlist = mysqli_query($conn, $select_query);
$shopadcount = mysqli_num_rows($result_shopadlist);

$select_query = "SELECT * FROM AT_PROD_MAIN 
                    WHERE code = 'surf'
                        AND category = '$reqCode'
                        AND use_yn = 'Y'
                        AND view_yn = 'Y'
                    ORDER BY rand()";
$result_shoplist = mysqli_query($conn, $select_query);
$shopcount = mysqli_num_rows($result_shoplist);
?>
<div id="wrap">
<? include '_layout_top.php'; ?>

    <div class="top_area_zone">
        <div id="listWrap">
            
            <? include '_layout_category.php'; ?>
            <?if($shopadcount > 0){?>
            <section id="popShop">
                <h2><img src="images/icon/moon.svg" alt=""> 인기 서핑샵 추천</h2>
                <ul class="listShop">
                    <li class="listShopbox">

                    <?while ($row = mysqli_fetch_assoc($result_shopadlist)){
                        $shop_img = explode('|', $row["shop_img"]);
                        ?>
                        <ul class="listItem">
                            <li class="thumbnail">
                                <a href="/surfview?seq=<?=$row["seq"]?>"><img src="<?=$shop_img[0]?>" alt=""></a>
                                <span>
                                    <img src="images/icon/parking.svg" alt="">
                                    <img src="images/icon/wifi.svg" alt="">
                                    <img src="images/icon/house.svg" alt="">
                                    <img src="images/icon/pet.svg" alt="">
                                    <img src="images/icon/toilet.svg" alt="">
                                </span>
                            </li>
                            <li class="contents">
                                <h3><a href="/surfview?seq=<?=$row["seq"]?>"><?=$row["shopname"]?> <i class="fas fa-angle-right"></i></a></h3>
                                <span><a href="javascript:fnMapView('<?=$row["shopname"]?>');"><img src="images/icon/map.svg" alt="">위치</a></span>
                                <span>구매 <?=number_format($row["sell_cnt"])?>개</span>
                                
                                <?
								$shop_info = explode('@', $row["sub_title"]);
								foreach($shop_info as $value){
									echo '<p>✓ '.$value.'</p>';
                                }
                                ?>

                            </li>
                            <li class="price">
                                <?
                                $shop_price = explode('@', $row["sub_info"]);
                                $arrlecture = explode('|', $shop_price[0]);
                                $arrrental = explode('|', $shop_price[1]);
                                ?>
                                <span class="lecture">
                                    <p><span><?=$arrlecture[0]?></span></p>
                                    <p>
                                    <?if($arrlecture[1] != 0) echo number_format($arrlecture[1]).'원';?>
                                    </p>
                                    <p><?=number_format($arrlecture[2])?>원</p>
                                </span>
                                <span class="rental">
                                    <p><span><?=$arrrental[0]?></span></p>
                                    <p>
                                    <?if($arrrental[1] != 0) echo number_format($arrrental[1]).'원';?>
                                    </p>
                                    <p><?=number_format($arrrental[2])?>원</p>
                                </span>
                                
                            </li>
                            <?if($row["sub_tag"] != ""){?>
                            <li class="event"><span>이벤트</span><?=$row["sub_tag"]?></li>
                            <?}?>
                        </ul>
                    <?}?>
                    
                    </li>
                </ul>
            </section>
            <?}?>
            <section id="allShop">
                <h2>#서핑샵 찾아보기</h2>
                <ul class="listShop">
                    <li class="listShopbox">
                    <?while ($row = mysqli_fetch_assoc($result_shoplist)){
                        $shop_img = explode('|', $row["shop_img"]);
                        ?>
                        <ul class="listItem">
                            <li class="thumbnail">
                                <a href="/surfview?seq=<?=$row["seq"]?>"><img src="<?=$shop_img[0]?>" alt=""></a>
                                <span>
                                    <img src="images/icon/parking.svg" alt="">
                                    <img src="images/icon/wifi.svg" alt="">
                                    <img src="images/icon/house.svg" alt="">
                                    <img src="images/icon/pet.svg" alt="">
                                    <img src="images/icon/toilet.svg" alt="">
                                </span>
                            </li>
                            <li class="contents">
                                <h3><a href="/surfview?seq=<?=$row["seq"]?>"><?=$row["shopname"]?> <i class="fas fa-angle-right"></i></a></h3>
                                <span><a href="javascript:fnMapView('<?=$row["shopname"]?>');"><img src="images/icon/map.svg" alt="">위치</a></span>
                                <span>구매 <?=number_format($row["sell_cnt"])?>개</span>
                                
                                <?
								$shop_info = explode('@', $row["sub_title"]);
								foreach($shop_info as $value){
									echo '<p>✓ '.$value.'</p>';
                                }
                                ?>

                            </li>
                            <li class="price">
                                <?
                                $shop_price = explode('@', $row["sub_info"]);
                                $arrlecture = explode('|', $shop_price[0]);
                                $arrrental = explode('|', $shop_price[1]);
                                ?>
                                <span class="lecture">
                                    <p><span><?=$arrlecture[0]?></span></p>
                                    <p>
                                    <?if($arrlecture[1] != 0) echo number_format($arrlecture[1]).'원';?>
                                    </p>
                                    <p><?=number_format($arrlecture[2])?>원</p>
                                </span>
                                <span class="rental">
                                    <p><span><?=$arrrental[0]?></span></p>
                                    <p>
                                    <?if($arrrental[1] != 0) echo number_format($arrrental[1]).'원';?>
                                    </p>
                                    <p><?=number_format($arrrental[2])?>원</p>
                                </span>
                                
                            </li>
                            <?if($row["sub_tag"] != ""){?>
                            <li class="event"><span>이벤트</span><?=$row["sub_tag"]?></li>
                            <?}?>
                        </ul>
                    <?}?>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</div>
<div class="con_footer">
    <div class="fixedwidth resbottom">
        <img src="https://surfenjoy.cdn3.cafe24.com/button/btnMap.png" id="slide1">
        <div id="sildeing" style="display:block;height:100%;padding-top:5px;">
            <iframe scrolling="no" frameborder="0" class="ifrmMap" id="ifrmMap" name="ifrmMap" style="width:100%;height:100%;" src="/act/surf/surfmap.html"></iframe>
        </div>
    </div>
</div>

<? include '_layout_bottom.php'; ?>

<script>
var mapView = 0;
var sLng = "37.9726807";
var sLat = "128.7593755";
var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION2 = {
       '양양서핑페스티벌 - 초급강습'		: [MARKER_SPRITE_X_OFFSET*0, MARKER_SPRITE_Y_OFFSET*3, '37.9723728', '128.7599369', '죽도해변', '#뮤직페스티벌 #서핑강습 #양양서핑페스티벌', 0, 69, 'https://surfenjoy.cdn3.cafe24.com/yangfe2/surfshop_yangyang_500x500.jpg', '죽도'],'당찬패키지 #END'		: [MARKER_SPRITE_X_OFFSET*1, MARKER_SPRITE_Y_OFFSET*3, '37.9726807', '128.7593755', '죽도해변', '#당찬패키지  #해변바베큐파티 #서핑버스 ', 1, 64, 'https://surfenjoy.cdn3.cafe24.com/shop/surfenjoy_new_1.jpg?v=3', '죽도'],'핀스서프&카페'		: [MARKER_SPRITE_X_OFFSET*2, MARKER_SPRITE_Y_OFFSET*3, '37.9735445', '128.75893', '강원 양양군 현남면 인구중앙길 99', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 2, 8, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_fins_500x500.jpg', '죽도'],'서프오션'		: [MARKER_SPRITE_X_OFFSET*3, MARKER_SPRITE_Y_OFFSET*3, '37.9721365', '128.7607446', '강원도 양양군 현남면 새나루길 43', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 3, 53, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_surfocean_500x500.jpg', '죽도'],'씨맨서프'		: [MARKER_SPRITE_X_OFFSET*4, MARKER_SPRITE_Y_OFFSET*3, '37.9718897', '128.7615991', '강원도 양양군 현남면 새나루길 9-9', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 4, 56, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_seaman_500x500.jpg', '죽도'],'배럴서프스쿨'		: [MARKER_SPRITE_X_OFFSET*5, MARKER_SPRITE_Y_OFFSET*3, '37.9726845', '128.7592012', '강원도 양양군 현남면 인구중앙길 91', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 5, 55, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_barrel_500x500.jpg', '죽도'],'서퍼911'		: [MARKER_SPRITE_X_OFFSET*6, MARKER_SPRITE_Y_OFFSET*3, '37.9725146', '128.7591486', '강원 양양군 현남면 인구중앙길 89', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 6, 54, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_surfer911_500x500.jpg', '죽도'],'캔디서프'		: [MARKER_SPRITE_X_OFFSET*7, MARKER_SPRITE_Y_OFFSET*3, '37.972866', '128.7592002', '강원 양양군 현남면 인구중앙길 93 캔디서프', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 7, 7, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_candysurf_500x500.jpg', '죽도'],'조아서프'		: [MARKER_SPRITE_X_OFFSET*8, MARKER_SPRITE_Y_OFFSET*3, '37.9715175', '128.7594324', '강원 양양군 현남면 인구중앙길 79', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 8, 2, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_joasurf_500x500.jpg', '죽도'],'이스트사이드'		: [MARKER_SPRITE_X_OFFSET*9, MARKER_SPRITE_Y_OFFSET*3, '37.9718166', '128.7590159', '강원도 양양군 현남면 창리길 6', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 9, 57, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_eastside_500x500.jpg', '죽도'],'이스트쇼어'		: [MARKER_SPRITE_X_OFFSET*10, MARKER_SPRITE_Y_OFFSET*3, '37.9718335', '128.7623908', '강원도 양양군 현남면 새나루길 27', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 10, 59, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_eastshore_500x500.jpg', '죽도'],'모쿠서프'		: [MARKER_SPRITE_X_OFFSET*11, MARKER_SPRITE_Y_OFFSET*3, '37.9731043', '128.7591667', '강원 양양군 현남면 인구중앙길 89', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 11, 3, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_moku_500x500.jpg', '죽도'],'망고서프'		: [MARKER_SPRITE_X_OFFSET*12, MARKER_SPRITE_Y_OFFSET*3, '37.9732333', '128.7591064', '강원 양양군 현남면 인구중앙길 79', '#서핑강습 #게스트하우스 #렌탈 #매우친절', 12, 4, 'https://surfenjoy.cdn3.cafe24.com/shop/surfshop_mango_500x500.jpg', '죽도']    };
</script>