<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Facturas Vencidas por Cliente</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        #example {
            table-layout: fixed;
        }

        .width1 {
            width: 1%;
        }

        .width2 {
            width: 27%;
        }

        .width3 {
            width: 8%;
        }

        .width4 {
            width: 14%;
        }

        .width5 {
            width: 11%;
        }

        .width6 {
            width: 7%;
        }

        .width7 {
            width: 9%;
        }

        .width8 {
            width: 17%;
        }

        .width9 {
            width: 6%;
        }


    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script>
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../js/buttons.html5.js"></script>

    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact" style="padding-left:50px;width:100%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Factura</th>' +
                '<th class="text-center">F Factura</th>' +
                '<th class="text-center">F Vencimiento</th>' +
                '<th class="text-center">Subtotal</th>' +
                '<th class="text-center">Reteiva</th>' +
                '<th class="text-center">Reteica</th>' +
                '<th class="text-center">Retefuente</th>' +
                '<th class="text-center">Iva</th>' +
                '<th class="text-center">Total</th>' +
                '<th class="text-center">V Cobrar</th>' +
                '<th class="text-center">Abonos</th>' +
                '<th class="text-center">Saldo</th>' +
                '</thead>';

            for (i = 0; i < d.detCarteraCliente.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].idFactura + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].fechaFactura + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].fechaVenc + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].SubtotalFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].retencionIvaFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].retencionIcaFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].retencionFteFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].ivaFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].totalRFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].TotalFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].cobradoFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].saldo + '</td>' +
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
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "nitCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "contactoCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cargoCliente",
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
                        "data": "dirCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "totalSaldoFormat",
                        "className": 'dt-body-right'
                    },
                ],
                "order": [[8, 'desc']],
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
                "ajax": "ajax/listaCarteraAcumulada.php"
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
    <div id="saludo1"><h4>CARTERA VENCIDA POR CLIENTE</h4></div>
    <div class="row flex-end">
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
                <th class="width2">Cliente</th>
                <th class="width3">NIT</th>
                <th class="width4">Contacto</th>
                <th class="width5">Cargo</th>
                <th class="width6">Teléfono</th>
                <th class="width7">Celular</th>
                <th class="width8">Dirección</th>
                <th class="width9">Total adeucado</th>
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
    <!--
<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo" width="100%">
<tr>
      <th width="1%" class="formatoEncabezados"></th>
    <th width="23%" class="formatoEncabezados">Cliente</th>
    <th width="8%" class="formatoEncabezados">NIT</th>
    <th width="14%" class="formatoEncabezados">Contacto</th>
    <th width="9%" class="formatoEncabezados">Cargo</th>
    <th width="9%" class="formatoEncabezados">Teléfono</th>
    <th width="9%" class="formatoEncabezados">Celular</th>
    <th width="17%" class="formatoEncabezados">Dirección </th>
    <th width="10%" class="formatoEncabezados">Total adeucado</th>
  </tr>   
<?php
    /*include "includes/utilTabla.php";
    include "includes/conect.php" ;


    $fecha_actual=date("Y")."-".date("m")."-".date("d");
    $link=conectarServidor();
    $sql= "	select  nomCliente, nitCliente, contactoCliente, cargoCliente, telCliente, celCliente, dirCliente, sum(Total) as sumtotal, sum(retencionIva) as sumretiva, sum(retencionIca) as sumretic, sum(retencionFte) as sumrfte, sum(IVA) as sumiva
                from factura, clientes WHERE Nit_cliente=nitCliente and factura.Estado='P' and idFactura>00 and fechaVenc<'$fecha_actual' group by nomCliente order by sumtotal desc;";
    $result=mysqli_query($link,$sql);


    $a=1;
    while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
    {
        $Nit_clien=$row['Nit_clien'];
        echo'<tr';
          if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
          echo '>
        <td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
        <td class="formatoDatos"><div align="center">'.$row['Nom_clien'].'</div></td>
        <td class="formatoDatos"><div align="left">'.$row['Nit_clien'].'</div></td>
        <td class="formatoDatos"><div align="center">'.$row['Contacto'].'</div></td>
        <td class="formatoDatos"><div align="center">'.$row['Cargo'].'</div></td>
        <td class="formatoDatos"><div align="left">'.$row['Tel_clien'].'</div></td>
        <td class="formatoDatos"><div align="center">'.$row['Cel_clien'].'</div></td>
        <td class="formatoDatos"><div align="left">'.$row['Dir_clien'].'</div></td>
        <td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$row['sumtotal'].'))</script></div></td>
        ';

        echo'</tr>';
        $sqli= "select idFactura, fechaFactura, fechaVenc, Total, retencionIva, retencionIca, retencionFte, Subtotal, IVA
                from factura WHERE Nit_cliente='$Nit_clien' and Estado='P' and fechaVenc<'$fecha_actual';";
        $resulti=mysqli_query($link,$sqli);

        echo '<tr><td colspan="9"><div class="commenthidden" id="UniqueName'.$a.'"><table width="100%" border="0" align="center" cellspacing="0" summary="detalle">
        <tr>
          <th width="5%" class="formatoEncabezados">Factura</th>
          <th width="7%" class="formatoEncabezados">F Factura</th>
          <th width="7%" class="formatoEncabezados">F Vencimiento</th>
          <th width="10%" class="formatoEncabezados">Subtotal</th>
          <th width="8%" class="formatoEncabezados">Reteiva</th>
          <th width="8%" class="formatoEncabezados">Reteica</th>
          <th width="8%" class="formatoEncabezados">Retefuente</th>
          <th width="10%" class="formatoEncabezados">Iva</th>
          <th width="10%" class="formatoEncabezados">Total</th>
          <th width="10%" class="formatoEncabezados">V Cobrar</th>
          <th width="10%" class="formatoEncabezados">Abonos</th>
          <th width="10%" class="formatoEncabezados">Saldo</th>
          </tr>';
        while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
        {
        $fact=$rowi['Factura'];
        $qryp="select sum(cobro) as Parcial from r_caja where idFactura=$fact";
        $resultpago=mysqli_query($link,$qryp);
        $rowpag=mysqli_fetch_array($resultpago);
        if($rowpag['Parcial'])
            $parcial=$rowpag['Parcial'];
        else
            $parcial=0;
        echo '<tr>
        <td class="formatoDatos"><div align="center">'.$rowi['Factura'].'</div></td>
        <td class="formatoDatos"><div align="left">'.$rowi['Fech_fact'].'</div></td>
        <td class="formatoDatos"><div align="left">'.$rowi['Fech_venc'].'</div></td>
        <td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Subtotal'].'))</script></div></td>
        <td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$rowi['Reten_iva'].'))</script></div></td>
        <td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Reten_ica'].'))</script></div></td>
        <td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$rowi['Reten_fte'].'))</script></div></td>
        <td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['IVA'].'))</script></div></td>
        <td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$rowi['Total'].'))</script></div></td>


        <td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.($rowi['Total']-$rowi['Reten_iva']-$rowi['Reten_ica']-$rowi['Reten_fte']).'))</script></div></td>
        <td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$parcial.'))</script></div></td>
        <td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.($rowi['Total']-$rowi['Reten_iva']-$rowi['Reten_ica']-$rowi['Reten_fte']-$parcial).'))</script></div></td>
        </tr>';
        }
        echo '</table></div></td></tr>';
        $a=$a+1;
    }
    //pongo el número de registros total, el tamaño de página y la página que se muestra
    /*echo "Número de registros encontrados: " . $num_total_registros . "<br>";
    echo "Se muestran páginas de " . $TAMANO_PAGINA . " registros cada una<br>";
    echo "Mostrando la página " . $pagina . " de " . $total_paginas . "<p>";
    mysqli_free_result($result);
    mysqli_free_result($resulti);
    mysqli_close($link);//Cerrar la conexion
    */ ?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>-->
</body>
</html>