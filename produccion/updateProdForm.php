<?php
include "includes/valAcc.php";
include "includes/conect.php";
//echo $_SESSION['Perfil'];
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de Producto</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE PRODUCTOS</strong></div>
<?php
	$link=conectarServidor();
	$Idprod=$_POST['IdProd'];
	$qry="select Cod_produc, Nom_produc, prod_activo, Id_cat_prod , Den_min , Den_max , pH_min, pH_max , Fragancia, Color, Apariencia, Cuenta_cont from productos where Cod_produc=$Idprod";
	$result=mysqli_query($link, $qry);
	$row=mysqli_fetch_array($result);
?>

<form id="form1" name="form1" method="post" action="updateProd.php">
<table border="0" align="center" width="45%">
    <tr> 
      <td width="11%" align="center"><strong>C&oacute;digo</strong></td>
      <td align="center" colspan="4"><strong>Descripci&oacute;n</strong></td>
      <td align="center" colspan="1"><strong>Activo</strong></td>
      <td align="center" colspan="1"><strong>Categor&iacute;a</strong></td>
    </tr>
    <tr> 
      <td align="center"><div align="center"><?php echo'<input name="Cod_prod" type="text" size="5" readonly="true" value="'.$row['Cod_produc'].'" align="middle">';?></div></td>
      <td align="center" colspan="4"><div align="center"><?php echo'<input name="Producto" type="text" size="45" value="'.$row['Nom_produc'].'">';?></div></td>
      <td colspan="1" align="center"><?php
	  		if ($row['prod_activo']==0)
			{
		  		echo'<select name="prod_act">';
		  		echo '<option selected value=0>Si</option>';
            	echo '<option value=1>No </option>';
				echo'</select>';
          	}
			else
			{
		  		echo'<select name="prod_act">';
		  		echo '<option selected value=1>No</option>';
            	echo '<option value=0>Si</option>';
				echo'</select>';
          	}
		  ?></td>
      <td align="center" colspan="1">
        <div align="center">
          <?php 
		  $qry1="select * from productos, cat_prod where productos.Cod_produc=$Idprod and productos.Id_cat_prod=cat_prod.Id_cat_prod";
		  $result1=mysqli_query($link, $qry1);
		  $row1=mysqli_fetch_array($result1); 
		  echo'<select name="IdCat">';
		  $result2=mysqli_query($link,"select * from cat_prod");
		  echo '<option selected value='.$row1['Id_cat_prod'].'>'.$row1['Des_cat_prod'].'</option>';
          while ($row2=mysqli_fetch_array($result2))
		  {
			if ($row2['Des_cat_prod']!= $row1['Des_cat_prod'])
	        	echo '<option value='.$row2['Id_cat_prod'].'>'.$row2['Des_cat_prod'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result);
		  mysqli_free_result($result1);
		  mysqli_free_result($result2);
		  /* cerrar la conexión */
		  mysqli_close($link);
		?>      
        </div></td>
    </tr>
    <tr> 
    	  <td colspan="7"><div align="center"><strong>Tipo</strong></div></td>
    </tr>
    <tr>
          <td colspan="7" align="center">
          <?php
		  	$cuenta=$row['Cuenta_cont'];
			if($cuenta==412046)
			{
				echo '<select name="cuenta" id="cuenta">
                <option value="412046" selected>Detergente, Suavizante, Ambientador, Jabón, Shampoo, Lavaloza, Desengrasante, Multiusos</option>
                <option value="412047">Ceras, Removedor, Limpiadores, Blanqueador, Limpiavidrios, Lustramuebles, Creolina</option>                
        		</select>';     
			}
			if($cuenta==412047)
			{
				echo '<select name="cuenta" id="cuenta">
                <option value="412047" selected>Ceras, Removedor, Limpiadores, Blanqueador, Limpiavidrios, Lustramuebles, Creolina</option>
                <option value="412046">Detergente, Suavizante, Ambientador, Jabón, Shampoo, Lavaloza, Desengrasante, Multiusos</option>                
        		</select>';     
			}
		  ?>
        </td>
    </tr>
    <tr>
        <td colspan="1"><div align="center"><strong>Densidad M&iacute;nima</strong></div></td>
        <td width="13%" colspan="1"><div align="center"><strong>Densidad M&aacute;xima</strong></div></td>
        <td width="10%" colspan="1"><div align="center"><strong>pH M&iacute;nimo</strong></div></td>
        <td width="9%" colspan="1"><div align="center"><strong>pH M&aacute;ximo</strong></div></td>
        <td width="15%" colspan="1"><div align="center"><strong>Fragancia</strong></div></td>
        <td width="11%" colspan="1"><div align="center"><strong>Color</strong></div></td>
        <td width="31%" colspan="1"><div align="center"><strong>Apariencia</strong></div></td>
        
    </tr>
    <tr>
        <td colspan="1"><div align="center"><strong><input type="text" name="den_min" size=5 onKeyPress="return aceptaNum(event)" value="<?php echo $row['Den_min'];  ?>"></strong></div></td>
        <td colspan="1"><div align="center"><strong><input type="text" name="den_max" size=5 onKeyPress="return aceptaNum(event)" value="<?php echo $row['Den_max'];  ?>"></strong></div></td>
        <td colspan="1"><div align="center"><strong><input type="text" name="ph_min" size=5 onKeyPress="return aceptaNum(event)" value="<?php echo $row['pH_min'];  ?>"></strong></div></td>
        <td colspan="1"><div align="center"><strong><input type="text" name="ph_max" size=5 onKeyPress="return aceptaNum(event)" value="<?php echo $row['pH_max'];  ?>"></strong></div></td>
        <td colspan="1"><div align="center"><strong><input type="text" name="fragancia" size=10 value="<?php echo $row['Fragancia'];  ?>"></strong></div></td>
        <td colspan="1"><div align="center"><strong><input type="text" name="color" size=5 value="<?php echo $row['Color'];  ?>"></strong></div></td>
        <td colspan="1"><div align="center"><strong><input type="text" name="Apariencia" size=25 value="<?php echo $row['Apariencia'];  ?>"></strong></div></td>
      <tr>
    <tr><td>&nbsp;</td></tr>
    <tr> 
         <td colspan="7"><div align="center">
          <input type="submit" name="Submit" value="Actualizar" align="middle">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
