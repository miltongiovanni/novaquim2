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
    $datosRetorno  = array(
        $titulo,  
        'data'    => $personal
       ); 

print json_encode($datosRetorno);

?>