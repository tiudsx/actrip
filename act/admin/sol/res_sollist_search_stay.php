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
                        AND b.res_type = 'stay'
                        AND a.res_confirm = '확정'
                        ORDER BY ressubseq";
//echo $select_query;
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);
?>

<div class="contentimg bd">
<form name="frmConfirm" id="frmConfirm" autocomplete="off">
    <div class="gg_first">예약 현황 (<span id="listdate"><?=$selDate?></span>)
        <input type="button" name="listtab" class="gg_btn gg_btn_grid large" style="width:80px; height:20px;" value="전체" onclick="fnListTab('all', this);" />
        <input type="button" name="listtab" class="gg_btn gg_btn_grid large gg_btn_color" style="width:80px; height:20px;" value="숙박&바베큐" onclick="fnListTab('stay', this);" />
        <input type="button" name="listtab" class="gg_btn gg_btn_grid large" style="width:80px; height:20px;" value="강습&렌탈" onclick="fnListTab('surf', this);" />
    </div>
<?
$stayinfo = "";
$staybbqinfo = "";
$staypubinfo = "";
while ($row = mysqli_fetch_assoc($result_setlist)){
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
    $prod_name = $row['prod_name'];
    $sdate = $row['sdate'];
    $edate = $row['edate'];
    $resdate = $row['resdate'];
    $staysex = $row['staysex'];
    $stayM = $row['stayM'];
    $stayroom = $row['stayroom'];
    $staynum = $row['staynum'];
    $bbq = $row['bbq'];

    $memoYN = "";
    if($memo != "" || $memo2 != ""){
        $memoYN = "O";
    }

    $stayMText = "";
    $stayWText = "";
    if($staysex == "남"){
        $stayMText = $stayM.(($stayM == "")? "" : "명");
    }else{
        $stayWText = $stayM.(($stayM == "")? "" : "명");
    }
    
    $fontcolor = "";
    if($prod_name != "N" && $prod_name != "솔게스트하우스"){
        $fontcolor = "color:#8080ff;";
    }

    if($prod_name != "N"){
        if($staynum != ""){
            $staynum = $staynum."번 (".((($staynum % 2) == 0) ? "2층" : "1층").")";
        }

        if($row['sMonth'] == $Mon || $row['eMonth'] == $Mon){
            $staylist_text = "
                <tr onmouseover=\"this.style.background='#ff9';\" onmouseout=\"this.style.background='#fff';\">
                    <td style='cursor:pointer;$fontcolor' onclick='fnSolModify($resseq);'>$user_name</td>
                    <td style='cursor:pointer;$fontcolor' onclick='fnSolModify($resseq);'>$user_tel</td>
                    <td style='$fontcolor'>$prod_name</td>
                    <td style='$fontcolor'>".str_replace("-", ".", substr($sdate, 5, 10))."~".str_replace("-", ".", substr($edate, 5, 10))."</td>
                    <td style='$fontcolor'>".(($stayroom == "") ? "" : $stayroom."호")."</td>
                    <td style='$fontcolor'>$staynum</td>
                    <td style='$fontcolor'>$stayMText</td>
                    <td style='$fontcolor'>$stayWText</td>
                    <td style='$fontcolor'>$memoYN</td>
                </tr>
            ";

            $stayinfo .= $staylist_text;

            if($staysex == "남"){
                $stayMCnt += $stayM;
            }else{
                $stayWCnt += $stayM;
            }
        }
    }

    if($bbq != "N" && $Day == $row['resDay']){
        $staylist_text = "
            <tr onmouseover=\"this.style.background='#ff9';\" onmouseout=\"this.style.background='#fff';\">
                <td style='cursor:pointer;$fontcolor' onclick='fnSolModify($resseq);'>$user_name</td>
                <td style='cursor:pointer;$fontcolor' onclick='fnSolModify($resseq);'>$user_tel</td>
                <td style='$fontcolor'>$stayMText</td>
                <td style='$fontcolor'>$stayWText</td>
                <td style='$fontcolor'>$memoYN</td>
            </tr>
        ";
        if($bbq == "바베큐"){
            $staybbqinfo .= $staylist_text;
        }else if($bbq == "펍파티"){
            $staypubinfo .= $staylist_text;
        }else{
            $staybbqinfo .= $staylist_text;
            $staypubinfo .= $staylist_text;
        }

        if($staysex == "남"){
            if($bbq == "바베큐"){
                $bbqMCnt += $stayM;
            }else if($bbq == "펍파티"){
                $pubMCnt += $stayM;
            }else{
                $bbqMCnt += $stayM;
                $pubMCnt += $stayM;
            }
        }else{
            if($bbq == "바베큐"){
                $bbqWCnt += $stayM;
            }else if($bbq == "펍파티"){
                $pubWCnt += $stayM;
            }else{
                $bbqWCnt += $stayM;
                $pubWCnt += $stayM;
            }
        }
    }
//while end
}
?>
<table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:1px;width:100%;">
    <colgroup>
        <col width="*" />
        <col width="24%" />
        <col width="24%" />
    </colgroup>
    <tbody>
        <tr>
            <th>숙소 정보</th>
            <th>바베큐파티</th>
            <th>펍파티</th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:1px;width:100%;">
                    <colgroup>
                        <col width="13%" />
                        <col width="18%" />
                        <col width="*" />
                        <col width="14%" />
                        <col width="8%" />
                        <col width="11%" />
                        <col width="7%" />
                        <col width="7%" />
                        <col width="7%" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>이름</th>
                            <th>연락처</th>
                            <th>숙소명</th>
                            <th>이용기간</th>
                            <th>호실</th>
                            <th>침대</th>
                            <th>남</th>
                            <th>여</th>
                            <th>메모</th>
                        </tr>
                        <?=$stayinfo?>
                        <tr>
                            <th colspan="2">총 인원</th>
                            <td></td>
                            <td></td>
                            <td></td>        
                            <td></td>                    
                            <td><?=($stayMCnt == 0) ? "" : $stayMCnt."명"?></td>
                            <td><?=($stayWCnt == 0) ? "" : $stayWCnt."명"?></td>
                            <td><?=($stayMCnt+$stayWCnt == 0) ? "" : $stayMCnt+$stayWCnt."명"?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="vertical-align: top;">
                <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:1px;width:100%;<?if($staybbqinfo == ""){ echo "display:none;"; }?>">
                    <colgroup>
                        <col width="*" />
                        <col width="36%" />
                        <col width="13%" />
                        <col width="13%" />
                        <col width="13%" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>이름</th>
                            <th>연락처</th>
                            <th>남</th>
                            <th>여</th>
                            <th>메모</th>
                        </tr>
                        <?=$staybbqinfo?>
                        <tr>
                            <th colspan="2">총 인원</th>
                            <td><?=($bbqMCnt == 0) ? "" : $bbqMCnt."명"?></td>
                            <td><?=($bbqWCnt == 0) ? "" : $bbqWCnt."명"?></td>
                            <td><?=($bbqMCnt+$bbqWCnt == 0) ? "" : $bbqMCnt+$bbqWCnt."명"?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="vertical-align: top;">
                <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:1px;width:100%;<?if($staypubinfo == ""){ echo "display:none;"; }?>">
                    <colgroup>
                        <col width="*" />
                        <col width="36%" />
                        <col width="13%" />
                        <col width="13%" />
                        <col width="13%" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>이름</th>
                            <th>연락처</th>
                            <th>남</th>
                            <th>여</th>
                            <th>메모</th>
                        </tr>
                        <?=$staypubinfo?>
                        <tr>
                            <th colspan="2">총 인원</th>
                            <td><?=($pubMCnt == 0) ? "" : $pubMCnt."명"?></td>
                            <td><?=($pubWCnt == 0) ? "" : $surfWCnt_sol_13."명"?></td>
                            <td><?=($pubMCnt+$pubWCnt == 0) ? "" : $pubMCnt+$pubWCnt."명"?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>