<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Categor&iacute;as de Producto</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">

<div id="saludo1"><strong>LISTADO DE CATEGOR&Iacute;AS DE PRODUCTOS</strong></div> 
<table width="100%" border="0">
<tr> 
  <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
</tr>
</table>

<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
	//parametros iniciales que son los que cambiamos
	//conectar con el servidor de BD
	$link=conectarServidor();
	//conectar con la tabla (ej. use datos;)
    //sentencia SQL    tblusuarios.IdUsuario,
	$sql="	SELECT  Id_cat_prod as Codigo, Des_cat_prod as 'Categoria'
			FROM cat_prod order by Codigo";
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
