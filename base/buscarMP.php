<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">

<head>
  <meta charset="utf-8">
  <title>Seleccionar Materia Prima a Actualizar</title>
  <script src="../js/validar.js"></script>
</head>

<body>
  <div id="contenedor">
    <div id="saludo"><strong>SELECCIÓN DE MATERIA PRIMA A ACTUALIZAR</strong></div>
		<?php
        include "../includes/base.php";
        $rep = buscarMPrimaForm("updateMPForm.php");
        echo $rep;
        ?>
		<div class="row form-group">
			<div class="col-1"><button class="button1" style="vertical-align:middle" onclick="history.back()">
					<span>VOLVER</span></button></div>
		</div>
  </div>
</body>

</html>