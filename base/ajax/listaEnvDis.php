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
    for($i = 0; $i < count($relaciones); $i++){
        $datos[]  = array(
            $relaciones[$i]["idEnvDis"],
            $relaciones[$i]["producto"],
            $relaciones[$i]["nomEnvase"],
            $relaciones[$i]["tapa"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 
print json_encode($datosRetorno);

?>