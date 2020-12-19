<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de la Nota Crédito</title>
<script  src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACIÓN DEL PRODUCTO EN LA NOTA CRÉDITO</strong></div>
<form action="updateProdNota.php" method="post" name="actualiza">
<table width="55%" border="0" align="center" summary="cuerpo">
  <tr>
    <td width="69%" class="titulo"><div align="center">Producto</div></td>
    <td width="18%" class="titulo"><div align="center">Cantidad</div></td>
  </tr>
  
  <?php
	$link=conectarServidor();
	foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
	if ($codigo < 100)
	{
		$qry="select codProducto as Codigo, DesServicio as Producto, cantProducto as Cantidad, precioProducto as Precio from det_pedido, servicios where codProducto=IdServicio and idPedido=$pedido AND codProducto=$codigo;";
	}
	if (($codigo < 100000)&&($codigo > 100))
	{
		$qry="select idNotaC as nota, det_nota_c.codProducto, det_nota_c.cantProducto as canNota, det_factura.cantProducto as canFac, Nombre as Producto, precioProducto as precio  
from nota_c,det_nota_c, det_factura, prodpre WHERE idNotaC=$mensaje and idNotaC=idNotaC and idFactura=facturaOrigen and det_nota_c.codProducto=Cod_prese and det_factura.codProducto=Cod_prese and det_nota_c.codProducto=$codigo;";
	}
	if ($codigo >= 100000)
	{
		$qry="select idNotaC as nota, det_nota_c.codProducto, det_nota_c.cantProducto as canNota, det_factura.cantProducto as canFac, Producto, precioProducto as precio 
from nota_c,det_nota_c, det_factura, distribucion WHERE idNotaC=$mensaje and idNotaC=idNotaC and idFactura=facturaOrigen and det_nota_c.codProducto=Id_distribucion and det_factura.codProducto=Id_distribucion and det_nota_c.codProducto=$codigo;";
	}
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$codigo=$row['Cod_producto'];
	$canNota=$row['canNota'];
	$producto=$row['Producto'];
	$canFac=$row['canFac'];
	echo '<tr>';
	echo '<td align="center">';
 	echo $producto;
//	echo "canfac ".$canFac;
	echo '<input name="codigo" type="hidden" value="'.$codigo.'"><input name="nota" type="hidden" value="'.$mensaje.'">';
 	echo '</td>';	
	echo '<td align="center">';	
	echo'<select name="cantidad" id="combo">';
    echo '<option value='.intval($canNota).' selected>'.intval($canNota).'</option>';
  for ($i = 1; $i <= $canFac; $i++) 
  {
	  if(intval($canNota)!=$i)
	echo '<option value='.$i.'>'.$i.'</option>';
  }
  echo'</select>';
	
	
	
	
	
 	//echo'<input size=5 name="cantidad" type="text" align="right" value="'.$cantidad.'">';
 	echo '</td>';
	echo '</tr>';
	mysqli_close($link);
	?>
	<tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
    	<td>&nbsp;</td>
	</tr>
	<tr>
   	  <td colspan="3"><div align="center"><input type="submit" name="Submit" value="Cambiar"></div></td>
	</tr>
  
</table>
</form>
</div>
</body>
</html>
