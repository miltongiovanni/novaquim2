<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Lista de Usuarios</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script src="../js/buttons.html5.js"></script>

    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'details-control',*/
                        /*"orderable": false,*/
                        "data": "idUsuario",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "nombre",
                    },
                    {
                        "data": "apellido",
                    },
                    {
                        "data": "usuario",
                    },
                    {
                        "data": "fecCrea",
                    },
                    {
                        "data": "estado",
                    },
                    {
                        "data": "perfil",
                    }
                ],
                "columnDefs":
                    [{
                        "targets": [0 ],
                        "className": 'dt-body-center'
                    }
                    ],
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5',
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
                "ajax": "ajax/listaUsuarios.php"
            });
        });
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2">
        <h4>LISTADO DE USUARIOS ACTIVOS</h4>
    </div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-80">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th>Id Usuario</th>
                <th>Nombre Usuario</th>
                <th>Apellidos Usuario</th>
                <th>Usuario</th>
                <th>Fecha de creación</th>
                <th>Estado</th>
                <th>Perfil</th>
            </tr>
            </thead>
        </table>
    </div>


    <?php
    /*
        include "../includes/utilTabla.php";
        //include "../includes/conect.php" ;
        function cargarClases($classname)
        {
          require '../clases/'.$classname.'.php';
        }

        spl_autoload_register('cargarClases');
        $usuarioOperador = new UsuariosOperaciones();
        $usuarios=$usuarioOperador->getTableUsers();
        verTabla($usuarios);*/
    ?>

    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
</div>
</body>

</html>