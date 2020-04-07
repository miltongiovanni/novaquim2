<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $EtiquetasOperador = new EtiquetasOperaciones();
    $etiquetas=$EtiquetasOperador->getTableEtiquetas();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($etiquetas),
        'recordsFiltered' => count($etiquetas)
        );
    $datosRetorno  = array(
        $titulo,  
        'data'    => $etiquetas
       ); 

print json_encode($datosRetorno);

?>