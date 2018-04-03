<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista del Personal Activo</title>
<meta charset="utf-8">
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

<div id="saludo1"><strong>LISTADO DEL PERSONAL ACTIVO</strong></div> 
<table width="100%" border="0" summary="encabezado">
	<tr> 
    	<td><div align="right"><button class="button" style="vertical-align:middle" onclick="window.location='menu.php'"><span><STRONG>Ir al Men&uacute;</STRONG></span></button></div></td>
    </tr>
</table>

<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;

	//conectar con el servidor de BD
$link=conectarServidor();
    
    //sentencia SQL    tblusuarios.IdUsuario,
	$sql="select Id_personal as Id, nom_personal as Nombre, cel_personal as Celular, Eml_personal AS 'Correo electrónico', areas_personal.area as 'Área', cargo as Cargo from personal, areas_personal, cargos_personal 
	wHERE personal.Area=Id_area and activo=1 AND cargo_personal=Id_cargo order by Id_personal";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<div align="center"><button class="button" style="vertical-align:middle" onclick="window.location='menu.php'"><span><STRONG>Ir al Men&uacute;</STRONG></span></button></div>
</div>
</body>
</html>