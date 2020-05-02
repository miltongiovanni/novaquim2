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
<title>Actualizar datos de Producto</title>
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
		  echo $nombre_campo." = ".$valor."<br>";  
		  eval($asignacion); 
	  }  
	  $qry="SELECT Cod_envase, Nom_envase FROM envase where Cod_envase=$IdEnv";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_close($link);
?>
<div id="saludo"><strong>AJUSTE DE INVENTARIO DE <?php echo strtoupper($row['Nom_envase']); ?></strong></div>
<table border="0" align="center" width="34%">
	<tr> 
		<td width="43%"><div align="center"><strong>Inventario </strong></div></td>
	</tr>
    <?php 
		$link=conectarServidor();
		$qry="SELECT codEnvase, invEnvase from inv_envase where codEnvase=$IdEnv;";
		if ($result=mysqli_query($link,$qry))
		{
			$row=mysqli_fetch_array($result);
			$inv=$row['inv_envase'];
			echo '<tr><form action="updateInvEnv.php" method="post" name="actualiza">';
			echo '<td><div align="center"><input name="inv" type="text" size="5" value="'.$row['inv_envase'].'"/></div></td>';
			echo '<td align="center" valign="middle">';
			echo '<input type="submit" class="formatoBoton" name="Submit" value="Cambiar" >
				  <input name="IdEnv" type="hidden" value="'.$IdEnv.'">
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
