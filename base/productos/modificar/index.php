<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Seleccionar Producto a Actualizar</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link href="../../../node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script  src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../node_modules/select2/dist/js/select2.min.js"></script>
    <script src="../../../node_modules/select2/dist/js/i18n/es.js"></script>
    <script>
        $(document).ready(function() {
            $('#codProducto').select2({
                placeholder: 'Seleccione un producto',
                language: "es"
            });
        });
    </script>
</head>

<body>
	<div id="contenedor" class="container-fluid">
		<div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR PRODUCTO A MODIFICAR</h4></div>
        <?php
        include "../../../includes/base.php";
        $rep = buscarProductoForm("updateProdForm.php", false);
        echo $rep;
        ?>

		<div class="row mb-3">
			<div class="col-1"><button class="button1"  onclick="history.back()">
					<span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</html>