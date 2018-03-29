<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Usuarios</title>
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

<div id="saludo1"><strong>LISTADO DE USUARIOS ACTIVOS</strong></div> 
<table width="100%" border="0" summary="encabezado">
	<tr> 
    	<td><div align="right"><button class="button" style="vertical-align:middle" onclick="window.location='menu.php'"><span><STRONG>Ir al Men&uacute;</STRONG></span></button></div></td>
    </tr>
</table>



<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
	$mysqli=conectarServidor();
    //sentencia SQL    tblusuarios.IdUsuario,

	
	$sql="	SELECT  tblusuarios.Nombre as 'Nombre del Usuario', 
			tblusuarios.Apellido as 'Apellidos del Usuario',
			tblusuarios.Usuario, tblusuarios.FecCrea as 'Fecha de Creación', 
			tblestados.Descripcion as 'Estado',	tblperfiles.Descripcion as 'Perfil'
			FROM tblusuarios,tblperfiles, tblestados
			where tblusuarios.EstadoUsuario=tblestados.IdEstado and EstadoUsuario<=2
			and tblusuarios.IdPerfil=tblperfiles.IdPerfil order by tblusuarios.IdUsuario";

	//llamar funcion de tabla
	verTabla($sql, $mysqli);
?>


<div align="center"><button class="button" style="vertical-align:middle" onclick="window.location='menu.php'"><span><STRONG>Ir al Men&uacute;</STRONG></span></button></div>
</div>
</body>
</html>