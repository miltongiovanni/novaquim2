<?php

class InvDistribucionOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeInvDistribucion($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO inv_distribucion VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteInvDistribucion($datos)
    {
        $qry = "DELETE FROM inv_distribucion WHERE codDistribucion= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getInvDistribucion($codDistribucion)
    {
        $qry = "SELECT invDistribucion FROM inv_distribucion WHERE codDistribucion=? ";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codDistribucion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        } else {
            return $result['invDistribucion'];
        }
    }

    public function getTableInvDistribucion($idCompra, $tipoCompra)
    {
        switch (intval($tipoCompra)) {
            case 1:
                $qry = "SELECT idCompra, codigo, nomMPrima Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN mprimas ON codigo=codDistribucionrima
                        WHERE idCompra=$idCompra";
                break;
            case 2:
                $qry = "SELECT codigo, nomEnvase Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN inv_distribucion ON codigo=codDistribucion
                        WHERE idCompra=$idCompra AND codigo < 100
                        UNION
                        SELECT codigo, tapa Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN tapas_val ON codigo=codTapa
                        WHERE idCompra=$idCompra AND codigo > 100";
                break;
            case 3:
                $qry = "SELECT codigo, nomEtiqueta Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN etiquetas ON codigo=codEtiqueta
                        WHERE idCompra=$idCompra ;";
                break;
            case 5:
                $qry = "SELECT codigo, producto Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN distribucion ON codigo=idDistribucion
                        WHERE idCompra=$idCompra";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorCategoria($idProv, $idCatProv)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codDistribucionrima Codigo, nomMPrima Producto FROM mprimas
                        LEFT JOIN inv_distribucion dp ON dp.Codigo=codDistribucionrima AND dp.idProv=? WHERE dp.Codigo IS NULL ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codDistribucion Codigo, nomEnvase Producto  FROM inv_distribucion
                        LEFT JOIN inv_distribucion ON Codigo=codDistribucion AND idProv=? WHERE Codigo IS NULL
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM tapas_val
                        LEFT JOIN inv_distribucion ON Codigo=codTapa AND idProv=? AND codTapa<>114 WHERE Codigo IS NULL ORDER BY Producto;
                        ";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM etiquetas
                        LEFT JOIN inv_distribucion ON Codigo=codEtiqueta and idProv=? WHERE Codigo IS NULL ORDER BY Producto;";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN inv_distribucion ON Codigo=idDistribucion AND idProv=? WHERE Codigo IS NULL order by Producto";
                break;
        }

        $stmt = $this->_pdo->prepare($qry);

        $stmt->execute(array($idProv));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateInvDistribucion($datos)
    {
        $qry = "UPDATE inv_distribucion SET invDistribucion=? WHERE codDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}