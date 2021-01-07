<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Facturas por Cobrar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        #example {
            table-layout: fixed;
        }

        .width1 {
            width: 3%;
        }

        .width2 {
            width: 3%;
        }

        .width3 {
            width: 6%;
        }

        .width4 {
            width: 6%;
        }

        .width5 {
            width: 29%;
        }

        .width6 {
            width: 13%;
        }

        .width7 {
            width: 5%;
        }

        .width8 {
            width: 7%;
        }

        .width9 {
            width: 7%;
        }

        .width10 {
            width: 7%;
        }

        .width11 {
            width: 7%;
        }

        .width12 {
            width: 7%;
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
            var perfil = <?=$_SESSION['Perfil']?>;
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="recibo_caja1.php" method="post" name="elimina">' +
                                '          <input name="factura" type="hidden" value="' + row.idFactura + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Pagar">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        "visible": (perfil === '1' ||perfil === '11') ? false : true,
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
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "contactoCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "telCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "celCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "totalRFormat",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "TotalFormat",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cobradoFormat",
                        "className": 'dt-body-center'
                    },

                    {
                        "data": "saldo",
                        "className": 'dt-body-center'
                    },
                ],

                "order": [[3, 'asc']],
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
                "ajax": "ajax/listaFactXCobrar.php"
            });
        });
    </script>

</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>FACTURAS PENDIENTES DE COBRO POR INDUSTRIAS NOVAQUIM S.A.S.</strong></div>
    <div class="row flex-end">
        <div class="col-2">
            <form action="Imp_EstadoCobros.php" method="post" target="_blank">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir estado cartera</STRONG></span></button>
            </form>
        </div>
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
                <th class="width3">Fecha de Factura</th>
                <th class="width4">Fecha Venc</th>
                <th class="width5">Cliente</th>
                <th class="width6">Contacto</th>
                <th class="width7">Teléfono</th>
                <th class="width8">Celular</th>
                <th class="width9">Valor Factura</th>
                <th class="width10">Valor a Cobrar</th>
                <th class="width11">Valor Cobrado</th>
                <th class="width12">Saldo</th>
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

    <!--<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo" width="100%">
        <tr>
            <th width="1%" scope="col"></th>
            <th width="4%" align="center" class="formatoEncabezados" scope="col">Factura</th>
            <th width="6%" align="center" class="formatoEncabezados" scope="col">Fecha de Factura</th>
            <th width="6%" align="center" class="formatoEncabezados" scope="col">Fecha Vencimiento</th>
            <th width="27%" align="center" class="formatoEncabezados" scope="col">Cliente</th>
            <th width="14%" align="center" class="formatoEncabezados" scope="col">Contacto</th>
            <th width="4%" align="center" class="formatoEncabezados" scope="col">Teléfono</th>
            <th width="6%" align="center" class="formatoEncabezados" scope="col">Celular</th>
            <th width="8%" align="center" class="formatoEncabezados" scope="col">Valor Factura</th>
            <th width="8%" align="center" class="formatoEncabezados" scope="col">Valor a Cobrar</th>
            <th width="8%" align="center" class="formatoEncabezados" scope="col">Valor Cobrado</th>
            <th width="8%" align="center" class="formatoEncabezados" scope="col">Saldo</th>
        </tr>
        <?php
    /*        include "includes/conect.php";
            $fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
            $total = 0;
            $totalvenc = 0;
            $totalavenc = 0;
            $totalnvenc = 0;
            $link = conectarServidor();
            if ($link) {
                $qry = "select idFactura, nomCliente, contactoCliente, cargoCliente, telCliente, celCliente, fechaFactura, fechaVenc, Total, Descuento, totalR, retencionIva, retencionIca, retencionFte, Subtotal, IVA
                from factura, clientes WHERE Nit_cliente=nitCliente and factura.Estado='P' and idFactura>00;";
                $result = mysqli_query($link, $qry);
                $a = 1;
                while ($row = mysqli_fetch_array($result)) {
                    $factura = $row['Factura'];
                    $fecVen = $row['Fech_venc'];
                    $fact = $row['Factura'];
                    $retefuente = $row['Reten_fte'];
                    $Subtotal = $row['Subtotal'];
                    $totalfac = $row['Total'];
                    $Descuento = $row['Descuento'] * $Subtotal;
                    $Total_R = $row['Total_R'];
                    $reteica = $row['Reten_ica'];
                    $reteiva = $row['Reten_iva'];
                    $qryp = "select sum(cobro) as Parcial from r_caja where idFactura=$fact";
                    $resultpago = mysqli_query($link, $qryp);
                    $rowpag = mysqli_fetch_array($resultpago);
                    if ($rowpag['Parcial'])
                        $parcial = $rowpag['Parcial'];
                    else
                        $parcial = 0;
                    $qrync = "select round(totalNotaC)as pago_nc, fechaNotaC  from nota_c where fechaNotaC>'2016-04-05' and facturaDestino=$fact";
                    //echo " ".$qrync." ";
                    $resultnc = mysqli_query($link, $qrync);
                    $rownc = mysqli_fetch_array($resultnc);
                    if ($rownc['pago_nc']) {
                        $pago_nc = $rownc['pago_nc'];
                        $Fecha_nc = $rownc['Fecha'];
                    } else
                        $pago_nc = 0;
                    if ($factura < 9981) {
                        $ValTot = round($Total_R - $Descuento - $retefuente - $reteiva - $reteica);
                    } else {
                        $ValTot = round($Total_R - $Descuento - $reteiva - $reteica - $retefuente);
                    }
                    $ptotal = $Total_R - $parcial - $pago_nc;
                    if (abs($ptotal) < 1000) {
                        $qryupt = "update factura set Estado='C', fechaCancelacion='$Fecha_nc', retencionIva=0, retencionIca=0, retencionFte=0  where idFactura=$factura";
                        $resulupdate = mysqli_query($link, $qryupt);
                    }
                    $dias = Calc_Dias($fecVen, $fecha_actual);
                    if ($dias < 0) {
                        $formato = "formatoDatos1";
                        $totalvenc = $totalvenc + $ValTot - $parcial - $pago_nc;
                    }
                    if ($dias >= 0 && $dias <= 8) {
                        $formato = "formatoDatos2";
                        $totalavenc = $totalavenc + $ValTot - $parcial - $pago_nc;
                    }
                    if ($dias > 8) {
                        $formato = "formatoDatos";
                        $totalnvenc = $totalnvenc + $ValTot - $parcial - $pago_nc;
                    }
                    $total = $totalvenc + $totalavenc + $totalnvenc;
                    echo '<tr class="' . $formato . '"';
                    echo '><td align="center" valign="middle">';
                    if ((md5(1) == $_SESSION['Perfil']) || (md5(11) == $_SESSION['Perfil'])) {
                        echo '<form action="recibo_caja1.php" method="post" name="apppago' . $a . '">
                        <div align="center">
                            <input class="formatoBoton" type="submit" name="Submit" value="Cobrar" >
                            <input name="Pago" type="hidden" value="0" >
                            <input name="Reten" type="hidden" value="0" >
                            <input name="factura" type="hidden" value="' . $factura . '" >
                               <input name="fecVen" type="hidden" value="' . $fecVen . '" >
                               <input name="ValTot" type="hidden" value="' . $ValTot . '" >
                        </div>
                        </form>';
                    }
                    echo '</td>
                    <td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="center">' . $row['Factura'] . '</div></td>
                    <td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="center">' . $row['Fech_fact'] . '</div></td>
                    <td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="center">' . $row['Fech_venc'] . '</div></td>
                    <td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="left">' . ($row['Nom_clien']) . '</div></td>
                    <td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="left">' . ($row['Contacto']) . '</div></td>
                    <td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="right">' . $row['Tel_clien'] . '</div></td>
                    <td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="right">' . $row['Cel_clien'] . '</div></td>
                    <td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="right">$ <script  > document.write(commaSplit(' . $Total_R . '))</script></div></td>
                    <td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="right">$ <script  > document.write(commaSplit(' . $ValTot . '))</script></div></td>';
                    echo '<td';
                    if (($a % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="right">$ <script  > document.write(commaSplit(' . ($parcial + $pago_nc) . '))</script></div></td>';
                    $saldo = $ValTot - $parcial - $pago_nc;
                    echo '<td';
                    if (($a++ % 2) == 0) echo ' bgcolor="#DFE2FD" ';
                    echo '><div align="right">$ <script  > document.write(commaSplit(' . round($saldo) . '))</script></div></td>';
                    echo '</tr>';
                }
                echo '<tr>
                    <td colspan="5" ></Td>
                    <td colspan="5" class="titulo1" align="right">TOTAL VENCIDO :</Td>
                    <td colspan="2" class="titulo1"><div align="left">$ <script  > document.write(commaSplit(' . $totalvenc . '))</script></div> </td>
                    </tr>';
                echo '<tr>
                    <td colspan="5" ></Td>
                    <td colspan="5" class="titulo2" align="right">TOTAL A VENCER EN UNA SEMANA:</Td>
                    <td colspan="2" class="titulo2"><div align="left">$ <script  > document.write(commaSplit(' . $totalavenc . '))</script></div> </td>
                    </tr>';
                echo '<tr>
                    <td colspan="5" ></Td>
                    <td colspan="5" class="titulo3" align="right">TOTAL SIN VENCER EN UNA SEMANA  :</Td>
                    <td colspan="2" class="titulo3"><div align="left">$ <script  > document.write(commaSplit(' . $totalnvenc . '))</script></div> </td>
                    </tr>';
                echo '<tr>
                    <td colspan="5" ></Td>
                    <td colspan="5" class="titulo" align="right">TOTAL :</Td>
                    <td colspan="2" class="titulo"><div align="left">$ <script  > document.write(commaSplit(' . $total . '))</script></div> </td>
                    </tr>';
                mysqli_free_result($result);
                mysqli_close($link);
            } else {
                echo "La conexion a la base de datos no se pudo realizar";
            }
            */ ?>
    </table>-->
</div>
</body>
</html>
