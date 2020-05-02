<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">

<head>
  <meta charset="utf-8">
  <title>Seleccionar Tapa o Válvula a Actualizar</title>
  <script  src="../js/validar.js"></script>
</head>

<body>
  <div id="contenedor">
    <div id="saludo"><strong>SELECCIÓN DE TAPAS O VÁLVULAS A ACTUALIZAR</strong></div>
    <?php
        include "../includes/base.php";
        $rep = buscarTapaForm("updateValForm.php");
        echo $rep;
        ?>

    <div class="row form-group">
      <div class="col-1"><button class="button1"  onclick="history.back()"><span>VOLVER</span></button></div>
    </div>

  </div>
</body>

</html>