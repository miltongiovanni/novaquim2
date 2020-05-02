<?php
include "includes/valAcc.php";
include "includes/calcularDias.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Facturas por pagar</title>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>FACTURAS PENDIENTES DE PAGO POR INDUSTRIAS NOVAQUIM S.A.S.</strong></div>

<table border="0" align="center" width="80%" summary="encabezado">
<tr align="center">
  <td width="62%">&nbsp;</td>
  	<td width="15%"><form action="FacturasXpagar_Xls.php" method="post" target="_blank"><input name="Submit" type="submit" value="Exportar a Excel"></form></td>
    <td width="13%"><form action="Imp_EstadoPagos.php" method="post" target="_blank"><input type="submit" name="Submit" value="Imprimir Estado"></form></td>
  	<td width="10%"><div align="right"><input type="button" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td> 
</tr>
</table>

<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo" width="98%">
      <tr>
        <th width="2%" scope="col">&nbsp;</th>
        <th width="4%" class="formatoEncabezados" scope="col">Id</th>
        <th width="4%" class="formatoEncabezados" scope="col">Factura</th>
        <th width="24%" class="formatoEncabezados" scope="col">Proveedor</th>
        <th width="9%" class="formatoEncabezados" scope="col">Fecha Factura</th>
        <th width="7%" class="formatoEncabezados" scope="col">Fecha Vto</th>
        <th width="8%" class="formatoEncabezados" scope="col">Valor Factura </th>
        <th width="6%" class="formatoEncabezados" scope="col">Retenci&oacute;n</th>
        <th width="8%" class="formatoEncabezados" scope="col">Rete Ica</th>
        <th width="8%" class="formatoEncabezados" scope="col">Valor a Pagar</th>
        <th width="10%" class="formatoEncabezados" scope="col">Valor Pagado</th>
        <th width="10%" class="formatoEncabezados" scope="col">Saldo</th>
  </tr>
      <?php
	  include "includes/conect.php";
	  $link=conectarServidor();
	  $fecha_actual=date("Y")."-".date("m")."-".date("d");
	  $total=0;
	  $totalvenc=0;
	  $totalavenc=0;
	  $totalnvenc=0;
	  if($link)
	  	{  
			$qry="select idCompra as Id, Compra, nit_prov as Nit, Num_fact as Factura, Fech_comp, 
				Fech_venc, total_fact as Total, Subtotal, Nom_provee as Proveedor, retencion, ret_provee, ret_ica 
				FROM compras, proveedores where estado=3 and nit_prov=nitProv
				union
				select Id_gasto as Id, Compra, nit_prov as Nit, Num_fact as Factura, Fech_comp, 
				Fech_venc, total_fact as Total, Subtotal_gasto as Subtotal, Nom_provee as Proveedor, retencion_g as retencion, ret_provee, ret_ica
				from gastos, proveedores where estado=3 and nit_prov=nitProv order by Fech_venc;";
			$result=mysqli_query($link,$qry);		
			$a=1;
			while($row=mysqli_fetch_array($result))
			{
				$id_compra=$row['Id'];
				$compra=$row['Compra'];
				$factura=$row['Factura'];
				$Subtotal=$row['Subtotal'];
				$ret_ica=$row['ret_ica'];
				$ret_provee=$row['ret_provee'];
				$fecVen=$row['Fech_venc'];
				$total=$total+$row['Total'];
				$fact=$row['Factura'];
				$retencion=$row['retencion'];
				$ValTot=$row['Total'];
				$ValPag=$ValTot-$retencion;
				$qry1="select sum(pago) as Parcial from egreso where Id_compra=$id_compra and tip_compra=$compra";
				$resultpago=mysqli_query($link,$qry1);
				$rowpag=mysqli_fetch_array($resultpago);
				if($rowpag['Parcial'])
					$parcial=$rowpag['Parcial'];
				else
					$parcial=0;
				if($ValPag==$parcial)
					{
						if($compra==6)
							$qryupt="update gastos set estado='C' where Id_gasto=$id_compra";
						else
							$qryupt="update compras set estadoCompra='C'where Id_compra=$id_compra";
						$resulupdate=mysqli_query($link,$qryupt);
					}
				$saldo=$ValPag-$parcial-$ret_ica;
				$dias=Calc_Dias($fecVen,$fecha_actual);
				if ($dias<0)
				{
					$formato="formatoDatos1";
					$totalvenc=$totalvenc+$saldo;
				}	
				if ($dias>=0 && $dias<=8)
				{
					$formato="formatoDatos2";
					$totalavenc=$totalavenc+$saldo;
				}	
				if ($dias>8)
				{
					$formato="formatoDatos";
					$totalnvenc=$totalnvenc+$saldo;
				}		
				echo'<tr class="'.$formato.'"><td align="center" valign="middle" >';
				if (md5(1)==$_SESSION['Perfil'])
				{
				  echo '<form action="egreso.php" method="post" name="apppago'.$a.'">
					    <div align="center">
						  <input class="formatoBoton" type="submit" name="Submit" value="Pagar" >
						  <input name="Pago" type="hidden" value="0" >
						  <input name="factura" type="hidden" value="'.$factura.'">
						  <input name="fecVen" type="hidden" value="'.$fecVen.'" >
						  <input name="ValTot" type="hidden" value="'.$ValTot.'" >
						  <input name="id_compra" type="hidden" value="'.$id_compra.'" >
						  <input name="compra" type="hidden" value="'.$compra.'" >
					    </div>
				       </form>';
				}
				echo '</td>
				<td ';
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="center">'.$row['Id'].'</div></td>
	        	<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="center">'.$row['Factura'].'</div></td>
	        	<td'; 
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="center">'.htmlentities ($row['Proveedor'], ENT_QUOTES, "ISO-8859-1").'</div></td>
				<td';
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="center">'.$row['Fech_comp'].'</div></td>
    	    	<td';
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="center">'.$row['Fech_venc'].'</div></td>
				<td ';
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.$row['Total'].'))</script></div></td>';
				echo '<td';
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.$row['retencion'].'))</script></div></td>';
				echo '<td';
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.$row['ret_ica'].'))</script></div></td>';
				echo '<td';
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.($row['Total']-$row['retencion']-$ret_ica).'))</script></div></td>';
				echo '<td';
				if (($a % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.$parcial.'))</script></div></td>';
				echo '<td';
				if (($a++ % 2)==0) echo ' bgcolor="#DFE2FD" ';
				echo '><div align="right">$ <script  > document.write(commaSplit('.$saldo.'))</script></div></td>';
      		 	echo'</tr>';
			}
				echo'<tr>
				<td colspan="2" ></Td>
				<td colspan="7" class="titulo1" align="right">TOTAL VENCIDO :</Td>
				<td colspan="2" class="titulo1"><div align="left">$ <script  > document.write(commaSplit('.$totalvenc.'))</script></div> </td>
				</tr>';
				echo'<tr>
				<td colspan="2" ></Td>
				<td colspan="7" class="titulo2" align="right">TOTAL A VENCER EN UNA SEMANA:</Td>
				<td colspan="2" class="titulo2"><div align="left">$ <script  > document.write(commaSplit('.$totalavenc.'))</script></div> </td>
				</tr>';
				echo'<tr>
				<td colspan="2" ></Td>
				<td colspan="7" class="titulo3" align="right">TOTAL SIN VENCER EN UNA SEMANA  :</Td>
				<td colspan="2" class="titulo3"><div align="left">$ <script  > document.write(commaSplit('.$totalnvenc.'))</script></div> </td>
				</tr>';
				echo'<tr>
				<td colspan="2" align="right" ></Td>
				<td colspan="7" class="titulo" align="right">TOTAL :</Td>
				<td colspan="2" class="titulo"><div align="left">$ <script  > document.write(commaSplit('.($totalvenc+$totalavenc+$totalnvenc).'))</script></div> </td>
				</tr>';
				mysqli_free_result($result);
				mysqli_close($link);
	 	}
		else 
		{
			echo "La conexion a la base de datos no se pudo realizar";
		}
	  ?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>
