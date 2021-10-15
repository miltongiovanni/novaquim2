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
            return $result;
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

    public function getLotesMPrima($codMPrima)
    {
        $qry = "SELECT loteMP
                FROM inv_mprimas
                WHERE codMP=?
                AND invMP>0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllLotesMPrima($codMPrima)
    {
        $qry = "SELECT loteMP
                FROM inv_mprimas
                WHERE codMP=?";
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

    public function getTableStockInvMPrima()
    {
        $qry = "SELECT codMP, nomMPrima, ROUND(SUM(invMP),3) invTotal, minStockMPrima
                FROM inv_mprimas imp
                         LEFT JOIN mprimas m on imp.codMP = m.codMPrima
                WHERE codMP != 10401 AND codMP != 10402
                GROUP BY codMP, nomMPrima, minStockMPrima
                HAVING  SUM(invMP) < minStockMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableInvMPrimaFecha($fecha)
    {
        $qry = "SELECT i.codMP,
                       i.nomMPrima,
                       i.invtotal,
                       ec.entrada,
                       salidaProduccion,
                       salidaEnvDist
                FROM (SELECT codMP, nomMPrima, ROUND(SUM(invMP), 3) invtotal
                      FROM inv_mprimas
                               LEFT JOIN mprimas m on inv_mprimas.codMP = m.codMPrima
                      WHERE codMP != 10401
                        AND codMP != 10402
                        AND invMP > 0
                      GROUP BY codMP) i
                         LEFT JOIN (SELECT codigo, ROUND(SUM(cantidad), 3) entrada
                                    FROM compras c
                                             LEFT JOIN det_compras dc on c.idCompra = dc.idCompra
                                    WHERE tipoCompra = 1
                                      AND fechComp >= '$fecha'
                                    GROUP BY codigo) ec ON i.codMP = ec.codigo
                         LEFT JOIN (SELECT dop.codMPrima, ROUND(SUM(cantidadMPrima), 3) salidaProduccion
                                    FROM ord_prod op
                                             LEFT JOIN det_ord_prod dop on op.lote = dop.lote
                                    WHERE fechProd > '$fecha'
                                    GROUP BY dop.codMPrima) sp ON sp.codMPrima = i.codMP
                         LEFT JOIN (SELECT codMPrima, ROUND(SUM(cantMedida * cantidad * densidad / 1000), 3) salidaEnvDist
                                    FROM rel_dist_mp rdm
                                             LEFT JOIN mprimadist m on rdm.codMPrimaDist = m.codMPrimaDist
                                             LEFT JOIN medida m2 on rdm.codMedida = m2.idMedida
                                             LEFT JOIN envasado_dist ed on rdm.codDist = ed.codDist
                                    WHERE fechaEnvDist > '$fecha'
                                    GROUP BY codMPrima) ek ON ek.codMPrima = i.codMP";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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
