<?php
include __DIR__.'/../../surf/surffunc.php';

$hidsearch = $_REQUEST["hidsearch"];

if($hidsearch == ""){ //초기화면 조회
    $select_query = 'SELECT a.user_name, a.user_tel, a.etc, a.user_email, b.* FROM `AT_RES_MAIN` as a INNER JOIN `AT_RES_SUB` as b 
                        ON a.resnum = b.resnum 
                        WHERE b.seq IN (7, 14)
                            AND b.res_confirm IN (0, 1, 8, 4)
                            ORDER BY b.resnum, b.ressubseq';

    $titleText = "전체";
    $listText = "미입금,예약대기,입금완료,환불요청";    
}else{
	include __DIR__.'/../../db.php';

    $chkResConfirm = $_REQUEST["chkResConfirm"];
    $chkbusNum = $_REQUEST["chkbusNum"];
    $sDate = $_REQUEST["sDate"];
    $eDate = $_REQUEST["eDate"];
    $schText = trim($_REQUEST["schText"]);
    
    for($b = 0; $b < count($chkResConfirm); $b++){
        $res_confirm .= $chkResConfirm[$b].',';

        if($chkResConfirm[$b] == 0){
            $listText .= "미입금,";
        }else if($chkResConfirm[$b] == 1){
            $listText .= "예약대기,";
        }else if($chkResConfirm[$b] == 3){
            $listText .= "확정,";
        }else if($chkResConfirm[$b] == 8){
            $listText .= "입금완료,";
        }else if($chkResConfirm[$b] == 7){
            $listText .= "취소,";
        }else if($chkResConfirm[$b] == 4){
            $listText .= "환불요청,";
        }else if($chkResConfirm[$b] == 4){
            $listText .= "환불완료,";
        }
    }
    $res_confirm .= '99';
    if($listText != ""){
        $listText = substr($listText, 0, strlen($listText) - 1);
    }

    $inResType = "";
    for($b = 0; $b < count($chkbusNum); $b++){
        $inResType .= '"'.$chkbusNum[$b].'",';
    }
    $inResType .= '"99"';

    $busDate = "";
    if($sDate == "" && $eDate == ""){
        $titleText = "전체";
    }else{
        if($sDate != "" && $eDate != ""){
            $busDate = ' AND (res_date BETWEEN CAST("'.$sDate.'" AS DATE) AND CAST("'.$eDate.'" AS DATE))';
        }else if($sDate != ""){
            $busDate = ' AND res_date >= CAST("'.$sDate.'" AS DATE)';
        }else if($eDate != ""){
            $busDate = ' AND res_date <= CAST("'.$eDate.'" AS DATE)';
        }
        $titleText = "[$sDate ~ $eDate]";
    }

    if($schText != ""){
        $schText = ' AND (a.resnum like "%'.$schText.'%" OR a.user_name like "%'.$schText.'%" OR a.user_tel like "%'.$schText.'%")';
    }

    $select_query = 'SELECT a.user_name, a.user_tel, a.etc, a.user_email, a.memo, b.* FROM `AT_RES_MAIN` as a INNER JOIN `AT_RES_SUB` as b 
                        ON a.resnum = b.resnum 
                        WHERE b.res_confirm IN ('.$res_confirm.')
                            AND res_busnum IN ('.$inResType.')'.$busDate.$schText.' 
                            ORDER BY b.resnum, b.res_date, b.ressubseq';

}

// echo $select_query;
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count == 0){
?>
 <div class="contentimg bd">
 <div class="gg_first"><?=$titleText?> 예약정보</div>
    <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
        <colgroup>
            <col width="8%" />
            <col width="auto" />
            <col width="9%" />
            <col width="9%" />
            <col width="9%" />
            <col width="5%" />
            <col width="14%" />
            <col width="8%" />
            <col width="4%" />
            <col width="6%" />
            <col width="8%" />
            <col width="6%" />
            <col width="5%" />
        </colgroup>
        <tbody>
            <tr>
                <th rowspan="2">예약번호</th>
                <th rowspan="2">행선지명</th>
                <th rowspan="2">이름/연락처</th>
                <th colspan="6">예약항목</th>
                <th rowspan="2">승인처리</th>
                <th rowspan="2">결제금액</th>
                <th rowspan="2">환불금액</th>
                <th rowspan="2">특이사항</th>
            </tr>
            <tr>
                <th>이용일</th>
                <th>행선지</th>
                <th>좌석번호</th>
                <th>정류장</th>
                <th>예약상태</th>
                <th>환불</th>
            </tr>
            <tr>
                <td colspan="13" style="text-align:center;height:50px;">
                    <b>[<?=$listText?>] 건으로 조회된 데이터가 없습니다.</b>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?
	return;
}

$i = 0;
$b = 0;
$c = 0;
$PreMainNumber = "";
$RtnTotalPrice = 0;
$TotalPrice = 0;
$TotalDisPrice = 0;
$res_coupon = "";
$ChangeChk = 0;
$reslist = '';
$reslist1 = '';
$reslistConfirm = "";
$busNum = "";
while ($row = mysqli_fetch_assoc($result_setlist)){
	$now = date("Y-m-d");
	$MainNumber = $row['resnum'];

	if($MainNumber != $PreMainNumber && $c > 0){
        
        $i++;

        $trcolor = "";
        if(($i % 2) == 0){
            $trcolor = "class='selTr2'";
        }
?>
            <tr name="btnTrList" <?=$trcolor?>>
                <td <?=$rowspan?> style="text-align: center;"><?=$PreMainNumber?></td>
                <td <?=$rowspan?> style="text-align: center;"><?=$shopname?></td>
                <td <?=$rowspan?> style="text-align: center;"><?=$user_name?><br>(<?=$user_tel?>)</td>
                <?=$reslist?>
                <td style="text-align: center;" <?=$rowspan?>>
                    <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:60px; height:25px;" value="상태변경" onclick="fnConfirmUpdateList(this, 1, <?=$PreMainNumber?>);" />  
                </td>
                <td <?=$rowspan?>><b style="font-weight:700;color:red;"><?=number_format($TotalDisPrice).'원'?></b>
                    <?if(($TotalPrice-$TotalDisPrice) > 0){?>
                    <br>(할인:<?=number_format($TotalPrice-$TotalDisPrice).'원'?>)
                    <?}?>
                </td>
                <td <?=$rowspan?>>
                    <?if($RtnTotalPrice > 0){?>
                        <b><?=number_format($RtnTotalPrice).'원'?></b>
                    <?}?>
                </td>
                <td style="text-align: center;" <?=$rowspan?>>
                    <?if($etc != ""){?>
                        <span class="btn_view" seq="2<?=$i?>">있음</span><span style='display:none;'><b>특이사항</b><br><?=$etc?></span>
                    <?}?>
                    <br>
                    <?if($res_coupon == "JOABUS"){ echo "[조아]"; }else if($res_coupon == "NAVER"){ echo "[NAVER]"; }else if($res_coupon == "KLOOK"){ echo "[KLOOK]"; }else if($res_coupon != ""){ echo "[할인]"; }?>
                </td>
            </tr>
            <?=$reslist1?>
            <tr id="tr<?=$PreMainNumber?>" style="display:none;">
                <td colspan="4"></td>
                <td>메모</td>
                <td colspan="3"><textarea id="memo" name="memo" rows="3" style="width: 90%; resize:none;"><?=$memo?></textarea></td>
                <td colspan="3"></td>
            </tr>
<?
	}

	if($MainNumber == $PreMainNumber){
		$b++;
	}else{
		$RtnTotalPrice = 0;
        $TotalPrice = 0;
        $TotalDisPrice = 0;
        $res_coupon = "";
		$b = 0;
        $ChangeChk = 0;
		$reslist = '';
		$reslist1 = '';
        $reslistConfirm = "";
        $busNum = "";
    }
    
	$shopname = $row['shopname'];
	$user_name = $row['user_name'];
	$user_tel = $row['user_tel'];
	$PreMainNumber = $row['resnum'];
	$etc = $row['etc'];
    $memo = $row['memo'];
    $res_date = $row['res_date'];

    if($c == 0){
?>
        <div class="contentimg bd">
        <form name="frmConfirm" id="frmConfirm" autocomplete="off">
        <div class="gg_first"><?=$titleText?> 예약정보</div>
            <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
                <colgroup>
                    <col width="8%" />
                    <col width="auto" />
                    <col width="9%" />
                    <col width="9%" />
                    <col width="9%" />
                    <col width="5%" />
                    <col width="14%" />
                    <col width="8%" />
                    <col width="4%" />
                    <col width="6%" />
                    <col width="8%" />
                    <col width="6%" />
                    <col width="5%" />
                </colgroup>
                <tbody>
                    <tr>
                        <th rowspan="2">예약번호</th>
                        <th rowspan="2">행선지명</th>
                        <th rowspan="2">이름/연락처</th>
                        <th colspan="6">예약항목</th>
                        <th rowspan="2">승인처리</th>
                        <th rowspan="2">결제금액</th>
                        <th rowspan="2">환불금액</th>
                        <th rowspan="2">특이사항</th>
                    </tr>
                    <tr>
                        <th>이용일</th>
                        <th>행선지</th>
                        <th>좌석번호</th>
                        <th>정류장</th>
                        <th>예약상태</th>
                        <th>환불</th>
                    </tr>
<?
    }

    $c++;

/*
예약상태
    0 : 미입금
    1 : 예약대기
    2 : 임시확정
    3 : 확정
    4 : 환불요청
    5 : 환불완료
    6 : 임시취소
    7 : 취소
    8 : 입금완료
*/

	$ResColor = "";
	$ResCss = "";
	$datDate = substr($row['res_date'], 0, 10);

    $ResConfirm = $row['res_confirm'];
    $res_coupon = $row['res_coupon'];    
    if($ResConfirm == 0){
        $ResConfirmText = "미입금";
		$TotalPrice += $row['res_price'];
        $TotalDisPrice += $row['res_totalprice'];
        $ChangeChk++;
    }else if($ResConfirm == 1){
        $ResConfirmText = "예약대기";
    }else if($ResConfirm == 2){
        $ResConfirmText = "임시확정";
        $TotalPrice += $row['res_price'];
        $TotalDisPrice += $row['res_totalprice'];
    }else if($ResConfirm == 6){
        $ResConfirmText = "임시취소";
    }else if($ResConfirm == 8){
        $ResConfirmText = "입금완료";
        $TotalPrice += $row['res_price'];
        $TotalDisPrice += $row['res_totalprice'];
        $ChangeChk++;
    }else if($ResConfirm == 3){
        $ResConfirmText = "확정";
        $ResColor = "rescolor3";
        $TotalPrice += $row['res_price'];
        $TotalDisPrice += $row['res_totalprice'];
    }else if($ResConfirm == 4){
        $ResConfirmText = "환불요청";
        $ResColor = "rescolor1";
        $TotalPrice += $row['res_price'];
        $TotalDisPrice += $row['res_totalprice'];
        $RtnTotalPrice += $row['rtn_totalprice'];
    }else if($ResConfirm == 5){
        $ResConfirmText = "환불완료";
        $ResCss = "rescss";
        $TotalPrice += $row['res_price'];
        $TotalDisPrice += $row['res_totalprice'];
        $RtnTotalPrice += $row['rtn_totalprice'];
    }else if($ResConfirm == 7){
        $ResConfirmText = "취소";
        $ResCss = "rescss";
    }

    $str_pos = strpos($reslistConfirm, $ResConfirmText);
    if($str_pos === false)
    {
        $reslistConfirm .= $ResConfirmText."/";
    }
    

	if ($datDate < date("Y-m-d", strtotime($now." 0 day")))
	{
		$ResCss = "resper";
	}

    
    $ressubseq = $row['ressubseq'];
    
	$RtnPrice = '';
    $RtnBank = '';
    $RtnBankRow = '';
	if($ResConfirm == 4 || $ResConfirm == 5){
		// $RtnPrice = ''.number_format($row['rtn_totalprice']).'원';
		// $RtnBank = '<tr class="'.$ResCss.'" name="btnTrPoint">
		// 				<td style="text-align:center;" colspan="4">'.str_replace('|', '&nbsp ', $row['rtn_bankinfo']).' | 환불액 : '.$RtnPrice.'</td>
        //             </tr>';
        // $RtnBankRow = 'rowspan="2"';

        $RtnPrice = ''.number_format($row['rtn_totalprice']).'원';
		$RtnBank = '<span class="btn_view" seq="3'.$ressubseq.'">계좌</span><span style="display:none;"><b>환불계좌</b><br>'.str_replace('|', '&nbsp ', $row['rtn_bankinfo']).'<br>환불액 : '.$RtnPrice.'</span></td>';
    }

    $busNumText = fnBusNum($row['res_busnum']);
    $busNum .= $busNumText.',';
    
    if($b == 0){
        $reslist = "
                    <td style='text-align:center;'>
                        <input type='hidden' id='MainNumber' name='MainNumber' value='$MainNumber'>
                        <label>
                        <input type='checkbox' id='chkCancel' name='chkCancel[]' value='$ressubseq' style='vertical-align:-3px;' />
                        $res_date
                        </label>
                    </td>
                    <td style='text-align:center;'>".$busNumText."</td>
                    <td style='text-align:center;'>".$row['res_seat']."번</td>
                    <td style='text-align:center;'><span style='cursor:pointer;text-decoration: underline;' onclick='fnModifyInfo(\"bus\", $ressubseq, 1);'>".$row["res_spointname"]." -> ".$row["res_epointname"]."</span></td>
                    <td style='text-align:center;'>";

            $ResConfirm0 = '';
            $ResConfirm1 = '';
            $ResConfirm3 = '';
            $ResConfirm4 = '';
            $ResConfirm5 = '';
            $ResConfirm7 = '';
            $ResConfirm8 = '';

        /*
        예약상태
            0 : 미입금
            1 : 예약대기
            2 : 임시확정
            3 : 확정
            4 : 환불요청
            5 : 환불완료
            6 : 임시취소
            7 : 취소
            8 : 입금완료
        */

        if($ResConfirm == 0) $ResConfirm0 = 'selected';
        if($ResConfirm == 1) $ResConfirm1 = 'selected';
        if($ResConfirm == 3) $ResConfirm3 = 'selected';
        if($ResConfirm == 4) $ResConfirm4 = 'selected';
        if($ResConfirm == 5) $ResConfirm5 = 'selected';
        if($ResConfirm == 7) $ResConfirm7 = 'selected';
        if($ResConfirm == 8) $ResConfirm8 = 'selected';
        $reslist .= "
                        <select id='selConfirm' name='selConfirm[]' class='select' style='padding:1px 2px 4px 2px;' onchange='fnChangeModify(this, $ResConfirm);'>
                            <option value='0' ".$ResConfirm0.">미입금</option>
                            <option value='1' ".$ResConfirm1.">예약대기</option>
                            <option value='3' ".$ResConfirm3.">확정</option>
                            <option value='4' ".$ResConfirm4.">환불요청</option>
                            <option value='5' ".$ResConfirm5.">환불완료</option>
                            <option value='7' ".$ResConfirm7.">취소</option>
                            <option value='8' ".$ResConfirm8.">입금완료</option>
                        </select>";
        $reslist .= "
                    </td>
                    <td style='text-align:center;'>$RtnBank</td>";
    }else{
        $trcolor = "";
        if(($i % 2) == 1 && $i > 0){
            $trcolor = "class='selTr2'";
        }

        $reslist1 .= "
                        <tr name='btnTrList' $trcolor>
                            <td style='text-align:center;'>
                                <input type='hidden' id='MainNumber' name='MainNumber' value='$MainNumber'>
                                <label>
                                <input type='checkbox' id='chkCancel' name='chkCancel[]' value='$ressubseq' style='vertical-align:-3px;' />
                                $res_date
                                </label>
                            </td>
                            <td style='text-align:center;'>".$busNumText."</td>
                            <td style='text-align:center;'>".$row['res_seat']."번</td>
                            <td style='text-align:center;'><span style='cursor:pointer;text-decoration: underline;' onclick='fnModifyInfo(\"bus\", $ressubseq, 1);'>".$row["res_spointname"]." -> ".$row["res_epointname"]."</span></td>
                            <td style='text-align:center;'>";

            $ResConfirm0 = '';
            $ResConfirm1 = '';
            $ResConfirm3 = '';
            $ResConfirm4 = '';
            $ResConfirm5 = '';
            $ResConfirm7 = '';
            $ResConfirm8 = '';

        /*
        예약상태
            0 : 미입금
            1 : 예약대기
            2 : 임시확정
            3 : 확정
            4 : 환불요청
            5 : 환불완료
            6 : 임시취소
            7 : 취소
            8 : 입금완료
        */

        if($ResConfirm == 0) $ResConfirm0 = 'selected';
        if($ResConfirm == 1) $ResConfirm1 = 'selected';
        if($ResConfirm == 3) $ResConfirm3 = 'selected';
        if($ResConfirm == 4) $ResConfirm4 = 'selected';
        if($ResConfirm == 5) $ResConfirm5 = 'selected';
        if($ResConfirm == 7) $ResConfirm7 = 'selected';
        if($ResConfirm == 8) $ResConfirm8 = 'selected';
        $reslist1 .= "
                        <select id='selConfirm' name='selConfirm[]' class='select' style='padding:1px 2px 4px 2px;' onchange='fnChangeModify(this, $ResConfirm);'>
                            <option value='0' ".$ResConfirm0.">미입금</option>
                            <option value='1' ".$ResConfirm1.">예약대기</option>
                            <option value='3' ".$ResConfirm3.">확정</option>
                            <option value='4' ".$ResConfirm4.">환불요청</option>
                            <option value='5' ".$ResConfirm5.">환불완료</option>
                            <option value='7' ".$ResConfirm7.">취소</option>
                            <option value='8' ".$ResConfirm8.">입금완료</option>
                        </select>";
        $reslist1 .= "
                        </td>
                        <td style='text-align:center;'>$RtnBank</td>
                    </tr>";
    }

    $rowspan = "";
    if($b > 0){
        $rowspan = "rowspan='".($b + 1)."'";
    }
//while end
}

$i++;
$trcolor = "";
if(($i % 2) == 0 && $i > 0){
    $trcolor = "class='selTr2'";
}
?>

            <tr name="btnTrList" <?=$trcolor?>>
                <td <?=$rowspan?> style="text-align: center;"><?=$PreMainNumber?></td>
                <td <?=$rowspan?> style="text-align: center;"><?=$shopname?></td>
                <td <?=$rowspan?> style="text-align: center;"><?=$user_name?><br>(<?=$user_tel?>)</td>
                <?=$reslist?>
                <td style="text-align: center;" <?=$rowspan?>>
                    <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:60px; height:25px;" value="상태변경" onclick="fnConfirmUpdateList(this, 1, <?=$PreMainNumber?>);" />  
                </td>
                <td <?=$rowspan?>><b style="font-weight:700;color:red;"><?=number_format($TotalDisPrice).'원'?></b>
                    <?if(($TotalPrice-$TotalDisPrice) > 0){?>
                    <br>(할인:<?=number_format($TotalPrice-$TotalDisPrice).'원'?>)
                    <?}?>
                </td>
                <td <?=$rowspan?>>
                    <?if($RtnTotalPrice > 0){?>
                        <b><?=number_format($RtnTotalPrice).'원'?></b>
                    <?}?>
                </td>
                <td style="text-align: center;" <?=$rowspan?>>
                    <?if($etc != ""){?>
                        <span class="btn_view" seq="2<?=$i?>">있음</span><span style='display:none;'><b>특이사항</b><br><?=$etc?></span>
                    <?}?>
                    <br>
                    <?if($res_coupon == "JOABUS"){ echo "[조아]"; }else if($res_coupon == "NAVER"){ echo "[NAVER]"; }else if($res_coupon == "KLOOK"){ echo "[KLOOK]"; }else if($res_coupon != ""){ echo "[할인]"; }?>
                </td>
            </tr>
            <?=$reslist1?>
            <tr id="tr<?=$PreMainNumber?>" style="display:none;">
                <td colspan="4"></td>
                <td>취소사유를 작성해주세요~</td>
                <td colspan="3"><textarea id="memo" name="memo" rows="3" style="width: 90%; resize:none;"><?=$memo?></textarea></td>
                <td colspan="3"></td>
            </tr>
		</tbody>
	</table>
	<span id="hidInitParam" style="display:none;">
		<input type="hidden" id="resparam" name="resparam" size="10" value="changeConfirm" class="itx">
		<input type="hidden" id="userid" name="userid" size="10" value="admin" class="itx">
		<input type="hidden" id="changeConfirm" name="changeConfirm" size="10" value="1" class="itx">
	</span>
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