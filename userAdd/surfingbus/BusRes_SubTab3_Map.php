<style>
html, body, iframe, h1, h2, h3, h4, h5, h6, a, img, dl, dt, dd, fieldset, form, input, label, table, caption, tbody, tfoot, thead, tr, th, td, embed, hgroup{margin:0; padding:0; font-size:12px;}
</style>

<div class="bd" style="padding:0px;" id="s1">
	<span id="mapnum"></span>
	<div id="map" style="width:100%;height:100%;">&nbsp;</div>
</div>

<!--<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=U1myst76wv3P5Cx0BYuB&submodules=geocoder"></script>-->
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=zhh3svia3i"></script>
<script>
var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50,
    MARKER_SPRITE_POSITION = {
        "여의도"		: [0, MARKER_SPRITE_Y_OFFSET*3, '37.5245283', '126.9217621', '여의도공원 횡단보도', '탑승시간 : <font color="red">05시 40분</font>', 0],
        "신도림"		: [MARKER_SPRITE_X_OFFSET*1, MARKER_SPRITE_Y_OFFSET*3, '37.5095592', '126.8885712', '홈플러스 신도림점 앞', '탑승시간 : <font color="red">05시 50분</font>', 1],
        "구로디지털단지": [MARKER_SPRITE_X_OFFSET*2, MARKER_SPRITE_Y_OFFSET*3, '37.4833593', '126.9015249', '동대문엽기떡볶이 앞 버스정류장', '탑승시간 : <font color="red">06시 05분</font>', 2],
        "봉천역"		: [MARKER_SPRITE_X_OFFSET*3, MARKER_SPRITE_Y_OFFSET*3, '37.4821436', '126.9426997', '봉천역 1번출구 앞', '탑승시간 : <font color="red">06시 20분</font>', 3],
        "사당역"		: [MARKER_SPRITE_X_OFFSET*3, MARKER_SPRITE_Y_OFFSET*3, '37.4764763', '126.977734', '사당역 6번출구 방향 신한성약국 앞', '탑승시간 : <font color="red">06시 30분</font>', 4],
        "강남역"		: [MARKER_SPRITE_X_OFFSET*4, MARKER_SPRITE_Y_OFFSET*3, '37.4982078', '127.0290928', '강남역 1번출구 버스정류장', '탑승시간 : <font color="red">06시 45분</font>', 5],
        "종합운동장역"	: [MARKER_SPRITE_X_OFFSET*5, MARKER_SPRITE_Y_OFFSET*3, '37.5104765', '127.0722925', '종합운동장역 4번출구 방향 버스정류장', '탑승시간 : <font color="red">07시 00분</font>', 6],
			
        "당산역"	: [0, MARKER_SPRITE_Y_OFFSET*3, '37.5344135', '126.9012162', '당산역 13출구 IBK기업은행 앞', '탑승시간 : <font color="red">05시 40분</font>', 7],
        "합정역"	: [MARKER_SPRITE_X_OFFSET*1, MARKER_SPRITE_Y_OFFSET*3, '37.5507926', '126.9159159', '합정역 3번출구 앞', '탑승시간 : <font color="red">05시 45분</font>', 8],
        "신촌역"	: [MARKER_SPRITE_X_OFFSET*2, MARKER_SPRITE_Y_OFFSET*3, '37.5551754', '126.9377183', '신촌역 5번출구 앞', '탑승시간 : <font color="red">05시 55분</font>', 9],
        "충정로역"	: [MARKER_SPRITE_X_OFFSET*3, MARKER_SPRITE_Y_OFFSET*3, '37.5602216', '126.9655845', '충정로역 4번출구 앞', '탑승시간 : <font color="red">06시 05분</font>', 10],
        "종로3가역"	: [MARKER_SPRITE_X_OFFSET*4, MARKER_SPRITE_Y_OFFSET*3, '37.5703347', '126.99317687', '종로3가역 12번출구 방향 새마을금고 앞', '탑승시간 : <font color="red">06시 20분</font>', 11],
        "왕십리역"	: [MARKER_SPRITE_X_OFFSET*5, MARKER_SPRITE_Y_OFFSET*3, '37.5615557', '127.0348018', '왕십리역 11번출구 방향 우리은행 앞', '탑승시간 : <font color="red">06시 40분</font>', 12],
        "건대입구역": [MARKER_SPRITE_X_OFFSET*6, MARKER_SPRITE_Y_OFFSET*3, '37.5393413', '127.0716672', '건대입구역 롯데백화점 스타시티점 입구', '탑승시간 : <font color="red">07시 00분</font>', 13],

        "목동역"	: [0, MARKER_SPRITE_Y_OFFSET*3, '37.5258341', '126.8656441', '목동역 5번출구 방향 버스정류장', '탑승시간 : <font color="red">05시 30분</font>', 14],
        "영등포역"	: [MARKER_SPRITE_X_OFFSET*1, MARKER_SPRITE_Y_OFFSET*3, '37.5165141', '126.9072803', '영등포역입구 택시승강장 뒤쪽', '탑승시간 : <font color="red">05시 45분</font>', 15],
        "흑석역"	: [MARKER_SPRITE_X_OFFSET*2, MARKER_SPRITE_Y_OFFSET*3, '37.5083259', '126.9639916', '흑석역 3번출구 CU편의점 앞', '탑승시간 : <font color="red">06시 05분</font>', 16],
        "신반포역"	: [MARKER_SPRITE_X_OFFSET*3, MARKER_SPRITE_Y_OFFSET*3, '37.5032103', '126.9956391', '신반포역 4번출구', '탑승시간 : <font color="red">06시 15분</font>', 17],
        "논현역"	: [MARKER_SPRITE_X_OFFSET*4, MARKER_SPRITE_Y_OFFSET*3, '37.5112622', '127.0223111', '논현역 1번출구 영동가구 앞', '탑승시간 : <font color="red">06시 25분</font>', 18],
        "강남구청역": [MARKER_SPRITE_X_OFFSET*5, MARKER_SPRITE_Y_OFFSET*3, '37.5172037', '127.0420593', '강남구청역 1번출구', '탑승시간 : <font color="red">06시 35분</font>', 19],

        "시청역"		: [0, MARKER_SPRITE_Y_OFFSET*3, '37.5656892', '126.9768335', '시청역 2번출구', '탑승시간 : <font color="red">06시 00분</font>', 20],
        "신용산역"		: [MARKER_SPRITE_X_OFFSET*1, MARKER_SPRITE_Y_OFFSET*3, '37.5290958', '126.9675779', '신용산역 4번출구', '탑승시간 : <font color="red">06시 20분</font>', 21],
        "사당역4"		: [MARKER_SPRITE_X_OFFSET*2, MARKER_SPRITE_Y_OFFSET*3, '37.478569', '126.9814861', '사당역 10번출구 방향 버거킹', '탑승시간 : <font color="red">06시 45분</font>', 22],
        "강남역4"		: [MARKER_SPRITE_X_OFFSET*3, MARKER_SPRITE_Y_OFFSET*3, '37.4982078', '127.0290928', '강남역 1번출구 버스정류장', '탑승시간 : <font color="red">07시 10분</font>', 23],
        "종합운동장역4"	: [MARKER_SPRITE_X_OFFSET*4, MARKER_SPRITE_Y_OFFSET*3, '37.5104765', '127.0722925', '종합운동장역 4번출구 방향 버스정류장', '탑승시간 : <font color="red">07시 30분</font>', 24],
        "잠실역4"		: [MARKER_SPRITE_X_OFFSET*5, MARKER_SPRITE_Y_OFFSET*3, '37.5120967', '127.0961789', '롯데마트 잠실점 정문 앞', '탑승시간 : <font color="red">07시 40분</font>', 25],
	
		
        "주문진해변"	: [0, 0, '37.910099', '128.8168456', '청시행비치 주차장 입구', '탑승시간 : <font color="red">14시 15분</font>', 26],
        "남애해변"	: [0, 0, '37.9452543', '128.7814356', '남애3리 입구', '탑승시간 : <font color="red">14시 30분</font>', 27],
        "인구해변"	: [MARKER_SPRITE_X_OFFSET*1, 0, '37.968786', '128.761337', '현남보건지소 맞은편', '탑승시간 : <font color="red">14시 35분</font>', 28],
        "죽도해변"	: [MARKER_SPRITE_X_OFFSET*2, 0, '37.9720003', '128.7595433', '죽도오토캠핑장 입구', '탑승시간 : <font color="red">14시 40분</font>', 29],
        "동산항해변"	: [MARKER_SPRITE_X_OFFSET*3, 0, '37.9763045', '128.7586692', '동산항해변 입구', '탑승시간 : <font color="red">14시 45분</font>', 30],
        "기사문해변": [MARKER_SPRITE_X_OFFSET*4, 0, '38.0053627', '128.7306342', '기사문 해변주차장 입구', '탑승시간 : <font color="red">14시 50분</font>', 31],
        "하조대해변": [MARKER_SPRITE_X_OFFSET*5, 0, '38.0268271', '128.7169575', '서피비치 회전교차로 횡단보도 앞', '탑승시간 : <font color="red">15시 00분</font>', 32],
        "동호해변"	: [MARKER_SPRITE_X_OFFSET*6, 0, '38.0577573', '128.6819169', '동호해변 버스정류장', '탑승시간 : <font color="red">15시 05분</font>', 33],
        "설악해변"	: [MARKER_SPRITE_X_OFFSET*7, 0, '38.1295523', '128.6221133', '설악해변 주차장입구', '탑승시간 : <font color="red">15시 15분</font>', 34],
		
		
        "주문진해변2"	: [0, 0, '37.910099', '128.8168456', '청시행비치 주차장 입구', '탑승시간 : <font color="red">17시 15분</font>', 35],
        "남애해변2"	: [0, 0, '37.9452543', '128.7814356', '남애3리 입구', '탑승시간 : <font color="red">17시 30분</font>', 36],
        "인구해변2"	: [MARKER_SPRITE_X_OFFSET*1, 0, '37.968786', '128.761337', '현남보건지소 맞은편', '탑승시간 : <font color="red">17시 35분</font>', 37],
        "죽도해변2"	: [MARKER_SPRITE_X_OFFSET*2, 0, '37.9720003', '128.7595433', '죽도오토캠핑장 입구', '탑승시간 : <font color="red">17시 40분</font>', 38],
        "동산항해변2"	: [MARKER_SPRITE_X_OFFSET*3, 0, '37.9763045', '128.7586692', '동산항해변 입구', '탑승시간 : <font color="red">17시 45분</font>', 39],
        "기사문해변2": [MARKER_SPRITE_X_OFFSET*4, 0, '38.0053627', '128.7306342', '기사문 해변주차장 입구', '탑승시간 : <font color="red">17시 50분</font>', 40],
        "하조대해변2": [MARKER_SPRITE_X_OFFSET*5, 0, '38.0268271', '128.7169575', '서피비치 회전교차로 횡단보도 앞', '탑승시간 : <font color="red">18시 00분</font>', 41],
        "동호해변2"	: [MARKER_SPRITE_X_OFFSET*6, 0, '38.0577573', '128.6819169', '동호해변 버스정류장', '탑승시간 : <font color="red">18시 05분</font>', 42],
        "설악해변2"	: [MARKER_SPRITE_X_OFFSET*7, 0, '38.1295523', '128.6221133', '설악해변 주차장입구', '탑승시간 : <font color="red">18시 15분</font>', 43]
    };

var map = new naver.maps.Map('map', {
    center: new naver.maps.LatLng(37.5245283, 126.9217621),
    zoom: 13
});

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
            url: 'https://surfenjoy.cdn3.cafe24.com/bus/sp_pins_spot_v3.png',
            size: new naver.maps.Size(24, 37),
            anchor: new naver.maps.Point(12, 37),
            origin: new naver.maps.Point(MARKER_SPRITE_POSITION[key][0], MARKER_SPRITE_POSITION[key][1])
        },
        zIndex: 100
    });

    var infoWindow = new naver.maps.InfoWindow({
        content: '<div style="width:190px;text-align:left;padding:10px;line-height:1.5;"><b>'+ key.replace("2", "") +'</b><br/>&nbsp;&nbsp;&nbsp;' + MARKER_SPRITE_POSITION[key][4] + '<br/>&nbsp;&nbsp;&nbsp;' + MARKER_SPRITE_POSITION[key][5] + "</div>"
    });
	marker.set('seq', MARKER_SPRITE_POSITION[key][0]);
	marker.set('seq2', MARKER_SPRITE_POSITION[key][1]);
	marker.set('seq3', key);
    markers.push(marker);
    infoWindows.push(infoWindow);

    marker.addListener('mouseover', onMouseOver);
    marker.addListener('mouseout', onMouseOut);

	if(MARKER_SPRITE_POSITION[key][6] == 0){
		infoWindow.open(map, marker)
	}
};

naver.maps.Event.addListener(map, 'idle', function() {
    //updateMarkers(map, markers);
});

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
        } else {
            infoWindow.open(map, marker);
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
            '<div style="padding:10px;width:300px;font-size:14px;line-height:20px;">',
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
        url: 'https://surfenjoy.cdn3.cafe24.com/bus/sp_pins_spot_v3_over.png',
        size: new naver.maps.Size(24, 37),
        anchor: new naver.maps.Point(12, 37),
        origin: new naver.maps.Point(seq, seq2)
    });
}
function onMouseOut(e) {
    var marker = e.overlay,
        seq = marker.get('seq'),
        seq2 = marker.get('seq2');

    marker.setIcon({
        url: 'https://surfenjoy.cdn3.cafe24.com/bus/sp_pins_spot_v3.png',
        size: new naver.maps.Size(24, 37),
        anchor: new naver.maps.Point(12, 37),
        origin: new naver.maps.Point(seq, seq2)
    });
}

function mapMove(vlu){
	var position = new naver.maps.LatLng(MARKER_SPRITE_POSITION[vlu][2],MARKER_SPRITE_POSITION[vlu][3]);
	map.panTo(position);

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
//searchAddressToCoordinate("현남면");
//naver.maps.onJSContentLoaded = initGeocoder;
</script>