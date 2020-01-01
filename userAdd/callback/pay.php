<?php
include __DIR__.'/../db.php';

include __DIR__.'/../func.php';

function begin(){
	mysql_query("BEGIN");
}

function rollback(){
	mysql_query("ROLLBACK");
}

function commit(){
	mysql_query("COMMIT");
}

$imp_uid = trim($_REQUEST["Amt"]);
?>
test<br>
<?=$imp_uid?>