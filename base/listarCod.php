<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
  <title>Lista de Precios</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="../js/validar.js"></script>
</head>

<body>
  <div id="contenedor">
    <div id="saludo1"><strong>LISTA DE PRECIOS</strong></div>
    <div class="row" style="justify-content: right;">
			<div class="col-2">
				<form action="XlsListaPrecios.php" method="post" target="_blank">
					<button class="button" type="submit" style="vertical-align:middle">
						<span><STRONG>Exportar a Excel</STRONG></span></button>
        </form>
      </div>
      <div class="col-2">
        <form action="selListaPrecios.php" method="post" target="_blank">
					<button class="button" type="submit" style="vertical-align:middle">
						<span><STRONG>Imprimir Lista de Precios</STRONG></span></button>
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
		$PrecioOperador = new PreciosOperaciones();
		$precios=$PrecioOperador->getTablePreciosHTML();
		verTabla($precios);
		?>
		<div class="row">
			<div class="col-1"><button class="button" style="vertical-align:middle"
					onclick="window.location='../menu.php'">
					<span><STRONG>Ir al Menú</STRONG></span></button></div>
    </div>

  </div>
</body>

</html>