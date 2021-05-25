<?php
include "../includes/valAcc.php";
include "../includes/calcularDias.php";
$idCliente = $_POST['idCliente'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$OperadorCliente = new ClientesOperaciones();
$cliente = $OperadorCliente->getCliente($idCliente);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Estado de Cuenta por Cliente</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
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
            width: 8%;
        }

        .width3 {
            width: 10%;
        }

        .width4 {
            width: 10%;
        }

        .width5 {
            width: 10%;
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

        .width10 {
            width: 10%;
        }

        .width11 {
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
                '<th align="center">Recibo de Caja</th>' +
                '<th align="center">Valor</th>' +
                '<th align="center">Fecha</th>' +
                '<th align="center">Forma de pago</th>' +
                '</thead>';
            for (i = 0; i < d.detEstado.length; i++) {
                rep += '<tr>' +
                    '<td align="center">' + d.detEstado[i].idRecCaja + '</td>' +
                    '<td align="left">' + d.detEstado[i].pago + '</td>' +
                    '<td align="center">' + d.detEstado[i].fechaRecCaja + '</td>' +
                    '<td align="center">' + d.detEstado[i].formaPago + '</td>' +
                    '</tr>'
            }

            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {

            let idCliente = <?=$idCliente?>;
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
                        "data": "fechaFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaVenc",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "totalFactura",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "totalReal",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "abono",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "totalNotaC",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "Saldo",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "fechaCancelacion",
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
                "ajax": "ajax/listaEstadoCuentaCliente.php?idCliente=" + idCliente,
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
    <div id="saludo1"><h4>ESTADO DE CUENTA <?= strtoupper($cliente['nomCliente']); ?></h4></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-70">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Factura</th>
                <th class="width3">Fecha Factura</th>
                <th class="width4">Fecha Vencimiento</th>
                <th class="width5">Total Factura</th>
                <th class="width6">Valor a Cobrar</th>
                <th class="width7">Valor cobrado</th>
                <th class="width8">Nota crédito</th>
                <th class="width9">Saldo Pendiente</th>
                <th class="width10">Fecha de Cancelación</th>
                <th class="width11">Estado</th>
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
    <!--<form action="EstadoCuenta_Xls.php" method="post" target="_blank">
        <table width="700" border="0" align="center">
            <tr>
                <td width="473"><input name="cliente" type="hidden" value="<?php /*echo $cliente; */ ?>"></td>
                <td width="127"><input type="submit" name="Submit" value="Exportar a Excel">
                </td>
                <td width="86"><input type="button" onClick="window.location='menu.php'" value="Ir al Menú"></td>
            </tr>
        </table>
    </form>
    <table border="0" align="center" cellspacing="0" cellpadding="0">
        <tr>
            <th width="18" class="formatoEncabezados"></th>
            <th width="59" align="center" class="formatoEncabezados">Factura</th>
            <th width="128" align="center" class="formatoEncabezados">Fecha Factura</th>
            <th width="128" align="center" class="formatoEncabezados">Fecha Vencimiento</th>
            <th width="120" align="center" class="formatoEncabezados">Total Factura</th>
            <th width="120" align="center" class="formatoEncabezados">Valor a Cobrar</th>
            <th width="120" align="center" class="formatoEncabezados">Saldo Pendiente</th>
            <th width="128" align="center" class="formatoEncabezados">Fecha de Cancelación</th>
            <th width="42" align="center" class="formatoEncabezados">Estado</th>
        </tr>
        <?php
    /*        $sql = "	select idFactura, fechaFactura, fechaVenc, Total, (Total-retencionIva-retencionIca-retencionFte) as 'Valor a Cobrar', (Total-retencionIva-retencionIca-retencionFte-(select SUM(cobro) from r_caja where idFactura=idFactura group by idFactura)) as 'Saldo', fechaCancelacion, Estado
    from factura where Nit_cliente='$cliente' ORDER BY idFactura desc;";
            $result = mysqli_query($link, $sql);
            $a = 1;
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                $factura = $row['Factura'];
                if ($row['Estado'] == 'C')
                    $estado = 'Cancelada';
                if ($row['Estado'] == 'P')
                    $estado = 'Pendiente';
                if ($row['Estado'] == 'A')
                    $estado = 'Anulada';
                if ($row['Saldo'] == NULL)
                    $saldo = $row['Valor a Cobrar'];
                else    $saldo = $row['Saldo'];

                if ($row['Fech_Canc'] != '0000-00-00')
                    $cancel = $row['Fech_Canc'];
                else
                    $cancel = NULL;
                $Tot = number_format($row['Total'], 0, '.', ',');
                $Valor = number_format($row['Valor a Cobrar'], 0, '.', ',');
                $Saldo = number_format($row['Saldo'], 0, '.', ',');
                echo '<tr';
                if (($a % 2) == 0) echo ' bgcolor="#B4CBEF" ';
                echo '>
        <td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments(' . "'" . 'UniqueName' . $a . "'" . ')">+/-</a></div></td>
        <td class="formatoDatos"><div align="center">' . $row['Factura'] . '</div></td>
        <td class="formatoDatos"><div align="center">' . $row['Fech_fact'] . '</div></td>
        <td class="formatoDatos"><div align="center">' . $row['Fech_venc'] . '</div></td>
        <td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit(' . $row['Total'] . '))</script></div></td>
        <td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit(' . $row['Valor a Cobrar'] . '))</script></div></td>
        <td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit(' . $saldo . '))</script></div></td>
        <td class="formatoDatos"><div align="center">' . $cancel . '</div></td>
        <td class="formatoDatos"><div align="center">' . $estado . '</div></td>
        ';

                echo '</tr>';
                $sqli = "select idRecCaja, cobro, fechaRecCaja from r_caja where idFactura=$factura";
                $resulti = mysqli_query($link, $sqli);
                echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName' . $a . '"><table border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <th width="40" class="formatoEncabezados">Pago</th>
          <th width="120" class="formatoEncabezados">Fecha</th>
          <th width="160" class="formatoEncabezados">Valor</th>
          </tr>';
                while ($rowi = mysqli_fetch_array($resulti, MYSQLI_BOTH)) {
                    echo '<tr>
        <td class="formatoDatos"><div align="center">' . $rowi['Id_caja'] . '</div></td>
        <td class="formatoDatos"><div align="center">' . $rowi['Fecha'] . '</div></td>
        <td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit(' . $rowi['cobro'] . '))</script></div></td>
        </tr>';
                }
                echo '</table></div></td></tr>';
                $a = $a + 1;
            }
            mysqli_free_result($result);
            /* cerrar la conexión
            mysqli_close($link);
            */ ?>
    </table>
    <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
    </div>-->
</div>
</body>
</html>
