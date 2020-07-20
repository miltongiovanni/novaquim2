<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualización</title>
</head>
<body>
<?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();
	//REVISA EL INVENTARIO DE PRODUCTO
	if ($producto < 100000)
	{
		$qry="select idRemision, codProducto as Codigo, loteProducto, Nombre as Producto, cantProducto as Cantidad from det_remision1, prodpre where idRemision=$remision and codProducto=$producto and codProducto=Cod_prese";
		echo $qry."<br>";
		$result=mysqli_query($link,$qry);
		while(($row=mysqli_fetch_array($result)))
		{
			$lote=$row['Lote_producto'];
			$cant=$row['Cantidad'];
			echo "cantidad ".$cant."<br>";
			$qry2="select codPresentacion as Codigo, loteProd as Lote, invProd as Inv from inv_prod where codPresentacion=$producto AND loteProd=$lote;";
			echo $qry2."<br>";	
			$result2=mysqli_query($link,$qry2);
			$row2=mysqli_fetch_array($result2);	
			$Inv=$row2['Inv'];	
			$Inv=$Inv + $cant;
			$qry3="update inv_prod set invProd=$Inv where codPresentacion=$producto AND loteProd=$lote;";
			echo $qry3."<br>";
			$result3=mysqli_query($link,$qry3);
		}
	}
	else
	{
		$qry="SELECT codProducto as Codigo, Producto, cantProducto as Cantidad, loteProducto from det_remision1, distribucion 
		where codProducto=Id_distribucion and idRemision=$remision AND codProducto=$producto;";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		$qry2="select codDistribucion, invDistribucion as Inv from inv_distribucion WHERE codDistribucion=$producto;";
		echo $qry2."<br>";	
		$result2=mysqli_query($link,$qry2);
		$row2=mysqli_fetch_array($result2);	
		$Inv=$row2['Inv'];	
		$Inv=$Inv + $cantidad;
		$qry3="update inv_distribucion set invDistribucion=$Inv where codDistribucion=$producto;";
		echo $qry3."<br>";
		$result3=mysqli_query($link,$qry3);
	}			
	//ELIMINA EL PRODUCTO DE LA REMISION
	$qryinv="delete from det_remision1 where idRemision=$remision and codProducto=$producto";
	echo $qryinv;
	echo'<form action="det_remision.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	echo '<input name="remision" type="hidden" value="'.$remision.'">
	<input name="Crear" type="hidden" value="5">
	<input type="submit" name="Submit" value="Cambiar" >';
	if($result==1)
	{
		$ruta="";
		mover_pag($ruta,"Remision Actualizada correctamente");
	}
	echo'</form>';
	
	mysqli_close($link);
?>
</body>
</html>