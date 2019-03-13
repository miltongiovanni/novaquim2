<?php
include "includes/valAcc.php";
include "includes/conect.php";
//echo $_SESSION['Perfil'];
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de Producto</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
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
	  $qry="select Cod_tapa, Nom_tapa from tapas_val where Cod_tapa=$IdTap";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_close($link);
?>
<div id="saludo"><strong>AJUSTE DE INVENTARIO DE <?php echo strtoupper($row['Nom_tapa']); ?></strong></div>
<table border="0" align="center" width="25%">
	<tr> 
		<td width="43%"><div align="center"><strong>Inventario </strong></div></td>
	</tr>
    <?php 
		$link=conectarServidor();
		$qry="select Cod_tapa, inv_tapa from inv_tapas_val where Cod_tapa=$IdTap;";
		if ($result=mysqli_query($link,$qry))
		{
			$row=mysqli_fetch_array($result);
			$inv=$row['inv_tapa'];
			echo '<tr><form action="updateInvTap.php" method="post" name="actualiza">';
			echo '<td><div align="center"><input name="inv" type="text" size="5" value="'.$row['inv_tapa'].'"></div></td>';
			echo '<td align="center" valign="middle">';
			echo '<input type="Submit" class="formatoBoton" name="Submit" value="Cambiar" >
				  <input name="IdTap" type="hidden" value="'.$IdTap.'">
				  <input name="inv_ant" type="hidden" value="'.$inv.'">';
			echo '</td></form></tr>';
			mysqli_close($link);
		}
	?>
    <tr> 
      <td>&nbsp;</td>
      <td width="15%">&nbsp;</td>
      <td width="42%"><div align="left"> </div></td>
    </tr>
  </table>
</div>
</body>
</html>
