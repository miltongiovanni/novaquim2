<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Servicios</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE SERVICIOS OFRECIDOS POR INDUSTRIAS NOVAQUIM S.A.S.</strong></div>
<table width="100%" border="0">
  <tr> <form action="Servicios_Xls.php" method="post" target="_blank"><td width="1179" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td></form>
      <td width="91"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
  </tr>
</table>
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	select IdServicio as Id, DesServicio as 'Descripción del Servicio', tasa as Tasa from servicios, tasa_iva where Cod_iva=Id_tasa;";
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