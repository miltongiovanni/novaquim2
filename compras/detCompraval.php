<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Ingreso de Compra de Tapas y V&aacute;lvulas</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div align="center"><img src="images/LogoNova.JPG"/></div>
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
if($CrearFactura==0)
{
	$est='P';
	$link=conectarServidor();   
	$bd="novaquim";   
	/*validacion del valor a pagar"*/
	$qryFact="insert into compras (nit_prov, Num_fact, Fech_comp, Fech_venc, estado, compra)
	values  ('$nit_prov', $num_fac, '$FchFactura','$VenFactura','$est', 3)";
	if($resultfact=mysql_db_query($bd,$qryFact))
	{
		$qry="select max(Id_compra) as Fact from compras";
		$result=mysql_db_query($bd,$qry);
		$row=mysql_fetch_array($result);
		$Factura=$row['Fact'];	
		echo '<form method="post" action="detCompraval.php" name="form3">';
		echo'<input name="CrearFactura" type="hidden" value="5">'; 
		echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
		echo '</form>';
		echo'<script >
		document.form3.submit();
		</script>';		
		mysql_close($link);
	}
	else
	{
		mover_pag("compraval.php","Error al ingresar la factura de compra");
		mysql_close($link);
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
	//AGREGANDO LOS ARTICULOS DE LA FACTURA";
	$link=conectarServidor();   
	$bd="novaquim";
	$qrybus="select * from det_compras where Id_compra=$Factura and Codigo=$cod_val;";
	$resultqrybus=mysql_db_query($bd,$qrybus);
	$row_bus=mysql_fetch_array($resultqrybus);
	if ($row_bus['Codigo']==$cod_val)
	{
		echo' <script >
			alert("Producto incluido anteriormente");
			document.formulario.submit();
		</script>'; 
		mysql_close($link);
	}
	else
	{  
		//SE ACTUALIZA LA TABLA DE INVENTARIOS
		$qryinv="select * from inv_tapas_val where Cod_tapa=$cod_val";
		$qryprec="select Pre_tapa from tapas_val where Cod_tapa=$cod_val";
		$resultinv=mysql_db_query($bd,$qryinv);
		$resultprec=mysql_db_query($bd,$qryprec);
		$rowprec=mysql_fetch_array($resultprec);
		$prec=$rowprec['Pre_tapa'];
		if($precio_val > $prec)
			$prec=$precio_val;
		if($rowinv=mysql_fetch_array($resultinv))
		{
			$inv=$rowinv['inv_tapa'];
			$inv=$inv+$cant_val;
			$qryup="update inv_tapas_val set inv_tapa=$inv where Cod_tapa=$cod_val";
			$resultup=mysql_db_query($bd,$qryup);
		}
		else
		{
			$qryins="insert into inv_tapas_val (Cod_tapa, Pre_tapa, inv_tapa) values ($cod_val, $precio_val, $cant_val)";
			$resultup=mysql_db_query($bd,$qryins);
		}
		$qryup2="update tapas_val set Pre_tapa=$prec where Cod_tapa=$cod_val";
		$resultup2=mysql_db_query($bd,$qryup2);
  
		$qryFact="insert into det_compras (Id_compra, Codigo, Cantidad, Precio) values ($Factura, $cod_val, $cant_val, $precio_val)";
		if($resultfact=mysql_db_query($bd,$qryFact))
		{	
		$qry="select sum(Cantidad*Precio) as Total, sum(Precio*Cantidad*tasa) as IVA from det_compras,envase, tasa_iva
			where Id_compra=$Factura and Codigo=Cod_envase and envase.Cod_iva=tasa_iva.Id_tasa";
			$qry="select sum(Cantidad*Precio) as Total, sum(Precio*Cantidad*tasa) as IVA from det_compras,tapas_val, tasa_iva
			where Id_compra=$Factura and Codigo=Cod_tapa and Cod_iva=Id_tasa";
			$result=mysql_db_query($bd,$qry);
			$row=mysql_fetch_array($result);
			$SUBTotalFactura=$row['Total'];
			$Iva_Factura=$row['IVA'];
			$TotalFactura=$SUBTotalFactura+$Iva_Factura;
			$qryUpFactura="update compras set total_fact=$TotalFactura, Subtotal=$SUBTotalFactura, IVA=$Iva_Factura where Id_compra=$Factura";
			$result=mysql_db_query($bd,$qryUpFactura);
		}	
		mysql_close($link);	
	} 
	
	echo '<form method="post" action="detCompraval.php" name="form3">';
	echo'<input name="CrearFactura" type="hidden" value="5">'; 
	echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
	echo '</form>';
	echo'<script >
	document.form3.submit();
	</script>';		
}
?>


<form method="post" action="detCompraval.php" name="form1">
  <table width="55%"  align="center" border="0">
   <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div align="left" class="titulo"><strong> Compra de Tapas o V&aacute;lvulas: </strong></div></td>
      <td width="19%"><div align="right"><strong>No. de Compra</strong> </div></td>
      <td width="19%"><div align="left"><?php echo $Factura;?></div></td>
    </tr>
    <tr>
      <td colspan="4"><hr></td>
    </tr>
    <?php
	  	$link=conectarServidor();
		$Fact=$Factura;
        $bd="novaquim";
		$qry="select compras.*, Nom_provee
		from compras, proveedores
		where Id_compra=$Fact
		and compras.nit_prov=proveedores.nitProv";
		$result=mysql_db_query($bd,$qry);
		$row=mysql_fetch_array($result);
		$nit=$row['nit_prov'];
		mysql_close($link);
	 ?>
    <tr>
      <td width="24%"><strong>Proveedor</strong></td>
      <td width="38%"><?php echo  $row['Nom_provee']?></td>
      <td><strong>NIT</strong></td>
      <td><?php echo  $row['nit_prov']?></td>
    </tr>
    <tr>
      <td ><strong>Fecha de Factura</strong></td>
      <td><?php echo $row['Fech_comp'];?></td>
      <td><strong>Valor Factura</strong></td>
      <td><div align="left"><?php echo '$ <script > document.write(commaSplit('.$row['total_fact'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td ><strong>Fecha Vencimiento </strong></td>
      <td><?php echo $row['Fech_venc'];?></td>
      <td><strong>No. de Factura</strong></td>
      <td><?php echo  $row['Num_fact']?></td>
    </tr>
    <tr>
      <td colspan="4"><hr></td>
    </tr>
    <tr>
    	<td></td>
        <td ><div align="center"><strong>Tapa o V&aacute;lvula</strong></div></td>
      	<td><div align="center"><strong>Cantidad</strong></div></td>
        <td><div align="center"><strong>Precio por Un (Sin IVA)</strong></div></td>
    </tr>
    <tr>
    	<td></td>
      <td ><div align="center">
        <?php

			$link=conectarServidor();
			echo'<select name="cod_val">';
			$result=mysql_db_query("novaquim","select * from tapas_val, det_proveedores  where Cod_tapa=Codigo and NIT_provee='$nit' order by Cod_tapa;");
			$total=mysql_num_rows($result);
            while($row=mysql_fetch_array($result))
			{
				echo '<option value='.$row['Cod_tapa'].'>'.$row['Nom_tapa'].'</option>';
            }
            echo'</select>';
			mysql_close($link);
		?>      
      </div></td>
      <td><div align="center">
        <input name="cant_val" type="text" size=10>
      </div></td>
      <td><div align="center">
        <input name="precio_val" type="text" size=10>
      </div></td>
      
    </tr>
    <tr>
      <td colspan="4" align="center"><input name="submit" onClick="return Enviar(this.form)" type="submit"  value="Continuar">
          <input name="CrearFactura" type="hidden" value="1">
          <?php echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; ?> </td>
    </tr>
    <tr>
      <td colspan="4"><hr></td>
    </tr>
    <tr>
      <td  colspan="4" class="titulo">Detalle de Factura : </td>
    </tr>
     </table>
     </form>
     <table width="55%" border="0" align="center">
          <tr>
          	<th width="9%"></th>
            <th width="9%">C&oacute;digo</th>
            <th width="37%">Tapa o V&aacute;lvula</th>
            <th width="16%">Cantidad </th>
            <th width="17%">Precio por Un</th>
            <th width="9%"></th>
          </tr>
        <tr>
        	<td colspan="6"><hr></td>
        </tr>
          <?php
			$link=conectarServidor();
			$bd="novaquim";
			$qry="SELECT Codigo, Nom_tapa, Cantidad, Precio 
			FROM det_compras, tapas_val 
			where Id_compra=$Factura and det_compras.Codigo=tapas_val.Cod_tapa;";
			$result=mysql_db_query($bd,$qry);
			while($row=mysql_fetch_array($result))
			{
				$codigo=$row['Codigo'];
				$cantidad=$row['Cantidad'];
				echo'<tr>
				<form action="updateCompraVal.php" method="post" name="actualiza">
					<input name="Factura" type="hidden" value="'.$Factura.'"/>
					<input name="codigo" type="hidden" value="'.$codigo.'"/>
					<input name="cantidad" type="hidden" value="'.$cantidad.'"/>
					<td align="center" valign="middle"> <input type="submit" name="Submit" value="Cambiar" /></td>
				</form>
				<td><div align="center">'.$row['Codigo'].'</div></td>
				<td><div align="center">'.$row['Nom_tapa'].'</div></td>
				<td><div align="center">'.$row['Cantidad'].'</div></td>
				<td><div align="center">$ <script > document.write(commaSplit('.$row['Precio'].'))</script></div></td>
				<form action="delValComp.php" method="post" name="elimina">
					<input name="Factura" type="hidden" value="'.$Factura.'"/>
					<input name="codigo" type="hidden" value="'.$codigo.'"/>
					<input name="cantidad" type="hidden" value="'.$cantidad.'"/>
					<td align="center" valign="middle"> <input type="submit" name="Submit" value="Eliminar" /></td>
				</form>
				</tr>';
			}
			mysql_close($link);
			?>
    <tr>
      <td colspan="6"><hr></td>
    </tr>
  </table>

<table width="27%" border="0" align="center"> 
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Terminar"></div></td>
    </tr>
</table> 
</body>
</html>
