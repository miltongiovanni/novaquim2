<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de la Nota Cr&eacute;dito</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DEL PRODUCTO EN LA NOTA CR&Eacute;DITO</strong></div>
<form action="updateProdNota.php" method="post" name="actualiza">
<table width="55%" border="0" align="center" summary="cuerpo">
  <tr>
    <td width="69%" class="titulo"><div align="center">Producto</div></td>
    <td width="18%" class="titulo"><div align="center">Cantidad</div></td>
  </tr>
  
  <?php
	$link=conectarServidor();
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	if ($codigo < 100)
	{
		$qry="select Cod_producto as Codigo, DesServicio as Producto, Can_producto as Cantidad, Prec_producto as Precio from det_pedido, servicios where Cod_producto=IdServicio and Id_ped=$pedido AND Cod_producto=$codigo;";
	}
	if (($codigo < 100000)&&($codigo > 100))
	{
		$qry="select Nota as nota, det_nota_c.Cod_producto, det_nota_c.Can_producto as canNota, det_factura.Can_producto as canFac, Nombre as Producto, prec_producto as precio  
from nota_c,det_nota_c, det_factura, prodpre WHERE Id_Nota=$nota and Nota=Id_Nota and Id_fact=Fac_orig and det_nota_c.Cod_producto=Cod_prese and det_factura.Cod_producto=Cod_prese and det_nota_c.Cod_producto=$codigo;";
	}
	if ($codigo >= 100000)
	{
		$qry="select Nota as nota, det_nota_c.Cod_producto, det_nota_c.Can_producto as canNota, det_factura.Can_producto as canFac, Producto, prec_producto as precio 
from nota_c,det_nota_c, det_factura, distribucion WHERE Id_Nota=$nota and Nota=Id_Nota and Id_fact=Fac_orig and det_nota_c.Cod_producto=Id_distribucion and det_factura.Cod_producto=Id_distribucion and det_nota_c.Cod_producto=$codigo;";
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
	echo '<input name="codigo" type="hidden" value="'.$codigo.'"><input name="nota" type="hidden" value="'.$nota.'">';
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
