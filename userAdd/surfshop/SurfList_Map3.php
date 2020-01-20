<style>
html, body, iframe, h1, h2, h3, h4, h5, h6, a, img, dl, dt, dd, fieldset, form, input, label, table, caption, tbody, tfoot, thead, tr, th, td, embed, hgroup{margin:0; padding:0; font-size:12px;}

.overlaybox {position:relative;height:270px;background:url('https://surfenjoy.cdn3.cafe24.com/shop/box_movie.png') no-repeat;padding:0px 10px 0px 10px;left:15px;}
.overlaybox div, ul {overflow:hidden;margin:0;padding:0;}
.overlaybox li {list-style: none;}
.overlaybox .boxtitle {color:#fff;font-size:16px;font-weight:bold;margin-bottom:8px;padding-top:3px;}
.overlaybox .first {position:relative;width:247px;height:136px;margin-bottom:8px;}
.first .text {color:#fff;font-weight:bold;}
.first .movietitle {position:absolute;width:100%;bottom:0;background:rgba(0,0,0,0.4);padding:7px 15px;font-size:14px;}
.overlaybox ul {width:247px;}
.overlaybox li {position:relative;margin-bottom:2px;background:#2b2d36;padding:5px 10px;color:#aaabaf;line-height: 1;}
.overlaybox li span {display:inline-block;}
.overlaybox li .title {font-size:13px;}
</style>

<?
include __DIR__.'/../db.php';
$arrMapList = array();

$select_query = 'SELECT * FROM SURF_BUS_GPS_BUS ORDER BY user_name';
$result_setlist = mysqli_query($conn, $select_query);

$mapNum = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){
	$arrMapList[$mapNum] = $row['user_name'].'|'.$row['lng'].'|'.$row['lat'].'|'.$mapNum.'|https://surfenjoy.cdn3.cafe24.com/bus/bus1.jpg|'.$row['insdate'];
	$mapNum++;

}


$mapList = "";
$now = date("Y-m-d H:i:s");
foreach($arrMapList as $value){
	$arrMapList = explode('|', $value);

	$todayDate = date("Y-m-d H:i:s", strtotime($arrMapList[5]));
	$toNow = (strtotime($now)-strtotime($todayDate));
	$toNowMin = 0;
	$toNowS = 0;

	$gpsTime = $toNow."초 전...";

	if($toNow > 60){
		$toNowMin = (int)((strtotime($now)-strtotime($todayDate)) / 60);
		$toNowS = $toNow - ($toNowMin * 60);
		
		$gpsTime = $toNowMin."분 ".$toNowS."초 전...";
	}

	//echo $arrMapList[0]." 수집시간 : ".$todayDate." / $toNow / $toNowMin / $toNowS<br>";
	
	$mapList .= "'$arrMapList[0]'		: [MARKER_SPRITE_X_OFFSET*$arrMapList[3], MARKER_SPRITE_Y_OFFSET*3, '$arrMapList[2]', '$arrMapList[1]', '', '', $arrMapList[3], '$arrMapList[4]', '수집시간 : $gpsTime'],";
}

$mapList = rtrim($mapList, ',');
?>
<div class="bd" style="padding:0px;" id="s1">
	<span id="mapnum"></span>
	<div id="map" style="width:100%;height:100%;">&nbsp;</div>
</div>

<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=zhh3svia3i&submodules=geocoder"></script>

<script>
var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION = {
        <?=$mapList?>
    };

var mapOptions = {
	zoomControl: true,
	zoomControlOptions: {
		style: naver.maps.ZoomControlStyle.SMALL,
		position: naver.maps.Position.RIGHT_CENTER
	},
	center: new naver.maps.LatLng(37.9714987, 128.7615295),
    zoom: 13
};

var map = new naver.maps.Map('map', mapOptions);

var bounds = map.getBounds(),
    southWest = bounds.getSW(),
    northEast = bounds.getNE(),
    lngSpan = northEast.lng() - southWest.lng(),
    latSpan = northEast.lat() - southWest.lat();

var markers = [],
    infoWindows = [];

for (var key in MARKER_SPRITE_POSITION) {

    /*
	var position = new naver.maps.LatLng(
        southWest.lat() + latSpan * Math.random(),
        southWest.lng() + lngSpan * Math.random());
	*/
    var position = new naver.maps.LatLng(MARKER_SPRITE_POSITION[key][2],MARKER_SPRITE_POSITION[key][3]);

    var marker = new naver.maps.Marker({
        map: map,
        position: position,
        title: key,
		icon: {
			url: 'https://surfenjoy.cdn3.cafe24.com/bus/sp_pins_spot_v3.png', //50, 68 크기의 원본 이미지
            size: new naver.maps.Size(24, 37),
            anchor: new naver.maps.Point(12, 37),
            origin: new naver.maps.Point(MARKER_SPRITE_POSITION[key][0], MARKER_SPRITE_POSITION[key][1])
		},

        /*icon: {
            url: 'http://static.naver.com/maps2/icons/pin_spot.png'
        },*/
        zIndex: 100
    });

	var busImg = "https://surfenjoy.cdn3.cafe24.com/bus/bus1.jpg";
	var shopbox2 = '<div class="overlaybox">' +
		'    <div class="boxtitle">[서울-양양] '+ key +'</div>' +
		'    <div class="first" style="background: url(' + MARKER_SPRITE_POSITION[key][7] + ') no-repeat;background-size: 100%">' +
		'        <!--div class="movietitle text">'+ key +'</div-->' +
		'    </div>' +
		'    <ul>' +
		'        <li class="up">' +
		'            <span class="title">' + MARKER_SPRITE_POSITION[key][8] + '</span>' +
		'        </li>' +
		'        <li style="background:#d24545;color:#fff;text-align:center;font-size:15px;cursor:pointer;margin-top:5px;padding-top:5px;padding-bottom:5px;" onclick="fnShopViewMove();">' +
		'            <span class="title">정류장 보기</span>' +
		'        </li>' +
		'    </ul>' +
		'</div>';

	var infoWindow = new naver.maps.InfoWindow({
        content: shopbox2,
		backgroundColor: "",
		borderColor: "",
		borderWidth: 0,
		disableAnchor: false,
		anchorSize: new naver.maps.Size(0, 0),
		anchorColor: ""
    });
	marker.set('seq', MARKER_SPRITE_POSITION[key][0]);
	marker.set('seq2', MARKER_SPRITE_POSITION[key][1]);
	marker.set('seq3', key);
    markers.push(marker);
    infoWindows.push(infoWindow);

};

naver.maps.Event.addListener(map, 'idle', function() {
    updateMarkers(map, markers);
});


function fnShopViewMove(){
	var openNewWindow = window.open("about:blank");
	openNewWindow.location.href = "/buspoint";
}

function updateMarkers(map, markers) {
    var mapBounds = map.getBounds();
    var marker, position;

    for (var i = 0; i < markers.length; i++) {

        marker = markers[i]
        position = marker.getPosition();

        if (mapBounds.hasLatLng(position)) {
            showMarker(map, marker);
        } else {
            hideMarker(map, marker);
        }
    }
}

function showMarker(map, marker) {
    if (marker.setMap()) return;
    marker.setMap(map);
}

function hideMarker(map, marker) {
    if (!marker.setMap()) return;
    marker.setMap(null);
}

// 해당 마커의 인덱스를 seq라는 클로저 변수로 저장하는 이벤트 핸들러를 반환합니다.
function getClickHandler(seq) {
    return function(e) {
        var marker = markers[seq],
            infoWindow = infoWindows[seq];
        if (infoWindow.getMap()) {
            //infoWindow.close();

			var position = new naver.maps.LatLng(marker["position"]["y"] + 0.0005,marker["position"]["x"]);
			map.panTo(position);
        } else {
            infoWindow.open(map, marker);

			var position = new naver.maps.LatLng(marker["position"]["y"] + 0.0005,marker["position"]["x"]);
			map.panTo(position);
        }
    }
}

function mapMove(vlu){
	var position = new naver.maps.LatLng(parseFloat(MARKER_SPRITE_POSITION[vlu][2]) + 0.0006,MARKER_SPRITE_POSITION[vlu][3]);
	map.panTo(position);

	var num = MARKER_SPRITE_POSITION[vlu][6];
	var marker = markers[num],
		infoWindow = infoWindows[num];
        infoWindow.open(map, marker);
}

window.onload=function(){
	var marker = markers[0],
			infoWindow = infoWindows[0];
	infoWindow.open(map, marker);

	var position = new naver.maps.LatLng(marker["position"]["y"],marker["position"]["x"]);
	map.panTo(position);
	//infoWindow.open(map, marker);

	for (var i=0, ii=markers.length; i<ii; i++) {
		naver.maps.Event.addListener(markers[i], 'click', getClickHandler(i));
	}
}
</script>