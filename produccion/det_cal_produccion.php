<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle Control de Calidad de producto</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>

</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>CONTROL DE CALIDAD POR PRODUCCIÓN</strong></div>
<table border="0" align="center" width="57%" >
<?php
	include "includes/conect.php";
	$link=conectarServidor();
	$Lote=$_POST['Lote'];
	$qryord="select Lote, fechProd, cantidadKg, codResponsable, Nom_produc, nomFormula, nom_personal, Den_min, Den_max ,pH_min, pH_max, Fragancia, Color, Apariencia, Estado 
			from ord_prod, formula, productos, personal
			WHERE ord_prod.idFormula=formula.idFormula and formula.codProducto=productos.Cod_produc
			and ord_prod.codResponsable=personal.Id_personal and Lote=$Lote;";
	$resultord=mysqli_query($link,$qryord);
	$roword=mysqli_fetch_array($resultord);
	if ($roword)
		mysqli_close($link);
	else
	{
		mover("buscarOProd.php","No existe la Orden de Producción");
		mysqli_close($link);
	}
	$est=$roword['Estado'];
	$link=conectarServidor();
	$qrycal="select densidadProd,pHProd,olorProd,colorProd,aparienciaProd,observacionesProd from cal_producto where Lote=$Lote;";
	$resultcal=mysqli_query($link,$qrycal);
	$rowcal=mysqli_fetch_array($resultcal);
	mysqli_close($link);
		
function mover($ruta,$mensaje)
{
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo'<script >
	alert("'.$mensaje.'")
	self.location="'.$ruta.'"
	</script>';
}
?>
<tr>
      <td width="11%">&nbsp;</td>
  </tr>
<tr>
      <td width="11%"><div align="right"><strong>Lote</strong></div></td>
    <td width="50%"><div align="left"><?php echo $Lote;?></div></td>
    <td width="21%"><div align="right"><strong>Fecha de Producción</strong> </div></td>
    <td width="18%"><?php echo $roword['Fch_prod'];?></td>
  </tr>
	<tr>
      <td><div align="right"><strong>Producto</strong></div></td>
      <td><?php echo  $roword['Nom_produc']?></td>
      <td><div align="right"><strong>Cantidad (Kg)</strong></div></td>
      <td><div align="left"><?php echo $roword['Cant_kg']; ?> </div></td
    ></tr>
    <tr>
      <td><div align="right"><strong>Fórmula</strong></div></td>
      <td><?php echo  $roword['Nom_form']?></td>
      <td><div align="right"><strong>Responsable</strong></div></td>
      <td><?php echo  $roword['nom_personal']?></td>
    </tr>
       
</table>

<!--<input type="submit" name='boton' value='Imprimir' onclick='window.print();'> -->
<table border="0" align="center" width="42%">
 <tr>
    <td width="26%"><div align="center"><strong>Propiedad</strong></div></td>
    <td colspan="2"><div align="center"><strong>Especificación</strong></div></td>
    <td width="32%"><div align="center"><strong>Valor / Cumple</strong></div></td>
  </tr>
   <tr>
    <td><div align="center"><strong>pH</strong></div></td>
    <td width="20%"><div align="center"> Min: <?php echo $roword['pH_min']; ?></div></td>
    <td width="22%"><div align="center">Max: <?php echo $roword['pH_max'];?></div></td>
    <td><div align="center"><?php echo $rowcal['ph_prod']; ?></div></td>
  </tr>
   <tr>
    <td><div align="center"><strong>Densidad</strong></div></td>
    <td><div align="center">Min: <?php echo $roword['Den_min']; ?></div></td>
    <td><div align="center">Max: <?php echo $roword['Den_max']; ?></div></td>
    <td><div align="center"><?php echo $rowcal['den_prod']; ?></div></td>
  </tr>
  <tr>
    <td><div align="center"><strong>Olor</strong></div></td>
    <td colspan="2"><div align="center"><?php echo $roword['Fragancia']; ?></div></td>
    <td><div align="center">
	<?php  
	if($rowcal['ol_prod']==0) 
	echo "CUMPLE";
	else
	echo "NO CUMPLE";
	?></div></td>
  </tr>
  <tr>
    <td><div align="center"><strong>Color</strong></div></td>
    <td colspan="2"><div align="center"><?php echo $roword['Color']; ?></div></td>
    <td><div align="center"><?php  
	if($rowcal['col_prod']==0) 
	echo "CUMPLE";
	else
	echo "NO CUMPLE";
	?></div></td>
  </tr>
  <tr>
    <td><div align="center"><strong>Apariencia</strong></div></td>
    <td colspan="2"><div align="center"><?php echo $roword['Apariencia']; ?></div></td>
    <td><div align="center"><?php  
	if($rowcal['ap_prod']==0) 
	echo "CUMPLE";
	else
	echo "NO CUMPLE";
	?></div></td>
  </tr>
    <tr>
    <td><div align="center"><strong>Observaciones</strong></div></td>
    <td colspan="3"><div align="center"><?php echo $rowcal['Obs_prod']; ?></div></td>
  </tr>
<tr>
<tr>


<td colspan="1">
<form action="Imp_Cert_an.php" method="post" target="_blank">
  <div align="center">
    <input name="Lote" type="hidden" value="<?php echo $Lote; ?>">
    <input type="submit" name="Submit" value="Imprimir Certificado" <?php if($est=='P') echo 'disabled';  ?>>
  </div>
  </form>
</td>
<td colspan="2">
<form action="mod_cal_produccion.php" method="post">
  <div align="center">
    <input name="Lote" type="hidden" value="<?php echo $Lote; ?>">
    <input type="submit" name="Submit" value="Modificar Control de Calidad">
  </div>
  </form>
</td>
<td colspan="1">
<form action="Imp_Env_prod.php" method="post" target="_blank">
  <div align="center">
    <input name="Lote" type="hidden" value="<?php echo $Lote; ?>">
    <input type="submit" name="Submit" value="Imprimir Orden Envasado" <?php if($est=='P') echo 'disabled';  ?> >
  </div>
  </form>
</td>

</tr>
</table>
</form>

<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>

</div>
</body>
</html>