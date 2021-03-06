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

<div class="bd" style="padding:0px;" id="s1">
	<span id="mapnum"></span>
	<div id="map" style="width:100%;height:100%;">&nbsp;</div>
</div>

<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=zhh3svia3i&submodules=geocoder"></script>
<script>
MARKER_SPRITE_POSITION = parent.MARKER_SPRITE_POSITION2;
var mapOptions = {
	zoomControl: true,
	zoomControlOptions: {
		style: naver.maps.ZoomControlStyle.SMALL,
		position: naver.maps.Position.RIGHT_CENTER
	},
	center: new naver.maps.LatLng(parent.sLng, parent.sLat),
    zoom: 13
};

var mapShopView = 0;
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
			url: 'https://navermaps.github.io/maps.js.ncp/docs/img/example/ico_pin.jpg', //50, 68 크기의 원본 이미지
			//url: 'http://static.naver.com/maps2/icons/marker-default.png',
			size: new naver.maps.Size(18, 25),
			scaledSize: new naver.maps.Size(18, 25),
			origin: new naver.maps.Point(0, 0),
			anchor: new naver.maps.Point(12, 34)
		},

        /*icon: {
            url: 'http://static.naver.com/maps2/icons/pin_spot.png'
        },*/
        zIndex: 100
    });

var shopbox2 = '<div class="overlaybox">' +
    '    <div class="boxtitle">[' + MARKER_SPRITE_POSITION[key][9] + '] '+ key +'</div>' +
    '    <div class="first" style="background: url(' + MARKER_SPRITE_POSITION[key][8] + ') no-repeat;background-size: 100%">' +
    '        <!--div class="movietitle text">'+ key +'</div-->' +
    '    </div>' +
    '    <ul>' +
    '        <li class="up">' +
    '            <span class="title">' + MARKER_SPRITE_POSITION[key][4] + '</span>' +
    '        </li>' +
    '        <li style="background:#d24545;color:#fff;text-align:center;font-size:15px;cursor:pointer;" onclick="fnShopViewMove(' + MARKER_SPRITE_POSITION[key][7] + ');">' +
    '            <span class="title">상세내용 보기</span>' +
    '        </li>' +
    '    </ul>' +
    '</div>';

var shopbox = '<div style="width:230px;text-align:left;padding:10px;line-height:1.5;cursor:pointer;" onclick="fnShopViewMove(' + MARKER_SPRITE_POSITION[key][7] + ');"><b>'+ key +'</b><br/>&nbsp;&nbsp;&nbsp;' + MARKER_SPRITE_POSITION[key][4] + '<br/>&nbsp;&nbsp;&nbsp;' + MARKER_SPRITE_POSITION[key][5] + "</div>";

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

    //marker.addListener('mouseover', onMouseOver);
    //marker.addListener('mouseout', onMouseOut);
	if(MARKER_SPRITE_POSITION[key][6] == 0 && parent.mapView == 1){
		mapShopView = 1;
		//infoWindow.open(map, marker)
	}
};

naver.maps.Event.addListener(map, 'idle', function() {
    updateMarkers(map, markers);
});

window.onload=function(){
	if(mapShopView == 1){
		var marker = markers[0],
				infoWindow = infoWindows[0];
		infoWindow.open(map, marker);

		var position = new naver.maps.LatLng(marker["position"]["y"],marker["position"]["x"]);
		//map.panTo(position);
		//infoWindow.open(map, marker);
	}
}

function fnShopViewMove(seq){
	parent.location.href = '/surfres?seq=' + seq;
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
            infoWindow.close();
        } else {
            infoWindow.open(map, marker);

			var position = new naver.maps.LatLng(marker["position"]["y"] + 0.0005,marker["position"]["x"]);
			//map.panTo(position);
        }
    }
}

for (var i=0, ii=markers.length; i<ii; i++) {
    naver.maps.Event.addListener(markers[i], 'click', getClickHandler(i));
}

function initGeocoder() {
    var latlng = map.getCenter();
    var utmk = naver.maps.TransCoord.fromLatLngToUTMK(latlng); // 위/경도 -> UTMK
    var tm128 = naver.maps.TransCoord.fromUTMKToTM128(utmk);   // UTMK -> TM128
    var naverCoord = naver.maps.TransCoord.fromTM128ToNaver(tm128); // TM128 -> NAVER

    infoWindow = new naver.maps.InfoWindow({
        content: ''
    });

    map.addListener('click', function(e) {
        var latlng = e.coord,
            utmk = naver.maps.TransCoord.fromLatLngToUTMK(latlng),
            tm128 = naver.maps.TransCoord.fromUTMKToTM128(utmk),
            naverCoord = naver.maps.TransCoord.fromTM128ToNaver(tm128),
			ch = naver.maps.TransCoord.fromNaverToLatLng("291971,562552");

		//임시
		document.getElementById("mapnum").innerText = latlng;

        utmk.x = parseFloat(utmk.x.toFixed(1));
        utmk.y = parseFloat(utmk.y.toFixed(1));

        infoWindow.setContent([
            '<div style="padding:10px;width:350px;font-size:14px;line-height:20px;">',
            '<strong>LatLng</strong> : '+ latlng +'<br />',
            '<strong>UTMK</strong> : '+ utmk +'<br />',
            '<strong>TM128</strong> : '+ tm128 +'<br />',
            '<strong>NAVER</strong> : '+ naverCoord +'<br />',
            '</div>'
        ].join(''));

        infoWindow.open(map, latlng);
    });
}

function searchAddressToCoordinate(address) {
    naver.maps.Service.geocode({
        address: address
    }, function(status, response) {
        if (status === naver.maps.Service.Status.ERROR) {
            return alert('Something Wrong!');
        }

        var item = response.result.items[0],
            addrType = item.isRoadAddress ? '[도로명 주소]' : '[지번 주소]',
            point = new naver.maps.Point(item.point.x, item.point.y);

        infoWindow.setContent([
                '<div style="padding:10px;min-width:200px;line-height:150%;">',
                '<h4 style="margin-top:5px;">검색 주소 : '+ response.result.userquery +'</h4><br />',
                addrType +' '+ item.address +'<br />',
                '&nbsp&nbsp&nbsp -> '+ point.x +','+ point.y,
                '</div>'
            ].join('\n'));


        map.setCenter(point);
        infoWindow.open(map, point);
    });
}

function onMouseOver(e) {
    var marker = e.overlay,
        seq = marker.get('seq'),
        seq2 = marker.get('seq2');

    marker.setIcon({
        url: 'http://static.naver.com/maps2/icons/pin_spot.png'
    });
}
function onMouseOut(e) {
    var marker = e.overlay,
        seq = marker.get('seq'),
        seq2 = marker.get('seq2');

    marker.setIcon({
        url: 'http://static.naver.com/maps2/icons/marker-default.png'
    });
}

function mapMove(vlu){
	var position = new naver.maps.LatLng(parseFloat(MARKER_SPRITE_POSITION[vlu][2]),MARKER_SPRITE_POSITION[vlu][3]);
	//map.panTo(position);

	var num = MARKER_SPRITE_POSITION[vlu][6];
	var marker = markers[num],
		infoWindow = infoWindows[num];
        infoWindow.open(map, marker);



	var mobile = fnMobileType();
	var mapAppHtml = "";
	var mapNameText = encodeURIComponent(vlu);
}

function fnMobileType(){
	if (/android|iphone|ipad|ipod/i.test(navigator.userAgent))
	{
		if(/android/i.test(navigator.userAgent)){
			return 1;
		}else{
			return 2;
		}
	}else{
		return 0;
	}
}
//searchAddressToCoordinate("제주특별자치도 서귀포시 색달동 3039");
//naver.maps.onJSContentLoaded = initGeocoder;
</script>