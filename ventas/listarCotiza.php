<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Cotizaciones</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script src="../js/buttons.html5.js"></script>
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact" style="padding-left:50px;width:100%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Productos Novaquim</th>' +
                '<th align="center">Productos de Distribución</th>' +
                '</thead>';
            rep += '<tr>' +
                '<td align="center">' + d.productos + '</td>' +
                '<td align="center">' + d.distribucion + '</td>' +
                '</tr>'
            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "idCotizacion",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "desCatClien",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomPersonal",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaCotizacion",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "precioCotizacion",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "presentacionesCotizacion",
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[1, 'desc']],
                "deferRender": true,  //For speed
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
                    "lengthMenu": "Mostrando _MENU_ datos por página",
                    "zeroRecords": "Lo siento no encontró nada",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay datos disponibles",
                    "search": "Búsqueda:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "infoFiltered": "(Filtrado de _MAX_ en total)"

                },
                "ajax": "ajax/listaCotizaciones.php"
            });
            // Add event listener for opening and closing details
            $('#example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>LISTA DE COTIZACIONES</strong></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-90">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th></th>
                <th>Id</th>
                <th>Cliente</th>
                <th>Categoría Cliente</th>
                <th>Vendedor</th>
                <th>Fecha Cotización</th>
                <th>Precio</th>
                <th>Presentaciones</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>
  <!--  <table align="center" width="100%" border="0">
        <tr>
            <td width="1177" align="right">
                <form action="Cotiza_Xls.php" method="post" target="_blank"><input name="Submit" type="submit"
                                                                                   class="resaltado"
                                                                                   value="Exportar a Excel"></form>
            </td>
            <td width="93">
                <div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'"
                                          value="Ir al Menú">
                </div>
            </td>
        </tr>
    </table>
    <table border="0" align="center" cellspacing="0" width="90%">
        <tr>
            <th width="2%" class="formatoEncabezados"></th>
            <th width="3%" class="formatoEncabezados">Id</th>
            <th width="29%" class="formatoEncabezados">Cliente</th>
            <th width="16%" class="formatoEncabezados">Categoría Cliente</th>
            <th width="14%" class="formatoEncabezados">Vendedor</th>
            <th width="12%" class="formatoEncabezados">Fecha Cotización</th>
            <th width="10%" class="formatoEncabezados">Precio</th>
            <th width="14%" class="formatoEncabezados">Presentaciones</th>
        </tr>
        <?php
/*        include "includes/utilTabla.php";
        include "includes/conect.php";
        $link = conectarServidor();
        $sql = "select idCotizacion, nomCliente, desCatClien, nom_personal, fechaCotizacion, precioCotizacion, presentaciones, distribucion, productos 
	from cotizaciones, clientes_cotiz, Personal, cat_clien 
	where idCliente=idCliente and codVendedor=Id_personal and idCatCliente=idCatClien order by idCotizacion desc;";
        //llamar funcion de tabla
        $result = mysqli_query($link, $sql);
        $a = 1;
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<tr';
            if (($a++ % 2) == 0) echo ' bgcolor="#B4CBEF" ';
            echo '>
	  <td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments(' . "'" . 'UniqueName' . $a . "'" . ')">+/-</a></div></td>
	  <td class="formatoDatos"><div align="center">' . $row['Id_Cotizacion'] . '</div></td>
	  <td class="formatoDatos"><div align="left">' . $row['Nom_clien'] . '</div></td>
	  <td class="formatoDatos"><div align="center">' . $row['Des_cat_cli'] . '</div></td>
	  <td class="formatoDatos"><div align="center">' . $row['nom_personal'] . '</div></td>
	  <td class="formatoDatos"><div align="center">' . $row['Fech_Cotizacion'] . '</div></td>';
            if ($row['precio'] == 1) $precio = "Fábrica";
            if ($row['precio'] == 2) $precio = "Distribuidor";
            if ($row['precio'] == 3) $precio = "Detal";
            if ($row['precio'] == 4) $precio = "Mayorista";
            if ($row['precio'] == 5) $precio = "Super";
            echo '<td class="formatoDatos"><div align="center">' . $precio . '</div></td>';
            if ($row['presentaciones'] == 1) $presentacion = "Todas";
            if ($row['presentaciones'] == 2) $presentacion = "Pequeñas";
            if ($row['presentaciones'] == 3) $presentacion = "Grandes";
            echo '<td class="formatoDatos"><div align="center">' . $presentacion . '</div></td>';

            $seleccion1 = explode(",", $row['productos']);
            $c = count($seleccion1);
            $prodnova = "";
            if (in_array(1, $seleccion1)) $prodnova[] = " Limpieza Equipos";
            if (in_array(2, $seleccion1)) $prodnova[] = " Limpieza General  ";
            if (in_array(3, $seleccion1)) $prodnova[] = " Mantenimiento de pisos ";
            if (in_array(4, $seleccion1)) $prodnova[] = " Productos para Lavandería ";
            if (in_array(5, $seleccion1)) $prodnova[] = " Aseo Doméstico y Oficina ";
            if (in_array(6, $seleccion1)) $prodnova[] = " Higiene Cocina ";
            if (in_array(7, $seleccion1)) $prodnova[] = " Línea Automotriz ";

            $opciones_prod = implode(",", $prodnova);
            if ($row['distribucion']) {
                $seleccion = explode(",", $row['distribucion']);
                $b = count($seleccion);
                $distrib = "";
                if (in_array(1, $seleccion)) $distrib[] = " Implementos de Aseo";
                if (in_array(2, $seleccion)) $distrib[] = " Desechables ";
                if (in_array(3, $seleccion)) $distrib[] = " Cafetería ";
                if (in_array(4, $seleccion)) $distrib[] = " Abarrotes ";
                if (in_array(5, $seleccion)) $distrib[] = " Distribución Aseo ";
                if (in_array(6, $seleccion)) $distrib[] = " Aseo Personal ";
                if (in_array(7, $seleccion)) $distrib[] = " Hogar ";
                if (in_array(8, $seleccion)) $distrib[] = " Papelería ";
                if (in_array(9, $seleccion)) $distrib[] = " Otros ";
                $opciones_dist = implode(",", $distrib);
            } else {
                $opciones_dist = 'No eligió Productos de Distribución';
            }
            echo '</tr>';
            echo '<tr><td colspan="9"><div class="commenthidden" id="UniqueName' . $a . '"><table width="100%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	  <tr>
		<th width="45%" class="formatoEncabezados">Productos Novaquim</th>
		<th width="10%" class="formatoEncabezados"></th>
		<th width="45%" class="formatoEncabezados">Productos de Distribución</th>
	  </tr>';
            echo '<tr>
	  <td class="formatoDatos"><div align="center">' . $opciones_prod . '</div></td>
	  <td class="formatoDatos"><div align="center">' . '</div></td>
	  <td class="formatoDatos"><div align="left">' . $opciones_dist . '</div></td>
	  </tr>';
            echo '</table></div></td></tr>';
            $a = $a + 1;
        }
        mysqli_close($link);//Cerrar la conexion
        */?>
    </table>
    <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
    </div>-->
</div>
</body>
</html>
