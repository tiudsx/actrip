<?
include __DIR__.'/../db.php';


// 과거 수집 데이터 삭제
mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

$select_query = "DELETE FROM AT_PROD_BUS_GPS_LAST WHERE TIMESTAMPDIFF(MINUTE, insdate, now()) > 20";
$result_set = mysqli_query($conn, $select_query);

mysqli_query($conn, "COMMIT");

?>

<div id="wrap">
    <? include __DIR__.'/../_layout_top.php'; ?>

    <link rel="stylesheet" type="text/css" href="../css/surfview.css">
    <link rel="stylesheet" type="text/css" href="../css/surfview_bus.css">
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />

    <div class="top_area_zone">
        <section class="shoptitle">
            <div style="padding:6px;">
                <h1>액트립 서핑버스 실시간 위치조회</h1>
                <div class="reviewcnt">※ 서핑버스 현재위치를 1분마다 조회하여 표시됩니다.</div>
                <div class="shopsubtitle">※ 실제위치와 오차가 있을 수 있으니 참고부탁드립니다.</div>
            </div>
        </section>

        <section class="notice">
            <div class="vip-tabwrap">
                <div id="tabnavi" class="fixed1" style="top: 49px;">
                    <div class="vip-tabnavi">
                        <ul>
                            <li class="on"><a>현재위치 조회</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div id="view_tab2" style="min-height: 800px;">

<?
$now = date("Y-m-d H:i:s");
//$now = "2020-06-27 13:29:00";
$weekNum = date("w", strtotime($now));
$nowTime = date("Hi", strtotime($now));

if($nowTime < 1330){
    $busList = "'Y','E'";
}else{
    $busList = "'S','A'";
}

$arrMapList = array();
$select_query = 'SELECT * FROM AT_PROD_BUS_GPS_LAST a INNER JOIN AT_PROD_BUS b
                    ON a.user_name = b.gpsname
                        AND a.gpsdate = b.busdate
                    WHERE b.busgubun IN ('.$busList.')
                    ORDER BY b.busgubun DESC, b.busnum';
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

$busNumBtn = "";
$busGPS = "";
$mapNum = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){
    $busNum = $row['busgubun'].$row['busnum'];
    $busgubun = $row["busgubun"];
	$busName = $row['busname'];
	$user_name = $row['user_name'];
	$lat = $row['lat'];
    $lng = $row['lng'];
    $insdate = $row['insdate'];

    $busNumBtn .= '<input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="'.$busName.'" bus="'.$busNum.'" onclick="fnBusGPSPoint(this);">&nbsp;';

    $arrMapList[$row['busgubun']] .= '<input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="'.$busName.'" bus="'.$busNum.'" onclick="fnBusGPSPoint(this);">&nbsp;';

    $todayTime = date("h시 i분", strtotime($insdate));

    $todayDate = date("Y-m-d H:i:s", strtotime($insdate));
    $toNow = (strtotime($now)-strtotime($todayDate));
    
    $gpsTime = $toNow."초 전";
    if($toNow > 60){
		$toNowMin = (int)((strtotime($now)-strtotime($todayDate)) / 60);
		$toNowS = $toNow - ($toNowMin * 60);
		
		$gpsTime = $toNowMin."분 ".$toNowS."초 전";
	}

    if($busgubun == "Y"){
        $locationname = "서울 → 양양행";
    }else if($busgubun == "S"){
        $locationname = "양양 → 서울행";
    }else if($busgubun == "E"){
        $locationname = "서울 → 동해행";
    }else if($busgubun == "A"){
        $locationname = "동해 → 서울행";
    }

    $busImg = "https://surfenjoy.cdn3.cafe24.com/act_bus/surfbus_".$busNum.".jpg?v=0|";
    $busGPS .= "if(busGPSList.".$busNum." == null) busGPSList.".$busNum." = []; \n busGPSList.".$busNum.".push({ '$busNum': [MARKER_SPRITE_X_OFFSET*$mapNum, MARKER_SPRITE_Y_OFFSET*3, '$lat', '$lng', '$busImg', '$insdate', '$gpsTime 위치', '$locationname', '$busName', '$busgubun']});\n";

    $mapNum++;
}
?>

<script>
var MARKER_SPRITE_X_OFFSET = 29,
    MARKER_SPRITE_Y_OFFSET = 50;

var busGPSList = {}
    busGPSList.Y1 = [];
<?=$busGPS?>

var MARKER_POINT = "", MARKER_ZOOM = 17;
var MARKER_SPRITE_POSITION2 = {};
function fnBusGPSPoint(obj) {
	$j("input[btnpoint='point']").css("background", "").css("color", "");
	$j(obj).css("background", "#1973e1").css("color", "#fff");
    
    var busnum = $j(obj).attr("bus");
    var gubun = busnum.substring(0, 1);
    MARKER_POINT = busnum;
    
	if(gubun == "S" || gubun == "A"){
		MARKER_ZOOM = 18;
	}

	if(MARKER_SPRITE_POSITION2[busnum] == null){
		MARKER_SPRITE_POSITION2 = eval("busGPSList." + busnum)[0];
	}
	
	$j("#ifrmBusMap").css("display", "block").attr("src", "/act/surfbus/surfgpsmap.html");
}
</script>
            
    <div class="bd" style="padding-top:5px;">
        <table class="et_vars">
            <colgroup>
                <col style="width:190px;">
                <col style="width:*;">
            </colgroup>
            <tbody>
                <tr>
                    <th style="text-align: center;" colspan="2">
                        <strong style="line-height:2;">
                            ★ 액트립 셔틀버스 운행 차량
                        </strong>
                    </th>
                </tr>

            <?if($count == 0){?>
                <tr>
                    <td style="text-align:center;line-height:3;" colspan="2">
                        <h1 style='font-size:12px;height:50px;padding-top:20px;'>현재 서핑버스는 운행중이지 않습니다.</h1>
                    </td>
                </tr>
                <?}else{?>
                <?if($arrMapList["Y"]){?>
                <tr>
                    <th>서울 → 양양행</th>
                    <td style="line-height:3;">
                        <?=$arrMapList["Y"]?>
                    </td>
                </tr>
                <?
                }
                
                if($arrMapList["S"]){
                ?>
                <tr>
                    <th>양양 → 서울행</th>
                    <td style="line-height:3;">
                        <?=$arrMapList["S"]?>
                    </td>
                </tr>
                <?
                }
                
                if($arrMapList["E"]){
                ?>
                <tr>
                    <th>서울 → 동해행</th>
                    <td style="line-height:3;">
                        <?=$arrMapList["E"]?>
                    </td>
                </tr>
                <?
                }
                
                if($arrMapList["A"]){
                ?>
                <tr>
                    <th>동해 → 서울행</th>
                    <td style="line-height:3;">
                        <?=$arrMapList["A"]?>
                    </td>
                </tr>                        
            <?
                } 
            }
            ?>
            </tbody>
        </table>
    </div>

    <iframe scrolling="no" frameborder="0" id="ifrmBusMap" name="ifrmBusMap" style="width:100%;height:450px;display:none;"></iframe>

            </div>
        </section>
    </div>
</div>

<? include __DIR__.'/../_layout_bottom.php'; ?>

<script>    
    var busDateinit = "2020-04-01";

    $j(document).ready(function() {
        setTimeout('$j("input[type=button]").eq(0).click();', 500);
    });
</script>

<script src="../js/surfview_bus.js"></script>
<script src="../js/surfview.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/surfview_busday.js"></script>