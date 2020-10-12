<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
if(isset($_POST['idProv']))
{
    $DetProveedorOperador = new DetProveedoresOperaciones();
    $datos = array($idProv, $Codigo);
    $DetProveedorOperador->makeDetProveedor($datos);
    unset($_POST['idProv']);
    header('Location: detProveedor.php');
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <script src="../js/validar.js"></script>
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
                        "className": 'dt-body-center'
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "Producto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": function ( row ) {
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
    <div id="saludo1"><strong>PRODUCTOS OFRECIDOS POR <?= $proveedor['nomProv'] ?></strong></div>
    <form method="post" action="detProveedor.php" name="form1">
        <input type="hidden" class="form-control col-2" name="idProv" id="idProv" value="<?= $idProv ?>">
        <div class="form-group row" style="margin-top: 20px;">
            <label class="col-form-label col-1" for="Codigo"><strong>Producto</strong></label>
            <?php
            $DetProveedorOperador = new DetProveedoresOperaciones();
            $productos = $DetProveedorOperador->getProdPorCategoria($idProv, $proveedor['idCatProv']);
            $filas = count($productos);
            echo '<select name="Codigo" id="Codigo" class="form-control col-3"  required>';
            echo '<option disabled selected value="">----------------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
            }
            echo '</select>';
            ?>
            <div class="col-2" style="padding: 4px 25px">
                <button class="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span></button>
            </div>
        </div>
    </form>
    <table id="example" class="display compact" style="width:50%; margin-bottom: 20px;">
        <thead>
        <tr>
            <th width="15%">Código</th>
            <th width="70%">Producto</th>
            <th width="15%"></th>
        </tr>
        </thead>
    </table>
    <div class="row">
        <div class="col-1">
            <button class="button" onclick="eliminarSession(); ">
                <span><STRONG>Terminar</STRONG></span>
            </button>
        </div>
    </div>
</div>
<script>
    function eliminarSession() {
        let variable = 'idProv';
        $.ajax({
            url: '../includes/controladorCompras.php',
            type: 'POST',
            data: {
                "action": 'eliminarSession',
                "variable": variable,
            },
            dataType: 'text',
            success: function (res) {
                window.location='../menu.php';
            },
            error: function () {
                alert("Vous avez un GROS problème");
            }
        });
    }
</script>

</body>
</html>