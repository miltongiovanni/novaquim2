<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<title>Actualización</title>
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
  //echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}  
$bd="novaquim";

$link=conectarServidor();
$valida=1;
//$result=mysql_db_query($bd,$qryinv);
if ($producto < 100000)
{
  if($cant_ant>$cantidad)
  {
	$qryr="select codProducto, cantProducto, loteProducto from det_remision1 where idRemision=$remision and codProducto=$producto order by loteProducto desc;";
	$devolucion=$cant_ant-$cantidad;
	$resultr=mysqli_query($link,$qryr);
	while(($rowr=mysqli_fetch_array($resultr))||($devolucion!=0))
	{
	  $Cod_producto=$rowr['Cod_producto'];
	  $Can_producto=$rowr['Can_producto'];
	  $Lote_producto=$rowr['Lote_producto'];
	  $qryinv="select invProd from inv_prod where loteProd=$Lote_producto and codPresentacion=$Cod_producto";
	  $resultinv=mysqli_query($link,$qryinv);
	  $rowinv=mysqli_fetch_array($resultinv);
	  $inv_actual=$rowinv['inv_prod'];
	  if ($Can_producto>=$devolucion)
	  {
		$inv_entra=$devolucion;
		$devolucion=0;
		$inv_final= $inv_actual + $inv_entra;
		$qrys="update inv_prod set invProd=$inv_final where loteProd=$Lote_producto and codPresentacion=$Cod_producto";
		$results=mysqli_query($link,$qrys);
		$ajuste=$Can_producto-$inv_entra;
		$qryd="update det_remision1 set cantProducto=$ajuste where idRemision=$remision and codProducto=$producto and loteProducto=$Lote_producto";
		$resultd=mysqli_query($link,$qryd);
		$valida=0;
	  }
	  else
	  {
		$inv_entra=$Can_producto;
		$devolucion=$devolucion-$Can_producto;
		$inv_final=$inv_actual+$inv_entra;
		$qrys="update inv_prod set invProd=$inv_final where loteProd=$Lote_producto and codPresentacion=$Cod_producto";
		$results=mysqli_query($link,$qrys);
		$qryd="delete from det_remision1 where idRemision=$remision and codProducto=$producto and loteProducto=$Lote_producto";
		$resultd=mysqli_query($link,$qryd);
	  }
	}
  }
  else
  {
	$qryinv="select invProd, loteProd from inv_prod where codPresentacion=$producto and invProd>0";
	$resultinv=mysqli_query($link,$qryinv);
	$entrada=$cantidad-$cant_ant;
	while(($rowinv=mysqli_fetch_array($resultinv))&&($entrada!=0))
	{
	  $inv_actual=$rowinv['inv_prod'];
	  $lote_actual=$rowinv['lote_prod'];
	  if ($inv_actual>=$entrada)
	  {
		$inv_final=$inv_actual-$entrada;
		$qryr="select codProducto, cantProducto, loteProducto from det_remision1 where idRemision=$remision and codProducto=$producto and loteProducto=$lote_actual";
		$resultr=mysqli_query($link,$qryr);
		if($rowr=mysqli_fetch_array($resultr))
		{
		  $cant_actual=$rowr['Can_producto'];
		  $cant_final=$cant_actual+$entrada;
		  $qryd="update det_remision1 set cantProducto=$cant_final where idRemision=$remision and codProducto=$producto and loteProducto=$lote_actual";
		  $resultd=mysqli_query($link,$qryd);
		  $valida=0;
		}
		else
		{
		  $qryd="insert into det_remision1 (idRemision, codProducto, cantProducto, loteProducto) values($remision, $producto, $entrada, $lote_actual)";
		  $resultd=mysqli_query($link,$qryd);
		  $valida=0;
		}
		$qrys="update inv_prod set invProd=$inv_final where loteProd=$lote_actual and codPresentacion=$producto";
		$results=mysqli_query($link,$qrys);
		$entrada=0;
	  }
	  else
	  {
		$entrada=$entrada-$inv_actual;
		$inv_final=0;
		$qryr="select codProducto, cantProducto, loteProducto from det_remision1 where idRemision=$remision and codProducto=$producto and loteProducto=$lote_actual";
		$resultr=mysqli_query($link,$qryr);
		if($rowr=mysqli_fetch_array($resultr))
		{
		  $cant_actual=$rowr['Can_producto'];
		  $cant_final=$cant_actual+$inv_actual;
		  $qryd="update det_remision1 set cantProducto=$cant_final where idRemision=$remision and codProducto=$producto and loteProducto=$lote_actual";
		  $resultd=mysqli_query($link,$qryd);
		}
		else
		{
		  $qryd="insert into det_remision1 (idRemision, codProducto, cantProducto, loteProducto) values($remision, $producto, $inv_actual, $lote_actual)";
		  $resultd=mysqli_query($link,$qryd);
		}
		$qrys="update inv_prod set invProd=$inv_final where loteProd=$lote_actual and codPresentacion=$producto";
		$results=mysqli_query($link,$qrys);
	  }
	}
  }
}
else
{
	$qry2="select codDistribucion, invDistribucion as Inv from inv_distribucion WHERE codDistribucion=$producto;";
	$result2=mysqli_query($link,$qry2);
	$row2=mysqli_fetch_array($result2);	
	$Inv=$row2['Inv'];	
	$Inv=$Inv - $cantidad + $cant_ant;
	$qry3="update inv_distribucion set invDistribucion=$Inv where codDistribucion=$producto;";
	$result3=mysqli_query($link,$qry3);
	$qryinv="update det_remision1 set cantProducto=$cantidad where idRemision=$remision and codProducto=$producto";
	$resultinv=mysqli_query($link,$qryinv);
	$valida=0;
}	

//
mysqli_close($link);
echo'<form action="det_remision.php" method="post" name="formulario">';
echo '<input name="remision" type="hidden" value="'.$remision.'"/>
<input name="Crear" type="hidden" value="5">
<input type="submit" name="Submit" value="Cambiar" >';
if($valida==0)
{
	$ruta="";
	mover_pag($ruta,"Remisión Actualizada correctamente");
}
echo'</form>';
function mover_pag($ruta,$mensaje)
{
	echo'<script > document.formulario.submit(); </script>';
}
?>
</body>
</html>