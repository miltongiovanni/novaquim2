<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Órdenes de Producción de Materia Prima</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE ÓRDENES DE PRODUCCIÓN DE MATERIA PRIMA</strong></div>

<table width="100%" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo">
	<tr>
      <th width="33" class="formatoEncabezados"></th>
      <th width="49" class="formatoEncabezados">Lote</th>
      <th width="232" class="formatoEncabezados">Solución de Color</th>
      <th width="106" class="formatoEncabezados">Fecha Producción</th>
      <th width="211" class="formatoEncabezados">Responsable</th>
      <th width="55" class="formatoEncabezados">Cantidad</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="select Lote_mp, Fch_prod, Cant_kg, Nom_mprima, nom_personal from ord_prod_mp, mprimas, personal where ord_prod_mp.Cod_mprima=mprimas.Cod_mprima and Cod_persona=Id_personal order by Lote_mp desc;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$lote=$row['Lote_mp'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Lote_mp'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nom_mprima'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fch_prod'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['nom_personal'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$row['Cant_kg'].')+" Kg")</script></div></td>
	';
	
	echo'</tr>';
	$sqli="select  Id_mprima, Can_mprima, Lote_MP, Nom_mprima from det_ord_prod_mp, mprimas where Id_mprima=Cod_mprima and Lote_mprima=$lote;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="60%" border="0" align="center" cellspacing="0" summary="detalle">
	<tr>
      <th width="6%" class="formatoEncabezados">Código</th>
	  <th width="20%" class="formatoEncabezados">Materia Prima</th>
  	  <th width="10%" class="formatoEncabezados">Lote MP</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Id_mprima'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Nom_mprima'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Lote_MP'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Can_mprima'].'))</script></div></td>

	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulti);
/* cerrar la conexión */
mysqli_close($link);
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>