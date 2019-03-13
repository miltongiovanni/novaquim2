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
<title>Actualizar datos de Envase</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE ENVASE</strong></div>
<?php
	  $link=conectarServidor();
	  $IdEnv=$_POST['Codigo'];
	  $qry="select * from envase where Cod_envase=$IdEnv";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

<form id="form1" name="form1" method="post" action="updateEnv.php">
	<table width="431" border="0" align="center">
    <tr> 
      <td width="87"><div align="center"><strong>C&oacute;digo </strong></div></td>
      <td width="211"><div align="center"><strong>Envase</strong></div></td>
      <td width="119" ><div align="center"><strong>Stock M&iacute;nimo</strong></div></td>
    </tr>
    <tr> 
      <td><?php echo'<input name="Codigo" type="text" readonly="true" value="'.$row['Cod_envase'].'" size="10"/>';?></td>
      <td><?php echo'<input name="nombre" type="text" value="'.$row['Nom_envase'].'" size="30"/>';?></td>
      <td><?php echo'<input name="stock" type="text" value="'.$row['stock_envase'].'" size="10"/>';?></td>
    </tr>
     <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center">
          <input type="submit" name="Submit" value="Actualizar"  onClick="return Enviar(this.form);">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
