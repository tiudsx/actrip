<?
$param_mid = $_REQUEST["mid"];

if($param_mid == ""){
	$param = str_replace("/", "", $_SERVER["REQUEST_URI"]);

	if (!empty(strpos($_SERVER["REQUEST_URI"], '?'))){
		$param = substr($param, 0, strpos($_SERVER["REQUEST_URI"], '?') - 1);
	}

	$param = explode('_', $param)[0];
}else{
	$param = $param_mid;
}

$area = $_REQUEST["area"];

if($param == "surfres"){
	$select_query = 'SELECT a.*, b.gubun, b.codename FROM SURF_SHOP a INNER JOIN SURF_CODE b ON a.cate_3 = b.seq where intseq = '.$seq.' AND useYN = "Y"';
	$result = mysqli_query($conn, $select_query);
	$rowMain = mysqli_fetch_array($result);
	$count = mysqli_num_rows($result);

	if($count == 0){
		echo '<script>alert("예약이 불가능한 상품입니다.");location.href="surfevent";</script>';
		exit;
	}

	$param = $rowMain["gubun"];
	$area = $rowMain["cate_3"];

	if($param == "surfeast"){
		$areaname = '양양';
	}else if($param == "surfeast2"){
		$areaname = '고성';	
	}else if($param == "surfeast3"){
		$areaname = '동해,강릉';
	}else if($param == "surfsouth"){
		$areaname = '부산';
	}else if($param == "surfjeju"){
		$areaname = '제주';
	}else if($param == "surfsouth"){
		$areaname = '부산';
	}else if($param == "surfwest"){
		$areaname = '서해';
	}
}else{
	if($param == "surfeast"){
		$areaname = '양양';
		$areaCodeNone = "57";
	}else if($param == "surfeast2"){
		$areaname = '고성';	
		$areaCodeNone = "78";
	}else if($param == "surfeast3"){
		$areaname = '강릉,동해';
		$areaCodeNone = "84";
	}else if($param == "surfsouth"){
		$areaname = '부산';
		$areaCodeNone = "84";
	}else if($param == "surfjeju"){
		$areaname = '제주';
		$areaCodeNone = "67";
	}else if($param == "surfsouth"){
		$areaname = '부산';
		$areaCodeNone = "71";
	}else if($param == "surfwest"){
		$areaname = '서해';
		$areaCodeNone = "70";
	}else{
		$areaname = '추천샵';
		$areaview = 'eventview';
	}
}
?>

<link rel="stylesheet" type="text/css" href="surfshop_btn.css" />
<style>
.surfbtn li, .surfbtn2 li {
	list-style: none;
	float: left;
	font-size: 13px;
	padding-right: 5px;
}


.surfbtn a, .surfbtn2 a {
    display: block;
    overflow: hidden;
    padding: 7px 20px;
    margin: 2px;
    border: 1px solid #4f83bd;
    border-radius: 49px;
    white-space: nowrap;
    text-overflow: ellipsis;
    text-decoration: none !important;
    text-align: center;
    color: #4f83bd;
	letter-spacing: -0.5px;

}

.surfbtn2 a {
	background-color: #4f83bd;
    color: #fff;    
    background-position: 28px 16px;
    background-repeat: no-repeat;
}

.surfarea .surfbtn2 a:hover {
    background-color: #fff;
    color: black;    
    background-position: 28px 16px;
    background-repeat: no-repeat;

}

.surfarea .surfbtn a:hover {
    background-color: #4f83bd;
    color: #fff;    
    background-position: 28px 16px;
    background-repeat: no-repeat;

}

.surfbtn .on2 > a {
    border-color: #4f83bd;
    background: #4f83bd;
    color: #fff;
}

.surfbtn .on3 > a {
    border-color: #DDD;
    background: #DDD;
    color: #000;
    
}



a {
    selector-dummy: expression(this.hideFocus=true);
    text-decoration: none;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -ms-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
}

a:focus {
    outline: none;
}
a:hover {
    text-decoration: underline;
}

a:hover {
    text-decoration: none;
}
a {
    blr: expression(this.onFocus=this.blur());
}

.surfarea .surfbtn a{
    display: block !important;
}
.surfarea .surfbtn a{
    display: block !important;
}


  </style>
<?if($param != "surfBBQ"){?>
<div>
	<div class="popover-wrapper">
		<div class="popover-container-pc">
			<div class="popover-content animate-bounce-down popover-filter__option" data-popover-content="true" style="display:none;" id="areaView">
				<div class="layer-default">
					<div class="radio-list inner">
						<div class="input-radio <?=(($param == 'surfevent') ? 'input-radio_active' : '')?>"><input type="checkbox" id="basic" name="sortFilter" value="on"><label for="basic" onclick="location.href='/surfevent';">추천샵</label></div>
						<div class="input-radio <?=(($param == 'surfeast') ? 'input-radio_active' : '')?>"><input type="checkbox" id="like" name="sortFilter" value="on"><label for="like" onclick="location.href='/surfeast';">양양</label></div>
						<div class="input-radio <?=(($param == 'surfeast3') ? 'input-radio_active' : '')?>"><input type="checkbox" id="like" name="sortFilter" value="on"><label for="like" onclick="location.href='/surfeast3';">강릉,동해</label></div>
						<div class="input-radio <?=(($param == 'surfsouth') ? 'input-radio_active' : '')?>"><input type="checkbox" id="hot" name="sortFilter" value="on"><label for="hot" onclick="location.href='/surfsouth';">부산</label></div>
						<!--div class="input-radio <?=(($param == 'surfeast2') ? 'input-radio_active' : '')?>"><input type="checkbox" id="like" name="sortFilter" value="on"><label for="like" onclick="location.href='/surfeast2';">고성</label></div>
						<div class="input-radio <?=(($param == 'surfjeju') ? 'input-radio_active' : '')?>"><input type="checkbox" id="hot" name="sortFilter" value="on"><label for="hot" onclick="location.href='/surfjeju';">제주</label></div>
						
						<div class="input-radio <?=(($param == 'surfwest') ? 'input-radio_active' : '')?>"><input type="checkbox" id="hot" name="sortFilter" value="on"><label for="hot" onclick="location.href='/surfwest';">서해</label></div-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--div class="fixed_wrap2" style="display:;">
	<ul class="cnb3 clear"-->
<div class="surfarea">
<?if($areaview == "eventview"){?>
	<ul class="surfbtn2 clear">
		<!--li><a href="/surfeast">양양</a></li>
		<li><a href="/surfeast3">동해,강릉</a></li-->
		<!--li><a href="/surfeast2">고성</a></li>
		<li><a href="/surfjeju">제주</a></li>
		<li><a href="/surfsouth">부산</a></li>
		<li><a href="/surfwest">서해</a></li-->
<?}else{?>
	<ul class="surfbtn clear">
		<li class="on2"><a href="javascript:fnAreaView(this);"><?=$areaname?> <i class="filter-icon filter-icon__arrow_bottom"></i></a></li>
<?
$select_query = 'SELECT * FROM SURF_CODE where gubun = "'.$param.'" AND codeUseYN = "Y" ORDER BY ordernum';
$result_setlist = mysqli_query($conn, $select_query);

	$i = 0;
	while ($row = mysqli_fetch_assoc($result_setlist)){
		// || ($i == 0 && $area == "")
?>
		<li area="<?=$row["seq"]?>" class="<?=(($area == $row["seq"] || ($i == 0 && $area == "")) ? 'on3' : '')?>"><a href="/<?=$param?>?area=<?=$row["seq"]?>"><?=$row["codename"]?></a></li>
<?
	$i++;
	}
}?>
	</ul>
</div>
<div class="" style="width:100%;display:;">
	<h1 class="ngeb clear"></h1>
</div>
<?}?>

