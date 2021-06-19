<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8">
	<title>Eliminar Envase</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script  src="../js/validar.js"></script>
</head>


<body>
	<div id="contenedor" class="container-fluid">
		<div id="saludo"><h4>ELIMINACIÓN DE ENVASE</h4></div>
		<?php
        include "../includes/base.php";
        $rep = buscarEnvaseForm("deleteEnv.php");
        echo $rep;
        ?>
		<div class="row form-group">
			<div class="col-1"><button class="button1" type="button"
					onclick="history.back()"><span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</html>