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
	$seleccion = explode(",", $pedidos);

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Industrias Novaquim")
							 ->setLastModifiedBy("Milton Espitia")
							 ->setTitle("Lista Necesidades")
							 ->setSubject("Lista de Compras")
							 ->setDescription("Lista de Compras para pedidos")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8","Código"))
			->setCellValue('B1', 'Producto')
			->setCellValue('C1', 'Cantidad')
			->setCellValue('D1', 'Precio');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Necesidades Inv');
$link=conectarServidor();
$i=2;

$qry_prod="SELECT Cod_producto, SUM(Can_producto) as Cantidad, Nombre as Producto, Prec_producto from det_pedido, prodpre where Cod_producto=Cod_prese and Cod_producto <100000 and (";
$a=count($seleccion);
for ($j = 0; $j < $a; $j++) 
{
	$qry_prod=$qry_prod."Id_Ped=".($seleccion[$j]);
	if ($j<=($a-2))
		$qry_prod=$qry_prod." or ";	
} 
$qry_prod=$qry_prod.") group by Cod_producto order by Producto";
$result_prod=mysqli_query($link,$qry_prod);	
while($row_prod=mysqli_fetch_array($result_prod, MYSQLI_BOTH))
{
	$cod=$row_prod['Cod_producto'];
	$cantidad=$row_prod['Cantidad'];
	$qrybus="select Cod_prese as Codigo, SUM(inv_prod) as Inventario from inv_prod WHERE Cod_prese=$cod group by Cod_prese;";
	$resultbus=mysqli_query($link,$qrybus);
	$rowbus=mysqli_fetch_array($resultbus);
	if ($rowbus)
	{
	  if($rowbus['Inventario'] < $cantidad)
	  {
		  $cantidad=$cantidad- $rowbus['Inventario'];
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row_prod['Cod_producto']));
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row_prod['Producto']));
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$cantidad));
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i++,iconv("iso-8859-1", "UTF-8", $row_prod['Prec_producto']));
	  }
	}
	else
	{
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row_prod['Cod_producto']));
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row_prod['Producto']));
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$cantidad));
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i++,iconv("iso-8859-1", "UTF-8", $row_prod['Prec_producto']));
	}
}
//PRODCUTOS DE DISTRIBUCION
$qry_dist="select Cod_producto, sum(Can_producto) as Cantidad, Producto, Prec_producto from det_pedido, distribucion where Cod_producto=Id_distribucion and Cod_producto >=100000 and (";
for ($j = 0; $j < $a; $j++) 
{
	$qry_dist=$qry_dist."Id_Ped=".($seleccion[$j]);
	if ($j<=($a-2))
		$qry_dist=$qry_dist." or ";	
} 
$qry_dist=$qry_dist.") group by Cod_producto order by Producto";
$result_dist=mysqli_query($link,$qry_dist);	
while($row_dist=mysqli_fetch_array($result_dist, MYSQLI_BOTH))
{
	$cod=$row_dist['Cod_producto'];
	$cantidad=$row_dist['Cantidad'];	
	$qrybus="SELECT codDistribucion AS Codigo, invDistribucion as Inventario from inv_distribucion WHERE codDistribucion=$cod;";
	$resultbus=mysqli_query($link,$qrybus);
	$rowbus=mysqli_fetch_array($resultbus);
	if ($rowbus)
	{
		if($rowbus['Inventario'] < $cantidad)
		{
		  $cantidad=$cantidad- $rowbus['Inventario'];
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row_dist['Cod_producto']));
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row_dist['Producto']));
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$cantidad));
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i++,iconv("iso-8859-1", "UTF-8", $row_dist['Prec_producto']/1.2));
		}
	}
	else
	{
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row_dist['Cod_producto']));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row_dist['Producto']));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$cantidad));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i++,iconv("iso-8859-1", "UTF-8", $row_dist['Prec_producto']/1.2));
	}
}
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="List_compras.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








