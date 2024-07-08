<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

function cargarClases($classname)
{
require '../../../clases/'.$classname.'.php';
}
spl_autoload_register('cargarClases');
$idCliente = $_POST['idCliente'];
$nomCliente = $_POST['nomCliente'];
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
			->setCellValue('A1', 'Factura')
			->setCellValue('B1', 'Fecha factura')
			->setCellValue('C1', 'Fecha vencimiento')
			->setCellValue('D1', 'Subtotal')
			->setCellValue('E1', 'Reteiva')
			->setCellValue('F1', 'Reteica')
			->setCellValue('G1', 'Retefuente')
			->setCellValue('H1', 'Iva')
			->setCellValue('I1', 'Total')
			->setCellValue('J1', 'VCobrar')
			->setCellValue('K1', 'Abonos')
			->setCellValue('L1', 'Saldo');
// Rename sheet
$spreadsheet->getActiveSheet()->setTitle($nomCliente);
$RecCajaOperador = new RecCajaOperaciones();

$detalle = $RecCajaOperador->getDetalleFacturasAccClienteXcobrar($idCliente);
$j=2;
for($i=0;$i<count($detalle);$i++){
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $j, $detalle[$i]['idFactura']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $j, $detalle[$i]['fechaFactura']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $j, $detalle[$i]['fechaVenc']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4, $j, $detalle[$i]['SubtotalFormat']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(5, $j, $detalle[$i]['retencionIvaFormat']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $j, $detalle[$i]['retencionIcaFormat']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(7, $j, $detalle[$i]['retencionFteFormat']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(8, $j, $detalle[$i]['ivaFormat']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(9, $j, $detalle[$i]['TotalFormat']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(10, $j, $detalle[$i]['totalRFormat']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(11, $j, $detalle[$i]['cobradoFormat']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(12, $j++, $detalle[$i]['saldo']);
}
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Cartera acumulada '.$nomCliente.'.xlsx"');
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








