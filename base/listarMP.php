<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Materias Primas</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
  <div id="saludo1"><strong>LISTADO DE MATERIAS PRIMAS</strong></div>
  <table width="100%" border="0" summary="encabezado">
    <tr>
      <td><div align="right">
        <input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
    </tr>
  </table>
  <?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
	$link=conectarServidor();
	$sql="	SELECT Cod_mprima as Codigo, Nom_mprima as 'Materia Prima', Des_cat_mp as 'Tipo de Materia Prima', Min_stock_mp as 'Stock Mínimo'
			FROM  mprimas, cat_mp
			WHERE mprimas.Id_cat_mp=cat_mp.Id_cat_mp
			ORDER BY Codigo";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>