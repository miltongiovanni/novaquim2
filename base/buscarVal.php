<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Tapa o V&aacute;lvula a Actualizar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>	
</head>
<body>
<div id="contenedor">
  <div id="saludo"><strong>SELECCI&Oacute;N DE TAPAS O V&Aacute;LVULAS A ACTUALIZAR</strong></div>
  <form id="form1" name="form1" method="post" action="updateValForm.php">
    <table width="100%" border="0">
      <tr>
        <td><div align="center"><strong>Tapa o V&aacute;lvula</strong>
			<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="Codigo">';
				$result=mysqli_query($link,"select * from tapas_val order by Nom_tapa");
				echo '<option selected value="">-----------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Cod_tapa'].'>'.$row['Nom_tapa'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
			?>
          <input type="submit" name="Submit" value="Continuar" onClick="return Enviar(this.form);">
        </div></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">
          <input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  ">
        </div></td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>