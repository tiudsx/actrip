<?php
include __DIR__.'/../db.php';

session_start();

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
ini_set('memory_limit', -1);

date_default_timezone_set('Asia/Seoul');

require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("SurfTemplate.xls");

$baseRow = 6;

$inResConfirm = $_REQUEST["chkResConfirm"];
$inResType = $_REQUEST["chkbusNum"];
$inResSex = $_REQUEST["chkResSex"];

$schText = $_REQUEST["schText"];

if($schText == "-1") $schText = '';

if($schText != ""){
	$schText = ' AND (MainNumber like "%'.$_REQUEST["schText"].'%" OR userName like "%'.$_REQUEST["schText"].'%" OR userPhone like "%'.$_REQUEST["schText"].'%")';
}

$select_query = 'SELECT * FROM `SURF_YANGFE_MAIN` WHERE ResConfirm IN ('.$inResConfirm.')
						AND userGubun IN ('.$inResType.')
						AND userSex IN ('.$inResSex.')'.$schText.' 
						ORDER BY intseq asc';

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

$r = 0;
if($count == 0){
	$cellnum = $baseRow + $r;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($cellnum,1);

	$objPHPExcel->getActiveSheet()
		->setCellValue("A".$cellnum, '')
		->setCellValue("B".$cellnum, '')
		->setCellValue("C".$cellnum, '')
		->setCellValue("D".$cellnum, '')
		->setCellValue("E".$cellnum, '')
		->setCellValue("F".$cellnum, '예약정보가 없습니다.')
		->setCellValue("G".$cellnum, '')
		->setCellValue("H".$cellnum, '')
		->setCellValue("I".$cellnum, '');

}

while ($row = mysqli_fetch_assoc($result_setlist)){

	$cellnum = $baseRow + $r;
	if($row['ResConfirm'] == 0){
		$ResConfirm = "미입금";
	}else if($row['ResConfirm'] == 1){
		$ResConfirm = "입금대기";
	}else if($row['ResConfirm'] == 2){
		$ResConfirm = "확정";
	}else if($row['ResConfirm'] == 3){
		$ResConfirm = "취소";
	}

	$objPHPExcel->getActiveSheet()->insertNewRowBefore($cellnum,1);

	$objPHPExcel->getActiveSheet()
		->setCellValue("A".$cellnum, ($r + 1))
		->setCellValue("B".$cellnum, $row['userGubun'])
		->setCellValue("C".$cellnum, $row['userName'])
		->setCellValue("D".$cellnum, $row['userPhone'])
		->setCellValue("E".$cellnum, $row['userClub'])
		->setCellValue("F".$cellnum, $row['userSex'])
		->setCellValue("G".$cellnum, str_replace('-', ' ', $row['userCarnum']))
		->setCellValue("H".$cellnum, $row['Etc'])
		->setCellValue("I".$cellnum, $ResConfirm);


	$r++;
}

$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

$filename = 'yangyang_festival_'.date("Ymd");

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

exit;
?>