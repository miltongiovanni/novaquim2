<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Ingreso de Productos Hoja de Pedido de Venta Directa</title>
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
<div id="saludo1"><strong>DETALLE PEDIDO VENTA DIRECTA</strong></div> 
<?php
	include "includes/conect.php";
	include "includes/calcularDias.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	function mover($ruta,$nota)
	{
		//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
		echo'<script >
		alert("'.$nota.'");
		self.location="'.$ruta.'";
		</script>';
	} 
	$link=conectarServidor();  
	$bd="novaquim";   
	$fecha_actual=date("Y")."-".date("m")."-".date("d");
	if($sobre==NULL)
	   $sobre=0;
	if ($Crear == 3)
	{
		$dias_p=Calc_Dias($FchPed,$fecha_actual);
		$dias_ep=Calc_Dias($FchEnt,$FchPed);
		$dias_e=Calc_Dias($FchEnt,$fecha_actual);
		if(($dias_p>=0)&&($dias_e>=0)&&($dias_ep>=0))
		{		  
		  $qrycam="select MAX(Id_pedido) AS Pedido from pedido;";
		  $resultqrycam=mysql_db_query($bd,$qrycam);
		  $row_cam=mysql_fetch_array($resultqrycam);
		  $pedido=$row_cam['Pedido']+1;
		  $qryins_comp="insert into pedido (Id_pedido, Nit_cliente, Fech_pedido, Fech_entrega, tip_precio, Estado, Id_sucurs) 
					    values ($pedido, '$cliente', '$FchPed', '$FchEnt', $tip_precio, 'P', $sucursal)";
		  $resultins_prod=mysql_db_query($bd,$qryins_comp);	
		  $qrycam="select MAX(Id_pedido) AS Pedido from pedido;";
		  $resultqrycam=mysql_db_query($bd,$qrycam);
		  $row_cam=mysql_fetch_array($resultqrycam);
		  $pedido=$row_cam['Pedido'];
		  mysql_close($link);
		  echo '<form method="post" action="det_pedidoVD.php" name="form3">';
		  echo'<input name="Crear" type="hidden" value="5">'; 
		  echo'<input name="sobre" type="hidden" value="'.$sobre.'">'; 
		  echo'<input name="pedido" type="hidden" value="'.$pedido.'">'; 
		  echo '</form>';
		  echo'<script >
				document.form3.submit();
				</script>';
		}
		else
		{
			if($dias_p<0)
			{
				echo'<script >
				alert("La fecha del pedido no puede ser menor que la actual");
				self.location="pedido.php";
				</script>';	
			}
			if($dias_ep<0)
			{
				echo'<script >
				alert("La fecha de entrega del pedido no puede ser menor que la fecha del pedido");
				self.location="pedido.php";
				</script>';	
			}
			if($dias_e<0)
			{
				echo'<script >
				alert("La fecha de entrega del pedido no puede ser menor que la actual");
				self.location="pedido.php";
				</script>';	
			}
		}
	}
	if($Crear==1)
	{
		//MIRA CUANTOS PRODUCTOS HAY EN EL PEDIDO  --- DEBE SER MÁXIMO 40 PRODUCTOS
		$qry1="select * from det_pedido where Id_ped=$pedido";
		$result1=mysql_db_query($bd,$qry1);
		$items=mysql_num_rows ($result1);
		if ($items<40)
		{	
			//PRECIOS DE PRODUCTOS DE LA EMPRESA
			$qryins_p="insert into det_pedido (Id_ped, Cod_producto, Can_producto, Prec_producto) values ($pedido, $cod_producto, $cantidad, 0)";
			$resultins_p=mysql_db_query($bd,$qryins_p);
			$qrybus="select Id_pedido, tip_precio, Cod_producto, directa from pedido, det_pedido, prodpre 
			where Id_pedido=$pedido AND Id_pedido=Id_ped And Cod_producto <100000 and Cod_producto=Cod_prese and Cod_producto=$cod_producto;";
			$resultbus=mysql_db_query($bd,$qrybus);
			$rowbus=mysql_fetch_array($resultbus);
			$precio=$rowbus['directa']*(1+$sobre/100);
			$qryup="update det_pedido set Prec_producto=$precio where Id_ped=$pedido and Cod_producto=$cod_producto;";
			$resultup=mysql_db_query($bd,$qryup);
			
		}
		else
		{
			echo'<script >
			alert("Máximo 40 productos por pedido")
			</script>';	
			mysql_close($link);
		}
		mysql_close($link);
	}
	if($Crear==2)
	{
		//MIRA CUANTOS PRODUCTOS HAY EN EL PEDIDO  --- DEBE SER MÁXIMO 40 PRODUCTOS
		$qry1="select * from det_pedido where Id_ped=$pedido";
		$result1=mysql_db_query($bd,$qry1);
		$items=mysql_num_rows ($result1);
		if ($items<40)
		{	
			//PRECIOS DE PRODUCTOS DE DISTRIBUCIÓN
			$qryins_d="insert into det_pedido (Id_ped, Cod_producto, Can_producto, Prec_producto) values ( $pedido, $cod_producto, $cantidad, 0)";
			$resultins_d=mysql_db_query($bd,$qryins_d);
			$qrybus="select Id_ped, Cod_producto, Precio_vta, directa from det_pedido, distribucion 
			where Id_ped=$pedido AND Id_ped=Id_ped and Cod_producto=Id_distribucion And Cod_producto >100000 and Cod_producto=$cod_producto";
			$resultbus=mysql_db_query($bd,$qrybus);
			$rowbus=mysql_fetch_array($resultbus);
			$precio=$rowbus['directa']*(1+$sobre/100);	
			$qryup="update det_pedido set Prec_producto=$precio where Id_ped=$pedido and Cod_producto=$cod_producto;";
			$resultup=mysql_db_query($bd,$qryup);
		}
		else
		{
			echo'<script >
			alert("Máximo 40 productos por pedido")
			</script>';	
		}
		mysql_close($link);
	}
	if($Crear==4)
	{
		//MIRA CUANTOS PRODUCTOS HAY EN EL PEDIDO  --- DEBE SER MÁXIMO 40 PRODUCTOS
		$qry1="select * from det_pedido where Id_ped=$pedido";
		$result1=mysql_db_query($bd,$qry1);
		$items=mysql_num_rows ($result1);
		if ($items<40)
		{	
			//PRECIOS DE HERRAMIENTAS
			$qryins_d="insert into det_pedido (Id_ped, Cod_producto, Can_producto, Prec_producto) values ($pedido, $cod_producto, $cantidad, 0)";
			$resultins_d=mysql_db_query($bd,$qryins_d);
			$qrybus="select Id_ped, Cod_producto, precio from det_pedido, herramientas 
			where Id_ped=$pedido AND Id_ped=Id_ped and Cod_producto=Id_herramienta And Cod_producto >1000000 and Cod_producto=$cod_producto;";
			$resultbus=mysql_db_query($bd,$qrybus);
			$rowbus=mysql_fetch_array($resultbus);
			$precio=$rowbus['precio']*(1+$sobre/100);	
			$qryup="update det_pedido set Prec_producto=$precio where Id_ped=$pedido and Cod_producto=$cod_producto;";
			$resultup=mysql_db_query($bd,$qryup);
		}
		else
		{
			echo'<script >
			alert("Máximo 40 productos por pedido")
			</script>';	
		}
		mysql_close($link);
	}
	$link=conectarServidor(); 
	$qry2="Select nom_clien, Id_pedido, Fech_pedido, Fech_entrega, Cod_vend, nom_personal, tipo_precio, pedido.Estado, Nom_sucursal, Dir_sucursal, Tel_clien 
		FROM pedido, personal, clientes, tip_precio, clientes_sucursal 
		where Cod_vend=Id_personal and Id_pedido=$pedido and clientes.nit_clien=nit_cliente and Id_precio=tip_precio and Id_sucurs=Id_sucursal and clientes_sucursal.Nit_clien=Nit_cliente";
	$result2=mysql_db_query($bd,$qry2);
	if ($row2=mysql_fetch_array($result2))
	{
		mysql_close($link);
	}
	else
	{
		mover("buscarPedido.php","No existe la Orden de Pedido");
		mysql_close($link);
	}
?>
<table border="0"  align="center" cellpadding="0" summary="Encabezado" width="82%">
    <tr>
    <td width="14%" align="right" ><strong>No. de Pedido</strong></td>
      <td width="27%"><div align="left"><?php echo $pedido;?></div></td>
    <td width="17%" align="right"><strong>Cliente</strong></td>
   	  <td colspan="3"><div align="left"><?php echo $row2['nom_clien']; ?></div></td>
    </tr>
    <tr>
        <td align="right" ><strong>Fecha Pedido</strong></td>
      <td colspan="1"  align="left"><?php echo $row2['Fech_pedido']; ?></td>
      	<td align="right"><strong>Vendedor</strong></td>
   	  	<td width="23%" colspan="1"><?php echo $row2['nom_personal']; ?></td>
        <td width="6%" align="right"><strong>Estado</strong></td>
      <td width="13%" align="right" ><div align="left" >
        <?php 
	  	if ($row2['Estado']=='A')
	  	$estado='Anulado';
		if ($row2['Estado']=='F')
	  	$estado='Facturado';
		if ($row2['Estado']=='P')
	  	$estado='Pendiente';
		if ($row2['Estado']=='L')
	  	$estado='Por Facturar';
	  	echo $estado; 
	  ?>
      </div></td>
  </tr>
        <tr>
      	<td align="right"><strong>Fecha Entrega</strong></td>
      	<td colspan="1" align="left"><?php echo $row2['Fech_entrega']; ?></td>
      	
        
      <td align="right"  ><strong>Tipo de Precio</strong></td>
   	  <td colspan="1" align="left"><?php echo $row2['tipo_precio']; ?></td>
      <td align="right"  ><strong>Tel&eacute;fono</strong></td>
   	  <td colspan="1" align="left"><?php echo $row2['Tel_clien']; ?></td>
    </tr>
    <tr>
      	<td align="right"><strong>Lugar de Entrega</strong></td>
      	<td colspan="1" align="left"><?php echo $row2['Nom_sucursal']; ?></td>
      	
        
      <td align="right"  ><strong>Direcci&oacute;n de Entrega</strong></td>
   	  <td colspan="2" align="left"><?php echo $row2['Dir_sucursal']; ?></td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    </table>
      
    <?php
    $link=conectarServidor(); 
	if ($row2['Estado']=='P')
	{
		echo '<form method="post" action="det_pedidoVD.php" name="form1">
 			<table border="0"  align="center" cellpadding="0" summary="cuerpo1"> 
			<tr>
				<td colspan="4"><div align="center"><strong>Productos Novaquim</strong></div></td>
				<td colspan="1"><div align="center"><strong>Unidades</strong></div></td>
				<td colspan="1"><div align="center"></div></td>
			</tr>
			<tr>
				<td colspan="4"><div align="center">';
		echo'<select name="cod_producto">';
			$result=mysql_db_query("novaquim","SELECT Cod_prese, Nombre FROM prodpre, productos where prodpre.Cod_produc=productos.Cod_produc and prod_activo=0 and pres_activo=0 and catalogo=1 order by Nombre;");
			$total=mysql_num_rows($result);
            while($row=mysql_fetch_array($result))
			{
				echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
            }
            echo'</select>';
			echo '</div></td>
			<td colspan="1"><div align="center"><input name="cantidad" type="text" size=7 onKeyPress="return aceptaNum(event)"></div></td>';
			echo '<td colspan="1" align="center"><input name="Crear" type="hidden" value="1"><input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar" ></td>';
			echo '</table> </form>
			 <form method="post" action="det_pedidoVD.php" name="form2">
			 <table border="0"  align="center" cellpadding="0" summary="cuerpo1">
			<tr>
				<td colspan="4"><div align="center"><strong>Productos Distribuci&oacute;n</strong></div></td>
				<td colspan="1"><div align="center"><strong>Unidades</strong></div></td>
			</tr>
			<tr>
				<td colspan="4"><div align="center">';
			echo'<select name="cod_producto">';
			$result=mysql_db_query("novaquim","select Id_distribucion, Producto from distribucion where Activo=0 and catalogo=1 order by Producto;");
			$total=mysql_num_rows($result);
            while($row=mysql_fetch_array($result))
			{
				echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
            }
            echo '</select>';
			echo '</div></td>
				<td colspan="1"><div align="center"><input name="cantidad" type="text" size=7 onKeyPress="return aceptaNum(event)"  ></div></td>';
			echo '<td align="center"><input name="Crear" type="hidden" value="2"><input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar" ></td>';
		  	echo '</table></form>';
			echo '<form method="post" action="det_pedidoVD.php" name="form3">
			 <table border="0"  align="center" cellpadding="0" summary="cuerpo1">
			<tr>
				<td colspan="4"><div align="center"><strong>Herramientas de Ventas</strong></div></td>
				<td colspan="1"><div align="center"><strong>Unidades</strong></div></td>
			</tr>
			<tr>
				<td colspan="4"><div align="center">';
			echo'<select name="cod_producto">';
			$result=mysql_db_query("novaquim","select Id_herramienta, Producto from herramientas where catalogo=1;;");
			$total=mysql_num_rows($result);
            while($row=mysql_fetch_array($result))
			{
				echo '<option value='.$row['Id_herramienta'].'>'.$row['Producto'].'</option>';
            }
            echo '</select>';
			echo '</div></td>
				<td colspan="1"><div align="center"><input name="cantidad" type="text" size=7 onKeyPress="return aceptaNum(event)"  ></div></td>';
			echo '<td align="center"><input name="Crear" type="hidden" value="4"><input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar" ></td>';
		  	echo '</table></form>';
			mysql_close($link);
		}
	?>
<table border="0" align="center" cellpadding="0" cellspacing="0" summary="cuerpo">
          <tr>
          	<th width="56"></th>
          	<th width="41" align="center"><strong>Item</strong></th>
            <th width="67" align="center"><strong>C&oacute;digo</strong></th>
            <th width="417" align="center"><strong>Producto </strong></th>
			<th width="86" align="center" ><strong>Cantidad </strong></th>
            <th width="94" align="center"><strong>Precio </strong></th>
            <th width="55"></th>
  </tr>
          <?php
			$link=conectarServidor();
			$bd="novaquim";
			$qry="select Cod_producto, Can_producto, Nombre, Prec_producto, Estado from det_pedido, prodpre, pedido where Cod_producto=Cod_prese and det_pedido.Id_Ped=$pedido and det_pedido.Id_ped=pedido.Id_pedido order by Nombre;";
			$i=0;
			if ($result=mysql_db_query($bd,$qry))
			{
				while($row=mysql_fetch_array($result))
				{
					$cod=$row['Cod_producto'];
					$cantidad=$row['Can_producto'];
					$precio=$row['Prec_producto'];
					$i=$i+1;
					echo'<tr><td align="center" valign="middle">';
					if ($row['Estado']=='P')
					{
					echo '<form action="updatePedidoVD.php" method="post" name="actualiza'.$i.'">
						<input type="submit" class="formatoBoton" name="Submit" value="Cambiar" >
						<input name="pedido" type="hidden" value="'.$pedido.'">
						<input name="sobre" type="hidden" value="'.$sobre.'">
						<input name="producto" type="hidden" value="'.$cod.'">
						<input name="cantidad" type="hidden" value="'.$cantidad.'">
						<input name="precio" type="hidden" value="'.$precio.'">
						</form>';
					}
					echo '</td>
						<td';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo '><div align="center">'.$i.'</div></td>
						<td';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo '><div align="center">'.$row['Cod_producto'].'</div></td>
					  	<td';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo ' ><div align="left">'.$row['Nombre'].'</div></td>
					  	<td ';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo '><div align="center">'.$row['Can_producto'].'</div></td>
					  	<td';
						if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo ' ><div align="center">$ '.$row['Prec_producto'].'</div></td>
					  	<td align="center">';
					if ($row['Estado']=='P')
					{   
						echo '<form action="delprodPedVD.php" method="post" name="elimina'.$i.'">
						<input type="submit" class="formatoBoton" name="Submit" value="Eliminar">
						<input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'">
						<input name="producto" type="hidden" value="'.$cod.'">
					</form>';
					}
					echo '</td></tr>';
				}
				mysql_close($link);
			}
			?>
		<?php
			$link=conectarServidor();
			$bd="novaquim";
			$qry="select Cod_producto, Can_producto, Producto, Prec_producto, Estado from det_pedido, distribucion, pedido where Cod_producto=Id_distribucion and det_pedido.Id_Ped=$pedido and det_pedido.Id_ped=pedido.Id_pedido order by Producto;";
			if ($result=mysql_db_query($bd,$qry))
			{
				while($row=mysql_fetch_array($result))
				{
					$cod=$row['Cod_producto'];
					$cantidad=$row['Can_producto'];
					$precio=$row['Prec_producto'];
					$i=$i+1;
					echo'<tr>
					<td align="center" valign="middle">';
					if ($row['Estado']=='P')
					{ 
						echo '<form action="updatePedidoVD.php" method="post" name="actualiza'.$i.'">
						<input type="submit" class="formatoBoton" name="Submit" value="Cambiar">
						<input name="pedido" type="hidden" value="'.$pedido.'">
						<input name="sobre" type="hidden" value="'.$sobre.'">
						<input name="producto" type="hidden" value="'.$cod.'">
						<input name="cantidad" type="hidden" value="'.$cantidad.'">
						<input name="precio" type="hidden" value="'.$precio.'">
					</form>';
					}
					echo '</td>
					<td';
					if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
					echo '><div align="center">'.$i.'</div></td>
				  <td';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo '><div align="center">'.$row['Cod_producto'].'</div></td>
				  <td';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo '><div align="left">'.$row['Producto'].'</div></td>
				  <td';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo ' ><div align="center">'.$row['Can_producto'].'</div></td>
				  <td';
						if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo '><div align="center">$ '.$row['Prec_producto'].'</div></td>
				  <td align="center" valign="middle">';
					if ($row['Estado']=='P')
					{ 
					echo '<form action="delprodPedVD.php" method="post" name="elimina'.$i.'">
					<input type="submit" class="formatoBoton" name="Submit" value="Eliminar" >
					<input name="sobre" type="hidden" value="'.$sobre.'">
					<input name="pedido" type="hidden" value="'.$pedido.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					</form>';
					}
					echo '</td></tr>';
				}
			}
			$qry="select Id_ped, Cod_producto, Can_producto, Prec_producto, Producto, Estado from det_pedido, herramientas, pedido where Id_ped=$pedido and Cod_producto>1000000 and Cod_producto=Id_herramienta and det_pedido.Id_ped=pedido.Id_pedido order by Producto;";
			if ($result=mysql_db_query($bd,$qry))
			{
				while($row=mysql_fetch_array($result))
				{
					$cod=$row['Cod_producto'];
					$cantidad=$row['Can_producto'];
					$precio=$row['Prec_producto'];
					$i=$i+1;
					echo'<tr>
					<td align="center" valign="middle">';
					if ($row['Estado']=='P')
					{ 
						echo '<form action="updatePedidoVD.php" method="post" name="actualiza'.$i.'">
						<input type="submit" class="formatoBoton" name="Submit" value="Cambiar">
						<input name="pedido" type="hidden" value="'.$pedido.'">
						<input name="sobre" type="hidden" value="'.$sobre.'">
						<input name="producto" type="hidden" value="'.$cod.'">
						<input name="cantidad" type="hidden" value="'.$cantidad.'">
						<input name="precio" type="hidden" value="'.$precio.'">
					</form>';
					}
					echo '</td>
					<td';
					if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
					echo '><div align="center">'.$i.'</div></td>
				  <td';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo '><div align="center">'.$row['Cod_producto'].'</div></td>
				  <td';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo '><div align="left">'.$row['Producto'].'</div></td>
				  <td';
						if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo ' ><div align="center">'.$row['Can_producto'].'</div></td>
				  <td';
						if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
						echo '><div align="center">$ '.$row['Prec_producto'].'</div></td>
				  <td align="center" valign="middle">';
					if ($row['Estado']=='P')
					{ 
					echo '<form action="delprodPedVD.php" method="post" name="elimina'.$i.'">
					<input type="submit" class="formatoBoton" name="Submit" value="Eliminar" >
					<input name="sobre" type="hidden" value="'.$sobre.'">
					<input name="pedido" type="hidden" value="'.$pedido.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					</form>';
					}
					echo '</td></tr>';
				}
			}
			$qrytot="SELECT SUM(Can_producto*Prec_producto) as Total FROM det_pedido where Id_ped=$pedido;";
			$resulttot=mysql_db_query($bd,$qrytot);
			$row_tot=mysql_fetch_array($resulttot);
			$total=number_format($row_tot['Total'],0,'.',',');
			echo'<tr>
			<td colspan="3"></td>
				  <td colspan="2"><div align="right"><strong>TOTAL PEDIDO</strong></div></td>
				  <td><div align="center"><strong> $ '.$total.'</strong></div></td>
			</tr>';
			mysql_close($link);
			?>

            <tr><td colspan="6">&nbsp;</td></tr>
            <tr>
                <td colspan="4">
                    <form action="Imp_Ord_pedVD.php" method="post" target="_blank">
                    <div align="center">
                    <input name="pedido" type="hidden" value="<?php echo $pedido; ?>">
                    <input type="submit" name="Submit" value="Imprimir" >
                    </div>
                    </form>                </td> 
                <td colspan="2"> 
                    <form action="inv_pedVD.php" method="post">
                    <div align="left">
                    <input name="pedido" type="hidden" value="<?php echo $pedido; ?>">
                    <input type="submit" name="Submit2" value="Analizar" >
                    </div>
                    </form>                </td>
            </tr>           
  </table>
<?php 
		  echo'<input name="Crear" type="hidden" value="0">'; 
		  echo'<input name="pedido" type="hidden" value="'.$pedido.'">'; 
	  ?> 
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div> 
</body>
</html>
	   