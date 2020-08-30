<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
<title>Faltante del Pedido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
	<script  src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue" />
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>FALTANTE DE PEDIDO</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  	
	$pedido=$_POST['pedido'];
	$link=conectarServidor();  
	$bd="novaquim";   
	$qry="Select nomCliente, idPedido, fechaPedido, fechaEntrega, codVendedor, nom_personal, tipo_precio 
		FROM pedido, personal, clientes, tip_precio 
		where codVendedor=Id_personal and idPedido=$pedido and nitCliente=nit_cliente and Id_precio=tipoPrecio;";
	$result=mysql_db_query($bd,$qry);
	$row=mysql_fetch_array($result);
	mysql_close($link);
	 ?>
<table  align="center" border="0" summary="cuerpo">
    <tr>
    	<td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td width="119" ><div align="right"><strong>Fecha Pedido:</strong></div></td>
      <td width="83" colspan="1"  align="center"><div align="left"><?php echo $row['Fech_pedido']; ?></div></td>
  	  <td width="119"  ><div align="right"><strong>No. de Pedido: </strong></div></td>
   	  	<td width="335" colspan="1"  ><div align="left"><?php echo $pedido;?></div></td>
  </tr>
    <tr>
      	<td><div align="right"><strong>Fecha Entrega:</strong></div></td>
      	<td colspan="1" align="center"><div align="left"><?php echo $row['Fech_entrega']; ?></div></td>
      	<td><div align="right"><strong>Cliente:</strong></div></td>
      	<td colspan="1"><div align="left"><?php echo $row['nom_clien']; ?></div></td>
    </tr>
    <tr>
      	<td ><div align="right"><strong>Tipo de Precio:</strong></div></td>
      	<td colspan="1" align="center"><div align="left"><?php echo $row['tipo_precio']; ?></div></td>
      	<td><div align="right"><strong>Vendedor:</strong></div></td>
   	  	<td colspan="1"><?php echo $row['nom_personal']; ?></td>
    </tr>
    <tr>
      	<td height="8" colspan="6"><hr /></td>
    </tr>
    <tr>
      	<td  colspan="5">Productos del Pedido : </td>
    </tr>  
</table>
<table width="624" border="0" align="center">
  <tr>
        <th width="98" align="center">Código</th>
        <th width="432" align="center">Producto </th>
        <th width="80" align="center">Cantidad </th>
  	</tr>
          <?php
			$link=conectarServidor();  
			$bd="novaquim";
			$qry="SELECT Cod_producto, Can_producto, Nombre as Producto from det_pedido, prodpre 
			where Cod_producto=Cod_prese and Id_Ped=$pedido and Cod_producto <100000
			UNION
			select Cod_producto, Can_producto, Producto from det_pedido, distribucion 
			where Cod_producto=Id_distribucion and Id_Ped=$pedido and Cod_producto >=100000;";
			$result=mysql_db_query($bd,$qry);	
			$validar=0;
			while($row=mysql_fetch_array($result, MYSQLI_BOTH))
			{
				$cod=$row['Cod_producto'];
				$cantidad=$row['Can_producto'];
				if ($cod < 100000)
				{
					$qrybus="select codPresentacion as Codigo, SUM(inv_prod) as Inventario from inv_prod WHERE codPresentacion=$cod group by codPresentacion;";
					$resultbus=mysql_db_query($bd,$qrybus);
					$rowbus=mysql_fetch_array($resultbus);
					if ($rowbus)
					{
						if($rowbus['Inventario'] < $cantidad)
						{
							$cantidad=$cantidad- $rowbus['Inventario'];
							echo'<tr>
							<td><div align="center">'.$row['Cod_producto'].'</div></td>
							<td><div align="center">'.$row['Producto'].'</div></td>
							<td><div align="center">'.$cantidad.'</div></td>
							</tr>';
							$validar++;
						}
					}
					else
					{
						echo'<tr>
						<td><div align="center">'.$row['Cod_producto'].'</div></td>
						<td><div align="center">'.$row['Producto'].'</div></td>
						<td><div align="center">'.$cantidad.'</div></td>
						</tr>';
						$validar++;
					}
				}
				else
				{
					$qrybus="SELECT Id_distribucion AS Codigo, invDistribucion as Inventario from inv_distribucion WHERE Id_distribucion=$cod;";
					$resultbus=mysql_db_query($bd,$qrybus);
					$rowbus=mysql_fetch_array($resultbus, MYSQLI_BOTH);
					if ($rowbus)
					{
						if($rowbus['Inventario'] < $cantidad)
						{
							$cantidad=$cantidad- $rowbus['Inventario'];
							echo'<tr>
							<td><div align="center">'.$row['Cod_producto'].'</div></td>
							<td><div align="center">'.$row['Producto'].'</div></td>
							<td><div align="center">'.$cantidad.'</div></td>
							</tr>';
							$validar++;
						}
					}
					else
					{
						echo'<tr>
						<td><div align="center">'.$row['Cod_producto'].'</div></td>
						<td><div align="center">'.$row['Producto'].'</div></td>
						<td><div align="center">'.$cantidad.'</div></td>
						</tr>';
						$validar++;
					}

				}
			}
			if ($validar==0)
			{
				$qryup="UPDATE pedido SET Estado='L' WHERE idPedido=$pedido;";
				$resultup=mysql_db_query($bd,$qryup);	
			}
			mysql_close($link);
			?>
</table>
<table width="63%" border="0" align="center">
<tr> 
        <td colspan="2"><div align="center"><form action="det_pedido.php" method="post">
                                      <input name="pedido" type="hidden" value="<?php echo $pedido; ?>"/>
                                      <input name="Crear" type="hidden" value="5"/>
                    <input type="submit" name="Submit2" value="Volver" />
                    
                    </form>                </div></td>
  </tr>
</table> 
</div>
</body>
</html>
	   