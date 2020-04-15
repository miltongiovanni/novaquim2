<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Listado de Compras por Fecha</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
    <script >	function togglecomments (postid) {
		var whichpost = document.getElementById(postid);
		if (whichpost.className=="commentshown") { whichpost.className="commenthidden"; } else { whichpost.className="commentshown"; }
	}</script>
</head>
<body>
<div id="contenedor">
  <div id="saludo1"><strong>LISTADO DE  COMPRAS POR FECHA</strong></div>
  <?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

?>
  <table width="100%" border="0">
    <tr>
      <form action="Compras_Xls.php" method="post" target="_blank">
        <td width="85%" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td>
        <input name="FchIni" type="hidden" value="<?php echo $FchIni ?>">
        <input name="FchFin" type="hidden" value="<?php echo $FchFin ?>">
      </form>
      <td width="15%"><div align="right">
        <input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
    </tr>
  </table>
  <table border="0" align="center" cellspacing="0">
    <tr>
      <th width="18" class="formatoEncabezados"></th>
      <th width="67" class="formatoEncabezados">Id Compra</th>
      <th width="100" class="formatoEncabezados">NIT</th>
      <th width="315" class="formatoEncabezados">Proveedor</th>
      <th width="71" class="formatoEncabezados">Factura</th>
      <th width="113" class="formatoEncabezados">Fecha Compra</th>
      <th width="113" class="formatoEncabezados">Fecha Vencimiento</th>
      <th width="73" class="formatoEncabezados">Estado</th>
      <th width="84" class="formatoEncabezados">Valor Factura </th>
    </tr>
    <tr>
      <td colspan="4" class="titulo">Materia Prima</td>
    </tr>
    <?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	SELECT id_compra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp,
Fech_venc as 'Fecha Vcmto', Des_estado as Estado, total_fact as Total
FROM compras, proveedores, estados
WHERE compras.nit_prov=proveedores.nitProv and compra=1 and Fech_comp>='$FchIni' and Fech_comp<='$FchFin' and estado=Id_estado
order BY Fech_comp DESC, id_compra;";
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
	echo'<tr';
	if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>
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
mysqli_close($link);//Cerrar la conexion
?>
    <tr>
      <td colspan="4" class="titulo">Envase, Tapas y/o V&aacute;lvulas</td>
    </tr>
    <?php
$link=conectarServidor();
$sql="	SELECT id_compra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp,
Fech_venc as 'Fecha Vcmto', estado as Estado, total_fact as Total
FROM compras, proveedores 
WHERE compras.nit_prov=proveedores.nitProv and (compra=2 or compra=3) and Fech_comp>='$FchIni' and Fech_comp<='$FchFin'
order BY Fech_comp DESC;";
$result=mysqli_query($link,$sql);
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$id_com=$row['id_compra'];
	if ($row['Estado']=='C')
		$estado='Cancelada';
	if ($row['Estado']=='P')
		$estado='Pendiente';
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
	$sqli="select Codigo, Nom_envase as Producto, Cantidad, Precio from det_compras, envase
	where Codigo=Cod_envase and Id_compra=$id_com and Codigo<100
	union
	select Codigo, Nom_tapa as Producto, Cantidad, Precio from det_compras, tapas_val
	where Codigo=Cod_tapa and Id_compra=$id_com and Codigo>100;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="70%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="40%" class="formatoEncabezados">Envase</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="12%" class="formatoEncabezados">Precio</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit('.$rowi['Precio'].'))</script></div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_close($link);//Cerrar la conexion
?>
    <tr>
      <td colspan="4" class="titulo">Productos de Distribuci&oacute;n</td>
    </tr>
    <?php
$link=conectarServidor();
$sql="	SELECT id_compra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp,
Fech_venc as 'Fecha Vcmto', estado as Estado, total_fact as Total 
FROM compras, proveedores
WHERE compras.nit_prov=proveedores.nitProv and compra=5 and Fech_comp>='$FchIni' and Fech_comp<='$FchFin'
order BY Fech_comp desc;";
$result=mysqli_query($link,$sql);
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$id_com=$row['id_compra'];
	if ($row['Estado']=='C')
		$estado='Cancelada';
	if ($row['Estado']=='P')
		$estado='Pendiente';

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
	$sqli="select Codigo, Producto, Cantidad, Precio 
	from det_compras, distribucion
	where Codigo=Id_distribucion and Id_compra=$id_com;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="65%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="49%" class="formatoEncabezados">Producto</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="5%" class="formatoEncabezados">Precio</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit('.$rowi['Precio'].'))</script></div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_close($link);//Cerrar la conexion
?>
    <tr>
      <td colspan="4" class="titulo">Etiquetas</td>
    </tr>
    <?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();
$sql="	SELECT id_compra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp as 'Fecha Compra',
Fech_venc as 'Fecha Vcmto', estado as Estado, total_fact as Total 
FROM compras, proveedores
WHERE compras.nit_prov=proveedores.nitProv and compra=4 and Fech_comp>='$FchIni' and Fech_comp<='$FchFin'
order BY id_compra DESC;";
$result=mysqli_query($link,$sql);
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$id_com=$row['id_compra'];
	if ($row['Estado']=='C')
		$estado='Cancelada';
	if ($row['Estado']=='P')
		$estado='Pendiente';
	echo'<tr';
	if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['id_compra'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['NIT'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Proveedor'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Factura'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Compra'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Vcmto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$estado.'</div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['Total'].'))</script></div></td>
	';
	
	echo'</tr>';
	$sqli="select Codigo, Nom_etiq as Producto, Cantidad, Precio from det_compras, etiquetas
where Codigo=Cod_etiq and Id_compra=$id_com;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="70%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="40%" class="formatoEncabezados">Envase</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="12%" class="formatoEncabezados">Precio</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit('.$rowi['Precio'].'))</script></div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_close($link);//Cerrar la conexion
?>
  </table>
  <table width="27%" border="0" align="center">
    <tr>
      <td class="formatoDatos">&nbsp;</td>
    </tr>
    <tr>
      <td><div align="center">
        <input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
    </tr>
  </table>
</div>
</body>
</html>