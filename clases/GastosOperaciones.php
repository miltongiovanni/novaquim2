<?php

class GastosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }

    public function makeGasto($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO gastos (idProv, numFact, fechGasto, fechVenc, estadoGasto, idUsuario) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function getTableGastos()
    {
        $qry = "SELECT idGasto, nitProv, nomProv, numFact, fechGasto, fechVenc, descEstado, CONCAT('$', FORMAT(totalGasto, 0)) totalGasto,
                CONCAT('$', FORMAT(retefuenteGasto, 0)) retefuenteGasto, CONCAT('$', FORMAT(reteicaGasto, 0)) reteicaGasto,
                CONCAT('$', FORMAT(totalGasto-retefuenteGasto-reteicaGasto, 0))  vreal
                FROM gastos
                   LEFT JOIN estados e on gastos.estadoGasto = e.idEstado
                   LEFT JOIN proveedores p on gastos.idProv = p.idProv
                ORDER BY idGasto DESC;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getTableGastosPorFecha($fechaIni, $fechaFin)
    {
        $qry = "SELECT idGasto,
                       nitProv,
                       nomProv,
                       numFact,
                       fechGasto,
                       CONCAT('$', FORMAT(subtotalGasto, 0))                                 subtotalGasto,
                       CONCAT('$', FORMAT(ivaGasto, 0))                                      ivaGasto,
                       CONCAT('$', FORMAT(retefuenteGasto, 0))                               retefuenteGasto,
                       CONCAT('$', FORMAT(reteicaGasto, 0))                                  reteicaGasto,
                       CONCAT('$', FORMAT(totalGasto, 0))                                    totalGasto,
                       CONCAT('$', FORMAT(totalGasto - retefuenteGasto - reteicaGasto, 0)) vreal
                FROM gastos
                         LEFT JOIN proveedores p on gastos.idProv = p.idProv
                WHERE fechGasto >= ?
                  AND fechGasto <= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaIni, $fechaFin));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getTotalesGastosPorFecha($fechaIni, $fechaFin)
    {
        $qry = "SELECT
                       CONCAT('$', FORMAT(SUM(subtotalGasto), 0))                                 subtotalPeriodo,
                       CONCAT('$', FORMAT(SUM(ivaGasto), 0))                                      ivaPeriodo,
                       CONCAT('$', FORMAT(SUM(totalGasto), 0))                                    totalPeriodo,
                       CONCAT('$', FORMAT(SUM(retefuenteGasto), 0))                               retefuentePeriodo,
                       CONCAT('$', FORMAT(SUM(reteicaGasto), 0))                                  reteicaPeriodo
                FROM gastos
                WHERE fechGasto >= ?
                  AND fechGasto <= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaIni, $fechaFin));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getGasto($idGasto)
    {
        $qry = "SELECT idGasto, gastos.idProv, nitProv, nomProv, numFact, fechGasto, fechVenc, estadoGasto, descEstado, CONCAT('$', FORMAT(totalGasto, 0)) totalGasto,
                       CONCAT('$', FORMAT(retefuenteGasto, 0)) retefuenteGasto, CONCAT('$', FORMAT(reteicaGasto, 0)) reteicaGasto,
                       CONCAT('$', FORMAT(totalGasto-retefuenteGasto-reteicaGasto, 0))  vreal
                FROM gastos
                         LEFT JOIN estados e on gastos.estadoGasto = e.idEstado
                         LEFT JOIN proveedores p on gastos.idProv = p.idProv
                WHERE idGasto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idGasto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getGastoById($idGasto)
    {
        $qry = "SELECT idGasto, gastos.idProv, nomProv, numFact, fechGasto, fechVenc, estadoGasto, descEstado
                FROM gastos
                         LEFT JOIN estados e on gastos.estadoGasto = e.idEstado
                         LEFT JOIN proveedores p on gastos.idProv = p.idProv
                WHERE idGasto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idGasto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkFactura($idProv, $numFact)
    {
        $qry = "SELECT idGasto  FROM gastos WHERE idProv= ? AND numFact= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv, $numFact));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function isValidIdGasto($idGasto)
    {
        $qry = "SELECT * FROM gastos WHERE idGasto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idGasto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result==false){
            return false;
        }
        else{
            return true;
        }
    }
    public function updateGasto($datos)
    {
        $qry = "UPDATE gastos SET idProv=?, numFact=?, fechGasto=?, fechVenc=? WHERE idGasto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function cancelaGasto($estadoGasto, $fechPago, $idGasto)
    {
        $qry = "UPDATE gastos SET estadoGasto=?, fechCancelacion=? WHERE idGasto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estadoGasto, $fechPago, $idGasto));
    }

    public function updateEstadoGasto($datos)
    {
        $qry = "UPDATE gastos SET estadoGasto=? WHERE idGasto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateTotalesGasto($base, $idGasto)
    {
        $qry = "UPDATE gastos,
                (SELECT IF(SUM(precGasto * cantGasto) IS NULL, 0, ROUND(SUM(precGasto * cantGasto), 2)) subtotal,
                        IF(SUM(precGasto * cantGasto) IS NULL, 0,
                           ROUND(SUM(precGasto * cantGasto * tasaIva), 2)) AS iva,
                        IF(SUM(precGasto * cantGasto) IS NULL, 0,
                           ROUND((SUM(precGasto * cantGasto) + SUM(precGasto * cantGasto * tasaIva)),
                                 0)) total,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precGasto * cantGasto) >= $base, ROUND(SUM(precGasto * cantGasto * tasaRetIca), 0),
                              0)) AS reteica,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precGasto * cantGasto) >= $base, ROUND(SUM(precGasto * cantGasto * tasaRetefuente), 0),
                              0)) AS retefuente
                 FROM det_gastos dg
                          LEFT JOIN gastos g ON dg.idGasto = g.idGasto
                          LEFT JOIN tasa_iva ti ON dg.codIva = ti.idTasaIva
                          LEFT JOIN proveedores p ON g.idProv = p.idProv
                          LEFT JOIN tasa_reteica tr on p.idTasaIcaProv = tr.idTasaRetIca
                          LEFT JOIN tasa_retefuente t on p.idRetefuente = t.idTasaRetefuente
                      WHERE dg.idGasto = $idGasto) tabla
            SET totalGasto=total,
                subtotalGasto=subtotal,
                ivaGasto=iva,
                retefuenteGasto=retefuente,
                reteicaGasto=reteica
            WHERE idGasto = $idGasto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
    }
}
