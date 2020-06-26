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
            ->setCellValue('A1', 'Codigo')
			->setCellValue('B1', 'Envase')
			->setCellValue('C1', 'Costo')
			->setCellValue('D1', 'Cantidad')
			->setCellValue('E1', 'Entrada')
			->setCellValue('F1', 'Salida');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Inventario Env Fch');
$link=conectarServidor();
$sql="SELECT inv_tapas_val.codTapa as Codigo, Nom_tapa as Producto, invTapa as Cantidad, Pre_tapa from inv_tapas_val, tapas_val where inv_tapas_val.codTapa=tapas_val.Cod_tapa;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$prod=$row['Codigo'];
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Codigo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Pre_tapa']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Cantidad']));
	
	//ENTRADA POR COMPRAS
  $sqle1="select sum(Cantidad) as entrada1 from compras, det_compras where tipoCompra=2 and compras.Id_compra=det_compras.idCompra and Fech_comp>='$Fch' and Codigo=$prod;";
  $resulte1=mysqli_query($link,$sqle1);
  $rowe1=mysqli_fetch_array($resulte1, MYSQLI_BOTH);
  if($rowe1['entrada1']==NULL)
	  $entrada1=0;
  else
	  $entrada1=$rowe1['entrada1'];
 //ENTRADA POR CAMBIO DE PRESENTACIÓN
  $sqle2="SELECT SUM(cantPresentacionNvo) as entrada2 from cambios, det_cambios2, prodpre where det_cambios2.idCambio=cambios.idCambio and fechaCambio >='$Fch' and codPresentacionNvo=Cod_prese and Cod_tapa=$prod;";
  $resulte2=mysqli_query($link,$sqle2);
  $rowe2=mysqli_fetch_array($resulte2, MYSQLI_BOTH);
  if($rowe2['entrada2']==NULL)
	  $entrada2=0;
  else
	  $entrada2=$rowe2['entrada2'];
	//ENTRADA POR DESARMADO DE KITS  
  $entrada=$entrada1+ $entrada2 ;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $entrada);
	//SALIDA POR ENVASADO
 	$sqls1="SELECT sum(cantPresentacion) as salida1  from envasado, ord_prod, prodpre where fechProd>'$Fch' and envasado.Lote=ord_prod.Lote and Cod_prese=Con_prese and Cod_envase=$prod;";
	$results1=mysqli_query($link,$sqls1);
	$rows1=mysqli_fetch_array($results1, MYSQLI_BOTH);
	if($rows1['salida1']==NULL)
		$salida1=0;
	else
		$salida1=$rows1['salida1'];
	//SALIDA POR ENVASADO DE PRODUCTOS DE DISTRIBUCION
	$sqls2="select sum(Cantidad) as salida2 from det_env_dist, rel_dist_mp where Fch_env_dist>'$Fch' and det_env_dist.Cod_dist=rel_dist_mp.Cod_dist and Cod_envase=$prod;";	
	$results2=mysqli_query($link,$sqls2);
	$rows2=mysqli_fetch_array($results2, MYSQLI_BOTH);
	if($rows2['salida2']==NULL)
		$salida2=0;
	else
		$salida2=$rows2['salida2'];
	//SALIDA POR ARMADO DE KITS
    $sqls3="select sum(cantArmado) as salida3 FROM arm_kit, kit where codKit=kit.Id_kit and fechArmado>'$Fch' AND Cod_env=$prod;";
	$results3=mysqli_query($link,$sqls3);
	$rows3=mysqli_fetch_array($results3, MYSQLI_BOTH);
	if($rows3['salida3']==NULL)
		$salida3=0;
	else
		$salida3=$rows3['salida3'];
	//SALIDA POR VENTA DE JABÓN
	$sqls4="SELECT sum(cantidad) as salida4 from 
	(select sum(Can_producto) as cantidad from remision, det_remision, prodpre 
	where remision.Id_remision=det_remision.Id_remision and Fech_remision>'$Fch' and Cod_producto=Cod_prese and Cod_produc>=504 and Cod_produc<=514 and Cod_envase=$prod
	union
	select sum(Can_producto) as cantidad from remision1, det_remision1, prodpre 
	where remision1.Id_remision=det_remision1.Id_remision and Fech_remision>'$Fch' and Cod_producto=Cod_prese and Cod_produc>=504 and Cod_produc<=514 and Cod_envase=$prod ) as matriz;";	
	$results4=mysqli_query($link,$sqls4);
	$rows4=mysqli_fetch_array($results4, MYSQLI_BOTH);
	if($rows4['salida4']==NULL)
		$salida4=0;
	else
		$salida4=$rows4['salida4'];
	//SALIDA POR REENVASE DE PRODUCTO
	$sqls5="SELECT SUM(cantPresentacionAnt) as salida5 from cambios, det_cambios, prodpre where det_cambios.idCambio=cambios.idCambio and fechaCambio >='$Fch' and codPresentacionAnt=Cod_prese and Cod_tapa=$prod;";
	$results5=mysqli_query($link,$sqls5);
	$rows5=mysqli_fetch_array($results5, MYSQLI_BOTH);
	if($rows5['salida5']==NULL)
		$salida5=0;
	else
		$salida5=$rows5['salida5'];
	$salida=$salida1 + $salida2 + $salida3+$salida4+$salida5;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i++, $salida);
} 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Inv_Tap_Fch.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
mysqli_free_result($resulte1);
mysqli_free_result($resulte2);
mysqli_free_result($results1);
mysqli_free_result($results2);
mysqli_free_result($results3);
mysqli_free_result($results4);
mysqli_free_result($results5);
mysqli_close($link);//Cerrar la conexion
exit;
?>








