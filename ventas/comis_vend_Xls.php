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
$bd="novaquim";
$qrybus="select nom_personal from personal where Id_personal=$vendedor;";
$resultbus=mysqli_query($link,$qrybus);
$rowbus=mysqli_fetch_array($resultbus);
$nombre=$rowbus['nom_personal'];
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
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8",'CONSULTA DE COMISIONES DEL VENDEDOR '.strtoupper($nombre)))
			->setCellValue('A2', 'Factura')
			->setCellValue('B2', 'Cliente')
			->setCellValue('C2', '% Desc')
			->setCellValue('D2', 'Fech Canc')
			->setCellValue('E2', 'Total')
			->setCellValue('F2', 'Subtotal')
			->setCellValue('G2', iconv("iso-8859-1", "UTF-8",'Vtas Nova'))
			->setCellValue('H2', 'Vtas Dist')
			->setCellValue('I2', 'Com Nova')
			->setCellValue('J2', 'Com Dist')
			->setCellValue('K2', 'Com Total');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Comisiones');

$sql="select Factura, nomCliente, Descuento, Total, Subtotal, IVA, fechaCancelacion, sum(empresa) as nova, sum(distribucion) as dis, sum(empresa*com_nova) as com_nova, sum(distribucion*com_dist) as com_dist, (sum(empresa*com_nova)+sum(distribucion*com_dist)) as com_tot from
(select Factura, nomCliente, Descuento, Total, retencionIva, retencionIca, retencionFte, Subtotal, IVA, fechaCancelacion, sum(Can_producto*prec_producto*(1-Descuento)) as empresa, 0 as distribucion, com_dist, com_nova 
from factura, det_factura, clientes, personal where nitCliente=Nit_cliente and codVendedor=$vendedor and fechaCancelacion>='$FchIni' and fechaCancelacion<='$FchFin' and Factura=Id_fact and Cod_producto<100000 AND codVendedor=Id_personal group by Factura
union
select Factura, nomCliente, Descuento, Total, retencionIva, retencionIca, retencionFte, Subtotal, IVA, fechaCancelacion, 0 as empresa, sum(Can_producto*prec_producto*(1-Descuento)) as distribucion, com_dist, com_nova 
from factura, det_factura, clientes, personal where nitCliente=Nit_cliente and codVendedor=$vendedor and fechaCancelacion>='$FchIni' and fechaCancelacion<='$FchFin' and Factura=Id_fact and Cod_producto>100000 AND codVendedor=Id_personal group by Factura) as tabla group by Factura;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=3;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Factura']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Nom_clien']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Descuento']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Fech_Canc']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Total']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['Subtotal']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['nova']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['dis']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['com_nova']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i,iconv("iso-8859-1", "UTF-8", $row['com_dist']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $i++, iconv("iso-8859-1", "UTF-8",$row['com_tot']));

} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Comisiones '.$nombre.'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








