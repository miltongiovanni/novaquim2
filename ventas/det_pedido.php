<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Ingreso de Productos Hoja de Pedido</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
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
<div id="saludo1"><strong>DETALLE DEL PEDIDO</strong></div> 
<?php
	include "includes/conect.php";
	include "includes/calcularDias.php";
	$encabfecha='USUARIO: '.$_SESSION['User'].' |   FECHA: '.date('d-m-Y  h:i:s');
	date_default_timezone_set('America/Bogota');
	//echo  $encabfecha;
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	function mover($ruta,$mensaje)
	{
		//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
		echo'<script >
		alert("'.$mensaje.'");
		self.location="'.$ruta.'";
		</script>';
	} 
	$link=conectarServidor();  
	$fecha_actual=date("Y")."-".date("m")."-".date("d");
	if ($Crear == 3)
	{
		$dias_p=Calc_Dias($FchPed,$fecha_actual);
		$dias_ep=Calc_Dias($FchEnt,$FchPed);
		$dias_e=Calc_Dias($FchEnt,$fecha_actual);
		if(($dias_p>=0)&&($dias_e>=0)&&($dias_ep>=0))
		{		  
		  $qrycam="select MAX(idPedido) AS Pedido from pedido;";
		  $resultqrycam=mysqli_query($link,$qrycam);
		  $row_cam=mysqli_fetch_array($resultqrycam);
		  $pedido=$row_cam['Pedido']+1;
		  $qryins_comp="insert into pedido (idPedido, Nit_cliente, fechaPedido, fechaEntrega, tipoPrecio, Estado, idSucursal) 
					    values ($pedido, '$cliente', '$FchPed', '$FchEnt', $tip_precio, 'P', $sucursal)";
		  $resultins_prod=mysqli_query($link,$qryins_comp);	
		  $qrycam="select MAX(idPedido) AS Pedido from pedido;";
		  $resultqrycam=mysqli_query($link,$qrycam);
		  $row_cam=mysqli_fetch_array($resultqrycam);
		  $pedido=$row_cam['Pedido'];
		  mysqli_close($link);
		  echo '<form method="post" action="det_pedido.php" name="form3">';
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
	if ($Crear==6)
	{
		  $qry_upd="update pedido set Nit_cliente='$cliente', fechaPedido='$FchPed', fechaEntrega='$FchEnt', tipoPrecio=$tip_precio, Estado='P', idSucursal=$sucursal where idPedido=$pedido";
		  //echo $qry_upd;
		  $result_upd=mysqli_query($link,$qry_upd);	
		  mysqli_close($link);
		  echo '<form method="post" action="det_pedido.php" name="form3">';
		  echo'<input name="Crear" type="hidden" value="5">'; 
		  echo'<input name="sobre" type="hidden" value="'.$sobre.'">'; 
		  echo'<input name="pedido" type="hidden" value="'.$pedido.'">'; 
		  echo '</form>';
		  echo'<script >
				document.form3.submit();
				</script>';
		
	}
	if($Crear==1)
	{
		//MIRA CUANTOS PRODUCTOS HAY EN EL PEDIDO  --- DEBE SER MÁXIMO 40 PRODUCTOS
		$qry1="select * from det_pedido where Id_ped=$pedido";
		$result1=mysqli_query($link,$qry1);
		$items=mysqli_num_rows ($result1);
		if ($items<40)
		{	
			//PRECIOS DE PRODUCTOS DE LA EMPRESA
			$qryins_p="insert into det_pedido (Id_ped, Cod_producto, Can_producto, Prec_producto) values ($pedido, $cod_producto, $cantidad, 0)";
			$resultins_p=mysqli_query($link,$qryins_p);
			$qrybus="select idPedido, tipoPrecio, Cod_producto, fabrica, distribuidor, detal, mayor, super from pedido, det_pedido, prodpre 
			where idPedido=$pedido AND idPedido=Id_ped And Cod_producto <100000 and Cod_producto=Cod_prese and Cod_producto=$cod_producto;";
			$resultbus=mysqli_query($link,$qrybus);
			$rowbus=mysqli_fetch_array($resultbus);
			switch ($rowbus['tip_precio']) 
			{
				case 1:
					$precio=$rowbus['fabrica']*(1+$sobre/100);
					break;
				case 2:
					$precio=$rowbus['distribuidor']*(1+$sobre/100);
					break;
				case 3:
					$precio=$rowbus['detal']*(1+$sobre/100);
					break;
				case 4:
					$precio=$rowbus['mayor']*(1+$sobre/100);
					break;
				case 5:
					$precio=$rowbus['super']*(1+$sobre/100);
					break;	
			}
			$qryup="update det_pedido set Prec_producto=$precio where Id_ped=$pedido and Cod_producto=$cod_producto;";
			$resultup=mysqli_query($link,$qryup);
			
		}
		else
		{
			echo'<script >
			alert("Máximo 40 productos por pedido")
			</script>';	
			mysqli_close($link);
		}
		mysqli_close($link);
	}
	if($Crear==2)
	{
		//MIRA CUANTOS PRODUCTOS HAY EN EL PEDIDO  --- DEBE SER MÁXIMO 40 PRODUCTOS
		$qry1="select * from det_pedido where Id_ped=$pedido";
		$result1=mysqli_query($link,$qry1);
		$items=mysqli_num_rows ($result1);
		if ($items<40)
		{	
			//PRECIOS DE PRODUCTOS DE DISTRIBUCIÓN
			$qryins_d="insert into det_pedido (Id_ped, Cod_producto, Can_producto, Prec_producto) values ( $pedido, $cod_producto, $cantidad, 0)";
			$resultins_d=mysqli_query($link,$qryins_d);
			$qrybus="select precio_vta from det_pedido, distribucion where Id_ped=$pedido and Cod_producto=$cod_producto and Cod_producto=Id_distribucion;";
			$resultbus=mysqli_query($link,$qrybus);
			$rowbus=mysqli_fetch_array($resultbus);
			$precio=$rowbus['precio_vta']*(1+$sobre/100);	
			$qryup="update det_pedido set Prec_producto=$precio where Id_ped=$pedido and Cod_producto=$cod_producto;";
			//echo $qryup;
			$resultup=mysqli_query($link,$qryup);
		}
		else
		{
			echo'<script >
			alert("Máximo 40 productos por pedido")
			</script>';	
		}
		mysqli_close($link);
	}
	if($Crear==4)
	{
		//MIRA CUANTOS PRODUCTOS HAY EN EL PEDIDO  --- DEBE SER MÁXIMO 40 PRODUCTOS
		$qry1="select * from det_pedido where Id_ped=$pedido";
		$result1=mysqli_query($link,$qry1);
		$items=mysqli_num_rows ($result1);
		if ($items<40)
		{	
			//SERVICIOS OFRECIDOS	
			$qryins_d="insert into det_pedido (Id_ped, Cod_producto, Can_producto, Prec_producto) values ($pedido, $cod_producto, $cantidad, $precio)";
			$resultins_d=mysqli_query($link,$qryins_d);
		}
		else
		{
			echo'<script >
			alert("Máximo 40 productos por pedido")
			</script>';	
		}
		mysqli_close($link);
	}
	$link=conectarServidor(); 
	$qry2="Select nomCliente, idPedido, fechaPedido, fechaEntrega, codVendedor, nom_personal, tipo_precio, pedido.Estado, Nom_sucursal, Dir_sucursal, telCliente 
		FROM pedido, personal, clientes, tip_precio, clientes_sucursal 
		where codVendedor=Id_personal and idPedido=$pedido and clientes.nitCliente=nit_cliente and Id_precio=tipoPrecio and idSucursal=Id_sucursal and clientes_sucursal.Nit_clien=Nit_cliente";
	$result2=mysqli_query($link,$qry2);
	if ($row2=mysqli_fetch_array($result2))
	{
		mysqli_close($link);
	}
	else
	{
		mysqli_close($link);
		mover("buscarPedido.php","No existe la Orden de Pedido");
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
      <td align="right"  ><strong>Teléfono</strong></td>
   	  <td colspan="1" align="left"><?php echo $row2['Tel_clien']; ?></td>
    </tr>
    <tr>
      	<td align="right"><strong>Lugar de Entrega</strong></td>
      	<td colspan="1" align="left"><?php echo $row2['Nom_sucursal']; ?></td>
      	
        
      <td align="right"  ><strong>Dirección de Entrega</strong></td>
   	  <td colspan="2" align="left"><?php echo $row2['Dir_sucursal']; ?></td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    </table>
      
    <?php
    $link=conectarServidor(); 
	if ($row2['Estado']=='P')
	{
		echo '<form method="post" action="det_pedido.php" name="form1">
 			<table border="0"  align="center" cellpadding="0" summary="cuerpo1"> 
			<tr>
				<td colspan="4"><div align="center"><strong>Productos Novaquim</strong></div></td>
				<td colspan="1"><div align="center"><strong>Unidades</strong></div></td>
				<td colspan="1"><div align="center"></div></td>
			</tr>
			<tr>
				<td colspan="4"><div align="center">';
		echo'<select name="cod_producto">';
			$result=mysqli_query($link,"SELECT Cod_prese, Nombre FROM prodpre, productos where prodpre.Cod_produc=productos.Cod_produc and prod_activo=0 and pres_activo=0 order by Nombre;");
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
            }
            echo'</select>';
			echo '</div></td>
			<td colspan="1"><div align="center"><input name="cantidad" type="text" size=7 onKeyPress="return aceptaNum(event)"></div></td>';
			echo '<td colspan="1" align="center"><input name="Crear" type="hidden" value="1"><input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'"><input name="submit" class="formatoBoton1" onclick="return Enviar(this.form)" type="submit"  value="Continuar" ></td>';
			echo '</table> </form>
			 <form method="post" action="det_pedido.php" name="form2">
			 <table border="0"  align="center" cellpadding="0" summary="cuerpo1">
			<tr>
				<td colspan="4"><div align="center"><strong>Productos Distribución</strong></div></td>
				<td colspan="1"><div align="center"><strong>Unidades</strong></div></td>
			</tr>
			<tr>
				<td colspan="4"><div align="center">';
			echo'<select name="cod_producto">';
			$result=mysqli_query($link,"select Id_distribucion, Producto from distribucion where Activo=0 order by Producto;");
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
            }
            echo '</select>';
			echo '</div></td>
				<td colspan="1"><div align="center"><input name="cantidad" type="text" size=7 onKeyPress="return aceptaNum(event)"  ></div></td>';
			echo '<td align="center"><input name="Crear" type="hidden" value="2"><input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'"><input name="submit" onclick="return Enviar(this.form)" class="formatoBoton1" type="submit"  value="Continuar" ></td>';
		  	echo '</table></form>';
			echo '<form method="post" action="det_pedido.php" name="form3">
 			<table border="0"  align="center" cellpadding="0" summary="cuerpo1"> 
			<tr>
				<td colspan="4"><div align="center"><strong>Servicios</strong></div></td>
				<td colspan="1"><div align="center"><strong>Cantidad</strong></div></td>
				<td colspan="1"><div align="center"><strong>Precio</strong></div></td>
				<td colspan="1"><div align="center"></div></td>
			</tr>
			<tr>
				<td colspan="4"><div align="center">';
		echo'<select name="cod_producto">';
			$result=mysqli_query($link,"select IdServicio, DesServicio from servicios where Activo=0 order by DesServicio;");
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['IdServicio'].'>'.$row['DesServicio'].'</option>';
            }
            echo'</select>';
			echo '</div></td>
			<td colspan="1"><div align="center"><input name="cantidad" type="text" size=7 onKeyPress="return aceptaNum(event)"></div></td>';
			echo '<td colspan="1"><div align="center"><input name="precio" type="text" size=7 onKeyPress="return aceptaNum(event)"></div></td>';
			echo '<td colspan="1" align="center"><input name="Crear" type="hidden" value="4"><input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'"><input name="submit" class="formatoBoton1" onclick="return Enviar(this.form)" type="submit"  value="Continuar" ></td>';
			echo '</table> </form>';
			mysqli_close($link);
		}
	?>
<table border="0" align="center" cellpadding="0" cellspacing="0" summary="cuerpo">
          <tr>
          	<th width="56"></th>
          	<th width="41" align="center"><strong>Item</strong></th>
            <th width="67" align="center"><strong>Código</strong></th>
            <th width="417" align="center"><strong>Producto </strong></th>
			<th width="86" align="center" ><strong>Cantidad </strong></th>
            <th width="94" align="center"><strong>Precio </strong></th>
            <th width="55"></th>
  </tr>
          <?php
			$link=conectarServidor();
			$qry="select Cod_producto, Can_producto, Nombre, Prec_producto, Estado from det_pedido, prodpre, pedido where Cod_producto=Cod_prese and det_pedido.Id_Ped=$pedido and det_pedido.Id_ped=pedido.idPedido order by Nombre;";
			$i=0;
			$a=0;
			if ($result=mysqli_query($link,$qry))
			{
				while($row=mysqli_fetch_array($result))
				{
					$cod=$row['Cod_producto'];
					$cantidad=$row['Can_producto'];
					$precio=$row['Prec_producto'];
					$i=$i+1;
					echo'<tr><td align="center" valign="middle">';
					if ($row['Estado']=='P')
					{
					echo '<form action="updatePedido.php" method="post" name="actualiza'.$i.'">
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
						echo '<form action="delprodPed.php" method="post" name="elimina'.$i.'">
						<input type="submit" class="formatoBoton" name="Submit" value="Eliminar">
						<input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'">
						<input name="producto" type="hidden" value="'.$cod.'">
					</form>';
					}
					echo '</td></tr>';
				}
				mysqli_close($link);
			}
			?>
		<?php
			$link=conectarServidor();
			$qry="select Cod_producto, Can_producto, Producto, Prec_producto, Estado from det_pedido, distribucion, pedido where Cod_producto=Id_distribucion and det_pedido.Id_Ped=$pedido and det_pedido.Id_ped=pedido.idPedido order by Producto;";
			if ($result=mysqli_query($link,$qry))
			{
				while($row=mysqli_fetch_array($result))
				{
					$cod=$row['Cod_producto'];
					$cantidad=$row['Can_producto'];
					$precio=$row['Prec_producto'];
					$i=$i+1;
					echo'<tr>
					<td align="center" valign="middle">';
					if ($row['Estado']=='P')
					{ 
						echo '<form action="updatePedido.php" method="post" name="actualiza'.$i.'">
						<input type="submit" class="formatoBoton" name="Submit"  value="Cambiar">
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
					echo '<form action="delprodPed.php" method="post" name="elimina'.$i.'">
					<input type="submit" class="formatoBoton" class="formatoBoton" name="Submit" value="Eliminar" >
					<input name="sobre" type="hidden" value="'.$sobre.'">
					<input name="pedido" type="hidden" value="'.$pedido.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					</form>';
					}
					echo '</td></tr>';
				}
			}
			$qry="select Cod_producto, DesServicio as Producto, Can_producto, Prec_producto, Estado from det_pedido, servicios, pedido  where Cod_producto=IdServicio and Id_ped=idPedido and Id_ped=$pedido order by DesServicio;";
			if ($result=mysqli_query($link,$qry))
			{
				while($row=mysqli_fetch_array($result))
				{
					$cod=$row['Cod_producto'];
					$cantidad=$row['Can_producto'];
					$precio=$row['Prec_producto'];
					$i=$i+1;
					echo'<tr>
					<td align="center" valign="middle">';
					if ($row['Estado']=='P')
					{ 
						echo '<form action="updatePedido.php" method="post" name="actualiza'.$i.'">
						<input type="submit" class="formatoBoton" name="Submit"  value="Cambiar">
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
					echo '<form action="delprodPed.php" method="post" name="elimina'.$i.'">
					<input type="submit" class="formatoBoton" class="formatoBoton" name="Submit" value="Eliminar" >
					<input name="sobre" type="hidden" value="'.$sobre.'">
					<input name="pedido" type="hidden" value="'.$pedido.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					</form>';
					}
					echo '</td></tr>';
				}
			}
			$qrytot="SELECT SUM(Can_producto*Prec_producto) as Total FROM det_pedido where Id_ped=$pedido;";
			$resulttot=mysqli_query($link,$qrytot);
			$row_tot=mysqli_fetch_array($resulttot);
			$total=number_format($row_tot['Total'],0,'.',',');
			echo'<tr>
			<td colspan="3"></td>
				  <td colspan="2"><div align="right"><strong>TOTAL PEDIDO</strong></div></td>
				  <td><div align="center"><strong> $ '.$total.'</strong></div></td>
			</tr>';
			mysqli_close($link);
			?>

            <tr><td colspan="6">&nbsp;</td></tr>
            <tr>
                <td colspan="3">
                    <form action="Ord_ped_xls.php" method="post" target="_blank">
                    <div align="center">
                    <input name="pedido" type="hidden" value="<?php echo $pedido; ?>">
                    <input name="Submit" type="submit" class="formatoBoton1" value="Exportar a Excel" >
                    </div>
                    </form>                </td> 
                    <td colspan="1">
                    <form action="Imp_Ord_ped.php" method="post" target="_blank">
                    <div align="center">
                    <input name="pedido" type="hidden" value="<?php echo $pedido; ?>">
                    <input name="Submit" type="submit" class="formatoBoton1" value="Imprimir" >
                    </div>
                    </form>                </td> 
                <td colspan="2"> 
                    <form action="inv_ped.php" method="post">
                    <div align="left">
                    <input name="pedido" type="hidden" value="<?php echo $pedido; ?>">
                    <input name="sobre" type="hidden" value="<?php echo $sobre; ?>">
                    <input name="Submit2" type="submit" class="formatoBoton1" value="Analizar"
                     <?php
					if ((md5(1)!=$_SESSION['Perfil'])&&(md5(2)!=$_SESSION['Perfil']))
					echo 'disabled';
					?>
                     >
                    </div>
                    </form>                </td>
            </tr>           
  </table>
<p>
  <?php 
		  echo'<input name="Crear" type="hidden" value="0">'; 
		  echo'<input name="pedido" type="hidden" value="'.$pedido.'">'; 
	  ?> &nbsp;
</p>

<div align="center"><input type="button" class="formatoBoton1" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div> 
</body>
</html>
	   