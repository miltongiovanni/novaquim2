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
            ->setCellValue('A1', 'Cod Producto')
			->setCellValue('B1', 'Producto')
			->setCellValue('C1', 'Cantidad')
			->setCellValue('D1', 'Precio')
			->setCellValue('E1', 'Tasa Iva');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Cotizacion Personalizada');
$link=conectarServidor();
$sql="select Cod_producto, Can_producto, Nombre as Producto, Prec_producto, 0.16 as tasa
from det_cot_personalizada, prodpre where Cod_producto=Cod_prese and Id_cot_per=$cotizacion order by Nombre;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Cod_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Can_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Prec_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i++, iconv("iso-8859-1", "UTF-8",$row['tasa']));
} 
$sql="select Cod_producto, Can_producto, Producto, Prec_producto, tasa
from det_cot_personalizada, distribucion, tasa_iva where Cod_producto=Id_distribucion and Id_cot_per=$cotizacion and Cod_iva=Id_tasa order by Producto";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Cod_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Can_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Prec_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i++, iconv("iso-8859-1", "UTF-8",$row['tasa']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Cot_personalizada.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








