<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $UsuarioOperador = new UsuariosOperaciones();
	$usuarios=$UsuarioOperador->getTableUsers();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($usuarios),
        'recordsFiltered' => count($usuarios)
        ); 
    $datosRetorno  = array(
        $titulo,  
        'data'    => $usuarios
       ); 

print json_encode($datosRetorno);


?>