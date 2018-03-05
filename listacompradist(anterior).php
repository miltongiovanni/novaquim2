<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Compras de Productos de Distribuci&oacute;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td colspan="3"><div align="center"><img src="images/LogoNova.JPG" ></div></td>
  </tr>
  <tr>
   
    <td width="53%"><div align="center" class="titulo">
       <div align="center">
         <p>LISTADO DE  COMPRAS DE PRODUCTOS DE DISTRIBUCI&Oacute;N</p>
        </div>
    </div></td>
  </tr>
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
        <th width="2%" class="formatoEncabezados">NIT</th>
      <th width="27%" class="formatoEncabezados">Proveedor</th>
      <th width="5%" class="formatoEncabezados">Factura</th>
      <th width="5%" class="formatoEncabezados">Fecha Compra</th>
      <th width="8%" class="formatoEncabezados">Fecha Vencimiento</th>
      <th width="4%" class="formatoEncabezados">Estado</th>
      <th width="9%" class="formatoEncabezados">Valor Factura </th>
      <th width="34%" class="formatoEncabezados">Producto de Distribuci&oacute;n</th>
      <th width="6%" class="formatoEncabezados">Cantidad</th>
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
$sql="	SELECT nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp as 'Fecha Compra',
Fech_venc as 'Fecha Vcmto', estado as Estado, total_fact as Total, Producto, Cant_dist AS Cantidad 
FROM compra_dist, proveedores, distribucion, det_compra_dist
WHERE compra_dist.nit_prov=proveedores.NIT_provee 
and distribucion.Id_distribucion=det_compra_dist.Cod_dist
AND compra_dist.Id_compra_dist=det_compra_dist.Id_compra_dist
order BY Fech_comp, Num_fact;";
$result=mysql_db_query($database,$sql);
while($row=mysql_fetch_array($result, MYSQLI_BOTH))
{
echo'<tr>
<td class="formatoDatos"><div align="center">'.$row['NIT'].'</div></td>
<td class="formatoDatos"><div align="right">'.$row['Proveedor'].'</div></td>
<td class="formatoDatos"><div align="center">'.$row['Factura'].'</div></td>
<td class="formatoDatos"><div align="center">'.$row['Fecha Compra'].'</div></td>
<td class="formatoDatos"><div align="center">'.$row['Fecha Vcmto'].'</div></td>
<td class="formatoDatos"><div align="center">'.$row['Estado'].'</div></td>
<td class="formatoDatos"><div align="right">$ <script language="javascript"> document.write(commaSplit('.$row['Total'].'))</script></div></td>
<td class="formatoDatos"><div align="right">'.$row['Producto'].'</div></td>
<td class="formatoDatos"><div align="right">'.$row['Cantidad'].'</div></td>';

echo'</tr>';
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