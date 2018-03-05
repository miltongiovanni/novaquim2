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
            ->setCellValue('A1', 'No. Factura')
			->setCellValue('B1', 'Total')
			->setCellValue('C1', 'Valor Pagado')
			->setCellValue('D1', 'Fecha Compra')
			->setCellValue('E1', 'Fecha Vencimiento')
			->setCellValue('F1', iconv("iso-8859-1", "UTF-8",'Fecha Cancelaci�n'))
			->setCellValue('G1', 'Forma de Pago');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Lista de Facturas');
$link=conectarServidor();
$sql="SELECT Num_fact as Factura, total_fact as Total, pago as 'Valor Pagado', Fech_comp as 'Fecha Compra', Fech_venc as 'Fecha Vencimiento', Fecha as 'Fecha Canc', forma_pago as 'Forma de Pago' from (select Id_egreso as Id, nit_prov as Nit, Nom_provee as Proveedor, Num_fact, total_fact, pago, Fech_comp, Fech_venc, Fecha, forma_pago from egreso, compras, proveedores, form_pago WHERE egreso.Id_compra=compras.Id_compra and nit_prov=NIT_provee and tip_compra<6 and form_pago=Id_fpago order by Id DESC) as tabla where Nit='$prov';";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Factura']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Total']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Valor Pagado']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Fecha Compra']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Fecha Vencimiento']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['Fecha Canc']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i++, iconv("iso-8859-1", "UTF-8",$row['Forma de Pago']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Pago_fac_compra_'.$nprov.'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
exit;
?>








