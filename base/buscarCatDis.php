<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Seleccionar categoría de productos de Distribución</title>
	<script type="text/javascript" src="../js/validar.js"></script>

</head>

<body>
	<div id="contenedor">
		<div id="saludo"><strong>SELECCIÓN DE CATEGORÍA DE DISTRIBUCIÓN A ACTUALIZAR</strong></div>
		<?php
        include "../includes/base.php";
        $rep = buscarCatDisForm("updateCatDisForm.php");
        echo $rep;
        ?>

		<div class="row form-group">
			<div class="col-1"><button class="button1"  onclick="history.back()">
					<span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</html>