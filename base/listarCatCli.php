<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Categorías de Clientes</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CATEGORÍAS DE CLIENTES</strong></div>
<table width="700" align="center" border="0">
  <tr> 
        <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
    </tr>
</table>

<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
	$link=conectarServidor();
	$sql="	select Id_cat_cli as C�digo, Des_cat_cli as 'Tipo de Cliente' from cat_clien;";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>
