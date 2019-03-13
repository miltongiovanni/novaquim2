<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Consulta de Stock de Inventario de Producto Terminado</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE STOCK DE INVENTARIO DE PRODUCTO TERMINADO</strong></div>

<table  align="center" width="700" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellspacing="0">
<tr>
      <th width="17" class="formatoEncabezados"></th>
    <th width="80" class="formatoEncabezados">C&oacute;digo</th>
    <th width="409" class="formatoEncabezados">Producto</th>
    <th width="78" class="formatoEncabezados">Cantidad</th>
    <th width="56" class="formatoEncabezados">Stock</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	SELECT inv_prod.Cod_prese as Codigo, Nombre, sum(inv_prod) as inventario, stock_prese 
FROM inv_prod, prodpre, productos, medida
where inv_prod.Cod_prese=prodpre.Cod_prese AND medida.Id_medida=prodpre.Cod_umedid and productos.Cod_produc=prodpre.Cod_produc 
group by Codigo ORDER BY Nom_produc, cant_medida;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	if ($row['inventario'] < $row['stock_prese'])
	{
		$prod=$row['Codigo'];
		echo'<tr';
	 	 if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	 	 echo '>
		<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
		<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
		<td class="formatoDatos"><div align="left">'.$row['Nombre'].'</div></td>
		<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$row['inventario'].'))</script></div></td>
		<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$row['stock_prese'].'))</script></div></td>';
		echo'</tr>';
		$sqli="select inv_prod.Cod_prese as Codigo, Nombre, lote_prod, inv_prod as Inventario 
		from inv_prod, prodpre where inv_prod.Cod_prese=prodpre.Cod_prese and inv_prod.Cod_prese=$prod and inv_prod>0;";
		$resulti=mysqli_query($link,$sqli);
		echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="60%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
		<tr>
		  <th width="6%" class="formatoEncabezados">Lote</th>
		  <th width="5%" class="formatoEncabezados">Cantidad</th>
		</tr>';
		while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
		{
		echo '<tr>
		<td class="formatoDatos"><div align="center">'.$rowi['lote_prod'].'</div></td>
		<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$rowi['Inventario'].'))</script></div></td>
		</tr>';
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