<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Materia Prima a Realizar Control de Calidad</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>	
</head>
<body>
<div id="contenedor">
  <div id="saludo"><strong>SELECCI&Oacute;N DE MATERIA PRIMA A REALIZAR CONTROL DE CALIDAD</strong></div>
<form id="form1" name="form1" method="post" action="selectlotMP.php">  
<table width="700" border="0" align="center">
 <tr>
      <td>
        <div align="center"><strong>Materia Prima</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdMP">';
				$result=mysqli_query($link,"select mprimas.Cod_mprima, Nom_mprima from mprimas, inv_mprimas where mprimas.Cod_mprima=inv_mprimas.codMP and Estado_MP='C' order by Nom_mprima");
				echo '<option selected value="">-----------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Cod_mprima'].'>'.$row['Nom_mprima'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
				mysqli_close($link);
			?>
          <input type="button" value="Continuar" onClick="return Enviar(this.form);">
        </div>
      </td>
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
</form
></div>
</body>
</html>
