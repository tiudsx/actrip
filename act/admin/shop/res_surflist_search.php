<?
$reqDate = $_REQUEST["selDate"];
if($reqDate == ""){
    $selDate = str_replace("-", "", date("Y-m-d"));
}else{
	include __DIR__.'/../../db.php';
    $shopseq = $_REQUEST["seq"];
    $selDate = $reqDate;
}
$Year = substr($selDate,0,4);
$Mon = substr($selDate,4,2);

if($_REQUEST["chkResConfirm"] == ""){
    $res_confirm = "8";
}else{
	include __DIR__.'/../../db.php';
    $res_confirm = "";
    
    $chkResConfirm = $_REQUEST["chkResConfirm"];
    $sDate = $_REQUEST["sDate"];
    $eDate = $_REQUEST["eDate"];
    $schText = trim($_REQUEST["schText"]);
    $shopseq = $_REQUEST["seq"];
    
    for($i = 0; $i < count($chkResConfirm); $i++){
        $res_confirm .= $chkResConfirm[$i].',';
    }
    $res_confirm .= '99';
}

if($sDate == ""){
    $select_query = 'SELECT a.user_name, a.user_tel, a.etc, a.user_email, a.memo, b.*, c.optcode, c.stay_day FROM `AT_RES_MAIN` as a INNER JOIN `AT_RES_SUB` as b 
                        ON a.resnum = b.resnum 
                    INNER JOIN `AT_PROD_OPT` c
                        ON b.optseq = c.optseq
                        WHERE Month(b.res_date) = '.$Mon.'
                            AND b.seq = '.$shopseq.'
                            AND b.res_confirm IN ('.$res_confirm.')
                            ORDER BY b.resnum, b.ressubseq';
}else{
    if($schText != ""){
        $schText = ' AND (a.resnum like "%'.$schText.'%" OR a.user_name like "%'.$schText.'%" OR a.user_tel like "%'.$schText.'%")';
    }
    $select_query = 'SELECT a.user_name, a.user_tel, a.etc, a.user_email, a.memo, b.*, c.optcode, c.stay_day FROM `AT_RES_MAIN` as a INNER JOIN `AT_RES_SUB` as b 
                        ON a.resnum = b.resnum 
                    INNER JOIN `AT_PROD_OPT` c
                        ON b.optseq = c.optseq
                        WHERE b.seq = '.$shopseq.'
                            AND b.res_confirm IN ('.$res_confirm.')
                            AND (b.res_date BETWEEN CAST("'.$sDate.'" AS DATE) AND CAST("'.$eDate.'" AS DATE))'.$schText.'
                            ORDER BY b.resnum, b.ressubseq';
}

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count == 0){
    $select_query = "SELECT * FROM AT_PROD_MAIN WHERE seq = $shopseq AND use_yn = 'Y'";
    $result = mysqli_query($conn, $select_query);
    $rowMain = mysqli_fetch_array($result);

?>
 <div class="contentimg bd">
    <div class="gg_first"><?=$Mon?>월 예약목록</div>
    <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
        <colgroup>
            <col width="auto" />
            <col width="22%" />
            <col width="16%" />
            <col width="16%" />
            <col width="16%" />
        </colgroup>
        <tbody>
            <tr>
                <th>예약번호</th>
                <th>이용일</th>
                <th>이름</th>
                <th>승인여부</th>
                <th>특이사항</th>
            </tr>
            <tr>
                <td colspan="5" style="text-align:center;height:50px;">
                <b>예약된 목록이 없습니다. 달력 월을 변경해보세요.</b>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?
	return;
}

$b = 0;
$c = 0;
$PreMainNumber = "";
$TotalPrice = 0;
$ChangeChk = 0;
$reslist = '';
while ($row = mysqli_fetch_assoc($result_setlist)){
	$now = date("Y-m-d");
	$MainNumber = $row['resnum'];

	if($MainNumber != $PreMainNumber && $c > 0){
    ?>

            <tr name="btnTrList" style="text-align:center;cursor:pointer;" onclick="fnListViewKakao(this);">
                <td style="text-align: center;"><?=$PreMainNumber?></td>
                <td style="text-align: center;"><?=$res_date?></td>
                <td style="text-align: center;"><?=$user_name?></td>
                <td style="text-align: center;"><?if($ChangeChk > 0){ echo "승인필요"; }else{ echo "O"; }?></td>
                <td style="text-align: center;"><?if($etc != ""){ echo "있음"; }?></td>
            </tr>
            <tr id="<?=$PreMainNumber?>" style="display:none;">
                <td colspan="5">

                    <table class="et_vars exForm bd_tb" style="width:100%">
                        <colgroup>
                            <col style="width:80px;">
                            <col style="width:auto;">
                            <col style="width:70px;">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th style="text-align:center;">이용일</th>
                                <th style="text-align:center;">예약항목</th>
                                <th style="text-align:center;">상태</th>
                            </tr>
                            <?=$reslist?>
                        </tbody>
                    </table>
                    <table class="et_vars exForm bd_tb" style="width:100%">
                        <colgroup>
                            <col style="width:80px;">
                            <col style="width:auto;">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>연락처</th>
                                <td style="text-align:left;"><b><?=$user_tel?></b></td>
                            </tr>
                        <?if($TotalPrice > 0){?>
                            <tr>
                                <th>결제금액</th>
                                <td style="text-align:left;"><b><?=number_format($TotalPrice).'원'?></b></td>
                            </tr>
                        <?}?>
                        <?if($etc != ""){?>
                            <tr>
                                <th>특이사항</th>
                                <td><textarea id="etc" name="etc" rows="5" style="width: 90%; resize:none;" disabled="disabled"><?=$etc?></textarea></td>
                            </tr>
                        <?}?>
                        <?if($ChangeChk == 0 && $memo != ""){?>
                            <tr>
                                <th>사유 및<br>메모</th>
                                <td>
                                    <textarea id="memo" name="memo" rows="3" style="width: 90%; resize:none;" <?if($ChangeChk == 0){ echo 'disabled="disabled"';}?>><?=$memo?></textarea>
                                </td>
                            </tr>
                        <?}?>
                        </tbody>
                    </table>
                    <?if($ChangeChk > 0){?>
                    <div class="write_table" style="padding-bottom:15px;text-align:center;">
                        <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:90px; height:30px;" value="상태변경하기" onclick="fnConfirmUpdate(this, 2);" />
                    </div>
                    <?}?>
                </td>
            </tr>

    <?
	}

	if($MainNumber == $PreMainNumber){
		$b++;
	}else{
		$b = 0;
        $TotalPrice = 0;
        $ChangeChk = 0;
		$reslist = '';
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
<div class="gg_first"><?=$Mon?>월 예약목록</div>
    <table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
		<colgroup>
			<col width="auto" />
			<col width="22%" />
			<col width="16%" />
			<col width="16%" />
			<col width="16%" />
		</colgroup>
        <tbody>
            <tr>
                <th>예약번호</th>
                <th>이용일</th>
                <th>이름</th>
                <th>승인여부</th>
                <th>특이사항</th>
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
    if($ResConfirm == 0){
        $ResConfirmText = "미입금";
        $ChangeChk++;
    }else if($ResConfirm == 1){
        $ResConfirmText = "예약대기";
    }else if($ResConfirm == 2){
        $ResConfirmText = "임시확정";
        $TotalPrice += $row['res_price'];
    }else if($ResConfirm == 6){
        $ResConfirmText = "임시취소";
    }else if($ResConfirm == 8){
        $ResConfirmText = "입금완료";
        $TotalPrice += $row['res_price'];
        $ChangeChk++;
    }else if($ResConfirm == 3){
        $ResConfirmText = "확정";
        $ResColor = "rescolor3";
        $TotalPrice += $row['res_price'];
    }else if($ResConfirm == 4){
        $ResConfirmText = "환불요청";
        $ResColor = "rescolor1";
    }else if($ResConfirm == 5){
        $ResConfirmText = "환불완료";
        $ResCss = "rescss";
    }else if($ResConfirm == 7){
        $ResConfirmText = "취소";
        $ResCss = "rescss";
    }

    if ($datDate < date("Y-m-d", strtotime($now." 0 day")))
    {
        $ResCss = "predate";
    }

    $TimeDate = "";
    if(($row['sub_title'] == "lesson" || $row['sub_title'] == "pkg") && $row['res_time'] != ""){
        $TimeDate = '강습시간 : '.$row['res_time'];
    }

    $ResNum = "";
    if($row['res_m'] > 0){
        $ResNum = "남:".$row['res_m']."명";
    }
    if($row['res_m'] > 0 && $row['res_w'] > 0){
        $ResNum .= ",";
    }
    if($row['res_w'] > 0){
        $ResNum .= "여:".$row['res_w']."명";
    }

    $ResOptInfo = "";
    $optinfo = $row['optsubname'];
    if($row['sub_title'] == "lesson"){
        $arrdate = explode("-", $row['res_date']); // 들어온 날짜를 년,월,일로 분할해 변수로 저장합니다.
        $s_Y=$arrdate[0]; // 지정된 년도 
        $s_m=$arrdate[1]; // 지정된 월
        $s_d=$arrdate[2]; // 지정된 요일

        $stayPlus = $row['stay_day']; //숙박 여부
        //이전일 요일구하기
        $preDate = date("Y-m-d", strtotime(date("Y-m-d",mktime(0,0,0,$s_m,$s_d,$s_Y))." -1 day"));
        $nextDate = date("Y-m-d", strtotime(date("Y-m-d",mktime(0,0,0,$s_m,$s_d,$s_Y))." +1 day"));
        if($stayPlus == 0){
            $ResOptInfo = "숙박일 : ".$row['res_date']."(1박)";
        }else if($stayPlus == 1){
            $ResOptInfo = "숙박일 : $preDate(1박)";
        }else if($stayPlus == 2){
            $ResOptInfo = "숙박일 : $preDate(2박)";
        }else{
            // $ResOptInfo = "안내 : $optinfo";
        }
    }else if($row['sub_title'] == "rent"){

    }else if($row['sub_title'] == "pkg"){
        // $ResOptInfo = $optinfo.$TimeDate;
        $ResOptInfo = $optinfo;
    }else if($row['sub_title'] == "bbq"){
        //$ResOptInfo = str_replace('<br>', '', $optinfo);
        //$ResOptInfo = $optinfo;
    }

    $ressubseq = $row['ressubseq'];
    $optname = $row['optname'];
$reslist .= "
           <tr>
                <td style='text-align:center;'>
                    <input type='hidden' id='MainNumber' name='MainNumber' value='$MainNumber'>
					<label>
					<input type='checkbox' id='chkCancel' name='chkCancel[]' value='$ressubseq' style='vertical-align:-3px;display:none;' />
					$res_date
					</label>
				</td>
                <td>
                    $optname<br>
					<span class='resoption'>$TimeDate ($ResNum)</span>
					<span class='resoption'>$ResOptInfo</span>
				</td>
                <td style='text-align:center;'>";                
                    if($ResConfirm == 8 || $ResConfirm == 0){
$reslist .= "
                        <select id='selConfirm' name='selConfirm[]' class='select' style='padding:1px 2px 4px 2px;' onchange='fnChangeModify(this, $ResConfirm);'>
                            <option value='$ResConfirm'>승인처리</option>
                            <option value='3'>확정</option>
                            <option value='6'>취소</option>
                        </select>";
                    }else{
$reslist .= $ResConfirmText;
                    }
$reslist .= "
                </td>
			</tr>";
//while end
}
?>


            <tr name="btnTrList" style="text-align:center;cursor:pointer;" onclick="fnListViewKakao(this);">
                <td style="text-align: center;"><?=$PreMainNumber?></td>
                <td style="text-align: center;"><?=$res_date?></td>
                <td style="text-align: center;"><?=$user_name?></td>
                <td style="text-align: center;"><?if($ChangeChk > 0){ echo "승인필요"; }else{ echo "O"; }?></td>
                <td style="text-align: center;"><?if($etc != ""){ echo "있음"; }?></td>
            </tr>
            <tr id="<?=$PreMainNumber?>" style="display:none;">
                <td colspan="5">

                    <table class="et_vars exForm bd_tb" style="width:100%">
                        <colgroup>
                            <col style="width:80px;">
                            <col style="width:auto;">
                            <col style="width:70px;">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th style="text-align:center;">이용일</th>
                                <th style="text-align:center;">예약항목</th>
                                <th style="text-align:center;">상태</th>
                            </tr>
                            <?=$reslist?>
                        </tbody>
                    </table>
                    <table class="et_vars exForm bd_tb" style="width:100%">
                        <colgroup>
                            <col style="width:80px;">
                            <col style="width:auto;">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>연락처</th>
                                <td style="text-align:left;"><b><?=$user_tel?></b></td>
                            </tr>
                        <?if($TotalPrice > 0){?>
                            <tr>
                                <th>결제금액</th>
                                <td style="text-align:left;"><b><?=number_format($TotalPrice).'원'?></b></td>
                            </tr>
                        <?}?>
                        <?if($etc != ""){?>
                            <tr>
                                <th>특이사항</th>
                                <td><textarea id="etc" name="etc" rows="5" style="width: 90%; resize:none;" disabled="disabled"><?=$etc?></textarea></td>
                            </tr>
                        <?}?>
                        <?if($ChangeChk == 0 && $memo != ""){?>
                            <tr>
                                <th>사유 및<br>메모</th>
                                <td>
                                    <textarea id="memo" name="memo" rows="3" style="width: 90%; resize:none;" <?if($ChangeChk == 0){ echo 'disabled="disabled"';}?>><?=$memo?></textarea>
                                </td>
                            </tr>
                        <?}?>
                        </tbody>
                    </table>
                    <?if($ChangeChk > 0){?>
                    <div class="write_table" style="padding-bottom:15px;text-align:center;">
                        <input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:90px; height:30px;" value="상태변경하기" onclick="fnConfirmUpdate(this, 2);" />
                    </div>
                    <?}?>
                </td>
            </tr>
		</tbody>
	</table>
	<span id="hidInitParam" style="display:none;">
		<input type="hidden" id="resparam" name="resparam" size="10" value="changeConfirm" class="itx">
		<input type="hidden" id="userid" name="userid" size="10" value="kakaoall" class="itx">
        <input type="hidden" id="shopseq" name="shopseq" value="<?=$shopseq?>">
	</span>
</form>
<form name="frmConfirmSel" id="frmConfirmSel" style="display:none;"></form>

</div>