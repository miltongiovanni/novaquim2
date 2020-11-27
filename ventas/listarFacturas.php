<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Facturas de Venta</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        #example {
            table-layout: fixed;
        }

        .width1 {
            width: 2%;
        }

        .width2 {
            width: 5%;
        }

        .width3 {
            width: 5%;
        }

        .width4 {
            width: 5%;
        }

        .width5 {
            width: 30%;
        }

        .width6 {
            width: 10%;
        }

        .width7 {
            width: 10%;
        }

        .width8 {
            width: 10%;
        }
        .width9 {
            width: 10%;
        }
    </style>
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
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact formatoDatos" style="padding-left:50px;width:50%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Código</th>' +
                '<th align="center">Producto</th>' +
                '<th align="center">Cantidad</th>' +
                '<th align="center">Precio Venta</th>' +
                '</thead>';
            for(i=0; i<d.detFactura.length; i++){
                rep += '<tr>' +
                    '<td align="center">' + d.detFactura[i].codProducto + '</td>' +
                    '<td align="left">' + d.detFactura[i].Producto + '</td>' +
                    '<td align="center">' + d.detFactura[i].cantProducto + '</td>' +
                    '<td align="center">' + d.detFactura[i].precioProducto + '</td>' +
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
                        "data": "idFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "idPedido",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "idRemision",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "fechaFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaVenc",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "totalFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "estadoFactura",
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
                "ajax": "ajax/listaFacturas.php",
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
    <div id="saludo1"><strong>LISTA DE FACTURAS DE VENTA</strong></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Factura</th>
                <th class="width3">Pedido</th>
                <th class="width4">Remision</th>
                <th class="width5">Cliente</th>
                <th class="width6">Fecha Factura</th>
                <th class="width7">Fecha Vencimiento</th>
                <th class="width8">Total</th>
                <th class="width9">Estado</th>
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
    <!--<table align="center" width="700" border="0">
        <tr>
            <td>
                <div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'"
                                          value="Ir al Menú"></div>
            </td>
        </tr>
    </table>
    <table border="0" align="center" cellspacing="0" cellpadding="0">
        <tr>
            <th width="8" class="formatoEncabezados"></th>
            <th width="50" class="formatoEncabezados">Factura</th>
            <th width="49" class="formatoEncabezados">Pedido</th>
            <th width="61" class="formatoEncabezados">Remisión</th>
            <th width="379" class="formatoEncabezados">Cliente</th>
            <th width="113" class="formatoEncabezados">Fecha Factura</th>
            <th width="113" class="formatoEncabezados">Fecha Vencimiento</th>
            <th width="178" class="formatoEncabezados">Vendedor</th>
            <th width="89" class="formatoEncabezados">Total</th>
            <th width="42" class="formatoEncabezados">Estado</th>
        </tr>
        <?php
/*        include "includes/utilTabla.php";
        include "includes/conect.php";
        //Limito la busqueda
        $TAMANO_PAGINA = 20;

        //examino la página a mostrar y el inicio del registro a mostrar
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else
            $pagina = NULL;

        if (!$pagina) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
        }
        $link = conectarServidor();
        $sql = "	select idFactura, idPedido, Nit_cliente, fechaFactura, fechaVenc, idRemision, ordenCompra, nomCliente, telCliente, dirCliente, 
		Ciudad, nom_personal as vendedor, Total, factura.Estado 
		from factura, clientes, personal,ciudades
		where Nit_cliente=nitCliente and idCiudad=ciudadCliente and codVendedor=Id_personal  and idCatCliente<>13 ORDER BY idFactura desc";
        $result = mysqli_query($link, $sql);
        $num_total_registros = mysqli_num_rows($result);
        //calculo el total de páginas
        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

        //muestro los distintos índices de las páginas, si es que hay varias páginas
        echo '<div id="paginas" align="center">';
        if ($total_paginas > 1) {
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($pagina == $i)
                    //si muestro el índice de la página actual, no coloco enlace
                    echo $pagina . " ";
                else
                    //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
                    echo "<a href='listarFacturas.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;";
            }
        }
        echo '</div>';

        //construyo la sentencia SQL
        $ssql = "	select idFactura, idPedido, Nit_cliente, fechaFactura, fechaVenc, idRemision, ordenCompra, nomCliente, telCliente, dirCliente, 
		Ciudad, nom_personal as vendedor, Total, factura.Estado 
		from factura, clientes, personal,ciudades
		where Nit_cliente=nitCliente and idCiudad=ciudadCliente and codVendedor=Id_personal  and idCatCliente<>13 ORDER BY idFactura desc limit " . $inicio . "," . $TAMANO_PAGINA;
        $rs = mysqli_query($link, $ssql);
        $a = 1;
        while ($row = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
            $factura = $row['Factura'];
            $Tot = number_format($row['Total'], 0, '.', ',');
            echo '<tr';
            if (($a % 2) == 0) echo ' bgcolor="#B4CBEF" ';
            echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments(' . "'" . 'UniqueName' . $a . "'" . ')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">' . $row['Factura'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Id_pedido'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Id_remision'] . '</div></td>
	<td class="formatoDatos"><div align="left">' . $row['Nom_clien'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Fech_fact'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Fech_venc'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['vendedor'] . '</div></td>
	<td class="formatoDatos"><div align="center">$ ' . $Tot . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Estado'] . '</div></td>
	';

            echo '</tr>';
            $sqli = "select idFactura, codProducto, cantProducto, Nombre as Producto, tasa, precioProducto, Descuento 
	from det_factura, prodpre, tasa_iva, factura 
	where idFactura=idFactura and idFactura=$factura and codProducto<100000 and codProducto=Cod_prese and Cod_iva=Id_tasa 
	UNION 
	select idFactura, codProducto, cantProducto, Producto, tasa, precioProducto, Descuento 
	from det_factura, distribucion, tasa_iva, factura 
	where idFactura=idFactura and idFactura=$factura and codProducto>100000 and codProducto<1000000 AND codProducto=Id_distribucion AND Cod_iva=Id_tasa
	union
select idFactura, codProducto, cantProducto, DesServicio as Producto, tasa, precioProducto, Descuento 
	from det_factura, servicios, tasa_iva, factura 
	where idFactura=idFactura and idFactura=$factura and codProducto<100 AND codProducto=IdServicio AND Cod_iva=Id_tasa";
            $resulti = mysqli_query($link, $sqli);
            echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName' . $a . '"><table width="75%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="8%" class="formatoEncabezados">Código</th>
	  <th width="60%" class="formatoEncabezados">Producto</th>
      <th width="6%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
            while ($rowi = mysqli_fetch_array($resulti, MYSQLI_BOTH)) {
                echo '<tr>
	<td class="formatoDatos"><div align="center">' . $rowi['Cod_producto'] . '</div></td>
	<td class="formatoDatos"><div align="left">' . $rowi['Producto'] . '</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit(' . $rowi['Can_producto'] . '))</script></div></td>

	</tr>';
            }
            echo '</table></div></td></tr>';
            $a = $a + 1;
        }
        mysqli_free_result($result);
        mysqli_free_result($resulti);
        mysqli_close($link);//Cerrar la conexion
        */?>

    </table>-->
</div>
</body>
</html>