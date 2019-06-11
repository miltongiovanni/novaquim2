<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8">
	<title>Borrar Usuario</title>
	<script type="text/javascript" src="../scripts/validar.js"></script>
</head>


<body>
	<div id="contenedor">

		<div id="saludo"><strong>BORRADO DE USUARIOS</strong></div>
		
		<?php
        include "../includes/administracion.php";
        $rep = buscarUsuarioForm("deleteUser.php");
        echo $rep;
        ?>
		<div class="row form-group">
            <div class="col-1"><button class="button" style="vertical-align:middle" onclick="history.back()">
                    <span>VOLVER</span></button></div>
        </div>
	</div>
</body>

</html>