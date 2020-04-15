<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Ingreso de Compra de Materia Prima</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue" />
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div align="center"><img src="images/LogoNova.JPG"/></div>
<?php
include "includes/conect.php";
$Crear=$_POST['Crear'];
if($Crear==0)
{
   $Lote=$_POST['Lote'];
}
else
{
	//echo "NO ESTA CREANDO FACTURA";
	$Lote=$_POST['Lote'];
	$cod_prodpre=$_POST['cod_prodpre'];
	$cantidad=$_POST['Cant'];
	$link=conectarServidor();   
	$bd="novaquim";   
	//SE INSERTA LA CANTIDAD DE PRODUCTO ENVASADO
	$qryins="insert into envasado (Lote, Con_prese, Can_prese) values ($Lote, $cod_prodpre, $cantidad)";
	$resultins=mysql_db_query($bd,$qryins);
	mysql_close($link);
} 

function mover_pag($ruta,$nota)
{	
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo' <script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
?>
  <table width="66%"  align="center" border="0">
    <tr>
      <td>&nbsp;</td>
      <td width="19%">&nbsp;</td>
      <td width="21%">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div align="left" class="titulo"><strong> Envasado de Productos por Lote: </strong></div></td>
      <td width="19%"><div align="right"><strong>No. de Lote</strong> </div></td>
      <td width="19%"><div align="left"><?php echo $Lote;?></div></td>
    </tr>
    <tr>
      <td colspan="5"><hr /></td>
    </tr>
    <?php
		$link=conectarServidor();
		$bd="novaquim";
		$qry="SELECT Lote, Fch_prod, Cant_kg, ord_prod.Cod_prod as Codigo, Nom_produc, nom_personal 
		FROM ord_prod, productos, personal
		where Lote=$Lote and ord_prod.Cod_prod=productos.Cod_produc AND ord_prod.Cod_persona=personal.Id_personal;";
		$result=mysql_db_query($bd,$qry);
		$row=mysql_fetch_array($result);
		$cod_prod=$row['Codigo'];
		mysql_close($link);
	 ?>
    <tr>
      <td width="22%"><strong>Producto</strong></td>
      <td colspan="2"><?php echo  $row['Nom_produc']; ?></td>
      <td><strong>Cantidad (Kg)</strong></td>
      <td><?php echo  $row['Cant_kg']?></td>
    </tr>
    <tr>
      <td ><strong>Fecha de Producci&oacute;n</strong></td>
      <td colspan="2"><?php echo $row['Fch_prod']; ?></td>
      <td><strong>Responsable</strong></td>
      <td><div align="left"><?php echo $row['nom_personal']; ?> </div></td>
    </tr>
    <tr>
      <td colspan="5"><hr /></td>
    </tr>
    <tr>
      <td height="8" colspan="5"><hr /></td>
    </tr>
    <tr>
      <td  colspan="5">Detalle de Envasado : </td>
    </tr>
    <tr>
      <td colspan="5">
      <table width="100%" border="1" align="center">
          <tr>
            <th width="10%"></th>
            <th width="18%">C&oacute;digo</th>
            <th width="62%">Producto por Presentaci&oacute;n</th>
            <th width="20%">Cantidad </th>
          </tr>
          <?php
			$link=conectarServidor();
			$bd="novaquim";
			$qry="SELECT Con_prese, Nombre, Can_prese FROM envasado, prodpre WHERE Con_prese=Cod_prese and lote=$Lote;";
			$result=mysql_db_query($bd,$qry);
			while($row=mysql_fetch_array($result))
			{
			echo'<tr>
				<td>
					<form action="updateEnvasado.php" method="post" name="actualiza">
						<input type="submit" name="Submit" value="Cambiar" />
						<input name="Lote" type="hidden" value="'.$Lote.'"/>
						<input name="Presentacion" type="hidden" value="'.$row['Con_prese'].'"/>
						<input name="Cantidad" type="hidden" value="'.$row['Can_prese'].'"/>
					</form>
				</td>
			  <td><div align="center">'.$row['Con_prese'].'</div></td>
			  <td><div align="center">'.$row['Nombre'].'</div></td>
			  <td><div align="center">'.$row['Can_prese'].'</div></td>
			</tr>';
			}
			mysql_close($link);
			?>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5"><hr /></td>
    </tr>
    <tr>
      <td><div align="center"></div></td>
      <td><div align="center"></div></td>
      <td><div align="center"></div></td>
      <td><div align="right"></div></td>
    </tr>
  </table>
  </div>
</form>
<table width="27%" border="0" align="center">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Terminar"></div></td>
    </tr>
</table> 
</body>
</html>