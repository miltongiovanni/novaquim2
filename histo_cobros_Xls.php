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
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8", 'Id Pago'))
			->setCellValue('B1', iconv("iso-8859-1", "UTF-8", 'Factura'))
			->setCellValue('C1', iconv("iso-8859-1", "UTF-8", 'Cliente'))
			->setCellValue('D1', iconv("iso-8859-1", "UTF-8", 'Cobro'))
			->setCellValue('E1', iconv("iso-8859-1", "UTF-8", 'Fecha de Pago'))
			->setCellValue('F1', iconv("iso-8859-1", "UTF-8", 'Forma de Pago'));
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Historia de Pagos');
$link=conectarServidor();
$sql="select Id_caja as 'Id', Fact as Factura, Nom_clien as Cliente, CONCAT('$ ', FORMAT(cobro,0)) as Pagos, Fecha, forma_pago as 'Forma de Pago' 
from r_caja, factura, clientes, form_pago where Fact=Factura and Nit_cliente=Nit_clien and form_pago=Id_fpago and Fecha>='$FchIni' and Fecha<='$FchFin' order by Id DESC";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Id']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Factura']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Cliente']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,$row['Pagos']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Fecha']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i++, iconv("iso-8859-1", "UTF-8",$row['Forma de Pago']));
} 
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Histo_cobros.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>








