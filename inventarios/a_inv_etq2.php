<?php
include "../includes/valAcc.php";
include "includes/conect.php";
//echo $_SESSION['Perfil'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de Producto</title>
<script  src="../js/validar.js"></script>

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
	  $qry="select Cod_etiq, Nom_etiq from etiquetas where Cod_etiq=$IdEtq";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_close($link);
?>
<div id="saludo"><strong>AJUSTE DE INVENTARIO DE <?php echo strtoupper($row['Nom_etiq']); ?></strong></div>
<table border="0" align="center" width="25%">
	<tr> 
		<td width="43%"><div align="center"><strong>Inventario </strong></div></td>
	</tr>
    <?php 
		$link=conectarServidor();
		$qry="select codEtiq, invEtiq from inv_etiquetas where codEtiq=$IdEtq;";
		if ($result=mysqli_query($link,$qry))
		{
			$row=mysqli_fetch_array($result);
			$inv=$row['inv_etiq'];
			echo '<tr><form action="updateInvEtq.php" method="post" name="actualiza">';
			echo '<td><div align="center"><input name="inv" type="text" size="5" value="'.$row['inv_etiq'].'"></div></td>';
			echo '<td align="center" valign="middle">';
			echo '<input type="submit" class="formatoBoton" name="Submit" value="Cambiar" >
				  <input name="IdEtq" type="hidden" value="'.$IdEtq.'">
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
