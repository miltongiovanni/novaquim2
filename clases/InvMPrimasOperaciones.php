<?php

class InvMPrimasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeInvMPrima($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO inv_mprimas VALUES(?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteInvMPrima($datos)
    {
        $qry = "DELETE FROM inv_mprimas WHERE codMP= ? AND loteMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteAllDetCompra($idProv)
    {
        $qry = "DELETE FROM inv_mprimas WHERE idProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv));
    }

    public function getFechaLoteInvMPrima($codMP, $loteMP)
    {
        $qry = "SELECT fechLote FROM inv_mprimas WHERE codMP=? AND loteMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMP, $loteMP));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['fechLote'];
    }

    public function getInvMPrimaByLote($codMP, $loteMP)
    {
        $qry = "SELECT invMP FROM inv_mprimas WHERE codMP=? AND loteMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMP, $loteMP));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        } else {
            return $result['invMP'];
        }
    }

    public function getInvTotalMPrima($codMPrima)
    {
        $qry = "SELECT SUM(invMP) invMP FROM inv_mprimas WHERE codMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        } else {
            return $result['invMP'];
        }
    }

    public function getInvMPrima($codMPrima)
    {
        $qry = "SELECT invMP, loteMP, fechLote FROM inv_mprimas WHERE codMP=? ORDER BY fechLote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableInvMPrima($idCompra, $tipoCompra)
    {
        switch (intval($tipoCompra)) {
            case 1:
                $qry = "SELECT idCompra, codigo, nomMPrima Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN mprimas ON codigo=codMPrima
                        WHERE idCompra=$idCompra";
                break;
            case 2:
                $qry = "SELECT codigo, nomEnvase Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN envases ON codigo=codEnvase
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
                $qry = "SELECT codMPrima Codigo, nomMPrima Producto FROM mprimas
                        LEFT JOIN inv_mprimas dp ON dp.Codigo=codMPrima AND dp.idProv=? WHERE dp.Codigo IS NULL ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codEnvase Codigo, nomEnvase Producto  FROM envases
                        LEFT JOIN inv_mprimas ON Codigo=codEnvase AND idProv=? WHERE Codigo IS NULL
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM tapas_val
                        LEFT JOIN inv_mprimas ON Codigo=codTapa AND idProv=? AND codTapa<>114 WHERE Codigo IS NULL ORDER BY Producto;
                        ";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM etiquetas
                        LEFT JOIN inv_mprimas ON Codigo=codEtiqueta and idProv=? WHERE Codigo IS NULL ORDER BY Producto;";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN inv_mprimas ON Codigo=idDistribucion AND idProv=? WHERE Codigo IS NULL order by Producto";
                break;
        }

        $stmt = $this->_pdo->prepare($qry);

        $stmt->execute(array($idProv));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetProveedor($idProv)
    {
        $qry = "SELECT codProveedor, nomProveedor, catProd, proveedores.idCatProd, prodActivo, densMin, densMax, pHmin, pHmax, fragancia, color, apariencia
        FROM  proveedores
        LEFT JOIN cat_prod cp on proveedores.idCatProd = cp.idCatProd
        WHERE codProveedor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProveedor));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimoProdxCat($idCatProd)
    {
        $qry = "SELECT MAX(codProveedor) as Cod from proveedores where idCatProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Cod'];
    }


    public function updateInvMPrima($datos)
    {
        $qry = "UPDATE inv_mprimas SET invMP=? WHERE codMP=? AND loteMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
