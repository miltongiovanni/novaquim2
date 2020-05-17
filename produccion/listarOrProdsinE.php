<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Órdenes de Producción sin Envasar</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE ÓRDENES DE PRODUCCIÓN SIN ENVASAR</strong></div>

<table width="100%" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo" width="90%">
	<tr>
      <th width="2%" class="formatoEncabezados"></th>
      <th width="6%" class="formatoEncabezados">Lote</th>
      <th width="27%" class="formatoEncabezados">Producto</th>
      <th width="27%" class="formatoEncabezados">Fórmula</th>
      <th width="9%" class="formatoEncabezados">Fecha Producción</th>
      <th width="13%" class="formatoEncabezados">Responsable</th>
      <th width="8%" class="formatoEncabezados">Estado</th>
      <th width="8%" class="formatoEncabezados">Cantidad</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	SELECT Lote, Fch_prod as 'Fecha de Producción', Nom_produc as 'Nombre de Producto', 
nomFormula as 'Formulación', Cant_kg as 'Cantidad (Kg)', nom_personal as Responsable, Estado
FROM ord_prod, formula, productos, personal
WHERE ord_prod.Id_form=formula.idFormula AND formula.codProducto=productos.Cod_produc and Cod_persona=Id_personal and (Estado='P' or Estado='C')
order by Lote desc;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$lote=$row['Lote'];
	$est=$row['Estado'];
	if($est=='P')
		$estadop="En producción";
	if($est=='C')
		$estadop="En Calidad";
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Lote'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nombre de Producto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Formulación'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha de Producción'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Responsable'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$estadop.'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$row['Cantidad (Kg)'].')+" Kg")</script></div></td>
	';
	
	echo'</tr>';
	$sqli="SELECT det_ord_prod.Cod_mprima as Código, Nom_mprima, Can_mprima as Cantidad, Lote_MP
	from det_ord_prod, mprimas
	where det_ord_prod.Cod_mprima=mprimas.Cod_mprima and Lote = $lote 
	order by Orden;";
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
	<td class="formatoDatos"><div align="center">'.$rowi['Código'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Nom_mprima'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Lote_MP'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>

	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
//mysqli_free_result($resulti);
/* cerrar la conexión */
mysqli_close($link);
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>