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

<form id="form1" name="form1" method="post" action="updateDis1.php">
	<table border="0" align="center" width="47%" >
    <tr> 
      <td width="10%"><div align="center"><strong>C&oacute;digo </strong></div></td>
      <td colspan="2"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
      
      
      
      <td width="18%"><div align="center"><strong>Precio de Venta</strong></div></td>
      
      
    </tr> <?php echo'<input name="cat_dist" type="hidden" value="'.$row['Id_Cat_dist'].'" />';?>
    <tr> 
      <td><div align="center"><?php echo'<input name="Id_prod" type="text" readonly size="6" value="'.$row['Id_distribucion'].'"/>';?></div></td>
      <td colspan="2"><div align="center"><?php echo $row['Producto']; ?></div></td>
      
      
     
      <td><div align="center"><?php echo $row['precio_vta']; ?></div></td>
      
      
    </tr>
    <tr>
    <td colspan="2"><div align="center"><strong>Utilidad Cliente</strong></div></td>
    <td colspan="2"><div align="center"><strong>Utilidad Cliente Institucional</strong></div></td>
    </tr>
    <tr>
    <td colspan="2"><div align="center">
        <?php echo'<input name="util_clien" type="text"  size="6" value="'.($row['util_clien']*100).'"/>';?>
      </div></td>
    <td colspan="2"><div align="center"><?php echo'<input name="util_dist" type="text" size="6" value="'.($row['util_dist']*100).'"/>';?></div></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td> 
      <td width="37%">&nbsp;</td> <td width="35%">&nbsp;</td>
      <td><div align="center">
          <input name="Submit" type="submit" class="formatoBoton1" value="Enviar">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
