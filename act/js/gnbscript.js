$j.ajaxSetup({
	async: false
});

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

		if($j("#view_tab3").css("display") == "block"){
			$j(".con_footer").css("display", "none");
		}else{
			$j(".con_footer").css("display", "block");			
		}
	}
});
/* End */

function gpe_getCookie1(name) { 
	var Found = false 
	var start, end 
	var i = 0 
	while(i <= document.cookie.length) { 
		start = i 
		end = start + name.length 
		if(document.cookie.substring(start, end) == name) { 
			Found = true 
			break 
		} 
		i++ 
	} 
	
	if(Found == true) { 
		start = end + 1 
		end = document.cookie.indexOf(";", start) 

		if(end < start) 
			end = document.cookie.length 

		return document.cookie.substring(start, end) 
	} 
	return "" 
} 

function gpe_setCookie1( name, value, expiredays ) { 
	var todayDate = new Date(); 
	todayDate.setDate( todayDate.getDate() + expiredays ); 
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
}