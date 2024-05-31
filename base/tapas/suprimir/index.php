<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Tapa o Válvula</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script  src="../../../js/validar.js"></script>
</head>

<body>
    <div id="contenedor" class="container-fluid">
        <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ELIMINACIÓN DE TAPAS O VÁLVULAS</h4></div>
        <?php
        include "../../../includes/base.php";
        $rep = buscarTapaForm("deleteVal.php");
        echo $rep;
        ?>
		<div class="row form-group">
			<div class="col-1"><button class="button1" 
					onclick="history.back()"><span>VOLVER</span></button></div>
        </div>
    </div>
</body>

</html>