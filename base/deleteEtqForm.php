<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8">
	<title>Eliminar Etiqueta</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script  src="../js/validar.js"></script>
</head>


<body>
	<div id="contenedor">
		<div id="saludo"><strong>ELIMINACIÓN DE ETIQUETAS</strong></div>
		<?php
        include "../includes/base.php";
        $rep = buscarEtiquetaForm("deleteEtq.php");
        echo $rep;
        ?>
		<div class="row form-group">
			<div class="col-1"><button class="button1" 
					onclick="history.back()"><span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</html>
