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
$link=conectarServidor();
$qrybus="select Nom_clien from clientes where Nit_clien='$cliente'";
$resultbus=mysqli_query($link,$qrybus);
$rowbus=mysqli_fetch_array($resultbus);
$nombre=$rowbus['Nom_clien'];
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
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8",'ESTADO DE CUENTA DE '.strtoupper($nombre)))
			->setCellValue('A2', 'Factura')
			->setCellValue('B2', 'Fecha Factura')
			->setCellValue('C2', 'Fecha Vencimiento')
			->setCellValue('D2', 'Total')
			->setCellValue('E2', 'Valor a Cobrar')
			->setCellValue('F2', 'Saldo')
			->setCellValue('G2', iconv("iso-8859-1", "UTF-8",'Fecha Cancelaci�n'))
			->setCellValue('H2', 'Estado');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Estado de cuenta');

$sql="select Factura, Fech_fact, Fech_venc, Total, (Total-Reten_iva-Reten_ica-Reten_fte) as 'Valor a Cobrar', (Total-Reten_iva-Reten_ica-Reten_fte-(select SUM(cobro) from r_caja where Fact=Factura group by Fact)) as 'Saldo', Fech_Canc, Estado 
from factura where Nit_cliente='$cliente' ORDER BY Factura desc;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=3;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	if ($row['Estado']=='C')
		$estado='Cancelada';
	if ($row['Estado']=='P')
	  	$estado='Pendiente';
	if ($row['Estado']=='A')
	 	$estado='Anulada';
	if ($row['Saldo']==NULL)
	 		$saldo=$row['Valor a Cobrar'];
	else	$saldo=$row['Saldo'];
	if ($row['Fech_Canc']!='0000-00-00')
	 	$cancel=$row['Fech_Canc'];
	else
		$cancel="";
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Factura']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Fech_fact']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Fech_venc']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Total']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Valor a Cobrar']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $saldo));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$cancel));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i++,iconv("iso-8859-1", "UTF-8", $estado));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="EstadoCuenta'.$nombre.'.xls"');
header('Cache-Control: max-age=0');
mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>







