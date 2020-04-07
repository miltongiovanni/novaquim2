<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaDisOperador = new CategoriasDisOperaciones();
    $categoriasDis=$CategoriaDisOperador->getCatsDisTable();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasDis),
        'recordsFiltered' => count($categoriasDis)
        ); 
    $datosRetorno  = array(
        $titulo,  
        'data'    => $categoriasDis
       ); 


print json_encode($datosRetorno);


?>