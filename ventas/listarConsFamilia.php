<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Consulta de Venta de Productos por Familia</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE VENTA DE PRODUCTOS POR FAMILIA</strong></div> 

<?php
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}

?>

<table border="0" align="center" width="700">
  <tr> 
      <form action="ProductosXFamilia_Xls.php" method="post" target="_blank"><td width="596" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="FchIni" type="hidden" value="<?php echo $FchIni ?>"><input name="FchFin" type="hidden" value="<?php echo $FchFin ?>"></form>
      <td width="94"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="83" class="formatoEncabezados">Código</th>
      <th width="313" class="formatoEncabezados">Producto</th>
      <th width="88" class="formatoEncabezados">Cantidad</th>
      <th width="94" class="formatoEncabezados">Precio</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql= "	select fechaFactura, codProducto, Producto, SUM(cantProducto) as Cantidad, precioProducto, Cod_ant 
from factura, det_factura, prodpre, precios 
where idFactura=idFactura and codProducto=Cod_prese and Cod_ant=codigo_ant and fechaFactura>='$FchIni' and fechaFactura<'$FchFin' group BY Cod_ant order by Cantidad desc;";
$result=mysqli_query($link, $sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$Tot=number_format($row['prec_producto'], 0, '.', ',');
	echo'<tr';
	  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center">'.$row['Cod_ant'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Cantidad'].'</div></td>
	<td class="formatoDatos"><div align="center">$ '.$Tot.'</div></td>
	</tr>';
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
 </body>
</html>