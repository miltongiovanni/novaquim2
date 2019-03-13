<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Categor&iacute;as de Producto</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<style>

/*PARA HACER EL EFECTO ZEBRA DE LAS TABLAS*/
tr:nth-child(even) {
    background-color: #DFE2FD;  
}
</style>
</head>
<body>
<div id="contenedor">

<div id="saludo1"><strong>LISTADO DE CATEGOR&Iacute;AS DE PRODUCTOS</strong></div> 
<table width="100%" border="0">
<tr> 
  <td><div align="right"><button class="button" style="vertical-align:middle" onclick="window.location='menu.php'"><span><STRONG>Ir al Men&uacute;</STRONG></span></button></div></td>
</tr>
</table>

<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
	//parametros iniciales que son los que cambiamos
	//conectar con el servidor de BD
	$mysqli=conectarServidor();
	//conectar con la tabla (ej. use datos;)
    //sentencia SQL    tblusuarios.IdUsuario,
	$sql=("	SELECT  Id_cat_prod as 'Código', Des_cat_prod as 'Categoría'
			FROM cat_prod order by Id_cat_prod");
	//llamar funcion de tabla
	verTabla($sql, $mysqli);
?>
<div align="center"><button class="button" style="vertical-align:middle" onclick="window.location='menu.php'"><span><STRONG>Ir al Men&uacute;</STRONG></span></button>
        </div>
</div>
</body>
</html>
