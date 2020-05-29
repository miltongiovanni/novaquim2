<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Órdenes de Producción</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><img src="images/LogoNova.JPG"></div></td>
  </tr>
  <tr>
        <td>&nbsp;</td>
    </tr>
  <tr>
    <td width="53%"><div align="center" class="titulo">
       <div align="center">LISTADO DE ÓRDENES DE PRODUCCIÓN</div>
    </div></td>
  </tr>
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
  </tr>
</table>

<?php
	include "includes/utilTabla.php";
	include "includes/conect.php";
	//parametros iniciales que son los que cambiamos
	$servidorBD="localhost";
	$usuario="root";
	$password="novaquim";
	$database="novaquim";
	//conectar con el servidor de BD
	$link=conectarServidorBD($servidorBD, $usuario, $password);
	//conectar con la tabla (ej. use datos;)
	conectarBD($database, $link);  
	//sentencia SQL    tblusuarios.IdUsuario,
	$sql="SELECT Lote as 'No. de Lote', fechProd as 'Fecha de Producción', Nom_produc as 'Nombre de Producto', nomFormula as 'Fórmulación'
		FROM ord_prod, formula, productos
		where ord_prod.idFormula=formula.idFormula AND formula.codProducto=productos.Cod_produc ;";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<table width="27%" border="0" align="center">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
    </tr>
</table>
</body>
</html>