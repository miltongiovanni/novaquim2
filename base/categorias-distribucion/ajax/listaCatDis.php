<?php

function cargarClases($classname)
    {
      require '../../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaDisOperador = new CategoriasDisOperaciones();
    $categoriasDis=$CategoriaDisOperador->getCatsDisTable();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasDis),
        'recordsFiltered' => count($categoriasDis),
        'data'    => $categoriasDis
       ); 


print json_encode($datosRetorno);


?>