<?php
include __DIR__.'/../db.php';

function begin(){
	mysql_query("BEGIN");
}

function rollback(){
	mysql_query("ROLLBACK");
}

function commit(){
	mysql_query("COMMIT");
}

$success = true;
$datetime = date('Y/m/d H:i'); 

mysqli_query($conn, "SET AUTOCOMMIT=0");
mysqli_query($conn, "BEGIN");

$shopcode = "longbeach";
$shopname = "롱비치서프스쿨";
$shop_addr = "강원도 양양군 현남면 갯마을길 42-20";
$shop_lat = "37.9485905";
$shop_lng = "128.7789425";

$cate_3 = 60;

$shopcharge = 10;
$shoporder = 99;
$admin_userid = "";
$admin_email = "";
$admin_tel = "010-2331-7590"; //카카오톡 번호
$admin_phone = "010-2331-7590"; //대표 연락처
$shop_listimg = "https://surfenjoy.cdn3.cafe24.com/shop/surfshop_longbeach_200x188.jpg";
$shop_mainimg = "https://surfenjoy.cdn3.cafe24.com/shop/surfshop_longbeach_500x500.jpg";
$shop_info = "★ 대한민국 서핑샵 ".$shopname."!!@\r\n★ 우수한 실력과 친절함을 겸비한 강사진~@\r\n★ 조용한 서핑을 원할때는 이곳!!";
$shop_tag = "#서핑강습 #게스트하우스 #렌탈 #매우친절";
$shop_price = "강습|입문강습|0|70000@\r\n렌탈|서핑보드|0|20000";
$shop_content = "";//<img src='https://surfenjoy.cdn3.cafe24.com/surfshop/res_longbeach_01.jpg' class='placeholder2' />
$shop_useinfo = 1;
$shop_agreement = 1;
$opt_bus = "N";
$opt_bbq = "N";
$opt_reslist = "0,1,2,3,4";


$shopbank = "농협 351-1080-7853-93 / 정광영"; //전체계좌번호
$shopbankname = "농협"; //은행
$shopbanknum = "351-1080-7853-93"; //계좌번호
$shopbankuser = "정광영"; //예금주


$select_query = "INSERT INTO `SURF_SHOP` (`groupcode`, `shopcharge`, `shopbank`, `shopbankname`, `shopbanknum`, `shopbankuser`, `cate_1`, `cate_2`, `cate_3`, `shopcode`, `shopname`, `shoporder`, `admin_userid`, `admin_email`, `admin_tel`, `admin_phone`, `shop_listimg`, `shop_mainimg`, `shop_addr`, `shop_lat`, `shop_lng`, `shop_info`, `shop_tag`, `shop_price`, `shop_contentfile`, `shop_content`, `shop_useinfo`, `shop_agreement`, `opt_bus`, `opt_bbq`, `opt_reslist`, `useYN`, `insuserid`, `insdate`, `udpuserid`, `udpdate`) VALUES
('surf', $shopcharge, '$shopbank', '$shopbankname', '$shopbanknum', '$shopbankuser', $cate_3, $cate_3, $cate_3, '$shopcode', '$shopname', $shoporder, '$admin_userid', '$admin_email', '$admin_tel', '$admin_phone', '$shop_listimg', '$shop_mainimg', '$shop_addr', '$shop_lat', '$shop_lng', '$shop_info', '$shop_tag', '$shop_price', 'image', '$shop_content', $shop_useinfo, $shop_agreement, '$opt_bus', '$opt_bbq', '$opt_reslist', 'Y', 'admin', '$datetime', 'admin', '$datetime');";
$result_set = mysqli_query($conn, $select_query);
echo $select_query.'<br><br>';
if($success){
	$select_query = 'SELECT * FROM SURF_SHOP where shopcode = "'.$shopcode.'"';

	$result = mysqli_query($conn, $select_query);
	$rowMain = mysqli_fetch_array($result);

	$shopSeq = $rowMain["intseq"];

	$select_query = "INSERT INTO `SURF_SHOP_DAY` (`gubun`, `shopSeq`, `day_type`, `day_name`, `date_s`, `date_e`, `opt_week`, `week0`, `week1`, `week2`, `week3`, `week4`, `week5`, `week6`, `opt_price0`, `opt_price1`, `opt_price2`, `opt_price3`, `opt_price4`, `useYN`) VALUES
('surf', $shopSeq, 0, '비수기1', '2019-05-01', '2019-06-30', '0,1,2,3,4,5,6', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 0, 0, 0, 0, 0, 'Y'),
('surf', $shopSeq, 1, '비수기2', '2019-09-01', '2019-10-31', '0,1,2,3,4,5,6', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 0, 0, 0, 0, 0, 'N'),
('surf', $shopSeq, 2, '성수기1', '2019-07-01', '2019-08-31', '0,1,2,3,4,5,6', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 0, 0, 0, 0, 0, 'N');";
	$result_set = mysqli_query($conn, $select_query);

echo $select_query.'<br><br>';
	if(!$result_set) $success = false;
}

if($success){
	$select_query = "INSERT INTO `SURF_SHOP_OPT` (`gubun`, `shopSeq`, `opt_type`, `opt_order`, `opt_name`, `opt_time`, `opt_sexM`, `opt_sexW`, `opt_PkgTitle`, `opt_StayDay`, `opt_Price`, `opt_YN`) VALUES
('surf', $shopSeq, 0, 1, '입문강습', '9시|12시|15시|', 20, 20, NULL, NULL, 70000, 'Y'),
('surf', $shopSeq, 0, 2, '레벨업강습', '9시|12시|15시|', 20, 20, NULL, NULL, 100000, 'Y'),

('surf', $shopSeq, 1, 1, '스펀지보드', NULL, 20, 20, NULL, NULL, 30000, 'Y'),
('surf', $shopSeq, 1, 2, '에폭시보드', NULL, 20, 20, NULL, NULL, 45000, 'Y'),
('surf', $shopSeq, 1, 3, '서핑슈트', NULL, 20, 20, NULL, NULL, 15000, 'Y'),

('surf', $shopSeq, 3, 1, '게스트하우스', NULL, 20, 20, NULL, 5, 20000, 'Y');";
	$result_set = mysqli_query($conn, $select_query);

/*
('surf', $shopSeq, 0, 3, '2:1강습', '9시|12시|15시|', 20, 20, NULL, NULL, 130000, 'Y'),

('surf', $shopSeq, 2, 1, '얼리버드 서핑패키지1', '9시|11시|13시|15시|', 20, 20, '얼리버드 서핑패키지1 :  강습+숙박+바베큐+클럽파티', NULL, 70000, 'N'),
('surf', $shopSeq, 2, 2, '얼리버드 서핑패키지2', '9시|11시|13시|15시|', 20, 20, '얼리버드 서핑패키지2 :  숙박+바베큐+클럽파티', NULL, 40000, 'N'),
('surf', $shopSeq, 2, 3, '서핑패키지', '9시|11시|13시|15시|', 20, 20, '서핑패키지 :  강습+바베큐+클럽파티', NULL, 70000, 'N'),
('surf', $shopSeq, 2, 4, '바베큐패키지', '9시|11시|13시|15시|', 20, 20, '바베큐패키지 :  바베큐+클럽파티', NULL, 40000, 'N'),

,


('surf', $shopSeq, 3, 99, '게스트하우스', NULL, 20, 20, NULL, 5, 20000, 'N'),
('surf', $shopSeq, 4, 99, '바베큐', NULL, 20, 20, NULL, NULL, 20000, 'N')
*/
echo $select_query.'<br><br>';
	if(!$result_set) $success = false;
}

if(!$success){
	mysqli_query($conn, "ROLLBACK");

	echo '<script>alert("예약진행 중 오류가 발생하였습니다.");</script>';
}else{
	mysqli_query($conn, "COMMIT");

	echo '<script>alert("완료되었습니다.");</script>';
}
?>