<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Compras de V&aacute;lvulas y/o Tapas</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
    <script >	function togglecomments (postid) {
		var whichpost = document.getElementById(postid);
		if (whichpost.className=="commentshown") { whichpost.className="commenthidden"; } else { whichpost.className="commentshown"; }
	}</script>
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td colspan="3"><div align="center"><img src="images/LogoNova.JPG" ></div></td>
  </tr>
  <tr>
   
    <td width="53%"><div align="center" class="titulo">
       <div align="center">
         <p>LISTADO DE  COMPRAS DE V&Aacute;LVULAS Y/O TAPAS</p>
       </div>
    </div></td>
  </tr>
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table width="70%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="2%" class="formatoEncabezados"></th>
      <th width="10%" class="formatoEncabezados">NIT</th>
      <th width="22%" class="formatoEncabezados">Proveedor</th>
      <th width="5%" class="formatoEncabezados">Factura</th>
      <th width="5%" class="formatoEncabezados">Fecha Compra</th>
      <th width="8%" class="formatoEncabezados">Fecha Vencimiento</th>
      <th width="4%" class="formatoEncabezados">Estado</th>
      <th width="9%" class="formatoEncabezados">Valor Factura </th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
//parametros iniciales que son los que cambiamos
$servidorBD="localhost";
$usuario="root";
$password="novaquim";
$database="novaquim";
//conectar con el servidor de BD
$link=conectarServidorBD($servidorBD, $usuario, $password);
//conectar con la tabla (ej. use datos;)
conectarBD($database, $link);  
//sentencia SQL    tblusuarios.IdUsuario,
$sql="	SELECT idCompra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp as 'Fecha Compra',
Fech_venc as 'Fecha Vcmto', estado as Estado, total_fact as Total
FROM compras, proveedores
WHERE compras.nit_prov=proveedores.nitProv and compra=3
order BY Fech_comp, Num_fact;";
$result=mysql_db_query($database,$sql);
$a=1;
while($row=mysql_fetch_array($result, MYSQLI_BOTH))
{
	$id_com=$row['Id_compra'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['NIT'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Proveedor'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Factura'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Compra'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Vcmto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Estado'].'</div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['Total'].'))</script></div></td>
	';
	
	echo'</tr>';
	$sqli="select Codigo, Nom_tapa as Producto, Cantidad, Precio from det_compras, tapas_val
where Codigo=Cod_tapa and idCompra=$id_com;";
	$resulti=mysql_db_query($database,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="70%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="40%" class="formatoEncabezados">V&aacute;lvula o Tapa</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="12%" class="formatoEncabezados">Precio</th>
  	</tr>';
	while($rowi=mysql_fetch_array($resulti, MYSQLI_BOTH))
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
mysql_close($link);//Cerrar la conexion
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
</body>
</html>