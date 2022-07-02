<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaProdOperador = new CategoriasProdOperaciones();
    $categoriasProd=$CategoriaProdOperador->getCatsProdTable();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasProd),
        'recordsFiltered' => count($categoriasProd),
        'data'    => $categoriasProd
       ); 

print json_encode($datosRetorno);

?>