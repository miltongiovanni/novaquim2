<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Compras de Materias Primas por Proveedor</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/Javascript">	function togglecomments (postid) {
		var whichpost = document.getElementById(postid);
		if (whichpost.className=="commentshown") { whichpost.className="commenthidden"; } else { whichpost.className="commentshown"; }
	}</script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE COMPRAS DE MATERIAS PRIMAS POR PROVEEDOR</strong></div>
<table width="1118" border="0">
  <tr> 
      <td width="1117"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0">
	<tr>
      <th width="18" class="formatoEncabezados"></th>
      <th width="64" class="formatoEncabezados">Id Compra</th>
      <th width="119" class="formatoEncabezados">NIT</th>
      <th width="287" class="formatoEncabezados">Proveedor</th>
      <th width="55" class="formatoEncabezados">Factura</th>
      <th width="114" class="formatoEncabezados">Fecha Compra</th>
      <th width="113" class="formatoEncabezados">Fecha Vencimiento</th>
      <th width="42" class="formatoEncabezados">Estado</th>
      <th width="84" class="formatoEncabezados">Valor Factura </th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

$link=conectarServidor();
$sql="	SELECT id_compra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp,
Fech_venc as 'Fecha Vcmto', Des_estado as Estado, total_fact as Total
FROM compras, proveedores, estados
WHERE compras.nit_prov=proveedores.NIT_provee and compra=1 and nit_prov='$prov' and estado=Id_estado
order BY Fech_comp DESC;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$id_com=$row['id_compra'];
	$estado=$row['Estado'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['id_compra'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['NIT'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Proveedor'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Factura'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_comp'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Vcmto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$estado.'</div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['Total'].'))</script></div></td>
	';
	echo'</tr>';
	$sqli="select Id_compra, Codigo, Nom_mprima as Producto, Lote, Cantidad, Precio
	from det_compras, mprimas
	where Codigo=Cod_mprima and Id_compra=$id_com;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="9"><div class="commenthidden" id="UniqueName'.$a.'"><table width="80%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="10%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="40%" class="formatoEncabezados">Materia Prima</th>
      <th width="15%" class="formatoEncabezados">Lote</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="15%" class="formatoEncabezados">Precio</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$rowi['Lote'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit('.$rowi['Precio'].'))</script></div></td>
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
      <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
    </tr>
</table>
</div>
</body>
</html>