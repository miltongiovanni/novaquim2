<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $TapasOperador = new TapasOperaciones();
    $tapas=$TapasOperador->getTableTapas();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($tapas),
        'recordsFiltered' => count($tapas),
        'data'    => $tapas
       ); 

    print json_encode($datosRetorno);

?>