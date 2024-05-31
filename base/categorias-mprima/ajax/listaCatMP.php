<?php

function cargarClases($classname)
    {
      require '../../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaMPOperador = new CategoriasMPOperaciones();
    $categoriasMP=$CategoriaMPOperador->getCatsMPTable();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasMP),
        'recordsFiltered' => count($categoriasMP),
        'data'    => $categoriasMP
       ); 
       print json_encode($datosRetorno);

?>