<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idProv'])) {
    $idProv = $_POST['idProv'];
    $_SESSION['idProv'] = $idProv;
} else {
    if (isset($_SESSION['idProv'])) {
        $idProv = $_SESSION['idProv'];
    }
}


$ProveedorOperador = new ProveedoresOperaciones();
$proveedor = $ProveedorOperador->getProveedor($idProv);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Proveedor</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script src="../../../js/jszip.js"></script>
    <script src="../../../js/pdfmake.js"></script>
    <script src="../../../js/vfs_fonts.js"></script>
    <script>

        $(document).ready(function () {
            let idProv = document.getElementById("idProv").value;
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'details-control',*/
                        /*"orderable": false,*/
                        "data": "Codigo",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "Producto",
                    },
                ],
                "columnDefs":
                    [{
                        "targets": [0],
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
                "ajax": "../ajax/listaDetProv.php?idProv=" + idProv
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ACTUALIZACIÓN DE PROVEEDORES</h4></div>
    <form id="form1" name="form1" method="post" action="updateProv.php">
        <input type="hidden" name="idProv" id="idProv" value="<?= $idProv ?>">
        <div class="row mb-3">
            <div class="col-2">
                <label class="form-label  " for="nitProv"><strong>NIT</strong></label>
                <input type="text" class="form-control  " name="nitProv" id="nitProv"
                       value="<?= $proveedor['nitProv'] ?>" readOnly>
            </div>
            <div class="col-4">
                <label class="form-label  " for="nomProv"><strong>Proveedor</strong></label>
                <input type="text" class="form-control  " name="nomProv" id="nomProv"
                       value="<?= $proveedor['nomProv'] ?>">
            </div>
            <div class="col-2">
                <label class="form-label  " for="idCatProv"><strong>Tipo de Proveedor</strong></label>
                <?php
                $manager = new CategoriasProvOperaciones();
                $categorias = $manager->getCatsProv();
                $filas = count($categorias);
                echo '<select name="idCatProv" id="idCatProv" class="form-control  "  required>';
                echo '<option selected value="' . $proveedor['idCatProv'] . '">' . $proveedor['desCatProv'] . '</option>';
                for ($i = 0; $i < $filas; $i++) {
                    if ($proveedor['idCatProv'] != $categorias[$i]["idCatProv"]) {
                        echo '<option value="' . $categorias[$i]["idCatProv"] . '">' . $categorias[$i]['desCatProv'] . '</option>';
                    }
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-2">
                <label class="form-label  " for="estProv"><strong>Estado Proveedor</strong></label>
                <select name="estProv" id="estProv" class="form-control  " required>
                    <?php
                    if ($proveedor['estProv'] == 0) {
                        ?>
                        <option value="0" selected>Inactivo</option>
                        <option value="1">Activo</option>
                        <?php
                    } else {
                        ?>
                        <option value="1" selected>Activo</option>
                        <option value="0">Inactivo</option>
                        <?php
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="row mb-3">
            <div class="col-3">
                <label class="form-label  " for="dirProv"><strong>Dirección</strong></label>
                <input type="text" class="form-control  " name="dirProv" id="dirProv"
                       value="<?= $proveedor['dirProv'] ?>">
            </div>
            <div class="col-3">
                <label class="form-label  " for="contProv"><strong>Nombre Contacto</strong></label>
                <input type="text" class="form-control  " name="contProv" id="contProv"
                       value="<?= $proveedor['contProv'] ?>">
            </div>
            <div class="col-1">
                <label class="form-label  " for="telProv"><strong>Teléfono</strong></label>
                <input type="text" class="form-control  " name="telProv" id="telProv"
                       value="<?= $proveedor['telProv'] ?>"
                       onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-3">
                <label class="form-label  " for="emailProv"><strong>Correo electrónico</strong></label>
                <input type="email" class="form-control  " name="emailProv" id="emailProv"
                       value="<?= $proveedor['emailProv'] ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="autoretProv"><strong>Autorretenedor</strong></label>
                <select name="autoretProv" id="autoretProv" class="form-control col-1 " required>
                    <?php
                    if ($proveedor['autoretProv'] == 0) {
                        ?>
                        <option value="0" selected>NO</option>
                        <option value="1">SI</option>
                        <?php
                    } else {
                        ?>
                        <option value="1" selected>SI</option>
                        <option value="0">NO</option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label" for="regProv"><strong>Régimen Proveedor</strong></label>
                <select name="regProv" id="regProv" class="form-control col-2 " required>
                    <option value="0" <?= $proveedor['regProv'] == 0 ? 'selected' : '' ?>>Simplificado</option>
                    <option value="1" <?= $proveedor['regProv'] == 1 ? 'selected' : '' ?>>Común</option>
                    <option value="2" <?= $proveedor['regProv'] == 2 ? 'selected' : '' ?>>Simple</option>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label" for="idTasaIcaProv"><strong>Tasa Reteica</strong></label>
                <?php
                $manager = new TasaReteIcaOperaciones();
                $categorias = $manager->getTasasReteIca();
                $filas = count($categorias);
                echo '<select name="idTasaIcaProv" id="idTasaIcaProv" class="form-control col-1 "  required>';
                echo '<option selected value="' . $proveedor['idTasaIcaProv'] . '">' . $proveedor['reteica'] . '</option>';
                for ($i = 0; $i < $filas; $i++) {
                    if ($proveedor['idTasaIcaProv'] != $categorias[$i]["idTasaRetIca"]) {
                        echo '<option value="' . $categorias[$i]["idTasaRetIca"] . '">' . $categorias[$i]['reteica'] . '</option>';
                    }
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-3">
                <label class="form-label" for="idRetefuente"><strong>Tasa Retefuente</strong></label>
                <?php
                $manager = new TasaRetefuenteOperaciones();
                $categorias = $manager->getTasasRetefuente();
                $filas = count($categorias);
                echo '<select name="idRetefuente" id="idRetefuente" class="form-control col-2 "  required>';
                echo '<option selected value="' . $proveedor['idRetefuente'] . '">' . $proveedor['retefuente'] . '</option>';
                for ($i = 0; $i < $filas; $i++) {
                    if ($proveedor['idRetefuente'] != $categorias[$i]["idTasaRetefuente"]) {
                        echo '<option value="' . $categorias[$i]["idTasaRetefuente"] . '">' . $categorias[$i]['retefuente'] . '</option>';
                    }
                }
                echo '</select>';
                ?>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Actualizar Proveedor</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-3">
            <button class="button" type="button" onClick="window.location='/compras/proveedor/detalle'">
                <span>Adicionar o cambiar productos</span></button>
        </div>
    </div>
<div class="tabla-50">
    <table id="example" class="formatoDatos5 table table-sm table-striped">
        <thead>
        <tr>
            <th class="text-center">Código</th>
            <th class="text-center">Producto</th>
        </tr>
        </thead>
    </table>
</div>

    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
