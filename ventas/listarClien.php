<?php
include "../includes/valAcc.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>
<?php 
if ($Estado=='A')
echo 'Lista de Clientes Activos';
if ($Estado=='N')
echo 'Lista de Clientes No Activos';
?>

</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>


    
    
    
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>

		<?php 
		if ($Estado=='A')
		echo 'LISTADO DE CLIENTES ACTIVOS DE INDUSTRIAS NOVAQUIM';
		if ($Estado=='N')
		echo 'LISTADO DE CLIENTES INACTIVOS DE INDUSTRIAS NOVAQUIM';
		
		?>
</strong></div>
<table  align="center"border="0" summary="encabezado" width="90%">
  <tr> <td width="92%" align="right"><form action="Clientes_Xls.php" method="post" target="_blank">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"><input name="Estado" type="hidden" value="<?php echo $Estado ?>"></form></td> 
      <td width="8%"><div align="left"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo" width="90%">
	<tr>
	<th width="2%" class="formatoEncabezados"></th>
    <th width="9%" align="center" class="formatoEncabezados">NIT</th>
    <th width="33%" align="center" class="formatoEncabezados">Cliente</th>
    <th width="21%" align="center" class="formatoEncabezados">Dirección</th>
	<th width="14%" align="center" class="formatoEncabezados">Tipo de Cliente</th>
	<th width="12%" align="center" class="formatoEncabezados">Vendedor</th>
    <th width="9%" align="center" class="formatoEncabezados">Última compra</th>
  </tr>   
<?php
include "includes/conect.php" ;
$fecha_actual=date("Y")."-".date("m")."-".date("d");
$link=conectarServidor();
if ($Estado=='A')
	$sql="select Nit_clien as Nit, Nom_clien as Cliente, Dir_clien as Direccion, Contacto, Cargo, Tel_clien as Tel1, nom_personal as vendor, desCatClien, Fax_clien As Fax, Cel_clien as Cel, Eml_clien as Eml, ciudad, max(Fech_fact) as Ult_compra
from clientes, Personal, cat_clien, ciudades, factura where cod_vend=Id_Personal and Id_cat_clien=idCatClien and Ciudad_clien=Id_ciudad and  Nit_cliente=Nit_clien AND clientes.Estado='A' group by Nit_clien order by Cliente";
if ($Estado=='N')
	$sql="select Nit_clien as Nit, Nom_clien as Cliente, Dir_clien as Direccion, Contacto, Cargo, Tel_clien as Tel1, nom_personal as vendor, desCatClien, Fax_clien As Fax, Cel_clien as Cel, Eml_clien as Eml, ciudad, max(Fech_fact) as Ult_compra
from clientes, Personal, cat_clien, ciudades, factura where cod_vend=Id_Personal and Id_cat_clien=idCatClien and Ciudad_clien=Id_ciudad and  Nit_cliente=Nit_clien AND clientes.Estado='N' group by Nit_clien order by Cliente;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$dias=Calc_Dias($fecha_actual, $row['Ult_compra']);
	if ($dias<60)
	{
		$formato="formatoDatos";
	}	
	if ($dias>=60 && $dias<=120)
	{
		$formato="formatoDatos2";
	}	
	if ($dias>120)
	{
		$formato="formatoDatos1";
	}	
	echo'<tr class="'.$formato.'"';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="'.$formato.'"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="'.$formato.'"><div align="center">'.$row['Nit'].'</div></td>
	<td class="'.$formato.'"><div align="left">'.$row['Cliente'].'</div></td>
	<td class="'.$formato.'"><div align="left">'.$row['Direccion'].'</div></td>	
	<td class="'.$formato.'"><div align="center">'.$row['Des_cat_cli'].'</div></td>
	<td class="'.$formato.'"><div align="left">'.$row['vendor'].'</div></td>
	<td class="'.$formato.'"><div align="center">'.$row['Ult_compra'].'</div></td>
	';
	
	echo'</tr>';
	echo '<tr><td colspan="5"><div class="commenthidden" id="UniqueName'.$a.'"><table border="0" align="center" cellspacing="0" summary="cuerpo">
	<tr>
	  <th width="200" class="formatoEncabezados">Contacto</th>
	  <th width="200" class="formatoEncabezados">Cargo Contacto</th>
	  <th width="61" align="center" class="formatoEncabezados">Teléfono</th>
	  <th width="100" class="formatoEncabezados">Ciudad</th>
	  <th width="50" class="formatoEncabezados">Fax</th>
  	  <th width="100" class="formatoEncabezados">Celular</th>
      <th width="250" class="formatoEncabezados">Correo Electrónico</th>
  	</tr>';
	echo '<tr>
	<td class="formatoDatos"><div align="left">'.$row['Contacto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Cargo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Tel1'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['ciudad'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fax'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Cel'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Eml'].'</div></td>
	</tr>';
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_close($link);//Cerrar la conexion
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>