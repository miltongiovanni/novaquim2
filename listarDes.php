<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista Relaci&oacute;n Paca Producto</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>RELACI&Oacute;N PRODUCTOS POR PACA</strong></div>
<table width="100%" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table width="490" border="0" align="center" cellspacing="0">
<tr>
    <th width="22" class="formatoEncabezados"></th>
    <th width="44" class="formatoEncabezados">Item</th>
    <th width="68" class="formatoEncabezados">C&oacute;digo</th>
    <th width="296" class="formatoEncabezados"> Paca de Productos</th>
</tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="select Id_rel, Cod_paca, Producto from rel_dist_emp, distribucion where Cod_paca=Id_distribucion;";
$result=mysqli_query($link,$sql);

$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$Id=$row['Id_rel'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id_rel'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Cod_paca'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>';
	echo'</tr>';
	$sqli="select Id_rel, Cod_unidad, Producto, Cantidad from rel_dist_emp, distribucion where Cod_unidad=Id_distribucion and Id_rel=$Id;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="400" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="30" class="formatoEncabezados" align="center">C&oacute;digo</th>
	  <th width="340" class="formatoEncabezados" align="center">Producto</th>
      <th width="30" class="formatoEncabezados" align="center">Cantidad</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
			echo '<tr>
			<td class="formatoDatos"><div align="center">'.$rowi['Cod_unidad'].'</div></td>
			<td class="formatoDatos"><div align="center">'.$rowi['Producto'].'</div></td>
			<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>
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
<table width="27%" border="0" align="center">
<tr>
        <td class="formatoDatos">&nbsp;</td>
  </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
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