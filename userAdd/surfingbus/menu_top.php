<?
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

if($pcmobile){
//============ Mobile 영역 Start =============

//============ Mobile 영역 End =============

}else{

//============ PC 영역 Start =============


//============ PC 영역 End =============
}

$folderUrl = "/userAdd/surfingbus";
?>
<script>
	var $j = jQuery.noConflict();

	var folderBus = "surfingbus";
	var folderBusRoot = "/userAdd/surfingbus";
</script>
<link rel="stylesheet" type="text/css" href="/userAdd/script/common.css?v=1" />
<link rel="stylesheet" type="text/css" href="surfbus.css?v=1" />
<link rel="stylesheet" type="text/css" href="/userAdd/script/calendar.css" />
<link rel="stylesheet" type="text/css" href="/userAdd/script/jquery-ui.css" />
<script src="/userAdd/script/jquery-ui.js"></script>
<script src="/userAdd/script/jquery.blockUI.js"></script>
<script src="/userAdd/script/common.js?v=12"></script>
<script src="surfbus.js?v=31"></script>