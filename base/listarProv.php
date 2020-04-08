<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Proveedores</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE PROVEEDORES</strong></div>
<table width="972" border="0" align="center" summary="encabezado">
  <tr> <td width="1179" align="right"><form action="Proveedores_Xls.php" method="post" target="_blank"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></form></td>
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table align="center" cellspacing="0" cellpadding="0" summary="cuerpo">
  <tr>
	<th width="8" class="formatoEncabezados"></th>
    <th width="94" class="formatoEncabezados">NIT</th>
    <th width="325" class="formatoEncabezados">Proveedor</th>
    <th width="253" class="formatoEncabezados">Dirección</th>
	<th width="137" class="formatoEncabezados">Contacto</th>
	<th width="69" class="formatoEncabezados">Teléfono</th>
	<th width="66" class="formatoEncabezados">Fax</th>
    <th width="157" class="formatoEncabezados">Correo Electrónico</th>
  </tr>   
<?php
include "includes/conect.php" ;


//Limito la busqueda 
$TAMANO_PAGINA = 20; 

//examino la página a mostrar y el inicio del registro a mostrar 
if(isset($_GET['pagina'])) 
{
    $pagina = $_GET['pagina']; 
}
else
	$pagina=NULL;
if (!$pagina) 
{ 
   	 $inicio = 0; 
   	 $pagina=1; 
} 
else 
{ 
   	$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
}



$link=conectarServidor();
$sql="	SELECT  NIT_provee as 'Nit',
			Nom_provee as 'Proveedor',
			Dir_provee as 'Dir_prov', 
			Nom_contac as 'Contacto',
			Tel_provee as 'Tel1',
			Fax_provee as 'Fax',
			Eml_provee as 'Email',
			desCatProv as 'Cat'
			FROM proveedores, cat_prov
			where proveedores.Id_cat_prov=cat_prov.idCatProv order by Nom_provee;";
$result=mysqli_query($link,$sql);
$num_total_registros = mysqli_num_rows($result); 
//calculo el total de páginas 
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

//muestro los distintos índices de las páginas, si es que hay varias páginas 
echo '<div id="paginas" align="center">';
if ($total_paginas > 1){ 
   	for ($i=1;$i<=$total_paginas;$i++){ 
      	 if ($pagina == $i) 
         	 //si muestro el índice de la página actual, no coloco enlace 
         	 echo $pagina . " "; 
      	 else 
         	 //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
         	 echo "<a href='listarProv.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;"; 
   	} 
}
echo '</div>';

//construyo la sentencia SQL 
$ssql = "SELECT  NIT_provee as 'Nit',
			Nom_provee as 'Proveedor',
			Dir_provee as 'Dir_prov', 
			Nom_contac as 'Contacto',
			Tel_provee as 'Tel1',
			Fax_provee as 'Fax',
			Eml_provee as 'Email',
			desCatProv as 'Cat'
			FROM proveedores, cat_prov
			where proveedores.Id_cat_prov=cat_prov.idCatProv order by Nom_provee limit " . $inicio . "," . $TAMANO_PAGINA;

$rs = mysqli_query($link,$ssql);




$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
{
	$nit=$row['Nit'];
	echo'<tr';
	if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Nit'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Proveedor'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Dir_prov'].'</div></td>	
	<td class="formatoDatos"><div align="left">'.$row['Contacto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Tel1'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Fax'].'</div></td>
	<td class="formatoDatos"><div align="left"><a href="mailto:'.$row['Email'].'">'.$row['Email'].'</a></div></td>
	';
	
	echo'</tr>';
	$sqli="
			select Codigo, Nom_mprima AS Producto from det_proveedores, mprimas 
			WHERE Codigo=Cod_mprima and det_proveedores.Id_cat_prov=1 and NIT_provee='$nit'
			union
			select Codigo, Nom_envase as Producto from det_proveedores, envase 
			WHERE Codigo=Cod_envase and det_proveedores.Id_cat_prov=2 and NIT_provee='$nit'
			union
			select Codigo, Nom_tapa as Producto from det_proveedores, tapas_val 
			WHERE Codigo=Cod_tapa and det_proveedores.Id_cat_prov=2 and NIT_provee='$nit'
			union
			select Codigo, Producto from det_proveedores, distribucion 
			WHERE Codigo=Id_distribucion and det_proveedores.Id_cat_prov=5 and NIT_provee='$nit'
			union 
			select Codigo, Nom_etiq as Producto from det_proveedores, etiquetas 
			WHERE Codigo=Cod_etiq and det_proveedores.Id_cat_prov=3 and NIT_provee='$nit';";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="4"><div class="commenthidden" id="UniqueName'.$a.'"><table width="100%" border="0" align="center" cellspacing="0" summary="detalle">
	<tr>
	  <th width="20%" class="formatoEncabezados">C&oacute;digo</th>
      <th width="80%" class="formatoEncabezados">Producto</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
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
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>