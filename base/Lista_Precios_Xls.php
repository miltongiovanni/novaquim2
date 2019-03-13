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
			->setCellValue('A1', iconv("iso-8859-1", "UTF-8",'Código'))
			->setCellValue('B1', iconv("iso-8859-1", "UTF-8",'Presentación de producto'))
			->setCellValue('C1', iconv("iso-8859-1", "UTF-8",'Super'))
			->setCellValue('D1', iconv("iso-8859-1", "UTF-8",'Fábrica'))
			->setCellValue('E1', iconv("iso-8859-1", "UTF-8",'Mayorista'))
			->setCellValue('F1', iconv("iso-8859-1", "UTF-8",'Distribuidor'))
			->setCellValue('G1', iconv("iso-8859-1", "UTF-8",'Detal'));
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Precios');
$link=conectarServidor();
$sql="	select codigo_ant, producto, fabrica, distribuidor, detal, mayor, super, cant_medida, Cod_produc
from precios, (select DISTINCTROW Cod_ant, cant_medida, Cod_produc from prodpre, precios, medida where Cod_ant=codigo_ant and Cod_umedid=Id_medida and pres_activa=0 and pres_lista=0 group by Cod_ant) as tabla 
where pres_activa=0 and codigo_ant=Cod_ant order by Cod_produc,  cant_medida";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$columnas=mysqli_num_fields($result);
$filas = mysqli_num_rows($result);
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['codigo_ant']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['super']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, iconv("iso-8859-1", "UTF-8",$row['fabrica']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i,iconv("iso-8859-1", "UTF-8", $row['mayor']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, iconv("iso-8859-1", "UTF-8",$row['distribuidor']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i++, iconv("iso-8859-1", "UTF-8",$row['detal']));
} 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Lista de Precios.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








