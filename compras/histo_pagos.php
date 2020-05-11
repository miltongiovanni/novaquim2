<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Histórico de Comprobantes de Egreso</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
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
                            let rep = '<form action="consultaEgreso.php" method="post" name="elimina">' +
                                '          <input name="idEgreso" type="hidden" value="' + row.idEgreso + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Consultar">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "idEgreso",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "idCompra",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "tipoComp",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nitProv",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "numFact",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "vreal",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "pago",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "descuento",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechPago",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "formaPago",
                        "className": 'dt-body-center'
                    },

                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="Imp_Egreso.php" method="post" target="_blank" name="impEgreso">' +
                                '          <input name="idEgreso" type="hidden" value="' + row.idEgreso + '">' +
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
                "ajax": "ajax/listaEgresos.php"
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>HISTÓRICO DE COMPROBANTES DE EGRESO</strong></div>
    <div class="row" style="justify-content: flex-end;">
        <div class="col-2">
            <form action="fech_histo_pagos_Xls.php" method="post" target="_blank">
                <button class="button" type="submit">
                    <span><STRONG>Exportar a Excel</STRONG></span></button>
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
                <th width="2%"></th>
                <th width="4%">Id</th>
                <th width="4%">Id Compra</th>
                <th width="8%">Tipo Compra</th>
                <th width="6%">Nit</th>
                <th width="26%">Proveedor</th>
                <th width="6%">Factura</th>
                <th width="7%">Valor a Pagar</th>
                <th width="7%">Valor Pagado</th>
                <th width="7%">Descuento</th>
                <th width="6%">Fecha Pago</th>
                <th width="7%">Forma de Pago</th>
                <th width="2%"></th>
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


<!--    <table border="0" cellspacing="0" cellpadding="0" align="center" summary="encabezado" width="100%">
        <tr>
            <td width="93%" align="right">
                <form action="fech_histo_pagos_Xls.php" method="post"><input name="Submit" type="submit"
                                                                             class="resaltado" value="Exportar a Excel">
                </form>
            </td>
            <td width="7%">
                <div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'"
                                          value="Ir al Men&uacute;"></div>
            </td>
        </tr>
    </table>

    <table border="0" align="center" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <th width="4%" class="formatoEncabezados">Id</th>
            <th width="9%" class="formatoEncabezados">Nit</th>
            <th width="25%" class="formatoEncabezados">Proveedor</th>
            <th width="5%" class="formatoEncabezados">Factura</th>
            <th width="9%" class="formatoEncabezados">Total</th>
            <th width="9%" class="formatoEncabezados">Valor Pagado</th>
            <th width="8%" class="formatoEncabezados">Fecha Compra</th>
            <th width="8%" class="formatoEncabezados">Fecha Vto</th>
            <th width="8%" class="formatoEncabezados">Fecha Canc</th>
            <th width="8%" class="formatoEncabezados">Forma de Pago</th>
            <th width="7%" class="formatoEncabezados">&nbsp;</th>
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
        $sql = " select idEgreso as Id, nit_prov as Nit, Nom_provee as Proveedor, numFact as Factura, totalCompra as Total, pago as 'Valor Pagado', fechComp as 'Fecha Compra', fechVenc as 'Fecha Vencimiento', fechPago as 'Fecha Canc', formaPago as 'Forma de Pago' 
from egreso, compras, proveedores, form_pago 
WHERE egreso.idCompra=compras.idCompra and nit_prov=nitProv and tipoCompra<6 and formPago=Id_fpago
union
select idEgreso as Id, nit_prov as Nit, Nom_provee as Proveedor, numFact as Factura, totalGasto as Total, pago as 'Valor Pagado', fechGasto as 'Fecha Compra', fechVenc as 'Fecha Vencimiento', fechPago as 'Fecha Canc', forma_pago as 'Forma de Pago'
from egreso, gastos, proveedores, form_pago 
WHERE egreso.idCompra=gastos.idGasto and nit_prov=nitProv and tipoCompra=6 and formPago=Id_fpago order by Id DESC;";
        //llamar funcion de tabla
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
                    echo "<a href='histo_pagos.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;";
            }
        }
        echo '</div>';

        //construyo la sentencia SQL
        $ssql = "select idEgreso as Id, nit_prov as Nit, Nom_provee as Proveedor, numFact as Factura, totalCompra as Total, pago as 'Valor Pagado', fechComp as 'Fecha Compra', fechVenc as 'Fecha Vencimiento', fechPago as 'Fecha Canc', forma_pago as 'Forma de Pago' 
from egreso, compras, proveedores, form_pago 
WHERE egreso.idCompra=compras.idCompra and nit_prov=nitProv and tipoCompra<6 and formPago=idFormaPago
union
select idEgreso as Id, nit_prov as Nit, Nom_provee as Proveedor, numFact as Factura, totalGasto as Total, pago as 'Valor Pagado', fechGasto as 'Fecha Compra', fechVenc as 'Fecha Vencimiento', fechPago as 'Fecha Canc', forma_pago as 'Forma de Pago'
from egreso, gastos, proveedores, form_pago 
WHERE egreso.idCompra=gastos.idGasto and nit_prov=nitProv and tipoCompra=6 and formPago=idFormaPago order by Id DESC limit " . $inicio . "," . $TAMANO_PAGINA;
        $rs = mysqli_query($link, $ssql);
        $a = 1;
        while ($row = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
            $nit = $row['Nit'];
            $egreso = $row['Id'];
            echo '<tr';
            if (($a % 2) == 0) echo ' bgcolor="#B4CBEF" ';
            echo '>
	<td class="formatoDatos"><div align="center">' . $row['Id'] . '</div></td>
	
	<td class="formatoDatos"><div align="center">' . $row['Nit'] . '</div></td>
	<td class="formatoDatos"><div align="left">' . $row['Proveedor'] . '</div></td>	
	<td class="formatoDatos"><div align="center">' . $row['Factura'] . '</div></td>
	<td class="formatoDatos"><div align="center">$ ' . number_format($row['Total'], 0, '.', ',') . '</div></td>
	<td class="formatoDatos"><div align="center">$ ' . number_format($row['Valor Pagado'], 0, '.', ',') . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Fecha Compra'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Fecha Vencimiento'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Fecha Canc'] . '</div></td>
	<td class="formatoDatos"><div align="center">' . $row['Forma de Pago'] . '</div></td>
	<td class="formatoDatos"><div align="center"><form action="Imp_Egreso.php" method="post" target="_blank" name="imprime' . $a . '"><input name="egreso" type="hidden" value="' . $egreso . '"><input name="Submit" type="submit" value="Imprimir" class="formatoBoton"></form></div></td>
	';

            echo '</tr>';
            echo '</tr>';
            $a = $a + 1;
        }

        */?>
    </table>

    <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'"
                               value="Ir al Men&uacute;"></div>-->
</div>
</body>
</html>