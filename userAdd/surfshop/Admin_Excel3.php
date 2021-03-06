<?php
include __DIR__.'/../db.php';

session_start();

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Asia/Seoul');

require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("SurfTemplate.xls");

$baseRow = 6;


$sDate = $_REQUEST["sDate"];

$selDate = ($_REQUEST["sDate"] == "") ? str_replace("-", "", date("Y-m-d")) : $_REQUEST["sDate"];

$Year = substr($selDate,0,4);
$Mon = substr($selDate,4,2);

$ResDateTitle = " [".$Year."년 ".$Mon."월]";

$select_query = 'SELECT opt_bbq FROM `SURF_SHOP` WHERE intseq = '.$_SESSION['shopseq'];
$result_shop = mysqli_query($conn, $select_query);
$rowshop = mysqli_fetch_array($result_shop);

$opt_bbq = $rowshop["opt_bbq"]; //서프엔조이 바베큐 여부

$bbqSql = "";
if($opt_bbq == "Y"){
	$bbqSql = "AND b.ResGubun != 4";
}

$select_query = 'SELECT * FROM `SURF_SHOP_RES_MAIN` as a INNER JOIN `SURF_SHOP_RES_SUB` as b
					ON a.MainNumber = b.MainNumber
				INNER JOIN SURF_CODE as c
					ON cast(b.ResGubun as char(1)) = c.code 
				where b.ResConfirm = 5
					'.$bbqSql.'
					AND a.shopSeq = '.$_SESSION['shopseq'].'
					AND (Year(ResDate) = '.$Year.' AND Month(ResDate) = '.$Mon.')
				ORDER BY subintseq';

$result_setlist = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_setlist);

//=========== 샵 정보 가져오기 ===========
$select_query_admin = 'SELECT * FROM `SURF_SHOP` where intseq = '.$_SESSION['shopseq'].' limit 1';
$resultAdmin = mysqli_query($conn, $select_query_admin);
$rowAdmin = mysqli_fetch_array($resultAdmin);

$shopcode = $rowAdmin["shopcode"];
$shopname = $rowAdmin["shopname"];

$objPHPExcel->getActiveSheet()->setCellValue('E1', ' ● '.$shopname.''.$ResDateTitle);

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
		->setCellValue("I".$cellnum, '')
		->setCellValue("J".$cellnum, '')
		->setCellValue("K".$cellnum, '')
		->setCellValue("L".$cellnum, '');

}

$s_i = 0;
$e_i = 0;
$PreMainNumber = "";
while ($row = mysqli_fetch_assoc($result_setlist)){

	$MainNumber = $row['MainNumber'];
	if($MainNumber != $PreMainNumber && $r > 0){
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$s_i.':A'.$e_i);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$s_i.':B'.$e_i);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$s_i.':C'.$e_i);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$s_i.':D'.$e_i);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.$s_i.':J'.$e_i);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$s_i.':K'.$e_i);
	}

	$cellnum = $baseRow + $r;
	if($MainNumber == $PreMainNumber){
		$e_i++;
	}else{
		$s_i = $cellnum;
		$e_i = $cellnum;
	}
	$PreMainNumber = $row['MainNumber'];

	if($row['ResGubun'] == 2){
		$gubun = $row['codename'];
		$gubunTitle = $row['ResDay'];
	}else{
		$gubun = $row['codename'];
		$gubunTitle = $row['ResOptName'];
	}

	$TimeDate = "";
	if($row['ResGubun'] == 0 || $row['ResGubun'] == 2){
		$TimeDate = $row['ResTime'];
	}else if($row['ResGubun'] == 3){
		$TimeDate = $row['ResDay'];
	}

	$ResNumM = "";
	$ResNumW = "";
	if($row['ResNumM'] > 0){
		$ResNumM = $row['ResNumM'].' 명';
	}

	if($row['ResNumW'] > 0){
		$ResNumW = $row['ResNumW'].' 명';
	}
	$LastPrice = number_format($row['ResPrice']).'원';

	$objPHPExcel->getActiveSheet()->insertNewRowBefore($cellnum,1);

	$objPHPExcel->getActiveSheet()
		->setCellValue("A".$cellnum, $row['MainNumber'])
		->setCellValue("B".$cellnum, substr($row['ResDate'], 0, 10))
		->setCellValue("C".$cellnum, $row['userName'])
		->setCellValue("D".$cellnum, $row['userPhone'])
		->setCellValue("E".$cellnum, $gubun)
		->setCellValue("F".$cellnum, $gubunTitle)
		->setCellValue("G".$cellnum, $TimeDate)
		->setCellValue("H".$cellnum, $ResNumM)
		->setCellValue("I".$cellnum, $ResNumW)
		->setCellValue("J".$cellnum, $row['Etc'])
		->setCellValue("K".$cellnum, "확정")
		->setCellValue("L".$cellnum, $LastPrice);


	$r++;
}
$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

if(!($s_i == $e_i)){
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($s_i - 1).':A'.($e_i - 1));
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($s_i - 1).':B'.($e_i - 1));
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.($s_i - 1).':C'.($e_i - 1));
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.($s_i - 1).':D'.($e_i - 1));
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.($s_i - 1).':J'.($e_i - 1));
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.($s_i - 1).':K'.($e_i - 1));
}

$filename = 'surfenjoy_'.$shopcode.'_'.date("Ymd");

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