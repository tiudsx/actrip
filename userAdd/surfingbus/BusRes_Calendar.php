<?php
	//$selDate = ($_REQUEST["selDate"] == "") ? str_replace("-", "", date("Y-m-d")) : $_REQUEST["selDate"];
	$selDate = ($_REQUEST["selDate"] == "") ? "20190501" : $_REQUEST["selDate"];

    $iDay;
	$iMonLastDay;
	$iWeekCnt;
    $Year = substr($selDate,0,4);
	$Mon = substr($selDate,4,2);

	if(($Mon >= 1 && $Mon <= 3)){
		//$Mon = "04";
	}

	$datDate = date("Y-m-d", mktime(0, 0, 0, $Mon, 1, $Year));
	$NextDate = date("Y-m-d", strtotime($datDate." +1 month"));
	$PreDate = date("Y-m-d", strtotime($datDate." -1 month"));
	$now = date("Y-m-d A h:i:s");

//echo $NextDate.$PreDate;



/*$to = "lud1@naver.com";
$subject = "PHP 메일 발송";
$contents = "PHP mail()함수를 이용한 메일 발송 테스트";
$headers = "From: surf@surfenjoy.com\r\n";

mail($to, $subject, $contents, $headers);
*/

$holidays = array(
	"0101"=> array( "type"=> 0, "title"=> "신정", "year"=> "" ),
	"0301"=> array( "type"=> 0, "title"=> "삼일절", "year"=> "" ),
	"0505"=> array( "type"=> 0, "title"=> "어린이날", "year"=> "" ),
	"0512"=> array( "type"=> 0, "title"=> "석가탄신일", "year"=> "" ),
	"0606"=> array( "type"=> 0, "title"=> "현충일", "year"=> "" ),
	"0815"=> array( "type"=> 0, "title"=> "광복절", "year"=> "" ),
	"1003"=> array( "type"=> 0, "title"=> "개천절", "year"=> "" ),
	"1009"=> array( "type"=> 0, "title"=> "한글날", "year"=> "" ),
	"1225"=> array( "type"=> 0, "title"=> "크리스마스", "year"=> "" ),

	"0204"=> array( "type"=> 0, "title"=> "설날", "year"=> "2018" ),
	"0205"=> array( "type"=> 0, "title"=> "설날", "year"=> "2018" ),
	"0206"=> array( "type"=> 0, "title"=> "설날", "year"=> "2018" ),

	"0912"=> array( "type"=> 0, "title"=> "추석", "year"=> "2019" ),
	"0913"=> array( "type"=> 0, "title"=> "추석", "year"=> "2019" ),
	"0914"=> array( "type"=> 0, "title"=> "추석", "year"=> "2019" )
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
	if($selMonth > date("Ym", strtotime($nowMonth." -10 month"))){
	    echo "<a href='javascript:fnCalMove(\"$p_m\");' class='tour_calendar_prev'><span class='cal_ico'></span>이전</a>";
	}

	echo ("
            <a href='javascript:fnCalMove(\"$n_m\");' class='tour_calendar_next'><span class='cal_ico'></span>다음</a>
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

    for($r=0;$r<=$ra;$r++){
        echo "<tr>";

		for($z=1;$z<=7;$z++){
			$rv=7*$r+$z; $ru=$rv-$l; // 칸에 번호를 매겨줍니다. 1일이 되기전 공백들 부터 마이너스 값으로 채운 뒤 ~ 

			if($ru<=0 || $ru>$s_t){ 
				echo "<td><span class='tour_td_block'><span class='tour_cal_day'>&nbsp;</span></span></td>";
			}else{
				$s = date("Y-m-d",mktime(0,0,0,$s_m,$ru,$s_Y)); // 현재칸의 날짜
				$h = date("H");
				$weeknum = $z - 1;

				$calMD = explode("-",$s)[1].explode("-",$s)[2];
				$holidayChk = (array_key_exists($calMD, $holidays)) ? " style='color:red;'" : "";

				$onOff = 0;
				if(($s >= "2019-07-15" && $s <= "2019-08-18") || ($weeknum == 0 || $weeknum == 6)){
					$onOff = 1;
				}

				if(!($s > "2011-05-03" && $s < "2019-09-30") || $onOff == 0)
				{
					echo "<td class='cal_type2'><span class='tour_td_block'><span class='tour_cal_day' style='color:#c2c2c2;'>$ru</span><span class='tour_cal_pay' style='color:#d0d0d0;'></span></span></td>";
				}
				else
				{
					if($s >= $nowDate){
						echo "<td class='cal_type2' style='cursor:pointer;padding-bottom:2px;'><calBox class='tour_td_block' value='$s' weekNum='$weeknum' onclick='fnPassenger(this, $Price, 1);'><span class='tour_cal_day' $holidayChk>$ru</span><span class='tour_cal_pay'>예약가능</span></calBox></td>";
					}else{
						echo "<td class='cal_type2' style='padding-bottom:2px;'><span class='tour_td_block'><span class='tour_cal_day' style='color:#c2c2c2;'>$ru</span><span class='tour_cal_pay' style='color:#d0d0d0;'>종료</span></span></td>";
					}
				}
			}
		}

        echo "</tr>";
    }
echo ("
            </tbody>
        </table>
    </div>");
?>