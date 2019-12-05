<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $conn = Conectar::conexion(); 
    $qry = "SELECT codigoGen 'Código', producto 'Descripción', CONCAT('$', FORMAT(fabrica, 0)) 'Precio Fábrica', CONCAT('$', FORMAT(distribuidor, 0)) 'Precio Distribución', 
    CONCAT('$', FORMAT(detal, 0)) 'Precio Detal', CONCAT('$', FORMAT(mayor, 0)) 'Precio Mayorista', CONCAT('$', FORMAT(super, 0)) 'Precio Super'
    FROM precios WHERE presActiva=0;";
    $stmt = $conn->prepare($qry);
    $stmt->execute();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => $stmt->rowCount(),
        'recordsFiltered' => $stmt->rowCount()
        ); 
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $datos[]  = array(
            $result["Código"],
            $result["Descripción"],
            $result["Precio Fábrica"],
            $result["Precio Distribución"],
            $result["Precio Detal"],
            $result["Precio Mayorista"],
            $result["Precio Super"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>