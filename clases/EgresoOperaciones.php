<?php

class EgresoOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeEgreso($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO egreso (idCompra, tipoCompra) VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteEgreso($idEgreso)
    {
        $qry = "DELETE FROM egreso WHERE idProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEgreso));
    }

    public function getEgresoes($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idProv, nomProv FROM egreso WHERE estProv=1 ORDER BY nomProv;";
        } else {
            $qry = "SELECT idProv, nomProv FROM egreso ORDER BY nomProv;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgresoesByTipo($tipoCompra)
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE idCatProv = $tipoCompra ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllEgresoesGastos()
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE (idCatProv = 5 OR idCatProv = 6) ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgresoesByName($q)
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgresoesByNameAndTipoCompra($q, $tipoCompra)
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE idCatProv=? AND nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgresoesGastos($q)
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE (idCatProv=5 OR idCatProv=6) AND nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableEgresos()
    {
        $qry = "SELECT idEgreso, e.idCompra, fp.formaPago, CONCAT('$', FORMAT(pago, 0)) pago, fechPago,
                       numFact, nitProv, nomProv, tipoComp, CONCAT('$', FORMAT(descuentoE, 0)) descuento,
                       CONCAT('$', FORMAT(total-retefuente-reteica, 0)) vreal
                FROM egreso e
                LEFT JOIN ( SELECT idCompra id, tipoCompra, numFact, fechComp, fechVenc, totalCompra total, c.idProv,
                            nitProv, nomProv, retefuenteCompra retefuente, reteicaCompra reteica
                            FROM compras c
                            LEFT JOIN proveedores p on c.idProv = p.idProv
                            UNION
                            SELECT idGasto id, tipoCompra, numFact, fechGasto fechComp, fechVenc, totalGasto total, g.idProv,
                            nitProv, nomProv, retefuenteGasto retefuente, reteicaGasto reteica
                            FROM gastos g
                            LEFT JOIN proveedores p ON g.idProv = p.idProv
                            ) t ON e.idCompra=t.id AND e.tipoCompra=t.tipoCompra
                LEFT JOIN form_pago fp ON e.formPago = fp.idFormaPago
                LEFT JOIN tip_compra tc ON e.tipoCompra=tc.idTipo";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFormEgreso($idEgreso)
    {
        $qry = "SELECT idEgreso, e.idCompra, e.tipoCompra, CONCAT('$', FORMAT(pago, 0)) pago, pago pagon, fechPago, descuentoE, formPago, formaPago, estadoCompra,
                       numFact, fechComp, fechVenc, CONCAT('$', FORMAT(total, 0)) total, nitProv, nomProv, CONCAT('$', FORMAT(retefuente, 0)) retefuente, CONCAT('$', FORMAT(reteica, 0)) reteica, pago vlr_pago,
                       CONCAT('$', FORMAT(total-retefuente-reteica, 0))  vreal, (total-retefuente-reteica) treal 
                FROM egreso e
                LEFT JOIN ( SELECT idCompra id, tipoCompra, numFact, fechComp, fechVenc, totalCompra total, estadoCompra,
                              nitProv, nomProv, retefuenteCompra retefuente, reteicaCompra reteica
                       FROM compras c
                                LEFT JOIN proveedores p on c.idProv = p.idProv
                       UNION
                       SELECT idGasto id, tipoCompra, numFact, fechGasto fechComp, fechVenc, totalGasto total, estadoGasto estadoCompra,
                              nitProv, nomProv, retefuenteGasto retefuente, reteicaGasto reteica
                       FROM gastos g
                                LEFT JOIN proveedores p on g.idProv = p.idProv
                ) t ON e.idCompra=t.id AND e.tipoCompra=t.tipoCompra
                LEFT JOIN form_pago fp on e.formPago = fp.idFormaPago 
                WHERE idEgreso=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEgreso));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgreso($idEgreso)
    {
        $qry = "SELECT idEgreso, e.idCompra, e.tipoCompra, pago, fechPago, descuentoE,
                       numFact, fechComp, fechVenc, total, nitProv, nomProv, retefuente, reteica,
                       (total-retefuente-reteica)  vreal FROM egreso e
                LEFT JOIN ( SELECT idCompra id, tipoCompra, numFact, fechComp, fechVenc, totalCompra total,
                            nitProv, nomProv, retefuenteCompra retefuente, reteicaCompra reteica
                            FROM compras c
                            LEFT JOIN proveedores p on c.idProv = p.idProv
                            UNION
                            SELECT idGasto id, tipoCompra, numFact, fechGasto fechComp, fechVenc, totalGasto total,
                            nitProv, nomProv, retefuenteGasto retefuente, reteicaGasto reteica
                            FROM gastos g
                            LEFT JOIN proveedores p on g.idProv = p.idProv
                          ) t ON e.idCompra=t.id AND e.tipoCompra=t.tipoCompra
                WHERE idEgreso=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEgreso));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalesxPagarxVen8dias()
    {
        $qry = "SELECT SUM(subtotal) total
                FROM
                (SELECT (SUM(totalCompra) - SUM(retefuenteCompra) - SUM(reteicaCompra) - IF(SUM(pago) IS NULL, 0, SUM(pago)) - IF(SUM(descuentoE) IS NULL, 0 , SUM(descuentoE))) subtotal
                FROM compras c
                LEFT JOIN egreso e on c.idCompra = e.idCompra AND c.tipoCompra=e.tipoCompra
                WHERE estadoCompra=3 AND DATEDIFF(fechVenc, NOW())>= 8
                UNION
                SELECT (SUM(totalGasto)- SUM(retefuenteGasto)- SUM(reteicaGasto)- IF(SUM(pago) IS NULL, 0, SUM(pago))- IF(SUM(descuentoE) IS NULL, 0 , SUM(descuentoE))) subtotal
                FROM gastos g
                LEFT JOIN egreso e2 on g.tipoCompra = e2.tipoCompra AND g.idGasto=e2.idCompra
                WHERE estadoGasto=3 AND DATEDIFF(fechVenc, NOW())>= 8) t;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getTotalesxPagarxVencidos()
    {
        $qry = "SELECT SUM(subtotal) total
                FROM
                (SELECT (SUM(totalCompra) - SUM(retefuenteCompra) - SUM(reteicaCompra) - IF(SUM(pago) IS NULL, 0, SUM(pago)) - IF(SUM(descuentoE) IS NULL, 0 , SUM(descuentoE))) subtotal
                FROM compras c
                LEFT JOIN egreso e on c.idCompra = e.idCompra AND c.tipoCompra=e.tipoCompra
                WHERE estadoCompra=3 AND DATEDIFF(fechVenc, NOW())< 0
                UNION
                SELECT (SUM(totalGasto)- SUM(retefuenteGasto)- SUM(reteicaGasto)- IF(SUM(pago) IS NULL, 0, SUM(pago))- IF(SUM(descuentoE) IS NULL, 0 , SUM(descuentoE))) subtotal
                FROM gastos g
                LEFT JOIN egreso e2 on g.tipoCompra = e2.tipoCompra AND g.idGasto=e2.idCompra
                WHERE estadoGasto=3 AND DATEDIFF(fechVenc, NOW())< 0) t;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getTotalesxPagarxVenc1sem()
    {
        $qry = "SELECT subtotal total
                FROM
                (SELECT (SUM(totalCompra) - SUM(retefuenteCompra) - SUM(reteicaCompra) - IF(SUM(pago) IS NULL, 0, SUM(pago)) - IF(SUM(descuentoE) IS NULL, 0 , SUM(descuentoE))) subtotal
                FROM compras c
                LEFT JOIN egreso e on c.idCompra = e.idCompra AND c.tipoCompra=e.tipoCompra
                WHERE estadoCompra=3 AND DATEDIFF(fechVenc, NOW())>= 0  AND DATEDIFF(fechVenc, NOW())< 8
                UNION
                SELECT (SUM(totalGasto)- SUM(retefuenteGasto)- SUM(reteicaGasto)- IF(SUM(pago) IS NULL, 0, SUM(pago))- IF(SUM(descuentoE) IS NULL, 0 , SUM(descuentoE))) subtotal
                FROM gastos g
                LEFT JOIN egreso e2 on g.tipoCompra = e2.tipoCompra AND g.idGasto=e2.idCompra
                WHERE estadoGasto=3 AND DATEDIFF(fechVenc,NOW() )>= 0  AND DATEDIFF(fechVenc, NOW())< 8) t;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getPagosXIdTipoCompra($id, $tipoCompra)
    {
        $qry = "SELECT CONCAT('$', FORMAT(pago, 0)) pago, CONCAT('$', FORMAT(descuentoE, 0)) descuento, fechPago, formaPago
                FROM egreso 
                LEFT JOIN form_pago fp on egreso.formPago = fp.idFormaPago
                WHERE idCompra=? and tipoCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($id, $tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPagoXIdTipoCompra($id, $tipoCompra)
    {
        $qry = "SELECT SUM(pago) parcial FROM egreso WHERE idCompra=? and tipoCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($id, $tipoCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result != null) {
            return $result['parcial'];
        } else {
            return 0;
        }
    }

    public function getTableComprasXPagar()
    {
        $qry = "SELECT idCompra id, tipoCompra, tipoComp, numFact, fechComp, fechVenc, totalCompra total, subtotalCompra subtotal,
                       nomProv, retefuenteCompra retefuente, reteicaCompra reteica
                FROM compras c
                LEFT JOIN proveedores p on c.idProv = p.idProv
                LEFT JOIN tip_compra tc on c.tipoCompra = tc.idTipo
                WHERE estadoCompra=3
                UNION
                SELECT idGasto id, tipoCompra, tipoComp, numFact, fechGasto fechComp, fechVenc, totalGasto total, subtotalGasto subtotal,
                       nomProv, retefuenteGasto retefuente, reteicaGasto reteica
                FROM gastos g
                LEFT JOIN proveedores p on g.idProv = p.idProv
                LEFT JOIN tip_compra t on g.tipoCompra = t.idTipo
                WHERE estadoGasto=3
                ORDER BY fechVenc";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkEgreso($idCompra, $tipoCompra)
    {
        $qry = "SELECT idEgreso  FROM egreso WHERE idCompra = ? AND tipoCompra = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra, $tipoCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateEgreso($datos)
    {
        $qry = "UPDATE egreso SET pago=?, fechPago=?, descuentoE=?, formPago=? WHERE idEgreso=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
