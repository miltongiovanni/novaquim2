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
							 ->setDescription("Lista de Facturas por per�odo")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'Fecha')
            ->setCellValue('B1', iconv("iso-8859-1", "UTF-8",'C�digo'))
			->setCellValue('C1', 'Producto')
			->setCellValue('D1', 'Cantidad')
			->setCellValue('E1', 'Precio sin Iva');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Ventas por Referencia');
$link=conectarServidor();
$bd="novaquim";
$sql="	select fechaFactura, Cod_producto, Nombre, SUM(Can_producto) as Cantidad, prec_producto 
from factura, det_factura, prodpre 
where Factura=Id_fact and Cod_producto=Cod_prese and fechaFactura>='$FchIni' and fechaFactura<'$FchFin' group BY Cod_producto;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Fech_fact']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, iconv("iso-8859-1", "UTF-8",$row['Cod_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i,iconv("iso-8859-1", "UTF-8", $row['Nombre']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, iconv("iso-8859-1", "UTF-8",$row['Cantidad']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i++,iconv("iso-8859-1", "UTF-8", $row['prec_producto']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Ventas_Referencia.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
exit;
?>








