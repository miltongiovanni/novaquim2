<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Etiqueta a Actualizar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCI&Oacute;N DE ETIQUETA A ACTUALIZAR</strong></div>
<table width="100%" border="0">
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="updateEtqForm.php">
      	<div align="center"><strong>Etiqueta</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="Codigo">';
				$result=mysqli_query($link,"select * from etiquetas order by Nom_etiq");
				echo '<option selected value="">-----------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Cod_etiq'].'>'.$row['Nom_etiq'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
			?>
          <input type="button" value="Continuar" onClick="return Enviar(this.form);">
      	</div>
    	</form>    
        </td>
  	</tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</div>
</body>
</html>