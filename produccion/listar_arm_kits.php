<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Kits Armados</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO KIT ARMADOS</strong></div>
<table width="40%" border="0" align="center">
  <tr>
      <td colspan="2"><div align="center" class="titulo"></div></td>
  </tr>
  <tr> 
      <td width="14%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
  </tr>
</table>

<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
	$sql="	select Id_armado as Id, Cod_prese as Código, Nombre as Producto, Cantidad, Fecha_arm as Fecha from arm_kit, kit, prodpre where Codigo=Cod_prese and Cod_kit=Id_kit
union
select  Id_armado as Id, Id_distribucion as Código, Producto, Cantidad, Fecha_arm as Fecha from arm_kit, kit, distribucion where Codigo=Id_distribucion and Cod_kit=Id_kit order by Fecha desc;";
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
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
        </div></td>
    </tr>
</table>
</div>
</body>
</html>