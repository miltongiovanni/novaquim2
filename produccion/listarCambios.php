<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Cambios de Producto</title>
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
            width: 10%;
        }

        .width2 {
            width: 20%;
        }

        .width3 {
            width: 30%;
        }

        .width4 {
            width: 40%;
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


        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact" style="padding-left:50px;width:70%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Origen</th>';
            rep += '<th align="center">Presentación</th>' +
                '<th align="center">Cantidad</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.detCambio.length; i++) {
                rep += '<tr>' +
                    '<td align="center">' + d.detCambio[i].codPresentacionAnt + '</td>';
                rep += '<td align="center">' + d.detCambio[i].presentacion + '</td>' +
                    '<td align="center">' + d.detCambio[i].cantPresentacionAnt + '</td>' +
                    '</tr>'
            }
            rep += '<table cellpadding="5" cellspacing="0" border="0"  class="display compact" style="padding-left:50px;width:70%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Destino</th>';
            rep += '<th align="center">Presentación</th>' +
                '<th align="center">Cantidad</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.detCambio2.length; i++) {
                rep += '<tr>' +
                    '<td align="center">' + d.detCambio2[i].codPresentacionNvo + '</td>';
                rep += '<td align="center">' + d.detCambio2[i].presentacion + '</td>' +
                    '<td align="center">' + d.detCambio2[i].cantPresentacionNvo + '</td>' +
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
                        "data": "idCambio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaCambio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomPersonal",
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[1, 'desc']],
                "dom": 'Blfrtip',
                "paging": true,
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
                "ajax": "ajax/listaCambios.php",
                "deferRender": true,  //For speed
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
    <div id="saludo1"><strong>LISTADO DE CAMBIOS DE PRESENTACIÓN DE PRODUCTO</strong></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-50">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Cambio</th>
                <th class="width3">Fecha cambio</th>
                <th class="width4">Responsable</th>
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
    <!--<table width="100%" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0">
	<tr>PRIMARY
      <th width="16" class="formatoEncabezados"></th>
      <th width="53" class="formatoEncabezados">Cambio</th>
      <th width="197" class="formatoEncabezados">Fecha del Cambio</th>
      <th width="291" class="formatoEncabezados">Responsable</th>
  </tr>   
<?php
    /*include "includes/utilTabla.php";
    include "includes/conect.php" ;
    $link=conectarServidor();
    $sql="	SELECT idCambio, nom_personal, fechaCambio FROM cambios, personal WHERE codPersonal=Id_personal order by idCambio desc;";
    $result=mysqli_query($link, $sql);
    $a=1;
    while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
    {
        $cambio=$row['Id_cambio'];
        echo'<tr';
          if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
          echo '>
        <td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
        <td class="formatoDatos"><div align="center">'.$row['Id_cambio'].'</div></td>
        <td class="formatoDatos"><div align="center">'.$row['Fech_cambio'].'</div></td>
        <td class="formatoDatos"><div align="center">'.$row['nom_personal'].'</div></td>';
        echo'</tr>';
        $sqli="select idCambio, Nombre, SUM(cantPresentacionAnt) as Cantidad FROM det_cambios, prodpre
        where idCambio=$cambio AND codPresentacionAnt=Cod_prese GROUP BY codPresentacionAnt;";
        $resulti=mysqli_query($link, $sqli);
        echo '<tr><td colspan="4"><div class="commenthidden" id="UniqueName'.$a.'"><table width="100%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
            <th width="10%" class="formatoEncabezados">Origen</th>
                <th width="60%" class="formatoEncabezados">Nombre</th>
              <th width="20%" class="formatoEncabezados">Cantidad</th>
          </tr>';
        while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
        {
        echo '<tr>
            <td class="formatoDatos"><div align="left"></div></td>
            <td class="formatoDatos"><div align="left">'.$rowi['Nombre'].'</div></td>
            <td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td></tr>';
        }
        echo '<tr>
            <th width="5%" class="formatoEncabezados">Destino</th>
                <th width="20%" class="formatoEncabezados">Nombre</th>
              <th width="5%" class="formatoEncabezados">Cantidad</th>
          </tr>';
        $sqli2="select idCambio, Nombre, SUM(cantPresentacionNvo) as Cantidad FROM det_cambios2, prodpre
        where idCambio=$cambio AND codPresentacionNvo=Cod_prese GROUP BY codPresentacionNvo;";
        $resulti2=mysqli_query($link, $sqli2);
        while($rowi2=mysqli_fetch_array($resulti2, MYSQLI_BOTH))
        {
        echo '<tr>
            <td class="formatoDatos"><div align="left"></div></td>
            <td class="formatoDatos"><div align="left">'.$rowi2['Nombre'].'</div></td>
            <td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi2['Cantidad'].'))</script></div></td></tr>';
        }
        echo '</table></div></td></tr>';
        $a=$a+1;
    }
    mysqli_free_result($result);
    mysqli_free_result($resulti);
    mysqli_free_result($resulti2);
    mysqli_close($link);//Cerrar la conexion
    */ ?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>-->
</div>
</body>
</html>