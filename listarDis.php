<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Productos de Distribuci&oacute;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE PRODUCTOS DE DISTRIBUCI&Oacute;N</strong></div>
<table width="100%" border="0">
  <tr> <form action="Distribucion_Xls.php" method="post" target="_blank"><td width="1179" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td></form>
      <td width="91"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
	$sql="	SELECT Id_distribucion as Código, Producto, CONCAT('$ ',format(round(precio_vta),0)) as Precio, tasa as 'Iva', Des_cat_dist as 'Categoría' 
			FROM  distribucion, tasa_iva, cat_dist
			WHERE distribucion.Cod_iva=tasa_iva.Id_tasa and distribucion.Id_Cat_dist=cat_dist.Id_cat_dist and Activo=0 and Cotiza=0
			ORDER BY cat_dist.Id_Cat_dist , Producto";
	//llamar funcion de tabla
	verTabla($sql, $link);
//Cerrar la conexion
?>
<table width="27%" border="0" align="center">
    <tr>
        <td>&nbsp;</td>
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
</div>
</body>
</html>