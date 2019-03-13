<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de Categor&iacute;a</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<?php
	  $link=conectarServidor();
	  $IdCategoria=$_POST['IdCat'];
	  $qry="select *from cat_prod where Id_cat_prod=$IdCategoria";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>
<div id="contenedor">

<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE CATEGOR&Iacute;AS </strong></div> 
<form id="form1" name="form1" method="post" action="updateCat.php">
<table width="245" border="0" align="center">
    <tr> 
      <td width="55"><div align="center"><strong>C&oacute;digo </strong></div></td>
      <td width="209"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
    </tr>
    <tr> 
      <td><div align="right"><?php echo'<input name="Cod_cat" type="text" size="5" readonly="true" value="'.$row['Id_cat_prod'].'"/>';?></div></td>
      <td><div align="left"><?php echo'<input name="Categoria" type="text" size="30" value="'.$row['Des_cat_prod'].'"/>';?></div></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center"><input type="submit" name="Submit" value="Actualizar" ></div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
