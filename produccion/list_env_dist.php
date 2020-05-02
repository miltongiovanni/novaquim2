<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Envasado de Productos de Distribuci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">

<div id="saludo1"><strong>LISTA DE ENVASADO DE PRODUCTOS DE DISTRIBUCI&Oacute;N</strong></div> 
<table width="100%" border="0">
<tr> 
  <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
</tr>
</table>

<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
	$link=conectarServidor();
    //sentencia SQL    tblusuarios.IdUsuario,
	$sql="select Id_env_dist as Id, Fch_env_dist as Fecha, Cod_dist as Código, Producto, Cantidad from det_env_dist, distribucion where Cod_dist=Id_distribucion ORDER by Id DESC;";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>
