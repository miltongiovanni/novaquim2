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
<title>Actualizar datos de Producto de Distribuci&oacute;n</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE PRODUCTOS DE DISTRIBUCI&Oacute;N</strong></div>
<?php
	  $link=conectarServidor();
	  $IdProd=$_POST['IdDis'];
	  $qry="select Id_distribucion, Producto, Id_Cat_dist, Cod_iva, precio_vta, precio_com, Cotiza, Activo, stock_dis, precio_vta_dis, util_clien, util_dist from distribucion where Id_distribucion=$IdProd";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

<form id="form1" name="form1" method="post" action="updateDis.php">
	<table border="0" align="center" width="50%" >
    <tr> 
      <td width="10%"><div align="center"><strong>C&oacute;digo </strong></div></td>
      <td colspan="2"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
      
      
      
      <td width="16%"><div align="center"><strong>Stock m&iacute;nimo</strong></div></td>
      
      
    </tr> <?php echo'<input name="cat_dist" type="hidden" value="'.$row['Id_Cat_dist'].'" />';?>
    <tr> 
      <td><div align="center"><?php echo'<input name="Id_prod" type="text" readonly size="6" value="'.$row['Id_distribucion'].'"/>';?></div></td>
      <td colspan="2"><div align="center"><?php echo'<input name="producto" type="text" size="70" value="'.$row['Producto'].'"/>';?></div></td>
      
      
     
      <td><div align="center"><?php echo'<input name="stock_dis" type="text"  size="6" value="'.$row['stock_dis'].'"/>';?></div></td>
      
      
    </tr>
    <tr>
    <td><div align="center"><strong>Tasa de IVA</strong></div></td>
    <td width="12%"><div align="center"><strong>Precio de Venta</strong></div></td>
    <td width="16%"><div align="center"><strong>Producto para Cotizar</strong></div></td>
    <td><div align="center"><strong>Producto Activo</strong></div></td>
    </tr>
    <tr>
    <td><div align="center">
        <?php
		  $link=conectarServidor();
		  $qry1="select * from distribucion, tasa_iva where distribucion.Id_distribucion=$IdProd and 
		  distribucion.Cod_iva=tasa_iva.Id_tasa";
		  $result1=mysqli_query($link,$qry1);
		  $row1=mysqli_fetch_array($result1); 
		  echo'<select name="cod_iva">';
		  $result2=mysqli_query($link,"select * from tasa_iva");
		  echo '<option selected value='.$row1['Id_tasa'].'>'.$row1['tasa'].'</option>';
          while ($row2=mysqli_fetch_array($result2))
		  {
			if ($row2['tasa']!= $row1['tasa'])
	        	echo '<option value='.$row2['Id_tasa'].'>'.$row2['tasa'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result1);
		  mysqli_free_result($result2);
/* cerrar la conexión */
mysqli_close($link);
		?>
      </div></td>
    <td><div align="center"><?php echo'<input name="precio_vta" type="text"  size="6" value="'.$row['precio_vta'].'"/>';?></div></td>
     <td><div align="center">
		<?php
        $cotiza=$row['Cotiza'];
        if ($cotiza==1)
        {
        echo '<select name="cotiza" >
            <option value="1" selected>No</option>
            <option value="0">Si</option>
            </select>';
        }
        else
		{
		echo '<select name="cotiza" >
            <option value="0" selected>Si</option>
            <option value="1">No</option>
            </select>';	
		}    
        ?>
      </div></td>
      <td><div align="center">
	  <?php 
        $Activo=$row['Activo'];
        if ($Activo==1)
        {
        echo '<select name="Activo" >
            <option value="1" selected>No</option>
            <option value="0">Si</option>
            </select>';
        }
        else
		{
		echo '<select name="Activo" >
            <option value="0" selected>Si</option>
            <option value="1">No</option>
            </select>';	
		}    
        ?></div></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td> 
      <td>&nbsp;</td> <td>&nbsp;</td>
      <td><div align="center">
          <input name="Submit" type="submit" class="formatoBoton1" value="Enviar">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
