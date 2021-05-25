<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Proveedor</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
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
                        "targets": [0, 1],
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
                "ajax": "ajax/listaDetProv.php?idProv=" + idProv
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><h4>ACTUALIZACIÓN DE PROVEEDORES</h4></div>
    <form id="form1" name="form1" method="post" action="updateProv.php">
        <input type="hidden" class="form-control col-2" name="idProv" id="idProv" value="<?= $idProv ?>">
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="nitProv"><strong>NIT</strong></label>
            <input type="text" class="form-control col-2" name="nitProv" id="nitProv"
                   value="<?= $proveedor['nitProv'] ?>" readOnly>
            <label class="col-form-label col-2 text-right"
                   for="nomProv"><strong>Proveedor</strong></label>
            <input type="text" class="form-control col-2" name="nomProv" id="nomProv"
                   value="<?= $proveedor['nomProv'] ?>">
            <label class="col-form-label col-2 text-right" for="contProv"><strong>Nombre
                    Contacto</strong></label>
            <input type="text" class="form-control col-2" name="contProv" id="contProv"
                   value="<?= $proveedor['contProv'] ?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right"
                   for="dirProv"><strong>Dirección</strong></label>
            <input type="text" class="form-control col-2" name="dirProv" id="dirProv"
                   value="<?= $proveedor['dirProv'] ?>">
            <label class="col-form-label col-2 text-right"
                   for="telProv"><strong>Teléfono</strong></label>
            <input type="text" class="form-control col-2" name="telProv" id="telProv"
                   value="<?= $proveedor['telProv'] ?>"
                   onkeydown="return aceptaNum(event)">
            <label class="col-form-label col-2 text-right" for="emailProv"><strong>Correo
                    electrónico</strong></label>
            <input type="email" class="form-control col-2" name="emailProv" id="emailProv"
                   value="<?= $proveedor['emailProv'] ?>">
        </div>
        <div class="form-group row">

            <label class="col-form-label col-2" for="idCatProv"><strong>Tipo de Proveedor</strong></label>
            <?php
            $manager = new CategoriasProvOperaciones();
            $categorias = $manager->getCatsProv();
            $filas = count($categorias);
            echo '<select name="idCatProv" id="idCatProv" class="form-control col-2"  required>';
            echo '<option selected value="' . $proveedor['idCatProv'] . '">' . $proveedor['desCatProv'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($proveedor['idCatProv'] != $categorias[$i]["idCatProv"]) {
                    echo '<option value="' . $categorias[$i]["idCatProv"] . '">' . $categorias[$i]['desCatProv'] . '</option>';
                }
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-2" for="autoretProv"><strong>Autorretenedor</strong></label>
            <select name="autoretProv" id="autoretProv" class="form-control col-2" required>
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
            <label class="col-form-label col-2" for="regProv"><strong>Régimen Proveedor</strong></label>
            <select name="regProv" id="regProv" class="form-control col-2" required>
                <?php
                if ($proveedor['regProv'] == 0) {
                    ?>
                    <option value="0" selected>Simplificado</option>
                    <option value="1">Común</option>
                    <?php
                } else {
                    ?>
                    <option value="1" selected>Común</option>
                    <option value="0">Simplificado</option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="idTasaIcaProv"><strong>Tasa Reteica</strong></label>
            <?php
            $manager = new TasaReteIcaOperaciones();
            $categorias = $manager->getTasasReteIca();
            $filas = count($categorias);
            echo '<select name="idTasaIcaProv" id="idTasaIcaProv" class="form-control col-2"  required>';
            echo '<option selected value="' . $proveedor['idTasaIcaProv'] . '">' . $proveedor['reteica'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($proveedor['idTasaIcaProv'] != $categorias[$i]["idTasaRetIca"]) {
                    echo '<option value="' . $categorias[$i]["idTasaRetIca"] . '">' . $categorias[$i]['reteica'] . '</option>';
                }
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-2" for="idRetefuente"><strong>Tasa Retefuente</strong></label>
            <?php
            $manager = new TasaRetefuenteOperaciones();
            $categorias = $manager->getTasasRetefuente();
            $filas = count($categorias);
            echo '<select name="idRetefuente" id="idRetefuente" class="form-control col-2"  required>';
            echo '<option selected value="' . $proveedor['idRetefuente'] . '">' . $proveedor['retefuente'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($proveedor['idRetefuente'] != $categorias[$i]["idTasaRetefuente"]) {
                    echo '<option value="' . $categorias[$i]["idTasaRetefuente"] . '">' . $categorias[$i]['retefuente'] . '</option>';
                }
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-2" for="regProv"><strong>Estado Proveedor</strong></label>
            <select name="estProv" id="estProv" class="form-control col-2" required>
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
        <div class="form-group row">
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
            <button class="button" type="button" onClick="window.location='detProveedor.php'">
                <span>Adicionar o cambiar productos</span></button>
        </div>
    </div>

    <table id="example" class="display compact" style="width:50%; margin: 20px auto;">
        <thead>
        <tr>
            <th>Código</th>
            <th>Producto</th>
        </tr>
        </thead>
    </table>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
