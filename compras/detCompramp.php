<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Ingreso de Compra de Materia Prima</title>
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
<div id="saludo1"><strong>DETALLE DE  COMPRA DE MATERIA PRIMA</strong></div> 
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
$qrys="select estado from compras where Id_compra=$Factura";
$results=mysqli_query($link,$qrys);
$rows=mysqli_fetch_array($results);
$estadoc=$rows['estado'];
mysqli_free_result($results);
mysqli_close($link);
}

if($CrearFactura==2)
{
$link=conectarServidor();
$qryup="update compras set nit_prov='$nit_prov', Num_fact=$num_fac, Fech_comp='$FchFactura', Fech_venc='$VenFactura' where Id_compra=$Factura;";
$resultup=mysqli_query($link,$qryup);
mysqli_close($link);
}
if($CrearFactura==0)
{
	//VALIDA QUE LA FACTURA NO HAYA SIDO INGRESADA ANTES
	$link=conectarServidor();   
	$qrybus="Select * from compras WHERE nit_prov='$nit_prov' AND Num_fact=$num_fac;";
	$resultqrybus=mysqli_query($link,$qrybus);
	if ($row_bus=mysqli_fetch_array($resultqrybus))
	{
		$Factura=$row_bus['Id_compra'];
		echo '<form method="post" action="detCompramp.php" name="form3">';
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
		//echo $dias_v." dias v <br>";
		$dias_f=Calc_Dias($VenFactura,$FchFactura);
		//echo $dias_f." dias f <br>";
		if(($dias_v>=-8)&&($dias_v<=0)&&($dias_f>=0))
		{		  
		  $est=2;
		  /*validacion del valor a pagar"*/
		  $qryFact="insert into compras (nit_prov, Num_fact, Fech_comp, Fech_venc, estado, compra)
		  values  ('$nit_prov', $num_fac, '$FchFactura','$VenFactura',$est, 1)"; 
		  if($resultfact=mysqli_query($link,$qryFact))
		  {
			  $qry="select max(Id_compra) as Fact from compras";
			  if ($result=mysqli_query($link,$qry))
			  {
				  $row=mysqli_fetch_array($result);
				  $Factura=$row['Fact'];	
				  mysqli_free_result($result);
				  echo '<form method="post" action="detCompramp.php" name="form3">';
				  echo'<input name="CrearFactura" type="hidden" value="5">'; 
				  echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
				  echo '</form>';
				  echo'<script >
					  document.form3.submit();
					  </script>';
			  }
			  else
			  {
				  echo' <script  type="text/javascript">
				  alert("Error al revisar el máximo valor del consecutivo de las compras")
				  </script>';
			  }
		  }
		  else
		  {
			  mover_pag("compramp.php","Error al ingresar la factura de compra");
		  }
		}
		else
		{
			if($dias_v>0)
			{
				echo $dias_v;
				echo'<script  type="text/javascript">
				alert("La fecha de factura de la compra no puede ser de una fecha futura");
				self.location="compramp.php";
				</script>';	
			}
			if($dias_v<-8)
			{
				echo $dias_v;
				echo'<script  type="text/javascript">
				alert("La fecha de factura de la compra no puede ser menor de 8 días de la fecha actual");
				self.location="compramp.php";
				</script>';	
			}
			if($dias_f<0)
			{
				echo'<script  type="text/javascript">
				alert("La fecha de vencimiento de la compra no puede ser menor que la de la fecha de compra");
				self.location="compramp.php";
				</script>';	
			}
			
		}
	}
	
	mysqli_free_result($resultqrybus);
	mysqli_close($link);
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
	//echo "ADICIONANDO LOS PRODUCTOS AL DETALLE DE LA FACTURA";
	$link=conectarServidor();   
	$qrybus="select * from det_compras where Id_compra=$Factura AND Codigo=$cod_mprima;";
	$resultqrybus=mysqli_query($link,$qrybus);
	$row_bus=mysqli_fetch_array($resultqrybus);
	if ($row_bus['Codigo']==$cod_mprima)
		{
			echo' <script >
				alert("Producto incluido anteriormente");
				document.formulario.submit();
			</script>'; 
		}
	else
	{
		$qryFact="insert into det_compras (Id_compra, Codigo, Cantidad, Precio, Lote) values  ($Factura, $cod_mprima, $kg, $precio, '$lote')";
		if($resultfact=mysqli_query($link,$qryFact))
		{	
			$qry="select sum(Precio*Cantidad) as Total, sum(Precio*Cantidad*tasa) as IVA, tasa_retica 
from det_compras, mprimas, tasa_iva, compras, proveedores, tasa_reteica
where det_compras.Id_compra=$Factura AND Codigo=Cod_mprima and compras.Id_compra=det_compras.Id_compra and nit_prov=NIT_provee 
and numtasa_rica=Id_tasa_retica and tasa_iva.Id_tasa=mprimas.Cod_iva;";
			if ($result=mysqli_query($link,$qry))
			{
				$row=mysqli_fetch_array($result);
				$SUBTotalFactura=$row['Total'];
				$tasa_reteica=$row['tasa_retica'];
				if ($SUBTotalFactura>=BASE_C)
				{
					$retencion=$SUBTotalFactura*0.025;
					$reteica=$SUBTotalFactura*$tasa_reteica/1000;
				}
				else
				{
					$retencion=0;
					$reteica=0;
				}
				$Iva_Factura=$row['IVA'];
				$TotalFactura=$SUBTotalFactura+$Iva_Factura;
				$qryUpFactura="update compras set total_fact=$TotalFactura, Subtotal=$SUBTotalFactura, IVA=$Iva_Factura, retencion=$retencion, ret_ica=$reteica where Id_compra=$Factura";
				if ($result=mysqli_query($link,$qryUpFactura))
				{
					//SE ACTUALIZA LA TABLA DE INVENTARIOS
					$qryinv="select Cod_mprima, Lote_mp, inv_mp, Fecha_lote from inv_mprimas where Cod_mprima=$cod_mprima and Lote_mp='$lote';";
					$qryprec="select Precio_mp from mprimas where Cod_mprima=$cod_mprima;";
					if ($resultinv=mysqli_query($link,$qryinv))
					{
						if ($resultprec=mysqli_query($link,$qryprec))
						{
							$rowprec=mysqli_fetch_array($resultprec);
							$prec=$rowprec['Precio_mp'];
							if($Precio > $prec)
									$prec=$Precio;
							if ($rowinv=mysqli_fetch_array($resultinv))//Si existe inventario de la materia prima
							{
								$inv=$rowinv['inv_mp'];
								$inv=$inv+$kg;
								$qryup="update inv_mprimas set inv_mp=$inv where Cod_mprima=$cod_mprima and lote_mp='$lote'";
								if ($resultupinv=mysqli_query($link,$qryup))
								{	
								}
								else
								{
									echo' <script >
									alert("Error al actualizar el Inventario de Materia Prima")
									</script>';
								}
								
							}
							else
							{
								$qryins="insert into inv_mprimas (Cod_mprima, Lote_mp, inv_mp, Fecha_lote, Estado_MP) values ($cod_mprima, '$lote', $kg, '$FchLote', 'C')";
								if ($resultins=mysqli_query($link,$qryins))
								{
									//Actualizar el precio de materia prima en 
								}
								else
								{
									echo' <script >
									alert("Error al ingresar al inventario de materias primas la compra")
									</script>';
								}
							}
							$qryup2="update mprimas set Precio_mp=$prec where Cod_mprima=$cod_mprima";
							if($resultupmp=mysqli_query($link,$qryup2))
							{}
							else
							{
								echo' <script >
								alert("Error al actualizar el precio del la Materia Prima")
								</script>';
							}
						}
						else
						{
							echo' <script >
							alert("Error al consultar el precio del la Materia Prima")
							</script>';
						}
					}
					else
					{
						echo' <script >
						alert("Error al consultar el inventario")
						</script>';
					}
				}
		}
		
	} 	
		mysqli_free_result($resultinv);	
		mysqli_free_result($resultprec);	
		mysqli_free_result($resultqrybus);		
		mysqli_close($link);
	echo '<form method="post" action="detCompramp.php" name="form3">';
	echo'<input name="CrearFactura" type="hidden" value="5">'; 
	echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
	echo '</form>';
	echo'<script >
		document.form3.submit();
		</script>';
	}

}
if($CrearFactura==5)
{	
	$link=conectarServidor();
	$qry="select sum(Precio*Cantidad) as Total, sum(Precio*Cantidad*tasa) as IVA, tasa_retica
from det_compras, mprimas, tasa_iva, compras, proveedores, tasa_reteica
where det_compras.Id_compra=$Factura AND Codigo=Cod_mprima and compras.Id_compra=det_compras.Id_compra and nit_prov=NIT_provee 
and numtasa_rica=Id_tasa_retica and tasa_iva.Id_tasa=mprimas.Cod_iva;";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$qryc="select ret_provee from compras, proveedores where nit_prov=NIT_provee and Id_compra=$Factura";
	$resultc=mysqli_query($link,$qryc);
	$rowc=mysqli_fetch_array($resultc);
	$autore=$rowc['ret_provee'];
	
	$SUBTotalFactura=$row['Total'];
	$tasa_reteica=$row['tasa_retica'];
	if ($SUBTotalFactura==NULL)
		$SUBTotalFactura=0;
		
		
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
	if ($Iva_Factura==NULL)
		$Iva_Factura=0;
	$TotalFactura=$SUBTotalFactura+$Iva_Factura;
	$qryUpFactura="update compras set total_fact=$TotalFactura, Subtotal=$SUBTotalFactura, IVA=$Iva_Factura, retencion=$retencion, ret_ica=$reteica where Id_compra=$Factura";
	//echo $qryUpFactura;
	if ($estadoc!=7)
	$result1=mysqli_query($link,$qryUpFactura);
	mysqli_free_result($resultc);	
	mysqli_free_result($result);	
	mysqli_close($link);
} 
if($CrearFactura==6)
{	
	if ($estado==2)
	{
	  $link=conectarServidor();
	  $qryUpEstFactura="update compras set estado=3 where Id_compra=$Factura";
	  $result2=mysqli_query($link,$qryUpEstFactura);
	  mysqli_close($link);
	}
	echo'<script  type="text/javascript">
	self.location="menu.php";
	</script>';
} 
?>
<?php
		$link=conectarServidor();
		$qry="select compras.*, Nom_provee, Des_estado
		from compras, proveedores, estados
		where Id_compra=$Factura
		and compras.nit_prov=proveedores.NIT_provee and estado=Id_estado";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		$nit=$row['nit_prov'];
		$des_estado=$row['Des_estado'];
		$estado=$row['estado'];
		mysqli_free_result($result);
		mysqli_close($link);
	 ?>
<form method="post" action="detCompramp.php" name="form1">
  <table  align="center" border="0" summary="table" width="72%">
  <tr>
    <td width="18%"><div align="right"><strong>No. de Compra</strong> </div></td>
    <td width="13%" colspan="1"><div align="left"><?php echo $Factura;?></div></td>
    <td width="22%"><div align="right"><strong>No. de Factura</strong></div></td>
    <td width="8%"><?php echo  $row['Num_fact']?></td>
    <td width="16%" ><div align="right"><strong>Estado</strong> </div></td><td width="23%" colspan=3 ><?php echo $des_estado; ?></td>
  </tr>
    <tr>
      
    </tr>
    
    <tr>
      <td><div align="right"><strong>Proveedor</strong></div></td>
      <td colspan="3"><?php echo  $row['Nom_provee']?></td>
      <td><div align="right"><strong>Valor Factura</strong></div></td>
      <td><div align="left"><?php echo '$ <script  type="text/javascript"> document.write(commaSplit('.$row['total_fact'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td><div align="right"><strong>NIT</strong></div></td>
      <td colspan="3"><?php echo  $row['nit_prov']?></td>
      <td><div align="right"><strong>Rete Ica</strong></div></td>
      <td><div align="left"><?php echo '$ <script  type="text/javascript"> document.write(commaSplit('.$row['ret_ica'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td ><div align="right"><strong>Fecha de Factura</strong></div></td>
      <td colspan="3"><?php echo $row['Fech_comp'];?></td>
       <td><div align="right"><strong>Retenci&oacute;n</strong></div></td>
      <td><div align="left"><?php echo '$ <script  type="text/javascript"> document.write(commaSplit('.$row['retencion'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td ><div align="right"><strong>Fecha Vencimiento </strong></div></td>
      <td colspan="3"><?php echo $row['Fech_venc'];?></td>
       <td><div align="right"><strong>Valor a Pagar</strong></div></td>
      <td><div align="left"><?php echo '$ <script  type="text/javascript"> document.write(commaSplit('.($row['total_fact']-$row['retencion']-$row['ret_ica']).'))</script>' ;?> </div></td>
    </tr>
    <tr>
    	<td colspan="6"><hr></td>	
    </tr>
    <?php
	if ($estadoc!=7)
	{
	 echo '<tr>
      <td colspan="2"><div align="center"><strong>Materia Prima</strong></div></td>
      <td width="14%"><div align="center"><strong>Cantidad en Kg</strong></div></td>
      <td width="16%"><div align="center"><strong>Precio por Kg  (Sin IVA)</strong></div></td>
      <td><div align="center"><strong>Lote Materia Prima</strong></div></td>
      <td align="center" ><strong>Fecha Lote</strong></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">';
     $link=conectarServidor();
			echo'<select name="cod_mprima">';
			$result=mysqli_query($link,"select * from mprimas, det_proveedores WHERE NIT_provee='$nit' and Cod_mprima=Codigo order by Nom_mprima;");
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Cod_mprima'].'>'.$row['Nom_mprima'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
			mysqli_close($link);
		   
      echo '</div></td>
      <td><div align="center">
        <input name="kg" type="text" size=10>
      </div></td>
      <td><div align="center">
        <input name="precio" type="text" size=10>
      </div></td>
      <td><div align="center">
        <input name="lote" type="text" size=15>
      </div></td>
      <td><input type="text" name="FchLote" id="sel2" readonly size=10><input type="reset" value=" ... "
		onclick="return showCalendar('."'sel2'".', '."'%Y-%m-%d'".', '."'12'".', true);"></td>
    </tr>
    <tr>
      <td colspan="6" align="right"><input name="submit" type="submit" class="formatoBoton1" onClick="return Enviar(this.form)"  value="Continuar">
          <input name="CrearFactura" type="hidden" value="1">
          <input name="Factura" type="hidden" value="'.$Factura.'">'; 
		  ?> </td>
    </tr>
    <?php
	}
	?>
  </table>
</form>
	<table border="0" align="center" summary="detalle">
    <tr>
      <td  colspan="5" class="titulo">Detalle de Factura : </td>
    </tr>
  <tr>
    <th width="69"></th>
    <th width="65" align="center">C&oacute;digo</th>
    <th width="266" align="center">Materia Prima</th>
    <th width="51" align="center">Iva</th>
    <th width="119" align="center">Cantidad (Kg)</th>
    <th width="89" align="center">Precio/ Kg</th>
    <th width="154" align="center">Lote M. Prima</th>
    <th width="79"></th>
   </tr>
          <?php
			$link=conectarServidor();
			$Fact=$Factura;
			$qry="SELECT Codigo, Nom_mprima, Cantidad, Precio, Lote, tasa 
			FROM det_compras, mprimas, tasa_iva 
			where Id_compra=$Factura and det_compras.Codigo=mprimas.Cod_mprima and mprimas.Cod_iva=tasa_iva.Id_tasa";
				$result=mysqli_query($link,$qry);
			$c=0;
			while($row=mysqli_fetch_array($result))
			{
				$codigo=$row['Codigo'];
				$cantidad=$row['Cantidad'];
				$lote_mp=$row['Lote'];
				echo'<tr><td>';
				if ($estadoc!=7)
				{
				echo '<form action="updateCompraMP.php" method="post" name="actualiza'.$c.'">
				<input name="Factura" type="hidden" value="'.$Factura.'">
				<input name="codigo" type="hidden" value="'.$codigo.'">
				<input name="cantidad" type="hidden" value="'.$cantidad.'">
				<input name="lote_mp" type="hidden" value="'.$lote_mp.'">
				<input type="submit" name="Submit" value="Cambiar">
				</form>';
				}
				echo '</td>
				  <td><div align="center">'.$row['Codigo'].'</div></td>
				  <td><div align="center">'.$row['Nom_mprima'].'</div></td>
				  <td><div align="center">'.$row['tasa']*(100).' %</div></td>
				  <td><div align="center"> '.$row['Cantidad'].'</div></td>
				  <td><div align="center">$ <script  type="text/javascript"> document.write(commaSplit('.$row['Precio'].'))</script></div></td>
				  <td><div align="center">'.$row['Lote'].'</div></td>
			<td>';
			if ($estadoc!=7)
				{
			echo '<form action="delMPComp.php" method="post" name="elimina'.$c++.'">
				<input name="Factura" type="hidden" value="'.$Factura.'">
				<input name="codigo" type="hidden" value="'.$codigo.'">
				<input name="cantidad" type="hidden" value="'.$cantidad.'">
				<input name="lote_mp" type="hidden" value="'.$lote_mp.'">
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

<div align="center">
<form method="post" action="detCompramp.php" name="form5">
<input name="CrearFactura" type="hidden" value="6"> 
<input name="Factura" type="hidden" value="<?php echo $Factura; ?>"> 
<input name="estado" type="hidden" value="<?php echo $estado; ?>"> 
<input type="submit" class="formatoBoton1"  value="Terminar"></form></div>
</div> 
</body>
</html>