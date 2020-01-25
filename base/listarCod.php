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
	<link rel="stylesheet" href="../css/datatables.css">
	<script  src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/datatables.js"></script>
	<script src="../js/dataTables.buttons.js"></script>
	<script src="../js/jszip.js"></script>
	<script src="../js/pdfmake.js"></script>
	<script src="../js/vfs_fonts.js"></script>
	<script src="../js/buttons.html5.js"></script>

	<script>
	$(document).ready(function() {
		$('#example').DataTable( {
		"columnDefs": 
			[{
				"targets": [ 0, 1,2,3,4,5,6  ],
				"className": 'dt-body-center'
			}
			],
		"dom": 'Blfrtip',
		"buttons": [
			'copyHtml5',
		'excelHtml5'
		],
		"order": [[ 0, "asc" ]],
		"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
		"language": {
			"lengthMenu": "Mostrando _MENU_ datos por página",
			"zeroRecords": "Lo siento no encontró nada",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay datos disponibles",
			"search":         "Búsqueda:",
			"paginate": {
				"first":      "Primero",
				"last":       "Último",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"infoFiltered": "(Filtrado de _MAX_ en total)"
			
		},
			"ajax": "ajax/listaCod.php"
		} );
	} );
	</script>
</head>

<body>
  <div id="contenedor">
    <div id="saludo1"><strong>LISTA DE PRECIOS</strong></div>
    <div class="row" style="justify-content: right;">
			<div class="col-2">
				<form action="XlsListaPrecios.php" method="post" target="_blank">
					<button class="button" type="submit" >
						<span><STRONG>Exportar a Excel</STRONG></span></button>
        </form>
      </div>
      <div class="col-2">
        <form action="selListaPrecios.php" method="post" target="_blank">
					<button class="button" type="submit" >
						<span><STRONG>Imprimir Lista de Precios</STRONG></span></button>
				</form>
			</div>
			<div class="col-1">
				<button class="button"  onclick="window.location='../menu.php'">
					<span><STRONG>Ir al Menú</STRONG></span></button>
			</div>
    </div>
    <table id="example" class="display compact formatoDatos" style="width:70%">
        <thead>
            <tr>
                <th>Código</th>
				<th>Descripción</th>
				<th>Precio Fábrica</th>
				<th>Precio Distribución</th>
				<th>Precio Detal</th>
				<th>Precio Mayorista</th>
				<th>Precio Super</th>
            </tr>
        </thead>
	</table>
	<div class="row">
		<div class="col-1"><button class="button" 
		onclick="window.location='../menu.php'">
		<span><STRONG>Ir al Menú</STRONG></span></button></div>
    </div>

  </div>
</body>

</html>