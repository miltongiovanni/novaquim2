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
    for($i = 0; $i < count($categoriasMP); $i++){
        $datos[]  = array(
            $categoriasMP[$i]["idCatMP"],
            $categoriasMP[$i]["catMP"]
        ); 
    }

    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 
       print json_encode($datosRetorno);

?>