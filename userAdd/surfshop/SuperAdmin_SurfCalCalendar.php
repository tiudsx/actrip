<?php
session_start();

	$selDate = ($_REQUEST["selDate"] == "") ? str_replace("-", "", date("Y-m-d")) : $_REQUEST["selDate"];
	$selDay = $_REQUEST["selDay"];
    $iDay;
	$iMonLastDay;
	$iWeekCnt;
    $Year = substr($selDate,0,4);
	$Mon = substr($selDate,4,2);

	$datDate = date("Y-m-d", mktime(0, 0, 0, $Mon, 1, $Year));
	$NextDate = date("Y-m-d", strtotime($datDate." +1 month"));
	$PreDate = date("Y-m-d", strtotime($datDate." -1 month"));
	$now = date("Y-m-d A h:i:s");

$holidays = array(
	"0101"=> array( "type"=> 0, "title"=> "신정", "year"=> "" ),
	"0301"=> array( "type"=> 0, "title"=> "삼일절", "year"=> "" ),
	"0505"=> array( "type"=> 0, "title"=> "어린이날", "year"=> "" ),
	"0606"=> array( "type"=> 0, "title"=> "현충일", "year"=> "" ),
	"0815"=> array( "type"=> 0, "title"=> "광복절", "year"=> "" ),
	"1003"=> array( "type"=> 0, "title"=> "개천절", "year"=> "" ),
	"1009"=> array( "type"=> 0, "title"=> "한글날", "year"=> "" ),
	"1225"=> array( "type"=> 0, "title"=> "크리스마스", "year"=> "" ),


	"0215"=> array( "type"=> 0, "title"=> "설날", "year"=> "2018" ),
	"0216"=> array( "type"=> 0, "title"=> "설날", "year"=> "2018" ),
	"0217"=> array( "type"=> 0, "title"=> "설날", "year"=> "2018" ),
	"0505"=> array( "type"=> 0, "title"=> "어린이날", "year"=> "2018" ),
	"0507"=> array( "type"=> 0, "title"=> "대체휴일", "year"=> "2018" ),
	"0522"=> array( "type"=> 0, "title"=> "석가탄신일", "year"=> "2018" ),
	//"0613"=> array( "type"=> 0, "title"=> "지방선거", "year"=> "2018" ),
	"0924"=> array( "type"=> 0, "title"=> "추석", "year"=> "2018" ),
	"0925"=> array( "type"=> 0, "title"=> "추석", "year"=> "2018" ),
	"0926"=> array( "type"=> 0, "title"=> "대체휴일", "year"=> "2018" )
);

	$x=explode("-",$datDate); // 들어온 날짜를 년,월,일로 분할해 변수로 저장합니다.
	$s_Y=$x[0]; // 지정된 년도 
	$s_m=$x[1]; // 지정된 월
	$s_d=$x[2]; // 지정된 요일
	
	$nowMonth = date("Ym");
	$selMonth = date("Ym",mktime(0,0,0,$s_m,$s_d,$s_Y));

	$s_t=date("t",mktime(0,0,0,$s_m,$s_d,$s_Y)); // 지정된 달은 몇일까지 있을까요?
	$s_n=date("N",mktime(0,0,0,$s_m,1,$s_Y)); // 지정된 달의 첫날은 무슨요일일까요?
	$l=$s_n%7; // 지정된 달 1일 앞의 공백 숫자.
	$ra=($s_t+$l)/7; $ra=ceil($ra); $ra=$ra-1; // 지정된 달은 총 몇주로 라인을 그어야 하나? 

	$n_d= date("Y-m-d",mktime(0,0,0,$s_m,$s_d+1,$s_Y)); // 다음날
	$p_d= date("Y-m-d",mktime(0,0,0,$s_m,$s_d-1,$s_Y)); // 이전날

	$n_m= date("Ym",mktime(0,0,0,$s_m+1,$s_d,$s_Y)); // 다음달 (빠뜨린 부분 추가분이에요)
	$p_m= date("Ym",mktime(0,0,0,$s_m-1,$s_d,$s_Y)); // 이전달
	$n_Y= date("Y-m-d",mktime(0,0,0,$s_m,$s_d,$s_Y+1)); // 내년
	$p_Y= date("Y-m-d",mktime(0,0,0,$s_m,$s_d,$s_Y-1)); // 작년

	$nowDate = date("Y-m-d");
// 변수 $s 에 새로운 값을 넣고 새문서를 만들면, $s 가 들어와 원하는 값을 표시해 줍니다.

	echo ("
    <div class='tour_calendar_box'>
        <div class='tour_calendar_header'>
	");
	echo "<a href='javascript:fnCalMoveAdminCal2(\"$p_m\", 0);' class='tour_calendar_prev'><span class='cal_ico'></span>이전</a>";
	echo ("
            <a href='javascript:fnCalMoveAdminCal2(\"$n_m\", 0);' class='tour_calendar_next'><span class='cal_ico'></span>다음</a>
            <div class='tour_calendar_title'>
                <span class='tour_calendar_month'>$s_Y.$s_m</span>
            </div>
        </div>
        <table class='tour_calendar' summary='출발일을 선택하는 달력입니다. 달력 선택후 출발 시간 선택 레이어가 활성화 됩니다.'>
            <caption>출발일 선택 달력</caption>
            <thead>
                <tr>
                    <th scope='col'><span>SUN</span></th>
                    <th scope='col'><span>MON</span></th>
                    <th scope='col'><span>TUE</span></th>
                    <th scope='col'><span>WED</span></th>
                    <th scope='col'><span>THU</span></th>
                    <th scope='col'><span>FRI</span></th>
                    <th scope='col'><span>SAT</span></th>
                </tr>
            </thead>
            <tbody>
		");

	include '../db.php';

/*
예약구분
-----------
0	미입금
1	취소
2	예약대기
3	임시확정
4	임시취소
5	확정
6	환불요청
7	환불완료
*/

	$select_query = 'SELECT COUNT(*) AS Cnt, ResDate, DAY(ResDate) AS sDay, a.ResConfirm, SUM(ResPrice) AS price, SUM(RtnPrice) AS RtnPrice, b.shopSeq, c.opt_bbq, c.opt_bbq, c.shopname, max(c.shopcharge) as shopcharge FROM `SURF_SHOP_RES_SUB` as a INNER JOIN `SURF_SHOP_RES_MAIN` as b
						ON a.MainNumber = b.MainNumber
					INNER JOIN SURF_SHOP as c
						ON b.shopSeq = c.intseq							
							WHERE a.DelUse = "N"
								AND a.ResConfirm IN (5, 7)
								AND (Year(ResDate) = '.$Year.' AND Month(ResDate) = '.$Mon.')
								AND ((c.opt_bbq = "Y" AND a.ResGubun IN (0,1,2,3)) OR (c.opt_bbq = "N"))
							GROUP BY b.shopSeq, a.ResDate, a.ResConfirm, c.opt_bbq, c.shopname';
	$result_setlist = mysqli_query($conn, $select_query);
//echo $select_query;
	$arrResCount = array();
	$arrShopPrice = array();
	$arrShopCharge = array();
	$totalPrice = 0;
	$totalRtnPrice = 0;
	while ($row = mysqli_fetch_assoc($result_setlist)){

		if($row['ResConfirm'] == 5){
			$sumPrice = $row['price'];
			$totalPrice += $sumPrice;

			$arrResCount[$row['shopname']][$row['ResConfirm']][$row['sDay']] = $sumPrice;
			$arrShopPrice[$row['shopname']][$row['ResConfirm']] += $row['price'];
			$arrShopCharge[$row['shopname']][$row['ResConfirm']] = ($row['shopcharge'] / 100);
		}else{
			$totalRtnPrice += $row['RtnPrice'];
			$arrResCount[$row['shopname']][$row['ResConfirm']][$row['sDay']] = $row['RtnPrice'];
			$arrShopPrice[$row['shopname']][$row['ResConfirm']] += $row['RtnPrice'];
			$arrShopCharge[$row['shopname']][$row['ResConfirm']] = ($row['shopcharge'] / 100);
		}
		
	}
/*
	foreach  ($arrResCount as $arrKey => $arrVlu){

		foreach ($arrVlu as $arrKey2 => $arrVlu2) { 

			foreach ($arrVlu2 as $arrKey3 => $arrVlu3) { 
				echo $arrKey.'|'.$arrKey2.'|'.$arrKey3.'#'.$arrVlu3.'<br>';
			} 
		} 
	}

	echo '<br><br>';
*/

    for($r=0;$r<=$ra;$r++){
        echo "<tr>";

		for($z=1;$z<=7;$z++){
			$rv=7*$r+$z; $ru=$rv-$l; // 칸에 번호를 매겨줍니다. 1일이 되기전 공백들 부터 마이너스 값으로 채운 뒤 ~ 

			if($ru<=0 || $ru>$s_t){ 
				echo "<td><span class='tour_td_block' style='min-height:48px;'><span class='tour_cal_day'>&nbsp;</span></span></td>";
			}else{
				$s = date("Y-m-d",mktime(0,0,0,$s_m,$ru,$s_Y)); // 현재칸의 날짜
				$h = date("H");
				$weeknum = $z - 1;

				$calMD = explode("-",$s)[1].explode("-",$s)[2];
				$holidayChk = (array_key_exists($calMD, $holidays)) ? " style='color:red;'" : "";
				


				$adminText = "";
				if($arrResCount[2][5][$ru] != ""){
					$adminText .= '<br><font color="black">'.number_format($arrResCount[2][5][$ru])."원</font>";
				}
				
				if($arrResCount[2][3][$ru] != ""){
					//$adminText .= '<br><font color="red"><b>'.$arrResCount[2][3][$ru]."건 환불</b></font>";
				}
				
				if($arrResCount[2][4][$ru] != ""){
					//$adminText .= '<br><font color="black">'.$arrResCount[2][4][$ru]."건 취소</font>";
				}

				$selYN = 'no';
				$selYNbg = '';
				if($selDay == $ru){
					$selYN = 'yes';
					$selYNbg = 'background:#efefef;';
				}
				
				echo "<td class='cal_type2'><calBox sel='$selYN' style='min-height:48px;$selYNbg' class='tour_td_block' value='$s'><span class='tour_cal_day' $holidayChk>$ru</span><span class='tour_cal_pay'>$adminText</span></calBox></td>";
			}
		}

        echo "</tr>";
    }
echo ("
            </tbody>
        </table>
    </div>");

	foreach  ($arrShopPrice as $arrKey => $arrVlu){
		foreach ($arrVlu as $arrKey2 => $arrVlu2) { 
			if($arrKey2 == 5){
				$shopList .= $arrKey.' : '.number_format($arrVlu2).'원 ('.number_format($arrVlu2 * (1 - $arrShopCharge[$arrKey][$arrKey2])).'원 / '.number_format($arrVlu2 * $arrShopCharge[$arrKey][$arrKey2]).'원)<br>';
			}else{
				$shopListRtn .= $arrKey.' : '.number_format($arrVlu2).'원<br>';
			}
		} 
	}
?>

<script>
$j(document).ready(function(){
	var cancelFee = "";
	if(userid == "surfenjoy"){
		cancelFee = "<br><br>총 취소수수료 : <?=number_format($totalRtnPrice)?>원";
		cancelFee += "<br><br>서프엔조이 수수료 : <?=number_format($totalPrice * 0.15)?>원</b>";
	}


	$j("#initText2").html("<b><?=$s_Y.'년 '.$s_m?>월<br><br><?=$shopList?>" + cancelFee);
});
</script>