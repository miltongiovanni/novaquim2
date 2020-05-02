<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Orden de Producci&oacute;n</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>	
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo"><strong>ORDEN DE PRODUCCI&Oacute;N</strong></div>
<form method="post" action="o_produccion2.php" name="form1">	
  	<table width="36%" align="center">
    <tr>
      	<td><strong>Producto</strong></td>
      	<td>
		<?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="producto">';
			$result=mysqli_query($link,"select * from productos where prod_activo=0 order by Nom_produc;");
			echo '<option value="">---------------------------------------------------------------</option>';
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Cod_produc'].'>'.$row['Nom_produc'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
		?>
        </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
   	  <td>&nbsp;</td>
   	  <td><div align="right"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
  </table>
</form> 
</div>
</body>
</html>