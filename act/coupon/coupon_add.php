<?php
include __DIR__.'/../db.php';
include __DIR__.'/../surf/surffunc.php';

function RandString($len){
    $return_str = "";

    for ( $i = 0; $i < $len; $i++ ) {
        mt_srand((double)microtime()*1000000);
        $return_str .= substr('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(0,35), 1);
    }

    return $return_str;
}

$coupon = $_REQUEST["coupon"];
$arrdate = explode("|", decrypt($coupon));

// echo '<br>'.$arrdate[0];
// echo '<br>'.decrypt($coupon);
if($arrdate[0] >= date("Y-m-d")){
    mysqli_query($conn, "SET AUTOCOMMIT=0");
    mysqli_query($conn, "BEGIN");

    $success = true;

    $coupon_code = RandString(5);
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $add_date = date("Y-m-d");

    $select_query = "SELECT * FROM AT_COUPON_CODE where couponseq = $arrdate[1] AND seq = '$arrdate[2]' AND use_yn = 'N' AND add_ip = '$user_ip'";
    $result = mysqli_query($conn, $select_query);
    $chkCnt = mysqli_num_rows($result); //체크 개수
    if($chkCnt == 0){
        $select_query = "INSERT INTO AT_COUPON_CODE(`couponseq`, `coupon_code`, `seq`, `add_ip`, `add_date`) VALUES ($arrdate[1], '$coupon_code', '$arrdate[2]', '$user_ip', '$add_date')";
        $result_set = mysqli_query($conn, $select_query);
        if(!$result_set) $success = false;

        if(!$success){
            mysqli_query($conn, "ROLLBACK");
            echo 'err';
        }else{
            mysqli_query($conn, "COMMIT");
            echo $coupon_code;
        }
    }else{
        echo "over";
    }
}else{
    echo "no";
}

?>