<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">

<head>
	<meta charset="utf-8">
	<title>Seleccionar Envase a Actualizar</title>
	<script  src="../js/validar.js"></script>
</head>

<body>
	<div id="contenedor">
		<div id="saludo"><strong>SELECCIÓN DE ENVASE A ACTUALIZAR</strong></div>
		<?php
        include "../includes/base.php";
        $rep = buscarEnvaseForm("updateEnvForm.php");
        echo $rep;
        ?>

		<div class="row form-group">
			<div class="col-1"><button class="button1" 
					onclick="history.back()"><span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</html>