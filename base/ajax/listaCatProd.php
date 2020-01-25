<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaProdOperador = new CategoriasProdOperaciones();
    $categoriasProd=$CategoriaProdOperador->getCatsProdTable();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasProd),
        'recordsFiltered' => count($categoriasProd)
        ); 
    for($i = 0; $i < count($categoriasProd); $i++){
        $datos[]  = array(
            $categoriasProd[$i]["idCatProd"],
            $categoriasProd[$i]["catProd"]
        ); 
    }
    
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 

print json_encode($datosRetorno);

?>