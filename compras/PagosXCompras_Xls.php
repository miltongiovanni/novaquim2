<?php
include "includes/conect.php";
/** Error reporting */
error_reporting(E_ALL);
/** PHPExcel */
require_once 'Classes/PHPExcel.php';

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Industrias Novaquim")
							 ->setLastModifiedBy("Milton Espitia")
							 ->setTitle("Productos")
							 ->setSubject("Lista de Facturas")
							 ->setDescription("Lista de Facturas por período")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Id Compra')
			->setCellValue('B1', 'Nit Proveedor')
			->setCellValue('C1', 'Proveedor')
			->setCellValue('D1', 'No. Factura')
			->setCellValue('E1', 'Fecha Compra')
			->setCellValue('F1', 'Total')
			->setCellValue('G1', 'Valor Pagado')
			->setCellValue('H1', 'Fecha Vencimiento')
			->setCellValue('I1', iconv("iso-8859-1", "UTF-8",'Fecha Cancelación'));
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Lista de Facturas');
$link=conectarServidor();
$sql="select Id_egreso as Id, nit_prov as Nit, Nom_provee as Proveedor, numFact as Factura, totalCompra as Total, pago as 'Valor Pagado', fechComp as 'Fecha Compra', fechVenc as 'Fecha Vencimiento', Fecha 
from egreso, compras, proveedores 
WHERE egreso.Id_compra=compras.idCompra and nit_prov=nitProv AND compras.tipoCompra <6 and Fecha>='$FchIni' and Fecha<='$FchFin' order by Id DESC;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Id']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Nit']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Proveedor']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Factura']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Fecha Compra']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['Total']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['Valor Pagado']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['Fecha Vencimiento']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i++, iconv("iso-8859-1", "UTF-8",$row['Fecha']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Pago_fac_compra.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








