<?php
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}
function cargarClases($classname)
{
	require '../../../clases/'.$classname.'.php';
}
spl_autoload_register('cargarClases');

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Milton Giovanni Espitia')
	->setLastModifiedBy('Milton Giovanni Espitia')
	->setTitle('Inv MPrima')
	->setSubject('Inv MPrima')
	->setDescription('Inv MPrima')
	->setKeywords('Lista')
	->setCategory('Precios');
// Add some data
$spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A1', 'Código')
	->setCellValue('B1', 'Tapa')
	->setCellValue('C1', 'Cantidad')
	->setCellValue('D1', 'Entrada')
	->setCellValue('E1', 'Salida')
	->setCellValue('F1', 'Inventario')
	->setCellValue('G1', 'Costo');


// Rename sheet
$spreadsheet->getActiveSheet()->setTitle('Inventario Prod Fecha');

$InvTapaOperador = new InvTapasOperaciones();
$invTapas = $InvTapaOperador->getTableInvTapasFecha($fecha);
$j=2;
foreach ($invTapas as $invTapa)
{
	$spreadsheet->getActiveSheet()->setCellValue([1, $j], $invTapa['codTapa']);
	$spreadsheet->getActiveSheet()->setCellValue([2, $j], $invTapa['tapa']);
	$spreadsheet->getActiveSheet()->setCellValue([3, $j], $invTapa['invTapa']);
	$spreadsheet->getActiveSheet()->setCellValue([4, $j], $invTapa['entradaCompra'] + $invTapa['entradaCambio'] );
	$spreadsheet->getActiveSheet()->setCellValue([5, $j], $invTapa['salidaProduccion'] + $invTapa['salidaEnvasadoDist'] +  $invTapa['salidaJabones'] + $invTapa['salidaCambios']);
	$spreadsheet->getActiveSheet()->setCellValue([6, $j], $invTapa['invTapa'] - $invTapa['entradaCompra'] - $invTapa['entradaCambio'] + $invTapa['salidaProduccion'] + $invTapa['salidaEnvasadoDist'] + $invTapa['salidaJabones'] + $invTapa['salidaCambios']);
	$spreadsheet->getActiveSheet()->setCellValue([7, $j++], $invTapa['preTapa']);
}
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inv_Tap_Fecha.xlsx"');
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








