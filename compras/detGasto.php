<?php
include "../includes/valAcc.php";

if (isset($_SESSION['idGasto'])) {//Si la factura existe
    $idGasto = $_SESSION['idGasto'];
}
foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');


/*include "includes/conect.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo." = ".$valor."<br>";  
    eval($asignacion);
}

if ($CrearFactura == 2) {
    $link = conectarServidor();
    $qryup = "update gastos set nit_prov='$nit_prov', numFact=$num_fac, fechGasto='$FchFactura', fechVenc='$VenFactura' where idGasto=$Factura;";
    $resultup = mysqli_query($link, $qryup);
    mysqli_close($link);
}
if ($CrearFactura != 0) {
    $link = conectarServidor();
    $qrys = "select estadoGasto from gastos where idGasto=$Factura";
    $results = mysqli_query($link, $qrys);
    $rows = mysqli_fetch_array($results);
    $estadoc = $rows['estado'];
    mysqli_close($link);
}

if ($CrearFactura == 1) {
    //echo "NO ESTA CREANDO FACTURA";
    $link = conectarServidor();
    $qrybus = "select * from det_gastos where idGasto=$Factura AND Producto='$producto';";
    $resultqrybus = mysqli_query($link, $qrybus);
    $row_bus = mysqli_fetch_array($resultqrybus);
    if ($row_bus['Producto'] == $producto) {
        echo ' <script >
			alert("Producto incluido anteriormente");
			document.formulario.submit();
		</script>';
    } else {
        //SE ACTUALIZA EL DATALLE DE LA FACTURA
        $qryFact = "insert into det_gastos (idGasto, Producto, cantGasto, precGasto, codIva) values  ($Factura, '$producto', $cantidad, $precio, $tasa_iva)";
        $resultfact = mysqli_query($link, $qryFact);
    }
    mysqli_close($link);
    echo '<form method="post" action="detGasto.php" name="form3">';
    echo '<input name="CrearFactura" type="hidden" value="5">';
    echo '<input name="Factura" type="hidden" value="' . $Factura . '">';
    echo '</form>';
    echo '<script >
		document.form3.submit();
		</script>';
}
if ($CrearFactura == 5) {
    $link = conectarServidor();
    $qry = "select sum(cantGasto*precGasto) as Total, sum(cantGasto*precGasto*tasa) as IVA, tasaRetIca from det_gastos, tasa_iva, gastos, proveedores, tasa_reteica
			where det_gastos.idGasto=$Factura AND tasa_iva.Id_tasa=det_gastos.codIva and gastos.idGasto=det_gastos.idGasto and nit_prov=nitProv 
and numtasa_rica=idTasaRetIca;";

    $result = mysqli_query($link, $qry);
    $row = mysqli_fetch_array($result);
    $SUBTotalFactura = $row['Total'];
    $tasa_reteica = $row['tasa_retica'];
    $qryc = "select ret_provee from gastos, proveedores where nit_prov=nitProv and idGasto=$Factura";
    $resultc = mysqli_query($link, $qryc);
    $rowc = mysqli_fetch_array($resultc);
    $autore = $rowc['ret_provee'];
    if ($autore == 1) {
        $retencion = 0;
        $reteica = 0;
    } else {
        if ($SUBTotalFactura >= BASE_C) {
            $retencion = round($SUBTotalFactura * 0.025, 0);
            $reteica = round($SUBTotalFactura * $tasa_reteica / 1000);
        } else {
            $retencion = 0;
            $reteica = 0;
        }
    }
    $Iva_Factura = $row['IVA'];
    $TotalFactura = $SUBTotalFactura + $Iva_Factura;
    $qryUpFactura = "update gastos set totalGasto=$TotalFactura, subtotalGasto=$SUBTotalFactura, ivaGasto=$Iva_Factura, retefuenteGasto=$retencion, reteicaGasto=$reteica where idGasto=$Factura";
    if ($estadoc != 7)

        $result = mysqli_query($link, $qryUpFactura);
    mysqli_close($link);
}
if ($CrearFactura == 6) {
    if ($estado == 2) {
        $link = conectarServidor();
        $qryUpEstFactura = "update gastos set estadoGasto=3 where idGasto=$Factura";
        $result2 = mysqli_query($link, $qryUpEstFactura);
        mysqli_close($link);
    }
    echo '<script  >
	self.location="menu.php";
	</script>';
} */
$GastoOperador = new GastosOperaciones();
$DetGastoOperador = new DetGastosOperaciones();
$gasto = $GastoOperador->getGasto($idGasto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso del Detalle de los Gastos de Industrias Novaquim</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
    </style>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script>
        function redireccion() {
            eliminarSession();
            window.location.href = "../menu.php";
        }

        function eliminarSession() {
            let variable = 'idGasto';
            $.ajax({
                url: '../includes/controladorCompras.php',
                type: 'POST',
                data: {
                    "action": 'eliminarSession',
                    "variable": variable,
                },
                dataType: 'text',
                success: function (res) {
                },
                fail: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        function updateEstadoGasto(idGasto) {
            let estadoActualGasto = <?=$gasto['estadoGasto']?>;
            if (estadoActualGasto != 2) {
                redireccion();
            } else {
                $.ajax({
                    url: '../includes/controladorCompras.php',
                    type: 'POST',
                    data: {
                        "action": 'updateEstadoGasto',
                        "idGasto": idGasto,
                        "estadoGasto": 3,
                    },
                    dataType: 'json',
                    success: function (respuesta) {
                        if (respuesta.msg == 'OK') {
                            redireccion();
                        }
                    },
                    fail: function () {
                        alert("Vous avez un GROS problème");
                    }
                });
            }
        }

        $(document).ready(function () {
            let idGasto = <?=$idGasto?>;
            let ruta = "ajax/listaDetGasto.php?idGasto=" + idGasto;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetGastoForm.php" method="post" name="elimina">' +
                                '          <input name="idGasto" type="hidden" value="' + idGasto + '">' +
                                '          <input name="producto" type="hidden" value="' + row.producto + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "iva",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cantGasto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "precGasto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetGasto.php" method="post" name="elimina">' +
                                '          <input name="idGasto" type="hidden" value="' + idGasto + '">' +
                                '          <input name="producto" type="hidden" value="' + row.producto + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    }
                ],
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false,
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
    <div id="saludo1"><strong>INGRESO DE DETALLE DE LOS GASTOS</strong></div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>No. de Gasto</strong></div>
        <div class="col-1 bg-blue"><?= $idGasto; ?></div>
        <div class="col-1 text-right"><strong>Proveedor</strong></strong></div>
        <div class="col-3" style="background-color: #dfe2fd;"><?= $gasto['nomProv'] ?></div>
        <div class="col-1 text-right"><strong>NIT</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['nitProv'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>No. de Factura</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['numFact'] ?></div>
        <div class="col-2 text-right"><strong>Fecha de compra</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['fechGasto']; ?></div>
        <div class="col-2 text-right"><strong>Fecha Vencimiento </strong></strong></div>
        <div class="col-1 bg-blue"><?= $gasto['fechVenc'] ?></div>
        <div class="col-1 text-right"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['descEstado'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Valor Factura</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['totalGasto'] ?></div>
        <div class="col-1 text-right"><strong>Rete Ica</strong></strong></div>
        <div class="col-1 bg-blue"><?= $gasto['reteicaGasto'] ?></div>
        <div class="col-1 text-right"><strong>Retención</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['retefuenteGasto'] ?></div>
        <div class="col-1 text-right"><strong>Valor a Pagar</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['vreal'] ?></div>
    </div>

    <?php
    if ($gasto['estadoGasto'] != 7) {
        ?>
        <div class="form-group titulo row">
            <strong>Adicionar Detalle</strong>
        </div>
        <form method="post" action="makeDetGasto.php" name="form1">
            <input name="idGasto" type="hidden" value="<?= $idGasto; ?>">
            <div class="row">
                <div class="col-3 text-center" style="margin: 0 5px 0 0;"><strong>Descripción</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio Unitario (Sin IVA)</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Tasa Iva</strong></div>
                <div class="col-2 text-center">
                </div>
            </div>
            <div class="form-group row">
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-3" name="producto"
                       id="producto">
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantGasto"
                       id="cantGasto" onKeyPress="return aceptaNum(event)">
                <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precGasto" id="precGasto"
                       onKeyPress="return aceptaNum(event)">
                <?php
                $manager = new TasaIvaOperaciones();
                $tasas = $manager->getTasasIva();
                $filas = count($tasas);
                echo '<select name="codIva" id="codIva" class="form-control col-1">';
                echo '<option selected disabled value="">-------------</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
                }
                echo '</select>';
                ?>
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                    </button>
                </div>
            </div>
        </form>
        <?php
    } ?>
    <div class="form-group titulo row">
        <strong>Detalle del gasto</strong>
    </div>
    <table id="example" class="display compact" style="width:80%; margin-bottom: 20px;">
        <thead>
        <tr>
            <th width="10%"></th>
            <th width="45%">Descripción</th>
            <th width="5%">Iva</th>
            <th width="10%">Cantidad</th>
            <th width="20%">Precio unitario(Sin Iva)</th>
            <th width="10%"></th>
        </tr>
        </thead>
    </table>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="updateEstadoGasto(<?= $idGasto ?>)"><span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>
