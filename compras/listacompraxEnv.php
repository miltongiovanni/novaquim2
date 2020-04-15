<?php
include "includes/valAcc.php";
include "includes/conect.php";
include "includes/utilTabla.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Compra por Envase o Tapa</title>
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
	if($IdEnvTap<100)
	{
		$qry="select Cod_envase as codigo, Nom_envase as producto from envase where Cod_envase=$IdEnvTap";
	}
	else
	{
		$qry="select Cod_tapa as codigo, Nom_tapa as producto from tapas_val where Cod_tapa=$IdEnvTap";
	}
	$link=conectarServidor();
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	echo mb_strtoupper ($row['producto']);
	mysqli_free_result($result);
	mysqli_close($link);
?>
</strong></div>

<table width="700" border="0" align="center">
  <tr> <td align="center">&nbsp;</td>
        <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>

<?php
	$link=conectarServidor();
	$sql="select Fech_comp as 'Fecha de Compra', Nom_provee as Proveedor, Dir_provee as Dirección, Tel_provee as Teléfono, Round(Precio,2) as 'Precio sin IVA', Round(Cantidad,0) as Cantidad 
from compras, det_compras, proveedores where compras.Id_compra=det_compras.Id_compra and compra=2 and Codigo=$IdEnvTap and nit_prov=nitProv order by Fech_comp desc";
    //sentencia SQL    tblusuarios.IdUsuario,
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<table width="27%" border="0" align="center">
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