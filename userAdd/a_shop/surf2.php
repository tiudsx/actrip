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

            //$j("#test").html(scrollBottom + '/' + bottomBar + '/' + topBar.top + '/' + $j(window).scrollTop());

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

.title-box~.recommends-list .recommend-item:first-child{padding:0 0 30px}
.recommends-list .recommend-item{border-bottom:1px solid #e5e5e5;padding:20px 10px 20px 0px; height:180px;}
.recommends-list .recommend-item .item-inner{display:block;position:relative;width:100%}
.recommends-list .recommend-item .item-inner:after{content:"";display:table;clear:both;*zoom:1}
.recommends-list .recommend-item .image-box{position:absolute;overflow:hidden;
    border-radius: 0.8rem;
    bottom: 0;
    left: 0;
    padding: 0;
    top: 0;
    width: 40%;
    height:180px;
}

._1WNbiB {
    width: 100%;
    height: 100%;
    background: 50% no-repeat;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    overflow: hidden;
    position: absolute;
    top: 0;
    left: 0;
}

._1WNbiB {
    background-size: cover;
    padding: 0 1rem;
}

.recommends-list .recommend-item .image-box .badge-rap{position:absolute;top:10px;left:10px;width:100%}
.recommends-list .recommend-item .image-box .badge-rap:after{content:"";display:table;clear:both;*zoom:1}
.recommends-list .recommend-item .image-box .badge-rap span{font-size:13px;color:#fff;display:inline-block;padding:4px 5px;margin-left:5px}
.recommends-list .recommend-item .image-box .badge-rap span:first-child{margin-left:0}
.recommends-list .recommend-item .image-box .badge-rap span.badge-coupon{background-color:#18d0c5}
.recommends-list .recommend-item .image-box .badge-rap span.badge-goodstay,.recommends-list .recommend-item .image-box .badge-rap span.badge-myroom{background-color:#ff2d60}
.recommends-list .recommend-item .image-box .maker-rap{background-color:rgba(0,0,0,.5);display:none;z-index:1;position:absolute;top:0;left:0;width:100%;height:100%;text-align:center}
.recommends-list .recommend-item .image-box .maker-rap .maker-image{transform:translateY(-50%);position:relative;top:50%}
.recommends-list .recommend-item .image-box .maker-rap img{animation-name:bounceInDown;animation-iteration-count:1;animation-duration:.4s;animation-delay:0s;animation-timing-function:ease;animation-fill-mode:both;-webkit-backface-visibility:hidden;backface-visibility:hidden;width:auto}
.recommends-list .recommend-item.focused .maker-rap{display:block}
.recommends-list .recommend-item .info-box{
    background-color: transparent;
    float: right;
    min-height: 170px;
    padding-top: 0.3rem;
    position: relative;
    width: calc(60% - 1rem);
}
.recommends-list .recommend-item .info-box .title-rap .title-text{max-height:60px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;text-overflow:ellipsis;margin-right:60px;color:#333;vertical-align:middle;font-weight:550;letter-spacing:-1px;width:100%;}
.recommends-list .recommend-item .info-box .title-rap:focus strong,.recommends-list .recommend-item .info-box .title-rap:hover strong{color:#ff2d60}
.recommends-list .recommend-item .info-box .tags{border:1px solid #ccc;color:#333;font-size:13px;margin-left:10px;padding:3px 5px;vertical-align:middle}
.recommends-list .recommend-item .info-box .icons{margin-left:10px;vertical-align:middle}
.recommends-list .recommend-item .info-box .score-rap .icon-staylist-score{margin-top:-1px}
.recommends-list .recommend-item .info-box .score-rap .icon-score{display:inline-block;width:90px;height:20px;background-color:#eee}
.recommends-list .recommend-item .info-box .score-rap em{font-size:14px;color:#aaa;margin-left:10px}
.recommends-list .recommend-item .info-box .price-rap{margin-top:5px}
.recommends-list .recommend-item .info-box .price-rap:after{content:"";display:table;clear:both;*zoom:1}
.recommends-list .recommend-item .info-box .price-rap .price-item{margin-top:5px}
.recommends-list .recommend-item .info-box .price-rap .price-item:first-child{margin-top:0}
.recommends-list .recommend-item .info-box .price-rap .price-item .price-type{color:#333;display:inline-block;margin-right:5px;font-size:12px;}
.recommends-list .recommend-item .info-box .price-rap .price-item .price-type b{font-weight:600}
.recommends-list .recommend-item .info-box .price-rap .price-item .price-label{font-size:12px;color:#fff;display:inline-block;padding:3px 5px 2px;vertical-align:top;margin-top:3px}
.recommends-list .recommend-item .info-box .price-rap .price-item .price-label.label-member{background-color:#666}
.recommends-list .recommend-item .info-box .price-rap .price-item .price-label.label-reserve{background-color:#ff2d60}
.recommends-list .recommend-item .info-box .price-rap .price-item em{margin-left:3px;font-size:24px;color:#333;vertical-align:middle;font-weight:600;letter-spacing:-1px}
.recommends-list .recommend-item .info-box .price-rap .price-item em i{color:#333;font-size:16px;margin-left:2px}
.recommends-list .recommend-item .info-box .price-rap .price-item small{font-size:12px;color:#919191;margin-left:5px}
.recommends-list .recommend-item .info-box .price-rap .price-item small.underline{display:inline-block;margin-right:5px;text-decoration:line-through}
.recommends-list .recommend-item .info-box .badge-rap{margin-top:30px}
.recommends-list .recommend-item .info-box .badge-rap span{display:inline-block;margin-left:15px}
.recommends-list .recommend-item .info-box .badge-rap span em{font-size:14px;color:#333;margin-left:5px}
.recommends-list .recommend-item .info-box .badge-rap span:first-child{margin-left:0}
.recommends-list .recommend-item .info-box .hashtag-rap{margin-top:10px;}
.recommends-list .recommend-item .info-box .hashtag-rap p{font-size:12px;color:#aaa;line-height: 0.9em;font-weight:500;}

.recommends-list li:nth-child(1) { padding: 0px 10px 20px 0px;}

.recommends-list li {list-style: none;outline: none;}

.txt-distance {cursor:pointer;}
.txt-distance i{position:relative;top:-1px}
.txt-distance em{font-size:13px;margin-left:2px;font-weight:700;color:#808080;}

.f-right {    float: right;}

.icon-staylist-distance {    width: 14px;    height: 16px;   }
em{font-style: normal;}
.icon-staylist {
    display: inline-block;
    overflow: hidden;
    font-size: 0;
    line-height: 0;
    text-indent: -9999px;
    vertical-align: middle;
}

a {
    color: #666666;
    text-decoration: none;
    cursor: pointer;
	padding-top:3px;
}

.KNL89j {
    font-size: 0.85rem;
    line-height: 1.7rem;
    margin-top: .5rem;
    color: #616161;
}
</style>

<div class="wrap">
    <div class="top_bn_zone" style="display:none;">
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

    <div class="top_con_zone" id="fixNextTag" style="padding:6px;">
        
    <section style="width:100%;text-align:left;">
        <div class="adtitle" style="display:block;">
			<span><img src="https://surfenjoy.cdn3.cafe24.com/icon/cate_02.jpg"></span>
		</div>

        <div style="margin-bottom:20px;">
			<ul class="recommends-list" style="padding-inline-start:0px;margin-block-start:10px;">
				<li class="recommend-item">
					<div class="item-inner">
						<div class="image-box">
                            <div class="_1WNbiB" style="background-image: url('https://surfenjoy.cdn3.cafe24.com/shop/surfenjoy_new_1.jpg?v=3');"></div>
							
							<div class="badge-rap">
								<div>
                                    <span class="badge-myroom">&nbsp;추천&nbsp;</span>
                                    <!--span class="badge-coupon">10% 할인</span-->
								</div>
							</div>	
						</div>
							
						<div class="info-box">
							<div class="title-rap">
								<a href="/surfres?seq=69">
									<div>
										<strong class="title-text">
											<span style="display: block; position: relative; overflow: hidden;padding-top:1px;">
												<span style="width: 100%;">[죽도] 당찬패키지</span>
											</span>
                                        </strong>
                                        <span class="KNL89j">구매 <b>1,470</b>개</span>
                                    </div>
                                   
								</a>
							</div>
							
							<div class="price-rap">
								<div class="price-item">
									<span class="price-type"><b>입문강습</b></span>
									<span>
										<!--i class="price-label label-reserve">예약가</i-->
										<span>
											<small class="underline">80,000원</small>
											<em>70,000<small>원</small></em>
										</span>
									</span>
								</div>
							</div>
							
							<div class="hashtag-rap">
                                <p>★ 10월 12일, 13일 양양서핑 페스티벌</p>
                                <p>★ 죽도해변만의 고퀄리티 입문강습</p>
                                <p>★ 12일(토)에는 뮤직페스티벌과 함께~</p>
                            </div>
						</div>
					</div>
				</li>
				<li class="recommend-item">
					<div class="item-inner">
						<div class="image-box">
                            <div class="_1WNbiB" style="background-image: url('https://surfenjoy.cdn3.cafe24.com/yangfe2/surfshop_yangyang_500x500.jpg');"></div>
							
							<div class="badge-rap">
								<div>
                                    <span class="badge-myroom">&nbsp;추천&nbsp;</span>
                                    <!--span class="badge-coupon">10% 할인</span-->
								</div>
							</div>	
						</div>
							
						<div class="info-box">
							<div class="title-rap">
								<a href="/surfres?seq=69">
									<div>
										<strong class="title-text">
											<span style="display: block; position: relative; overflow: hidden;padding-top:1px;">
												<span style="width: 100%;">[죽도] 양양서핑페스티벌 - 초급강습</span>
											</span>
                                        </strong>
                                        <span class="KNL89j">구매 <b>1,470</b>개</span>
                                    </div>
                                   
								</a>
							</div>
							
							<div class="price-rap">
								<div class="price-item">
									<span class="price-type"><b>입문강습</b></span>
									<span>
										<!--i class="price-label label-reserve">예약가</i-->
										<span>
											<small class="underline">80,000원</small>
											<em>70,000<small>원</small></em>
										</span>
									</span>
								</div>
							</div>
							
							<div class="hashtag-rap">
                                <p>★ 10월 12일, 13일 양양서핑 페스티벌</p>
                                <p>★ 죽도해변만의 고퀄리티 입문강습</p>
                                <p>★ 12일(토)에는 뮤직페스티벌과 함께~</p>
                            </div>
						</div>
					</div>
				</li>
				
			</ul>
		</div>
    </section>


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