<?php
include "includes/valAcc.php";
include "includes/conect.php";
//echo $_SESSION['Perfil'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar Inventario de Producto de Distribuci&oacute;n</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">

<?php
	  $link=conectarServidor();
	  foreach ($_POST as $nombre_campo => $valor) 
	  { 
		  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
		  //echo $nombre_campo." = ".$valor."<br>";  
		  eval($asignacion); 
	  }  
	  $qry="SELECT Id_distribucion, Producto from distribucion where Id_distribucion=$IdDist";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_close($link);
?>
<div id="saludo"><strong>AJUSTE DE INVENTARIO DE <?php echo strtoupper($row['Producto']); ?></strong></div>
<table border="0" align="center" width="34%">
	<tr> 
		<td width="43%"><div align="center"><strong>Inventario </strong></div></td>
	</tr>
    <?php 
		$link=conectarServidor();
		$qry="select Id_distribucion, invDistribucion from inv_distribucion where Id_distribucion=$IdDist;";
		if ($result=mysqli_query($link,$qry))
		{
			$row=mysqli_fetch_array($result);
			$inv=$row['inv_dist'];
			echo '<tr><form action="updateInvDist.php" method="post" name="actualiza">';
			echo '<td><div align="center"><input name="inv" type="text" size="5" value="'.$row['inv_dist'].'"/></div></td>';
			echo '<td align="center" valign="middle">';
			echo '<input type="submit" class="formatoBoton" name="Submit" value="Cambiar" >
				  <input name="IdDist" type="hidden" value="'.$IdDist.'">
				  <input name="inv_ant" type="hidden" value="'.$inv.'">';
			echo '</td></form></tr>';
			mysqli_close($link);
		}
	?>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="left"> </div></td>
    </tr>
  </table>
</div>
</body>
</html>
