<?php
include "../includes/valAcc.php";
include "includes/utilTabla.php";
include "includes/conect.php" ;
$cliente=$_POST['cliente'];
$link=conectarServidor();  
$qrybus="select nomCliente from clientes where nitCliente='$cliente'";
$resultbus=mysqli_query($link, $qrybus);
$rowbus=mysqli_fetch_array($resultbus);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Histórico de Cobros Facturas</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>HISTÓRICO DE PAGOS DE FACTURAS DE <?php echo mb_strtoupper($rowbus['Nom_clien']); ?></strong></div>
<table width="711" border="0" align="center" summary="encabezado">
  <tr> <td width="611" align="right"><form action="histo_cobros_cli_Xls.php" method="post" target="_blank"><input name="cliente" type="hidden" value="<?php echo $cliente; ?>"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel">
    </form></td>
      <td width="90"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
  </tr>
</table>
<?php
	$link=conectarServidor();
    //sentencia SQL    tblusuarios.IdUsuario,
	$sql= "select idRecCaja as 'Id', idFactura as Factura, nomCliente as Cliente, CONCAT('$ ', FORMAT(cobro,0)) as Pago, fechaRecCaja, formaPago as 'Forma de Pago' from r_caja, factura, clientes, form_pago where idFactura=idFactura and Nit_cliente=nitCliente AND Nit_cliente='$cliente' and form_pago=idFormaPago order  by Id DESC;";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>