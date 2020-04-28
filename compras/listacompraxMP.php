<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Compra por Materia Prima</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE COMPRAS DE
 <?php
 foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
include "includes/conect.php";
$link=conectarServidor();
$result=mysqli_query($link,"select Nom_mprima from mprimas where Cod_mprima=$IdMP");
$row=mysqli_fetch_array($result);
echo mb_strtoupper ($row['Nom_mprima']);
mysqli_free_result($result);
mysqli_close($link);
?>
</strong></div>

<table width="44%" border="0" align="center" summary="Encabezado">
  <tr> <td width="88%" align="center">&nbsp;</td>
        <td width="12%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>

<?php
include "includes/utilTabla.php";

	//parametros iniciales que son los que cambiamos
    $link=conectarServidor();
    //sentencia SQL    tblusuarios.IdUsuario,
	$sql="	select fechComp as 'Fecha Compra', Cantidad, Nom_provee as 'Proveedor', Dir_provee as 'Dirección', Tel_provee as 'Teléfono', Precio as 'Precio Compra sin IVA', Cantidad as 'Cantidad Kg'
	from  det_compras, compras, mprimas, tasa_iva, proveedores 
	where Codigo=$IdMP AND det_compras.idCompra=compras.Id_compra AND Codigo=Cod_mprima AND tipoCompra= 1 and Cod_iva=Id_tasa AND nit_prov=nitProv ORDER BY fechComp DESC; ";
	
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>