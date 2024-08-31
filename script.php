<?php

if (!defined("DB_SERVER")) {
    define('DB_SERVER', 'localhost'); // database server/host
}
if (!defined("DB_USER")) {
    define('DB_USER', 'root'); // database username  novaquim_novaquim
}
if (!defined("DB_PASS")) {
    define('DB_PASS', 'novaquim'); // database password  E7VADSSck8)x
}
if (!defined("DB_NAME")) {
    define('DB_NAME', 'novaquim2'); // database name
}


//PDO
$dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_SERVER . ';charset=utf8';
$user = DB_USER;
$password = DB_PASS;

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$qry = "SELECT idFactura, idPedido  FROM factura f where f.estado != 'A'";
$stmt = $pdo->prepare($qry);
$stmt->execute();
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($facturas as $factura) {
    $facturaId = intval($factura['idFactura']);
    $pedidos = explode(',', $factura['idPedido']);
    foreach ($pedidos as $pedidoId) {
        $pedidoId = intval($pedidoId);
        $qry3 = "SELECT * FROM pedido p WHERE p.idPedido = $pedidoId";
        $stmt3 = $pdo->prepare($qry3);
        $stmt3->execute();
        $pedido = $stmt3->fetch(PDO::FETCH_ASSOC);
        if (is_array($pedido)) {
            /*Preparo la insercion */
            $qry2 = "INSERT INTO factura_pedido (facturaId, pedidoId) VALUES($facturaId, $pedidoId)";
            //echo $qry2 . '<br>';
            $stmt2 = $pdo->prepare($qry2);
            $stmt2->execute();
        }
    }
}
