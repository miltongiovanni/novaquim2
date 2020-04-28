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
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  

	$Lote=$_POST['Lote'];
	$cod_mprima=$_POST['mprima'];
	$gasto=$_POST['gasto'];
	$gasto_ant=$_POST['gasto_ant'];
	$lote_mp=$_POST['lote_mp'];
	//ACTUALIZA EL GASTO DE MATERIA PRIMA EN LA ORDEN DE PRODUCCION
	$qry="update det_ord_prod set Can_mprima=$gasto where Lote=$Lote and Cod_mprima=$cod_mprima and Lote_MP='$lote_mp'";
	echo'<form action="detO_Prod.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qry);
	if ($result)
	{
		$qryexis="select * from inv_mprimas where codMP=$cod_mprima and invMP!=0";
		$resultexis=mysqli_query($link,$qryexis);
		$rowexis=mysqli_fetch_array($resultexis);
		$exis=$rowexis['inv_mp'];
		$lote_mp=$rowexis['Lote_mp'];
		$exis=$exis+$gasto_ant-$gasto;
		$qryump="update inv_mprimas set invMP=$exis  where loteMP='$lote_mp' and codMP=$cod_mprima";
		$resultump=mysqli_query($link,$qryump);
	}
	echo '<input name="Lote" type="hidden" value="'.$Lote.'">';
	mysqli_free_result($resultexis);
	/* cerrar la conexión */
	mysqli_close($link);
	
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