<?php

function cargarClases($classname)
    {
      require '../../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $EtiquetasOperador = new EtiquetasOperaciones();
    $etiquetas=$EtiquetasOperador->getTableEtiquetas();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($etiquetas),
        'recordsFiltered' => count($etiquetas),
        'data'    => $etiquetas
       ); 

print json_encode($datosRetorno);

?>