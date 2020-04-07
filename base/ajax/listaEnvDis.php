<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $RelEnvDisOperador = new RelEnvDisOperaciones();
    $relaciones=$RelEnvDisOperador->getTableRelsEnvDis();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($relaciones),
        'recordsFiltered' => count($relaciones)
        );
    $datosRetorno  = array(
        $titulo,  
        'data'    => $relaciones
       ); 
print json_encode($datosRetorno);

?>