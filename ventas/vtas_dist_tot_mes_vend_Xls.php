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

$i=1;
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Industrias Novaquim")
							 ->setLastModifiedBy("Milton Espitia")
							 ->setTitle("Productos")
							 ->setSubject("Ventas por familia")
							 ->setDescription("Historico ventas familia")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', iconv("iso-8859-1", "UTF-8",'Código'))
            ->setCellValue('B1', 'Producto')
			->setCellValue('C1', 'Venta Mes'.$i++)
			->setCellValue('E1', 'Venta Mes'.$i++)
			->setCellValue('G1', 'Venta Mes'.$i++)
			->setCellValue('I1', 'Venta Mes'.$i++)
			->setCellValue('K1', 'Venta Mes'.$i++)
			->setCellValue('M1', 'Venta Mes'.$i++)
			->setCellValue('O1', 'Venta Mes'.$i++)
			->setCellValue('Q1', 'Venta Mes'.$i++)
			->setCellValue('S1', 'Venta Mes'.$i++)
			->setCellValue('U1', 'Venta Mes'.$i++)
			->setCellValue('W1', 'Venta Mes'.$i++)
			->setCellValue('Y1', 'Venta Mes'.$i++)
			->setCellValue('C2', 'Un')
			->setCellValue('D2', 'Total')
			->setCellValue('E2', 'Un')
			->setCellValue('F2', 'Total')
			->setCellValue('G2', 'Un')
			->setCellValue('H2', 'Total')
			->setCellValue('I2', 'Un')
			->setCellValue('J2', 'Total')
			->setCellValue('K2', 'Un')
			->setCellValue('L2', 'Total')
			->setCellValue('M2', 'Un')
			->setCellValue('N2', 'Total')
			->setCellValue('O2', 'Un')
			->setCellValue('P2', 'Total')
			->setCellValue('Q2', 'Un')
			->setCellValue('R2', 'Total')
			->setCellValue('S2', 'Un')
			->setCellValue('T2', 'Total')
			->setCellValue('U2', 'Un')
			->setCellValue('V2', 'Total')
			->setCellValue('W2', 'Un')
			->setCellValue('X2', 'Total')
			->setCellValue('Y2', 'Un')
			->setCellValue('Z2', 'Total');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle(iconv("iso-8859-1", "UTF-8",'Ventas Compras Dist  por Mes'));
$link=conectarServidor();
$fecha2=explode('-', $FchFin);
$fecha1=explode('-', $FchIni);
$mes1=$fecha1[1];
$mes2=$fecha2[1];
$meses=$fecha2[1]-$fecha1[1];
//parametros iniciales que son los que cambiamos
$link=conectarServidor();
//sentencia SQL    tblusuarios.IdUsuario,
$sql="select Id_cat_dist, Des_cat_dist from cat_dist;";
$result=mysqli_query($link,$sql);
$i=3;

while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{	
	$j=0;
	$Id_cat_dist=$row['Id_cat_dist'];
	$producto=$row['Des_cat_dist'];
	$mes=$fecha1[1];
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j++, $i, iconv("iso-8859-1", "UTF-8",$Id_cat_dist));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j++, $i, iconv("iso-8859-1", "UTF-8",$producto));
	for ($b=$mes1; $b<=$mes2; $b++)
	{
	  $sqlv="select sum(Can_producto) as cant, sum(prec_producto*Can_producto) as sub 
from det_factura, factura, distribucion, cat_dist, clientes  
where Factura=Id_fact and  fechaFactura>='$FchIni' and fechaFactura<='$FchFin' and Id_distribucion=Cod_producto and distribucion.Id_Cat_dist=cat_dist.Id_Cat_dist and month(fechaFactura)=$b and cat_dist.Id_cat_dist=$Id_cat_dist and Nit_cliente=nitCliente and codVendedor=$vendedor";
	  $resultv=mysqli_query($link,$sqlv);
	  $rowv=mysqli_fetch_array($resultv, MYSQLI_BOTH);
	  $cant=$rowv['cant'];
	  $sub=$rowv['sub'];
	  if ($cant==NULL)
	  {
	    $cant=0;
		$sub=0;
	  }
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j++, $i,iconv("iso-8859-1", "UTF-8", $cant));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j++, $i, iconv("iso-8859-1", "UTF-8",$sub));
	}
	$i++;
	
}
mysqli_free_result($result);
mysqli_free_result($resultv);
/* cerrar la conexión */
mysqli_close($link);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="VtasFamDistMes.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>








