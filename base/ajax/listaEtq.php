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
    for($i = 0; $i < count($etiquetas); $i++){
        $datos[]  = array(
            $etiquetas[$i]["codEtiqueta"],
            $etiquetas[$i]["nomEtiqueta"],
            $etiquetas[$i]["stockEtiqueta"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 

print json_encode($datosRetorno);

?>