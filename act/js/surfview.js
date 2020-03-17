$j(document).ready(function() {
    $j("#slide1").click(function() {
        $j(".vip-tabnavi li").removeClass("on");
        $j(".vip-tabnavi li").eq(3).addClass("on");

        $j("#view_tab1").css("display", "none");
        $j("#view_tab3").css("display", "block");

        fnMapView("#view_tab3", 90);
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
        }
    }

    fnMapView(objid, topCnt);
}

function fnResView(bool, objid, topCnt, obj) {
    $j(".vip-tabnavi li").removeClass("on");
    $j(obj).addClass("on");

    if (bool) {
        $j("#view_tab1").css("display", "block");
        $j("#view_tab3").css("display", "none");
    } else {
        $j("#view_tab1").css("display", "none");
        $j("#view_tab3").css("display", "block");
    }

    fnMapView(objid, topCnt);
}

function fnMapView(objid, topCnt) {
    var divLoc = $j(objid).offset();
    $j('html, body').animate({
        scrollTop: divLoc.top - topCnt
    }, "slow");
}