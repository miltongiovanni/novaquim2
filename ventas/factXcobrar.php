<?php
include "../includes/valAcc.php";
include "includes/calcularDias.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Facturas por Cobrar</title>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script  src="../js/validar.js"></script>
<script  src="scripts/block.js"></script>	
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>FACTURAS PENDIENTES DE COBRO POR INDUSTRIAS NOVAQUIM S.A.S.</strong></div> 
<table width="100%"  align="center" border="0" summary="encabezado">
  <tr> 	<td width="85%" align="right"><form action="FacturasXCobrar_Xls.php" method="post" target="_blank"><input name="Submit" type="submit" value="Exportar a Excel"></form></td>
    	<td  align="center" width="14%"><form action="Imp_EstadoCobros.php" method="post" target="_blank"><input type="submit" name="Submit" value="Imprimir Estado de Cartera"></form></td>
    	<td width="7%"><input type="button" onClick="window.location='menu.php'" value="Ir al Menú"></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo" width="100%">
<tr>
    <th width="1%" scope="col"></th>
    <th width="4%" align="center" class="formatoEncabezados" scope="col">Factura</th>
    <th width="6%" align="center" class="formatoEncabezados" scope="col">Fecha de Factura</th>
    <th width="6%" align="center" class="formatoEncabezados" scope="col">Fecha Vencimiento</th>
    <th width="27%" align="center" class="formatoEncabezados" scope="col">Cliente</th>
    <th width="14%" align="center" class="formatoEncabezados" scope="col">Contacto</th>
    <th width="4%" align="center" class="formatoEncabezados" scope="col">Teléfono</th>
    <th width="6%" align="center" class="formatoEncabezados" scope="col">Celular</th>
    <th width="8%" align="center" class="formatoEncabezados" scope="col">Valor Factura </th>
    <th width="8%" align="center" class="formatoEncabezados" scope="col">Valor a Cobrar </th>
    <th width="8%" align="center" class="formatoEncabezados" scope="col">Valor Cobrado </th>
    <th width="8%" align="center" class="formatoEncabezados" scope="col">Saldo</th>
  </tr>
      <?php
	  include "includes/conect.php";
	  $fecha_actual=date("Y")."-".date("m")."-".date("d");
	  $total=0;
	  $totalvenc=0;
	  $totalavenc=0;
	  $totalnvenc=0;
	  $link=conectarServidor();
	  if($link)
	  	{  
			$qry="select Factura, Nom_clien, Contacto, Cargo, Tel_clien, Cel_clien, Fech_fact, Fech_venc, Total, Descuento, Total_R, Reten_iva, Reten_ica, Reten_fte, Subtotal, IVA 
			from factura, clientes WHERE Nit_cliente=Nit_clien and factura.Estado='P' and Factura>00;";
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
				$qryp="select sum(cobro) as Parcial from r_caja where Fact=$fact";
				$resultpago=mysqli_query($link,$qryp);
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
				$ptotal=$Total_R-$parcial-$pago_nc;
				if (abs($ptotal)<1000)
				{
					$qryupt="update factura set Estado='C', Fech_Canc='$Fecha_nc', Reten_iva=0, Reten_ica=0, Reten_fte=0  where Factura=$factura";
					$resulupdate=mysqli_query($link, $qryupt);
				}
				$dias=Calc_Dias($fecVen,$fecha_actual);
				if ($dias<0)
				{
					$formato="formatoDatos1";
					$totalvenc=$totalvenc+$ValTot-$parcial-$pago_nc;
				}	
				if ($dias>=0 && $dias<=8)
				{
					$formato="formatoDatos2";
					$totalavenc=$totalavenc+$ValTot-$parcial-$pago_nc;
				}	
				if ($dias>8)
				{
					$formato="formatoDatos";
					$totalnvenc=$totalnvenc+$ValTot-$parcial-$pago_nc;
				}	
				$total=$totalvenc+$totalavenc+$totalnvenc;
				echo'<tr class="'.$formato.'"';
				echo '><td align="center" valign="middle">';
				if ((md5(1)==$_SESSION['Perfil'])||(md5(11)==$_SESSION['Perfil']))
				{ 
			 		echo '<form action="recibo_caja1.php" method="post" name="apppago'.$a.'">
					<div align="center">
						<input class="formatoBoton" type="submit" name="Submit" value="Cobrar" >
						<input name="Pago" type="hidden" value="0" >
						<input name="Reten" type="hidden" value="0" >
						<input name="factura" type="hidden" value="'.$factura.'" >
			       		<input name="fecVen" type="hidden" value="'.$fecVen.'" >
			       		<input name="ValTot" type="hidden" value="'.$ValTot.'" >
			    	</div>
					</form>';
				}
				echo '</td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="center">'.$row['Factura'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="center">'.$row['Fech_fact'].'</div></td>
    	    	<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="center">'.$row['Fech_venc'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="left">'.($row['Nom_clien']).'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="left">'.($row['Contacto']).'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">'.$row['Tel_clien'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">'.$row['Cel_clien'].'</div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.$Total_R.'))</script></div></td>
				<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.$ValTot.'))</script></div></td>';
				echo '<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.($parcial+$pago_nc).'))</script></div></td>';	
				$saldo=$ValTot-$parcial-$pago_nc;
				echo '<td'; 
				if (($a++ % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.round($saldo).'))</script></div></td>';				
      		 	echo'</tr>';
			}
			echo'<tr>
				<td colspan="5" ></Td>
				<td colspan="5" class="titulo1" align="right">TOTAL VENCIDO :</Td>
				<td colspan="2" class="titulo1"><div align="left">$ <script  > document.write(commaSplit('.$totalvenc.'))</script></div> </td>
				</tr>';
			echo'<tr>
				<td colspan="5" ></Td>
				<td colspan="5" class="titulo2" align="right">TOTAL A VENCER EN UNA SEMANA:</Td>
				<td colspan="2" class="titulo2"><div align="left">$ <script  > document.write(commaSplit('.$totalavenc.'))</script></div> </td>
				</tr>';
			echo'<tr>
				<td colspan="5" ></Td>
				<td colspan="5" class="titulo3" align="right">TOTAL SIN VENCER EN UNA SEMANA  :</Td>
				<td colspan="2" class="titulo3"><div align="left">$ <script  > document.write(commaSplit('.$totalnvenc.'))</script></div> </td>
				</tr>';
			echo'<tr>
				<td colspan="5" ></Td>
				<td colspan="5" class="titulo" align="right">TOTAL :</Td>
				<td colspan="2" class="titulo"><div align="left">$ <script  > document.write(commaSplit('.$total.'))</script></div> </td>
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
