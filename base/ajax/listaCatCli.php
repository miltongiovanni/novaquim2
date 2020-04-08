<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaCliOperador = new CategoriasCliOperaciones();
    $categoriasCli=$CategoriaCliOperador->getCatsCliTable();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasCli),
        'recordsFiltered' => count($categoriasCli)
        );
    $datosRetorno  = array(
        $titulo,  
        'data'    => $categoriasCli
       ); 

print json_encode($datosRetorno);

?>