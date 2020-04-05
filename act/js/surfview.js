$j(document).ready(function() {
    $j("#slide1").click(function() {
        $j(".vip-tabnavi li").removeClass("on");
        $j(".vip-tabnavi li").eq(3).addClass("on");

        $j("#view_tab1").css("display", "none");
        $j("#view_tab3").css("display", "block");

        if($j("#view_tab2").length > 0){
            $j("#view_tab2").css("display", "none");
        }

        fnMapView("#view_tab3", 90);
        
        $j(".con_footer").css("display", "none");
    });

    var swiper = new Swiper('.swiper-container', {
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var topBar = $j(".vip-tabwrap").offset();

    $j(window).scroll(function() {
        var docScrollY = $j(document).scrollTop();

        //$j("#test").html(scrollBottom + '/' + bottomBar + '/' + topBar.top + '/' + $j(window).scrollTop());
        if ((docScrollY + 47) > (topBar.top + 0)) {
            $j("#tabnavi").addClass("vip-tabwrap-fixed");
            $j(".vip-tabwrap").addClass("vip-tabwrap-top");
        } else {
            $j("#tabnavi").removeClass("vip-tabwrap-fixed");
            $j(".vip-tabwrap").removeClass("vip-tabwrap-top");
        }

        if (checkVisible($j('.contentimg')) && !isVisible) {
            $j(".vip-tabnavi li").removeClass("on");
            $j(".vip-tabnavi li").eq(0).addClass("on");
        }

        if (checkVisible($j('#shopmap')) && !isVisible) {
            $j(".vip-tabnavi li").removeClass("on");
            $j(".vip-tabnavi li").eq(1).addClass("on");
        }

        if (checkVisible($j('#cancelinfo')) && !isVisible) {
            $j(".vip-tabnavi li").removeClass("on");
            $j(".vip-tabnavi li").eq(2).addClass("on");
        }
    });
});

var isVisible = false;
function fnCoupon(type, gubun, coupon){
    if(coupon == ""){
        alert("쿠폰코드를 입력하세요.")
        return 0;
    }

    var params = "type=" + type + "&gubun=" + gubun + "&coupon=" + coupon;
    var rtn = $j.ajax({
        type: "POST",
        url: "/act/coupon/coupon_load.php",
        data: params,
        success: function (data) {
            return data;
        }
    }).responseText;

    if (rtn == "yes") {
        alert("이미 사용 된 쿠폰입니다.");
        return 0;
    }else if (rtn == "no") {
        alert("사용가능한 쿠폰이 없습니다.");
        return 0;
    }else{
        return rtn;
    }
}

function checkVisible(elm, eval) {
    eval = eval || "object visible";
    var viewportHeight = $j(window).height(), // Viewport Height
        scrolltop = $j(window).scrollTop(), // Scroll Top
        y = $j(elm).offset().top,
        elementHeight = $j(elm).height();
    if (eval == "object visible") return ((y < (viewportHeight + scrolltop)) && (y > (scrolltop - elementHeight)));
    if (eval == "above") return ((y < (viewportHeight + scrolltop)));
}

function fnResViewBus(bool, objid, topCnt, obj) {
    $j(".vip-tabnavi li").removeClass("on");
    $j(obj).addClass("on");

    $j(".con_footer").css("display", "block");
    if(bool){
        $j("#view_tab1").css("display", "block");
        $j("#view_tab2").css("display", "none");
        $j("#view_tab3").css("display", "none");
    }else{
        $j("#view_tab1").css("display", "none");

        if(objid == "#view_tab2"){
            $j("#view_tab2").css("display", "block");
            $j("#view_tab3").css("display", "none");
        }else{
            $j("#view_tab2").css("display", "none");
            $j("#view_tab3").css("display", "block");

            if(objid == "#view_tab3"){
                $j(".con_footer").css("display", "none");
            }
        }
    }

    fnMapView(objid, topCnt);
}

function fnResView(bool, objid, topCnt, obj) {
    $j(".vip-tabnavi li").removeClass("on");
    $j(obj).addClass("on");

    $j(".con_footer").css("display", "block");
    if (bool) {
        $j("#view_tab1").css("display", "block");
        $j("#view_tab3").css("display", "none");
    } else {
        $j("#view_tab1").css("display", "none");
        $j("#view_tab3").css("display", "block");

        if(objid == "#view_tab3"){
            $j(".con_footer").css("display", "none");
        }
    }

    fnMapView(objid, topCnt);
}

function fnMapView(objid, topCnt) {
    var divLoc = $j(objid).offset();
    $j('html, body').animate({
        scrollTop: divLoc.top - topCnt
    }, "slow");
}

//달력 월 이동
function fnCalMove(selDate, seq) {
    var nowDate = new Date();
	$j("#tour_calendar").load("/act/surf/surfview_calendar.php?selDate=" + selDate + "&seq=" + seq + "&t=" + nowDate.getTime());

    $j("#initText").css("display", "");
    $j("#lessonarea").css("display", "none");
}