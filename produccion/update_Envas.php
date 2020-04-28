<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Acualizaci&oacute;n</title>
</head>
<body>
<?php
	$Lote=$_POST['Lote'];
	$cod_pres=$_POST['Codpres'];
	$cantidad=$_POST['Cantidad'];
	$cantidad_ant=$_POST['Cantidad_ant'];
	$link=conectarServidor();
	if($cantidad >= $cantidad_ant)
	{
		$cambio=$cantidad - $cantidad_ant;
		//SE ACTUALIZA EL INVENTARIO
		$qry_inv="select inv_prod from inv_prod where lote_prod=$Lote and Cod_prese=$cod_pres;";
		$result_inv=mysqli_query($link,$qry_inv);
		$row_inv=mysqli_fetch_array($result_inv);
		$inv_inv=$row_inv['inv_prod']+$cambio;
		$qryup_prod="update inv_prod set inv_prod=$inv_inv where lote_prod=$Lote and Cod_prese=$cod_pres";
		$resultup_prod=mysqli_query($link,$qryup_prod);
		//SE ACTUALIZA EL ENVASE
		$qry_env="select * from inv_envase where codEnvase = (select codEnvase from prodpre where Cod_prese=$cod_pres)";
		$result_env=mysqli_query($link,$qry_env);
		$row_env=mysqli_fetch_array($result_env);
		$inv_env=$row_env['inv_envase'];
		$inv_env=$inv_env - $cantidad + $cantidad_ant;
		$cod_env=$row_env['Cod_envase'];
		$qry_up_env="update inv_envase set invEnvase=$inv_env where codEnvase=$cod_env";
		$result_up_env=mysqli_query($link,$qry_up_env);
		//SE ACTUALIZA LA TAPA
		$qry_val="select * from inv_tapas_val where codTapa = (select codTapa from prodpre where Cod_prese=$cod_pres)";
		$result_val=mysqli_query($link,$qry_val);
		$row_val=mysqli_fetch_array($result_val);
		$inv_val=$row_val['inv_tapa'];
		$inv_val=$inv_val - $cantidad + $cantidad_ant;
		$cod_val=$row_val['Cod_tapa'];
		$qry_up_val="update inv_tapas_val set invTapa=$inv_val where codTapa=$cod_val";
		$result_up_val=mysqli_query($link,$qry_up_val);
		//SE ACTUALIZA LA ETIQUETA
		$qry_etq="select * from inv_etiquetas where codEtiq = (select codEtiq from prodpre where Cod_prese=$cod_pres)";
		$result_etq=mysqli_query($link,$qry_etq);
		$row_etq=mysqli_fetch_array($result_etq);
		$inv_etq=$row_etq['inv_etiq'];
		$cod_etq=$row_etq['Cod_etiq'];
		$inv_etq=$inv_etq - $cantidad + $cantidad_ant;
		$qry_up_etq="update inv_etiquetas set invEtiq=$inv_etq where codEtiq=$cod_etq";
		$result_up_etq=mysqli_query($link,$qry_up_etq);		
		echo' <script >
				alert("Actualización Realizada con Éxito");
			</script>';
	}
	else
	{
		$cambio=$cantidad - $cantidad_ant;
		//SE ACTUALIZA EL INVENTARIO
		$qry_inv="select inv_prod from inv_prod where lote_prod=$Lote and Cod_prese=$cod_pres;";
		$result_inv=mysqli_query($link,$qry_inv);
		$row_inv=mysqli_fetch_array($result_inv);
		$inv_inv=$row_inv['inv_prod']+$cambio;
		//SE ACTUALIZA EL INVENTARIO
		$qryup_prod="update inv_prod set inv_prod=$inv_inv where lote_prod=$Lote and Cod_prese=$cod_pres";
		$resultup_prod=mysqli_query($link,$qryup_prod);
		//SE ACTUALIZA EL ENVASE
		$qry_env="select * from inv_envase where codEnvase = (select codEnvase from prodpre where Cod_prese=$cod_pres)";
		$result_env=mysqli_query($link,$qry_env);
		$row_env=mysqli_fetch_array($result_env);
		$inv_env=$row_env['inv_envase'];
		$inv_env=$inv_env - $cantidad + $cantidad_ant;
		$cod_env=$row_env['Cod_envase'];
		$qry_up_env="update inv_envase set invEnvase=$inv_env where codEnvase=$cod_env";
		$result_up_env=mysqli_query($link,$qry_up_env);
		//SE ACTUALIZA LA TAPA
		$qry_val="select * from inv_tapas_val where codTapa = (select codTapa from prodpre where Cod_prese=$cod_pres)";
		$result_val=mysqli_query($link,$qry_val);
		$row_val=mysqli_fetch_array($result_val);
		$inv_val=$row_val['inv_tapa'];
		$inv_val=$inv_val - $cantidad + $cantidad_ant;
		$cod_val=$row_val['Cod_tapa'];
		$qry_up_val="update inv_tapas_val set invTapa=$inv_val where codTapa=$cod_val";
		$result_up_val=mysqli_query($link,$qry_up_val);
		//SE ACTUALIZA LA ETIQUETA
		$qry_etq="select * from inv_etiquetas where codEtiq = (select codEtiq from prodpre where Cod_prese=$cod_pres)";
		$result_etq=mysqli_query($link, $qry_etq);
		$row_etq=mysqli_fetch_array($result_etq);
		$inv_etq=$row_etq['inv_etiq'];
		$cod_etq=$row_etq['Cod_etiq'];
		$inv_etq=$inv_etq - $cantidad + $cantidad_ant;
		$qry_up_etq="update inv_etiquetas set invEtiq=$inv_etq where codEtiq=$cod_etq";
		$result_up_etq=mysqli_query($link,$qry_up_etq);		
		echo' <script >
				alert("Actualización Realizada con Éxito");
			</script>';
	}
	$qry="update envasado set Can_prese=$cantidad where Lote=$Lote and Con_prese=$cod_pres";
	echo'<form action="det_Envasado.php" method="post" name="formulario">';
	$result=mysqli_query($link,$qry);
	echo '<input name="Lote" type="hidden" value="'.$Lote.'"/><input name="Crear" type="hidden" value="5"><input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="menu.php";
		mover_pag($ruta,"Envasado Actualizado correctamente");
	}
	echo'</form>';
	function mover_pag($ruta,$nota)
	{
	echo'<script >
	document.formulario.submit();
	</script>';
	}
	mysqli_close($link);
?>
</body>
</html>