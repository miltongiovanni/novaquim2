<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Seleccionar Etiqueta a Actualizar</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script  src="../js/validar.js"></script>
</head>

<body>
	<div id="contenedor">
		<div id="saludo"><strong>SELECCIÓN DE ETIQUETA A ACTUALIZAR</strong></div>
		<?php
        include "../includes/base.php";
        $rep = buscarEtiquetaForm("updateEtqForm.php");
        echo $rep;
        ?>

		<div class="row form-group">
			<div class="col-1"><button class="button1" 
					onclick="history.back()"><span>VOLVER</span></button></div>
		</div>

	</div>
</body>

</html>