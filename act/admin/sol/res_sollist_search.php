<?
include __DIR__.'/../../db.php';

$reqDate = $_REQUEST["selDate"];
if($reqDate == ""){
    // $selDate = str_replace("-", "", date("Y-m-d"));
    $selDate = date("Y-m-d");
}else{
    $selDate = $reqDate;
}
$arrDate = explode('-', $selDate);

$Year = $arrDate[0];
$Mon = $arrDate[1];
$Day = $arrDate[2];


$select_query = "SELECT *, DAY(b.sdate) AS sDay, DAY(b.edate) AS eDay, DAY(b.resdate) AS resDay, MONTH(b.sdate) AS sMonth, MONTH(b.edate) AS eMonth, MONTH(b.resdate) AS resMonth, DATEDIFF(b.edate, b.sdate) as eDateDiff FROM AT_SOL_RES_MAIN as a INNER JOIN AT_SOL_RES_SUB as b 
                    ON a.resseq = b.resseq 
                    WHERE ((b.sdate <= '$selDate' AND DATE_ADD(b.edate, INTERVAL -1 DAY) >= '$selDate')
                        OR	b.resdate = '$selDate')
                        AND a.res_confirm IN ('대기', '확정')
                        ORDER BY a.resseq, b.ressubseq";
                        //DATE_ADD(b.edate, INTERVAL -1 DAY) >= '2021-01-02'
//echo $select_query;

// $chkResConfirm = $_REQUEST["chkResConfirm"];
// $sDate = $_REQUEST["sDate"];
// $eDate = $_REQUEST["eDate"];
// $schText = trim($_REQUEST["schText"]);
// $shopseq = $_REQUEST["seq"];

// for($i = 0; $i < count($chkResConfirm); $i++){
//     $res_confirm .= $chkResConfirm[$i].',';

//     if($chkResConfirm[$i] == 0){
//         $listText .= "미입금,";
//     }else if($chkResConfirm[$i] == 3){
//         $listText .= "확정,";
//     }else if($chkResConfirm[$i] == 8){
//         $listText .= "입금완료,";
//     }else if($chkResConfirm[$i] == 2){
//         $listText .= "임시확정/취소,";
//         $res_confirm .= '6,';
//     }else if($chkResConfirm[$i] == 6){
//         $listText .= "임시취소,";
//     }
// }
// $res_confirm .= '99';
// if($listText != ""){
//     $listText = substr($listText, 0, strlen($listText) - 1);
// }

// $shopDate = "";
// if($sDate == "" && $eDate == ""){
//     $titleText = "전체";
// }else{
//     if($sDate != "" && $eDate != ""){
//         $shopDate = ' AND (b.res_date BETWEEN CAST("'.$sDate.'" AS DATE) AND CAST("'.$eDate.'" AS DATE))';
//     }else if($sDate != ""){
//         $shopDate = ' AND b.res_date >= CAST("'.$sDate.'" AS DATE)';
//     }else if($eDate != ""){
//         $shopDate = ' AND b.res_date <= CAST("'.$eDate.'" AS DATE)';
//     }
//     $titleText = "[$sDate ~ $eDate]";
// }

// if($schText != ""){
//     $schText = ' AND (a.resnum like "%'.$schText.'%" OR a.user_name like "%'.$schText.'%" OR a.user_tel like "%'.$schText.'%")';
// }

// $select_query = 'SELECT a.user_name, a.user_tel, a.etc, a.user_email, a.memo, b.*, c.optcode, c.stay_day FROM `AT_RES_MAIN` as a INNER JOIN `AT_RES_SUB` as b 
//                     ON a.resnum = b.resnum 
//                 INNER JOIN `AT_PROD_OPT` c
//                     ON b.optseq = c.optseq
//                     WHERE b.seq = '.$shopseq.'
//                         AND b.res_confirm IN ('.$res_confirm.')'.$shopDate.$schText.'
//                         ORDER BY b.resnum, b.ressubseq';


$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count == 0){
?>
 <div class="contentimg bd">
    <div class="gg_first">예약 현황 (<span id="listdate"><?=$selDate?></span>)</div>
    <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;" id="tbSolList">
        <colgroup>
            <col width="9%" />
            <col width="9%" />
            <col width="6%" />
            <col width="*" />
            <col width="4%" />
            <col width="3%" />
            <col width="3%" />
            <col width="3%" />
            <col width="3%" />
            <col width="8%" />
            <col width="3%" />
            <col width="3%" />
            <col width="5%" />
            <col width="5%" />
            <col width="4%" />
            <col width="4%" />
            <col width="8%" />
            <col width="7%" />
        </colgroup>
        <tbody>
            <tr>
                <th rowspan="2">이름</th>
                <th rowspan="2">연락처</th>
                <th rowspan="2">구분</th>
                <th rowspan="2">예약정보</th>
                <th colspan="3">강습</th>
                <th colspan="2">렌탈</th>
                <th colspan="3">숙박&파티</th>
                <th rowspan="2">요청사항</th>
                <th rowspan="2">직원메모</th>
                <th rowspan="2">입실</th>
                <th rowspan="2">상태</th>
                <th rowspan="2">알림톡</th>
                <th rowspan="2">예약업체</th>
            </tr>
            <tr>
                <th>시간</th>
                <th>남</th>
                <th>여</th>
                <th>남</th>
                <th>여</th>
                <th>파티</th>
                <th>남</th>
                <th>여</th>
            </tr>
            <tr>
                <td colspan="18" style="text-align:center;height:50px;">
                    <b>예약된 목록이 없습니다. 달력에서 다른 날짜를 선택하세요.</b>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?
	return;
}
?>

<div class="contentimg bd">
<form name="frmConfirm" id="frmConfirm" autocomplete="off">
    <div class="gg_first">예약 현황 (<span id="listdate"><?=$selDate?></span>)
        <input type="button" name="listtab" class="gg_btn gg_btn_grid large gg_btn_color" style="width:80px; height:20px;" value="전체" onclick="fnListTab('all', this);" />
        <input type="button" name="listtab" class="gg_btn gg_btn_grid large " style="width:80px; height:20px;" value="숙박&바베큐" onclick="fnListTab('stay', this);" />
        <input type="button" name="listtab" class="gg_btn gg_btn_grid large " style="width:80px; height:20px;" value="강습&렌탈" onclick="fnListTab('surf', this);" />
    </div>
    <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:1px;width:100%;" id="tbSolList">
        <colgroup>
            <col width="4%" />
            <col width="9%" />
            <col width="6%" />
            <col width="*" />
            <col width="4%" />
            <col width="3%" />
            <col width="3%" />
            <col width="3%" />
            <col width="3%" />
            <col width="8%" />
            <col width="3%" />
            <col width="3%" />
            <col width="5%" />
            <col width="5%" />
            <col width="3%" />
            <col width="4%" />
            <col width="10%" />
            <col width="7%" />
        </colgroup>
        <tbody>
            <tr>
                <th style="background-color:#336600; color:#efefef;" rowspan="2"></th>
                <th style="background-color:#336600; color:#efefef;" rowspan="2">예약자</th>
                <th style="background-color:#336600; color:#efefef;" rowspan="2">구분</th>
                <th style="background-color:#336600; color:#efefef;" rowspan="2">예약정보</th>
                <th style="background-color:#336600; color:#efefef;" colspan="3">강습</th>
                <th style="background-color:#336600; color:#efefef;" colspan="2">렌탈</th>
                <th style="background-color:#336600; color:#efefef;" colspan="3">숙박&파티</th>
                <th style="background-color:#336600; color:#efefef;" rowspan="2">요청사항</th>
                <th style="background-color:#336600; color:#efefef;" rowspan="2">직원메모</th>
                <th style="background-color:#336600; color:#efefef;" rowspan="2">입실</th>
                <th style="background-color:#336600; color:#efefef;" rowspan="2">상태</th>
                <th style="background-color:#336600; color:#efefef;" rowspan="2">알림톡</th>
                <th style="background-color:#336600; color:#efefef;" rowspan="2">예약업체</th>
            </tr>
            <tr>
                <th style="background-color:#336600; color:#efefef;">시간</th>
                <th style="background-color:#336600; color:#efefef;">남</th>
                <th style="background-color:#336600; color:#efefef;">여</th>
                <th style="background-color:#336600; color:#efefef;">남</th>
                <th style="background-color:#336600; color:#efefef;">여</th>
                <th style="background-color:#336600; color:#efefef;">파티</th>
                <th style="background-color:#336600; color:#efefef;">남</th>
                <th style="background-color:#336600; color:#efefef;">여</th>
            </tr>

<?
$i = 0;

$b = 1;
$c = 0;
$PreSeq = "";
$rowlist = '';
while ($row = mysqli_fetch_assoc($result_setlist)){
    $MainSeq = $row['resseq'];
    if($MainSeq == $PreSeq){
		$b++;
	}else{
        if($c > 0){
            $rowlist .= $b."|";
        }
		$b = 1;
    }
    $c++;

    $PreSeq = $row['resseq'];

	$now = date("Y-m-d");

    $resseq = $row['resseq'];
    $admin_user = $row['admin_user'];
    $res_confirm = $row['res_confirm'];
	$res_kakao = $row['res_kakao'];
	$res_kakao_chk = $row['res_kakao_chk'];
	$res_room_chk = $row['res_room_chk'];
	$res_company = $row['res_company'];
	$user_name = $row['user_name'];
    $user_tel = $row['user_tel'];
    $memo = $row['memo'];
    $memo2 = $row['memo2'];
    $ressubseq = $row['ressubseq'];
    $res_type = $row['res_type'];
    $prod_name = str_replace("솔게스트하우스", "솔게하", $row['prod_name']);
    $sdate = $row['sdate'];
    $edate = $row['edate'];
    $resdate = $row['resdate'];
    $staysex = $row['staysex'];
    $stayM = $row['stayM'];
    $stayroom = $row['stayroom'];
    $staynum = $row['staynum'];
    $restime = $row['restime'];
    $surfM = $row['surfM'];
    $surfW = $row['surfW'];
    $surfrent = $row['surfrent'];
    $surfrentM = $row['surfrentM'];
    $surfrentW = $row['surfrentW'];
    $bbq = $row['bbq'];
    $eDay = $row['eDay'];

    $memoYN = "";
    $memo2YN = "";
    if($memo != ""){
        $memoYN = "있음";
    }

    if($memo2 != ""){
        $memo2YN = "있음";
    }

    $stayText = "";
    $stayInfo = "";
    $bbqText = "";
    $surfText = "";
    $resText = "";
    $stayMText = "";
    $stayWText = "";
    if($row['res_type'] == "stay"){ //숙박&바베큐
        if($prod_name == "N"){
            $res_room_chk = "";
        }else{
            if($row['sMonth'] == $Mon || $row['eMonth'] == $Mon){
                if(!((int)$Day == $eDay)){
                    $resText = "숙박";
                    $stayText = $prod_name." (".str_replace("-", ".", substr($sdate, 5, 10))."~".str_replace("-", ".", substr($edate, 5, 10)).")";

                    if($res_confirm == "확정" || $res_confirm == "대기"){
                        $stayInfo = "stayinfo='$user_name|$user_name|$prod_name|$staysex|$stayroom|$staynum|".$row['eDateDiff']."|$eDay|$resseq|$res_confirm'";
                    }
                }
            }
        }

        if($bbq != "N" && $Day == $row['resDay']){
            $resText .= (($resText == "") ? "" : "/")."파티";
            // $stayText .= (($stayText == "") ? "$bbq" : " / $bbq");
            $bbqText = $bbq;
        }

        // if(($bbq != "N" && $prod_name == "N") || $prod_name != "솔게하"){
        if($staysex == "남"){
            $stayMText = $stayM.(($stayM == "")? "" : "명");
        }else{
            $stayWText = $stayM.(($stayM == "")? "" : "명");
        }
        // }
    }else{ //강습&렌탈
        $res_room_chk = "";
        if($Day == $row['resDay']){
            if($prod_name != "N"){
                $resText = "강습";
                $stayText = str_replace("솔게스트하우스", "솔.동해점", $row['prod_name']);
            }

            if($surfrent != "N"){            
                $resText .= (($resText == "") ? "" : "/")."렌탈";
                $stayText .= (($stayText == "") ? "" : " / ").$surfrent;
            }

            //$surfText .= (($surfText == "") ? "" : " ($resdate)");
        }
    }

    $fontcolor = "";
    if($res_confirm == "대기"){
        $fontcolor = "color:#c0c0c0;";
    }else if($res_confirm == "취소"){
        $fontcolor = "color:#c0c0c0;";
    }else{
        if($row['res_type'] == "stay" && $prod_name != "N" && $prod_name != "솔게하"){
            $fontcolor = "color:#8080ff;";
        }
    }

    

?>
    <tr>
        <td style="cursor:pointer;<?=$fontcolor?>" onclick="fnSolModify(<?=$resseq?>);"><?=$resseq?></td>
        <td style="cursor:pointer;<?=$fontcolor?>" onclick="fnSolModify(<?=$resseq?>);"><b><?=$user_name?><br><?=$user_tel?></b></td>
        <td style="<?=$fontcolor?>"><?=$resText?></td>
        <td style="<?=$fontcolor?>" <?=$stayInfo?>><?=$stayText?></td>
        <td style="<?=$fontcolor?>"><?=($restime == 0) ? "" : $restime?></td>
        <td style="<?=$fontcolor?>"><?=($surfM == 0) ? "" : $surfM."명"?></td>
        <td style="<?=$fontcolor?>"><?=($surfW == 0) ? "" : $surfW."명"?></td>
        <td style="<?=$fontcolor?>"><?=($surfrentM == 0) ? "" : $surfrentM."명"?></td>
        <td style="<?=$fontcolor?>"><?=($surfrentW == 0) ? "" : $surfrentW."명"?></td>
        <td style="<?=$fontcolor?>"><?=$bbqText?></td>
        <td style="<?=$fontcolor?>"><?=$stayMText?></td>
        <td style="<?=$fontcolor?>"><?=$stayWText?></td>
        <td style="<?=$fontcolor?>"><span class="btn_view" seq="10<?=$c?>"><?=$memoYN?></span><span style='display:none;'><b>요청사항</b><br><?=$memo?></td>
        <td style="<?=$fontcolor?>"><span class="btn_view" seq="20<?=$c?>"><?=$memo2YN?></span><span style='display:none;'><b>직원메모</b><br><?=$memo2?></td>
        <td style="<?=$fontcolor?>"><?if($res_room_chk == "Y"){echo "입실";}?></td>
        <td style="<?=$fontcolor?>"><?=$res_confirm?></td>
        <td style="<?=$fontcolor?>"><?if($res_kakao_chk == "Y"){echo "읽음";}?>/<?=$res_kakao?>회
            <?if($res_confirm == "확정"){?>
            <input type="button" class="gg_btn res_btn_color2" style="width:40px; height:22px;" value="발송" onclick="fnKakaoSend(<?=$resseq?>);" />
            <?}?>
        </td>
        <td <?=$fontcolor?>><?=$res_company?></td>
    </tr>
<?
//while end
}
$rowlist .= $b."|";
?>
		</tbody>
    </table>
    <input type="hidden" id="hidrowcnt" value="<?=$rowlist?>" />
</form>
<form name="frmConfirmSel" id="frmConfirmSel" style="display:none;"></form>
</div>

<script type="text/javascript">
$j(document).ready(function(){
	$j(".btn_view[seq]").mouseover(function(e){ //조회 버튼 마우스 오버시
		var seq = $j(this).attr("seq");
		var obj = $j(".btn_view[seq="+seq+"]");
		var tX = (obj.position().left)-354; //조회 버튼의 X 위치 - 레이어팝업의 크기만 큼 빼서 위치 조절
		var tY = (obj.position().top - 20);  //조회 버튼의 Y 위치
		

		if($j(this).find(".box_layer").length > 0){
			if($j(this).find(".box_layer").css("display") == "none"){
				$j(this).find(".box_layer").css({
					"top" : tY
					,"left" : tX
					,"position" : "absolute"
				}).show();
			}
		}else{
				$j(".btn_view[seq="+seq+"]").append('<div class="box_layer"></div>');
				$j(".btn_view[seq="+seq+"]").find(".box_layer").html($j(".btn_view[seq="+seq+"]").next().html());
				$j(".btn_view[seq="+seq+"]").find(".box_layer").css({
					"top" : tY
					,"left" : tX
					,"position" : "absolute"
				}).show();
		}		
	});
	
	$j(".btn_view[seq]").mouseout(function(e){
			$j(this).find(".box_layer").css("display","none");
	});				 
}); 
</script>