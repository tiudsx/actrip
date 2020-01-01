<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
include __DIR__.'/../db.php';

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Asia/Seoul');

/** PHPExcel_IOFactory */
//require_once dirname(__FILE__) . '/../../Classes/PHPExcel.php';
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';


$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("SurfTemplate.xls");
//$objPHPExcel->getActiveSheet()->setCellValue('D1', PHPExcel_Shared_Date::PHPToExcel(time()));

$baseRow = 5;

$chkResConfirm = $_REQUEST["chkResConfirm"];
$chkResType = $_REQUEST["chkResType"];
$shopSeq = $_REQUEST["shopSeq"];
$sDate = $_REQUEST["sDate"];
$eDate = $_REQUEST["eDate"];
$schText = $_REQUEST["schText"];

$inResConfirm = "";
for($i = 0; $i < count($chkResConfirm); $i++){
	if($chkResConfirm[$i] == 1 || $chkResConfirm[$i] == 3){
		$inResConfirm .= $chkResConfirm[$i].',';
	}
}
$inResConfirm .= '99';


$inResType = "";
for($i = 0; $i < count($chkResType); $i++){
	$inResType .= $chkResType[$i].',';
}
$inResType .= '99';

$ResDate = "";
if($sDate == "" && $eDate == ""){
}else{
	if($sDate != "" && $eDate != ""){
		$ResDate = ' AND (ResDate BETWEEN CAST("'.$sDate.'" AS DATE) AND CAST("'.$eDate.'" AS DATE))';
	}else if($sDate != ""){
		$ResDate = ' AND ResDate >= CAST("'.$sDate.'" AS DATE)';
	}else if($eDate != ""){
		$ResDate = ' AND ResDate <= CAST("'.$eDate.'" AS DATE)';
	}
}

if($schText != ""){
	$schText = ' WHERE (a.MainNumber like "%'.$_REQUEST["schText"].'%" OR a.userName like "%'.$_REQUEST["schText"].'%" OR a.userPhone like "%'.$_REQUEST["schText"].'%")';
}


$select_query = 'SELECT * FROM `SURF_SHOP_RES_MAIN` as a INNER JOIN `SURF_SHOP_RES_SUB` as b
					ON a.MainNumber = b.MainNumber
				INNER JOIN SURF_CODE as c
					ON cast(b.ResGubun as char(1)) = c.code 
				where b.ResConfirm IN ('.$inResConfirm.')'.$ResDate.$schText.' 
				ORDER BY ResDate, subintseq';

$result_setlist = mysqli_query($conn, $select_query);

$r = 0;
while ($row = mysqli_fetch_assoc($result_setlist)){
	$ResConfirm = "";

	if($row['ResConfirm'] == 0){
		$ResConfirm = "미입금";
	}else if($row['ResConfirm'] == 1){
		$ResConfirm = "예약완료";
	}else if($row['ResConfirm'] == 2){
		$ResConfirm = "환불요청";
	}else if($row['ResConfirm'] == 3){
		$ResConfirm = "취소완료";
	}

	$arrOpt = explode("@",$row['ResOptPrice']);
	if($row['ResOptPrice'] == ""){
		$OptText = '전기 미사용';
	}else{
		if($arrOpt[0] == "0"){
			$OptText = '전기 사용';
		}else{
			$OptText = $arrOpt[1].' '.number_format($arrOpt[2]).'원';
		}
	}

	$cellnum = $baseRow + $r;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($cellnum,1);

	$select_queryCnt = 'SELECT MainNumber FROM SURF_CAMPING_JUKDO where MainNumber = "'.$row['MainNumber'].'"';
	$result_setlistCnt = mysqli_query($conn, $select_queryCnt);
	$count = mysqli_num_rows($result_setlistCnt);
/*
$tmpNumber = $row['MainNumber'];
if($count == 1){
}else{
	if($tmpPreNumber == "" || $tmpNumber != $tmpPreNumber){
		$tmpNumber2 = "A".$cellnum.'A'.($cellnum + $count - 1);
		$objPHPExcel->getActiveSheet()
				->mergeCells("A".$cellnum.':A'.($cellnum + $count - 1))
				->setCellValue("A".$cellnum, '');
	}
}

	$tmpPreNumber = $row['MainNumber'];
*/
	$objPHPExcel->getActiveSheet()
		->setCellValue("A".$cellnum, $row['MainNumber'])
		->setCellValue("B".$cellnum, substr($row['sDate'], 0, 10))
		->setCellValue("C".$cellnum, $row['userName'])
		->setCellValue("D".$cellnum, $row['userPhone'])
		->setCellValue("E".$cellnum, $row['sLocation'])
		->setCellValue("F".$cellnum, number_format($row['ResPrice']).'원')
		->setCellValue("G".$cellnum, $OptText)
		->setCellValue("H".$cellnum, $row['Etc'])
		->setCellValue("I".$cellnum, $ResConfirm)
		->setCellValue("J".$cellnum, $row['insdate']);

	$r++;
}
$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

$filename = 'surfCamp_'.date("Ymd");

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