<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
  <title>Lista de Usuarios</title>
  <meta charset="utf-8">
  <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div id="contenedor">

    <div id="saludo1">
      <h4>LISTADO DE USUARIOS ACTIVOS</h4>
    </div>
    <div class="row" style="justify-content: right;">
      <div class="col-1"><button class="button" style="vertical-align:middle" onclick="window.location='../menu.php'">
          <span><STRONG>Ir al Menú</STRONG></span></button></div>
    </div>


    <?php

    include "../includes/utilTabla.php";
    //include "../includes/conect.php" ;
    function cargarClases($classname)
    {
      require '../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $usuarioOperador = new UsuariosOperaciones();
    $usuarios=$usuarioOperador->getTableUsers();
    verTabla($usuarios);
    ?>

    <div class="row">
      <div class="col-1"><button class="button" style="vertical-align:middle" onclick="window.location='../menu.php'">
          <span><STRONG>Ir al Menú</STRONG></span></button></div>
    </div>
  </div>
</body>

</html>