<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Categor&iacute;as de Productos de Distribuci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO CATEGOR&Iacute;AS DE PRODUCTOS DE DISTRIBUCI&Oacute;N</strong></div>
<table width="100%" border="0">
  <tr> 
        <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
        </div></td>
    </tr>
</table>
<?php
	include "includes/utilTabla.php";
	include "includes/conect.php" ;
	$link=conectarServidor();
    //sentencia SQL    tblusuarios.IdUsuario,
	$sql=utf8_encode("select Id_cat_dist as 'Código', Des_cat_dist as 'Categoría Distribución' from cat_dist;");
	//llamar funcion de tabla
	verTabla($sql, $link);
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
