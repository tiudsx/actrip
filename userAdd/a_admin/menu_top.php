<?
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

$folderUrlName = "a_admin";
$folderUrl = "/userAdd/a_admin";
?>
<script>
	var folderBus = "<?=folderUrlName?>";
	var folderBusRoot = "<?=$folderUrl?>";
</script>
<link rel="stylesheet" type="text/css" href="/userAdd/script/common.css" />
<link rel="stylesheet" type="text/css" href="admin.css" />
<link rel="stylesheet" type="text/css" href="/userAdd/script/calendar.css" />
<link rel="stylesheet" type="text/css" href="/userAdd/script/jquery-ui.css" />
<script src="/userAdd/script/jquery-ui.js"></script>
<script src="/userAdd/script/jquery.blockUI.js"></script>
<script src="/userAdd/script/common.js"></script>
<script src="surfshop.js"></script>