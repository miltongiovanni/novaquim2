<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if ($_POST['seleccion1'])    //and (Id_pedido=915 or Id_pedido=916)
{
    $selPedidos=$_POST['seleccion1'];
    /*$opciones_clien = implode(",", $_POST['seleccion1']);
   cho '<table border="0" align="center" width="80%" summary="detalle">
       <tr class="formatoDatos">
               <th width="12%" align="center">Código</th>
               <th width="62%" align="center">Producto </th>
               <th width="12%" align="center">Cantidad </th>
               <th width="14%" align="center">Precio</th>
       </tr>';
   $qry_prod = "SELECT codProducto, SUM(cantProducto) as Cantidad, Nombre as Producto, precioProducto from det_pedido, prodpre where codProducto=Cod_prese and codProducto <100000 and (";
   $a = count($_POST['seleccion1']);
   for ($j = 0; $j < $a; $j++) {
       $qry_prod = $qry_prod . "Id_Ped=" . ($_POST['seleccion1'][$j]);
       if ($j <= ($a - 2))
           $qry_prod = $qry_prod . " or ";
   }
   $qry_prod = $qry_prod . ") group by Cod_producto order by Producto";
   $result_prod = mysqli_query($link, $qry_prod);
   while ($row_prod = mysqli_fetch_array($result_prod, MYSQLI_BOTH)) {
       $cod = $row_prod['Cod_producto'];
       $cantidad = $row_prod['Cantidad'];
       $qrybus = "select codPresentacion as Codigo, SUM(invProd) as Inventario from inv_prod WHERE codPresentacion=$cod group by codPresentacion;";
       $resultbus = mysqli_query($link, $qrybus);
       $rowbus = mysqli_fetch_array($resultbus);
       if ($rowbus) {
           if ($rowbus['Inventario'] < $cantidad) {
               $cantidad = $cantidad - $rowbus['Inventario'];
               echo '<tr class="formatoDatos">
                 <td><div align="center">' . $row_prod['Cod_producto'] . '</div></td>
                 <td><div align="left">' . $row_prod['Producto'] . '</div></td>
                 <td><div align="center">' . $cantidad . '</div></td>
                 <td><div align="center">' . $row_prod['Prec_producto'] . '</div></td>
                 </tr>';
           }
       } else {
           echo '<tr class="formatoDatos">
             <td><div align="center">' . $row_prod['Cod_producto'] . '</div></td>
             <td><div align="left">' . $row_prod['Producto'] . '</div></td>
             <td><div align="center">' . $cantidad . '</div></td>
             <td><div align="center">' . $row_prod['Prec_producto'] . '</div></td>
             </tr>';
       }
   }
   //PRODCUTOS DE DISTRIBUCION
   $qry_dist = "select codProducto, sum(cantProducto) as Cantidad, Producto, precioProducto from det_pedido, distribucion where codProducto=Id_distribucion and codProducto >=100000 and (";
   $a = count($_POST['seleccion1']);
   for ($j = 0; $j < $a; $j++) {
       $qry_dist = $qry_dist . "Id_Ped=" . ($_POST['seleccion1'][$j]);
       if ($j <= ($a - 2))
           $qry_dist = $qry_dist . " or ";
   }
   $qry_dist = $qry_dist . ") group by Cod_producto order by Producto";
   $result_dist = mysqli_query($link, $qry_dist);
   while ($row_dist = mysqli_fetch_array($result_dist, MYSQLI_BOTH)) {
       $cod = $row_dist['Cod_producto'];
       $cantidad = $row_dist['Cantidad'];
       $qrybus = "SELECT Id_distribucion AS Codigo, invDistribucion as Inventario from inv_distribucion WHERE Id_distribucion=$cod;";
       $resultbus = mysqli_query($link, $qrybus);
       $rowbus = mysqli_fetch_array($resultbus);
       if ($rowbus) {
           if ($rowbus['Inventario'] < $cantidad) {
               $cantidad = $cantidad - $rowbus['Inventario'];
               echo '<tr class="formatoDatos">
                   <td><div align="center">' . $row_dist['Cod_producto'] . '</div></td>
                   <td><div align="left">' . $row_dist['Producto'] . '</div></td>
                   <td><div align="center">' . $cantidad . '</div></td>
                   <td><div align="center">' . $row_dist['Prec_producto'] . '</div></td>
                   </tr>';
           }
       } else {
           echo '<tr class="formatoDatos">
               <td><div align="center">' . $row_dist['Cod_producto'] . '</div></td>
               <td><div align="left">' . $row_dist['Producto'] . '</div></td>
               <td><div align="center">' . $cantidad . '</div></td>
               <td><div align="center">' . $row_dist['Prec_producto'] . '</div></td>
               </tr>';
       }
   }*/
} else {
    //echo "no escogió productos de novaquim <br>";Id_Ped=915 or Id_Ped=916)
    echo ' <script >
		alert("Debe escoger algún pedido");
		history.back();
		</script>';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Faltante del Pedido</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 20%;
        }

        .width2 {
            width: 60%;
        }

        .width3 {
            width: 20%;
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
            let selPedido = <?=json_encode($selPedidos)?>;
            let ruta = "ajax/listaNecesidades.php?selPedido=" + selPedido;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "codProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cantidad",
                        "className": 'dt-body-center'
                    }
                ],
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 1
                }],
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false,
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
                    "lengthMenu": "Mostrando _MENU_ datos por página",
                    "zeroRecords": "No hacen falta productos",
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
    <div id="saludo1"><strong>FALTANTE DE LOS PEDIDOS</strong></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>

    <div class="tabla-50">
        <table id="example" class="display compact">
            <thead>
            <tr>
                <th class="width1">Código</th>
                <th class="width2">Producto</th>
                <th class="width3">Cantidad</th>
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
</div>
</body>
</html>
	   