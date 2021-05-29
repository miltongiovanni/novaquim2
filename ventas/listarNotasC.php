<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Notas Crédito</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
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
            width: 40%;
        }

        .width4 {
            width: 10%;
        }

        .width5 {
            width: 9%;
        }

        .width6 {
            width: 9%;
        }

        .width7 {
            width: 15%;
        }

        .width8 {
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
                '</thead>';
            for(i=0; i<d.detNotaCr.length; i++){
                rep += '<tr>' +
                    '<td align="center">' + d.detNotaCr[i].codigo + '</td>' +
                    '<td align="left">' + d.detNotaCr[i].producto + '</td>' +
                    '<td align="center">' + d.detNotaCr[i].cantidad + '</td>' +
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
                        "data": "idNotaC",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "fechaNotaC",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "facturaOrigen",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "facturaDestino",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "motivo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "totalNotaC",
                        "className": 'dt-body-right'
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
                "ajax": "ajax/listaNotasCredito.php",
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
<div id="contenedor" class="container-fluid">
    <div id="saludo1"><h4>LISTA DE NOTAS CRÉDITO</h4></div>

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
                <th class="width1"></th>
                <th class="width2">Nota Crédito</th>
                <th class="width3">Cliente</th>
                <th class="width4">Fecha</th>
                <th class="width5">Factura Origen</th>
                <th class="width6">Factura Afecta</th>
                <th class="width7">Motivo</th>
                <th class="width8">Valor</th>
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


    <!--<table align="center" width="700" border="0" summary="encabezado">
        <tr>
            <td>
                <div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'"
                                          value="Ir al Menú"></div>
            </td>
        </tr>
    </table>
    <table border="0" align="center" cellspacing="0" cellpadding="0" summary="Cuerpo">
        <tr>
            <th width="8" class="formatoEncabezados"></th>
            <th width="95" class="formatoEncabezados">Nota Crédito</th>
            <th width="379" class="formatoEncabezados">Cliente</th>
            <th width="113" class="formatoEncabezados">Fecha</th>
            <th width="110" class="formatoEncabezados">Factura Origen</th>
            <th width="110" class="formatoEncabezados">Factura Afecta</th>
            <th width="160" class="formatoEncabezados">Motivo</th>
            <th width="160" class="formatoEncabezados">Valor</th>
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
        $sql = "	select idNotaC, nomCliente, fechaNotaC, facturaOrigen, facturaDestino, Motivo, totalNotaC from nota_c, clientes where Nit_cliente=nitCliente order by idNotaC DESC;";
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
                    echo "<a href='listarNotasC.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;";
            }
        }
        echo '</div>';

        $ssql = "	select idNotaC, nomCliente, fechaNotaC, facturaOrigen, facturaDestino, Motivo, totalNotaC from nota_c, clientes where Nit_cliente=nitCliente order by idNotaC DESC limit " . $inicio . "," . $TAMANO_PAGINA;
        $rs = mysqli_query($link, $ssql);


        $a = 1;
        while ($row = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
            $mensaje = $row['Nota'];
            if ($row['Motivo'] == 0)
                $motivo = "Devolución";
            else
                $motivo = "Descuento no aplicado";
            $Tot = number_format($row['Total'], 0, '.', ',');
            echo '<tr';
            if (($a % 2) == 0) echo ' bgcolor="#B4CBEF" ';
            echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments(' . "'" . 'UniqueName' . $a . "'" . ')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">' . $row['Nota'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Nom_clien'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Fecha'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Fac_orig'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Fac_dest'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $motivo . '</div></td>
	<td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit(' . round($row['Total'], 0) . '))</script></div></td>';

            echo '</tr>';
            $sqli = "select det_nota_c.codProducto as codigo, Nombre as producto, det_nota_c.cantProducto as cantidad 
	FROM det_nota_c, nota_c, det_factura, prodpre
	where idNotaC=idNotaC and idNotaC=$mensaje and det_nota_c.codProducto<100000 and det_nota_c.codProducto>0  AND det_nota_c.codProducto=Cod_prese 
	union
	select det_nota_c.codProducto as codigo, Producto as producto,det_nota_c.cantProducto as cantidad
	from det_nota_c, nota_c, det_factura, distribucion
	where idNotaC=idNotaC and idNotaC=$mensaje and det_nota_c.codProducto>100000 AND det_nota_c.codProducto=Id_distribucion
	union
	select codProducto as codigo, CONCAT ('Descuento de ', cantProducto, '% no aplicado en la factura')  as producto, cantProducto AS cantidad from det_nota_c where idNotaC=$mensaje AND codProducto=0";
            $resulti = mysqli_query($link, $sqli);
            echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName' . $a . '"><table width="750" border="0" align="center" cellspacing="0" summary="Detalle">
	<tr>
      <th width="40" class="formatoEncabezados">Código</th>
	  <th width="250" class="formatoEncabezados">Producto</th>
      <th width="40" class="formatoEncabezados">Cantidad</th>
  	</tr>';
            while ($rowi = mysqli_fetch_array($resulti, MYSQLI_BOTH)) {
                echo '<tr>
	<td class="formatoDatos"><div align="center">' . $rowi['codigo'] . '</div></td>
	<td class="formatoDatos"><div align="left">' . $rowi['producto'] . '</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit(' . $rowi['cantidad'] . '))</script></div></td>

	</tr>';
            }
            echo '</table></div></td></tr>';
            $a = $a + 1;
        }
        mysqli_free_result($result);
        mysqli_free_result($resulti);
        mysqli_close($link);//Cerrar la conexion
        */?>

    </table>
    <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
    </div>-->
</div>
</body>
</html>