<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Etiquetas</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE ETIQUETAS</strong></div>
<table width="100%" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
	//parametros iniciales que son los que cambiamos
	$link=conectarServidor();
    //sentencia SQL    tblusuarios.IdUsuario,
	$sql="	select Cod_etiq as 'Código', Nom_etiq as Etiqueta, stock_etiq as 'Stock Mínimo' from etiquetas;";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<table width="27%" border="0" align="center">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
    </tr>
</table>
</div>
</body>
</html>