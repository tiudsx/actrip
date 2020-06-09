<?php
include __DIR__.'/../../db.php';
include __DIR__.'/../../surf/surffunc.php';

$param = $_REQUEST["resparam"];
$ressubseq = $_REQUEST["ressubseq"];

if($param == "busmodify"){ //상태 정보
    header('Content-Type: application/json');

    $select_query = "SELECT a.user_name, a.user_tel, a.user_email, b.* FROM `AT_RES_MAIN` as a INNER JOIN `AT_RES_SUB` as b ON a.resnum = b.resnum WHERE b.ressubseq = $ressubseq";
    $result = mysqli_query($conn, $select_query);
    $count_sub = mysqli_num_rows($result);

    if($count_sub == 0){
        echo "err";
    }else{
        $dbdata;
        while ( $row = $result->fetch_assoc()){
            $dbdata = $row;
        }

        $output = json_encode($dbdata, JSON_UNESCAPED_UNICODE);
        echo urldecode($output);
    }
}
?>