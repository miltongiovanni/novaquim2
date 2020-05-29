<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es">
<head>
<title>Envasado de Productos por Lote</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
	<script  src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>PRODUCTOS ENVASADOS POR LOTE</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
	  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
	  //echo $nombre_campo." = ".$valor."<br>";  
	  eval($asignacion); 
	}  
	$link=conectarServidor();
	$qryord="select Lote, fechProd, cantidadKg, codResponsable, Nom_produc, nomFormula, nom_personal 
			from ord_prod, formula, productos, personal
			WHERE ord_prod.idFormula=formula.idFormula and formula.codProducto=productos.Cod_produc
			and ord_prod.codResponsable=personal.Id_personal and Lote=$Lote;";
	$resultord=mysqli_query($link,$qryord);
	$roword=mysqli_fetch_array($resultord);
	mysqli_free_result($resultord);
	if ($roword)
		mysqli_close($link);
	else
	{
		mover("Envasado.php","No existe la Orden de Producción");
		mysqli_close($link);
	}
	function mover($ruta,$mensaje)
	{
		//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
		echo'<script >
		alert("'.$mensaje.'")
		self.location="'.$ruta.'"
		</script>';
	}
	if ($Crear == 1)
	{
		//Envasado
		$link=conectarServidor();   
		/* disable autocommit */
		mysqli_autocommit($link, FALSE);
		$qrybus="select * from envasado where Lote=$Lote and Con_prese=$cod_prodpre;";
		$resultqrybus=mysqli_query($link,$qrybus);
		$row_bus=mysqli_fetch_array($resultqrybus);
		if ($row_bus['Con_prese']==$cod_prodpre)
		{
			/* Rollback */
			mysqli_rollback($link);
			echo' <script >
				alert("Producto incluido anteriormente");
			</script>'; 
		}
		else
		{
			//SE INSERTA LA CANTIDAD DE PRODUCTO ENVASADO
			$qryins="insert into envasado (Lote, Con_prese, Can_prese) values ($Lote, $cod_prodpre, $cantidad)";
			$resultins=mysqli_query($link,$qryins);
			//SE CARGA EN EL INVENTARIO
			$qryins_prod="insert into inv_prod (Cod_prese, inv_prod, lote_prod) values ($cod_prodpre, $cantidad, $Lote)";
			$resultins_prod=mysqli_query($link,$qryins_prod);
			//SE DESCUENTA EL ENVASE
			$qry_env="select * from inv_envase where codEnvase = (select codEnvase from prodpre where Cod_prese=$cod_prodpre)";
			$result_env=mysqli_query($link,$qry_env);
			$row_env=mysqli_fetch_array($result_env);
			$inv_env=$row_env['inv_envase'];
			$cod_env=$row_env['Cod_envase'];
			if ($inv_env >= $cantidad)
			{
				$inv_env=$inv_env - $cantidad;
				$qry_up_env="update inv_envase set invEnvase=$inv_env where codEnvase=$cod_env";
				$result_up_env=mysqli_query($link,$qry_up_env);
			}
			else
			{
			  /* Rollback */
			  mysqli_rollback($link);
			  echo' <script >
				  alert("No hay envase suficiente solo hay '.$inv_env.' unidades");
			  </script>';
			}
			//SE DESCUENTA LA TAPA
			$qry_val="select codTapa, invTapa from inv_tapas_val where codTapa = (select codTapa from prodpre where Cod_prese=$cod_prodpre)";
			$result_val=mysqli_query($link,$qry_val);
			$row_val=mysqli_fetch_array($result_val);
			$inv_val=$row_val['inv_tapa'];
			$cod_val=$row_val['Cod_tapa'];
			if ($inv_val >= $cantidad)
			{
				$inv_val=$inv_val - $cantidad;
				$qry_up_val="update inv_tapas_val set invTapa=$inv_val where codTapa=$cod_val";
				$result_up_val=mysqli_query($link,$qry_up_val);
			}
			else
			{
			  /* Rollback */
			  mysqli_rollback($link);
			  echo' <script >
				  alert("No hay tapas o válvulas suficientes, sólo hay '.$inv_val.' unidades");
			  </script>';
			}
			//SE DESCUENTA LA ETIQUETA
			$qry_etq="select * from inv_etiquetas where codEtiq = (select codEtiq from prodpre where Cod_prese=$cod_prodpre)";
			$result_etq=mysqli_query($link,$qry_etq);
			$row_etq=mysqli_fetch_array($result_etq);
			$inv_etq=$row_etq['inv_etiq'];
			$cod_etq=$row_etq['Cod_etiq'];
			if ($inv_etq >= $cantidad)
			{
				$inv_etq=$inv_etq - $cantidad;
				$qry_up_etq="update inv_etiquetas set invEtiq=$inv_etq where codEtiq=$cod_etq";
				$result_up_etq=mysqli_query($link,$qry_up_etq);
			}
			else
			{
			/* Rollback */
			mysqli_rollback($link);
			echo' <script >
				alert("No hay etiquetas suficientes, sólo hay '.$inv_etq.' unidades");
			</script>';
			}
		}
		//SE REALIZA EL COMMIT 
		$qry_up_ord="update ord_prod set Estado='F' where Lote=$Lote";
		$result_up_ord=mysqli_query($link,$qry_up_ord);
		mysqli_commit($link);
		mysqli_autocommit($link, TRUE);
		mysqli_close($link);
		echo '<form method="post" action="det_Envasado.php" name="form3">';
		echo'<input name="Crear" type="hidden" value="5">'; 
		echo'<input name="Lote" type="hidden" value="'.$Lote.'">'; 
		echo '</form>';
		echo'<script >
			document.form3.submit();
			</script>';
	}
	if ($Crear == 2)
	{
		$link=conectarServidor();
		$qry_up_ord="update ord_prod set Estado='E' where Lote=$Lote";
		$result_up_ord=mysqli_query($link,$qry_up_ord);
		mysqli_close($link);
	    mover("menu.php","Producto terminado de envasar éxitosamente");
	}
?>

<form method="post" action="det_Envasado.php" name="form1">
  <table align="center" border="0" summary="cuerpo">
    <tr>
      <td width="154">&nbsp;</td>
      <td width="123">&nbsp;</td>
      <td width="215">&nbsp;</td>
      <td width="144">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"></td>
      <td><div align="right"><strong>No. de Lote</strong> </div></td>
      <td width="188"><div align="left"><?php echo $Lote;?></div></td>
    </tr>
    <tr>
      <td colspan="5"><hr></td>
    </tr>
    <?php
		$link=conectarServidor();
		$qry1="SELECT Lote, fechProd, cantidadKg, ord_prod.codProducto as Codigo, Nom_produc, nom_personal 
		FROM ord_prod, productos, personal
		where Lote=$Lote and ord_prod.codProducto=productos.Cod_produc AND ord_prod.codResponsable=personal.Id_personal;";
		$result1=mysqli_query($link,$qry1);
		$row1=mysqli_fetch_array($result1);
		$cod_prod=$row1['Codigo'];
		mysqli_close($link);
	 ?>
     
    <tr>
      <td><strong>Producto</strong></td>
      <td colspan="2"><?php echo  $row1['Nom_produc']; ?></td>
      <td><strong>Cantidad (Kg)</strong></td>
      <td><?php echo  $row1['Cant_kg']?></td>
    </tr>
    <tr>
      <td ><strong>Fecha de Producción</strong></td>
      <td colspan="2"><?php echo $row1['Fch_prod']; ?></td>
      <td><strong>Responsable</strong></td>
      <td><div align="left"><?php echo $row1['nom_personal']; ?> </div></td>
    </tr>
    <tr>
      <td colspan="5"><hr></td>
    </tr>
    <tr>
      <td colspan="3"><div align="center"><strong>Presentación de Productos</strong></div></td>
      <td><div align="center"><strong>Unidades</strong></div></td>
    </tr>
    <tr>
      <td colspan="3"><div align="center">
          <?php

			$link=conectarServidor();
			echo'<select name="cod_prodpre">';
			$qry="SELECT Cod_prese, Nombre FROM (SELECT Cod_prese, Nombre FROM prodpre as prod_emp where Cod_produc=$cod_prod and pres_activo=0) as Tabla1 left JOIN envasado ON Lote=$Lote AND Cod_prese=Con_prese where Con_prese IS NULL";
			echo $qry;
			$result=mysqli_query($link,$qry);
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
            }
            echo'</select>';
			mysqli_close($link);
		?>
      </div></td>
      <td><div align="center">
          <input name="cantidad" type="text" size=20 >
      </div></td>
    
      <td align="right"><input name="submit" onClick="return Enviar(this.form)" type="submit"  value="Continuar" >
      	<input name="Crear" type="hidden" value="1">
          <?php echo'<input name="Lote" type="hidden" value="'.$Lote.'">'; ?> </td>
    </tr>
    
    <tr>
      <td height="8" colspan="5"><hr></td>
    </tr>
    <tr>
      <td  colspan="5">Detalle de Envasado : </td>
    </tr>
    </table>
</form>
    <table width="845" border="0" align="center" summary="detalle">
          <tr>
	        <th width="101"></th>
            <th width="58" align="center">Código</th>
            <th width="555" align="center">Producto por Presentación</th>
            <th width="113" align="center">Cantidad </th>
          </tr>
          <?php
			$link=conectarServidor();
			$qry="SELECT Con_prese, Nombre, Can_prese FROM envasado, prodpre WHERE Con_prese=Cod_prese and lote=$Lote;";
			$result=mysqli_query($link,$qry);
			$qrytot="select envasado.Lote, SUM(Can_prese*cant_medida/1000) AS enva, cantidadKg from envasado, prodpre, medida, ord_prod 
			where envasado.Lote=$Lote AND Con_prese=Cod_prese and Cod_umedid=Id_medida AND envasado.Lote=ord_prod.Lote group by envasado.Lote;";
			$resulttot=mysqli_query($link,$qrytot);
			if($rowtot=mysqli_fetch_array($resulttot))
			{
				$envasado=$rowtot['enva'];
				$total=$rowtot['Cant_kg'];
				$saldo=$total - $envasado;
			}
			else
			{	
				$saldo=number_format($row1['Cant_kg']);
			}
			//document.form3.submit();
			$c=0;
			while($row=mysqli_fetch_array($result))
			{
			echo'<tr><td><form action="updateEnvasado.php" method="post" name="actualiza'.$c++.'">
					<input type="submit" name="Submit" value="Cambiar" >
					<input name="Lote" type="hidden" value="'.$Lote.'">
					<input name="Presentacion" type="hidden" value="'.$row['Con_prese'].'">
					<input name="Cantidad" type="hidden" value="'.$row['Can_prese'].'"></form></td>
			  <td><div align="center">'.$row['Con_prese'].'</div></td>
			  <td><div align="center">'.$row['Nombre'].'</div></td>
			  <td><div align="center">'.$row['Can_prese'].'</div></td>
			</tr>';
			}
			echo '<tr><td colspan="5"><hr /></td></tr>';
			echo'<tr><td></td>
				<td>';
			echo '<form method="post" action="det_Envasado.php" name="form3">';
			echo'<input name="Crear" type="hidden" value="2">'; 
			echo '<input type="submit" name="Submit" value="Terminar Envasado" >';
			echo'<input name="Lote" type="hidden" value="'.$Lote.'">'; 
			echo '</form>';	
			echo '</td>
			  	
			  	<td><div align="right"><strong>Cantidad Pendiente en Litros</strong></div></td>
			  	<td><div align="center"><strong>'.$saldo.'</strong></div></td>
				</tr>';
			mysqli_close($link);
			?>
      </table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>