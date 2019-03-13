<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detalle Orden de Producci&oacute;n</title>
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
<div id="saludo1"><strong>CONTROL DE CALIDAD POR PRODUCCI&Oacute;N</strong></div>
<table border="0" align="center" width="57%" >
<?php
	include "includes/conect.php";
	$link=conectarServidor();
	$Lote=$_POST['Lote'];
	$qryord="select Lote, Fch_prod, Cant_kg, Cod_persona, Nom_produc, Nom_form, nom_personal, Den_min, Den_max ,pH_min, pH_max, Fragancia, Color, Apariencia 
			from ord_prod, formula, productos, personal
			WHERE ord_prod.Id_form=formula.Id_form and formula.Cod_prod=productos.Cod_produc
			and ord_prod.Cod_persona=personal.Id_personal and Lote=$Lote;";
	$resultord=mysqli_query($link,$qryord);
	$roword=mysqli_fetch_array($resultord);
	if ($roword)
	{
	  $qrycal="select den_prod,ph_prod,ol_prod,col_prod,ap_prod,Obs_prod from cal_producto where Lote=$Lote;";
	  $resultcal=mysqli_query($link,$qrycal);
	  $rowcal=mysqli_fetch_array($resultcal);
	  mysqli_close($link);
	}
	else
	{
		mover("buscarOProd.php","No existe la Orden de Producción");
		mysqli_close($link);
	}
		
		
function mover($ruta,$nota)
{
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo'<script language="Javascript">
	alert("'.$nota.'")
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
    <td width="21%"><div align="right"><strong>Fecha de Producci&oacute;n</strong> </div></td>
    <td width="18%"><?php echo $roword['Fch_prod'];?></td>
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

<form name="form2" method="POST" action="updateCalProd.php"> 
<!--<input type="submit" name='boton' value='Imprimir' onclick='window.print();'> -->
<table width="40%" border="0" align="center">
 <tr>
    <td width="17%"><div align="center"><strong>Propiedad</strong></div></td>
    <td colspan="2"><div align="center"><strong>Especificaci&oacute;n</strong></div></td>
    <td width="27%"><div align="center"><strong>Valor / Cumple</strong></div></td>
  </tr>
   <tr>
    <td width="17%"><div align="center"><strong>pH</strong></div></td>
    <td width="28%"><div align="center">Max: <?php echo $roword['pH_max']; ?></div></td>
    <td width="28%"><div align="center">Min: <?php echo $roword['pH_min']; ?></div></td>
    <td width="27%"><div align="center"><input type="text" name="pH" size=8 onKeyPress="return aceptaNum(event)" value="<?php echo $rowcal['ph_prod']; ?>" ></div></td>
  </tr>
   <tr>
    <td width="17%"><div align="center"><strong>Densidad</strong></div></td>
    <td width="28%"><div align="center">Max: <?php echo $roword['Den_max']; ?></div></td>
    <td width="28%"><div align="center">Min: <?php echo $roword['Den_min']; ?></div></td>
    <td width="27%"><div align="center"><input type="text" name="den_prod" size=8 onKeyPress="return aceptaNum(event)" value="<?php echo $rowcal['den_prod']; ?>" ></div></td>
  </tr>
  <tr>
    <td width="17%"><div align="center"><strong>Olor</strong></div></td>
    <td colspan="2"><div align="center"><?php echo $roword['Fragancia']; ?></div></td>
    <td width="27%"><div align="center">
	<?php if($rowcal['ol_prod']==0)
	{
		echo '<select name="ol_prod"> 
    <option value="0" selected>SI</option>
    <option value="1">NO</option>
    </select>';
	}
	else
	{
		echo '<select name="ol_prod"> 
    <option value="1" selected>NO</option>
    <option value="0">SI</option>
    </select>';
	}
	 ?>
    </div></td>
  </tr>
  <tr>
    <td width="17%"><div align="center"><strong>Color</strong></div></td>
    <td colspan="2"><div align="center"><?php echo $roword['Color']; ?></div></td>
    <td width="27%"><div align="center"><?php if($rowcal['col_prod']==0)
	{
		echo '<select name="col_prod"> 
    <option value="0" selected>SI</option>
    <option value="1">NO</option>
    </select>';
	}
	else
	{
		echo '<select name="col_prod"> 
    <option value="1" selected>NO</option>
    <option value="0">SI</option>
    </select>';
	}
	 ?></div></td>
  </tr>
  <tr>
    <td width="17%"><div align="center"><strong>Apariencia</strong></div></td>
    <td colspan="2"><div align="center"><?php echo $roword['Apariencia']; ?></div></td>
    <td width="27%"><div align="center"><?php if($rowcal['ap_prod']==0)
	{
		echo '<select name="ap_prod"> 
    <option value="0" selected>SI</option>
    <option value="1">NO</option>
    </select>';
	}
	else
	{
		echo '<select name="ap_prod"> 
    <option value="1" selected>NO</option>
    <option value="0">SI</option>
    </select>';
	}
	 ?></div></td>
  </tr>
    <tr>
    <td width="17%"><div align="center"><strong>Observaciones</strong></div></td>
    <td colspan="3"><div align="center"><input type="text" name="obs_prod" size=55 value="<?php echo $rowcal['Obs_prod']; ?>"></div></td>
  </tr>
<tr>


<tr> 
        <td align="center" colspan="2"><input type="hidden" name="Lote"  size=55 value="<?php echo $Lote;?>"><input type="reset" value="Restablecer"></td>
        <td align="center" colspan="2"><input type="button" value="    Continuar    " onclick="return Enviar(this.form);"></td>
</tr>
</table>
</form>

</div>
</body>
</html>