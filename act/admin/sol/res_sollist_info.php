<?php
include __DIR__.'/../../db.php';
include __DIR__.'/../../surf/surffunc.php';

$param = $_REQUEST["resparam"];
$resseq = $_REQUEST["resseq"];

if($param == "solview"){ //상세정보
    header('Content-Type: application/json');

    $select_query = "SELECT * FROM AT_SOL_RES_MAIN as a INNER JOIN AT_SOL_RES_SUB as b 
                        ON a.resseq = b.resseq 
                        WHERE a.resseq = $resseq
                            ORDER BY  b.ressubseq";
    $result = mysqli_query($conn, $select_query);
    $count_sub = mysqli_num_rows($result);

    if($count_sub == 0){
        echo "err";
    }else{
        $dbdata = array();
        $i = 0;
        while ( $row = $result->fetch_assoc()){
            $dbdata[$i] = $row;
            $i++;
        }

        $output = json_encode($dbdata, JSON_UNESCAPED_UNICODE);
        echo urldecode($output);
    }
}
?>