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
            ->setCellValue('A1', 'Id Gasto')
			->setCellValue('B1', 'Nit Proveedor')
			->setCellValue('C1', 'Proveedor')
			->setCellValue('D1', 'No. Factura')
			->setCellValue('E1', 'Fecha Compra')
			->setCellValue('F1', 'Total')
			->setCellValue('G1', 'Producto')
			->setCellValue('H1', 'Cantidad')
			->setCellValue('I1', 'Precio')
			->setCellValue('J1', 'Tasa');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Lista de Facturas');
$link=conectarServidor();
$sql="	select gastos.Id_gasto as Id, nit_prov, Nom_provee, Num_fact, Fech_comp, total_fact, Producto, Cant_gasto, Precio_gasto, tasa 
from gastos, proveedores, det_gastos, tasa_iva 
where Fech_comp>='$FchIni' and Fech_comp<='$FchFin' and nit_prov=nitProv and gastos.Id_gasto=det_gastos.Id_gasto AND det_gastos.Id_tasa=tasa_iva.Id_tasa;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
//$columnas=mysql_num_fields($result);
//$filas = mysql_num_rows($result);
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Id']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['nit_prov']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Nom_provee']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Num_fact']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Fech_comp']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['total_fact']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['Cant_gasto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['Precio_gasto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i++, iconv("iso-8859-1", "UTF-8",$row['tasa']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Gastos.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>








