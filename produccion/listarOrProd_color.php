<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de &Oacute;rdenes de Producci&oacute;n de Color</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE &Oacute;RDENES DE PRODUCCI&Oacute;N DE COLOR</strong></div>

<table width="100%" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo">
	<tr>
      <th width="33" class="formatoEncabezados"></th>
      <th width="49" class="formatoEncabezados">Lote</th>
      <th width="232" class="formatoEncabezados">Soluci&oacute;n de Color</th>
      <th width="106" class="formatoEncabezados">Fecha Producci&oacute;n</th>
      <th width="211" class="formatoEncabezados">Responsable</th>
      <th width="55" class="formatoEncabezados">Cantidad</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	select Lote_color as Lote, Fch_prod as 'Fecha de Producción', Nom_mprima as 'Nombre de Producto', Cant_kg as 'Cantidad (Kg)', nom_personal as Responsable  
from ord_prod_col, formula_col, mprimas, personal WHERE Id_form_color=Id_form_col AND Cod_sol_col=Cod_mprima and Cod_persona=Id_personal order by Lote_color desc;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$lote=$row['Lote'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Lote'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nombre de Producto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha de Producción'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Responsable'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  type="text/javascript"> document.write(commaSplit('.$row['Cantidad (Kg)'].')+" Kg")</script></div></td>
	';
	
	echo'</tr>';
	$sqli="SELECT det_ord_prod_col.Cod_mprima as Código, Nom_mprima, Can_mprima as Cantidad, Lote_MP
	from det_ord_prod_col, mprimas
	where det_ord_prod_col.Cod_mprima=mprimas.Cod_mprima and Lote = $lote;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="60%" border="0" align="center" cellspacing="0" summary="detalle">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="20%" class="formatoEncabezados">Materia Prima</th>
  	  <th width="10%" class="formatoEncabezados">Lote MP</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Código'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Nom_mprima'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Lote_MP'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  type="text/javascript"> document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>

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
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>