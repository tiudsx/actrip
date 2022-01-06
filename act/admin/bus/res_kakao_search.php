<?php
include __DIR__.'/../../surf/surffunc.php';

$hidsearch = $_REQUEST["hidsearch"];


include __DIR__.'/../../db.php';

$select_query = "SELECT A.*, REPLACE(B.name, '서핑버스 ', '') AS name FROM `AT_COUPON_CODE` AS A 
                    INNER JOIN AT_COUPON AS B 
                        ON A.couponseq = B.couponseq                        
                    WHERE A.couponseq IN (7,10,11,12,14,15) AND A.use_yn = 'N'
                    ORDER BY A.codeseq DESC";
$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

if($count == 0){
?>
<table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
<colgroup>
        <col width="9%"/>
        <col width="8%"/>
        <col width="11%"/>
        <col width="15%"/>
        <col width="15%"/>
        <col width="15%"/>
        <col width="12%"/>
        <col width="auto"/>
    </colgroup>
    <tbody>
        <tr>
            <th>채널</th>
            <th>이름</th>
            <th>연락처</th>
            <th>이용일 (서울>양양)</th>
            <th>이용일 (양양>서울)</th>
            <th>예약여부</th>
            <th>결과</th>
            <th>결과코드</th>
        </tr>
        <tr>
            <td colspan="8" style="text-align:center;height:50px;">
                <b>조회된 데이터가 없습니다.</b>
            </td>
        </tr>
    </tbody>
</table>

<?
	return;
}
?>
<table class="et_vars exForm bd_tb tbcenter" style="margin-bottom:5px;width:100%;">
    <colgroup>
        <col width="10%"/>
        <col width="9%"/>
        <col width="13%"/>
        <col width="15%"/>
        <col width="15%"/>
        <col width="13%"/>
        <col width="12%"/>
        <col width="auto"/>
    </colgroup>
    <tbody>
        <tr>
            <th>채널</th>
            <th>이름</th>
            <th>연락처</th>
            <th>이용일 (서울>양양)</th>
            <th>이용일 (양양>서울)</th>
            <th>예약여부</th>
            <th>결과</th>
            <th>결과코드</th>
        </tr>
<?while ($row = mysqli_fetch_assoc($result_setlist)){
	$coupon_code = $row['coupon_code'];
	$userinfo = $row['userinfo'];

    $arrChk = explode("|", $userinfo);
    //홍길동|0104437123|2022-01-08|2|2022-01-09|2|fail|L|M107:DeniedSenderNumber|K102:InvalidPhoneNumber

    $rtnText = "<b>".(($arrChk[6] == "fail") ? "실패" : "성공")."</b> (".(($arrChk[7] == "AT") ? "알림톡" : "문자").")";
    $rtnMessage = "<b>".$rtnText."</b>";
    $rtnTextCode = "";
   
    if($arrChk[8] != ""){
        $mesCode = substr($arrChk[8], 0, 4);
        $rtnTextCode .= $mesCode;
        //$rtnText .= "_".$arrChk[8];

        if($mesCode == "M001"){
            $data = json_decode(getKakaoSearch($arrChk[10]), true);
            $rtnMessage .= "<br>&nbsp;&nbsp;&nbsp; - ".$data["message"]." : ".fnMessageText($data["message"]);
        }else{
            $rtnMessage .= "<br>&nbsp;&nbsp;&nbsp; - ".$mesCode." : ".fnMessageText($mesCode);
        }
    }
    
    if($arrChk[9] != ""){
        $mesOriCode = substr($arrChk[9], 0, 4);
        $rtnTextCode .= " / ".$mesOriCode;
        //$rtnText .= "_".$arrChk[9];

        $rtnMessage .= "<br>&nbsp;&nbsp;&nbsp; - ".$mesOriCode." : ".fnMessageText($mesOriCode);
    }

    $rtnTextCode = '<span class="kakao_view" seq="'.$row['codeseq'].'">'.$rtnTextCode.'</span><span style="display:none;"><b>'.$row['insdate'].'</b><br><br>'.$rtnMessage.'</span>';

    ?>
        <tr>
            <td><?=$row['name']?></td>
            <td><?=$arrChk[0]?></td>
            <td><?=$arrChk[1]?></td>
            <td><?=$arrChk[2]?> (<?=$arrChk[3]?>명)</td>
            <td><?=$arrChk[4]?> (<?=$arrChk[5]?>명)</td>
            <td>X &nbsp;<input type="button" class="gg_btn res_btn_color2" style="width:40px; height:25px;" value="삭제" onclick="fnBusCouponDel(<?=$row['codeseq']?>);" /></td>
            <td><?=$rtnText?></td>
            <td>
                <?=$rtnTextCode?>                
            </td>
        </tr>
<?}?>
    </tbody>
</table>

<?
    function fnMessageText($code){
        switch ($code) {
            case 'K000':
                $text = "카카오 비즈메시지 발송 성공";
                break;
            case 'M000':
                $text = "SMS/LMS 발송 성공";
                break;
            case 'M001':
                $text = "SMS 발송 처리 중";
                break;
            case 'M107':
                $text = "미등록된 SMS 발신번호";
                break;
            case 'K208':
                $text = "링크버튼 형식 오류 (잘못된 파라메터 요청)";
                break;
            case 'K102':
                $text = "전화번호 오류";
                break;
            case 'K105':
                $text = "메시지 내용이 템플릿과 일치하지 않음";
                break;            
            case 'E104':
                $text = "유효하지 않은 사용자 전화번호";
                break;
            default:
                $text = $code;
                break;
        }

        return $text;
    }

    function getKakaoSearch($msgid){
        $params = array('profile'=>'70f9d64c6d3b9d709c05a6681a805c6b27fc8dca', 'msgid'=>$msgid);
        $query = http_build_query($params);
        $api_server = "https://alimtalk-api.bizmsg.kr/v2/sender/report";
    
        $opts = array(
            CURLOPT_URL => $api_server . '?' . $query,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                "userId: surfenjoy"
            ),
        );
    
        // 응답요청
        $curl_session = curl_init();
        curl_setopt_array($curl_session, $opts);
        $curl_response = curl_exec($curl_session);
        $resMessage = (curl_error($curl_session))? null : $curl_response;

        if($resMessage == null){
            return '{"code":"no"}';
        }else{
            return substr($resMessage, strpos($resMessage, "code") - 2);
        }
    }
/*
    $url = 'https://alimtalk-api.bizmsg.kr/v1/user/balance?userid=surfenjoy&userkey=RLORgrwUB4UI1Vt2ntl3';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    echo "결과:".$response;
    */
?>

<script type="text/javascript">
$j(document).ready(function(){
	$j(".kakao_view[seq]").mouseover(function(e){ //조회 버튼 마우스 오버시
		var seq = $j(this).attr("seq");
		var obj = $j(".kakao_view[seq="+seq+"]");
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
				$j(".kakao_view[seq="+seq+"]").append('<div class="box_layer"></div>');
				$j(".kakao_view[seq="+seq+"]").find(".box_layer").html($j(".kakao_view[seq="+seq+"]").next().html());
				$j(".kakao_view[seq="+seq+"]").find(".box_layer").css({
					"top" : tY
					,"left" : tX
					,"position" : "absolute"
				}).show();
		}		
	});
	
	$j(".kakao_view[seq]").mouseout(function(e){
			$j(this).find(".box_layer").css("display","none");
	});				 
}); 
</script>