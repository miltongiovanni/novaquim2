<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Detalle de Kit</title>
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
<div id="saludo1"><strong>DETALLE DE KIT</strong></div> 
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();  
	if($Crear==1)
	{
		//PRECIOS DE PRODUCTOS DE LA EMPRESA
		$qryins_p="insert into det_kit (Id_kit, Cod_producto) values ($Cod_kit, $cod_producto)";
		$resultins_p=mysqli_query($link,$qryins_p);
	}
	$qry1="SELECT Id_kit, Codigo, Nombre as Producto, Nom_envase from kit, prodpre, envase where Codigo=Cod_prese AND Cod_env=envase.Cod_envase AND Id_kit=$Cod_kit
	union
	SELECT Id_kit, Codigo, Producto, Nom_envase from kit, distribucion, envase where Codigo=Id_distribucion AND Cod_env=envase.Cod_envase and Id_kit=$Cod_kit";
	$result1=mysqli_query($link,$qry1);
	$row1=mysqli_fetch_array($result1, MYSQLI_BOTH);
	mysqli_close($link);
 ?>
<table width="515" border="0"  align="center">
    <tr>
        <td colspan="4" class="font2"><div align="left" class="titulo"><strong>Detalle del Kit</strong></div></td>
        <td width="192"></td>
    </tr>
    <tr> <td colspan="5" class="font2" ><hr></td> </tr>
    <tr>
        <td width="95" class="font2" ><div align="center"><strong>Codigo Kit:</strong></div></td>
        <td width="40" align="left" class="font2"><?php echo $row1['Id_kit']; ?></td>
        <td width="85" class="font2" ><div align="right"><strong>Nombre Kit:</strong></div></td>
   	  <td colspan="2" class="font2"><div align="left"><?php echo $row1['Producto']; ?></div></td>
  	</tr>
    <tr> <td  colspan="5" class="font2" ><hr></td> </tr>
    <?php
    $link=conectarServidor(); 
	echo '<form method="post" action="det_kits.php" name="form1">
		 <tr>
			<td colspan="4"><div align="center"><strong>Productos Novaquim</strong></div></td>
			<td colspan="1"><div align="left"><strong></strong></div></td>
		 </tr>
		 <tr> <td colspan="4"><div align="center">';
	echo'<select name="cod_producto">';
	$result2=mysqli_query($link,"SELECT Cod_prese, Nombre FROM prodpre order by Nombre;");
	while($row2=mysqli_fetch_array($result2))
	{
		echo '<option value='.$row2['Cod_prese'].'>'.$row2['Nombre'].'</option>';
	}
	echo '</select>';
	echo '</div></td>';
	echo '<td align="left"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar" /></td>';
	echo '</tr> ';
	echo '<input name="Crear" type="hidden" value="1">'; 
	echo '<input name="Cod_kit" type="hidden" value="'.$Cod_kit.'"></form>
		 <form method="post" action="det_kits.php" name="form2">
		 <tr><td colspan="4"><div align="center"><strong>Productos Distribución</strong></div></td>
		 <td colspan="1"><div align="left"><strong></strong></div></td></tr>
		<tr>
			<td colspan="4" ><div align="center">';
	echo'<select name="cod_producto">';
	$result3=mysqli_query($link,"select Id_distribucion, Producto from distribucion where Activo=0 order by Producto;");
	while($row3=mysqli_fetch_array($result3))
	{
		echo '<option value='.$row3['Id_distribucion'].'>'.$row3['Producto'].'</option>';
	}
	echo '</select>';
	echo '</div></td>';
	echo '<td align="left"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar" /></td>';
	echo '<input name="Crear" type="hidden" value="1">'; 
	echo '<input name="Cod_kit" type="hidden" value="'.$Cod_kit.'">';			  
	echo '</tr>';
	echo '<input name="Crear" type="hidden" value="1">'; 
	echo '<input name="Cod_kit" type="hidden" value="'.$Cod_kit.'"></form>';
	mysqli_close($link);
	?>
  <tr> <td  colspan="5" class="font2" ><hr></td> </tr>
  <tr><td colspan="5" class="titulo">Productos del Kit : </td>    </tr>   
</table>
<table width="517" border="0" align="center">
          <tr> <td  colspan="3" class="font2" ><hr></td> </tr>
          <tr>
            <th width="83" class="font2"><strong>Código</strong></th>
            <th width="340" class="font2"><strong>Producto </strong></th>
            <th width="80" class="font2"></th>
  </tr>
  <tr> <td  colspan="3" class="font2" ><hr></td> </tr>
          <?php
			$link=conectarServidor();
			$qry4="select det_kit.Id_kit, Cod_producto, Nombre from det_kit, prodpre WHERE det_kit.Id_kit=$Cod_kit AND Cod_producto=Cod_prese;";
			if ($result4=mysqli_query($link,$qry4))
			{
				while($row4=mysqli_fetch_array($result4))
				{
					$cod=$row4['Cod_producto'];
					echo'<tr>';
					echo '<td class="font2"><div align="center">'.$row4['Cod_producto'].'</div></td>
					  <td class="font2"><div align="center">'.$row4['Nombre'].'</div></td>';
						echo '<form action="delprodKit.php" method="post" name="elimina">
						<td align="center" valign="middle" class="font2"><input type="submit" class="formatoBoton" name="Submit" value="Eliminar" /></td>
						<input name="pedido" type="hidden" value="'.$pedido.'"/>
						<input name="producto" type="hidden" value="'.$cod.'"/>
						</form>';
					echo '</tr>';
				}
			}
			mysqli_close($link);
			?>
		<?php
			$link=conectarServidor();
			$qry5="select det_kit.Id_kit, Cod_producto, Producto from det_kit, distribucion WHERE det_kit.Id_kit=$Cod_kit AND Cod_producto=Id_distribucion;";
			if ($result5=mysqli_query($link,$qry5))
			{
				while($row5=mysqli_fetch_array($result5))
				{
					$cod=$row5['Cod_producto'];
					echo'<tr>';
					echo '</td>
				  <td class="font2"><div align="center">'.$row5['Cod_producto'].'</div></td>
				  <td class="font2"><div align="center">'.$row5['Producto'].'</div></td>';
					echo '<form action="delprodKit.php" method="post" name="elimina">
					<td align="center" valign="middle" class="font2"><input type="submit" class="formatoBoton" name="Submit" value="Eliminar" /> </td>
					<input name="Cod_kit" type="hidden" value="'.$Cod_kit.'"/>
					<input name="producto" type="hidden" value="'.$cod.'"/>
					</form>';
					echo '</tr>';
				}
			}
			mysqli_close($link);
			?>
            <tr> <td  colspan="3" class="font2" ><hr></td> </tr>           
      </table>
<?php 
  echo'<input name="Crear" type="hidden" value="0">'; 
?> 
<table width="27%" border="0" align="center">
    <tr> 
        <td><div align="center"><input name="Menu" type="button" class="resaltado" id="Menu" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
    </tr>
</table> 
</div>
</body>
</html>
	   