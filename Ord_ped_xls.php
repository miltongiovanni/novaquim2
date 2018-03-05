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
$sql1="Select nom_clien, Id_pedido, Fech_pedido, Fech_entrega, Cod_vend, nom_personal, tipo_precio, pedido.Estado, Nom_sucursal, Dir_sucursal, Tel_sucursal
		FROM pedido, personal, clientes, tip_precio, clientes_sucursal 
		where Cod_vend=Id_personal and Id_pedido=$pedido and clientes.nit_clien=nit_cliente and Id_precio=tip_precio and Id_sucurs=Id_sucursal and clientes_sucursal.Nit_clien=Nit_cliente";
$result1=mysqli_query($link,$sql1) or die("Error al conectar a la base de datos.");
$row1= mysqli_fetch_array($result1, MYSQLI_BOTH);
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
			->setCellValue('A1', 'Cliente')
			->setCellValue('B1', iconv("iso-8859-1", "UTF-8",$row1['nom_clien']))
			->setCellValue('A2', 'Lugar de entrega')
			->setCellValue('B2', iconv("iso-8859-1", "UTF-8",$row1['Nom_sucursal']))
			->setCellValue('A3', iconv("iso-8859-1", "UTF-8",'Dirección de entrega'))
			->setCellValue('B3', iconv("iso-8859-1", "UTF-8",$row1['Dir_sucursal']))
			->setCellValue('C1', 'Pedido')
			->setCellValue('D1', iconv("iso-8859-1", "UTF-8",$row1['Id_pedido']))
			->setCellValue('C2', 'Fecha')
			->setCellValue('D2', iconv("iso-8859-1", "UTF-8",$row1['Fech_pedido']))
			->setCellValue('C3', iconv("iso-8859-1", "UTF-8",'Teléfono'))
			->setCellValue('D3', iconv("iso-8859-1", "UTF-8",$row1['Tel_sucursal']))

            ->setCellValue('A5', 'Cod Producto')
			->setCellValue('B5', 'Producto')
			->setCellValue('C5', 'Cantidad')
			->setCellValue('D5', 'Precio')
			->setCellValue('E5', 'Tasa Iva');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Pedido '."$pedido");

$sql="select Cod_producto, Can_producto, Nombre as Producto, Prec_producto, 0.19 as tasa 
from det_pedido, prodpre, pedido 
where Cod_producto=Cod_prese and det_pedido.Id_Ped=$pedido and det_pedido.Id_ped=pedido.Id_pedido order by Nombre;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=6;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Cod_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Can_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Prec_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i++, iconv("iso-8859-1", "UTF-8",$row['tasa']));
} 
$sql="select Cod_producto, Can_producto, Producto, Prec_producto, tasa 
from det_pedido, distribucion, pedido, tasa_iva 
where Cod_producto=Id_distribucion and det_pedido.Id_Ped=$pedido and det_pedido.Id_ped=pedido.Id_pedido and Cod_iva=Id_tasa order by Producto;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Cod_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Can_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Prec_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i++, iconv("iso-8859-1", "UTF-8",$row['tasa']));
} 
$sql="select Cod_producto, DesServicio as Producto, Can_producto, Prec_producto, tasa  
from det_pedido, servicios, pedido, tasa_iva  
where Cod_producto=IdServicio and Id_ped=Id_pedido and Id_ped=$pedido and Cod_iva=Id_tasa order by DesServicio;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
while($row= mysqli_fetch_array($result, MYSQIL_BOTH))
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
header('Content-Disposition: attachment;filename="Pedido '."$pedido".'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








