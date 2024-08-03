<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
if (isset($_POST['idProv'])) {
    $DetProveedorOperador = new DetProveedoresOperaciones();
    $datos = array($idProv, $Codigo);
    $DetProveedorOperador->makeDetProveedor($datos);
    unset($_POST['idProv']);
    header('Location: ../detalle//');
}
if (isset($_SESSION['idProv'])) {
    $idProv = $_SESSION['idProv'];
}
$ProveedorOperador = new ProveedoresOperaciones();
$proveedor = $ProveedorOperador->getProveedor($idProv);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Productos por Proveedor</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 15%;
        }

        .width2 {
            width: 70%;
        }

        .width3 {
            width: 15%;
        }

    </style>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    
    <script>

        $(document).ready(function () {
            let idProv = document.getElementById("idProv").value;
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'dt-control',*/
                        /*"orderable": false,*/
                        "data": "Codigo",
                        "className": 'dt-body-center'
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "Producto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetProv.php" method="post" name="elimina">' +
                                '                    <input name="idProv" type="hidden" value="' + idProv + '">' +
                                '                    <input name="Codigo" type="hidden" value="' + row.Codigo + '">' +
                                '                    <input type="submit" name="Submit" class="formatoBoton"  value="Eliminar">' +
                                '                </form>'
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
                    "emptyTable": "No hay datos disponibles",
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
                "ajax": "../ajax/listaDetProv.php?idProv=" + idProv
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>PRODUCTOS OFRECIDOS POR <?= $proveedor['nomProv'] ?></h4></div>
    <?php if ($proveedor['idCatProv'] != 4): ?>
        <form method="post" action="index.php" name="form1">
            <input type="hidden" class="form-control col-2" name="idProv" id="idProv" value="<?= $idProv ?>">
            <div class="mb-3 row mt-3">
                <div class="col-1">
                    <label class="form-label " for="Codigo"><strong>Producto</strong></label>
                </div>
                <div class="col-3">
                    <?php
                    $DetProveedorOperador = new DetProveedoresOperaciones();
                    $productos = $DetProveedorOperador->getProdPorCategoria($idProv, $proveedor['idCatProv']);
                    if ($productos) {
                        $filas = count($productos);
                        echo '<select name="Codigo" id="Codigo" class="form-control "  required>';
                        echo '<option disabled selected value="">Seleccione una opción-----</option>';
                        for ($i = 0; $i < $filas; $i++) {
                            echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                        }
                        echo '</select>';
                    }
                    ?>
                </div>
                <div class="col-2" style="padding: 4px 25px">
                    <button class="button" type="button" onclick="return Enviar(this.form)">
                        <span>Adicionar producto</span>
                    </button>
                </div>
            </div>
        </form>
    <?php
    endif;
    ?>
    <div class="tabla-50 mb-5">
        <table id="example" class="formatoDatos table table-sm table-striped">
            <thead>
            <tr>
                <th class="width1 text-center">Código</th>
                <th class="width2 text-center">Producto</th>
                <th class="width3 text-center"></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" onclick="eliminarSession(); ">
                <span><STRONG>Terminar</STRONG></span>
            </button>
        </div>
    </div>
</div>
<script>
    function eliminarSession() {
        let variable = 'idProv';
        $.ajax({
            url: '../../../includes/controladorCompras.php',
            type: 'POST',
            data: {
                "action": 'eliminarSession',
                "variable": variable,
            },
            dataType: 'text',
            success: function (res) {
                window.location = '../../../menu.php';
            },
            error: function () {
                alert("Vous avez un GROS problème");
            }
        });
    }
</script>

</body>
</html>