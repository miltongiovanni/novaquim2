<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $EnvasesOperador = new EnvasesOperaciones();
    $envases=$EnvasesOperador->getTableEnvases();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($envases),
        'recordsFiltered' => count($envases)
        ); 
    for($i = 0; $i < count($envases); $i++){
        $datos[]  = array(
            $envases[$i]["codEnvase"],
            $envases[$i]["nomEnvase"],
            $envases[$i]["stockEnvase"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $envases
       ); 

print json_encode($datosRetorno);

?>