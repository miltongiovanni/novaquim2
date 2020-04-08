<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Creaci&oacute;n Nota de Cr&eacute;dito</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/javascript" src="scripts/block.js"></script>
    <script type="text/javascript" src="scripts/ajax2.js"></script>
    <script type="text/javascript">
		document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>DETALLE DE LA NOTA CR&Eacute;DITO</strong></div>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
  //echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}  	
include "includes/conect.php";
include "includes/num_letra.php";
$link=conectarServidor();

if ($crear==1)
{
  //PARA CREAR NOTA DE CRÉDITO
  $qrycam="select MAX(Nota) AS Notas from nota_c;";
  $resultqrycam=mysqli_query($link,$qrycam);
  $row_cam=mysqli_fetch_array($resultqrycam);
  $nota=$row_cam['Notas']+1;
  //DESCUENTO EN FACTURA ORIGEN
  $qrydesc="select Descuento from factura where Factura=$fact_ori;";
  $resultqrydesc=mysqli_query($link,$qrydesc);
  $row_desc=mysqli_fetch_array($resultqrydesc);
  $Descuento=$row_desc['Descuento'];
  //CREACIÓN DEL ENCABEZADO DE LA NOTA DE CRÉDITO
  $qryr="insert into nota_c (Nota, Nit_cliente, Fecha, Fac_orig, Fac_dest, motivo, Des_fac_or) values ($nota, '$cliente','$Fecha', $fact_ori, $fact_des, $razon, $Descuento)";
  $resultr=mysqli_query($link,$qryr);
  //CREAR 2 PARA SALIR DEL ENCABEZADO
  echo'<form action="makeNota.php" method="post" name="formulario">';
  echo '<input name="nota" type="hidden" value="'.$nota.'"><input name="crear" type="hidden" value="2"><input type="submit" name="Submit" value="Cambiar" >';
  echo'</form>'; 
  echo' <script  type="text/javascript"> document.formulario.submit(); </script>';
}
if ($crear==6)
{
	//MODIFICAR EL ENCABEZADO DE LA NOTA DE CRÉDITO
  $qryr="update nota_c set Fecha='$Fecha', Fac_orig=$fact_ori, Fac_dest=$fact_des, motivo=$razon where Nota=$nota";
  $resultr=mysqli_query($link,$qryr);
  //CREAR 2 PARA SALIR DEL ENCABEZADO
  echo'<form action="makeNota.php" method="post" name="formulario">';
  echo '<input name="nota" type="hidden" value="'.$nota.'"><input name="crear" type="hidden" value="2"><input type="submit" name="Submit" value="Cambiar" >';
  echo'</form>'; 
  echo' <script  type="text/javascript"> document.formulario.submit(); </script>';
}
$qrynot="select Nota, Nit_cliente, Fecha, Fac_orig, Fac_dest, motivo, Total, Subtotal, IVA, Nom_clien, Tel_clien, Dir_clien, Ciudad from nota_c, clientes, ciudades where Nota=$nota and Nit_cliente=Nit_clien and Ciudad_clien=Id_ciudad";
$resultnot=mysqli_query($link,$qrynot);
$rownot=mysqli_fetch_array($resultnot);
$Fac_orig=$rownot['Fac_orig'];	
$motivo=$rownot['motivo'];
$Fac_dest=$rownot['Fac_dest'];	
$qryffacor="select Fech_fact as FechFactOr from factura where Factura=$Fac_orig";
$resulffacor=mysqli_query($link,$qryffacor);
$rowffacor=mysqli_fetch_array($resulffacor);
$FechFactOr=$rowffacor['FechFactOr'];

$qryffacde="select Fech_fact as FechFactDe from factura where Factura=$Fac_dest";
$resulffacde=mysqli_query($link,$qryffacde);
$rowffacde=mysqli_fetch_array($resulffacde);
$FechFactDe=$rowffacde['FechFactDe'];

if ($crear==3)// SI HAY DEVOLUCIÓN DE PRODUCTOS
{	
  $valor=explode(",", $codigo);
  $cod=$valor[0];
  $not=$valor[1];
  if($cod <100000)
  {	
	$qrylot="SELECT Lote_producto as Lote from remision, det_remision, factura WHERE remision.Id_remision=det_remision.Id_remision AND factura.Id_remision=remision.Id_remision and Factura=$Fac_orig and Cod_producto=$cod;";
	$resultlot=mysqli_query($link,$qrylot);
	$row_lot=mysqli_fetch_array($resultlot);
	$lote=$row_lot['Lote'];
	if ($lote==NULL)
		$lote=0;
	$qryinv="select Cod_prese, lote_prod, inv_prod from inv_prod where Cod_prese=$cod and lote_prod=$lote";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$invt=$rowinv['inv_prod'];
	if ($invt==NULL)
	{
	  $qryupt="insert into inv_prod (Cod_prese, lote_prod, inv_prod) values ($cod, $lote, $cantidad)";
	}
	else
	{
	  $invt= $invt + $cantidad;
	  //SE ACTUALIZA EL INVENTARIO
	  $qryupt="update inv_prod set inv_prod=$invt where lote_prod=$lote and Cod_prese=$cod";
	}
	$resultupt=mysqli_query($link,$qryupt);
	//INSERCION DEL DETALLE DE LA NOTA DE CREDITO
	$qryr="insert into det_nota_c (Id_Nota, Cod_producto, Can_producto) values ($nota, $cod, $cantidad)";
	$resultr=mysqli_query($link,$qryr);
	echo'<form action="makeNota.php" method="post" name="formulario">';
	echo '<input name="nota" type="hidden" value="'.$nota.'"><input name="crear" type="hidden" value="5"><input type="submit" name="Submit" class="formatoBoton1" value="Cambiar" >';
	echo'</form>'; 
	echo' <script  type="text/javascript"> document.formulario.submit(); </script>';
  }
  else
  {
	$qryfac="select Can_producto from det_factura WHERE Id_fact=$Fac_orig and Cod_producto=$cod";
	$resultfac=mysqli_query($link,$qryfac);
	$row_fac=mysqli_fetch_array($resultfac);
	$cant=$row_fac['Can_producto'];
	if ($cant>=$cantidad)
	{
	  $qryinv="select Id_distribucion, inv_dist from inv_distribucion WHERE Id_distribucion=$cod";
	  $resultinv=mysqli_query($link,$qryinv);
	  $rowinv=mysqli_fetch_array($resultinv);
	  $invt=$rowinv['inv_dist'];
	  if ($invt==NULL)
	  {
		$qryupt="insert into inv_distribucion (Id_distribucion, inv_dist) values ($cod, $cantidad)";
	  }
	  else
	  {
		$invt= $invt + $cantidad;
		//SE ACTUALIZA EL INVENTARIO
		$qryupt="update inv_distribucion set inv_dist=$invt where Id_distribucion=$cod";
	  }
	  $resultupt=mysqli_query($link,$qryupt);
	  //INSERCION DEL DETALLE DE LA NOTA DE CREDITOS
	  $qryr="insert into det_nota_c (Id_Nota, Cod_producto, Can_producto) values ($nota, $cod, $cantidad)";
	  $resultr=mysqli_query($link,$qryr);
	  echo'<form action="makeNota.php" method="post" name="formulario">';
	  echo '<input name="nota" type="hidden" value="'.$nota.'"><input name="crear" type="hidden" value="5"><input type="submit" name="Submit" value="Cambiar" >';
	  echo'</form>'; 
	  echo' <script  type="text/javascript"> document.formulario.submit(); </script>';
	}
	else
	{
	  echo '<form method="post" action="makeNota.php" name="form3">';
	  echo'<input name="crear" type="hidden" value="2">'; 
	  echo'<input name="nota" type="hidden" value="'.$nota.'">'; 
	  echo '</form>';
	  echo' <script >
	  alert("La cantidad de producto es mayor a la de la factura");
	  document.form3.submit();
	  </script>'; 
	}
}
}
if ($crear==4) //SI NO SE HA HECHO DESCUENTO
{
  //CREACIÓN DEL DETALLE DE LA NOTA DE CRÉDITO CUANDO NO SE HA HECHO EL DESCUENTO
  $qrys="select Id_Nota, Cod_producto from det_nota_c where Id_Nota=$nota";
  echo $qrys;
  $results=mysqli_query($link,$qrys);
  $rows=mysqli_fetch_array($results);
  
  if ($rows['Cod_producto']==0)
  	$qryr="update det_nota_c set Cod_producto=0, Can_producto=$descuento where Id_Nota=$nota";
if ($rows['Cod_producto']==NULL)
  	$qryr="insert into det_nota_c (Id_Nota, Cod_producto, Can_producto) values ($nota, 0,$descuento)";
  echo $qryr; 
  $resultr=mysqli_query($link,$qryr);
  echo'<form action="makeNota.php" method="post" name="formulario">';
  echo '<input name="nota" type="hidden" value="'.$nota.'"><input name="crear" type="hidden" value="5"><input type="submit" class="formatoBoton1" name="Submit"  value="Cambiar" >';
  echo'</form>'; 
  echo' <script  type="text/javascript"> document.formulario.submit(); </script>';
}
if ($crear==5) //PARA CANCELAR SI LA NOTA ES POR TODA LA FACTURA
{
  //CONSULTA EL TOTAL DE NOTA
  $qrys="SELECT round(nota_c.Total) as totaln, Fecha, Fac_dest, factura.Total as totalf FROM nota_c, factura where Nota=$nota and Factura=Fac_dest";
  $results=mysqli_query($link,$qrys);
  $rows=mysqli_fetch_array($results);
  $totaln=$rows['totaln'];
  $Fac_dest=$rows['Fac_dest'];
  $Fechan=$rows['Fecha'];
  $totalf=$rows['totalf'];
  if (abs($totalf-$totaln)<1000)
  {
  	$qryr="update factura set Estado='C', Fech_Canc='$Fechan' where Factura=$Fac_dest;";
    $resultr=mysqli_query($link,$qryr);
  }
}

function mover_pag($ruta,$Mensaje)
{
	echo'<script >
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
<table  align="center" border="0" summary="encabezado">
    <tr>
      <td width="136"><div align="right"><strong>NOTA CR&Eacute;DITO:</strong> </div></td>
      <td width="208"><div align="left"><?php echo $nota;?></div></td>
      <td width="66"><div align="right"><strong>NIT:</strong></div></td>
      <td width="120" colspan="1"><?php echo $rownot['Nit_cliente']; ?></td>
      <td width="144"><div align="right"><strong>FECHA NOTA:</strong></div></td>
      <td width="99"><?php echo  $rownot['Fecha']?></td>
    </tr>
    <tr>
      <td><div align="right"><strong>CLIENTE:</strong></div></td>
      <td colspan="3"><?php echo  $rownot['Nom_clien']; ?></td>
      <td ><div align="right"><strong>FACTURA ORIGEN:</strong></div></td>
      <td colspan="1"><?php echo $rownot['Fac_orig']; ?></td>
    </tr>
    <tr>
      <td ><div align="right"><strong>DIRECCI&Oacute;N:</strong></div></td>
      <td colspan="3"><?php echo $rownot['Dir_clien']; ?></td>
      <td ><div align="right"><strong>FACTURA AFECTA:</strong></div></td>
      <td colspan="1"><?php echo $rownot['Fac_dest']; ?></td>
    </tr>
</table>
<form action="makeNota.php" method="post" name="formulario">
<?php 
if (($motivo==0)&&(($crear==5)||($crear==2)))  //CREAR 2 PARA ENTRAR EN LA OPCIÓN 0 MOTIVO DEVOLUCIÓN DE PRODUCTOS
{
	echo '<table width="668" border="0" align="center" summary="carga">
	<tr>
	<th colspan="3" align="center"><strong>PRODUCTOS PARA DEVOLUCI&Oacute;N</strong></th>
	</tr>
	<tr>
	<th width="406" align="center" class="font2"><strong>Producto</strong></th>
	<th width="123" align="center" class="font2"><strong>Cantidad</strong></th>
	</tr>
    <tr><td align="center">';
	$qryd="select Cod_producto, Nombre as Producto, Can_producto from det_factura, prodpre where Id_fact=$Fac_orig and Cod_producto=Cod_prese
	union
	select Cod_producto, Producto, Can_producto from det_factura, distribucion where Id_fact=$Fac_orig and Cod_producto=Id_distribucion";
	$resultd=mysqli_query($link,$qryd);
	echo'<select name="codigo" id="codigo" onChange="loadXMLDoc()" required>';
	$result=mysqli_query($link," select Tabla.Cod_producto, Tabla.Producto, Nota 
	FROM (select Cod_producto, Nombre as Producto, Can_producto, Nota from det_factura, prodpre, nota_c where Id_fact=Fac_orig and Cod_producto=Cod_prese and Nota=$nota
	union select Cod_producto, Producto, Can_producto, Nota from det_factura, distribucion, nota_c where Id_fact=Fac_orig and Cod_producto=Id_distribucion and Nota=$nota) as Tabla 
	LEFT JOIN det_nota_c ON Tabla.Cod_producto=det_nota_c.Cod_producto AND Id_Nota=$nota where det_nota_c.Cod_producto IS NULL;");
	echo '<option value="" selected>'."--------------------------------------------".'</option>';
	while($row=mysqli_fetch_array($result))
	{
		echo '<option value='.$row['Cod_producto'].','.$row['Nota'].'>'.$row['Producto'].'</option>';
	}
	echo'</select>';
	echo '</td><td align="center"><div id="myDiv"></div></td>';
	//echo '<td align="center"><input name="cantidad" type="text" size=10 ></td>';
	echo '<td width="125" align="right"><input name="submit" onClick="return Enviar(this.form)" type="submit"  value="Continuar" >
	  <input name="crear" type="hidden" value="3"><input name="nota" id="nota" type="hidden" value="'.$nota.'"> 
	</td>
	</tr>
</table>';
}
if (($motivo==1) && ($crear==2))// CREAR 2 ACTIVAR LA OPCION DE MOTIVO 1 QUE ES DESCUENTO NO REALIZADO
{
  echo '<table border="0" align="center" summary="carga">
	<tr>
	  <th width="105" align="center"><strong>DESCUENTO</strong></th>
	</tr>
	<tr>
	  <td align="center"><input type="text" name="descuento" size=5 onKeyPress="return aceptaNum(event)"> %';
 echo '</td>
	  	<td width="125" align="right"><input name="submit" class="formatoBoton1" onClick="return Enviar(this.form)" type="submit"  value="Continuar" >
		<input name="crear" type="hidden" value="4"><input name="nota" type="hidden" value="'.$nota.'"> 
	  </td>
	</tr>
  </table>';	
}
?>

</form>
<?php	
	if (($motivo==0) && (($crear==5)||($crear==2)))
	{
	  echo '<table border="0" align="center" summary="detalle">
		<tr>
		  <td  colspan="6">&nbsp;</td>
		</tr>
		<tr>
		  <th width="20"> </th>
		  <th width="53" align="center" class="font2"><strong>C&Oacute;DIGO</strong></th>
		  <th width="358" align="center" class="font2"><strong>PRODUCTO</strong></th>
		  <th width="50" align="center" class="font2"><strong>CAN</strong></th>
		  <th width="47" align="center" class="font2"><strong>IVA</strong></th>
		  <th width="80" align="center" class="font2"><strong>VLR. UNIT</strong></th>
		  <th width="80" align="center" class="font2"><strong>VLR. TOTAL</strong></th>
		  <th width="20"> </th>
		</tr>';
	  
	  $link=conectarServidor();
	  $qry="select det_nota_c.Cod_producto as codigo, Nombre as producto, det_nota_c.Can_producto as cantidad, tasa, Id_tasa, Des_fac_or, prec_producto as precio, (prec_producto*det_nota_c.Can_producto) AS subtotal FROM det_nota_c, nota_c, det_factura, prodpre, 	
	  tasa_iva 
	  where Id_Nota=Nota and Id_Nota=$nota and det_nota_c.Cod_producto<100000 and Fac_orig=Id_fact AND det_nota_c.Cod_producto=det_factura.Cod_producto AND det_nota_c.Cod_producto=Cod_prese and Cod_iva=Id_tasa 
	  union
	  select det_nota_c.Cod_producto as codigo, Producto as producto,det_nota_c.Can_producto as cantidad, tasa, Id_tasa, Des_fac_or,  prec_producto as precio, (prec_producto*det_nota_c.Can_producto) AS subtotal from det_nota_c, nota_c, det_factura, distribucion, 	
	  tasa_iva 
	  where Id_Nota=Nota and Id_Nota=$nota and det_nota_c.Cod_producto>100000 AND Fac_orig=Id_fact AND det_nota_c.Cod_producto=det_factura.Cod_producto AND det_nota_c.Cod_producto=Id_distribucion and Cod_iva=Id_tasa ;";
	  $result=mysqli_query($link,$qry);
	  $subtotal=0;
	  $descuento=0;
	  $iva10=0;
	  $iva16=0;
	  $a=0;
	  while($row=mysqli_fetch_array($result))
	  {
		  $codigo=$row['codigo'];
		  $cantidad=$row['cantidad'];		  
		  $subtotal += $row['cantidad']*$row['precio'];
		  $descuento+= $row['cantidad']*$row['precio']*$row['Des_fac_or'];
		  $Prec=number_format($row['precio'], 0, '.', ',');
		  $tot=number_format($row['precio']*$row['cantidad'], 0, '.', ',');
		  if ($row['tasa']==0.05)
			  $iva10 += $row['cantidad']*$row['precio']*$row['tasa']*(1-$row['Des_fac_or']);
			  
		if ($FechFactOr<FECHA_C)
		{
			if ($row['Id_tasa']==3)
			$iva16 += $row['cantidad']*$row['precio']*0.16*(1-$row['Des_fac_or']);
		}
		else
		{
		if ($row['Id_tasa']==3)
			$iva16 += $row['cantidad']*$row['precio']*$row['tasa']*(1-$row['Des_fac_or']);
		}	  		  
		  echo'<tr>
		      <td class="font2"><div align="center">';
			 echo '<form action="updateDetNotaC.php" method="post" name="actualiza'.$a.'">
						<input type="submit" class="formatoBoton" name="Submit" value="Cambiar" >
						<input name="codigo" type="hidden" value="'.$codigo.'">
						<input name="cantidad" type="hidden" value="'.$cantidad.'">
						<input name="nota" type="hidden" value="'.$nota.'">
						</form>';
			  
			  
			  
			  echo '</div></td>
			  <td class="font2"';
			  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			  echo '><div align="center">'.$row['codigo'].'</div></td>
			  <td class="font2"';
			  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			  echo '><div align="left">'.$row['producto'].'</div></td>
			  <td class="font2"';
			  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			  echo '><div align="center">'.$row['cantidad'].'</div></td>
			  <td class="font2"';
			  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			  echo '><div align="center">'.($row['tasa']*100).' %</div></td>
			  <td class="font2"';
			  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			  echo '><div align="center">$ '.$Prec.'</div></td>
			  <td class="font2"';
			  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
			  echo '><div align="center">$ '.$tot.'</div></td>';
			  echo '<td class="font2"><div align="center"><form action="delDetNotaC.php" method="post" name="actualiza'.$a.'">
						<input type="submit" class="formatoBoton" name="Submit" value="Eliminar" >
						<input name="codigo" type="hidden" value="'.$codigo.'">
						<input name="cantidad" type="hidden" value="'.$cantidad.'">
						<input name="nota" type="hidden" value="'.$nota.'">
						</form>';
			  echo '</tr>';
	  }
	  $Iva_10=number_format($iva10, 0, '.', ',');
	  $Iva_16=number_format($iva16, 0, '.', ',');
	  $Sub=number_format($subtotal, 0, '.', ',');
	  $Desc=number_format($descuento, 0, '.', ',');
	  $Total= $subtotal+$iva10+$iva16-$descuento;
	  $iva=$iva10+$iva16;
	  $Tot=number_format($Total, 0, '.', ',');
	  echo'<tr>
		  <td><div align="left"><strong>SON:</strong></div></td>
		  <td colspan="5"><div align="right"><strong>SUBTOTAL</strong></div></td>
		  <td><div align="center"><strong>$ '.$Sub.'</strong></div></td>
		  </tr>';
	  echo'<tr>
		  <td colspan="4" rowspan="4"><div align="left"><strong>'.numletra(round($Total)).'</strong></div></td>
		  </tr>';
		  
		  
		  
	  echo'<tr>
		  <td colspan="2"><div align="right"><strong>DESCUENTO</strong></div></td>
		<td><div align="center"><strong>$ '.$Desc.'</strong></div></td>
		  </tr>';
		  
		  
		  
	  echo'<tr>
		  <td colspan="2"><div align="right"><strong>IVA 5%</strong></div></td>
		  <td><div align="center"><strong>$ '.$Iva_10.'</strong></div></td>
		  </tr>';
	  echo'<tr>
		  <td colspan="2"><div align="right"><strong>';
	if ($FechFactOr<FECHA_C)
	echo 'IVA 16%';
	else
	echo 'IVA 19%';
		  echo'</strong></div></td>
		  <td><div align="center"><strong>$ '.$Iva_16.'</strong></div></td>
		  </tr>';
	  echo'<tr>
		  <td colspan="6"><div align="right"><strong>TOTAL</strong></div></td>
		  <td><div align="center"><strong>$ '.$Tot.'</strong></div></td>
		  </tr></table>';
	  $qryupd="update nota_c set Total=$Total , Subtotal=$subtotal, IVA=$iva where Nota=$nota";
	  $result=mysqli_query($link,$qryupd);
	  mysqli_close($link);
	  echo '<form method="post" action="detCompramp.php" name="form3">';
	  echo'<input name="crear" type="hidden" value="3">'; 
	  echo'<input name="nota" type="hidden" value="'.$nota.'">'; 
	  echo '</form>';
	}
	if (($motivo==1) && ($crear==5))
	  {
		  $qrydet="select Can_producto as Descuento, Factura.Subtotal from det_nota_c, nota_c, factura where Id_Nota=$nota and Id_Nota=Nota and Fac_orig=Factura;";
		  $resultdet=mysqli_query($link,$qrydet);
	  	  $rowdet=mysqli_fetch_array($resultdet);
	  	  $desct=$rowdet['Descuento'];
		  $subtotalfac = $rowdet['Subtotal'];
		  $vdesc=$subtotalfac * $desct /100;
		  $subtotal=$vdesc;
		  $subtotalf= number_format($subtotal, 0, '.', ',');
		  echo '<table border="0" align="center" summary="detalle">
		<tr>
		  <th width="473" align="center"><strong>DESCRIPCI&Oacute;N</strong></th>
		  <th width="136" align="center"><strong>VALOR</strong></th>
         </tr>
         <tr>
          <td align="center">Descuento '.$desct.' % Comercial no concedido en la Factura No.'.$Fac_orig.'</td>
          <td align="center">$ '.$subtotalf.'</td>
		</tr>
      	</table>';
		$iva16=$subtotal*.16;
	  	$Iva_16=number_format($iva16, 0, '.', ',');
	  	$Total= $subtotal+$iva16;
	  	$iva=$iva16;
	  	$Tot=number_format($Total, 0, '.', ',');
	  	echo'<table border="0" align="center" summary="pie"><tr>
		  <td><div align="left"><strong></strong></div></td>
		  <td colspan="5"><div align="right"><strong>SUBTOTAL</strong></div></td>
		  <td><div align="center"><strong>$ '.$subtotalf.'</strong></div></td>
		  </tr><tr>
		  <td><div align="left"><strong></strong></div></td>
		  <td colspan="5"><div align="right"><strong>IVA</strong></div></td>
		  <td><div align="center"><strong>$ '.$Iva_16.'</strong></div></td>
		  </tr><tr>
		  <td><div align="left"><strong>SON:</strong></div></td>
		  <td colspan="5"><div align="right"><strong>TOTAL</strong></div></td>
		  <td><div align="center"><strong>$ '.$Tot.'</strong></div></td>
		  </tr>';
	  	echo'<tr>
		  <td colspan="3" rowspan="3"><div align="left"><strong>'.numletra(round($Total)).'</strong></div></td>
		  </tr></table>';
		  
		  
		  
		  
		  
		  
		  
	  $qryupd="update nota_c set Total=$Total , Subtotal=$subtotal, IVA=$iva where Nota=$nota";
	  $result=mysqli_query($link,$qryupd);
	  }
    ?>
      <table width="336" align="center" summary="pie">
      <tr>
        <td width="209" colspan="1" align="center">
        <form action="Imp_NotaC.php" method="post" target="_blank">
            <input name="nota" type="hidden" value="<?php echo $nota; ?>">
            <input name="Submit" type="submit" class="formatoBoton1" value="Imprimir Nota Cr&eacute;dito" >
        </form>
        </td>
        <td width="115" colspan="1" align="center">
        <form action="makeNota.php" method="post" name="modificar">
        	<input name="crear" type="hidden" value="2">
            <input name="nota" type="hidden" value="<?php echo $nota; ?>">
            <input name="Submit" type="submit" class="formatoBoton1" value="Modificar" >
        </form>
        </td>
      </tr>
    </table>
<div align="center"><input type="button" class="formatoBoton1" onClick="window.location='menu.php'" value="Terminar"></div>
</div>
</body>
</html>
