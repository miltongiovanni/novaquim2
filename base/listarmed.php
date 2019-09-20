<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
	<title>Listado de Presentaciones de Producto</title>
	<meta charset="utf-8">
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../ja/validar.js"></script>
</head>

<body>
	<div id="contenedor">
		<div id="saludo1"><strong>LISTA DE PRESENTACIONES DE PRODUCTO</strong></div>
		<div class="row" style="justify-content: right;">
			<div class="col-1">
				<button class="button" style="vertical-align:middle" onclick="window.location='../menu.php'">
					<span><STRONG>Ir al Menú</STRONG></span></button>
			</div>
		</div>
		<?php
		include "../includes/utilTabla.php";
		function cargarClases($classname)
		{
		require '../clases/'.$classname.'.php';
		}
		spl_autoload_register('cargarClases');
		$PresentacionOperador = new PresentacionesOperaciones();
		$presentaciones=$PresentacionOperador->getTablePresentaciones();
		verTabla($presentaciones);
		?>
		<div class="row">
			<div class="col-1"><button class="button" style="vertical-align:middle" onclick="window.location='../menu.php'">
				<span><STRONG>Ir al Menú</STRONG></span></button>
			</div>
		</div>

</body>

</html>