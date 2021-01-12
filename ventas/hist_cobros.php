<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Histórico de Recibos de caja</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 5%;
        }

        .width2 {
            width: 6%;
        }

        .width3 {
            width: 6%;
        }

        .width4 {
            width: 32%;
        }

        .width5 {
            width: 8%;
        }

        .width6 {
            width: 8%;
        }

        .width7 {
            width: 10%;
        }

        .width8 {
            width: 5%;
        }


        table.dataTable.compact thead th,
        table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
    </style>
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
        function diffDate(fecha) {
            let fechVenc = new Date(fecha);
            let hoy = new Date();

            // The number of milliseconds in one day
            const ONE_DAY = 1000 * 60 * 60 * 24;

            // Calculate the difference in milliseconds
            const differenceMs = fechVenc - hoy;
            // Convert back to days and return
            return Math.round(differenceMs / ONE_DAY);
        }

        $(document).ready(function () {

            var table = $('#example').DataTable({
                "columns": [
                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="recibo_caja.php" method="post" name="consulta">' +
                                '          <input name="idRecCaja" type="hidden" value="' + row.idRecCaja + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Consultar">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "idRecCaja",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "idFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "pago",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaRecCaja",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "formaPago",
                        "className": 'dt-body-center'
                    },

                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="Imp_Recibo_Caja.php" method="post" target="_blank" name="impRecCaja">' +
                                '          <input name="idRecCaja" type="hidden" value="' + row.idRecCaja + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Imprimir">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                ],

                "order": [[1, 'desc']],
                "deferRender": true,  //For speed
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5',
                    /*'pdfHtml5'*/
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
                "createdRow": function (row, data, dataIndex) {
                    if (diffDate(data.fechVenc) < 0) {
                        $('td', row).addClass('formatoDataTable1');
                    } else if (diffDate(data.fechVenc) >= 0 && diffDate(data.fechVenc) < 8) {
                        $('td', row).addClass('formatoDataTable2');
                    }
                },
                "ajax": "ajax/listaRecCaja.php"
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>HISTÓRICO DE RECIBOS DE CAJA</strong></div>
    <div class="row flex-end">
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
                <th class="width2">Id</th>
                <th class="width3">Factura</th>
                <th class="width4">Cliente</th>
                <th class="width5">Pago</th>
                <th class="width6">Fecha</th>
                <th class="width7">Forma de Pago</th>
                <th class="width8"></th>
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

<!--    <table border="0" align="center" cellspacing="0" cellpadding="0" width="67%">
        <tr>
            <th width="5%" class="formatoEncabezados">Id</th>
            <th width="7%" class="formatoEncabezados">Factura</th>
            <th width="46%" class="formatoEncabezados">Cliente</th>
            <th width="9%" class="formatoEncabezados">Pago</th>
            <th width="8%" class="formatoEncabezados">Fecha</th>
            <th width="15%" class="formatoEncabezados">Forma de Pago</th>
            <th width="10%" class="formatoEncabezados">&nbsp;</th>
        </tr>


        <?php
/*        include "includes/utilTabla.php";
        include "includes/conect.php";
        //Limito la busqueda
        $TAMANO_PAGINA = 19;

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
        $sql = "	select idRecCaja as 'Id', idFactura as Factura, nomCliente as Cliente, CONCAT('$ ', FORMAT(cobro,0)) as Pagos, fechaRecCaja, formaPago as 'Forma de Pago' 
from r_caja, factura, clientes, form_pago where idFactura=idFactura and Nit_cliente=nitCliente and form_pago=idFormaPago order by Id DESC";
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
                    echo "<a href='hist_cobros.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;";
            }
        }
        echo '</div>';

        //construyo la sentencia SQL
        $ssql = "select idRecCaja as 'Id', idFactura as Factura, nomCliente as Cliente, CONCAT('$ ', FORMAT(cobro,0)) as Pagos, fechaRecCaja, formaPago  
from r_caja, factura, clientes, form_pago where idFactura=idFactura and Nit_cliente=nitCliente and form_pago=idFormaPago order by Id DESC limit " . $inicio . "," . $TAMANO_PAGINA;
        $rs = mysqli_query($link, $ssql);
        $a = 1;
        while ($row = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
            $Recibo = $row['Id'];
            echo '<tr';
            if (($a % 2) == 0) echo ' bgcolor="#B4CBEF" ';
            echo '>
	<td class="formatoDatos"><div align="center">' . $row['Id'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Factura'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Cliente'] . '</div></td>
	<td class="formatoDatos"><div align="left">' . $row['Pagos'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Fecha'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['forma_pago'] . '</div></td>
	<td class="formatoDatos"><div align="center"><form action="Imp_Recibo_Caja.php" method="post" target="_blank" name="imprime' . $a . '"><input name="Recibo" type="hidden" value="' . $Recibo . '"><input name="Submit" type="submit" value="Imprimir" class="formatoBoton"></form></div></td>
	';

            echo '</tr>';
            $a = $a + 1;
        }

        mysqli_free_result($result);
        mysqli_close($link);//Cerrar la conexion


        */?>
    </table>

    <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
    </div>-->
</div>
</body>
</html>