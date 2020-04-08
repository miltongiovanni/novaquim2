<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Consulta de Stock de Inventario de Materia Prima</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE STOCK DE INVENTARIO DE MATERIA PRIMA</strong></div>

<table  align="center" width="700" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table  border="0" align="center" cellspacing="0" >
<tr>
    <th width="23" class="formatoEncabezados"></th>
    <th width="72" class="formatoEncabezados">C&oacute;digo</th>
    <th width="243" class="formatoEncabezados">Materia Prima</th>
    <th width="101" class="formatoEncabezados">Cantidad (Kg)</th>
    <th width="76" class="formatoEncabezados">Stock (Kg)</th>
</tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="SELECT inv_mprimas.Cod_mprima as Codigo, Nom_mprima as Nombre, sum(inv_mp) as inventario, Min_stock_mp as Stock FROM inv_mprimas, mprimas
where inv_mprimas.Cod_mprima=mprimas.Cod_mprima group by Codigo order by Nombre;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$prod=$row['Codigo'];
	$inventario=$row['inventario'];
	$stock=$row['Stock'];
	if ($stock > $inventario)
	{
		echo'<tr';
	 	 if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	 	 echo '>
		<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
		<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
		<td class="formatoDatos"><div align="left">'.$row['Nombre'].'</div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['inventario'].'))</script></div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['Stock'].'))</script></div></td>';
		echo'</tr>';

	
		$sqli="SELECT inv_mprimas.Cod_mprima as Codigo, Nom_mprima as Nombre, Lote_mp as Lote, inv_mp as inventario FROM inv_mprimas, mprimas
		where inv_mprimas.Cod_mprima=mprimas.Cod_mprima and inv_mprimas.Cod_mprima=$prod ;";
		$resulti=mysqli_query($link,$sqli);
		echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="60%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
		<tr>
		  <th width="6%" class="formatoEncabezados">Lote</th>
		  <th width="5%" class="formatoEncabezados">Cantidad</th>
		</tr>';
		while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
		{
			if ($rowi['inventario'] >0)
			{
				echo '<tr>
				<td class="formatoDatos"><div align="center">'.$rowi['Lote'].'</div></td>
				<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['inventario'].'))</script></div></td>
				</tr>';
			}
		}
		echo '</table></div></td></tr>';
	$a=$a+1;
	}
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