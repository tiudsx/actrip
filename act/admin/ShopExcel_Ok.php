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
$i = 0;

mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

foreach($data as $key => $row) {
    // 첫번째 행은 제외할거임
    if($key == 0)
        continue;

    // //기존 회원번호 유무 체크하여 있으면 update 없으면 insert
    // $select_query = "SELECT * FROM AT_PROD_MAIN WHERE shopname = '".$row[0]."'";
    // $result = mysqli_query($conn, $select_query);
    // $count = mysqli_num_rows($result);
    
    // if($count == 0){
    $selData = array();
    //echo $key . " : " . $row[0] .'/' .$row[1]."<br/>";
    if($row[1] == "eat"){
        $selData[] = array("입력여부" => $row[0]
            , "code" => $row[1]
            , "샵이름" => $row[2]
            , "구분" => $row[3]
            , "카테고리명" => $row[4]
            , "카테고리 코드" => $row[5]
            , "대표번호" => $row[6]
            , "샵주소" => $row[7]
            , "위도" => $row[8]
            , "경도" => $row[9]
            , "대표메뉴" => $row[10]
            , "리스트 문구" => $row[11]
            , "제휴서비스" => $row[12]
            , "가격" => $row[13]
            , "썸네일" => $row[14]
            , "기타" => $row[15]);

        if($row[0] != "P"){
            // 기존데이터 삭제
            $select_query = "DELETE FROM AT_PROD_MAIN WHERE code = '$row[1]' AND shopname = '$row[2]'";
            $result_set = mysqli_query($conn, $select_query);
            if(!$result_set) goto errGo;

            $select_query = "INSERT INTO `AT_PROD_MAIN` (`code`, `bankseq`, `shopcharge`, `account_yn`, `category`, `categoryname`, `shopname`, `tel_kakao`, `tel_admin`, `shopaddr`, `shoplat`, `shoplng`, `img_ver`, `sub_title`, `sub_tag`, `shop_option`, `sub_info`, `shop_resinfo`, `shop_img`, `content_type`, `content`, `lesson_yn`, `rent_yn`, `bbq_yn`, `use_yn`, `view_yn`, `link_url`, `link_yn`, `sell_cnt`, `insuserid`, `insdate`, `upduserid`, `upddate`) VALUES
            ('$row[1]', 0, 0, 'N', '$row[5]', '$row[4]', '$row[2]', '', '$row[6]', '$row[7]', '$row[8]', '$row[9]', 0, '$row[10]', '$row[3]', '', '', '', 'https://surfenjoy.cdn3.cafe24.com/eat/thumfood.jpg', 'html', '', 'N', 'N', 'N', 'Y', 'Y', '', 'N', 0, 'admin', now(), 'admin', now());";
            //echo $select_query;
            $result_set = mysqli_query($conn, $select_query);
            if(!$result_set) goto errGo;

            $i++;
        }
    }
    $groupData[$key] = $selData;
    // }else{
    // }      
}

if(!$result_set){
    errGo:
    mysqli_query($conn, "ROLLBACK");
    echo 'err';
}else{
    mysqli_query($conn, "COMMIT");
    echo $i.'건 등록완료';
}

// $output = json_encode($groupData, JSON_UNESCAPED_UNICODE);
// echo urldecode($output);

unlink($img_name);
?>