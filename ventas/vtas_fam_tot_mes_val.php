<?php
include "../includes/valAcc.php";
$year = $_POST['year'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de Venta de Productos por Referencia</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 19.7%;
        }

        .width2 {
            width: 1.3%;
        }

        .width3 {
            width: 5.65%;
        }
        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 2px 15px 2px 2px;
        }
        table.dataTable.compact tbody th, table.dataTable.compact tbody td {
            padding: 2px;
        }
    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script> <!--Para exportar Excel-->
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../js/buttons.html5.js"></script>
    <script>

        $(document).ready(function () {
            let year = <?=$year?>;
            let ruta = "ajax/listaVtasFamNovaXMes.php?year=" + year;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "producto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_enero",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": function (row) {
                            let rep = '$ ' +commaSplit(Math.round(row.sub_enero));
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_febrero",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_febrero",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_marzo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_marzo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_abril",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_abril",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_mayo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_mayo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_junio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_junio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_julio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_julio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_agosto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_agosto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_septiembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_septiembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_octubre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_octubre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_noviembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_noviembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_diciembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_diciembre",
                        "className": 'dt-body-center'
                    },
                ],
/*                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 1
                } ],*/
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "order": [[2, 'desc']],
                "deferRender": true,  //For speed
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
                "ajax": ruta
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>CONSULTA DE VENTAS POR FAMILIA DE PRODUCTOS POR MES AÑO <?=$year?></strong></div>
    <div class="tabla-100">
        <table id="example" class="display compact formatoDatos5">
            <thead>
            <tr>
                <th class="width1" rowspan="2">Producto</th>
                <th colspan="2">Enero</th>
                <th colspan="2">Febrero</th>
                <th colspan="2">Marzo</th>
                <th colspan="2">Abril</th>
                <th colspan="2">Mayo</th>
                <th colspan="2">Junio</th>
                <th colspan="2">Julio</th>
                <th colspan="2">Agosto</th>
                <th colspan="2">Septiembre</th>
                <th colspan="2">Octubre</th>
                <th colspan="2">Noviembre</th>
                <th colspan="2">Diciembre</th>
            </tr>
            <tr>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="window.location='../menu.php'"><span>Terminar</span>
            </button>
        </div>
    </div>

 <!--
    <table width="100%" align="center" border="0">
        <tr>
            <form action="vtas_fam_tot_mes_Xls.php" method="post" target="_blank">
                <td width="91%" align="right"><input name="Submit" type="submit" class="resaltado"
                                                     value="Exportar a Excel"></td>
                <input name="FchIni" type="hidden" value="<?php /*echo $FchIni */?>"><input name="FchFin" type="hidden"
                                                                                        value="<?php /*echo $FchFin */?>">
            </form>
            <td width="9%">
                <div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'"
                                          value="Ir al Menú"></div>
            </td>
        </tr>
    </table>
    <table border="0" align="center" cellspacing="0">
        <?php
/*        include "includes/utilTabla.php";
        include "includes/conect.php";
        include "includes/calcularDias.php";
        $fecha2 = explode('-', $FchFin);
        $fecha1 = explode('-', $FchIni);
        $mes1 = $fecha1[1];
        $mes2 = $fecha2[1];
        echo '<tr>';
        //echo '<th class="formatoEncabezados" rowspan="2">Código</th>';
        echo '<th class="formatoEncabezados" rowspan="2">Producto</th>';

        for ($m = $mes1; $m <= $mes2; $m++) {
            echo '<th class="formatoEncabezados" colspan="2">Venta Mes ' . $m . '</th>';

        }
        echo '</tr><tr>';
        for ($n = $mes1; $n <= $mes2; $n++) {
            echo '<th class="formatoEncabezados">Un </th><th class="formatoEncabezados">Total</th>';

        }
        echo '</tr>';
        //$meses=$mes2-$mes1;
        //echo "Mes inicial ".$fecha1[1];
        //echo "Mes final ".$fecha2[1];
        //echo "Estos son los meses ".$meses;
        //parametros iniciales que son los que cambiamos
        $link = conectarServidor();
        //sentencia SQL    tblusuarios.IdUsuario,
        $sql = "select codigo_ant, producto from precios where pres_activa=0 order by producto;";
        $result = mysqli_query($link, $sql);
        $a = 1;
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $codigo_ant = $row['codigo_ant'];
            $producto = $row['producto'];
            //$PrComp=number_format($row['precio_com'], 0, '.', ',');
            //$PrVta=number_format($row['prec_venta'], 0, '.', ',');
            $mes = $fecha1[1];
            echo '<tr';
            if (($a++ % 2) == 0) echo ' bgcolor="#B4CBEF" ';
            echo '>';
            //echo '<td class="formatoDatos"><div align="center">'.$codigo_ant.'</div></td>';
            echo '<td class="formatoDatos"><div align="left">' . $producto . '</div></td>';
            for ($b = $mes1; $b <= $mes2; $b++) {
                $sqlv = "select sum(cantProducto) as cant, sum(precioProducto*cantProducto) as sub
from det_factura, factura, prodpre where idFactura=idFactura and  fechaFactura>='$FchIni' and fechaFactura<='$FchFin' and Cod_prese=codProducto and month(fechaFactura)=$b and Cod_ant=$codigo_ant";
//echo $sqlv."<br>";
                $resultv = mysqli_query($link, $sqlv);
                $rowv = mysqli_fetch_array($resultv, MYSQLI_BOTH);
                $cant = $rowv['cant'];
                $sub = $rowv['sub'];
                if ($cant == NULL) {
                    $cant = 0;
                    $sub = 0;
                }
                echo '<td class="formatoDatos"><div align="center"> ' . round($cant) . '</div></td>
	  <td class="formatoDatos"><div align="center">$ ' . round($sub) . '</div></td>';
            }
            echo '</tr>';

        }
        mysqli_free_result($result);
        mysqli_free_result($resultv);
        mysqli_close($link);
        */?>

    </table>
    <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
    </div>-->
</div>
</body>
</html>