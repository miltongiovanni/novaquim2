<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Ingreso de Productos a dar de Baja</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
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
<div id="saludo1"><strong>DETALLE DE LA BAJA DE PRODUCTOS</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();  
	if ($Crear == 3)
	{
		$qryins_comp="insert into bajas (Res_baja, Fech_baja, Motivo) values ( '$respon', '$FchBaja', '$motivo')";
		echo $qryins_comp;
		$resultins_prod=mysqli_query($link,$qryins_comp);	
		$qrycam="select MAX(Id_baja) AS baja from bajas;";
		$resultqrycam=mysqli_query($link,$qrycam);
		$row_cam=mysqli_fetch_array($resultqrycam);
		$baja=$row_cam['baja'];
		  echo '<form method="post" action="det_baja.php" name="form3">';
		  echo'<input name="Crear" type="hidden" value="5">'; 
		  echo'<input name="baja" type="hidden" value="'.$baja.'">'; 
		  echo '</form>';
		  echo'<script >
				document.form3.submit();
				</script>';
		mysqli_close($link);
	}
	if($Crear==1)
	{
		//PRODUCTOS DE LA EMPRESA
		$unidades=$cantidad;
		$qryinv="select Cod_prese, lote_prod, inv_prod from inv_prod where Cod_prese=$cod_producto and inv_prod >0 order by lote_prod;";
		$resultinv=mysqli_query($link,$qryinv);
		while($rowinv=mysqli_fetch_array($resultinv))
		{
			$invt=$rowinv['inv_prod'];
			$lot_prod=$rowinv['lote_prod'];
			$cod_prod=$rowinv['Cod_prese'];
			if (($invt >= $unidades))
			{
				$invt= $invt - $unidades;
				$qryins_p="insert into det_bajas (Cod_baja, Cod_producto, Can_producto, Lote_producto) values ( $baja, $cod_producto, $unidades, $lot_prod)";
				echo $qryins_p;
				echo'<script >
			alert("pausa")
			</script>';
				$resultins_p=mysqli_query($link,$qryins_p);
				$unidades=0;
				$qryupt="update inv_prod set inv_prod=$invt where lote_prod=$lot_prod and Cod_prese=$cod_prod";
				$resultupt=mysqli_query($link,$qryupt);
			}
			else
			{
				if ($invt>0)
				{
				  $unidades= $unidades - $invt;
				  $qryins_p="insert into det_bajas (Cod_baja, Cod_producto, Can_producto, Lote_producto) values ( $baja, $cod_producto, $invt, $lot_prod)";
				  echo $qryins_p;
				echo'<script >
			alert("pausa")
			</script>';
				  $resultins_p=mysqli_query($link,$qryins_p);
				  $qryupt="update inv_prod set inv_prod=0 where lote_prod=$lot_prod and Cod_prese=$cod_prod";
				  $resultupt=mysqli_query($link,$qryupt);	
				}
			}
		}
		echo '<form method="post" action="det_baja.php" name="form3">';
		echo'<input name="Crear" type="hidden" value="5">'; 
		echo'<input name="baja" type="hidden" value="'.$baja.'">'; 
		echo '</form>';
		echo'<script >
			document.form3.submit();
			</script>';
		mysqli_close($link);
	}
	if($Crear==2)
	{
		//PRECIOS DE PRODUCTOS DE DISTRIBUCIÓN
		$qryins_d="insert into det_bajas (Cod_baja, Cod_producto, Can_producto) values ( $baja, $cod_producto, $cantidad)";
		echo $qryins_d;
				echo'<script >
			alert("pausa")
			</script>';
		$resultins_d=mysqli_query($link,$qryins_d);
		$qryinv="select Id_distribucion, inv_dist from inv_distribucion WHERE Id_distribucion=$cod_producto;";
		$resultinv=mysql_db_query($bd,$qryinv);
		$unidades=$cantidad;
		while($rowinv=mysqli_fetch_array($resultinv))
		{
			$invt=$rowinv['inv_dist'];
			$cod_prod=$rowinv['Id_distribucion'];
			$invt= $invt - $unidades;
			$qryupt="update inv_distribucion set inv_dist=$invt where Id_distribucion=$cod_prod";
			$resultupt=mysqli_query($link,$qryupt);
		}
		echo '<form method="post" action="det_baja.php" name="form3">';
		echo'<input name="Crear" type="hidden" value="5">'; 
		echo'<input name="baja" type="hidden" value="'.$baja.'">'; 
		echo '</form>';
		echo'<script >
			document.form3.submit();
			</script>';
		mysqli_close($link);
	}
?>
<?php
		$link=conectarServidor();
		$qry="select Id_baja, Res_baja, Fech_baja from bajas where Id_baja=$baja;";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		if ($row)
			mysqli_close($link);
		else
		{
			mysqli_close($link);
			mover("baja.php","No existe la Relación de Baja");
		}	
		function mover($ruta,$nota)
		{
			//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
			echo'<script >
			alert("'.$nota.'")
			self.location="'.$ruta.'"
			</script>';
		}
	 ?>
<table  align="center" border="0">
    <tr>
      <td width="124" align="right" ><strong>No. de Baja</strong></td>
      <td width="53" align="left"><?php echo $baja;?></td>
      <td width="53" align="right" ><strong>Responsable</strong></td>
      <td width="243" align="left"><?php echo $row['Res_baja']; ?></td>
      <td width="44" align="right"><strong>Fecha </strong></td>
      <td width="100" align="left"><?php echo $row['Fech_baja']; ?></td>
    </tr>
    <?php 
		$link=conectarServidor();
		echo '<form method="post" action="det_baja.php" name="form1">
		<tr><td colspan="4"><div align="center"><strong>Productos Novaquim</strong></div></td>
		<td colspan="2"><div align="center"><strong>Unidades</strong></div></td></tr>
		<tr><td colspan="4"><div align="center">';
		echo'<select name="cod_producto">';
		$result=mysqli_query($link,"select inv_prod.Cod_prese as Codigo, Nombre FROM inv_prod, prodpre WHERE inv_prod.Cod_prese=prodpre.Cod_prese and inv_prod>0 group by inv_prod.Cod_prese order by Nombre;");
        while($row=mysqli_fetch_array($result))
		{
			echo '<option value='.$row['Codigo'].'>'.$row['Nombre'].'</option>';
        }
		echo'</select>';
		echo '</div></td>';
		echo '<input name="Crear" type="hidden" value="1">'; 
		echo '<input name="baja" type="hidden" value="'.$baja.'">'; 		
		echo '<td colspan="2"><div align="center"><input name="cantidad" type="text" size=10 onKeyPress="return aceptaNum(event)" ></div></td>';
		echo '<td colspan="2" align="left"><input name="nova" onclick="return Enviar(this.form)" type="button"  value="Continuar"></td></tr>
		 </form>
		 <form method="post" action="det_baja.php" name="form2">
		<tr>
			<td colspan="4"><div align="center"><strong>Productos Distribuci&oacute;n</strong></div></td>
			<td colspan="2"><div align="center"><strong>Unidades</strong></div></td>
		</tr>
		<tr>
			<td colspan="4"><div align="center">';
		echo'<select name="cod_producto">';
		$result=mysqli_query($link,"select inv_distribucion.Id_distribucion as Codigo, Producto from inv_distribucion, distribucion where inv_distribucion.Id_distribucion=distribucion.Id_distribucion AND inv_dist>0 and Activo=0 order by Producto ");
		while($row=mysqli_fetch_array($result))
		{
			echo '<option value='.$row['Codigo'].'>'.$row['Producto'].'</option>';
		}
		echo '</select>';
		echo '</div></td>
			<td colspan="2"><div align="center"><input name="cantidad" type="text" size=10 onKeyPress="return aceptaNum(event)"></div></td>';
		echo '<input name="Crear" type="hidden" value="2">'; 
		echo '<input name="baja" type="hidden" value="'.$baja.'">'; 
		echo '<td colspan="2" align="left"><input name="cont" onclick="return Enviar(this.form)" type="button"  value="Continuar" ></td></tr>
		</form>';
		mysqli_close($link);
	?>
  <tr>
    <td  colspan="8" class="titulo">Productos de la Baja de Mercanc&iacute;a : </td>    
  </tr>  
</table>
<table border="0" align="center">
          <tr>
          	<th width="56" align="center"></th>
            <th width="84" align="center">C&oacute;digo</th>
            <th width="437" align="center">Producto</th>
			<th width="127" align="center">Cantidad</th>
            <th width="68" align="center"></th>
  </tr>
          <?php
			$link=conectarServidor();
			$qry="select Id_remision, Cod_producto, Lote_producto, Nombre, SUM(Can_producto) as Cantidad from det_remision1, prodpre where Id_remision=$remision AND Cod_producto=Cod_prese group by Cod_producto;";
			$result=mysqli_query($link,$qry);
			while($row=mysqli_fetch_array($result))
			{
				$cod=$row['Cod_producto'];
				$cantidad=$row['Cantidad'];
				echo'<tr><td align="center" valign="middle">';
				echo '<form action="updateRemision.php" method="post" name="actualiza">
					<input type="submit" name="Submit" value="Cambiar" >
					<input name="remision" type="hidden" value="'.$remision.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					</form>';
				echo '</td><td><div align="center">'.$row['Cod_producto'].'</div></td>
				  <td><div align="center">'.$row['Nombre'].'</div></td>
				  <td><div align="center">'.$row['Cantidad'].'</div></td>
				  <td align="center" valign="middle">';
				echo '<form action="delprodRem.php" method="post" name="elimina">
					<input type="submit" name="Submit" value="Eliminar" >
					<input name="remision" type="hidden" value="'.$remision.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					</form>';
				echo '</td></tr>';
			}
			mysqli_close($link);
			?>
		<?php
			$link=conectarServidor();
			$qry="select Id_remision, Cod_producto, Producto, Can_producto from det_remision1, distribucion where Id_remision=$remision AND Cod_producto=Id_distribucion;";
			$result=mysqli_query($link,$qry);
			while($row=mysqli_fetch_array($result))
			{
				$cod=$row['Cod_producto'];
				$cantidad=$row['Can_producto'];
				echo'<tr>
				<td align="center" valign="middle">';
				echo '<form action="updateRemision.php" method="post" name="actualiza">
					<input type="submit" name="Submit" value="Cambiar" >
					<input name="remision" type="hidden" value="'.$remision.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
				</form>';
				echo '</td>
			  <td><div align="center">'.$row['Cod_producto'].'</div></td>
			  <td><div align="center">'.$row['Producto'].'</div></td>
			  <td><div align="center">'.$row['Can_producto'].'</div></td>
			  <td align="center" valign="middle">';
				echo '<form action="delprodRem.php" method="post" name="elimina">
				<input type="submit" name="Submit" value="Eliminar" >
				<input name="remision" type="hidden" value="'.$remision.'">
				<input name="producto" type="hidden" value="'.$cod.'">
				<input name="cantidad" type="hidden" value="'.$cantidad.'">
				</form>';
				
				echo '</td></tr>';
			}
			mysqli_close($link);
			?>
            <tr>
                <td colspan="5">
                    <form action="Imp_Baja.php" method="post" target="_blank">
                    <div align="center">
                    <input name="baja" type="hidden" value="<?php echo $baja; ?> ">
                    <input type="submit" name="Submit" value="Imprimir Remisi&oacute;n" >
                    </div>
                    </form>  
                </td> 
            </tr>           
      </table>
      <?php 
		  echo'<input name="Crear" type="hidden" value="0">'; 
		  echo'<input name="remision" type="hidden" value="'.$remision.'">'; 
	  ?> 

<table width="27%" border="0" align="center">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
        </div></td>
    </tr>
</table>
</div> 
</body>
</html>
	   