<?php

function cargarClases($classname)
    {
      require '../../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $InvAjustesOperador = new InvAjustesOperaciones();
    $ajustes=$InvAjustesOperador->getTableInvAjuste();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($ajustes),
        'recordsFiltered' => count($ajustes),
        'data'    => $ajustes
       ); 


print json_encode($datosRetorno);


?>