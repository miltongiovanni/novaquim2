<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Precios</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE PRECIOS</strong></div>
<table width="100%" border="0">
  <tr>
  	<td width="72%">&nbsp;</td> <form action="Lista_Precios_Xls.php" method="post" target="_blank">
  	<td width="9%"><input name="Submit" type="submit" class="formatoBoton" value="Exportar a Excel"/></td> </form><form action="Sel_Lista_Precios.php" method="post" target="_blank">
  	<td width="13%"><input name="Submit" type="submit" class="formatoBoton" value="Imprimir Lista de Precios"/></td> </form>
    <td width="6%"><input type="button" class="formatoBoton" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></td>
  </tr>
</table>
<table width="80%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
<tr>
      <th width="9%" class="formatoEncabezados">C&oacute;digo</th>
      <th width="41%" class="formatoEncabezados">Descripci&oacute;n</th>
      <th width="10%" class="formatoEncabezados">Precio Super</th>
      <th width="10%" class="formatoEncabezados">Precio F&aacute;brica</th>
      <th width="10%" class="formatoEncabezados">Precio Mayorista</th>
      <th width="10%" class="formatoEncabezados">Precio Distribuci&oacute;n</th>
    <th width="10%" class="formatoEncabezados">Precio Detal</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
	$link=conectarServidor();
	$sql="	select codigo_ant, producto, fabrica, distribuidor, detal, mayor, super, cant_medida, Cod_produc
from precios, (select DISTINCTROW Cod_ant, cant_medida, Cod_produc from prodpre, precios, medida where Cod_ant=codigo_ant and Cod_umedid=Id_medida and pres_activa=0 group by Cod_ant) as tabla 
where pres_activa=0 and codigo_ant=Cod_ant order by Cod_produc,  cant_medida";
	//llamar funcion de tabla
	$result=mysqli_query($link,$sql);
	$a=1;
	while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
	{
		echo'<tr';
	  	if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  	echo '>
		<td class="formatoDatos"><div align="center">'.$row['codigo_ant'].'</div></td>
		<td class="formatoDatos"><div align="left">'.$row['producto'].'</div></td>
		<td class="formatoDatos"><div align="center">$ <script language="javascript"> document.write(commaSplit('.$row['super'].'))</script></div></td>
		<td class="formatoDatos"><div align="center">$ <script language="javascript"> document.write(commaSplit('.$row['fabrica'].'))</script></div></td>
		<td class="formatoDatos"><div align="center">$ <script language="javascript"> document.write(commaSplit('.$row['mayor'].'))</script></div></td>
		<td class="formatoDatos"><div align="center">$ <script language="javascript"> document.write(commaSplit('.$row['distribuidor'].'))</script></div></td>
		<td class="formatoDatos"><div align="center">$ <script language="javascript"> document.write(commaSplit('.$row['detal'].'))</script></div></td>
		</tr>';
	}
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

</table>
<table width="27%" border="0" align="center">
    <tr>
        <td>&nbsp;</td>
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