<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8">
	<title>Eliminar Categoría de Materia Prima</title>
	<script  src="../js/validar.js"></script>
</head>

<body>
	<div id="contenedor">
		<div id="saludo"><strong>ELIMINACIÓN DE CATEGORÍA DE MATERIA PRIMA</strong></div>
		<?php
        include "../includes/base.php";
        $rep = buscarCatMPForm("deleteCatMP.php");
        echo $rep;
        ?>
		<div class="row form-group">
			<div class="col-1"><button class="button1"  onclick="history.back()">
					<span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</html>