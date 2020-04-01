<?php
include __DIR__.'/../db.php';

header('Content-Type: application/json');

$reqCode = ($_REQUEST["code"] == "") ? "busday" : $_REQUEST["code"];

$groupData = array();

//서핑버스 이용날짜 json
if($reqCode == "busday"){
    if($_REQUEST["bus"] == "Y"){
        $busgubun = "S";
    }else{
        $busgubun = "A";
    }

    $select_query = "SELECT *, REPLACE(RIGHT(busdate, 5), '-', '') as busjson FROM `AT_PROD_BUS` WHERE use_yn = 'Y' AND busgubun IN ('".$_REQUEST["bus"]."', '".$busgubun."') ORDER BY busnum";
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

    $select_query = 'SELECT * FROM `SURF_BUS_SUB` where busDate = "'.$_REQUEST["busDate"].'" AND DelUse = "N" AND ResConfirm IN (0, 1) AND busNum = "'.$_REQUEST["busNum"].'"';
    $result_setlist = mysqli_query($conn, $select_query);
    while ($row = mysqli_fetch_assoc($result_setlist)){
        //echo 'arrySeat['.$row['busSeat'].'] = "ok";';
        
        $groupData[$row['busSeat']] = array("seatnum" => $row['busSeat'], "seatYN" => "N");
    }
}

$output = json_encode($groupData, JSON_UNESCAPED_UNICODE);
echo urldecode($output);
?>

