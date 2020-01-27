<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<link rel="stylesheet" type="text/css" href="/userAdd/a_css/default.css" />
        
<script type="text/javascript">
    $j(document).ready(function(){

        var topBar = $j("#topBar").offset();
        var bottomBar = $j(".footer_Util_wrap00").height();
        if($j(".top_bn_zone").css("display") == "none"){
            var initTop = 0;
        }else{
            var initTop = 50;                    
        }

        if($j(document).scrollTop() > initTop){
            $j("#topBar").addClass("top_bar_fix");
            $j("#fixNextTag").addClass("pd_top_80");
        }

        $j(window).scroll(function(){					
            var docScrollY = $j(document).scrollTop();

            var scrollBottom = $j("body").height() - $j(window).height() - $j(window).scrollTop(); //스크롤바텀값
            var scrollBottom2= $j(window).height() - $j(window).scrollTop(); //스크롤바텀값

            $j("#test").html(scrollBottom + '/' + bottomBar + '/' + topBar.top + '/' + $j(window).scrollTop());

            if( docScrollY > topBar.top ) {
                $j("#topBar").addClass("top_bar_fix");
                $j("#fixNextTag").addClass("pd_top_80");
            }else{
                $j("#topBar").removeClass("top_bar_fix");
                $j("#fixNextTag").removeClass("pd_top_80");
            }

            if( scrollBottom < bottomBar ) {                
                //$j("#con_footer").css("bottom", (bottomBar - scrollBottom) + "px");
            }else{
                //$j("#con_footer").css("bottom", "0px");
            }

        });

        var type = "";
        var btnheight = "";
        $j("#slide1").click(function() {
            if(btnheight == "")	btnheight = $j("#con_footer").height();

            if (type == "down"){
                $j("#con_footer").animate(
                    {height: btnheight + "px",},
                    {duration:500, complete:function(){
                        //alert("다운");
                }});
                type = "";
            }
            else{
                $j("#con_footer").animate(
                    {height: "400px",},
                    {duration:500, complete:function(){
                        //alert("업");
                }});
                type = "down";
            }
        });	

    });
</script>

<style type="text/css">
    #con_footer{height:40px;position:fixed;bottom:0px;background:#00ffff;width:100%;z-index:1;}
</style>

<div class="wrap">
    <div class="top_bn_zone">
        상단 배너 영역
    </div>

    <div class="top_fix_zone" id="topBar">
        <div class="topheader" style="display: block;">
            <div class="gpe_logo">
                <a href="/"><img src="https://surfenjoy.cdn3.cafe24.com/logo/actrip.png" alt="로고"></a>
                <span id="test"></span>
            </div>
            <div></div>
        </div>
    </div>

    <div class="top_con_zone" id="fixNextTag" style="background-color: #656565;">
        하단 contents 영역sdfsdfsdfsdfsdf 
    </div>
</div>

<div id="con_footer">
    <div class="resbottom">
            <button class="reson" id="slide1"><i></i><span>예약하기</span></button>
        </div>
        <div id="sildeing" style="position:absolute;bottom:80px;display: none;">
            sdfsd<br>
            dsfsd<br>
            sdfs<br>
	</div>

</div>

<div class="footer_Util_wrap00">
    <div class="footer_Util_wrap0" style="">
        <!--유틸메뉴-->
        <div class="gpe_utilMenu">
            <ul>
                <li>
                    <a href="https://actrip.co.kr/surfenjoyservice">서비스이용약관</a>
                </li><li>
                    <a href="https://actrip.co.kr/surfenjoyprivacy">개인정보취급방침</a>
                </li><li>
                    <a href="https://actrip.co.kr/surfenjoyyouth">청소년보호정책</a>
                </li>		</ul>
        </div>
        
        <!--카피라이트-->
        <div class="gpe_copytxt">
            <p>
                    <font style="font-size:11px;">
    상호:에스씨컴퍼니 대표:이승철 TEL:010-3308-6080 FAX:02-6280-0080<br>
    사업자번호:149-14-00938 통신판매신고번호:2019-서울광진-0055호<br>
    서울시 광진구 아차산로 452, 10층 1015호<br>
    <!--서비스/환불/취소/교환 등은 '에스씨컴퍼니'에게 모든 책임이 있음을 알려드립니다.<br-->
    Copyright ⓒ 2017 <span style="font-weight:bold; color:#00a6d4;">actrip.co.kr</span>. All rights reserved
    </font>				</p>
        </div>
        
    </div>
</div>