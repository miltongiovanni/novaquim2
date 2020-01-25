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
    for($i = 0; $i < count($categoriasDis); $i++){
        $datos[]  = array(
            $categoriasDis[$i]["idCatDis"],
            $categoriasDis[$i]["catDis"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>