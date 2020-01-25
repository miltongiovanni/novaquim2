<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $PersonalOperador = new PersonalOperaciones();
	$personal=$PersonalOperador->getTablePersonal();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($personal),
        'recordsFiltered' => count($personal)
        ); 
    for($i = 0; $i < count($personal); $i++){
        $datos[]  = array(
            $personal[$i]["idPersonal"],
            $personal[$i]["nomPersonal"],
            $personal[$i]["celPersonal"],
            $personal[$i]["emlPersonal"],
            $personal[$i]["area"],
            $personal[$i]["cargo"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 

print json_encode($datosRetorno);

?>