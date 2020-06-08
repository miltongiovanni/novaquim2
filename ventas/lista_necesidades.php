<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
<title>Faltante del Pedido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue" >
	<script  src="../js/validar.js"></script>
	<script  src="scripts/block.js"></script>
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>FALTANTE DE LOS PEDIDOS</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  	
	if($_POST['seleccion1'])    //and (Id_pedido=915 or Id_pedido=916)
	{
	  	$opciones_clien = implode(",", $_POST['seleccion1']);
		$qryd="Select nom_clien, Id_pedido, Fech_pedido, Fech_entrega, Cod_vend, nom_personal FROM pedido, personal, clientes where Cod_vend=Id_personal  and nit_clien=nit_cliente and (";
		//print_r($opciones_prod);
		$a=count($_POST['seleccion1']);
		for ($j = 0; $j < $a; $j++) 
		{
			$qryd=$qryd."Id_pedido=".($_POST['seleccion1'][$j]);
			if ($j<=($a-2))
				$qryd=$qryd." or ";	
		} 
		$qryd=$qryd.") order by Fech_entrega";
		$link=conectarServidor();  
		$result=mysqli_query($link,$qryd);
		echo '<table  align="center" border="0" summary="cuerpo" width="80%">
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr class="formatoDatos">
			<td width="12%"><div align="center"><strong>No. de Pedido</strong></div></td>
			<td width="44%"><div align="center"><strong>Cliente</strong></div></td>
			<td width="13%" ><div align="center"><strong>Fecha Pedido</strong></div></td>
			<td width="12%"><div align="center"><strong>Fecha Entrega</strong></div></td>
			<td width="19%"><div align="center"><strong>Vendedor</strong></div></td>
		</tr>';
		while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
		{
			echo '<tr class="formatoDatos">
			<td><div align="center">';
			echo $row['Id_pedido']; 
			echo '</div></td>
			<td><div align="center">';
			echo $row['nom_clien']; 
			echo '</div></td>
			<td><div align="center">';
			echo $row['Fech_pedido']; 
			echo '</div></td>
			<td><div align="center">';
			echo $row['Fech_entrega']; 
			echo '</div></td>
			<td><div align="center">';
			echo $row['nom_personal']; 
			echo '</div></td>
			</tr>';
		}
		echo '<tr class="formatoDatos">
      	<td colspan="6"><hr /></td>
    	</tr>
		</table>';
		echo '<table border="0" align="center" width="80%" summary="detalle">
		<tr class="formatoDatos">
				<th width="12%" align="center">Código</th>
				<th width="62%" align="center">Producto </th>
				<th width="12%" align="center">Cantidad </th>
				<th width="14%" align="center">Precio</th>
		</tr>';
		$qry_prod="SELECT Cod_producto, SUM(Can_producto) as Cantidad, Nombre as Producto, Prec_producto from det_pedido, prodpre where Cod_producto=Cod_prese and Cod_producto <100000 and (";
		$a=count($_POST['seleccion1']);
		for ($j = 0; $j < $a; $j++) 
		{
			$qry_prod=$qry_prod."Id_Ped=".($_POST['seleccion1'][$j]);
			if ($j<=($a-2))
				$qry_prod=$qry_prod." or ";	
		} 
		$qry_prod=$qry_prod.") group by Cod_producto order by Producto";
		$result_prod=mysqli_query($link,$qry_prod);	
		while($row_prod=mysqli_fetch_array($result_prod, MYSQLI_BOTH))
		{
			$cod=$row_prod['Cod_producto'];
			$cantidad=$row_prod['Cantidad'];
			$qrybus="select codPresentacion as Codigo, SUM(invProd) as Inventario from inv_prod WHERE codPresentacion=$cod group by codPresentacion;";
			$resultbus=mysqli_query($link,$qrybus);
			$rowbus=mysqli_fetch_array($resultbus);
			if ($rowbus)
			{
			  if($rowbus['Inventario'] < $cantidad)
			  {
				  $cantidad=$cantidad- $rowbus['Inventario'];
				  echo'<tr class="formatoDatos">
				  <td><div align="center">'.$row_prod['Cod_producto'].'</div></td>
				  <td><div align="left">'.$row_prod['Producto'].'</div></td>
				  <td><div align="center">'.$cantidad.'</div></td>
				  <td><div align="center">'.$row_prod['Prec_producto'].'</div></td>
				  </tr>';
			  }
		  	}
		  	else
		  	{
			  echo'<tr class="formatoDatos">
			  <td><div align="center">'.$row_prod['Cod_producto'].'</div></td>
			  <td><div align="left">'.$row_prod['Producto'].'</div></td>
			  <td><div align="center">'.$cantidad.'</div></td>
			  <td><div align="center">'.$row_prod['Prec_producto'].'</div></td>
			  </tr>';
		  	}
		}
		//PRODCUTOS DE DISTRIBUCION
		$qry_dist="select Cod_producto, sum(Can_producto) as Cantidad, Producto, Prec_producto from det_pedido, distribucion where Cod_producto=Id_distribucion and Cod_producto >=100000 and (";
		$a=count($_POST['seleccion1']);
		for ($j = 0; $j < $a; $j++) 
		{
			$qry_dist=$qry_dist."Id_Ped=".($_POST['seleccion1'][$j]);
			if ($j<=($a-2))
				$qry_dist=$qry_dist." or ";	
		} 
		$qry_dist=$qry_dist.") group by Cod_producto order by Producto";
		$result_dist=mysqli_query($link,$qry_dist);	
		while($row_dist=mysqli_fetch_array($result_dist, MYSQLI_BOTH))
		{
			$cod=$row_dist['Cod_producto'];
			$cantidad=$row_dist['Cantidad'];	
			$qrybus="SELECT Id_distribucion AS Codigo, invDistribucion as Inventario from inv_distribucion WHERE Id_distribucion=$cod;";
			$resultbus=mysqli_query($link,$qrybus);
			$rowbus=mysqli_fetch_array($resultbus);
			if ($rowbus)
			{
				if($rowbus['Inventario'] < $cantidad)
				{
					$cantidad=$cantidad- $rowbus['Inventario'];
					echo'<tr class="formatoDatos">
					<td><div align="center">'.$row_dist['Cod_producto'].'</div></td>
					<td><div align="left">'.$row_dist['Producto'].'</div></td>
					<td><div align="center">'.$cantidad.'</div></td>
					<td><div align="center">'.$row_dist['Prec_producto'].'</div></td>
					</tr>';
				}
			}
			else
			{
				echo'<tr class="formatoDatos">
				<td><div align="center">'.$row_dist['Cod_producto'].'</div></td>
				<td><div align="left">'.$row_dist['Producto'].'</div></td>
				<td><div align="center">'.$cantidad.'</div></td>
				<td><div align="center">'.$row_dist['Prec_producto'].'</div></td>
				</tr>';
			}
		}
	}  
	else
	{
		//echo "no escogió productos de novaquim <br>";Id_Ped=915 or Id_Ped=916)
		echo' <script >
		alert("Debe escoger algún pedido");
		history.back();
		</script>';
	}
	echo '</table>';
	mysqli_close($link);
	 ?>

<table width="63%" border="0" align="center">
<tr> 
        <td colspan="2">
<div align="center"><form action="lista_necesidadesXLS.php" method="post" target="_blank">
                                      <input name="pedidos" type="hidden" value="<?php echo $opciones_clien; ?>"/>
                                      <input name="Crear" type="hidden" value="5"/>
                    <input type="submit" name="Submit2" value="Exportar a Excel" />
                    
                    </form>                </div></td>
  </tr>
</table> 
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>
	   