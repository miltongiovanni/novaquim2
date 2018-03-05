<?php
include "includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
?>
<!DOCTYPE html>
<html>
<head>
<title>
<?php 
if ($Estado=='A')
echo 'Lista de Distribuidoras Activas';
if ($Estado=='N')
echo 'Lista de Distribuidoras No Activas';
?>

</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>

		<?php 
		if ($Estado=='A')
		echo 'LISTADO DE DISTRIBUIDORAS ACTIVAS DE NOVAHOUSE';
		if ($Estado=='N')
		echo 'LISTADO DE DISTRIBUIDORAS INACTIVAS DE NOVAHOUSE';
		
		?>
</strong></div>
<table  align="center" width="1250"border="0" summary="encabezado">
  <tr> <td width="1146" align="right"><form action="Clientes_Xls.php" method="post" target="_blank">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"><input name="Estado" type="hidden" value="<?php echo $Estado ?>"></form></td> 
      <td width="94"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo">
	<tr>
	<th width="10" class="formatoEncabezados"></th>
    <th width="100" align="center" class="formatoEncabezados">NIT</th>
    <th width="348" align="center" class="formatoEncabezados">Distribudora</th>
    <th width="300" align="center" class="formatoEncabezados">Direcci&oacute;n</th>
	<th width="61" align="center" class="formatoEncabezados">Tel&eacute;fono</th>
	<th width="155" align="center" class="formatoEncabezados">Directora de Zona</th>
  </tr>   
<?php
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
if ($Estado=='A')
	$sql="select Nit_clien as Nit, Nom_clien as Cliente, Dir_clien as Direccion, Contacto, Cargo, Tel_clien as Tel1, nom_personal as vendor, Des_cat_cli, Fax_clien As Fax, Cel_clien as Cel, Eml_clien as Eml, ciudad, localidad
from clientes, Personal, cat_clien, ciudades, localidad where cod_vend=Id_Personal and Id_cat_clien=Id_cat_cli and Ciudad_clien=Id_ciudad and loc_clien=Id_localidad AND Estado='A' AND id_cat_clien=13 order by Cliente";
if ($Estado=='N')
	$sql="select Nit_clien as Nit, Nom_clien as Cliente, Dir_clien as Direccion, Contacto, Cargo, Tel_clien as Tel1, nom_personal as vendor, Des_cat_cli, Fax_clien As Fax, Cel_clien as Cel, Eml_clien as Eml, ciudad, localidad
from clientes, Personal, cat_clien, ciudades, localidad where cod_vend=Id_Personal and Id_cat_clien=Id_cat_cli and Ciudad_clien=Id_ciudad and loc_clien=Id_localidad AND Estado='N'  AND id_cat_clien=13 order by Cliente;";
$result=mysql_db_query($database,$sql);
$a=1;
while($row=mysql_fetch_array($result, MYSQLI_BOTH))
{
	$lote=$row['Lote'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Nit'].'</div></td>
	<td class="formatoDatos"><div align="left">'.htmlentities( $row['Cliente']).'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Direccion'].'</div></td>	
	<td class="formatoDatos"><div align="left">'.$row['Tel1'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['vendor'].'</div></td>
	';
	
	echo'</tr>';
	echo '<tr><td colspan="4"><div class="commenthidden" id="UniqueName'.$a.'"><table border="0" align="center" cellspacing="0" summary="cuerpo">
	<tr>
	  <th width="200" class="formatoEncabezados">Acividad</th>
	  <th width="100" class="formatoEncabezados">Ciudad</th>
	  <th width="100" class="formatoEncabezados">Localidad</th>
	  <th width="50" class="formatoEncabezados">Fax</th>
  	  <th width="100" class="formatoEncabezados">Celular</th>
      <th width="250" class="formatoEncabezados">Correo Electr&oacute;nico</th>
  	</tr>';
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$row['Des_cat_cli'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['ciudad'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['localidad'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fax'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Cel'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Eml'].'</div></td>
	</tr>';
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysql_close($link);//Cerrar la conexion
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>