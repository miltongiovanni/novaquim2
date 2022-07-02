<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaProvOperador = new CategoriasProvOperaciones();
    $categoriasProv=$CategoriaProvOperador->getCatsProv();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasProv),
        'recordsFiltered' => count($categoriasProv),
        'data'    => $categoriasProv
       ); 

print json_encode($datosRetorno);

?>