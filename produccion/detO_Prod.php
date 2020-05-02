<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle Orden de Producci&oacute;n</title>
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
<div id="saludo1"><strong>USO DE MATERIA PRIMA POR PRODUCCI&Oacute;N</strong></div>
<table border="0" align="center">
<?php
	include "includes/conect.php";
	$link=conectarServidor();
	$Lote=$_POST['Lote'];
	$qryord="select Lote, Fch_prod, Cant_kg, Cod_persona, Nom_produc, Nom_form, nom_personal 
			from ord_prod, formula, productos, personal
			WHERE ord_prod.Id_form=formula.Id_form and formula.Cod_prod=productos.Cod_produc
			and ord_prod.Cod_persona=personal.Id_personal and Lote=$Lote;";
	$resultord=mysqli_query($link,$qryord);
	$roword=mysqli_fetch_array($resultord);
	if ($roword)
		mysqli_close($link);
	else
	{
		mover("buscarOProd.php","No existe la Orden de Producción");
		mysqli_close($link);
	}
		
		
function mover($ruta,$nota)
{
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo'<script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
?>
<tr>
      <td width="82"><div align="right"><strong>Lote</strong></div></td>
    <td width="341"><div align="left"><?php echo $Lote;?></div></td>
    <td width="156"><div align="right"><strong>Fecha de Producci&oacute;n</strong> </div></td>
    <td width="234"><?php echo $roword['Fch_prod'];?></td>
  </tr>
	<tr>
      <td><div align="right"><strong>Producto</strong></div></td>
      <td><?php echo  $roword['Nom_produc']?></td>
      <td><div align="right"><strong>Cantidad (Kg)</strong></div></td>
      <td><div align="left"><?php echo $roword['Cant_kg']; ?> </div></td
    ></tr>
    <tr>
      <td><div align="right"><strong>F&oacute;rmula</strong></div></td>
      <td><?php echo  $roword['Nom_form']?></td>
      <td><div align="right"><strong>Responsable</strong></div></td>
      <td><?php echo  $roword['nom_personal']?></td>
    </tr>
</table>
<!--<input type="submit" name='boton' value='Imprimir' onclick='window.print();'> -->
<table width="57%" border="0" align="center">
 <tr>
    <td width="10%"><div align="left"></div></td>
    <td width="10%"><div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="10%"><div align="center"><strong>C&oacute;digo Nuevo</strong></div></td>
    <td width="45%"><div align="center"><strong>Materia Prima</strong></div></td>
    <td width="13%"><div align="center"><strong>Lote MP</strong></div></td>
    <td width="22%"><div align="center"><strong>MP Utilizada (Kg)</strong></div></td>
  </tr>
  <?php
	$link=conectarServidor();
	$Lote=$_POST['Lote'];
	$qry="SELECT Nom_mprima, Can_mprima, det_ord_prod.Cod_mprima as codigo, Lote_MP, Cod_nvo_mprima, alias  
	FROM det_ord_prod, mprimas where Lote=$Lote AND det_ord_prod.Cod_mprima=mprimas.Cod_mprima order by Orden;";
	
	$result=mysqli_query($link,$qry);
	//valign="middle"
	while($row=mysqli_fetch_array($result))
	{
	$codmp=$row['codigo'];
	$codmp_nvo=$row['Cod_nvo_mprima'];
	$mprima=$row['alias'];
	$gasto=$row['Can_mprima'];
	$lote_mp=$row['Lote_MP'];
	echo '<tr>
	<td align="center" valign="middle"> 
		<form action="updateO_prod.php" method="post" name="actualiza">
			<input type="submit" name="Submit" value="Cambiar" >
			<input name="Lote" type="hidden" value="'.$Lote.'">
			<input name="mprima" type="hidden" value="'.$codmp.'">
			<input name="lote_mp" type="hidden" value="'.$lote_mp.'">
			<input name="gasto" type="hidden" value="'.$gasto.'">
		</form>
	</td>
	<td align="center">'.$codmp.'</td>
	<td align="center">'.$codmp_nvo.'</td>
	<td align="left">'.$mprima.'</td>
	<td align="left">'.$lote_mp.'</td>
	<td align="center">'.$gasto.'</td></tr>';
	}
	mysqli_close($link);
?>
<tr>
<form action="Imp_Ord_prod.php" method="post" target="_blank">

<td colspan="5">
  <div align="right">
    <input name="Lote" type="hidden" value="<?php echo $Lote; ?>">
    <input type="submit" name="Submit" value="Imprimir">
  </div>
</td>
</form>
</tr>
</table>

<table width="27%" border="0" align="center">
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Terminar"></div></td>
    </tr>
</table> 

</div>
</body>
</html>