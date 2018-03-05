<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Ingreso de Compra de Etiqueta</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body> 
<div align="center"><img src="images/LogoNova1.JPG"/></div>
<?php
include "includes/conect.php";	
$link=conectarServidor(); 
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$Crear=$_POST['CrearFactura'];
if($CrearFactura==0)
{
	$qry="select max(Id_compra_etq) as Fact from compra_etq";
	$result=mysql_db_query($bd,$qry);
	$row=mysql_fetch_array($result);
	$Factura=$row['Fact']+1;	
	$est='P'; 
	$matriz = array("Id_compra_etq" => $Factura, "nit_prov" => "$nit_prov", "Num_fact" => $num_fac, "Fech_comp" => "$FchFactura", "Fech_venc" => "$VenFactura", "estado" => "$est");
	print_r($matriz);


	 
  	/*$bd="novaquim";   
	$qryFact="insert into compra_etq (nit_prov, Num_fact, Fech_comp, Fech_venc, estado)
	values  ('$nit_prov', $num_fac, '$FchFactura','$VenFactura','$est')";
	echo $qryFact;
	if($resultfact=mysql_db_query($bd,$qryFact))
	{
		$qry="select max(Id_compra_etq) as Fact from compra_etq";
		$result=mysql_db_query($bd,$qry);
		$row=mysql_fetch_array($result);
		$Factura=$row['Fact'];		
		echo '<form method="post" action="detCompraetq.php" name="form3">';
		echo'<input name="CrearFactura" type="hidden" value="5">'; 
		echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
		echo'<input name="link" type="hidden" value="'.$link.'">'; 
		echo '</form>';
		echo'<script language="Javascript">
			document.form3.submit();
			</script>';*/
	}
	else{
		mover_pag("compraetq.php","Error al ingresar la factura de compra");
	}
}
function mover_pag($ruta,$nota)
{	
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo' <script language="Javascript">
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}

if($CrearFactura==1)
{
	//echo "NO ESTA CREANDO FACTURA";
	//$link=conectarServidor();   
	echo $link;
	$bd="novaquim"; 
	$qrybus="select * from det_compra_etq where Id_compra_etq=$Factura and Cod_etq=$cod_etq;";
	$resultqrybus=mysql_db_query($bd,$qrybus);
	$row_bus=mysql_fetch_array($resultqrybus);
	if ($row_bus['Cod_etq']==$cod_etq)
		{
			echo' <script language="Javascript">
				alert("Producto incluido anteriormente");
				document.formulario.submit();
			</script>'; 
		}
	else
	{    
		//SE ACTUALIZA LA TABLA DE INVENTARIOS
		$qryinv="select * from inv_etiquetas where Cod_etiq=$cod_etq";
		$resultinv=mysql_db_query($bd,$qryinv);
		if ($rowinv=mysql_fetch_array($resultinv))
		{
			$inv=$rowinv['inv_etiq'];
			$prec=$rowinv['Prec_etiq'];
			if($precio_etq > $prec)
				$prec=$precio_etq;
			$inv=$inv+$can_etq;
			$qryup="update inv_etiquetas set Prec_etiq=$prec, inv_etiq=$inv where Cod_etiq=$cod_etq";
			$resultup=mysql_db_query($bd,$qryup);
		}
		else
		{
			$qryins="insert into inv_etiquetas (Cod_etiq, Prec_etiq, inv_etiq) values ($cod_etq, $precio_etq, $can_etq)";
			$resultup=mysql_db_query($bd,$qryins);
		}
		//
		$qryFact="insert into det_compra_etq (Id_compra_etq, Cod_etq, can_etq, etq_precio)
				   values  ($Factura, $cod_etq, $can_etq, $precio_etq)";
		if($resultfact=mysql_db_query($bd,$qryFact))
		{	
			$qry="select sum(can_etq*etq_precio) as Total from det_compra_etq
			where Id_compra_etq=$Factura";
			$result=mysql_db_query($bd,$qry);
			$row=mysql_fetch_array($result);
			$SUBTotalFactura=$row['Total'];
			$Iva_Factura=$SUBTotalFactura*0.16;
			$TotalFactura=$SUBTotalFactura+$Iva_Factura;
			$qryUpFactura="update compra_etq set total_fact=$TotalFactura where Id_compra_etq=$Factura";
			$result=mysql_db_query($bd,$qryUpFactura);
		}		
	} 
	/*echo '<form method="post" action="detCompraetq.php" name="form3">';
	echo'<input name="CrearFactura" type="hidden" value="5">'; 
	echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
	echo'<input name="link" type="hidden" value="'.$link.'">'; 
	echo '</form>';
	echo'<script language="Javascript">
		document.form3.submit();
		</script>';	*/
}
?>


<form method="post" action="detCompraetq.php" name="form1">
  <table width="55%"  align="center" border="0">
   <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div align="left" class="titulo"><strong>Compra de Etiqueta </strong></div></td>
      <td width="20%"><div align="right"><strong>No. de Compra</strong> </div></td>
      <td width="23%"><div align="left"><?php echo $Factura;?></div></td>
    </tr>
    <tr>
      <td colspan="4"><hr></td>
    </tr>
    <?php
	  	//$link=conectarServidor();
		echo $link;
		$Fact=$Factura;
        $bd="novaquim";
		 $qry="select compra_etq.*, Nom_provee
		from compra_etq, proveedores
		where Id_compra_etq=$Fact
		and compra_etq.nit_prov=proveedores.NIT_provee";
		$result=mysql_db_query($bd,$qry);
		$row=mysql_fetch_array($result);
	 ?>
    <tr>
      <td width="26%"><strong>Proveedor</strong></td>
      <td width="31%"><?php echo  $row['Nom_provee']?></td>
      <td><strong>NIT</strong></td>
      <td><?php echo  $row['nit_prov']?></td>
    </tr>
    <tr>
      <td ><strong>Fecha de Factura</strong></td>
      <td><?php echo $row['Fech_comp'];?></td>
      <td><strong>Valor Factura</strong></td>
      <td><div align="left"><?php echo '$ <script language="javascript"> document.write(commaSplit('.$row['total_fact'].'))</script>' ;?> </div></td>
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
      <td colspan="2"><div align="center"><strong>Etiqueta</strong></div></td>
      <td><div align="center"><strong>Cantidad</strong></div></td>
      <td><div align="center"><strong>Precio por Und</strong></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <?php

			$link=conectarServidor();
			echo'<select name="cod_etq">';
			$result=mysql_db_query("novaquim","select * from etiquetas order by Nom_etiq");
			$total=mysql_num_rows($result);
            while($row=mysql_fetch_array($result))
			{
				echo '<option value='.$row['Cod_etiq'].'>'.$row['Nom_etiq'].'</option>';
            }
            echo'</select>';
		?>      
      </div></td>
      <td><div align="center">
        <input name="can_etq" type="text" size=10>
      </div></td>
      <td><div align="center">
        <input name="precio_etq" type="text" size=10>
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
	<table width="55%" border="0" align="center">
          <tr>
            <th width="9%">C&oacute;digo</th>
            <th width="37%">Etiqueta</th>
            <th width="16%">Cantidad </th>
            <th width="17%">Precio por Und</th>
          </tr>
          <tr>
      		<td colspan="4"><hr></td>
    	  </tr>
          <?php
			//$link=conectarServidor();
			$Fact=$Factura;
			$bd="novaquim";
				 $qry="SELECT Cod_etq, Nom_etiq, can_etq, etq_precio
				FROM `det_compra_etq`, etiquetas 
				where Id_compra_etq=$Factura and det_compra_etq.Cod_etq=etiquetas.Cod_etiq";
				$result=mysql_db_query($bd,$qry);
	
			
			while($row=mysql_fetch_array($result))
			{
			echo'<tr>
			  <td><div align="center">'.$row['Cod_etq'].'</div></td>
			  <td><div align="center">'.$row['Nom_etiq'].'</div></td>
			  <td><div align="center">'.$row['can_etq'].'</div></td>
			  <td><div align="center">$ <script language="javascript"> document.write(commaSplit('.$row['etq_precio'].'))</script></div></td>
			</tr>';
			}
			?>
    <tr>
      <td colspan="4"><hr></td>
    </tr>
  </table>
  </div>
</form>
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
        <td><div align="center">
          <input type="button" class="resaltado" onClick="opcion();" value="Terminar">
        </div></td>
    </tr>
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
    </tr>
</table> 
</body>
</html>
