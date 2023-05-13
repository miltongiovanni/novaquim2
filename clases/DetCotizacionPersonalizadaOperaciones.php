<?php

class DetCotizacionPersonalizadaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetCotPersonalizada($datos)
    {
        $qry = "INSERT INTO det_cot_personalizada (idCotPersonalizada, codProducto, canProducto, precioProducto) VALUES (?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetCotPersonalizada($datos)
    {
        $qry = "DELETE FROM det_cot_personalizada WHERE idCotPersonalizada= ? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }


    public function getTableDetCotPersonalizadaes($idCotPersonalizada)
    {
        $qry = "SELECT dr1.codProducto, presentacion producto, SUM(cantProducto) cantProducto
                FROM det_cot_personalizada dr1
                         LEFT JOIN prodpre p on dr1.codProducto = p.codPresentacion
                WHERE idRemision = $idCotPersonalizada
                  AND dr1.codProducto < 100000 
                GROUP BY dr1.codProducto, presentacion
                UNION
                SELECT dr1.codProducto, producto, cantProducto
                FROM det_cot_personalizada dr1
                         LEFT JOIN distribucion ON dr1.codProducto = idDistribucion
                WHERE idRemision = $idCotPersonalizada
                  AND dr1.codProducto > 100000";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetCotPersonalizada($idCotPersonalizada)
    {
        $qry = "SELECT dcp.codProducto, p.presentacion producto, canProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto, precioProducto precio
                FROM det_cot_personalizada dcp
                         LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                WHERE idCotPersonalizada = $idCotPersonalizada
                  AND dcp.codProducto < 100000
                UNION
                SELECT dcp.codProducto, producto, canProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto, precioProducto precio
                FROM det_cot_personalizada dcp
                         LEFT JOIN distribucion d on dcp.codProducto = d.idDistribucion
                WHERE idCotPersonalizada = $idCotPersonalizada
                  AND dcp.codProducto >= 100000";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTableDetCotPersonalizada($idCotPersonalizada)
    {
        $qry = "SELECT dcp.codProducto, p.presentacion producto, canProducto, precioProducto, ROUND(precioProducto/1.19) precioProductoSinIva, ROUND(precioProducto*canProducto) subtotal,
                    ROUND(precioProducto*canProducto/1.19) subtotalSinIva
                FROM det_cot_personalizada dcp
                         LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                WHERE idCotPersonalizada = $idCotPersonalizada
                  AND dcp.codProducto < 100000
                UNION
                SELECT dcp.codProducto, producto, canProducto, precioProducto, ROUND(precioProducto/(1+tasaIva)) precioProductoSinIva, ROUND(precioProducto*canProducto) subtotal,
                    ROUND(precioProducto*canProducto/(1+tasaIva)) subtotalSinIva
                FROM det_cot_personalizada dcp
                         LEFT JOIN distribucion d on dcp.codProducto = d.idDistribucion
                         LEFT JOIN tasa_iva t ON t.idTasaIva=d.codIva
                WHERE idCotPersonalizada = $idCotPersonalizada
                  AND dcp.codProducto >= 100000";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

 public function getTotalCotPersonalizada($idCotPersonalizada)
    {
        $qry = "SELECT CONCAT('$', FORMAT(SUM(canProducto*precioProducto), 0)) totalCotizacion
                FROM det_cot_personalizada dcp
                WHERE idCotPersonalizada = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCotPersonalizada));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['totalCotizacion'];
    }

    public function getDetProdCotizacion($idCotPersonalizada, $codProducto)
    {
        if ($codProducto > 100000) {
            $qry = "SELECT producto, canProducto, precioProducto
                    FROM det_cot_personalizada dcp
                             LEFT JOIN distribucion d ON dcp.codProducto=d.idDistribucion
                    WHERE idCotPersonalizada = ?
                      AND dcp.codProducto = ?";
        }else{
            $qry = "SELECT presentacion producto, canProducto, precioProducto
                    FROM det_cot_personalizada dcp
                             LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                    WHERE idCotPersonalizada = ?
                      AND dcp.codProducto = ?;";

        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCotPersonalizada, $codProducto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function updateDetCotPersonalizada($datos)
    {
        $qry = "UPDATE det_cot_personalizada SET canProducto=?, precioProducto=?  WHERE idCotPersonalizada=? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
