<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Facturas de Venta</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<?php
include "includes/utilTabla.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
include "includes/conect.php" ;
//parametros iniciales que son los que cambiamos
$link=conectarServidor();
$sqlv="	select nom_personal from Personal where Id_personal=$IdPersonal;";
$resultv=mysqli_query($link,$sqlv);
$rowv=mysqli_fetch_array($resultv, MYSQLI_BOTH);
$vendedor=$rowv['nom_personal'];

?>
<div id="saludo1"><strong>LISTA DE CLIENTES DE <?php echo mb_strtoupper($vendedor); ?> </strong></div> 
<table  align="center" width="700" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo">
	<tr>
      <th width="10" class="formatoEncabezados"></th>
    <th width="100" align="center" class="formatoEncabezados">NIT</th>
    <th width="348" align="center" class="formatoEncabezados">Cliente</th>
    <th width="300" align="center" class="formatoEncabezados">Direcci&oacute;n</th>
	<th width="156" align="center" class="formatoEncabezados">Contacto</th>
    <th width="141" align="center" class="formatoEncabezados">Cargo Contacto</th>
	<th width="61" align="center" class="formatoEncabezados">Tel&eacute;fono</th>
  </tr>   
<?php
//conectar con el servidor de BD

//conectar con la tabla (ej. use datos;) 
//sentencia SQL    tblusuarios.IdUsuario,
$sql="	select Nit_clien as Nit, Nom_clien as Cliente, Dir_clien as Direccion, Contacto, Cargo, Tel_clien as Tel1, desCatClien, Fax_clien As Fax, Cel_clien as Cel, Eml_clien as Eml, ciudad 
from clientes, cat_clien, ciudades where cod_vend=$IdPersonal and Id_cat_clien=idCatClien and Ciudad_clien=Id_ciudad AND Estado='A' order by Cliente";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$nit=$row['Nit'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Nit'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Cliente'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Direccion'].'</div></td>	
	<td class="formatoDatos"><div align="left">'.$row['Contacto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Cargo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Tel1'].'</div></td>';
	echo'</tr>';
	$sqli="select Factura, Fech_fact, Fech_venc, Id_remision, Ord_compra, Nom_clien, Tel_clien, Dir_clien, 
		Ciudad, nom_personal as vendedor, Total, factura.Estado 
		from factura, clientes, personal,ciudades
		where Nit_cliente=Nit_clien and Nit_cliente='$nit' and Id_ciudad=Ciudad_clien and Cod_vend=Id_personal ORDER BY factura desc";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="75%" border="0" align="center" cellspacing="0" summary="cuerpo">
	<tr>
      <th width="10%" class="formatoEncabezados">Factura</th>
      <th width="15%" class="formatoEncabezados">Fecha Factura</th>
      <th width="15%" class="formatoEncabezados">Fecha Vencimiento</th>
      <th width="20%" class="formatoEncabezados">Total</th>
      <th width="10%" class="formatoEncabezados">Estado</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Factura'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Fech_fact'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Fech_venc'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Total'].'))</script></div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Estado'].'</div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
 </body>
</html>