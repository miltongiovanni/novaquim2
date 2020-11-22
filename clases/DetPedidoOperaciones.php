<?php

class DetPedidoOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetPedido($datos)
    {
        $qry = "INSERT INTO det_pedido (idPedido, codProducto, cantProducto, precioProducto) VALUES (?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetPedido($datos)
    {
        $qry = "DELETE FROM det_pedido WHERE idPedido= ? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteAllDetPedido($idPedido)
    {
        $qry = "DELETE FROM det_pedido WHERE idPedido= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido));
    }

    public function getDetPedido($idPedido)
    {
        $qry = "SELECT dp.idPedido, dp.codProducto, presentacion as Producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto
                FROM det_pedido dp
                         LEFT JOIN prodpre p on dp.codProducto = p.codPresentacion
                WHERE dp.idPedido = $idPedido
                  AND dp.codProducto > 10000
                  AND dp.codProducto < 100000
                UNION
                SELECT dp.idPedido, dp.codProducto, producto as Producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0))precioProducto
                FROM det_pedido dp
                         LEFT JOIN distribucion d on dp.codProducto = d.idDistribucion
                WHERE dp.idPedido = $idPedido
                  AND dp.codProducto > 100000
                UNION
                SELECT dp.idPedido, dp.codProducto, desServicio as Producto, cantProducto, precioProducto
                FROM det_pedido dp
                         LEFT JOIN servicios s on dp.codProducto = s.idServicio
                WHERE dp.idPedido = $idPedido
                  AND dp.codProducto < 100";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTotalSelPedido($selPedido)
    {
        $qry = "SELECT dp.codProducto, SUM(cantProducto) cantidad, presentacion producto, 1 orden
                FROM det_pedido dp
                         LEFT JOIN prodpre p ON dp.codProducto = p.codPresentacion
                WHERE dp.codProducto < 100000
                  AND dp.codProducto > 10000
                  AND dp.idPedido IN ($selPedido)
                GROUP BY dp.codProducto, producto
                UNION
                SELECT dp.codProducto, SUM(cantProducto) cantidad, producto, 2 orden
                FROM det_pedido dp
                         LEFT JOIN distribucion d ON dp.codProducto = d.idDistribucion
                WHERE dp.codProducto > 100000
                  AND dp.idPedido IN ($selPedido)
                GROUP BY dp.codProducto, producto
                ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTableDetPedido($idPedido)
    {
        $qry = "SELECT dcp.codProducto, p.presentacion producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 0)) subtotal, 1 orden
                FROM det_pedido dcp
                         LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                WHERE idPedido = $idPedido
                  AND dcp.codProducto < 100000 AND dcp.codProducto > 10000
                UNION
                SELECT dcp.codProducto, producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 0)) subtotal, 2 orden
                FROM det_pedido dcp
                         LEFT JOIN distribucion d on dcp.codProducto = d.idDistribucion
                WHERE idPedido = $idPedido
                  AND dcp.codProducto >= 100000
                UNION
                SELECT dcp.codProducto, s.desServicio producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 0)) subtotal, 3 orden
                FROM det_pedido dcp
                         LEFT JOIN servicios s on dcp.codProducto = s.idServicio
                WHERE idPedido = $idPedido
                  AND dcp.codProducto < 10000
                ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

 public function getTotalPedido($idPedido)
    {
        $qry = "SELECT CONCAT('$', FORMAT(SUM(cantProducto*precioProducto), 0)) totalPedido
                FROM det_pedido dp
                WHERE dp.idPedido= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return $result['totalPedido'];
        }else{
            return 0;
        }

    }

 public function getTotalItemsPedido($idPedido)
    {
        $qry = "SELECT COUNT(*) c
                FROM det_pedido dcp
                WHERE idPedido = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return $result['c'];
        }else{
            return 0;
        }
    }

    public function getDetProdPedido($idPedido, $codProducto)
    {
        if ($codProducto > 100000) {
            $qry = "SELECT producto, cantProducto, precioProducto
                    FROM det_pedido dcp
                             LEFT JOIN distribucion d ON dcp.codProducto=d.idDistribucion
                    WHERE idPedido = ?
                      AND dcp.codProducto = ?";
        }elseif($codProducto < 10000){
            $qry = "SELECT desServicio producto, cantProducto, precioProducto
                    FROM det_pedido dcp
                             LEFT JOIN servicios s on dcp.codProducto = s.idServicio
                    WHERE idPedido = ?
                      AND dcp.codProducto = ?;";
        }else{
            $qry = "SELECT presentacion producto, cantProducto, precioProducto
                    FROM det_pedido dcp
                             LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                    WHERE idPedido = ?
                      AND dcp.codProducto = ?;";
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido, $codProducto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function updateDetPedido($datos)
    {
        $qry = "UPDATE det_pedido SET cantProducto=?, precioProducto=?  WHERE idPedido=? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
