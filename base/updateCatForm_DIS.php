<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de Categor&iacute;a de Distribuci&oacute;n</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N  CATEGOR&Iacute;A DISTRIBUCI&Oacute;N</strong></div> 

<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
	$link=conectarServidor();
	$qry="select * from cat_dist where Id_cat_dist=$IdCat";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

<form id="form1" name="form1" method="post" action="updateCat_DIS.php">
	<table width="330" border="0" align="center">
    <tr> 
      <td width="78"><div align="right"><strong>C&oacute;digo </strong></div></td>
      <td width="302"><div align="left"><?php echo'<input name="Cod_cat" type="text" size="25" readonly="true" value="'.$row['Id_cat_dist'].'"/>';?></div></td>
    </tr>
    <tr> 
      <td><strong>Descripci&oacute;n</strong></td>
      <td><div align="left"><?php echo'<input name="Categoria" type="text" size="25" value="'.$row['Des_cat_dist'].'"/>';?></div></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center">
          <input type="submit" name="Submit" value="Actualizar">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
