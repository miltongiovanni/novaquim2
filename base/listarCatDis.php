<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lista de Categorías de Productos de Distribución</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="contenedor">
        <div id="saludo1"><strong>LISTADO CATEGORÍAS DE PRODUCTOS DE DISTRIBUCIÓN</strong></div>
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
		$catsDisOperador = new CategoriasDisOperaciones();
		$categorias=$catsDisOperador->getCatsDisTable();
		verTabla($categorias);
		?>
        <div class="row">
            <div class="col-1"><button class="button" style="vertical-align:middle"
                    onclick="window.location='../menu.php'">
                    <span><STRONG>Ir al Menú</STRONG></span></button></div>
        </div>
    </div>
</body>

</html>