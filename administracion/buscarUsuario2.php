<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Seleccionar Usuario a Actualizar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script  src="../js/validar.js"></script>
</head>

<body>
	<div id="contenedor">

		<div id="saludo"><strong>SELECCIONAR USUARIO A ASIGNAR CONTRASEÑA</strong></div>
		<?php
        include "../includes/administracion.php";
        $rep = buscarUsuarioForm("cambio1.php", true);
        echo $rep;
        ?>
		<div class="row form-group">
            <div class="col-1"><button class="button"  onclick="history.back()">
                    <span>VOLVER</span></button></div>
        </div>
	</div>
</body>

</html>