<?php
include "includes/valAcc.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="images/favicon.ico" type="image/ico" sizes="16x16">
    <title>Change</title>

    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/validar.js"></script>

</head>
<body>
<?php
session_destroy();
mover_pag("index.php", "Gracias por utilizar El Sistema de Información de Industrias Novaquim S.A.S.", "info");

?>
</body>
</html>
