<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de C&oacute;digo Gen&eacute;rico</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DEL C&Oacute;DIGO GEN&Eacute;RICO</strong></div>
<?php
	  $link=conectarServidor();
	  $Idprod=$_POST['IdProd'];
	  $qry="select codigo_ant, producto, fabrica, distribuidor, detal, pres_activa, pres_lista from precios where codigo_ant=$Idprod";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

<form id="form1" name="form1" method="post" action="updateCod.php">
	<table width="62%" border="0" align="center">
    <tr> 
      <td width="10%"><div align="center"><strong>C&oacute;digo</strong></div></td>
      <td width="47%"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
      <td width="14%"><div align="center"><strong>Precio F&aacute;brica</strong></div></td>
      <td width="10%"><div align="center"><strong>Activo</strong></div></td>
      <td width="19%"><div align="center"><strong>Precio en lista</strong></div></td>
    </tr>
    <tr> 
      <td><div align="right"><?php echo'<input name="Cod_prod" type="text" size="8" onKeyPress="return aceptaNum(event)" readonly="true" value="'.$row['codigo_ant'].'">';?></div></td>
      <td><div align="right"><?php echo'<input name="Producto" type="text" size="70" onKeyPress="return aceptaNum(event)" value="'.$row['producto'].'">';?></div></td>
      <td><div align="center"><?php echo'<input name="fabrica" type="text" size="8" onKeyPress="return aceptaNum(event)" value="'.$row['fabrica'].'">';?></div></td>
      <td align="center">
	    <?php
		echo'<select name="pres_activa">';
      if ($row['pres_activa']==0)
      {
          echo '<option selected value='.$row['pres_activa'].'>Si</option>';
          echo '<option value=1>No</option>';
          echo'</select>';			
      }
      if ($row['pres_activa']==1)
      {
          echo '<option selected value='.$row['pres_activa'].'>No</option>';
          echo '<option value=0>Si</option>';
          echo'</select>';			
      }
		?>      </td>
        <td align="center">
	    <?php
		  echo'<select name="pres_lista">';
      if ($row['pres_lista']==0)
      {
          echo '<option selected value='.$row['pres_lista'].'>Si</option>';
          echo '<option value=1>No</option>';
          echo'</select>';			
      }
      if ($row['pres_lista']==1)
      {
          echo '<option selected value='.$row['pres_lista'].'>No</option>';
          echo '<option value=0>Si</option>';
          echo'</select>';			
      }
		?>      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td width="19%"><div align="center">
          <input type="submit" name="Submit" value="Actualizar" >
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
