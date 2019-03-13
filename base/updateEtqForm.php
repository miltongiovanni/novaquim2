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
<title>Actualizar datos de Etiqueta</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE ETIQUETAS</strong></div>
<?php
	  $link=conectarServidor();
	  $IdEtq=$_POST['Codigo'];
	  $qry="select * from etiquetas where Cod_etiq=$IdEtq";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

<form id="form1" name="form1" method="post" action="updateEtq.php">
<table width="538" border="0" align="center">
    <tr align="center"> 
      <td width="74"><strong>C&oacute;digo </strong></td>
      <td width="328"><strong>Etiqueta</strong></td>
      <td width="122"><strong>Stock M&iacute;nimo</strong></td>
    </tr>
    <tr align="center"> 
      <td><?php echo'<input name="Codigo" type="text" readonly="true" value="'.$row['Cod_etiq'].'" size="5">';?></td>
      <td><?php echo'<input name="nombre" type="text" value="'.$row['Nom_etiq'].'" size="40">';?></td>
      <td><?php echo'<input name="stock" type="text" value="'.$row['stock_etiq'].'" size="10">';?></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center"><input type="submit" name="Submit" value="Actualizar"  onClick="return Enviar(this.form);"></div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
