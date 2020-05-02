<?php
include "includes/valAcc.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es">
<head>
<title>Cobro de Facturas de Venta</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>RECIBO DE CAJA POR COBRO DE FACTURAS DE VENTA</strong></div> 
<?php
include "includes/conect.php";
$Reten_pago=0;
$Retica=0;
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();  
if($Pago==3)
{
	$qryrc="select Fact, cobro, Fecha, descuento_f, form_pago, forma_pago, reten, reten_cree, No_cheque, Cod_banco, Banco from r_caja, form_pago, bancos where form_pago=Id_fpago and Cod_banco=Id_banco and Id_caja=$recibo_c";
	//echo $qryrc;
	$resultqryrc=mysqli_query($link, $qryrc);
	$row_rc=mysqli_fetch_array($resultqryrc);
	$factura=$row_rc['Fact'];
	/*$cobro_r=$row_rc['cobro'];
	$Fecha_r=$row_rc['Fecha'];
	$descuento_f_r=$row_rc['descuento_f'];
	$form_pago_r=$row_rc['form_pago'];
	$forma_pago_r=$row_rc['forma_pago'];
	$reten_r=$row_rc['reten'];
	$reten_cree_r=$row_rc['reten_cree'];   
	$No_cheque_r=$row_rc['No_cheque'];
	$Cod_banco_r=$row_rc['Cod_banco'];
	$Banco_r=$row_rc['Banco'];
	$reten_cree_r=$row_rc['reten_cree'];*/
	$Recibo=$recibo_c;
}
/*
$qrypag="select cobro, reten, r_caja.reten_cree, Reten_fte, Subtotal from r_caja, factura where Fact=$factura and Fact=Factura";
$resultpag=mysqli_query($link, $qrypag);
$rowpag=mysqli_fetch_array($resultpag);

if($rowpag)
{
	$retencion=$rowpag['reten'];
	$reten_cree=$rowpag['reten_cree'];
	$rfte=$rowpag['Reten_fte'];
	$subtot1=$rowpag['Subtotal'];
	$Reten=1;
	$Reten_pago=1;
	if ($Reten=1)
		$t_reten=$rfte/$subtot1;

}
if($Pago==0)
{
	$qrycam="select MAX(Id_caja) AS Recibo from r_caja;";
	$resultqrycam=mysqli_query($link, $qrycam);
	$row_cam=mysqli_fetch_array($resultqrycam);
	$Recibo=$row_cam['Recibo']+1;   
}*/
if($Pago==1)
{
	$qryFact="select Factura, Fech_fact, Fech_venc, Total, Reten_iva, Reten_ica, Reten_fte, Reten_cree, Subtotal, IVA, Total_R from factura WHERE Factura=$factura;";
	$Reten_pago=2;
	$resultfact=mysqli_query($link, $qryFact);
	$rowfact=mysqli_fetch_array($resultfact);
	$Reten_iva=$rowfact['Reten_iva'];
	$Reten_ica=$rowfact['Reten_ica'];
	$Reten_fte=$rowfact['Reten_fte'];
	$Reten_cree=$rowfact['Reten_cree'];
	/*validacion del valor a pagar"*/
	$qrytot="select sum(cobro) as Parcial from r_caja where Fact=$factura and Id_caja<>$Recibo";
	$resultot=mysqli_query($link, $qrytot);
	$rowtot=mysqli_fetch_array($resultot);
	$parcial=$rowtot['Parcial'];
	$total=$rowfact['Total_R']-$Reten_fte-$Reten_iva-$Reten_ica-$Reten_cree;
	$ValTopagar=$parcial + $abono;
	if($ValTopagar>$total)
   	{
		mover_pag("factXcobrar.php","El pago".$ValTopagar."sobrepasa el valor ".$total." de la facura");
   	}
	else
	{
		$qry="update r_caja set cobro=$abono, Fecha='$fecha', descuento_f=$descuento, form_pago=$Form_pago, reten=$retencion, reten_ica=$Retica, No_cheque=$No_cheque, Cod_banco=$Cod_banco where Id_caja=$Recibo";
		//echo "<br><br><br><br><br><br><br>".$qry."<br>";
		$result=mysqli_query($link, $qry);
   		if($result)
		{	
			if($total==($parcial+$abono))
			{				
				$qryupt="update factura set Estado='C', Fech_Canc='$fecha', Reten_iva=$Reten_iva, Reten_ica=$Reten_ica, Reten_fte=$Reten_fte where Factura=$factura";
				$resulupdate=mysqli_query($link, $qryupt);
				//echo $qryupt."result ".$resulupdate;
				
				
				
				//aqui toca poner el a
				if($resulupdate)
				{
					echo' <script >
					alert("Pago Aplicado Correctamente");
					</script>';
					echo '<form id="form7" name="form7" method="post" action="recibo_caja1.php">	
                   <input type="text" name="recibo_c" value="'.$Recibo.'" >
                   <input name="Retica" type="hidden" value="'.$Retica.'"><input name="Ret_fte" type="hidden" value="'.$Ret_fte.'">
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
				$qryupt="update factura set Reten_iva=$Reten_iva, Reten_ica=$Reten_ica, Reten_fte=$Reten_fte where Factura=$factura";
				$resulupdate=mysqli_query($link, $qryupt);
				//echo $qryupt;
				echo' <script >
					alert("Pago Aplicado Correctamente 2");
					</script>';
					echo '<form id="form7" name="form7" method="post" action="recibo_caja1.php">	
                   <input type="text" name="recibo_c" value="'.$Recibo.'" >
                   <input name="Retica" type="hidden" value="'.$Retica.'"><input name="Ret_fte" type="hidden" value="'.$Ret_fte.'">
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
  function mover_pag($ruta,$nota)
	{	
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo' <script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
	}
?>
<form method="post" action="recibo_caja2.php" name="form1">
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
	 	$qry="select Factura, Nit_cliente, Nom_clien, Contacto, Cargo, Tel_clien, Fech_fact, Fech_venc, Total, Reten_iva, Reten_ica, Reten_fte, Reten_cree, Subtotal, IVA, Total_R 
			from factura, clientes WHERE Nit_cliente=Nit_clien and Factura=$factura;";
		$result=mysqli_query($link, $qry);
		$row=mysqli_fetch_array($result);
		$nit=$row['Nit_cliente'];
		$qry3="select sum(cobro) as Parcial from r_caja where Fact=$factura";
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
      <td><div align="left"><?php echo '$ <script > document.write(commaSplit('.$row['Total_R'].'))</script>' ;?></div></td>
    </tr>
        <?php
	if ($Reten==0)//Reten es para preguntar si va a hacer retención, es 0 para preguntar y 1 si responde
	echo '<tr><td>&nbsp;</td></tr>
	<tr>
      <td class="titulo" colspan="3" align="right">Cliente Aplic&oacute; Retenci&oacute;n</td>
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
		
		$qryf="select Factura, Nit_cliente, Descuento, Nom_clien, Ret_iva, Ret_ica, Ret_fte, Ret_cree, Subtotal, IVA from factura, clientes where Factura=$factura and Nit_cliente=Nit_clien ;";
		$resultf=mysqli_query($link, $qryf);
		$rowf=mysqli_fetch_array($resultf);
		$Descuento=$rowf['Descuento'];
		$Ret_iva=$rowf['Ret_iva'];
		$Ret_ica=$rowf['Ret_ica'];
		$Ret_fte=$rowf['Ret_fte'];
		$Ret_cree=$rowf['Ret_cree'];
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
		$qryupf="update factura set Reten_iva=$reteiva , Reten_ica=$reteica , Reten_fte=$retefuente where Factura=$factura;";
		$resultupf=mysqli_query($link, $qryupf);
		
	echo '<tr>
      <td><div align="right"><strong>Retenci&oacute;n en la fuente:</strong></div></td>
      <td><div align="left">$ <script > document.write(commaSplit('.$retefuente.'))</script> </div></td>
      <td colspan="2" ><div align="right"><strong>ReteIca:</strong></div></td>
      <td colspan="2">$ <script > document.write(commaSplit('.$reteica.'))</script> </td>
      <td><div align="right"><strong>ReteIva:</strong></div></td>
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
      <td class="titulo" colspan="3" align="right">Tasa de Retenci&oacute;n en la fuente</td>
      <td colspan="2"><div align="center"><select name="t_reten"><option selected value=0.025>2.5%</option><option value=0.015>1.5%</option><option value=0.035>3.5%</option><option value=0.04>4%</option><option value=0>0%</option></select></div></td>
      <td></td>
    </tr>

	<tr>
      <td class="titulo" colspan="3" align="right">Aplic&oacute; Retenci&oacute;n de ICA</td>
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
	$qryrc="select Fact, cobro, Fecha, descuento_f, form_pago, forma_pago, reten, reten_cree, No_cheque, Cod_banco, Banco from r_caja, form_pago, bancos where form_pago=Id_fpago and Cod_banco=Id_banco and Id_caja=$Recibo";
	$resultqryrc=mysqli_query($link, $qryrc);
	$row_rc=mysqli_fetch_array($resultqryrc);
	$factura=$row_rc['Fact'];
	$cobro_r=$row_rc['cobro'];
	$Fecha_r=$row_rc['Fecha'];
	$descuento_f_r=$row_rc['descuento_f'];
	$form_pago_r=$row_rc['form_pago'];
	$forma_pago_r=$row_rc['forma_pago'];
	$reten_r=$row_rc['reten'];
	$reten_cree_r=$row_rc['reten_cree'];   
	$No_cheque_r=$row_rc['No_cheque'];
	$Cod_banco_r=$row_rc['Cod_banco'];
	$Banco_r=$row_rc['Banco'];
	$reten_cree_r=$row_rc['reten_cree'];		
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
      <td align="center" colspan="1"><input type="text" name="fecha" id="sel1" readonly size=12 value="'.$Fecha_r.'"><input type="reset" value=" ... " onclick="return showCalendar';
	  echo "('sel1', '%Y-%m-%d', '12', true)";
	  echo '" ></td>
      <td colspan="2"><div align="center"><select name="Form_pago">';
	  
	  $resultf=mysqli_query($link, "select Id_fpago, forma_pago from form_pago where Id_fpago<>2;");
			echo '<option selected value='.$form_pago_r.'>'.$forma_pago_r.'</option>';
			while($rowf=mysqli_fetch_array($resultf))
			{	
				if($rowf['Id_fpago']!=$form_pago_r)
				echo '<option value='.$rowf['Id_fpago'].'>'.$rowf['forma_pago'].'</option>';
			}
			echo'</select>';
	  
	  echo '</div></td>
	  
	  
	  <td colspan="2"><div align="center"><select name="Cod_banco">
	  
	   
	  <option selected value='.$Cod_banco_r.'>'.$Banco_r.'</option>';
	  
	  $link=conectarServidor();
          $resultb=mysqli_query($link, "select * from bancos");
          while($rowb=mysqli_fetch_array($resultb))
		  {
			  if($rowb['Id_banco']!=$Cod_banco_r)
              echo '<option value='.$rowb['Id_banco'].'>'.$rowb['Banco'].'</option>';
          }
          echo'</select>';
	  echo '</div></td>
	  <td><div align="center"><input name="No_cheque" type="text" size=10 value ="'.$No_cheque_r.'" onKeyPress="return aceptaNum(event)"></div></td>
      <td colspan="1"><div align="center"><input name="abono" type="text" size=10 value="'.($row['Total_R']-$retefuente-$reteiva-$reteica).'" onkeypress="return aceptaNum(event)"></div></td>
      <td><div align="center"><input name="descuento" type="text" size=10 value ="'.$descuento_f_r.'" onKeyPress="return aceptaNum(event)"></div></td>
    </tr>
    <tr><td colspan="8"><div align="right">
      <input name="submit"  onClick="return Enviar(this.form)" type="submit"  value="Actualizar Valor">
    </div><input name="Pago" type="hidden" value="1">
	<input name="Reten_pago" type="hidden" value="1"><input name="Reten" type="hidden" value="1"><input name="Retica" type="hidden" value="'.$Retica.'"><input name="Ret_fte" type="hidden" value="'.$Ret_fte.'">
	<input name="retencion" type="hidden" value="'.$retencion.'"><input name="retefuente" type="hidden" value="'.$retefuente.'"><input name="reteiva" type="hidden" value="'.$reteiva.'"><input name="reteica" type="hidden" value="'.$reteica.'">
    <input name="factura" type="hidden" value="'.$factura.'"> 
	</td></tr>';
	}
	?>
 </table>
</form>

</div>
</body>
</html>