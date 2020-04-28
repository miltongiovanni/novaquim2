<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Ingreso del Detalle de los Gastos de Industrias Novaquim</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>INGRESO DE DETALLE DE LOS GASTOS</strong></div>
<?php
include "includes/conect.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

if($CrearFactura==2)
{
$link=conectarServidor();
$qryup="update gastos set nit_prov='$nit_prov', Num_fact=$num_fac, Fech_comp='$FchFactura', Fech_venc='$VenFactura' where Id_gasto=$Factura;";
$resultup=mysqli_query($link,$qryup);
mysqli_close($link);
}
if($CrearFactura!=0)
{
  $link=conectarServidor();
  $qrys="select estado from gastos where Id_gasto=$Factura";
  $results=mysqli_query($link,$qrys);
  $rows=mysqli_fetch_array($results);
  $estadoc=$rows['estado'];
  mysqli_close($link);
}
if($CrearFactura==0)
{ 
	//VALIDA QUE LA FACTURA NO HAYA SIDO INGRESADA ANTES
	$link=conectarServidor();   
	$qrybus="Select * from gastos WHERE nit_prov='$nit_prov' AND Num_fact=$num_fac;";
	$resultqrybus=mysqli_query($link,$qrybus);
	if ($row_bus=mysqli_fetch_array($resultqrybus))
	{
		$Factura=$row_bus['Id_gasto'];
		mysqli_close($link);
		echo '<form method="post" action="detGasto.php" name="form3">';
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
		if(($dias_v>=-60)&&($dias_f>=0))
		{		  
		   $est=2;  
		   /*validacion del valor a pagar"*/
		   $qryFact="insert into gastos (nit_prov, Num_fact, Fech_comp, Fech_venc, estado, compra)
		   values  ('$nit_prov', $num_fac, '$FchFactura','$VenFactura', $est, 6)";
		   if($resultfact=mysqli_query($link,$qryFact))
		   {
				$qry="select max(Id_gasto) as Fact from gastos";
				$result=mysqli_query($link,$qry);
				$row=mysqli_fetch_array($result);
				$Factura=$row['Fact'];		
				echo '<form method="post" action="detGasto.php" name="form3">';
				echo'<input name="CrearFactura" type="hidden" value="5">'; 
				echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
				echo '</form>';
				echo'<script >
					document.form3.submit();
					</script>';	
			}
			else
			{
				mover_pag("gasto.php","Error al Ingresar el Gasto");
			}
			mysqli_close($link);
		}
		else
		{
			if($dias_v<-8)
			{
				echo $dias;
				echo'<script  >
				alert("La fecha de factura de la compra no puede ser menor de 8 días de la fecha actual");
				self.location="gasto.php";
				</script>';	
			}
			if($dias_f<0)
			{
				echo'<script  >
				alert("La fecha de vencimiento de la compra no puede ser menor que la de la fecha de compra");
				self.location="gasto.php";
				</script>';	
			}
			
		}
	}
}
function mover_pag($ruta,$nota)
{	
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo' <script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
if($CrearFactura==1)
{
 	//echo "NO ESTA CREANDO FACTURA";
	$link=conectarServidor();   
	$qrybus="select * from det_gastos where Id_gasto=$Factura AND Producto='$producto';";
	$resultqrybus=mysqli_query($link,$qrybus);
	$row_bus=mysqli_fetch_array($resultqrybus);
	if ($row_bus['Producto']==$producto)
	{
		echo' <script >
			alert("Producto incluido anteriormente");
			document.formulario.submit();
		</script>'; 
	}
	else
	{ 
		//SE ACTUALIZA EL DATALLE DE LA FACTURA
		$qryFact="insert into det_gastos (Id_gasto, Producto, Cant_gasto, Precio_gasto, Id_Tasa) values  ($Factura, '$producto', $cantidad, $precio, $tasa_iva)";
		$resultfact=mysqli_query($link,$qryFact);
	}		
	mysqli_close($link);
	echo '<form method="post" action="detGasto.php" name="form3">';
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
	$qry="select sum(Cant_gasto*Precio_gasto) as Total, sum(Cant_gasto*Precio_gasto*tasa) as IVA, tasaRetIca from det_gastos, tasa_iva, gastos, proveedores, tasa_reteica
			where det_gastos.Id_gasto=$Factura AND tasa_iva.Id_tasa=det_gastos.Id_Tasa and gastos.Id_gasto=det_gastos.Id_gasto and nit_prov=nitProv 
and numtasa_rica=idTasaRetIca;";
						
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$SUBTotalFactura=$row['Total'];
	$tasa_reteica=$row['tasa_retica'];
	$qryc="select ret_provee from gastos, proveedores where nit_prov=nitProv and Id_gasto=$Factura";
	$resultc=mysqli_query($link,$qryc);
	$rowc=mysqli_fetch_array($resultc);
	$autore=$rowc['ret_provee'];
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
	$qryUpFactura="update gastos set total_fact=$TotalFactura, Subtotal_gasto=$SUBTotalFactura, IVA_gasto=$Iva_Factura, retencion_g=$retencion, ret_ica=$reteica where Id_gasto=$Factura";
	if ($estadoc!=7)

	$result=mysqli_query($link,$qryUpFactura);	
	mysqli_close($link);
} 
if($CrearFactura==6)
{	
	if ($estado==2)
	{
	  $link=conectarServidor();
	  $qryUpEstFactura="update gastos set estado=3 where Id_gasto=$Factura";
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
	$qry="select Id_gasto, nit_prov, Num_fact, Fech_comp, Fech_venc, estado, total_fact, compra, retencion_g, Subtotal_gasto, IVA_gasto, ret_ica, Nom_provee, descEstado from gastos, proveedores, estados
	where Id_gasto=$Fact and gastos.nit_prov=proveedores.nitProv and estado=idEstado";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$estado=$row['estado'];
	$des_estado=$row['Des_estado'];
	mysqli_close($link);
 ?>
     
     
<form method="post" action="detGasto.php" name="form1">
  <table  align="center" border="0" width="55%">
    <tr>
      <td ><div align="right"><strong>No. de Gasto:</strong> </div></td>
      <td  colspan="1"><div align="left"><?php echo $Factura;?></div></td><td ><div align="right"><strong>No. de Factura</strong>:</div></td>
      <td colspan="1"><div align="left"><?php echo  $row['Num_fact']?></div></td>
      <td ><div align="right"><strong>Estado</strong> </div></td><td colspan="1" ><?php echo  $row['Des_estado']; ?></td>
    </tr>

    <tr>
      <td><div align="right"><strong>Proveedor:</strong></div></td>
      <td colspan="3"><div align="left"><?php echo  $row['Nom_provee']?></div></td>
      <td ><div align="right"><strong>Valor Factura</strong>:</div></td>
      <td colspan="2"><div align="left"><?php echo '$ <script > document.write(commaSplit('.$row['total_fact'].'))</script>' ;?> </div></td>
      
    </tr>
    <tr>
    <td><div align="right"><strong>NIT:</strong></div></td>
      <td colspan="3"><div align="left"><?php echo  $row['nit_prov']?></div></td>
      <td ><div align="right"><strong>Retenci&oacute;n Ica</strong>:</div></td>
      <td colspan="2"><div align="left"><?php echo '$ <script > document.write(commaSplit('.$row['ret_ica'].'))</script>' ;?> </div></td>
      
    </tr>
    <tr>
    <td ><div align="right"><strong>Fecha de Factura:</strong></div></td>
      <td colspan="3" ><div align="left"><?php echo $row['Fech_comp'];?></div></td>
      <td ><div align="right"><strong>Retenci&oacute;n</strong>:</div></td>
      <td colspan="2"><div align="left"><?php echo '$ <script > document.write(commaSplit('.$row['retencion_g'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td ><div align="right"><strong>Fecha Vencimiento: </strong></div></td>
      <td colspan="3" ><div align="left"><?php echo $row['Fech_venc'];?></div></td>
      <td ><div align="right"><strong>Valor a Pagar</strong>:</div></td>
      <td colspan="2"><div align="left"><?php echo '$ <script > document.write(commaSplit('.($row['total_fact']-$row['retencion_g']-$row['ret_ica']).'))</script>' ;?> </div></td>
    </tr>
    </table>
    
    <?php
	$estadog=$row['estado'];
	if ($estadog!=7)
	{
	echo '
    <table  align="center" border="0" width="55%">
    <tr>
      <td colspan="2"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
      <td><div align="center"><strong>Cantidad</strong></div></td>
      <td><div align="center"><strong>Precio Unitario (Sin IVA)</strong></div></td>
      <td><div align="center"><strong>Tasa  IVA</strong></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><input name="producto" type="text" size=50></div></td>
      <td><div align="center"><input name="cantidad" type="text" size=10></div></td>
      <td><div align="center"><input name="precio" type="text" size=10></div></td>
      <td><div align="center"><select name="tasa_iva" id="combo">';
	  $link=conectarServidor();
	  $qry="select * from tasa_iva";	
	  $result=mysqli_query($link,$qry);
	  echo '<option selected value="3">0.19</option>';
	  while($row=mysqli_fetch_array($result))
	  {
		  if ($row['Id_tasa']!=3)
			echo '<option value="'.$row['Id_tasa'].'">'.$row['tasa'].'</option>';  
			//echo= $row['Id_cat_prod'];
	  }
	  mysqli_close($link);
      echo '</select ></div></td>
    </tr>
    <tr> <input name="CrearFactura" type="hidden" value="1">';
    echo'<input name="Factura" type="hidden" value="'.$Factura.'"> 
      <td colspan="5" align="right"><input name="submit" onClick="return Enviar(this.form)" type="submit"  value="Continuar"></td>
    </tr>
  </table>';
	}
  ?>
</form>
	<table border="0" align="center">
		<tr>
      		<td  colspan="5" class="titulo">Detalle del Gasto: </td>
    	</tr>
        <tr>
        	<th width="71"></th>
      		<th width="314" align="center">Descripci&oacute;n</th>
      		<th width="81" align="center">Iva</th>
            <th width="104" align="center">Cantidad </th>
            <th width="100" align="center">Precio</th>
      		<th width="70"></th>
    	</tr>
          <?php
			$link=conectarServidor();
			$Fact=$Factura;
			$qry="select Producto, Cant_gasto as Cantidad, Precio_gasto as Precio, tasa as Iva from det_gastos, tasa_iva 
			WHERE det_gastos.Id_Tasa=tasa_iva.Id_tasa and Id_gasto=$Factura;";
			$result=mysqli_query($link,$qry);
			while($row=mysqli_fetch_array($result))
			{
			$producto=$row['Producto'];
			$cantidad=$row['Cantidad'];
			$precio=$row['Precio'];
			$iva=$row['Iva'];
			echo'<tr><td>';
			if ($estadog!=7)
				{
			echo '<form action="updateGasto.php" method="post" name="actualiza">
					<input name="factura" type="hidden" value="'.$Factura.'"/>
					<input name="producto" type="hidden" value="'.$producto.'"/>
					<input name="cantidad" type="hidden" value="'.$cantidad.'"/>
					<input type="submit" name="Submit" value="Cambiar" />
				</form>';
				}
			echo '</td>
			  <td><div align="center">'.$producto.'</div></td>
			  <td><div align="center">'.$iva*(100).' %</div></td>
			  <td><div align="center">'.$cantidad.'</div></td>
			  <td><div align="center">$ <script > document.write(commaSplit('.$precio.'))</script></div></td><td>';
			  if ($estadog!=7)
				{
			  echo '<form action="delGasto.php" method="post" name="elimina">
					<input name="factura" type="hidden" value="'.$Factura.'"/>
					<input name="producto" type="hidden" value="'.$producto.'"/>
					<input name="cantidad" type="hidden" value="'.$cantidad.'"/>
					<input type="submit" name="Submit" value="Eliminar" />
				</form>';
				}
			echo '</td></tr>';
			}
			mysqli_close($link);
			?>
  </table>
<table width="27%" border="0" align="center">
<tr><td>&nbsp;</td></tr>
    <tr> 
        <td><div align="center"><form method="post" action="detGasto.php" name="form5">
<input name="CrearFactura" type="hidden" value="6"> 
<input name="Factura" type="hidden" value="<?php echo $Factura; ?>"> 
<input name="estado" type="hidden" value="<?php echo $estado; ?>">
<input type="submit" class="resaltado"  value="Terminar"></form></div></td>
    </tr>
</table>
</div> 
</body>
</html>
