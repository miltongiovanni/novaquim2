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

    public function getTableInvMPrima()
    {
        $qry = "SELECT codMP, nomMPrima, ROUND(SUM(invMP),3) invtotal
                FROM inv_mprimas
                         LEFT JOIN mprimas m on inv_mprimas.codMP = m.codMPrima
                WHERE codMP != 10401 AND codMP != 10402 AND invMP > 0
                GROUP BY codMP";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEntradasInvMPrimaXFecha($codMPrima, $fecha)
    {
        $qry = "SELECT ROUND(SUM(cantidad), 3) entrada
                FROM compras c
                LEFT JOIN det_compras dc on c.idCompra = dc.idCompra
                WHERE tipoCompra=1 AND fechComp >= ? AND codigo=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fecha, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result != null) {
            return $result['entrada'];
        } else {
            return 0;
        }

    }

    public function getSalidasInvMPrimaOProdXFecha($codMPrima, $fecha)
    {
        $qry = "SELECT ROUND(SUM(cantidadMPrima), 3) salidaProduccion
                FROM ord_prod op
                LEFT JOIN det_ord_prod dop on op.lote = dop.lote
                WHERE fechProd >= ? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fecha, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result != null) {
            return $result['salidaProduccion'];
        } else {
            return 0;
        }
    }

    public function getSalidasInvMPrimaEnvDistXFecha($codMPrima, $fecha)
    {
        $qry = "SELECT codMPrima, ROUND(SUM(cantMedida*cantidad*densidad/1000), 3) salidaEnvDist
                FROM rel_dist_mp rdm
                LEFT JOIN mprimadist m on rdm.codMPrimaDist = m.codMPrimaDist
                LEFT JOIN medida m2 on rdm.codMedida = m2.idMedida
                LEFT JOIN envasado_dist ed on rdm.codDist = ed.codDist
                WHERE codMPrima=? AND fechaEnvDist>=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima, $fecha));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['salidaEnvDist'];
        } else {
            return 0;
        }
    }

    public function getDetInv($codMP)
    {
        $qry = "SELECT loteMP, invMP, fechLote
                FROM inv_mprimas
                WHERE codMP=? AND invMP>0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMP));
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
