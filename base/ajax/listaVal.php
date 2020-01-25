<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $TapasOperador = new TapasOperaciones();
    $tapas=$TapasOperador->getTableTapas();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($tapas),
        'recordsFiltered' => count($tapas)
        ); 
    for($i = 0; $i < count($tapas); $i++){
        $datos[]  = array(
            $tapas[$i]["codTapa"],
            $tapas[$i]["tapa"],
            $tapas[$i]["stockTapa"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 

    print json_encode($datosRetorno);

?>