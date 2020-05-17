<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Ingreso de Compra de Envase</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>

</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>INGRESO COMPRA DE ENVASE</strong></div>
<?php
include "includes/conect.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
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
	//VALIDA QUE LA FACTURA NO HAYA SIDO INGRESADA ANTES
	$link=conectarServidor();   
	$qrybus="Select * from compras WHERE nit_prov='$nit_prov' AND numFact=$num_fac;";
	$resultqrybus=mysqli_query($link,$qrybus);
	if ($row_bus=mysqli_fetch_array($resultqrybus))
	{
		$Factura=$row_bus['Id_compra'];
		echo '<form method="post" action="detCompraenv.php" name="form3">';
		echo'<input name="CrearFactura" type="hidden" value="5">'; 
		echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
		echo '</form>';
		echo' <script >
			alert("Factura ingresada anteriormente");
			document.formulario.submit();
			</script>'; 
	}
	else
	{
	  $fecha_actual=date("Y")."-".date("m")."-".date("d"); 
	  $dias_v=Calc_Dias($FchFactura,$fecha_actual);
	  $dias_f=Calc_Dias($VenFactura,$FchFactura);
	  if(($dias_v>=-8)&&($dias_f>=0)&&($dias_v<=0))
	  {		  
		 $est=2;
		 /*validacion del valor a pagar"*/
		 $qryFact="insert into compras (nit_prov, numFact, fechComp, fechVenc, estadoCompra, tipoCompra) values  ('$nit_prov', $num_fac, '$FchFactura','$VenFactura',$est, 2)";
		 if($resultfact=mysqli_query($link,$qryFact))
		 {
			  $qry="select max(idCompra) as Fact from compras";
			  $result=mysqli_query($link,$qry);
			  $row=mysqli_fetch_array($result);
			  $Factura=$row['Fact'];		
			  echo '<form method="post" action="detCompraenv.php" name="form3">';
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
			  mover_pag("compraenv.php","Error al ingresar la factura de compra");
		 }
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
				self.location="compraenv.php";
				</script>';	
			}
			if($dias_f<0)
			{
				echo'<script  >
				alert("La fecha de vencimiento de la compra no puede ser menor que la de la fecha de compra");
				self.location="compraenv.php";
				</script>';	
			}
			
		}
		
	}
	mysqli_free_result($resultqrybus);
	mysql_close($link);
} 


if($CrearFactura==1)
{
	if($Codigo<100)
	{
		//echo "ADICIONANDO PRODUCTOS AL DETALLE";
		$link=conectarServidor();   
		$qrybus="select * from det_compras where idCompra=$Factura and Codigo=$Codigo;";
		$resultqrybus=mysqli_query($link,$qrybus);
		$row_bus=mysqli_fetch_array($resultqrybus);
		if ($row_bus['Codigo']==$Codigo)
		{
			echo' <script >
				alert("Producto incluido anteriormente");
				document.formulario.submit();
				</script>'; 
		}
		else
		{  
			//SE ACTUALIZA LA TABLA DE INVENTARIOS
			$qryinv="select codEnvase, invEnvase from inv_envase where codEnvase=$Codigo";
			$qryprec="select Prec_envase from envase where Cod_envase=$Codigo";
			$resultinv=mysqli_query($link,$qryinv);
			$resultprec=mysqli_query($link,$qryprec);
			$rowprec=mysqli_fetch_array($resultprec);
			$prec=$rowprec['Prec_envase'];
			if($Precio > $prec)
				$prec=$Precio;
			if ($rowinv=mysqli_fetch_array($resultinv))
			{
				$inv=$rowinv['inv_envase'];
				$inv=$inv+$Cantidad;
				$qryup="update inv_envase set invEnvase=$inv where codEnvase=$Codigo";
				$resultup=mysqli_query($link,$qryup);
			}
			else
			{
				$qryins="insert into inv_envase (codEnvase, invEnvase) values ($Codigo, $Cantidad)";
				$resultup=mysqli_query($link,$qryins);
			}
			//ACTUALIZA EL PRECIO DEL ENVASE
			$qryup2="update envase set Prec_envase=$prec where Cod_envase=$Codigo";
			$resultup2=mysqli_query($link,$qryup2);
			$qryFact="insert into det_compras (idCompra, Codigo, Cantidad, Precio)
					   values  ($Factura, $Codigo, $Cantidad, $Precio)";
			$resultfact=mysqli_query($link,$qryFact);
		}	
		echo '<form method="post" action="detCompraenv.php" name="form3">';
		echo'<input name="CrearFactura" type="hidden" value="5">'; 
		echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
		echo '</form>';
		echo'<script >
			document.form3.submit();
			</script>';	 
	}
	else
	{
		//AGREGANDO LOS ARTICULOS DE LA FACTURA";
		$link=conectarServidor();   
		$qrybus="select * from det_compras where idCompra=$Factura and Codigo=$Codigo;";
		$resultqrybus=mysqli_query($link,$qrybus);
		$row_bus=mysqli_fetch_array($resultqrybus);
		if ($row_bus['Codigo']==$Codigo)
		{
			echo' <script >
				alert("Producto incluido anteriormente");
				document.formulario.submit();
			</script>'; 
		}
		else
		{  
			//SE ACTUALIZA LA TABLA DE INVENTARIOS
			$qryinv="select * from inv_tapas_val where codTapa=$Codigo";
			$qryprec="select Pre_tapa from tapas_val where Cod_tapa=$Codigo";
			$resultinv=mysqli_query($link,$qryinv);
			$resultprec=mysqli_query($link,$qryprec);
			$rowprec=mysqli_fetch_array($resultprec);
			$prec=$rowprec['Pre_tapa'];
			if($Precio > $prec)
				$prec=$Precio;
			if($rowinv=mysqli_fetch_array($resultinv))
			{
				$inv=$rowinv['inv_tapa'];
				$inv=$inv+$Cantidad;
				$qryup="update inv_tapas_val set invTapa=$inv where codTapa=$Codigo";
				$resultup=mysqli_query($link,$qryup);
			}
			else
			{
				$qryins="insert into inv_tapas_val (codTapa, Pre_tapa, invTapa) values ($Codigo, $Precio, $Cantidad)";
				$resultup=mysqli_query($link,$qryins);
			}
			$qryup2="update tapas_val set Pre_tapa=$prec where Cod_tapa=$Codigo";
			$resultup2=mysqli_query($link,$qryup2);
			$qryFact="insert into det_compras (idCompra, Codigo, Cantidad, Precio) values ($Factura, $Codigo, $Cantidad, $Precio)";
			$resultfact=mysqli_query($link,$qryFact);
		} 
		echo '<form method="post" action="detCompraenv.php" name="form3">';
		echo'<input name="CrearFactura" type="hidden" value="5">'; 
		echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
		echo '</form>';
		echo'<script >
		document.form3.submit();
		</script>';		
	}
	mysqli_free_result($resultinv);
	mysqli_free_result($resultprec);
	mysqli_free_result($resultqrybus);
	mysqli_close($link);
}
if($CrearFactura==5)
{	
	$link=conectarServidor();
	$qry1="select sum(Cantidad*Precio) as Total, sum(Precio*Cantidad*tasa) as IVA, tasaRetIca 
	from det_compras,envase, tasa_iva, compras, proveedores, tasa_reteica
    where det_compras.idCompra=$Factura and Codigo=Cod_envase and envase.Cod_iva=tasa_iva.Id_tasa and compras.idCompra=det_compras.idCompra and nit_prov=nitProv and numtasa_rica=idTasaRetIca";
	$result1=mysqli_query($link,$qry1);
	$row1=mysqli_fetch_array($result1);
	$SUBTotalFactura1=$row1['Total'];
	$tasa_reteica1=$row1['tasa_retica'];
	$Iva_Factura1=$row1['IVA'];
	$TotalFactura1=$SUBTotalFactura1+$Iva_Factura1;
	$qry2="select sum(Cantidad*Precio) as Total, sum(Precio*Cantidad*tasa) as IVA, tasaRetIca 
	from det_compras,tapas_val, tasa_iva, compras, proveedores, tasa_reteica
	where det_compras.idCompra=$Factura and Codigo=Cod_tapa and Cod_iva=Id_tasa and compras.idCompra=det_compras.idCompra and nit_prov=nitProv and numtasa_rica=idTasaRetIca";
	$result2=mysqli_query($link,$qry2);
	$row2=mysqli_fetch_array($result2);
	$SUBTotalFactura2=$row2['Total'];
	$tasa_reteica2=$row2['tasa_retica'];
	$Iva_Factura2=$row2['IVA'];
	$TotalFactura2=$SUBTotalFactura2 + $Iva_Factura2;
	$TotalFactura= $TotalFactura1 + $TotalFactura2;
	$SUBTotalFactura= $SUBTotalFactura1 + $SUBTotalFactura2;
	$tasa_reteica=($tasa_reteica1+$tasa_reteica2)/2;
	$Iva_Factura=$Iva_Factura1+$Iva_Factura2;
	$qryc="select ret_provee from compras, proveedores where nit_prov=nitProv and idCompra=$Factura";
	$resultc=mysqli_query($link,$qryc);
	$rowc=mysqli_fetch_array($resultc);
	$reteica=0;
	$autore=$rowc['ret_provee'];
	if ($autore==1)
	{
		$retencion=0;
		$reten_cree=0;
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
	$qryUpFactura="update compras set totalCompra=$TotalFactura, subtotalCompra=$SUBTotalFactura, ivaCompra=$Iva_Factura, retefuenteCompra=$retencion, reteicaCompra=$reteica where idCompra=$Factura
	";
	if ($estadoc!=7)
	$result=mysqli_query($link,$qryUpFactura);
	mysqli_free_result($result1);
	mysqli_free_result($result2);
	mysqli_free_result($resultc);
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
<form method="post" action="detCompraenv.php" name="form1">
<table  align="center" border="0" summary="encabezado" width="55%">
  <tr>
    <td width="22%" align="right"><div align="right"><strong>No. de Compra</strong> </div></td>
    <td width="15%"><div align="left"><?php echo $Factura;?></div></td>
    <td><div align="right"><strong>No. de Factura</strong></div></td><td><?php echo  $row['Num_fact']?></td>
    <td width="17%" ><div align="right"><strong>Estado</strong> </div></td><td colspan="1" ><?php echo  $row['Des_estado']?></td>
  </tr>
  <tr>
      <td width="22%"><div align="right"><strong>Proveedor</strong></div></td>
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
    </table>
    
    <?php
	if ($estadoc!=7)
	{
	echo '
    <table width="55%"  align="center" border="0" summary="Envase"> 
    <tr>
      <td width="44%" ><div align="center"><strong>Envase</strong></div></td>
      <td width="15%"><div align="center"><strong>Cantidad</strong></div></td>
      <td width="27%"><div align="center"><strong>Precio por Un (Sin IVA)</strong></div></td>
    </tr>
    <tr>
      <td><div align="center">';
	  $link=conectarServidor();
	  $val="select * from envase, det_proveedores where Cod_envase=Codigo AND NIT_provee='$nit' order by Nom_envase;";
	  echo'<select name="Codigo">';
	  $result=mysqli_query($link,$val);
	  while($row=mysqli_fetch_array($result))
	  {
		  echo '<option value='.$row['Cod_envase'].'>'.$row['Nom_envase'].'</option>';
	  }
	  echo '</select>';
	  mysqli_free_result($result);
	  mysqli_close($link);
	  
      echo '</div></td>
      <td><div align="center">
        <input name="Cantidad" type="text" size=10>
      </div></td>
      <td><div align="center">
        <input name="Precio" type="text" size=10>
      </div></td>
      <td width="14%" align="center"><input name="submit" onClick="return Enviar(this.form)" type="submit"  value="Continuar"><input name="CrearFactura" type="hidden" value="1">';
      echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
	  echo '</td>
    </tr>
  	</table>';
	}
    ?>
</form>
    <form method="post" action="detCompraenv.php" name="form2">
    <?php
	if ($estadoc!=7)
	{
	echo '
  	<table width="55%"  align="center" border="0" summary="Tapa">
    <tr>
      <td width="44%"><div align="center"><strong>Tapa o Válvula</strong></div></td>
      <td width="15%" ><div align="center"><strong>Cantidad</strong></div></td>
      <td width="27%" ><div align="center"><strong>Precio por Un (Sin IVA)</strong></div></td>
    </tr>
    <tr>
      <td><div align="center">';
	  $link=conectarServidor();
	  echo'<select name="Codigo">';
	  $result=mysqli_query($link,"select * from tapas_val, det_proveedores  where Cod_tapa=Codigo and NIT_provee='$nit' order by Cod_tapa;");
	  while($row=mysqli_fetch_array($result))
	  {
		  echo '<option value='.$row['Cod_tapa'].'>'.$row['Nom_tapa'].'</option>';
	  }
	  echo'</select>';
	  mysqli_free_result($result);
	  mysqli_close($link);
      echo '</div></td>
      <td><div align="center">
        <input name="Cantidad" type="text" size=10>
      </div></td>
      <td><div align="center">
        <input name="Precio" type="text" size=10>
      </div></td>
      <td width="14%" align="center"><input name="submit" onClick="return Enviar(this.form)" type="submit"  value="Continuar">
          <input name="CrearFactura" type="hidden" value="1">';
      echo'<input name="Factura" type="hidden" value="'.$Factura.'"> </td>
    </tr>
     </table>';
	}
	?>
     </form>
    <table width="713" border="0" align="center" summary="detalle">
    <tr>
      <td  colspan="6" class="titulo">Detalle de Factura : </td>
    </tr>
          <tr align="center">
          	<th width="44"></th>
            <th width="72">Código</th>
            <th width="312">Envase o Tapa</th>
            <th width="104">Cantidad </th>
            <th width="129">Precio por Un</th>
           	<th width="26"></th>
          </tr>
          <?php
			$link=conectarServidor();
			$Fact=$Factura;
				 $qry="SELECT Codigo, Nom_envase, Cantidad, Precio 
				FROM det_compras, envase 
				where idCompra=$Factura and det_compras.Codigo=envase.Cod_envase;";
				$result=mysqli_query($link,$qry);
			$c=0;
			while($row=mysqli_fetch_array($result))
			{
				$codigo=$row['Codigo'];
				$cantidad=$row['Cantidad'];
				echo'<tr><td>';
				if ($estadoc!=7)
				{
				echo '<form action="updateCompraEnv.php" method="post" name="actualiza'.$c.'">
					<input name="Factura" type="hidden" value="'.$Factura.'">
					<input name="codigo" type="hidden" value="'.$codigo.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					<input type="submit" name="Submit" value="Cambiar" >
				</form>';
				}
				echo '</td>
				<td><div align="center">'.$row['Codigo'].'</div></td>
				<td><div align="center">'.$row['Nom_envase'].'</div></td>
				<td><div align="center"><script  > document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>
				<td><div align="center">$ <script  > document.write(commaSplit('.$row['Precio'].'))</script></div></td>
				 <td>';
				 if ($estadoc!=7)
				{
				 echo '<form action="delEnvComp.php" method="post" name="elimina'.$c++.'">
					<input name="Factura" type="hidden" value="'.$Factura.'">
					<input name="codigo" type="hidden" value="'.$codigo.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					<input type="submit" name="Submit" value="Eliminar" >
				</form>';
				}
				echo '</td>
				</tr>';
			}
			mysqli_free_result($result);
			mysqli_close($link);
			?>
             <?php
			$link=conectarServidor();
			$qry="SELECT Codigo, Nom_tapa, Cantidad, Precio 
			FROM det_compras, tapas_val 
			where idCompra=$Factura and det_compras.Codigo=tapas_val.Cod_tapa;";
			$result=mysqli_query($link,$qry);
			while($row=mysqli_fetch_array($result))
			{
				$codigo=$row['Codigo'];
				$cantidad=$row['Cantidad'];
				echo'<tr>
				<td>';
				if ($estadoc!=7)
				{
				echo '<form action="updateCompraEnv.php" method="post" name="actualiza'.$c.'">
					<input name="Factura" type="hidden" value="'.$Factura.'">
					<input name="codigo" type="hidden" value="'.$codigo.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					 <input type="submit" name="Submit" value="Cambiar" >
				</form>';
				}
				echo '</td>
				<td><div align="center">'.$row['Codigo'].'</div></td>
				<td><div align="center">'.$row['Nom_tapa'].'</div></td>
				<td><div align="center"><script  > document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>
				<td><div align="center">$ <script  > document.write(commaSplit('.$row['Precio'].'))</script></div></td>
				<td>';
				if ($estadoc!=7)
				{
				echo '<form action="delEnvComp.php" method="post" name="elimina'.$c++.'">
					<input name="Factura" type="hidden" value="'.$Factura.'">
					<input name="codigo" type="hidden" value="'.$codigo.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					 <input type="submit" name="Submit" value="Eliminar" >
				</form>';
				}
				echo '</td>
				</tr>';
			}
			mysqli_free_result($result);
			mysqli_close($link);
			?>
  </table>
<div align="center"><form method="post" action="detCompraenv.php" name="form5">
<input name="CrearFactura" type="hidden" value="6"> 
<input name="Factura" type="hidden" value="<?php echo $Factura; ?>"> 
<input name="estado" type="hidden" value="<?php echo $estado; ?>"> 
<input type="submit" class="resaltado"  value="Terminar"></form></div>
</div>
</body>
</html>
