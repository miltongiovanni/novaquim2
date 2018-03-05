<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Usuarios</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">

<div id="saludo1"><strong>LISTADO DE USUARIOS REGISTRADOS</strong></div> 
<table width="100%" border="0" summary="encabezado">
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
    //sentencia SQL    tblusuarios.IdUsuario,

	
	$sql="	SELECT  tblusuarios.Nombre as 'Nombre del Usuario', 
			tblusuarios.Apellido as 'Apellidos del Usuario',
			tblusuarios.Usuario, tblusuarios.FecCrea as 'Fecha de Creación', 
			tblestados.Descripcion as 'Estado',	tblperfiles.Descripcion as 'Perfil'
			FROM tblusuarios,tblperfiles, tblestados
			where tblusuarios.EstadoUsuario=tblestados.IdEstado
			and tblusuarios.IdPerfil=tblperfiles.IdPerfil order by tblusuarios.IdUsuario";

	//llamar funcion de tabla
	verTabla($sql, $link);
?>


<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>