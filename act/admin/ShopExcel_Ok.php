<?php
set_time_limit(0); 

include __DIR__.'/../db.php';

$img_name = $_FILES['filename']['name'];
$tmp_file = $_FILES['filename']['tmp_name']; //서버에 임시로 저장된 파일 경로

move_uploaded_file($tmp_file,dirname(__FILE__)."/".$img_name);//파일을 실제로 서버에 업로드 하는 php 함수

require_once 'reader.php';

$xlsx = new XLSXReader( $img_name );
$sheetNames = $xlsx->getSheetNames();

$sheet = $xlsx->getSheet($sheetNames[1]);
$data = $sheet->getData();

$groupData = array();
foreach($data as $key => $row) {
    // 첫번째 행은 제외할거임
    if($key == 0)
        continue;

    //기존 회원번호 유무 체크하여 있으면 update 없으면 insert
    $select_query = "SELECT * FROM AT_PROD_MAIN WHERE shopname = '".$row[0]."' AND use_yn = 'Y'";
    $result = mysqli_query($conn, $select_query);
    $count = mysqli_num_rows($result);
    
    if($count == 0){
        $selData = array();
        //echo $key . " : " . $row[0] .'/' .$row[1]."<br/>";

        $selData[] = array("입력여부" => $row[0], "구분" => $row[1], "샵이름" => $row[2]);

        foreach($row as $cell) {
            
        }
        
        $groupData[$key] = $selData;
    }else{
    }      

    
}
// $cnt = 0;
// $groupData = array();
// for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
//     $selData = array();
//     for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
//         $selData[] = $tmp.$data->sheets[0]['cells'][$i][$j].",";
//     }

//     $groupData[] = $selData;
//     // $tmp = substr($tmp,0,(strlen($tmp)-1));
//     // $tmp_arr = explode(",",$tmp);

//     // if(!$tmp_arr[0]) break;    //엑셀값이 없을경우 for문 나가기

//     //기존 회원번호 유무 체크하여 있으면 update 없으면 insert
//     // $query = mysql_query("select mnumber from DRCERT where mnumber='$tmp_arr[0]'");
//     // $result = mysql_fetch_array($query);
//     // $rs_mnumber = $result[0];

//     // if(!$rs_mnumber){
//     //     $query = "//인서트 쿼리";    
//     // }else{
//     //     $query = "//업데이트 쿼리";    
//     // }        

//     // $cnt++;
//     // echo $query."<br />".$cnt."<br />";
//     // mysql_query ($query); // 글 저장
//     // $tmp = "";            //쿼리 날린후 초기화하여 다시 루프
// }

$output = json_encode($groupData, JSON_UNESCAPED_UNICODE);
echo urldecode($output);

unlink($img_name);
?>