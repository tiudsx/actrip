function fnCouponCheck(obj){
	var cp = fnCoupon("SUR", "load", $j("#coupon").val());
	if(cp > 0){
		$j("#coupondis").css("display", "");
		$j("#couponcode").val($j("#coupon").val())
		$j("#couponprice").val(cp);

		if(cp <= 100){ //퍼센트 할인
			$j("#coupondis").html("<br>적용쿠폰코드 : " + $j("#coupon").val() + "<br>총 결제금액에서 "+ cp + "% 할인");
		}else{ //금액할인
			$j("#coupondis").html("<br>적용쿠폰코드 : " + $j("#coupon").val() + "<br>총 결제금액에서 "+ commify(cp) + "원 할인");
		}
	}else{
		$j("#coupondis").css("display", "none");
		$j("#coupondis").html("");
		$j("#couponcode").val("")
		$j("#couponprice").val(0);
	}
	$j("#coupon").val("");

	fnTotalPrice();
}