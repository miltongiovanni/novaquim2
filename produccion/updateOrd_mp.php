<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualizaci&oacute;n</title>
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$bd="novaquim";
	//ACTUALIZA EL GASTO DE MATERIA PRIMA EN LA ORDEN DE PRODUCCION
	
		
	$qry="update det_ord_prod_mp set Can_mprima=$gasto where Lote_mprima=$Lote and Id_mprima=$mprima and Lote_MP='$lote_mp'";
	echo'<form action="detO_Prod_mp.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link, $qry);
	if ($result)
	{
		$qryexis="select * from inv_mprimas where codMP=$mprima and invMP!=0";
		$resultexis=mysqli_query($link, $qryexis);
		$rowexis=mysqli_fetch_array($resultexis);
		$exis=$rowexis['inv_mp'];
		$lote_mp=$rowexis['Lote_mp'];
		$exis=$exis+$gasto_ant-$gasto;
		$qryump="update inv_mprimas set invMP=$exis  where loteMP='$lote_mp' and codMP=$mprima";
		$resultump=mysqli_query($link, $qryump);
		mysqli_close($link);
	}
	echo '<input name="Lote" type="hidden" value="'.$Lote.'">';
	if($result==1)
	{
		$ruta="menu.php";
		mover_pag($ruta,"Gasto de Materia Prima Actualizado correctamente");
	}
	echo'</form>';
	function mover_pag($ruta,$nota)
	{
	echo'<script >
	document.formulario.submit();
	</script>';
	}
?>
</body>
</html>