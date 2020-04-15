<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Compra por Producto de Distribuci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE COMPRAS DE
<?php
	foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  			
include "includes/conect.php";
$link=conectarServidor();
$result=mysqli_query($link,"select Producto from distribucion where Id_distribucion=$IdDis");
$row=mysqli_fetch_array($result);
$Nom_producto=$row['Producto'];
echo mb_strtoupper ($Nom_producto);
mysqli_free_result($result);
mysqli_close($link);
//strtoupper ($cadena); 

			?>
</strong></div>

<table width="700" border="0" align="center">
  <tr> <td align="center">&nbsp;</td>
        <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>

<?php
include "includes/utilTabla.php";

	//parametros iniciales que son los que cambiamos
    $link=conectarServidor();
    //sentencia SQL    tblusuarios.IdUsuario,
	$sql="	select Fech_comp as 'Fecha Compra', Nom_provee as Proveedor, Dir_provee as Dirección, Tel_provee as Teléfono, round(Precio*(1+tasa)) as 'Precio Compra con IVA', round(Precio) as 'Precio Compra sin IVA', round (Cantidad,0) as Cantidad
	from det_compras, compras, distribucion, proveedores, tasa_iva
	where Codigo=$IdDis and det_compras.Id_compra=compras.Id_compra and Codigo=Id_distribucion AND nit_prov=nitProv AND Cod_iva=Id_tasa ORDER BY Fech_comp DESC ";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<table width="27%" border="0" align="center">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
        </div></td>
    </tr>
</table>
</div>
</body>
</html>