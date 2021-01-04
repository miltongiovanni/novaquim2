<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Cobro de Facturas de Venta</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>


</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>RECIBO DE CAJA POR COBRO DE FACTURAS DE VENTA</strong></div> 
<?php
include "includes/conect.php";
$Reten_pago=0;
$Retica=0;
//$reten_cree=NULL;
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$link=conectarServidor();  
if($Pago==3)
{
	$qryrc="select idFactura from r_caja where idRecCaja=$recibo_c";
	$resultqryrc=mysqli_query($link, $qryrc);
	$row_rc=mysqli_fetch_array($resultqryrc);
	$factura=$row_rc['Fact'];   
	$Recibo=$recibo_c;
    $qrypag= "select cobro, reten, r_caja.reten_ica, retencionFte, Subtotal, Descuento from r_caja, factura where idFactura=$factura and idFactura=idFactura";
    $resultpag=mysqli_query($link, $qrypag);
    $rowpag=mysqli_fetch_array($resultpag);
    if($rowpag)
    {
    	$retencion=$rowpag['reten'];
    	$Descuento=$rowpag['Descuento'];
    	$Retica=$rowpag['reten_ica'];
    	$rfte=$rowpag['Reten_fte'];
    	$subtot1=$rowpag['Subtotal'];
    	$Reten=1;
    	$Reten_pago=1;
    	if ($Reten=1)
    		$t_reten=round($rfte/((1-$Descuento)*$subtot1),3);
    }
}
if($Pago==0)
{
	$qrycam="select MAX(idRecCaja) AS Recibo from r_caja;";
	$resultqrycam=mysqli_query($link, $qrycam);
	$row_cam=mysqli_fetch_array($resultqrycam);
	$Recibo=$row_cam['Recibo']+1;   
}
if($Pago==1)
{
	$qryFact= "select idFactura, fechaFactura, fechaVenc, Total, totalR, retencionIva, retencionIca, retencionFte, Subtotal, IVA from factura WHERE idFactura=$factura;";
	$Reten_pago=2;
	$resultfact=mysqli_query($link, $qryFact);
	$rowfact=mysqli_fetch_array($resultfact);
	$Reten_iva=$rowfact['Reten_iva'];
	$Reten_ica=$rowfact['Reten_ica'];
	$Reten_fte=$rowfact['Reten_fte'];
	$Total_R=$rowfact['Total_R'];
	/*validacion del valor a pagar"*/
	$qrytot="select sum(cobro) as Parcial from r_caja where idFactura=$factura";
	$resultot=mysqli_query($link, $qrytot);
	$rowtot=mysqli_fetch_array($resultot);
	$parcial=$rowtot['Parcial'];
	$total=$rowfact['Total_R']-$Reten_fte-$Reten_iva-$Reten_ica;
	$ValTopagar=$parcial + $abono;
	//echo "este es el num de recibo ".$Recibo;
	if($ValTopagar>$total)
   	{
		mover_pag("factXcobrar.php","El pago".$ValTopagar."sobrepasa el valor ".$total." de la facura");
   	}
	else
	{
		$qry="insert into r_caja (idRecCaja, idFactura, cobro, fechaRecCaja, descuento_f, form_pago, reten, reten_ica, idCheque, codBanco) values($Recibo, $factura, $abono, '$fecha', $descuento, $Form_pago, $retencion, $Retica, $No_cheque, $Cod_banco)";
		//echo "<br>".$qry."<br>";
		$result=mysqli_query($link, $qry);
   		if($result)
		{	
			if($total==($parcial+$abono))
			{				
				$qryupt= "update factura set Estado='C', fechaCancelacion='$fecha', retencionIva=$Reten_iva, retencionIca=$Reten_ica, retencionFte=$Reten_fte where idFactura=$factura";
				$resulupdate=mysqli_query($link, $qryupt);
				//echo $qryupt."result ".$resulupdate;
				
				
				
				//aqui toca poner el a
				if($resulupdate)
				{
					echo' <script >
					alert("Pago Aplicado Correctamente");
					</script>';
					echo '<form id="form7" name="form7" method="post" action="recibo_caja1.php">	
                   <input type="text" name="recibo_c" value="'.$Recibo.'" ><input name="Retica" type="hidden" value="'.$Retica.'">
				   <input type="hidden" name="Pago" value="3">
                   <td align="left"><input type="button" value="      Continuar      " >
				   </form> ';
					echo'<script >
							document.form7.submit();
							</script>';
				}
				mover_pag("factXcobrar.php","Pago Aplicado Correctamente");
			}
			else
			{
				$qryupt= "update factura set retencionIva=$Reten_iva, retencionIca=$Reten_ica, retencionFte=$Reten_fte where idFactura=$factura";
				$resulupdate=mysqli_query($link, $qryupt);
				//echo $qryupt;
				echo' <script >
					alert("Pago Aplicado Correctamente");
					</script>';
					echo '<form id="form7" name="form7" method="post" action="recibo_caja1.php">	
                   <input type="text" name="recibo_c" value="'.$Recibo.'" ><input name="Retica" type="hidden" value="'.$Retica.'">
				   <input type="hidden" name="Pago" value="3">
                   <td align="left"><input type="button" value="      Continuar      " >
				   </form> ';
					echo'<script >
							document.form7.submit();
							</script>';
			}
			
		}
		else 
		{
   			mover_pag("factXcobrar.php","Pago No Aplicado");
		}
	}
   mysql_close($link);
}

?>
<form method="post" action="recibo_caja1.php" name="form1">
  <table border="0"  align="center" width="80%" >
    <tr>
      <td width="18%">&nbsp;</td>
      <td width="12%">&nbsp;</td>
      <td width="12%">&nbsp;</td>
      <td width="11%">&nbsp;</td>
      <td width="9%">&nbsp;</td>
      <td width="11%">&nbsp;</td>
      <td width="14%">&nbsp;</td>
      <td width="13%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><div align="left" class="titulo"><strong>Recibo de Caja No. :</strong>
        <input name="Recibo" type="text" readonly="true" value="<?php echo $Recibo; ?>" size="5">
      </div></td>
      <td colspan="3"><div align="right"><strong>No. de Factura:</strong></div></td>
      <td><div align="left"><?php echo $factura; ?></div></td>
    </tr>
    <?php
	  	$link=conectarServidor();
	 	$qry= "select idFactura, Nit_cliente, nomCliente, contactoCliente, cargoCliente, telCliente, fechaFactura, fechaVenc, Total, totalR, retencionIva, retencionIca, retencionFte, Subtotal, IVA 
			from factura, clientes WHERE Nit_cliente=nitCliente and idFactura=$factura;";
		$result=mysqli_query($link, $qry);
		$row=mysqli_fetch_array($result);
		$nit=$row['Nit_cliente'];
		$qry3="select sum(cobro) as Parcial from r_caja where idFactura=$factura";
		$result3=mysqli_query($link, $qry3);
		$row3=mysqli_fetch_array($result3);
		$valTot=$row['Total'];
		if($row3['Parcial'])
			$parcial=$row3['Parcial'];
		else
			$parcial=0;
		$saldo=$valTot-$parcial;
	 ?>
    <tr>
      <td><div align="right"><strong>Cliente:</strong></div></td>
      <td colspan="5"><?php echo  $row['Nom_clien']?></td>
      <td><div align="right"><strong>NIT:</strong></div></td>
      <td><?php echo  $row['Nit_cliente']?></td>
    </tr>
    <tr>
      <td ><div align="right"><strong>Fecha de Factura:</strong></div></td>
      <td><?php echo $row['Fech_fact'];?></td>
      <td colspan="2" ><div align="right"><strong>Fecha Vencimiento: </strong></div></td>
      <td colspan="2"><?php echo $row['Fech_venc'];?></td>
      <td><div align="right"><strong>Valor Factura:</strong></div></td>
      <td><div align="left"><?php echo '$ <script > document.write(commaSplit('.$row['Total'].'))</script>' ;?></div></td>
    </tr>
        <?php
	if ($Reten==0)//Reten es para preguntar si va a hacer retención, es 0 para preguntar y 1 si responde
	echo '<tr><td>&nbsp;</td></tr>
	<tr>
      <td class="titulo" colspan="3" align="right">Cliente Aplicó Retención</td>
      <td colspan="2"><div align="center"><select name="retencion"><option selected value=0>No</option><option value=1>Si</option></select></div></td>
      <td><input onClick="return Enviar(this.form)" type="button"  value="Continuar"></td>
    </tr>
    <tr><td>&nbsp;</td><td><input name="Pago" type="hidden" value="4">
    <input name="factura" type="hidden" value="'.$factura.'"><input name="Recibo" type="hidden" value="'.$Recibo.'"><input name="Reten" type="hidden" value="1"><input name="Reten_pago" type="hidden" value="0">  
	</td></tr>';
	?>
   
    <?php
	if ($Reten_pago==1)
	{
		$qryf= "select idFactura, Nit_cliente, Descuento, nomCliente, retIva, retIca, retFte, Subtotal, IVA from factura, clientes where idFactura=$factura and Nit_cliente=nitCliente ;";
		$resultf=mysqli_query($link, $qryf);
		$rowf=mysqli_fetch_array($resultf);
		$Descuento=$rowf['Descuento'];
		$Ret_iva=$rowf['Ret_iva'];
		$Ret_ica=$rowf['Ret_ica'];
		$Ret_fte=$rowf['Ret_fte'];
		$subtotal=$rowf['Subtotal'];
		$desc=round($Descuento*$subtotal);
		$iva=$rowf['IVA'];
		if($retencion==1)
		{
			if ($Ret_fte==1)
				$retefuente=round(($subtotal-$desc)*$t_reten);
			else
				$retefuente=0;
			if ($Ret_iva==1)
				$reteiva=round($iva*0.15);
			else
				$reteiva=0;
			if (($Ret_ica==1)&&($Retica==1))
				$reteica=round(($subtotal-$desc)*0.01104);
			else
				$reteica=0;
			
		}
		else
		{
			  $retefuente=0;
			  $reteiva=0;
			  $reteica=0;
		}
		$qryupf= "update factura set retencionIva=$reteiva , retencionIca=$reteica , retencionFte=$retefuente where idFactura=$factura;";
		//echo $qryupf;
		$resultupf=mysqli_query($link, $qryupf);
		
	echo '<tr>
      <td><div align="right"><strong>Retención en la fuente:</strong></div></td>
      <td><div align="left">$ <script > document.write(commaSplit('.$retefuente.'))</script> </div></td>
      <td colspan="2" ><div align="right"><strong>ReteIca:</strong></div></td>
      <td>$ <script > document.write(commaSplit('.$reteica.'))</script> </td>
      <td colspan="2"><div align="right"><strong>ReteIva:</strong></div></td>
      <td><div align="left">$ <script > document.write(commaSplit('.$reteiva.'))</script></div></td>
    </tr>';	
	echo '<tr>
      <td><div align="right"><strong>Valor a Cobrar:</strong></div></td>
      <td><div align="left">$ <script > document.write(commaSplit('.($row['Total_R']-$retefuente-$reteiva-$reteica).'))</script> </div></td>
      <td colspan="2" ><div align="right"><strong>Valor Cancelado:</strong></div></td>
      <td colspan="2">$ <script > document.write(commaSplit('.$parcial.'))</script> </td>
      <td><div align="right"><strong>Valor Pendiente:</strong></div></td>
      <td><div align="left">$ <script > document.write(commaSplit('.($row['Total_R']-$retefuente-$reteiva-$reteica-$parcial).'))</script></div></td>
    </tr>';
	}
	?>
    
    <?php
	if (($Reten==1)&&($Reten_pago==0)&&($retencion==1))//Para preguntar la tasa de retención
	echo '<tr><td>&nbsp;</td></tr>
	<tr>
      <td class="titulo" colspan="3" align="right">Tasa de Retención en la fuente</td>
      <td colspan="2"><div align="center"><select name="t_reten"><option selected value=0.025>2.5%</option><option value=0.015>1.5%</option><option value=0.035>3.5%</option><option value=0.04>4%</option><option value=0>0%</option></select></div></td>
      <td></td>
    </tr>

	<tr>
      <td class="titulo" colspan="3" align="right">Aplicó Retención de ICA</td>
      <td colspan="2"><div align="center"><select name="Retica"><option selected value=0>No</option><option value=1>Si</option></select></div></td>
      <td><input onClick="return Enviar(this.form)" type="button"  value="Continuar"></td>
    </tr>
    <tr><td>&nbsp;</td><td><input name="Pago" type="hidden" value="4">
    <input name="factura" type="hidden" value="'.$factura.'"><input name="retencion" type="hidden" value="'.$retencion.'"><input name="Recibo" type="hidden" value="'.$Recibo.'"><input name="Reten" type="hidden" value="2"><input name="Reten_pago" type="hidden" value="1">  
	</td></tr>';
	if (($Reten==1)&&($Reten_pago==0)&&($retencion==0))//Para preguntar la tasa de retención
	{
	  //echo '<form method="post" action="recibo_caja1.php" name="form3">';
	  echo '<tr><td>&nbsp;</td><td><input name="Pago" type="hidden" value="4">
	  <input name="factura" type="hidden" value="'.$factura.'">
	  <input name="retencion" type="hidden" value="'.$retencion.'">
	  <input name="Recibo" type="hidden" value="'.$Recibo.'">
	  <input name="Reten" type="hidden" value="2">
	  <input name="Reten_pago" type="hidden" value="1">  
	  </td></tr>';
	  //echo '</form>';
	  echo'<script >
			document.form1.submit();
			</script>';
	}
	?>
       
   
    <tr><td></td></tr>
    
    <?php 
	if ($Reten_pago==1)
	{
    echo 
	'<tr>
    	<td colspan="1"><div align="center"><strong>Fecha del Pago</strong></div></td>
        <td colspan="2"><div align="center"><strong>Forma de Pago</strong></div></td>
		<td colspan="2"><div align="center"><strong>Banco</strong></div></td>
		<td colspan="1"><div align="center"><strong>No. Cheque</strong></div></td>
      	<td colspan="1"><div align="center"><strong>Valor a Cancelar</strong></div></td>
        <td><div align="center"><strong>Descuento</strong></div></td>
    </tr>
    <tr>
      <td align="center" colspan="1"><input type="text" name="fecha" id="sel1" readonly size=12><input type="reset" value=" ... " onclick="return showCalendar';
	  echo "('sel1', '%Y-%m-%d', '12', true)";
	  echo '" ></td>
      <td colspan="2"><div align="center"><select name="Form_pago"><option selected value=0>Efectivo</option><option value=1>Transferencia</option><option value=2>Nota Crédito</option><option value=3>Consignación</option><option value=4>Cheque</option><option value=5>Dar de Baja</option></select></div></td>
	  <td colspan="2"><div align="center"><select name="Cod_banco">
	  
	   
	  <option selected value=0>--N.A.---</option>';
	  
	  $link=conectarServidor();
          $resultb=mysqli_query($link, "select * from bancos");
          while($rowb=mysqli_fetch_array($resultb)){
              echo '<option value='.$rowb['Id_banco'].'>'.$rowb['Banco'].'</option>';
          }
          echo'</select>';
	  echo '</div></td>
	  <td><div align="center"><input name="No_cheque" type="text" size=10 value ="0" onKeyPress="return aceptaNum(event)"></div></td>
      <td colspan="1"><div align="center"><input name="abono" type="text" size=10 value="'.($row['Total_R']-$retefuente-$reteiva-$reteica-$parcial).'" onkeypress="return aceptaNum(event)"></div></td>
      <td><div align="center"><input name="descuento" type="text" size=10 value ="0" onKeyPress="return aceptaNum(event)"></div></td>
    </tr>
    <tr><td colspan="8"><div align="right">
      <input name="submit"  onClick="return Enviar(this.form)" type="submit"  value="Cargar Valor">
    </div><input name="Pago" type="hidden" value="1">
	<input name="Reten_pago" type="hidden" value="1"><input name="Reten" type="hidden" value="1"><input name="Retica" type="hidden" value="'.$Retica.'">
	<input name="retencion" type="hidden" value="'.$retencion.'"><input name="retefuente" type="hidden" value="'.$retefuente.'"><input name="reteiva" type="hidden" value="'.$reteiva.'"><input name="reteica" type="hidden" value="'.$reteica.'">
    <input name="factura" type="hidden" value="'.$factura.'"> 
	</td></tr>';
	}
	?>
    <tr>
      <td  colspan="8" class="titulo">Detalle de Pagos : </td>
    </tr>
  </table>
</form>
<div align="center">
<form action="Imp_Recibo_Caja.php" method="post" target="_blank"><input name="Recibo" type="hidden" value="<?php echo $Recibo; ?>"><input name="Submit" type="submit" value="Imprimir"></form></div>
<table border="0" align="center" width="30%">
<tr>
	<td height="8" colspan="8">&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
    <th width="29%" align="center">No. Recibo Caja</th>
    <th width="18%" align="center">Fecha</th>
    <th width="25%" align="center">Pago</th>
    <th width="28%" align="center">Forma de Pago</th>
</tr>
<tr>
	<td height="8" colspan="8"><hr></td>
</tr>
<?php
//$Fact=$Factura;
$qry="select idFactura, cobro, fechaRecCaja, idRecCaja, formaPago from r_caja, form_pago where idFactura=$factura and form_pago=idFormaPago;";
$result=mysqli_query($link, $qry);
$i=1;
while($row=mysqli_fetch_array($result))
{
	$factura=$row['Fact'];
	$abono=$row['cobro'];
	$fecha=$row['Fecha'];
	$forma_pago=$row['forma_pago'];
	$Id_caja=$row['Id_caja'];
	echo'<tr>
	<td><div align="center">'.$Id_caja.'</div></td>
	<td><div align="center">'.$fecha.'</div></td>
	<td><div align="center">$ <script > document.write(commaSplit('.$abono.'))</script></div></td>
	<td><div align="center">'.$forma_pago.'</div></td>
	</tr>';
	$i++;
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>
    <tr>
      <td colspan="8"><hr></td>
    </tr>
  </table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='factXcobrar.php'" value="Terminar"  ></div>
</div>
</body>
</html>