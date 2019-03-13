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
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE MATERIA PRIMA</strong></div>
<?php
	  $link=conectarServidor();
	  $IdMP=$_POST['IdMP'];
	  $qry="select * from mprimas where Cod_mprima=$IdMP";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
/* cerrar la conexión */
?>

<form id="form1" name="form1" method="post" action="updateMP.php">
	<table width="594" border="0" align="center">
    <tr> 
      <td width="75"><div align="center"><strong>C&oacute;digo</strong></div></td>
      <td width="189"><div align="center"><strong>Materia Prima</strong></div></td>
      <td width="133"><div align="center"><strong>Tipo</strong></div></td>
      <td width="99"><div align="center"><strong>Stock </strong></div></td>
      <td width="76"><div align="center"><strong>Tasa Iva</strong></div></td>
    </tr>
    <tr> 
      <td align="center"><?php echo'<input name="Cod_mp" type="text" size="5" readonly="true" value="'.$row['Cod_mprima'].'"/>';?></td>
      <td align="center"><?php echo'<input name="mprimas" type="text" size="30" value="'.$row['Nom_mprima'].'"/>';?></td>
      <td align="center">
	    <?php
		  $qry1="select * from mprimas, cat_mp where mprimas.Cod_mprima=$IdMP and 
		  mprimas.Id_cat_mp=cat_mp.Id_cat_mp";
		  $result1=mysqli_query($link,$qry1);
		  $row1=mysqli_fetch_array($result1); 
		  echo'<select name="IdCatMP">';
		  $result2=mysqli_query($link,"select * from cat_mp");
		  echo '<option selected value='.$row1['Id_cat_mp'].'>'.$row1['Des_cat_mp'].'</option>';
          while ($row2=mysqli_fetch_array($result2))
		  {
			if ($row2['Des_cat_mp']!= $row1['Des_cat_mp'])
	        	echo '<option value='.$row2['Id_cat_mp'].'>'.$row2['Des_cat_mp'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result1);
		  mysqli_free_result($result2);

		?>      </td>
      <td align="center"><?php echo'<input name="stock" type="text" size="5" value="'.$row['Min_stock_mp'].'"/>';?></td>
      <td align="center"><select name="tasa_iva" id="combo">
            <?php
				$qry="select * from tasa_iva";	
                $result=mysqli_query($link,$qry);
				$qry3="SELECT Cod_iva, tasa from mprimas, tasa_iva where Cod_mprima=$IdMP AND Cod_iva=Id_tasa;";
                $result3=mysqli_query($link,$qry3);
				$row3=mysqli_fetch_array($result3);
                echo '<option selected value="'.$row3['Cod_iva'].'">'.$row3['tasa'].'</option>';
                while($row=mysqli_fetch_array($result))
                {
					if ($row['Id_tasa']!=$row3['Cod_iva'])
                      echo '<option value="'.$row['Id_tasa'].'">'.$row['tasa'].'</option>';  
                      //echo= $row['Id_cat_prod'];
                }
				mysqli_free_result($result);
				mysqli_free_result($result3);
/* cerrar la conexión */
mysqli_close($link);
            ?>
      </select >	</td> 
    </tr>
     <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="left">
          <input type="submit" name="Submit" value="Actualizar"  onClick="return Enviar(this.form);">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
