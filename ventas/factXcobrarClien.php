<?php
include "../includes/valAcc.php";
include "includes/calcularDias.php";
$cliente=$_POST[cliente];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<title>Facturas por Cobrar por Cliente</title>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css" >
<script  src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>FACTURAS PENDIENTES DE COBRO POR INDUSTRIAS NOVAQUIM S.A.S.</strong></div> 
<table width="700" border="0" align="center">
  <tr> <td width="85%" align="right"><form action="FacturasXCobrarCli_Xls.php" method="post" target="_blank"><input name="cliente" type="hidden" value="<?php echo $cliente; ?>"><input name="Submit" type="submit" value="Exportar a Excel"></form></td>
    <td width="196"><form action="Imp_EstadoCobros.php" method="post" target="_blank"><input type="submit" name="Submit" value="Imprimir Estado de Cartera">
    </form></td>
     <td width="86"><input type="button" onClick="window.location='menu.php'" value="Ir al Menú"></td>
  </tr>
</table>
<table  border="0" align="center" cellspacing="0"  cellpadding="0">
<tr>
    <th width="69" scope="col"></th>
    <th width="45" class="formatoEncabezados" scope="col">Factura</th>
    <th width="75" class="formatoEncabezados" scope="col">Fecha de Factura</th>
    <th width="75" class="formatoEncabezados" scope="col">Fecha Vencimiento</th>
    <th width="340" class="formatoEncabezados" scope="col">Cliente</th>
    <th width="210" class="formatoEncabezados" scope="col">Contacto</th>
    <th width="53" class="formatoEncabezados" scope="col">Teléfono</th>
    <th width="80" class="formatoEncabezados" scope="col">Celular</th>
    <th width="80" class="formatoEncabezados" scope="col">Valor Factura </th>
    <th width="80" class="formatoEncabezados" scope="col">Valor a Cobrar </th>
    <th width="80" class="formatoEncabezados" scope="col">Valor Cobrado </th>
    <th width="80" class="formatoEncabezados" scope="col">Saldo</th>
  </tr>
      <?php
	  include "includes/conect.php";
	  $fecha_actual=date("Y")."-".date("m")."-".date("d");
	  //$cliente=$_POST[cliente];
	  $total=0;
	  $totalvenc=0;
	  $totalavenc=0;
	  $totalnvenc=0;
	  $link=conectarServidor();
	  if($link)
	  	{  
			$qry= "select idFactura, nomCliente, contactoCliente, cargoCliente, telCliente, celCliente, fechaFactura, fechaVenc, Total, Descuento, totalR,  retencionIva, retencionIca, retencionFte, 	Subtotal, IVA 
			from factura, clientes WHERE Nit_cliente=nitCliente and factura.Estado='P' and Nit_cliente='$cliente';";
			$result=mysqli_query($link,$qry);
			$a=1;
			while($row=mysqli_fetch_array($result))
			{
				$factura=$row['Factura'];
				$fecVen=$row['Fech_venc'];
				$fact=$row['Factura'];
				$retefuente=$row['Reten_fte'];
				$Subtotal=$row['Subtotal'];
				$totalfac=$row['Total'];
				$Descuento=$row['Descuento']*$Subtotal;
				$Total_R=$row['Total_R'];
				$reteica=$row['Reten_ica'];
				$reteiva=$row['Reten_iva'];
				$qry="select sum(cobro) as Parcial from r_caja where Fact=$fact";
				$resultpago=mysqli_query($link,$qry);
				$rowpag=mysqli_fetch_array($resultpago);
				if($rowpag['Parcial'])
					$parcial=$rowpag['Parcial'];
				else
					$parcial=0;
				$qrync="select round(Total)as pago_nc, Fecha  from nota_c where Fecha>'2016-04-05' and Fac_dest=$fact";
				//echo " ".$qrync." ";
				$resultnc=mysqli_query($link,$qrync);
				$rownc=mysqli_fetch_array($resultnc);
				if($rownc['pago_nc']){
					$pago_nc=$rownc['pago_nc'];
					$Fecha_nc=$rownc['Fecha'];}
				else
					$pago_nc=0;
				if($factura<9981)
				{
				$ValTot=round($Total_R-$Descuento-$retefuente-$reteiva-$reteica);
				}
				else
				{
				$ValTot=round($Total_R-$Descuento-$reteiva-$reteica-$retefuente);
				}	
				$dias=Calc_Dias($fecVen,$fecha_actual);
				if ($dias<0)
				{
					$formato="formatoDatos1";
					$totalvenc=$totalvenc+$ValTot-$parcial;
				}	
				if ($dias>=0 && $dias<=8)
				{
					$formato="formatoDatos2";
					$totalavenc=$totalavenc+$ValTot-$parcial;
				}	
				if ($dias>8)
				{
					$formato="formatoDatos";
					$totalnvenc=$totalnvenc+$ValTot-$parcial;
				}	
				echo'<tr class="'.$formato.'"';
			 	echo '><td align="center" valign="middle" >
			 	<form action="recibo_caja1.php" method="post" name="apppago">
					<div align="center">
						<input class="formatoBoton" type="submit" name="Submit" value="Cobrar" >
						<input name="Pago" type="hidden" value="0" >
						<input name="factura" type="hidden" value="'.$factura.'" >
			       		<input name="fecVen" type="hidden" value="'.$fecVen.'" >
			       		<input name="ValTot" type="hidden" value="'.$ValTot.'" >
			    	</div>
				</form></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="center">'.$row['Factura'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="center">'.$row['Fech_fact'].'</div></td>
    	    	<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="center">'.$row['Fech_venc'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="left">'.$row['Nom_clien'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="left">'.$row['Contacto'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="right">'.$row['Tel_clien'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="right">'.$row['Cel_clien'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="right">$ <script > document.write(commaSplit('.($row['Total_R']).'))</script></div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="right">$ <script > document.write(commaSplit('.$ValTot.'))</script></div></td>';
				echo '<td'; 
				if (($a % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="right">$ <script > document.write(commaSplit('.$parcial.'))</script></div></td>';	
				$saldo=$ValTot-$parcial;
				echo '<td'; 
				if (($a++ % 2)==0) echo ' bgcolor="#CCD5FF" ';
				echo '><div align="right">$ <script > document.write(commaSplit('.$saldo.'))</script></div></td>';				
      		 	echo'</tr>';
				
			}
			echo'<tr>
				<td colspan="5" ></Td>
				<td colspan="4" class="titulo1" align="right">TOTAL VENCIDO :</Td>
				<td colspan="2" class="titulo1"><div align="left">$ <script > document.write(commaSplit('.$totalvenc.'))</script></div> </td>
				</tr>';
			echo'<tr>
				<td colspan="5" ></Td>
				<td colspan="4" class="titulo2" align="right">TOTAL A VENCER EN UNA SEMANA:</Td>
				<td colspan="2" class="titulo2"><div align="left">$ <script > document.write(commaSplit('.$totalavenc.'))</script></div> </td>
				</tr>';
			echo'<tr>
				<td colspan="5" ></Td>
				<td colspan="4" class="titulo3" align="right">TOTAL SIN VENCER EN UNA SEMANA  :</Td>
				<td colspan="2" class="titulo3"><div align="left">$ <script > document.write(commaSplit('.$totalnvenc.'))</script></div> </td>
				</tr>';
			echo'<tr>
				<td colspan="5" ></Td>
				<td colspan="4" class="titulo" align="right">TOTAL :</Td>
				<td colspan="2" class="titulo"><div align="left">$ <script > document.write(commaSplit('.$total.'))</script></div> </td>
				</tr>';
			mysqli_free_result($result);
			/* cerrar la conexión */
			mysqli_close($link);
	 	}
		else 
		{
			echo "La conexion a la base de datos no se pudo realizar";
		}
	  ?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>
