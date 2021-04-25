<? include __DIR__.'/../db.php'; ?>

<?php 
include __DIR__.'/../surf/surffunc.php';

$resseq = $_REQUEST["seq"];
if($resseq == ""){
    echo "<script>alert('예약된 정보가 없습니다.');location.href='https://actrip.co.kr';</script>";
    return;
}
$resseq = trim(decrypt($resseq));

$select_query = "SELECT * FROM AT_SOL_RES_MAIN as a INNER JOIN AT_SOL_RES_SUB as b 
                    ON a.resseq = b.resseq 
                    WHERE a.resseq = $resseq
                        ORDER BY b.ressubseq";
$result = mysqli_query($conn, $select_query);
$count_sub = mysqli_num_rows($result);
if($count_sub == 0){
    echo "<script>alert('예약된 정보가 없습니다.');location.href='https://actrip.co.kr';</script>";
    return;
}else{

    $i = 0;
    while ($row = mysqli_fetch_assoc($result)){
        if($i == 0){
            $user_name = $row["user_name"];
        }
        $i++;

        $res_type = $row["res_type"];
        $prod_name = $row["prod_name"];

        $bbq = $row["bbq"];
        $surfrent = $row["surfrent"];

        $prod_name = $row["prod_name"];
        $prod_name = $row["prod_name"];
        $prod_name = $row["prod_name"];

        if($res_type == "stay"){ //숙박&바베큐
            if($prod_name != "N"){ //숙소 신청
                $staytext = "숙소,";
                
            }

            if($bbq != "N"){ //바베큐 신청
                $bbqtext = "바베큐,";
            }
        }else{ //강습&렌탈
            if($prod_name != "N"){ //강습 신청
                $surftext = "서핑강습,";
            }
            if($surfrent != "N"){ //렌탈 신청
                $renttext = "장비렌탈,";
            }
        }
    }

    $resText = $staytext.$bbqtext.$surftext.$renttext;
    $resText = substr($resText, 0, strlen($resText) - 1);
}
?>

<script>
$j(document).ready(function(){
});
</script>


<div id="wrap">
    <? include __DIR__.'/../_layout_top.php'; ?>

    <link rel="stylesheet" href="../css/surfview.css">

    <div class="top_area_zone">
        <section class="shoptitle">
            <div style="padding:6px;">
                <h1>솔.동해서핑점 예약안내</h1>
                <a class="reviewlink">
                    <span class="reviewcnt">[<?=$user_name?>] 님 예약상세 안내입니다.</span>
                </a>
                <div class="shopsubtitle"><?=$resText?></div>
            </div>
        </section>

        <section class="notice">
            <div class="vip-tabwrap">
                <div id="tabnavi" class="fixed1" style="top: 49px;">
                    <div class="vip-tabnavi">
                        <ul>
                            <li class="on" onclick="fnResViewBus(true, '#content_tab1', 70, this);"><a>상세설명</a></li>
                            <!-- <li onclick="fnResViewBus(false, '#view_tab2', 70, this);"><a>서핑강습 안내</a></li>
                            <li onclick="fnResViewBus(false, '#view_tab3', 70, this);"><a>숙소 안내</a></li>
                            <li onclick="fnResViewBus(false, '#view_tab4', 70, this);"><a>바베큐안내</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <div id="view_tab1">
                <div class="contentimg">
                    <img src="https://actrip.co.kr/act/images/sol_kakao/sol_01.jpg" class="placeholder">
                    <img src="https://actrip.co.kr/act/images/sol_kakao/sol_surf_02.jpg?v=1" class="placeholder">
                    <img src="https://actrip.co.kr/act/images/sol_kakao/sol_surf_03.jpg" class="placeholder">
                    <img src="https://actrip.co.kr/act/images/sol_kakao/sol_surf_04.jpg" class="placeholder">
                    <img src="https://actrip.co.kr/act/images/sol_kakao/sol_surf_05.jpg" class="placeholder">
                    <img src="https://actrip.co.kr/act/images/sol_kakao/sol_surf_06.jpg" class="placeholder">
                    <img src="https://actrip.co.kr/act/images/sol_kakao/sol_02.jpg" class="placeholder">
                </div>
               
            </div>
            <div id="view_tab2" style="display: none;min-height: 800px;">

            </div>
            <div id="view_tab3" style="min-height: 800px;display:none;">

            </div>
            <div id="view_tab4" style="min-height: 800px;display:none;">

            </div>

            <div style="padding:10px 0 5px 0;font-size:12px;">
                <a href="http://pf.kakao.com/_HxmtMxl" target="_blank" rel="noopener"><img src="../images/kakaochat.jpg" class="placeholder"></a>
            </div>
        </section>
    </div>
</div>

<? include __DIR__.'/../_layout_bottom.php'; ?>

<script src="../js/surfview.js"></script>