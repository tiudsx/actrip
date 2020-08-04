<?php
include __DIR__.'/../db.php';

header('Content-Type: application/json');

$reqCode = ($_REQUEST["code"] == "") ? "busday" : $_REQUEST["code"];

$groupData = array();

//서핑버스 이용날짜 json
if($reqCode == "busday"){
    $seq = $_REQUEST["seq"];

    if($_REQUEST["bus"] == "Y"){
        $busgubun = "S";
    }else{
        $busgubun = "A";
    }

    $now = date("Y-m-d");
    $select_query = "SELECT *, REPLACE(RIGHT(busdate, 5), '-', '') as busjson FROM `AT_PROD_BUS` WHERE use_yn = 'Y' AND seq = '$seq' AND busgubun IN ('".$_REQUEST["bus"]."', '".$busgubun."') AND busdate >= '$now' ORDER BY busnum";
    $result_buslist = mysqli_query($conn, $select_query);
    while ($row = mysqli_fetch_assoc($result_buslist)){
        $arrBusInfo = array("busnum" => $row["busgubun"].$row["busnum"], "busname" => $row["busname"], "busseat" => $row["busseat"]);
        if($groupData[$row["busgubun"].$row["busjson"]] == null){
            $groupData[$row["busgubun"].$row["busjson"]] = array($arrBusInfo);
        }else{
            $groupData[$row["busgubun"].$row["busjson"]][] = $arrBusInfo;
        }
    }
//서핑버스 실시간 좌석 조회
}else if($reqCode == "busseat"){
    for ($i=0; $i <= 45; $i++) { 
        $groupData[] = array("seatnum" => "$i", "seatYN" => "Y");
    }

    $select_query = 'SELECT * FROM `AT_RES_SUB` where res_date = "'.$_REQUEST["busDate"].'" AND res_confirm IN (0, 1, 2, 3, 6) AND res_bus = "'.$_REQUEST["busNum"].'"';
    $result_setlist = mysqli_query($conn, $select_query);
    while ($row = mysqli_fetch_assoc($result_setlist)){
        //echo 'arrySeat['.$row['busSeat'].'] = "ok";';
        
        $groupData[$row['res_seat']] = array("seatnum" => $row['res_seat'], "seatYN" => "N");
    }
}

$output = json_encode($groupData, JSON_UNESCAPED_UNICODE);
echo urldecode($output);
?>

