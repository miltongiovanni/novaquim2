<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actualizar Gasto</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE GASTO DE INDUSTRIAS NOVAQUIM</strong></div>
<table border="0" align="center">
  <tr>
    <td width="334"><div align="center"><strong>Producto</strong></div></td>
    <td width="101"><div align="center"><strong>Cantidad</strong></div></td>
    <td width="143"><div align="center"><strong>Precio</strong></div></td>
    <td width="50"><div align="center"><strong>Iva</strong></div></td>
  </tr>
  <form action="updateGast.php" method="post" name="actualiza">
    <strong>
    <?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();
	$qry="SELECT Id_gasto, Producto, Cant_gasto, Precio_gasto, det_gastos.Id_Tasa as iva, tasa from det_gastos, tasa_iva
where Id_gasto=$factura AND Producto='$producto'  AND det_gastos.Id_Tasa=tasa_iva.Id_tasa;";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$producto=$row['Producto'];
	$cantidad=$row['Cant_gasto'];
	$precio=$row['Precio_gasto'];
	$id_iva=$row['iva'];
	$iva=$row['tasa'];
	echo '<input name="factura" type="hidden" value="'.$factura.'"/>';
	echo '<tr>';
	echo '<td align="center">';
 	echo $producto;
	echo '<input name="producto" type="hidden" value="'.$producto.'"/>';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="cantidad" type="text" align="center" value="'.$cantidad.'"/>';
 	echo '</td>';	
	echo '<input name="cant_ant" type="hidden" value="'.$cantidad.'"/>';
	echo '<td align="center">';
 	echo'<input size=10 name="precio" type="text" align="center" value="'.round($precio, 2).'"/>';
 	echo '</td>';	
	echo '<td><div align="center"><select name="tasa_iva" id="combo">';
	$qryi="select * from tasa_iva";	
	$result=mysqli_query($link,$qryi);
	echo '<option selected value='."$id_iva".'>'.(100*$iva).'</option>';
	while($rowi=mysqli_fetch_array($result))
	{
		if ($rowi['Id_tasa']!=$id_iva)
		  echo '<option value="'.$rowi['Id_tasa'].'">'.($rowi['tasa']*100).'</option>';  
		  //echo= $row['Id_cat_prod'];
	}
    echo '</select ></div></td>';
	echo '</tr>';
	$result=mysqli_query($link, $qry);
	mysqli_close($link);
	?>
    
    </strong>
    <p>&nbsp;</p>
	<tr bordercolor="0">
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	<tr bordercolor="#33CC99">
   	  <td colspan="4"><div align="center"><input type="submit" name="Submit" value="Cambiar" /></div></td>
	</tr>
  </form>
</table>
</div>
</body>
</html>
