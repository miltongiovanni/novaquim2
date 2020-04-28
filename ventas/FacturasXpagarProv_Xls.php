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
							 ->setSubject("Facturas X Pagar")
							 ->setDescription("Facturas por período")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'Factura')
			->setCellValue('B1', 'Proveedor')
			->setCellValue('C1', 'Fecha Factura')
			->setCellValue('D1', 'Fecha Vencimiento')
            ->setCellValue('E1', 'Valor Factura')
			->setCellValue('F1', iconv("iso-8859-1", "UTF-8",'Retención'))
			->setCellValue('G1', 'Valor a Pagar')
			->setCellValue('H1', 'Valor Pagado')
			->setCellValue('I1', 'Retecree')
			->setCellValue('J1', 'Saldo');
// Rename sheet

$objPHPExcel->getActiveSheet()->setTitle(iconv("iso-8859-1", "UTF-8",'Facturas por Pagar'));
$link=conectarServidor();
$bd="novaquim";
$sql="	select idCompra as Id, Compra, nit_prov as Nit, Num_fact as Factura, Fech_comp, Subtotal, 
				Fech_venc, total_fact as Total, nomProv as Proveedor, retencion, imp_cree 
				FROM compras, proveedores where estado=3 and nit_prov=NIT_provee and nit_prov='$Proveedor'
				union
				select Id_gasto as Id, Compra, nit_prov as Nit, Num_fact as Factura, Fech_comp, Subtotal_gasto as Subtotal,
				Fech_venc, total_fact as Total, nomProv as Proveedor, retencion_g as retencion, imp_cree 
				from gastos, proveedores where estado=3 and nit_prov=NIT_provee and nit_prov='$Proveedor' order by Fech_venc;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
//$columnas=mysql_num_fields($result);
//$filas = mysql_num_rows($result);
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Factura']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, iconv("iso-8859-1", "UTF-8",$row['Proveedor']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8", $row['Fech_comp']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, iconv("iso-8859-1", "UTF-8",$row['Fech_venc']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Total']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, iconv("iso-8859-1", "UTF-8",$row['retencion']));
	
	$id_compra=$row['Id'];
	$compra=$row['Compra'];
	$factura=$row['Factura'];
	$fecVen=$row['Fech_venc'];
	$fact=$row['Factura'];
	$retencion=$row['retencion'];
	$imp_cree=$row['imp_cree'];
	$ValTot=$row['Total'];
	$ValPag=$ValTot-$retencion;
	$qry1="select sum(pago) as Parcial from egreso where Id_compra=$id_compra and tip_compra=$compra";
	$resultpago=mysqli_query($link,$qry1);
	$rowpag=mysqli_fetch_array($resultpago);
	if($rowpag['Parcial'])
		$parcial=$rowpag['Parcial'];
	else
		$parcial=0;
	$saldo=$ValPag-$parcial;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",($row['Total']-$row['retencion'])));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, iconv("iso-8859-1", "UTF-8",$parcial));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['imp_cree']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i++, iconv("iso-8859-1", "UTF-8",$saldo));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="FactXPagar.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>








