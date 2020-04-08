<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Ingreso de Productos en la Cotizaci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    <script type="text/javascript">
    	document.onkeypress = stopRKey; 
    </script>

</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>DETALLE DE LA COTIZACI&Oacute;N PERSONALIZADA</strong></div> 
<?php
include "includes/conect.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
function mover($ruta,$nota)
{
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo'<script >
	alert("'.$nota.'");
	self.location="'.$ruta.'";
	</script>';
} 
$link=conectarServidor();  
if ($Crear == 3)
{
  $qrycam="select MAX(Id_cotiz_p) AS cotizacion  from cot_personalizada;";
  $resultqrycam=mysqli_query($link,$qrycam);
  $row_cam=mysqli_fetch_array($resultqrycam);
  $cotizacion=$row_cam['cotizacion']+1;
  $qryins_comp="insert into cot_personalizada (Id_cotiz_p, Cliente_cot, Fech_Cotizacion, tip_precio, destino) 
			  values ($cotizacion, $cliente, '$FchCot', $tip_precio, $Destino)";
  $resultins_prod=mysqli_query($link,$qryins_comp);	
  $qrycam="select MAX(Id_cotiz_p) AS cotiza from cot_personalizada;";
  $resultqrycam=mysqli_query($link,$qrycam);
  $row_cam=mysqli_fetch_array($resultqrycam);
  $cotizacion=$row_cam['cotiza'];
  mysqli_close($link);/*
  echo '<form method="post" action="det_cot_personalizada.php" name="form3">';
  echo'<input name="Crear" type="hidden" value="5">'; 
  echo'<input name="cotizacion" type="hidden" value="'.$cotizacion.'">'; 
  echo '</form>';
  echo'<script >
	  document.form3.submit();
	  </script>';*/
}
if($Crear==1)
{
  //PRECIOS DE PRODUCTOS DE LA EMPRESA
  $qryins_p="insert into det_cot_personalizada(Id_cot_per, Cod_producto, Can_producto, Prec_producto) values ($cotizacion, $cod_producto, $cantidad, 0)";
  $resultins_p=mysqli_query($link,$qryins_p);
  $qrybus="select Id_cotiz_p, tip_precio, Cod_producto, fabrica, distribuidor, detal, mayor, super from cot_personalizada, det_cot_personalizada, prodpre 
  where Id_cotiz_p=$cotizacion AND Id_cotiz_p=Id_cot_per And Cod_producto <100000 and Cod_producto=Cod_prese and Cod_producto=$cod_producto;";
  $resultbus=mysqli_query($link,$qrybus);
  $rowbus=mysqli_fetch_array($resultbus);
  switch ($rowbus['tip_precio']) 
  {
  case 1:
	$precio=$rowbus['fabrica'];
	break;
  case 2:
	$precio=$rowbus['distribuidor'];
	break;
  case 3:
	$precio=$rowbus['detal'];
	break;
  case 4:
	$precio=$rowbus['mayor'];
	break;
  case 5:
	$precio=$rowbus['super'];
	break;	
  }
  $qryup="update det_cot_personalizada set Prec_producto=$precio where Id_cot_per=$cotizacion and Cod_producto=$cod_producto;";
  $resultup=mysqli_query($link,$qryup);
  mysqli_close($link);
  echo '<form method="post" action="det_cot_personalizada.php" name="form3">';
  echo'<input name="Crear" type="hidden" value="5">'; 
  echo'<input name="cotizacion" type="hidden" value="'.$cotizacion.'">'; 
  echo '</form>';
  echo'<script >
	  document.form3.submit();
	  </script>';
}
if($Crear==2)
{
  //PRECIOS DE PRODUCTOS DE DISTRIBUCIÓN
  $qryins_d="insert into det_cot_personalizada(Id_cot_per, Cod_producto, Can_producto, Prec_producto) values ($cotizacion, $cod_producto, $cantidad, 0)";
  $resultins_d=mysqli_query($link,$qryins_d);
  $qrybus="select Id_cot_per, Cod_producto, Precio_vta from det_cot_personalizada, distribucion 
  where Id_cot_per=$cotizacion AND Cod_producto=Id_distribucion And Cod_producto >100000 and Cod_producto=$cod_producto";
  $resultbus=mysqli_query($link,$qrybus);
  $rowbus=mysqli_fetch_array($resultbus);
  $precio=$rowbus['Precio_vta'];	
  $qryup="update det_cot_personalizada set Prec_producto=$precio where Id_cot_per=$cotizacion and Cod_producto=$cod_producto;";
  $resultup=mysqli_query($link,$qryup);
  mysqli_close($link);
  echo '<form method="post" action="det_cot_personalizada.php" name="form3">';
  echo'<input name="Crear" type="hidden" value="5">'; 
  echo'<input name="cotizacion" type="hidden" value="'.$cotizacion.'">'; 
  echo '</form>';
  echo'<script >
	  document.form3.submit();
	  </script>';
}
$link=conectarServidor(); 
$qry2="select Id_cotiz_p, Fech_Cotizacion, Nom_clien, Contacto, Cargo, Tel_clien, Fax_clien, Cel_clien, Dir_clien, Eml_clien, tipo_precio, nom_personal, cel_personal 
from  cot_personalizada, clientes_cotiz, tip_precio, personal where Cliente_cot=Id_cliente and tip_precio=Id_precio and cod_vend=Id_personal and Id_cotiz_p=$cotizacion";
$result2=mysqli_query($link,$qry2);
if ($row2=mysqli_fetch_array($result2))
{
	mysqli_close($link);
}
else
{
	mover("buscarCotPer.php","No existe la Cotización");
	mysqli_close($link);
}
?>
<table border="0"  align="center" cellpadding="0" summary="Encabezado" width="62%">
<tr>
  <td width="15%" align="right" ><strong>No. de Cotizaci&oacute;n</strong></td>
  <td width="3%"><div align="left"><?php echo $cotizacion;?></div></td>
  <td width="15%" align="right" ><strong>Fecha Cotizaci&oacute;n</strong></td>
  <td width="17%" colspan="1"  align="left"><?php echo $row2['Fech_Cotizacion']; ?></td>
  <td width="15%" align="right"><strong>Cliente</strong></td>
  <td width="35%" colspan="3"><div align="left"><?php echo $row2['Nom_clien']; ?></div></td>
</tr>
<tr>
  <td align="right" ><strong>Tipo de Precio</strong></td>
  <td colspan="3"  align="left"><?php echo $row2['tipo_precio']; ?></td>
  <td align="right"><strong>Contacto</strong></td>
  <td width="35%" colspan="1"><?php echo $row2['Contacto']; ?></td>
</tr>
<tr>
  <td align="right"><strong>Vendedor</strong></td>
  <td colspan="3" align="left"><?php echo $row2['nom_personal']; ?></td>
  <td align="right"  ><strong>Cargo Contacto</strong></td>
  <td colspan="1" align="left"><?php echo $row2['Cargo']; ?></td>
</tr>
<tr><td colspan="6">&nbsp;</td></tr>
</table>
<?php
$link=conectarServidor(); 
echo '<form method="post" action="det_cot_personalizada.php" name="form1">
	<table border="0"  align="center" cellpadding="0" summary="cuerpo1"> 
	<tr>
		<td colspan="4"><div align="center"><strong>Productos Novaquim</strong></div></td>
		<td colspan="1"><div align="center"><strong>Unidades</strong></div></td>
		<td colspan="1"><div align="center"></div></td>
	</tr>
	<tr>
		<td colspan="4"><div align="center">';
echo'<select name="cod_producto">';
	$result=mysqli_query($link,"SELECT Cod_prese, Nombre FROM prodpre, productos where prodpre.Cod_produc=productos.Cod_produc and prod_activo=0 and pres_activo=0 order by Nombre;");
	while($row=mysqli_fetch_array($result))
	{
		echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
	}
	echo'</select>';
	echo '</div></td>
	<td colspan="1"><div align="center"><input name="cantidad" type="text" size=7 onKeyPress="return aceptaNum(event)"></div></td>';
	echo '<td colspan="1" align="center"><input name="Crear" type="hidden" value="1"><input name="cotizacion" type="hidden" value="'.$cotizacion.'"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar" ></td>';
	echo '</table> </form>
	 <form method="post" action="det_cot_personalizada.php" name="form2">
	 <table border="0"  align="center" cellpadding="0" summary="cuerpo1">
	<tr>
		<td colspan="4"><div align="center"><strong>Productos Distribuci&oacute;n</strong></div></td>
		<td colspan="1"><div align="center"><strong>Unidades</strong></div></td>
	</tr>
	<tr>
		<td colspan="4"><div align="center">';
	echo'<select name="cod_producto">';
	$result=mysqli_query($link,"select Id_distribucion, Producto from distribucion where Activo=0 order by Producto;");
	while($row=mysqli_fetch_array($result))
	{
		echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
	}
	echo '</select>';
	echo '</div></td>
		<td colspan="1"><div align="center"><input name="cantidad" type="text" size=7 onKeyPress="return aceptaNum(event)"  ></div></td>';
	echo '<td align="center"><input name="Crear" type="hidden" value="2"><input name="cotizacion" type="hidden" value="'.$cotizacion.'"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar" ></td>';
	echo '</table></form>';
	mysqli_close($link);
?>
<table border="0" align="center" cellpadding="0" cellspacing="0" summary="cuerpo" width="70%">
<tr>
  <th width="1%">&nbsp;</th>
  <th width="6%" align="center"><strong>Item</strong></th>
  <th width="9%" align="center"><strong>C&oacute;digo</strong></th>
  <th width="43%" align="center"><strong>Producto </strong></th>
  <th width="9%" align="center" ><strong>Cantidad </strong></th>
  <th width="9%" align="center"><strong>Precio </strong></th>
  <th width="12%" align="center"><strong>Subtotal </strong></th>
  <th width="11%">&nbsp;</th>
</tr>
<?php
$link=conectarServidor();
$qry="select Cod_producto, Can_producto, Nombre, Prec_producto, Prec_producto*Can_producto as subtotal from det_cot_personalizada, prodpre, cot_personalizada where Cod_producto=Cod_prese and Id_cotiz_p=$cotizacion and Id_cotiz_p=Id_cot_per order by Nombre";
$i=0;
$a=0;
if ($result=mysqli_query($link,$qry))
{
  while($row=mysqli_fetch_array($result))
  {
	$cod=$row['Cod_producto'];
	$cantidad=$row['Can_producto'];
	$precio=$row['Prec_producto'];
	$i=$i+1;
	echo'<tr><td align="center" valign="middle">';
	echo '<form action="updateCotPers.php" method="post" name="actualiza'.$i.'">
		<input type="submit" class="formatoBoton" name="Submit" value="Cambiar" >
		<input name="cotizacion" type="hidden" value="'.$cotizacion.'">
		<input name="producto" type="hidden" value="'.$cod.'">
		<input name="cantidad" type="hidden" value="'.$cantidad.'">
		<input name="precio" type="hidden" value="'.$precio.'">
		</form>';
	echo '</td>
		<td';
		if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo '><div align="center">'.$i.'</div></td>
		<td';
		if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo '><div align="center">'.$row['Cod_producto'].'</div></td>
		<td';
		if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo ' ><div align="left">'.$row['Nombre'].'</div></td>
		<td ';
		if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo '><div align="center">'.$row['Can_producto'].'</div></td>
		<td';
		if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo '><div align="center">$ '.$row['Prec_producto'].'</div></td>
		<td';
		if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo ' ><div align="center">$ '.$row['subtotal'].'</div></td>
		<td align="center">';
		echo '<form action="delprodCotPer.php" method="post" name="elimina'.$i.'">
		<input type="submit" class="formatoBoton" name="Submit" value="Eliminar">
		<input name="cotizacion" type="hidden" value="'.$cotizacion.'">
		<input name="producto" type="hidden" value="'.$cod.'">
	</form>';
	echo '</td></tr>';
  }
  mysqli_close($link);
}
?>
<?php
$link=conectarServidor();
$bd="novaquim";
$qry="select Cod_producto, Can_producto, Producto, Prec_producto, Prec_producto*Can_producto as subtotal from det_cot_personalizada, distribucion, cot_personalizada where Cod_producto=Id_distribucion and Id_cotiz_p=$cotizacion and Id_cotiz_p=Id_cot_per order by Producto;";
if ($result=mysqli_query($link,$qry))
{
  while($row=mysqli_fetch_array($result))
  {
	$cod=$row['Cod_producto'];
	$cantidad=$row['Can_producto'];
	$precio=$row['Prec_producto'];
	$i=$i+1;
	echo'<tr>
	<td align="center" valign="middle">';
		echo '<form action="updateCotPers.php" method="post" name="actualiza'.$i.'">
		<input type="submit" class="formatoBoton" name="Submit" value="Cambiar">
		<input name="cotizacion" type="hidden" value="'.$cotizacion.'">
		<input name="producto" type="hidden" value="'.$cod.'">
		<input name="cantidad" type="hidden" value="'.$cantidad.'">
		<input name="precio" type="hidden" value="'.$precio.'">
	</form>';
	echo '</td>
	<td';
	if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '><div align="center">'.$i.'</div></td>
	<td';
		if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo '><div align="center">'.$row['Cod_producto'].'</div></td>
	<td';
		if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo '><div align="left">'.$row['Producto'].'</div></td>
	<td';
		if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo ' ><div align="center">'.$row['Can_producto'].'</div></td>
	<td';
		if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo ' ><div align="center">$ '.$row['Prec_producto'].'</div></td>
	<td';
		if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
		echo '><div align="center">$ '.$row['subtotal'].'</div></td>
	<td align="center" valign="middle">';
	echo '<form action="delprodCotPer.php" method="post" name="elimina'.$i.'">
	<input type="submit" class="formatoBoton" name="Submit" value="Eliminar" >
	<input name="cotizacion" type="hidden" value="'.$cotizacion.'">
	<input name="producto" type="hidden" value="'.$cod.'">
	</form>';
	echo '</td></tr>';
  }
}
$qrytot="SELECT SUM(Can_producto*Prec_producto) as Total FROM det_cot_personalizada where Id_cot_per=$cotizacion;";
$resulttot=mysqli_query($link,$qrytot);
$row_tot=mysqli_fetch_array($resulttot);
$total=number_format($row_tot['Total'],0,'.',',');
echo'<tr>
<td colspan="3"></td>
<td colspan="3"><div align="right"><strong>TOTAL COTIZACI&Oacute;N</strong></div></td>
<td><div align="center"><strong> $ '.$total.'</strong></div></td>
</tr>';
mysqli_close($link);
?>

<tr><td colspan="7">&nbsp;</td></tr>
<tr>
  <td colspan="4">
    <form action="Imp_Cot_Per.php" method="post" target="_blank">
    <div align="center">
    <input name="cotizacion" type="hidden" value="<?php echo $cotizacion; ?>">
    <input type="submit" name="Submit" value="Imprimir" >
    </div>
    </form>                
  </td> 
  <td colspan="3"> 
    <form action="Cot_Per_Xls.php" method="post"  target="_blank">
    <div align="left">
    <input name="cotizacion" type="hidden" value="<?php echo $cotizacion; ?>">
    <input type="submit" name="Submit2" value="Exportar a Excel" >
    </div>
    </form>                
  </td>
</tr>           
</table>
<?php 
  echo'<input name="Crear" type="hidden" value="0">'; 
  echo'<input name="cotizacion" type="hidden" value="'.$cotizacion.'">'; 
?> 
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div> 
</body>
</html>
	   