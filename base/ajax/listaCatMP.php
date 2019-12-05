<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $conn = Conectar::conexion(); 
    $qry = "SELECT idCatMP, catMP FROM cat_mp order by idCatMP";
    $stmt = $conn->prepare($qry);
    $stmt->execute();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => $stmt->rowCount(),
        'recordsFiltered' => $stmt->rowCount()
        ); 
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $datos[]  = array(
            $result["idCatMP"],
            $result["catMP"]
    ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>