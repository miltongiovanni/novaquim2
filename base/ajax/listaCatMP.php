<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaMPOperador = new CategoriasMPOperaciones();
    $categoriasMP=$CategoriaMPOperador->getCatsMPTable();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasMP),
        'recordsFiltered' => count($categoriasMP)
        );
    $datosRetorno  = array(
        $titulo,  
        'data'    => $categoriasMP
       ); 
       print json_encode($datosRetorno);

?>