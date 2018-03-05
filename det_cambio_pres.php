<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Cambio de presentaci&oacute;n de Producto</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue" >	
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>CAMBIO DE PRESENTACI&Oacute;N DE PRODUCTO</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();  
	if ($Crear == 0)
	{
		$qryins_comp="insert into cambios (Cod_persona, Fech_cambio) values ($respon, '$fecha')";
		$resultins_prod=mysqli_query($link,$qryins_comp);	
		$qrycam="select MAX(Id_cambio) AS Cambio from cambios;";
		$resultqrycam=mysqli_query($link,$qrycam);
		$row_cam=mysqli_fetch_array($resultqrycam);
		$cambio=$row_cam['Cambio'];
		mysqli_free_result($resultqrycam);
		mysqli_close($link);
		echo '<form method="post" action="det_cambio_pres.php" name="form3">';
		echo'<input name="Crear" type="hidden" value="3">'; 
		echo'<input name="cambio" type="hidden" value="'.$cambio.'">'; 
		echo '</form>';
		echo'<script language="Javascript">
			 document.form3.submit();
			 </script>';	
	}
	if($Crear==1)
	{
		$qrybus="SELECT Cod_prese, lote_prod, inv_prod FROM inv_prod where lote_prod=$lote and Cod_prese=$Cod_prese_ant";
		$resultbus=mysqli_query($link,$qrybus);
		if($rowbus=mysqli_fetch_array($resultbus))
		{
			$inv=$rowbus['inv_prod'];
			if($cant_ant <= $inv)
			{
				echo'<script language="Javascript">
				alert("Hay inventario suficiente para realizar el cambio");
				</script>';
				$inv= $inv - $cant_ant;
				//SE ACTUALIZA EL INVENTARIO
				$qryupt="update inv_prod set inv_prod=$inv where lote_prod=$lote and Cod_prese=$Cod_prese_ant";
				echo $qryupt;
				$resultupt=mysqli_query($link,$qryupt);
				//SE GUARDA EL DETALLE DEL CAMBIO
				$qryDOP="insert into det_cambios (Id_cambio, Cod_prese_ant, Can_prese_ant, lote_prod) values ($cambio, $Cod_prese_ant, $cant_ant, $lote)";
				$resultDOP=mysqli_query($link,$qryDOP);
				$cantidad=$cant_ant;
				//SE DESCUENTA EL ENVASE
				$qry_env="select * from inv_envase where Cod_envase = (select Cod_envase from prodpre where Cod_prese=$Cod_prese_ant)";
				$result_env=mysqli_query($link,$qry_env);
				$row_env=mysqli_fetch_array($result_env);
				$inv_env=$row_env['inv_envase'];
				$cod_env=$row_env['Cod_envase'];
				$inv_env=$inv_env + $cant_ant;
				$qry_up_env="update inv_envase set inv_envase=$inv_env where Cod_envase=$cod_env";
				$result_up_env=mysqli_query($link,$qry_up_env);
				//SE DESCUENTA LA TAPA
				$qry_val="select * from inv_tapas_val where Cod_tapa = (select Cod_tapa from prodpre where Cod_prese=$Cod_prese_ant)";
				$result_val=mysqli_query($link,$qry_val);
				$row_val=mysqli_fetch_array($result_val);
				$inv_val=$row_val['inv_tapa'];
				$cod_val=$row_val['Cod_tapa'];
				$inv_val=$inv_val + $cant_ant;
				$qry_up_val="update inv_tapas_val set inv_tapa=$inv_val where Cod_tapa=$cod_val";
				$result_up_val=mysqli_query($link,$qry_up_val);
				//SE DESCUENTA LA ETIQUETA
				$qry_etq="select * from inv_etiquetas where Cod_etiq = (select Cod_etiq from prodpre where Cod_prese=$Cod_prese_ant)";
				$result_etq=mysqli_query($link,$qry_etq);
				$row_etq=mysqli_fetch_array($result_etq);
				$inv_etq=$row_etq['inv_etiq'];
				$cod_etq=$row_etq['Cod_etiq'];
				$inv_etq=$inv_etq + $cant_ant;
				$qry_up_etq="update inv_etiquetas set inv_etiq=$inv_etq where Cod_etiq=$cod_etq";
				$result_up_etq=mysqli_query($link,$qry_up_etq);
				mysqli_free_result($resultbus);
				mysqli_close($link);
				echo '<form method="post" action="det_cambio_pres.php" name="form3">';
				echo'<input name="Crear" type="hidden" value="4">'; 
				echo'<input name="lote" type="hidden" value="'.$lote.'">'; 
				echo'<input name="Cod_prese_ant" type="hidden" value="'.$Cod_prese_ant.'">';
				echo'<input name="cambio" type="hidden" value="'.$cambio.'">'; 
				echo '</form>';
				echo'<script language="Javascript">
					 document.form3.submit();
					 </script>';
			}
			else
			{
			  echo'<script language="Javascript">
			  alert("No hay inventario suficiente para realizar el cambio");
			  </script>';
			  mysqli_free_result($resultbus);
			  mysqli_close($link);
			  echo '<form method="post" action="det_cambio_pres.php" name="form3">';
			  echo'<input name="Crear" type="hidden" value="3">'; 
			  echo'<input name="cambio" type="hidden" value="'.$cambio.'">'; 
			  echo '</form>';
			  echo'<script language="Javascript">
			  document.form3.submit();
			  </script>';	
			}
			
		}
		else
		{
			echo'<script language="Javascript">
  			 alert("No es válido el lote");
   			</script>';
			mysqli_close($link);
			echo '<form method="post" action="det_cambio_pres.php" name="form3">';
			echo'<input name="Crear" type="hidden" value="3">'; 
			echo'<input name="cambio" type="hidden" value="'.$cambio.'">'; 
			echo '</form>';
			echo'<script language="Javascript">
				  document.form3.submit();
				  </script>';	
		}
	}
	if($Crear==2)
	{
		//MIRAR CUANTO PRODUCTO HAY Y A QUÉ LOTE PERTENECE
		$qryDOP="insert into det_cambios2 (Id_cambio, Cod_prese_nvo, Can_prese_nvo, lote_prod) values ($cambio, $Cod_prese_nvo, $cant_nvo, $lote)";
		$resultDOP=mysqli_query($link,$qryDOP);
		//SE ACTUALIZA EL INVENTARIO
		$qry_prod="select * from inv_prod WHERE Cod_prese=$Cod_prese_nvo AND lote_prod=$lote;";
		$result_prod=mysqli_query($link,$qry_prod);
		$row_prod=mysqli_fetch_array($result_prod);
		if ($row_prod) //si hay inventario se actualiza
		{
			$inv_prod=$row_prod['inv_prod'];
			$inv_prod=$inv_prod + $cant_nvo;
			$qryupt="update inv_prod set inv_prod=$inv_prod where lote_prod=$lote and Cod_prese=$Cod_prese_nvo";
			$resultupt=mysqli_query($link,$qryupt);
		}
		else //De lo contrario se inserta 
		{
			$qryins_prod="insert into inv_prod (Cod_prese, inv_prod, lote_prod) values ($Cod_prese_nvo, $cant_nvo, $lote)";
			$resultins_prod=mysqli_query($link,$qryins_prod);
		}
		$cantidad=$cant_nvo;
		//SE DESCUENTA EL ENVASE
		$qry_env="select * from inv_envase where Cod_envase = (select Cod_envase from prodpre where Cod_prese=$Cod_prese_nvo)";
		$result_env=mysqli_query($link,$qry_env);
		$row_env=mysqli_fetch_array($result_env);
		$inv_env=$row_env['inv_envase'];
		$cod_env=$row_env['Cod_envase'];
		$inv_env=$inv_env - $cantidad;
		$qry_up_env="update inv_envase set inv_envase=$inv_env where Cod_envase=$cod_env";
		$result_up_env=mysqli_query($link,$qry_up_env);
		//SE DESCUENTA LA TAPA
		$qry_val="select * from inv_tapas_val where Cod_tapa = (select Cod_tapa from prodpre where Cod_prese=$Cod_prese_nvo)";
		$result_val=mysqli_query($link,$qry_val);
		$row_val=mysqli_fetch_array($result_val);
		$inv_val=$row_val['inv_tapa'];
		$cod_val=$row_val['Cod_tapa'];
		$inv_val=$inv_val - $cantidad;
		$qry_up_val="update inv_tapas_val set inv_tapa=$inv_val where Cod_tapa=$cod_val";
		$result_up_val=mysqli_query($link,$qry_up_val);
		//SE DESCUENTA LA ETIQUETA
		$qry_etq="select * from inv_etiquetas where Cod_etiq = (select Cod_etiq from prodpre where Cod_prese=$Cod_prese_nvo)";
		$result_etq=mysqli_query($link,$qry_etq);
		$row_etq=mysqli_fetch_array($result_etq);
		$inv_etq=$row_etq['inv_etiq'];
		$cod_etq=$row_etq['Cod_etiq'];
		$inv_etq=$inv_etq - $cantidad;
		$qry_up_etq="update inv_etiquetas set inv_etiq=$inv_etq where Cod_etiq=$cod_etq";
		$result_up_etq=mysqli_query($link,$qry_up_etq);
		mysqli_close($link);
		echo '<form method="post" action="det_cambio_pres.php" name="form3">';
		echo'<input name="Crear" type="hidden" value="5">'; 
		echo'<input name="cambio" type="hidden" value="'.$cambio.'">'; 
		echo '</form>';
		echo'<script language="Javascript">
			 document.form3.submit();
			 </script>';
	}
?>
<?php
	$link=conectarServidor();
	$qry="select Id_cambio as Cambio, nom_personal as Responsable, Fech_cambio as Fecha 
	from cambios, personal WHERE Cod_persona=Id_personal and Id_cambio=$cambio;";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
 ?>
<form method="post" action="det_cambio_pres.php" name="form1">
  <table  align="center" border="0">
    <tr>
      <td width="115" ><div align="right"><strong>No. de Cambio </strong> </div></td>
      <td width="41" align="left"><?php echo $cambio;?></td>
      <td width="134" align="right"><strong>Fecha de Cambio </strong></td>
      <td width="118" ><?php echo $row['Fecha']; ?></td>
      <td width="96" align="right"><strong>Responsable</strong></td>
      <td colspan="2"><div align="left"><?php echo $row['Responsable']; ?> </div></td>
    </tr>

    <tr>
      	<td colspan="7">&nbsp;</td>
    </tr>
    <?php
	if ($Crear==3)
	{
	echo '
    <tr>
      	<td colspan="4"><div align="center"><strong>Presentaciones Origen</strong></div></td>
      	<td><div align="center"><strong>Unidades</strong></div></td>
        <td width="94"><div align="center"><strong>Lote</strong></div></td>
        <td width="83">&nbsp;</td>
    </tr>
    <tr>
      	<td colspan="4"><div align="center">';
			echo'<select name="Cod_prese_ant">';
			$result=mysqli_query($link,"select inv_prod.Cod_prese, Nombre from inv_prod, prodpre WHERE inv_prod.Cod_prese=prodpre.Cod_prese group BY Cod_prese order by Nombre;");
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
            }
            echo'</select>';
			mysqli_close($link);
      echo '</div></td>
    	<td ><div align="center"><input name="cant_ant" type="text" onKeyPress="return aceptaNum(event)" size=10 ></div></td>
        <td ><div align="center"><input name="lote" type="text" size=10 ></div></td>
        <td align="right"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar"></td>
    </tr>
    <tr>
      	<td colspan="7">&nbsp;</td>
    </tr>';
	echo'<input name="Crear" type="hidden" value="1">'; 
	echo'<input name="cambio" type="hidden" value="'.$cambio.'">'; 
	}
	?> 
     
	</table>
    </form>
	<table align="center">
    <tr>
      <td  colspan="4" class="titulo">Productos a Cambiar : </td>
    </tr> 
          <tr>
            <th width="91" align="center">C&oacute;digo</th>
            <th width="404" align="center">Producto por Presentaci&oacute;n</th>
			<th width="91" align="center">Lote </th>
            <th width="107" align="center">Cantidad </th>
          </tr>
          <?php
			$link=conectarServidor();
			$qry="select Id_cambio, Cod_prese_ant, Nombre, lote_prod, Can_prese_ant from det_cambios, prodpre WHERE Cod_prese_ant=Cod_prese AND Id_cambio=$cambio;";
			$result=mysqli_query($link,$qry);
			while($row=mysqli_fetch_array($result))
			{
			echo'<tr>
			  <td><div align="center">'.$row['Cod_prese_ant'].'</div></td>
			  <td><div align="center">'.$row['Nombre'].'</div></td>
  			  <td><div align="center">'.$row['lote_prod'].'</div></td>
			  <td><div align="center">'.$row['Can_prese_ant'].'</div></td>
			</tr>';
			}
			?>
      </table>
<form method="post" action="det_cambio_pres.php" name="form2">
  <table width="707" border="0"  align="center">
  <?php
  	if ($Crear==4)
	{
	  echo '
	  <tr>
		  <td colspan="3"><div align="center"><strong>Presentaciones Destino </strong></div></td>
		  <td width="93"><div align="center"><strong>Unidades</strong></div></td>
		  <td width="94"><div align="center"><strong>Lote</strong></div></td>
		  
	  </tr>
	  <tr>
		  <td colspan="3"><div align="center">';
			  $link=conectarServidor();
			  echo'<select name="Cod_prese_nvo">';
			  $result=mysqli_query($link,"SELECT Cod_prese, Nombre FROM prodpre where Cod_produc=(select Cod_produc FROM prodpre where Cod_prese=$Cod_prese_ant);");
			  while($row=mysqli_fetch_array($result))
			  {
				  echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
			  }
			  echo'</select>';
			  mysqli_close($link);
      	echo '</div></td>
	  	<td><div align="center"><input name="cant_nvo" type="text" size=10  onKeyPress="return aceptaNum(event)"></div></td>';
        echo '<td><div align="center"><input name="lote" type="text" size=10 value="'.$lote.'" readonly ></div></td>
        <td width="83"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar"></td>
    	</tr>';
	  echo'<input name="Crear" type="hidden" value="2">'; 
	  echo'<input name="Cod_prese_ant" type="hidden" value="'.$Cod_prese_ant.'">'; 
	  echo'<input name="cambio" type="hidden" value="'.$cambio.'">'; 
	}
	?> 
	<tr>
      
    </tr>
    <tr>
      <td  colspan="3" class="titulo">Productos  Cambiados : </td>
    </tr>  
	</table>
</form>
<table align="center">
          <tr>
            <th width="91">C&oacute;digo</th>
            <th width="404">Producto por Presentaci&oacute;n</th>
			<th width="91">Lote </th>
            <th width="107">Cantidad </th>
          </tr>
          <?php
			$link=conectarServidor();
			$qry="select Id_cambio, Cod_prese_nvo, Nombre, lote_prod, Can_prese_nvo from det_cambios2, prodpre WHERE Cod_prese_nvo=Cod_prese AND Id_cambio=$cambio;";
			$result=mysqli_query($link,$qry);
			while($row=mysqli_fetch_array($result))
			{
			echo'<tr>
			  <td><div align="center">'.$row['Cod_prese_nvo'].'</div></td>
			  <td><div align="center">'.$row['Nombre'].'</div></td>
  			  <td><div align="center">'.$row['lote_prod'].'</div></td>
			  <td><div align="center">'.$row['Can_prese_nvo'].'</div></td>
			</tr>';
			}
			mysqli_free_result($result);
			mysqli_close($link);
			?>
      </table>


<table width="27%" border="0" align="center">
<tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Terminar"></div></td>
    </tr>
</table> 
</div>
</body>
</html>