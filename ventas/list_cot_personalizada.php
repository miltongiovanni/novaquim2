<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Cotizaciones Personalizadas</title>
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
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact" style="padding-left:50px;width:50%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Código</th>' +
                '<th align="center">Producto</th>' +
                '<th align="center">Cantidad</th>' +
                '<th align="center">Precio</th>' +
                '</thead>';
            for(i=0; i<d.detCotPersonalizada.length; i++){
                rep += '<tr>' +
                    '<td align="center">' + d.detCotPersonalizada[i].codProducto + '</td>' +
                    '<td align="left">' + d.detCotPersonalizada[i].producto + '</td>' +
                    '<td align="center">' + d.detCotPersonalizada[i].canProducto + '</td>' +
                    '<td align="right">' + d.detCotPersonalizada[i].precioProducto + '</td>' +
                    '</tr>'
            }

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
                        "data": "idCotPersonalizada",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
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
                        "data": "tipPrecio",
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
                "ajax": "ajax/listaCotizacionesPersonalizadas.php"
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
    <div id="saludo1"><strong>LISTA DE COTIZACIONES PERSONALIZADAS</strong></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-80">
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
    <!--<table align="center" width="100%" border="0">
        <tr>
            <td>
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
        </tr>
        <?php
/*        include "includes/utilTabla.php";
        include "includes/conect.php";
        $link = conectarServidor();
        $sql = "select idCotPersonalizada, nomCliente, desCatClien, nom_personal, fechaCotizacion, tipPrecio, destino
	from cot_personalizada, clientes_cotiz, Personal, cat_clien 
	where idCliente=idCliente and codVendedor=Id_personal and idCatCliente=idCatClien order by idCotPersonalizada desc;";
        //llamar funcion de tabla
        $result = mysqli_query($link, $sql);
        $a = 1;
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $cot_per = $row['Id_Cotiz_p'];
            echo '<tr';
            if (($a % 2) == 0) echo ' bgcolor="#B4CBEF" ';
            echo '>
	  <td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments(' . "'" . 'UniqueName' . $a . "'" . ')">+/-</a></div></td>
	  <td class="formatoDatos"><div align="center">' . $row['Id_Cotiz_p'] . '</div></td>
	  <td class="formatoDatos"><div align="left">' . $row['Nom_clien'] . '</div></td>
	  <td class="formatoDatos"><div align="center">' . $row['Des_cat_cli'] . '</div></td>
	  <td class="formatoDatos"><div align="center">' . $row['nom_personal'] . '</div></td>
	  <td class="formatoDatos"><div align="center">' . $row['Fech_Cotizacion'] . '</div></td>';
            if ($row['tip_precio'] == 1) $precio = "Fábrica";
            if ($row['tip_precio'] == 2) $precio = "Distribuidor";
            if ($row['tip_precio'] == 3) $precio = "Detal";
            if ($row['tip_precio'] == 4) $precio = "Mayorista";
            if ($row['tip_precio'] == 5) $precio = "Super";
            echo '<td class="formatoDatos"><div align="center">' . $precio . '</div></td>';
            echo '</tr>';
            $sqli = "select idCotPersonalizada, codProducto, Nombre as Producto, canProducto, precioProducto from det_cot_personalizada, prodpre where idCotPersonalizada=$cot_per and codProducto <100000 AND codProducto=Cod_prese
	UNION
	select idCotPersonalizada, codProducto, Producto, canProducto, precioProducto from det_cot_personalizada, distribucion where idCotPersonalizada=$cot_per and codProducto >=100000 and codProducto=Id_distribucion;";
            $resulti = mysqli_query($link, $sqli);
            echo '<tr><td colspan="9"><div class="commenthidden" id="UniqueName' . $a . '"><table width="100%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	  <tr>
      <th width="6%" class="formatoEncabezados">Código</th>
	  <th width="50%" class="formatoEncabezados">Producto</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="15%" class="formatoEncabezados">Precio Venta</th>
  	</tr>';
            while ($rowi = mysqli_fetch_array($resulti, MYSQLI_BOTH)) {
                echo '<tr>
	<td class="formatoDatos"><div align="center">' . $rowi['Cod_producto'] . '</div></td>
	<td class="formatoDatos"><div align="left">' . $rowi['Producto'] . '</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit(' . $rowi['Can_producto'] . '))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit(' . $rowi['Prec_producto'] . '))</script></div></td>
	</tr>';
            }
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
