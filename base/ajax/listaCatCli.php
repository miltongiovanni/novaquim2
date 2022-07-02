<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaCliOperador = new CategoriasCliOperaciones();
    $categoriasCli=$CategoriaCliOperador->getCatsCliTable();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasCli),
        'recordsFiltered' => count($categoriasCli),
        'data'    => $categoriasCli
       ); 

print json_encode($datosRetorno);

?>