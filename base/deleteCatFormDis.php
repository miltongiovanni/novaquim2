<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Eliminar categoría producto de distribución</title>
	<script type="text/javascript" src="../js/validar.js"></script>
</head>


<body>
	<div id="contenedor">
		<div id="saludo"><strong>ELIMINACIÓN CATEGORÍA PRODUCTO DE DISTRIBUCIÓN</strong></div>
		<?php
        include "../includes/base.php";
        $rep = buscarCatDisForm("deleteCatDis.php");
        echo $rep;
        ?>

		<div class="row form-group">
			<div class="col-1"><button class="button1" style="vertical-align:middle" onclick="history.back()">
					<span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</html>