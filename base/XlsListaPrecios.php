<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

function cargarClases($classname)
{
require '../clases/'.$classname.'.php';
}
spl_autoload_register('cargarClases');

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Milton Giovanni Espitia')
    ->setLastModifiedBy('Milton Giovanni Espitia')
    ->setTitle('Lista de precios')
    ->setSubject('Precios')
    ->setDescription('Lista de precios')
    ->setKeywords('Lista')
    ->setCategory('Precios');

// Add some data
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'Código')
			->setCellValue('B1', 'Presentación de precio')
			->setCellValue('C1', 'Super')
			->setCellValue('D1', 'Fábrica')
			->setCellValue('E1', 'Mayorista')
			->setCellValue('F1', 'Distribuidor')
			->setCellValue('G1', 'Detal');
// Rename sheet
$spreadsheet->getActiveSheet()->setTitle('Precios');

$PrecioOperador = new PreciosOperaciones();
$precios=$PrecioOperador->getTablePrecios();
$j=2;
for($i=0;$i<count($precios);$i++){
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $j, $precios[$i]['Código']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $j, $precios[$i]['Descripción']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $j, $precios[$i]['Precio Super']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4, $j, $precios[$i]['Precio Fábrica']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(5, $j, $precios[$i]['Precio Mayorista']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $j, $precios[$i]['Precio Distribución']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(7, $j++, $precios[$i]['Precio Detal']);
}
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Lista de Precios.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
?>








