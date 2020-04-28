<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<title>Actualizaci&oacute;n</title>
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
	$qryr="select Cod_producto, Can_producto, Lote_producto from det_remision1 where Id_remision=$remision and Cod_producto=$producto order by Lote_producto desc;";
	$devolucion=$cant_ant-$cantidad;
	$resultr=mysqli_query($link,$qryr);
	while(($rowr=mysqli_fetch_array($resultr))||($devolucion!=0))
	{
	  $Cod_producto=$rowr['Cod_producto'];
	  $Can_producto=$rowr['Can_producto'];
	  $Lote_producto=$rowr['Lote_producto'];
	  $qryinv="select inv_prod from inv_prod where lote_prod=$Lote_producto and Cod_prese=$Cod_producto";
	  $resultinv=mysqli_query($link,$qryinv);
	  $rowinv=mysqli_fetch_array($resultinv);
	  $inv_actual=$rowinv['inv_prod'];
	  if ($Can_producto>=$devolucion)
	  {
		$inv_entra=$devolucion;
		$devolucion=0;
		$inv_final= $inv_actual + $inv_entra;
		$qrys="update inv_prod set inv_prod=$inv_final where lote_prod=$Lote_producto and Cod_prese=$Cod_producto";
		$results=mysqli_query($link,$qrys);
		$ajuste=$Can_producto-$inv_entra;
		$qryd="update det_remision1 set Can_producto=$ajuste where Id_remision=$remision and Cod_producto=$producto and Lote_producto=$Lote_producto";
		$resultd=mysqli_query($link,$qryd);
		$valida=0;
	  }
	  else
	  {
		$inv_entra=$Can_producto;
		$devolucion=$devolucion-$Can_producto;
		$inv_final=$inv_actual+$inv_entra;
		$qrys="update inv_prod set inv_prod=$inv_final where lote_prod=$Lote_producto and Cod_prese=$Cod_producto";
		$results=mysqli_query($link,$qrys);
		$qryd="delete from det_remision1 where Id_remision=$remision and Cod_producto=$producto and Lote_producto=$Lote_producto";
		$resultd=mysqli_query($link,$qryd);
	  }
	}
  }
  else
  {
	$qryinv="select inv_prod, lote_prod from inv_prod where Cod_prese=$producto and inv_prod>0";
	$resultinv=mysqli_query($link,$qryinv);
	$entrada=$cantidad-$cant_ant;
	while(($rowinv=mysqli_fetch_array($resultinv))&&($entrada!=0))
	{
	  $inv_actual=$rowinv['inv_prod'];
	  $lote_actual=$rowinv['lote_prod'];
	  if ($inv_actual>=$entrada)
	  {
		$inv_final=$inv_actual-$entrada;
		$qryr="select Cod_producto, Can_producto, Lote_producto from det_remision1 where Id_remision=$remision and Cod_producto=$producto and Lote_producto=$lote_actual";
		$resultr=mysqli_query($link,$qryr);
		if($rowr=mysqli_fetch_array($resultr))
		{
		  $cant_actual=$rowr['Can_producto'];
		  $cant_final=$cant_actual+$entrada;
		  $qryd="update det_remision1 set Can_producto=$cant_final where Id_remision=$remision and Cod_producto=$producto and Lote_producto=$lote_actual";
		  $resultd=mysqli_query($link,$qryd);
		  $valida=0;
		}
		else
		{
		  $qryd="insert into det_remision1 (Id_remision, Cod_producto, Can_producto, Lote_producto) values($remision, $producto, $entrada, $lote_actual)";
		  $resultd=mysqli_query($link,$qryd);
		  $valida=0;
		}
		$qrys="update inv_prod set inv_prod=$inv_final where lote_prod=$lote_actual and Cod_prese=$producto";
		$results=mysqli_query($link,$qrys);
		$entrada=0;
	  }
	  else
	  {
		$entrada=$entrada-$inv_actual;
		$inv_final=0;
		$qryr="select Cod_producto, Can_producto, Lote_producto from det_remision1 where Id_remision=$remision and Cod_producto=$producto and Lote_producto=$lote_actual";
		$resultr=mysqli_query($link,$qryr);
		if($rowr=mysqli_fetch_array($resultr))
		{
		  $cant_actual=$rowr['Can_producto'];
		  $cant_final=$cant_actual+$inv_actual;
		  $qryd="update det_remision1 set Can_producto=$cant_final where Id_remision=$remision and Cod_producto=$producto and Lote_producto=$lote_actual";
		  $resultd=mysqli_query($link,$qryd);
		}
		else
		{
		  $qryd="insert into det_remision1 (Id_remision, Cod_producto, Can_producto, Lote_producto) values($remision, $producto, $inv_actual, $lote_actual)";
		  $resultd=mysqli_query($link,$qryd);
		}
		$qrys="update inv_prod set inv_prod=$inv_final where lote_prod=$lote_actual and Cod_prese=$producto";
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
	$qryinv="update det_remision1 set Can_producto=$cantidad where Id_remision=$remision and Cod_producto=$producto";
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
function mover_pag($ruta,$nota)
{
	echo'<script > document.formulario.submit(); </script>';
}
?>
</body>
</html>