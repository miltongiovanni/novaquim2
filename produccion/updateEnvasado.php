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
<title>Actualizar datos de Envasado por Lote de Producto</title>
<script  src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACIÓN DE ENVASADO POR PRESENTACIÓN</strong></div>
<table border="0" align="center">
  <tr>
    <td width="417"><div align="center"><strong>Presentación de Producto</strong></div></td>
    <td width="91"><div align="center"><strong>Cantidad</strong></div></td>
  </tr>
  <form action="update_Envas.php" method="post" name="actualiza">
  <?php
	$link=conectarServidor();
	$Lote=$_POST['Lote'];
	$cod_pres=$_POST['Presentacion'];
	$cantidad=$_POST['Cantidad'];
	$qry="SELECT Lote, Con_prese as Codigo, Nombre AS Presentacion, Can_prese as Cantidad 
	FROM envasado, prodpre
	WHERE Con_prese=Cod_prese and Lote=$Lote and Con_prese=$cod_pres;";
	echo $qry;
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$codpres=$row['Codigo'];
	$Presentacion=$row['Presentacion'];
	$Cantidad=$row['Cantidad'];
	echo '<input name="Lote" type="hidden" value="'.$Lote.'">';
	echo '<tr>';
	echo '<td align="center">';
 	echo $Presentacion;
	echo '<input name="Codpres" type="hidden" value="'.$codpres.'">';
 	echo '</td>';	
	echo '<td align="center">';
	echo '<input name="Cantidad_ant" type="hidden" value="'.$Cantidad.'">';
 	echo'<input size=10 name="Cantidad" type="text" value="'.$Cantidad.'">';
 	echo '</td>';	
	echo '</tr>';
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
	?>
	<tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
	</tr>
	<tr >
   	  <td colspan="2"><div align="center"><input type="submit" name="Submit" value="Cambiar"></div></td>
	</tr>
  </form>
</table>
</div>
</body>
</html>
