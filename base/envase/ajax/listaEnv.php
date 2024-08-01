<?php

function cargarClases($classname)
    {
      require '../../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $EnvasesOperador = new EnvasesOperaciones();
    $envases=$EnvasesOperador->getTableEnvases();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($envases),
        'recordsFiltered' => count($envases),
        'data'    => $envases
       ); 

print json_encode($datosRetorno);

?>