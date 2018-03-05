<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Productos</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE PRODUCTOS </strong></div>
<table width="711" border="0" align="center" summary="encabezado">
  <tr> <td width="611" align="right"><form action="Productos_Xls.php" method="post" target="_blank"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel">
    </form></td>
      <td width="90"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
	$link=conectarServidor();
	$sql="	SELECT Cod_produc as Codigo, Nom_produc as 'Producto', Des_cat_prod as 'Categoría', Den_min as 'Dens Min', Den_max as 'Dens Max', pH_min as 'pH Min', pH_max as 'pH Max', Fragancia, Color, Apariencia 
			FROM  productos, cat_prod
			WHERE productos.Id_cat_prod=cat_prod.Id_cat_prod and prod_activo=0
			ORDER BY Codigo;";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>