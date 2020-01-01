<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

session_start();

if($_SESSION['shopseq'] == ""){
	$select_query_admin = 'SELECT * FROM `SURF_SHOP` where shopcode="'.$surftype.'" limit 1';
	$resultAdmin = mysqli_query($conn, $select_query_admin);
	$countAdmin = mysqli_num_rows($resultAdmin);
	$rowAdmin = mysqli_fetch_array($resultAdmin);

	if($countAdmin == 0){
		echo '<script>alert("관리자 권한이 없습니다.");history.back();</script>';
		exit;
	}

	$_SESSION['userid'] = $user_id;
	$_SESSION['shopseq'] = $rowAdmin["intseq"];
	$_SESSION['shopname'] = $rowAdmin["shopname"];
	$_SESSION['opt_reslist'] = $rowAdmin["opt_reslist"];
}

$typeT = explode(",", $_SESSION['opt_reslist']);

$MainNumber = $_REQUEST["MainNumber"]; //카카오에서 넘어오는 파라미터

if($MainNumber == ""){
	$paramDate = date("Y-m-d");
}
?>

<div class="bd_tl" style="width:100%;display:;">
	<h1 class="ngeb clear"><i class="bg_color"></i>[<?=$_SESSION['shopname']?>] 정산관리</h1>
</div>

<link rel="stylesheet" type="text/css" href="Admin_surf.css" />
<script src="Admin_surf.js"></script>

<script>
var userid = "<?=$user_id?>";
$j(document).ready(function(){
});
</script>

<div class="container" id="contenttop">
  <section>
    <article class="right_article4">
		<?include 'Admin_SurfCalCalendar.php'?>
    </article>
    <aside class="left_article4">
<!-- .tab_container -->
<div id="containerTab" class="areaRight">
    <ul class="tabs">
        <li class="active" rel="tab1">정산내용</li>
    </ul>

	<!-- #container -->
    <div class="tab_container">
        <!-- #tab1 -->
        <div id="tab1" class="tab_content">
			<div style="text-align:center;font-size:14px;padding:50px;" id="initText2">
			</div>
			<div id="divCalList">
			<?include 'Admin_SurfCalList.php'?>
			</div>
		</div>
    </div>
    <!-- .tab_container -->
</div>
<!-- #container -->

	</aside>
  </section>
</div>