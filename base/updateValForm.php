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
<title>Actualizar datos de Tapa o V&aacute;lvula</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE TAPA O V&Aacute;LVULA</strong></div>
<?php
	  $link=conectarServidor();
	  $IdEnv=$_POST['Codigo'];
	  $qry="select * from tapas_val where Cod_tapa=$IdEnv";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

<form id="form1" name="form1" method="post" action="updateVal.php">
<table width="32%" border="0" align="center">
    <tr> 
      <td width="16%" align="center"><strong>C&oacute;digo </strong></td>
      <td width="55%" align="center"><strong>Tapa o V&aacute;lvula</strong></td>
      <td width="29%" align="center" ><strong>Stock M&iacute;nimo</strong></td>
    </tr>
    <tr> 
      <td><?php echo'<input name="Codigo" type="text" readonly="true" value="'.$row['Cod_tapa'].'" size="10"/>';?></td>
      <td><?php echo'<input name="nombre" type="text" value="'.$row['Nom_tapa'].'" size="30"/>';?></td>
      <td><?php echo'<input name="stock" type="text" value="'.$row['stock_tapa'].'" size="10"/>';?></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center">
          <input type="submit" name="Submit" value="Enviar"  onClick="return Enviar(this.form);">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
