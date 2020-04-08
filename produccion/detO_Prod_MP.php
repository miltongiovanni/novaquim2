<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detalle Orden de Producci&oacute;n de Color</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/javascript" src="scripts/block.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>USO DE MATERIA PRIMA POR PRODUCCI&Oacute;N DE MATERIA PRIMA</strong></div>
<table border="0" align="center">
    <?php
		include "includes/conect.php";
		$link=conectarServidor();
		$Lote=$_POST['Lote'];
	  	$qryord="SELECT Lote_mp, Fch_prod, Cant_kg, nom_personal, Nom_mprima from ord_prod_mp, personal, formula_mp, mprimas WHERE Cod_persona=Id_personal and ord_prod_mp.Id_form_mp=formula_mp.Id_form_mp and Cod_mp=mprimas.Cod_mprima AND Lote_mp=$Lote";
		$resultord=mysqli_query($link, $qryord);
		$roword=mysqli_fetch_array($resultord);
		if ($roword)
			mysqli_close($link);
		else
		{
			mover("buscarOProd_MP.php","No existe la Orden de Producción de Materia Prima");
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
    <td width="46"><div align="left"><?php echo $Lote;?></div></td>
    <td width="191"><div align="right"><strong>Fecha de Producci&oacute;n</strong> </div></td>
    <td width="160"><?php echo $roword['Fch_prod'];?></td>
    <td width="106"><div align="right"><strong>Cantidad (Kg)</strong></div></td>
    <td width="221"><div align="left"><?php echo $roword['Cant_kg']; ?> </div></td>
</tr>
	<tr>
      <td><div align="right"><strong>Producto</strong></div></td>
      <td colspan="3"><?php echo  $roword['Nom_mprima']?></td>
      <td><div align="right"><strong>Responsable</strong></div></td>
      <td><?php echo  $roword['nom_personal']?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      
    </tr>
</table>
<!--<input type="submit" name='boton' value='Imprimir' onclick='window.print();'> -->
<table border="0" align="center" summary="cuerpo">
 <tr>
    <td width="71"><div align="left"></div></td>
    <td width="101"><div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="224"><div align="center"><strong>Materia Prima</strong></div></td>
    <td width="112"><div align="center"><strong>Lote MP</strong></div></td>
    <td width="163"><div align="center"><strong>MP Utilizada (Kg)</strong></div></td>
  </tr>
  <?php
	$link=conectarServidor();
	$Lote=$_POST['Lote'];
	$qry="SELECT Nom_mprima, Can_mprima, det_ord_prod_mp.Id_mprima as codigo, Lote_MP FROM det_ord_prod_mp, mprimas 
where Lote_mprima=$Lote AND det_ord_prod_mp.Id_mprima=mprimas.Cod_mprima";

	$result=mysqli_query($link, $qry);
	//valign="middle"
	while($row=mysqli_fetch_array($result))
	{
	$codmp=$row['codigo'];
	$mprima=$row['Nom_mprima'];
	$gasto=$row['Can_mprima'];
	$lote_mp=$row['Lote_MP'];
	echo '<tr>
	<td align="center" valign="middle"> 
		<form action="updateO_prod_mp.php" method="post" name="actualiza">
			<input type="submit" name="Submit" value="Cambiar" >
			<input name="Lote" type="hidden" value="'.$Lote.'">
			<input name="mprima" type="hidden" value="'.$codmp.'">
			<input name="lote_mp" type="hidden" value="'.$lote_mp.'">
			<input name="gasto" type="hidden" value="'.$gasto.'">
		</form>
	</td>
	<td align="center">'.$codmp.'</td>
	<td align="center">'.$mprima.'</td>
	<td align="center">'.$lote_mp.'</td>
	<td align="center">'.$gasto.'</td></tr>';
	}
	mysqli_close($link);
?>


</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Terminar"></div>
</div>
</body>
</html>