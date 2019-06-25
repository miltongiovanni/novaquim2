<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
	<title>Lista de Productos</title>
	<meta charset="utf-8">
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="contenedor">
		<div id="saludo1"><strong>LISTADO DE PRODUCTOS </strong></div>
		<div class="row" style="justify-content: right;">
			<div class="col-2">
				<form action="XlsProductos.php" method="post" target="_blank">
					<button class="button" type="submit" style="vertical-align:middle">
						<span><STRONG>Exportar a Excel</STRONG></span></button>
				</form>
			</div>
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
		$ProductoOperador = new ProductosOperaciones();
		$productos=$ProductoOperador->getTableProductos();
		verTabla($productos);
		?>
		<div class="row">
			<div class="col-1"><button class="button" style="vertical-align:middle"
					onclick="window.location='../menu.php'">
					<span><STRONG>Ir al Menú</STRONG></span></button></div>
		</div>
	</div>
</body>

</html>