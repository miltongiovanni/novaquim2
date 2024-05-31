<?php

function cargarClases($classname)
    {
      require '../../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $RelEnvDisOperador = new RelEnvDisOperaciones();
    $relaciones=$RelEnvDisOperador->getTableRelsEnvDis();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($relaciones),
        'recordsFiltered' => count($relaciones),
        'data'    => $relaciones
       ); 
print json_encode($datosRetorno);

?>