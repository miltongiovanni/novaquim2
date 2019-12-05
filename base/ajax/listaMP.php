<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $conn = Conectar::conexion(); 
    $qry = "SELECT codMPrima, nomMPrima, aliasMPrima, catMP, minStockMprima, aparienciaMPrima, olorMPrima, colorMPrima, pHmPrima, densidadMPrima, codMPrimaAnt 
    FROM  mprimas, cat_mp
    WHERE idCatMprima=idCatMP
    ORDER BY codMPrima;";
    $stmt = $conn->prepare($qry);
    $stmt->execute();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => $stmt->rowCount(),
        'recordsFiltered' => $stmt->rowCount()
        ); 
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $datos[]  = array(
            $result["codMPrima"],
            $result["nomMPrima"],
            $result["aliasMPrima"],
            $result["catMP"],
            $result["minStockMprima"],
            $result["aparienciaMPrima"],
            $result["olorMPrima"],
            $result["colorMPrima"],
            $result["pHmPrima"],
            $result["densidadMPrima"],
            $result["codMPrimaAnt"]
    ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>