<?php
include __DIR__.'/../db.php';

$success = true;
$insuserid = "admin";
$datetime = date('Y/m/d H:i'); 

mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

/*
code
  - surf : 서핑샵
  - bbqparty : 바베큐파티
  - bus : 서틀버스
  - stay : 숙소
  - eat : 맛집
  - act : 액티비티
*/
$code = "surf";
$shopcharge = "10";
$account_yn = "Y";
$category = "jajak";
$categoryname = "자작도";
$shopname = "솔서프";
$tel_kakao = "070-7345-8088";
$tel_admin = "070-7345-8088";
$shopaddr = "강원 고성군 죽왕면 자작도선사길 86";
$shoplat = "37.5782053";
$shoplng = "129.1155484";
$img_ver = 0;
$sub_title = "★ 고성 자작도해변에서 고고비치서프와 함께!!@
★ 퀄리티 높은 강습과 강사가 있는 곳!!";
$sub_tag = "10월 12일, 13일 양양 서핑 페스티벌";
$sub_info = "입문강습|0|50000@숙박|게스트하우스|0|20000";
$imgurl = "https://surfenjoy.cdn3.cafe24.com/surfshop/";
$shop_img = $imgurl."surfshop_sol_200x188.jpg|".$imgurl."surfshop_sol_500x500.jpg|";
//상세설명 구분 : file / html
$content_type = "html";
$content = "<img src=\'https://surfenjoy.cdn3.cafe24.com/surfshop/res_solguest_01.jpg\' class=\'placeholder\' />";
$lesson_yn = "Y";
$rent_yn = "Y";
$bbq_yn = "Y";
$use_yn = "Y";
$view_yn = "Y";
$link_url = "";
$link_yn = "N";
$sell_cnt = 275;

/* 입점샵 은행 계좌 정보 */
$full_bankname = "농협"; //은행
$full_banknum = "368-02-0429-94"; //계좌번호
$full_bankuser = "이준영"; //예금주

//주문연동 계좌 정보
$bankname = ""; //은행
$banknum = ""; //계좌번호
$bankuser = ""; //예금주
$banklinkUse = "N"; //주문영동 여부

$debug_query = "";
/* 입점샵 은행계좌 입력 */
$select_query = "INSERT INTO `AT_PROD_BANKNUM`(`shopname`, `full_bankname`, `full_banknum`, `full_bankuser`, `bankname`, `banknum`, `bankuser`, `banklinkUse`, `etc`) VALUES ('$shopname', '$full_bankname', '$full_banknum', '$full_bankuser', '$bankname', '$banknum', '$bankuser', '$banklinkUse', '');";
$result_set = mysqli_query($conn, $select_query);
$debug_query .= '<br><br>AT_PROD_BANKNUM:'.$select_query;
if(!$result_set) goto errGo;

/* 입점샵 메인정보 입력 */
$select_query = "INSERT INTO `AT_PROD_MAIN` (`code`, `bankseq`, `shopcharge`, `account_yn`, `category`, `categoryname`, `shopname`, `tel_kakao`, `tel_admin`, `shopaddr`, `shoplat`, `shoplng`, `img_ver`, `sub_title`, `sub_tag`, `sub_info`, `shop_img`, `content_type`, `content`, `lesson_yn`, `rent_yn`, `bbq_yn`, `use_yn`, `view_yn`, `link_url`, `link_yn`, `sell_cnt`, `insuserid`, `insdate`, `upduserid`, `upddate`) VALUES
('$code', LAST_INSERT_ID(), '$shopcharge', '$account_yn', '$category', '$categoryname', '$shopname', '$tel_kakao', '$tel_admin', '$shopaddr', '$shoplat', '$shoplng', $img_ver, '$sub_title', '$sub_tag', '$sub_info', '$shop_img', '$content_type', '$content', '$lesson_yn', '$rent_yn', '$bbq_yn', '$use_yn', '$view_yn', '$link_url', '$link_yn', $sell_cnt, '$insuserid', '$datetime', '$insuserid', '$datetime');";
$result_set = mysqli_query($conn, $select_query);
$debug_query .= '<br><br>AT_PROD_MAIN:'.$select_query;
//echo $select_query.'<br><br>';
if(!$result_set) goto errGo;

$result = mysqli_query($conn, "select LAST_INSERT_ID() as identity");
$rowMain = mysqli_fetch_array($result);
$seq = $rowMain["identity"];

/* 입점샵 운영기간 입력 */
	$select_query = "INSERT INTO `AT_PROD_DAY` (`seq`, `ordernum`, `day_name`, `sdate`, `edate`, `day_week`, `week0`, `week1`, `week2`, `week3`, `week4`, `week5`, `week6`, `lesson_price`, `rent_price`, `stay_price`, `bbq_price`, `use_yn`) VALUES 
	($seq, 1, '비수기1', '2020-04-01', '2020-06-30', '0,1,2,3,4,5,6', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 0, 0, 0, 0, 'Y'), 
	($seq, 2, '성수기1', '2020-07-01', '2020-08-31', '0,1,2,3,4,5,6', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 0, 0, 5000, 0, 'Y'), 
	($seq, 3, '비수기2', '2020-09-01', '2019-10-31', '0,1,2,3,4,5,6', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 0, 0, 0, 0, 'Y');";
	$result_set = mysqli_query($conn, $select_query);
	$debug_query .= '<br><br>AT_PROD_DAY:'.$select_query;
	//echo $select_query.'<br><br>';
	if(!$result_set) goto errGo;

/* 입점샵 옵션 입력 */
//lesson, rent, bbq
	$select_query = "INSERT INTO `AT_PROD_OPT` (`seq`, `optcode`, `optname`, `optsubname`, `opttime`, `opt_sexM`, `opt_sexW`, `opt_info`, `default_price`, `account_price`, `sell_price`, `shopcharge`, `use_yn`, `list_yn`, `peak_yn`, `stay_day`, `ordernum`) VALUES 
	($seq, 'lesson', '입문강습', '', '10시|13시|15시|', 9, 9, '', 80000, 72000, 80000, 10, 'Y', 'Y', 'N', -1, 1), 
	($seq, 'lesson', '입문강습+숙박 1박(당일)', '', '10시|13시|15시|', 9, 9, '', 80000, 72000, 80000, 10, 'Y', 'Y', 'Y', 0, 2),
	($seq, 'lesson', '입문강습+숙박 1박(전날)', '', '10시|13시|15시|', 9, 9, '', 80000, 72000, 80000, 10, 'Y', 'Y', 'Y', 1, 3),
	($seq, 'lesson', '입문강습+숙박 2박', '', '10시|13시|15시|', 9, 9, '', 80000, 72000, 80000, 10, 'Y', 'Y', 'Y', 2, 4),

	($seq, 'rent', '스펀지보드', '', '', 9, 9, '', 30000, 27000, 30000, 10, 'Y', 'Y', 'N', -1, 5), 
	($seq, 'rent', '에폭시보드', '', '', 9, 9, '', 40000, 36000, 40000, 10, 'Y', 'Y', 'N', -1, 6), 
	($seq, 'rent', '서핑슈트', '', '', 9, 9, '', 15000, 13500, 15000, 10, 'Y', 'Y', 'N', -1, 7),
	($seq, 'bbq', '바베큐파티', '', '', 20, 20, '', 30000, 30000, 30000, 0, 'Y', 'Y', 'N', -1, 8);";
	$result_set = mysqli_query($conn, $select_query);
	$debug_query .= '<br><br>AT_PROD_OPT:'.$select_query;
	//echo $select_query.'<br><br>';
	if(!$result_set) goto errGo;

if(!$success){
	errGo:
	mysqli_query($conn, "ROLLBACK");
	echo $debug_query;
	echo '<script>alert("예약진행 중 오류가 발생하였습니다.");</script>';
}else{
	mysqli_query($conn, "COMMIT");

	echo '<script>alert("완료되었습니다.");</script>';
}
?>