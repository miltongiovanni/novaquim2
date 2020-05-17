<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Seleccionar Producto a revisar Producción</title>
<script  src="../js/validar.js"></script>
<script  src="scripts/block.js"></script>	
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR EL PRODUCTO A REVISAR PRODUCCIÓN</strong></div>
<form id="form1" name="form1" method="post" action="listarEnvasadoProd.php">
<table border="0" align="center" width="700" summary="seleccionar producto a revisar produccion">
  	<tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
    	<td>
		
      	<div align="center"><strong>Producto:</strong>
		<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="producto">';
				$result=mysqli_query($link,"select Cod_produc, Nom_produc from productos order by Nom_produc;");
				echo '<option selected value="">-----------------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Cod_produc'].'>'.$row['Nom_produc'].'</option>';
				}
				echo'</select>';
				mysqli_close($link);
		?>
        <input type="submit" name="Submit" value="Continuar" onClick="return Enviar2(this.form);">
      	</div>
        </td>
  	</tr>
    <tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</form>
</div>
</body>
</html>

