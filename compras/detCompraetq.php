<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Ingreso de Compra de Etiqueta</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>

</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>DETALLE DE  COMPRA DE ETIQUETAS</strong></div> 
<?php
include "includes/conect.php";
include "includes/calcularDias.php";
$link=conectarServidor(); 
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
if($CrearFactura!=0)
{
  $link=conectarServidor();
  $qrys="select estadoCompra from compras where idCompra=$Factura";
  $results=mysqli_query($link,$qrys);
  $rows=mysqli_fetch_array($results);
  $estadoc=$rows['estado'];
  mysqli_free_result($results);
  mysqli_close($link);
}
if($CrearFactura==2)
{
$link=conectarServidor();
$qryup="update compras set nit_prov='$nit_prov', numFact=$num_fac, fechComp='$FchFactura', fechVenc='$VenFactura' where idCompra=$Factura;";
$resultup=mysqli_query($link,$qryup);
mysqli_close($link);
}
if($CrearFactura==0)
{
  $link=conectarServidor();
  $fecha_actual=date("Y")."-".date("m")."-".date("d"); 
  $dias_v=Calc_Dias($FchFactura,$fecha_actual);
  $dias_f=Calc_Dias($VenFactura,$FchFactura);
  if(($dias_v>=-8)&&($dias_f>=0)&&($dias_v<=0))
  {		  
	$est=2;  
	/*validacion del valor a pagar"*/
	$qryFact="insert into compras (nit_prov, numFact, fechComp, fechVenc, estadoCompra, tipoCompra)
	values  ('$nit_prov', $num_fac, '$FchFactura','$VenFactura',$est, 4)";
	echo $qryFact;
	if($resultfact=mysqli_query($link, $qryFact))
	{
		$qry="select max(idCompra) as Fact from compras";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		$Factura=$row['Fact'];		
		echo '<form method="post" action="detCompraetq.php" name="form3">';
		echo'<input name="CrearFactura" type="hidden" value="5">'; 
		echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
		echo '</form>';
		echo'<script >
			document.form3.submit();
			</script>';
		mysqli_free_result($result);
	}
	else
	{	
		mover_pag("compraetq.php","Error al ingresar la factura de compra");
	}
	mysqli_close($link);
  }
  else
		{
			if($dias_v>0)
			{
				echo $dias;
				echo'<script  >
				alert("La fecha de factura de la compra no puede ser de una fecha futura");
				self.location="compradist.php";
				</script>';	
			}
			if($dias_v<-8)
			{
				echo $dias;
				echo'<script  >
				alert("La fecha de factura de la compra no puede ser menor de 8 días de la fecha actual");
				self.location="compraetq.php";
				</script>';	
			}
			if($dias_f<0)
			{
				echo'<script  >
				alert("La fecha de vencimiento de la compra no puede ser menor que la de la fecha de compra");
				self.location="compraetq.php";
				</script>';	
			}
			
		}
}


if($CrearFactura==1)
{
	//echo "ADICIONANDO EL DETALLE DE LA FACTURA";
	$link=conectarServidor();   
	$qrybus="select * from det_compras where idCompra=$Factura and Codigo=$cod_etq;";
	$resultqrybus=mysqli_query($link,$qrybus);
	$row_bus=mysqli_fetch_array($resultqrybus);
	if ($row_bus['Codigo']==$cod_etq)
	{
		echo' <script >
			alert("Producto incluido anteriormente");
		</script>'; 
	}
	else
	{    
		//SE ACTUALIZA LA TABLA DE INVENTARIOS
		$qryinv="select codEtiq, invEtiq from inv_etiquetas where codEtiq=$cod_etq";
		$resultinv=mysqli_query($link,$qryinv);
		$qryprec="select Prec_etiq from etiquetas where Cod_etiq=$cod_etq";
		$resultprec=mysqli_query($link,$qryprec);
		$rowprec=mysqli_fetch_array($resultprec);
		$prec=$rowprec['Prec_etiq'];
		if($precio_etq > $prec)
			$prec=$precio_etq;
		if ($rowinv=mysqli_fetch_array($resultinv))
		{
			$inv=$rowinv['inv_etiq'];
			$inv=$inv+$can_etq;
			$qryup="update inv_etiquetas set invEtiq=$inv where codEtiq=$cod_etq";
			$resultup=mysqli_query($link,$qryup);
		}
		else
		{
			$qryins="insert into inv_etiquetas (codEtiq, invEtiq) values ($cod_etq, $can_etq)";
			$resultup=mysqli_query($link,$qryins);
		}
		//ACTUALIZA EL PRECIO	
		$qryup2="update etiquetas set Prec_etiq=$prec where Cod_etiq=$cod_etq";
		$resultup2=mysqli_query($link,$qryup2);
		$qryFact="insert into det_compras (idCompra, Codigo, Cantidad, Precio)
				   values  ($Factura, $cod_etq, $can_etq, $precio_etq)";
		if($resultfact=mysqli_query($link,$qryFact))
		{	
			$qry="select sum(Cantidad*Precio) as Total, tasaRetIca 
			from det_compras, compras, proveedores, tasa_reteica
			where det_compras.idCompra=$Factura and compras.idCompra=det_compras.idCompra and nit_prov=nitProv 
and numtasa_rica=idTasaRetIca";
			$result=mysqli_query($link,$qry);
			$row=mysqli_fetch_array($result);
			$SUBTotalFactura=$row['Total'];
			$Iva_Factura=$SUBTotalFactura*0.19;
			$TotalFactura=$SUBTotalFactura+$Iva_Factura;
			$qryUpFactura="update compras set totalCompra=$TotalFactura, subtotalCompra=$SUBTotalFactura, ivaCompra=$Iva_Factura, retefuenteCompra=$retencion, reteicaCompra=$reteica where idCompra=$Factura";
			echo $qryUpFactura;
			$resultup=mysqli_query($link,$qryUpFactura);
			mysqli_free_result($result);
		}
		mysqli_free_result($resultinv);
		mysqli_free_result($resultprec);		
	}
	 
	mysqli_close($link);
	

	

	echo '<form method="post" action="detCompraetq.php" name="form3">';
	echo'<input name="CrearFactura" type="hidden" value="5">'; 
	echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
	echo '</form>';
	echo'<script >
		document.form3.submit();
		</script>';	
}
if($CrearFactura==5)
{	
	$link=conectarServidor();
	$qry="select sum(Precio*Cantidad) as Total, sum(Precio*Cantidad*tasa) as IVA, tasaRetIca 
from det_compras, etiquetas, tasa_iva, compras, proveedores, tasa_reteica
where det_compras.idCompra=$Factura AND Codigo=Cod_etiq and compras.idCompra=det_compras.idCompra and nit_prov=nitProv 
and numtasa_rica=idTasaRetIca and tasa_iva.Id_tasa=etiquetas.Cod_iva";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$qryc="select ret_provee from compras, proveedores where nit_prov=nitProv and idCompra=$Factura";
	$resultc=mysqli_query($link,$qryc);
	$rowc=mysqli_fetch_array($resultc);
	$autore=$rowc['ret_provee'];
	$SUBTotalFactura=$row['Total'];
	$tasa_reteica=$row['tasa_retica'];
	if ($autore==1)
	{
		$retencion=0;
		$reteica=0;
	}
	else
	{
	  if ($SUBTotalFactura>=BASE_C)
	  {
		 $retencion=round($SUBTotalFactura*0.025,0);
		 $reteica=round($SUBTotalFactura*$tasa_reteica/1000);
	  }
	  else
	  {
			$retencion=0;
			$reteica=0;
	  }
	}
	$Iva_Factura=$row['IVA'];
	$TotalFactura=$SUBTotalFactura+$Iva_Factura;

	$qryUpFactura="update compras set totalCompra=$TotalFactura, subtotalCompra=$SUBTotalFactura, ivaCompra=$Iva_Factura, retefuenteCompra=$retencion, reteicaCompra=$reteica where idCompra=$Factura";
	if ($estadoc!=7)
		$result1=mysqli_query($link,$qryUpFactura);
	mysqli_close($link);
} 
if($CrearFactura==6)
{	
	if ($estado==2)
	{
	  $link=conectarServidor();
	  $qryUpEstFactura="update compras set estadoCompra=3 where idCompra=$Factura";
	  $result2=mysqli_query($link,$qryUpEstFactura);
	  mysqli_close($link);
	}
	echo'<script  >
	self.location="menu.php";
	</script>';
} 
?>
<?php
  $link=conectarServidor();
  $Fact=$Factura;
   $qry="select compras.*, Nom_provee, descEstado
		from compras, proveedores, estados
		where idCompra=$Factura
		and compras.nit_prov=proveedores.nitProv and estadoCompra=idEstado";
  $result=mysqli_query($link,$qry);
  $row=mysqli_fetch_array($result);
  $nit=$row['nit_prov'];
  $estado=$row['estado'];
  mysqli_close($link);
?>
<form method="post" action="detCompraetq.php" name="form1">
  <table  align="center" border="0" width="72%">
  <tr>
  	  <td width="17%"><div align="right"><strong>No. de Compra</strong> </div></td><td width="23%"><div align="left"><?php echo $Factura;?></div></td>
      <td width="23%"><div align="right"><strong>No. de Factura</strong></div></td><td width="5%"><?php echo  $row['Num_fact']?></td>
      <td width="12%" ><div align="right"><strong>Estado</strong> </div></td><td width="20%" colspan=3 ><?php echo  $row['Des_estado']?></td>
      
    </tr>
    
    <tr>
      <td><div align="right"><strong>Proveedor</strong></div></td>
      <td colspan="3"><?php echo  $row['Nom_provee']?></td>
      <td><div align="right"><strong>Valor Factura</strong></div></td>
      <td><div align="left"><?php echo '$ <script  > document.write(commaSplit('.$row['total_fact'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td><div align="right"><strong>NIT</strong></div></td>
      <td colspan="3"><?php echo  $row['nit_prov']?></td>
      <td><div align="right"><strong>Retención Ica</strong></div></td>
      <td><div align="left"><?php echo '$ <script  > document.write(commaSplit('.$row['ret_ica'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td ><div align="right"><strong>Fecha de Factura</strong></div></td>
      <td colspan="3"><?php echo $row['Fech_comp'];?></td>
       <td><div align="right"><strong>Retención</strong></div></td>
      <td><div align="left"><?php echo '$ <script  > document.write(commaSplit('.$row['retencion'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td ><div align="right"><strong>Fecha Vencimiento </strong></div></td>
      <td colspan="3"><?php echo $row['Fech_venc'];?></td>
       <td><div align="right"><strong>Valor a Pagar</strong></div></td>
      <td><div align="left"><?php echo '$ <script  > document.write(commaSplit('.($row['total_fact']-$row['retencion']-$row['ret_ica']).'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td colspan="6"><hr></td>
    </tr>
    <?php
	if ($estadoc!=7)
	{
	echo '
    <tr>
      <td colspan="3"><div align="center"><strong>Etiqueta</strong></div></td>
      <td width="16%"><div align="center"><strong>Cantidad</strong></div></td>
      <td><div align="center"><strong>Precio por Und</strong></div></td>
    </tr>
    <tr>
      <td colspan="3"><div align="center">';

	  $link=conectarServidor();
	  echo'<select name="cod_etq">';
	  $result=mysqli_query($link,"select * from etiquetas, det_proveedores where Cod_etiq=Codigo and Nit_provee='$nit' order by Nom_etiq");
	  while($row=mysqli_fetch_array($result))
	  {
		  echo '<option value='.$row['Cod_etiq'].'>'.$row['Nom_etiq'].'</option>';
	  }
	  echo'</select>';
	  mysqli_close($link);
      echo '</div></td>
      <td><div align="center">
        <input name="can_etq" type="text" size=10>
      </div></td>
      <td><div align="center">
        <input name="precio_etq" type="text" size=10>
      </div></td>
      <td><div align="center">
        <input name="submit" onClick="return Enviar(this.form)" type="submit"  value="Continuar">
          <input name="CrearFactura" type="hidden" value="1">';
          echo'<input name="Factura" type="hidden" value="'.$Factura.'"> 
      </div></td>
    </tr>'; 
	}
	?>
    
    
    <tr>
      <td colspan="6" align="right"></td>
    </tr>
    <tr>
      <td  colspan="4" class="titulo">Detalle de Factura : </td>
    </tr>
    </table>
    </form>
	<table width="55%" border="0" align="center">
          <tr>
          <th width="9%"></th>
            <th width="10%">Código</th>
            <th width="44%">Etiqueta</th>
            <th width="15%">Cantidad </th>
            <th width="13%">Precio Un</th>
            <th width="9%"></th>
          </tr>
          <?php
			$link=conectarServidor();
			$Fact=$Factura;
			$qry="SELECT Codigo, Nom_etiq, Cantidad, Precio
			FROM det_compras, etiquetas 
			where idCompra=$Factura and det_compras.Codigo=etiquetas.Cod_etiq";
			$result=mysqli_query($link,$qry);
			while($row=mysqli_fetch_array($result))
			{
			$codigo=$row['Codigo'];
			$cantidad=$row['Cantidad'];
			echo'<tr><td>';
			if ($estadoc!=7)
				{
			echo '<form action="updateCompraEtq.php" method="post" name="actualiza">
					<input name="factura" type="hidden" value="'.$Factura.'"/>
					<input name="codigo" type="hidden" value="'.$codigo.'"/>
					<input name="cantidad" type="hidden" value="'.$cantidad.'"/>
					<input type="submit" name="Submit" value="Cambiar" />
				</form>';
				}
			echo '</td><td><div align="center">'.$row['Codigo'].'</div></td>
			<td><div align="center">'.$row['Nom_etiq'].'</div></td>
			<td><div align="center">'.$row['Cantidad'].'</div></td>
			<td><div align="center">$ <script > document.write(commaSplit('.$row['Precio'].'))</script></div></td>';
			if ($estadoc!=7)
				{
			echo '<form action="delEtqComp.php" method="post" name="elimina">
					<input name="factura" type="hidden" value="'.$Factura.'"/>
					<input name="codigo" type="hidden" value="'.$codigo.'"/>
					<input name="cantidad" type="hidden" value="'.$cantidad.'"/>
					<td align="center" valign="middle"> <input type="submit" name="Submit" value="Eliminar" /></td>
				</form>';
				}
			echo '</tr>';
			}
			mysqli_free_result($result);
			mysqli_close($link);
			?>
 </table>
<div align="center">
<form method="post" action="detCompraetq.php" name="form5">
<input name="CrearFactura" type="hidden" value="6"> 
<input name="Factura" type="hidden" value="<?php echo $Factura; ?>"> 
<input name="estado" type="hidden" value="<?php echo $estado; ?>"> 
<input type="submit" class="resaltado"  value="Terminar"></form></div> 
</div>
</body>
</html>
