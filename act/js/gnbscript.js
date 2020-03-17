/* Hamburger Menu */
$j(".menu").click(function() {
	$j(".menu").toggleClass("active");
	$j(".navbar-menu").toggleClass("active");
	
	if($j(".menu").hasClass("active")){
		$j('body').block({ message: null }); 
		$j(".layG_kakao").css("display", "none");
		$j(".con_footer").css("display", "none");
	}else{
		$j('body').unblock(); 
		$j(".layG_kakao").css("display", "");
		$j(".con_footer").css("display", "");
	}
});
/* End */