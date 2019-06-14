<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
	<title>Lista del Personal Activo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<style>
		/*PARA HACER EL EFECTO ZEBRA DE LAS TABLAS*/
		tr:nth-child(even) {
			background-color: #DFE2FD;
		}
	</style>
</head>

<body>
	<div id="contenedor">

		<div id="saludo1"><strong>LISTADO DEL PERSONAL ACTIVO</strong></div>
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
		$personalOperador = new PersonalOperaciones();
		$personal=$personalOperador->getTablePersonal();
		verTabla($personal);
		?>
		<div class="row">
			<div class="col-1"><button class="button" style="vertical-align:middle"
					onclick="window.location='../menu.php'">
					<span><STRONG>Ir al Menú</STRONG></span></button></div>
		</div>
	</div>
</body>

</html>