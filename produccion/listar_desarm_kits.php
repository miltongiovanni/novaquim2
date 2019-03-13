<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Kits Desarmados</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO KIT DESARMADOS</strong></div>
<table width="40%" border="0" align="center">
  <tr>
      <td colspan="2"><div align="center" class="titulo"></div></td>
  </tr>
  <tr> 
      <td width="14%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>

<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();    //sentencia SQL    tblusuarios.IdUsuario,
	$sql="select Id_desarmado as Id, Cod_prese as Código, Nombre as Producto, Cantidad, Fecha_desarm as Fecha from desarm_kit, kit, prodpre where Codigo=Cod_prese and Cod_kit=Id_kit
	union
	select  Id_desarmado as Id, Id_distribucion as Código, Producto, Cantidad, Fecha_desarm as Fecha from desarm_kit, kit, distribucion where Codigo=Id_distribucion and Cod_kit=Id_kit order by Fecha desc;";
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