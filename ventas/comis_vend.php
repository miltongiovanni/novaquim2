<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$personalOperador = new PersonalOperaciones();
$personal = $personalOperador->getPerson($idPersonal);
$totales = $personalOperador->getTotalComisionVendedor($idPersonal, $fechaInicial, $fechaFinal);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de Venta de Productos por Referencia</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 6%;
        }

        .width2 {
            width: 40%;
        }

        .width3 {
            width: 5%;
        }

        .width4 {
            width: 7%;
        }

        .width5 {
            width: 7%;
        }

        .width6 {
            width: 7%;
        }

        .width7 {
            width: 7%;
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

        table.dataTable.compact thead th,
        table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
    </style>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script> <!--Para exportar Excel-->
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../js/buttons.html5.js"></script>
    <script>
        $(document).ready(function () {
            let idPersonal = <?=$idPersonal?>;
            let fechaInicial = '<?=$fechaInicial?>';
            let fechaFinal = '<?=$fechaFinal?>';
            let ruta = "ajax/listaComisionVendedor.php?idPersonal=" + idPersonal + "&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "idFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "desct",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaCancelacion",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "subtot",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "vtaEmpresa",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "vtaDistribucion",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "comEmpresa",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "comDistribucion",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "comTotal",
                        "className": 'dt-body-right'
                    },

                ],
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 2
                }],
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
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

    <div id="saludo1"><strong>CONSULTA DE COMISIONES DEL
            VENDEDOR <?php echo mb_strtoupper($personal['nomPersonal']); ?></strong></div>
    <div class="tabla-100">
        <table id="example" class="display compact">
            <thead>
            <tr>
                <th class="width1">Factura</th>
                <th class="width2">Cliente</th>
                <th class="width3">% Desc</th>
                <th class="width4">Fech Canc</th>
                <th class="width5">Subtotal</th>
                <th class="width6">Vtas Nova</th>
                <th class="width7">Vtas Dist</th>
                <th class="width8">Com Nova</th>
                <th class="width9">Com Dist</th>
                <th class="width10">Com Total</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-100">
        <div class="row formatoDatos">
            <div class="col-10">
                <div class=" text-right">
                    <strong>Comisión Novaquim</strong>
                </div>
            </div>
            <div class="col-1 ml-3 px-0">
                <div class="text-right">
                    <strong><?= $totales['comEmpresa'] ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos">
            <div class="col-10">
                <div class=" text-right">
                    <strong>Comisión distribución</strong>
                </div>
            </div>
            <div class="col-1 ml-3 px-0">
                <div class="text-right">
                    <strong><?= $totales['comDistribucion'] ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos">
            <div class="col-10">
                <div class=" text-right">
                    <strong>Comisión Total</strong>
                </div>
            </div>
            <div class="col-1 ml-3 px-0">
                <div class="text-right">
                    <strong><?= $totales['comTotal'] ?></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button"
                    onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <!--
<table width="100%"  align="center" border="0">
  <tr> 
      <form action="comis_vend_Xls.php" method="post" target="_blank"><td width="91%" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="FchIni" type="hidden" value="<?php /*echo $FchIni */ ?>"><input name="FchFin" type="hidden" value="<?php /*echo $FchFin */ ?>"><input name="vendedor" type="hidden" value="<?php /*echo $vendedor */ ?>"></form>
   <td width="9%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="1" width="100%"> 
<tr>
<th width="5%" class="formatoEncabezados">Factura</th>
<th width="29%" class="formatoEncabezados">Cliente</th>
<th width="5%" class="formatoEncabezados">% Desc</th>
<th width="7%" class="formatoEncabezados">Fech Canc</th>
<th width="7%" class="formatoEncabezados">Total</th>
<th width="7%" class="formatoEncabezados">Subtotal</th>
<th width="7%" class="formatoEncabezados">Vtas Nova</th>
<th width="7%" class="formatoEncabezados">Vtas Dist</th>
<th width="9%" class="formatoEncabezados">Com Nova</th>
<th width="8%" class="formatoEncabezados">Com Dist</th>
<th width="9%" class="formatoEncabezados">Com Total</th>
</tr>
<?php
    /*$link=conectarServidor();
    $database="novaquim";
    //sentencia SQL    tblusuarios.IdUsuario,
    $sql="select idFactura, nomCliente, Descuento, Total, Subtotal, IVA, fechaCancelacion, sum(empresa) as nova, sum(distribucion) as dis, sum(empresa*com_nova) as com_nova, sum(distribucion*com_dist) as com_dist, (sum(empresa*com_nova)+sum(distribucion*com_dist)) as com_tot from
    (select idFactura, nomCliente, Descuento, Total, retencionIva, retencionIca, retencionFte, Subtotal, IVA, fechaCancelacion, sum(cantProducto*precioProducto*(1-Descuento)) as empresa, 0 as distribucion, com_dist, com_nova
    from factura, det_factura, clientes, personal where nitCliente=Nit_cliente and codVendedor=$vendedor and fechaCancelacion>='$FchIni' and fechaCancelacion<='$FchFin' and idFactura=idFactura and codProducto<100000 AND codVendedor=Id_personal group by idFactura
    union
    select idFactura, nomCliente, Descuento, Total, retencionIva, retencionIca, retencionFte, Subtotal, IVA, fechaCancelacion, 0 as empresa, sum(cantProducto*precioProducto*(1-Descuento)) as distribucion, com_dist, com_nova
    from factura, det_factura, clientes, personal where nitCliente=Nit_cliente and codVendedor=$vendedor and fechaCancelacion>='$FchIni' and fechaCancelacion<='$FchFin' and idFactura=idFactura and codProducto>100000 AND codVendedor=Id_personal group by idFactura) as tabla group by idFactura;
    ";
    $result=mysqli_query($link,$sql);
    $sum_com_dist=0;
    $sum_com_nova=0;
    $sum_com_tot=0;
    $a=1;
    while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
    {
        $Factura=$row['Factura'];
        $Nom_clien=$row['Nom_clien'];
        $Descuento=$row['Descuento'];
        $Fech_Canc=$row['Fech_Canc'];
        $VlrTotal=number_format($row['Total'], 0, '.', ',');
        $VlrSubtotal=number_format($row['Subtotal'], 0, '.', ',');
        $Vlrnova=number_format($row['nova'], 0, '.', ',');
        $Vlrdis=number_format($row['dis'], 0, '.', ',');
        $Vlrcom_nova=number_format($row['com_nova'], 0, '.', ',');
        $Vlrcom_dist=number_format($row['com_dist'], 0, '.', ',');
        $Vlrcom_tot=number_format($row['com_tot'], 0, '.', ',');
        $sum_com_nova+=$row['com_nova'];
        $sum_com_dist+=$row['com_dist'];
        $sum_com_tot+=$row['com_tot'];
        //$mes=$fecha1[1];
        echo'<tr';
        if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
        echo '>';
        //echo '<td class="formatoDatos"><div align="center">'.$codigo_ant.'</div></td>';
        echo '<td class="formatoDatos"><div align="center">'.$Factura.'</div></td>';
        echo '<td class="formatoDatos"><div align="left">'.$Nom_clien.'</div></td>';
        echo '<td class="formatoDatos"><div align="center">'.($Descuento*100).' %</div></td>';
        echo '<td class="formatoDatos"><div align="center">'.$Fech_Canc.'</div></td>';
        echo '<td class="formatoDatos"><div align="center">$ '.$VlrTotal.'</div></td>';
        echo '<td class="formatoDatos"><div align="center">$ '.$VlrSubtotal.'</div></td>';
        echo '<td class="formatoDatos"><div align="center">$ '.$Vlrnova.'</div></td>';
        echo '<td class="formatoDatos"><div align="center">$ '.$Vlrdis.'</div></td>';
        echo '<td class="formatoDatos"><div align="center">$ '.$Vlrcom_nova.'</div></td>';
        echo '<td class="formatoDatos"><div align="center">$ '.$Vlrcom_dist.'</div></td>';
        echo '<td class="formatoDatos"><div align="center">$ '.$Vlrcom_tot.'</div></td>';
        echo '</tr>';
    }
    $Vlrsum_com_nova=number_format($sum_com_nova, 0, '.', ',');
    $Vlrsum_com_dist=number_format($sum_com_dist, 0, '.', ',');
    $Vlrsum_com_tot=number_format($sum_com_tot, 0, '.', ',');

    echo'<tr>
        <td colspan="6" ></Td>
        <td colspan="2" class="titulo" align="right">TOTAL :</Td>
        <td colspan="1" class="titulo"><div align="center">$ '.$Vlrsum_com_nova.'</div> </td>
        <td colspan="1" class="titulo"><div align="center">$ '.$Vlrsum_com_dist.'</div> </td>
        <td colspan="1" class="titulo"><div align="center">$ '.$Vlrsum_com_tot.'</div> </td>
        </tr>';
    mysqli_close($link);//Cerrar la conexion
    */ ?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>-->
</div>
</body>
</html>