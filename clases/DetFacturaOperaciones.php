<?php

class DetFacturaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetFactura($datos)
    {
        $qry = "INSERT INTO det_factura (idFactura, codProducto, cantProducto, precioProducto, idTasaIvaProducto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetFactura($datos)
    {
        $qry = "DELETE FROM det_factura WHERE idFactura= ? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteAllDetFactura($idFactura)
    {
        $qry = "DELETE FROM det_factura WHERE idFactura= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
    }

    public function getDetFactura($idFactura)
    {
        $qry = "SELECT CONCAT('003000', codSiigo)              codigo,
                       presentacion as                         producto,
                       cantProducto,
                       CONCAT(ROUND( tasaIva*100, 0), ' %')   iva,
                       CONCAT('$ ', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$ ', FORMAT(precioProducto*cantProducto, 0)) subtotal,
                       1 orden
                FROM det_factura dp
                         LEFT JOIN prodpre p on dp.codProducto = p.codPresentacion
                         LEFT JOIN tasa_iva ti on ti.idTasaIva = dp.idTasaIvaProducto
                         LEFT JOIN factura f on f.idFactura = dp.idFactura
                WHERE dp.idFactura = $idFactura
                  AND dp.codProducto > 10000
                  AND dp.codProducto < 100000
                UNION
                SELECT CONCAT('003000', codSiigo)             codigo,
                       producto as                            producto,
                       cantProducto,
                       CONCAT(ROUND( tasaIva*100, 0), ' %')  iva,
                       CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$ ', FORMAT(precioProducto*cantProducto, 0)) subtotal,
                       2 orden
                FROM det_factura dp
                         LEFT JOIN distribucion d on dp.codProducto = d.idDistribucion
                         LEFT JOIN tasa_iva t on t.idTasaIva = dp.idTasaIvaProducto
                         LEFT JOIN factura f on f.idFactura = dp.idFactura
                WHERE dp.idFactura = $idFactura
                  AND dp.codProducto > 100000
                UNION
                SELECT CONCAT('003000', codSiigo)            codigo,
                       desServicio as                        producto,
                       cantProducto,
                       CONCAT(ROUND( tasaIva*100, 0), ' %') iva,
                       CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$ ', FORMAT(precioProducto*cantProducto, 0)) subtotal,
                       3 orden
                FROM det_factura dp
                         LEFT JOIN servicios s on dp.codProducto = s.idServicio
                         LEFT JOIN tasa_iva i on i.idTasaIva = dp.idTasaIvaProducto
                         LEFT JOIN factura f on f.idFactura = dp.idFactura
                WHERE dp.idFactura = $idFactura
                  AND dp.codProducto < 100
                  ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalSelFactura($selFactura)
    {
        $qry = "SELECT dp.codProducto, SUM(cantProducto) cantidad, presentacion producto, 1 orden
                FROM det_factura dp
                         LEFT JOIN prodpre p ON dp.codProducto = p.codPresentacion
                WHERE dp.codProducto < 100000
                  AND dp.codProducto > 10000
                  AND dp.idFactura IN ($selFactura)
                GROUP BY dp.codProducto, producto
                UNION
                SELECT dp.codProducto, SUM(cantProducto) cantidad, producto, 2 orden
                FROM det_factura dp
                         LEFT JOIN distribucion d ON dp.codProducto = d.idDistribucion
                WHERE dp.codProducto > 100000
                  AND dp.idFactura IN ($selFactura)
                GROUP BY dp.codProducto, producto
                ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTableDetFactura($idFactura)
    {
        $qry = "SELECT dcp.codProducto, p.presentacion producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 0)) subtotal, 1 orden
                FROM det_factura dcp
                         LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                WHERE idFactura = $idFactura
                  AND dcp.codProducto < 100000 AND dcp.codProducto > 10000
                UNION
                SELECT dcp.codProducto, producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 0)) subtotal, 2 orden
                FROM det_factura dcp
                         LEFT JOIN distribucion d on dcp.codProducto = d.idDistribucion
                WHERE idFactura = $idFactura
                  AND dcp.codProducto >= 100000
                UNION
                SELECT dcp.codProducto, s.desServicio producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 0)) subtotal, 3 orden
                FROM det_factura dcp
                         LEFT JOIN servicios s on dcp.codProducto = s.idServicio
                WHERE idFactura = $idFactura
                  AND dcp.codProducto < 10000
                ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

 public function getTotalFactura($idFactura)
    {
        $qry = "SELECT CONCAT('$', FORMAT(SUM(cantProducto*precioProducto), 0)) totalFactura
                FROM det_factura dp
                WHERE dp.idFactura= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return $result['totalFactura'];
        }else{
            return 0;
        }

    }

 public function getTotalItemsFactura($idFactura)
    {
        $qry = "SELECT COUNT(*) c
                FROM det_factura dcp
                WHERE idFactura = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return $result['c'];
        }else{
            return 0;
        }
    }

    public function getDetProdFactura($idFactura, $codProducto)
    {
        if ($codProducto > 100000) {
            $qry = "SELECT producto, cantProducto, precioProducto
                    FROM det_factura dcp
                             LEFT JOIN distribucion d ON dcp.codProducto=d.idDistribucion
                    WHERE idFactura = ?
                      AND dcp.codProducto = ?";
        }elseif($codProducto < 10000){
            $qry = "SELECT desServicio producto, cantProducto, precioProducto
                    FROM det_factura dcp
                             LEFT JOIN servicios s on dcp.codProducto = s.idServicio
                    WHERE idFactura = ?
                      AND dcp.codProducto = ?;";
        }else{
            $qry = "SELECT presentacion producto, cantProducto, precioProducto
                    FROM det_factura dcp
                             LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                    WHERE idFactura = ?
                      AND dcp.codProducto = ?;";
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura, $codProducto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function updateDetFactura($datos)
    {
        $qry = "UPDATE det_factura SET cantProducto=?, precioProducto=?  WHERE idFactura=? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
