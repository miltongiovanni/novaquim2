<?php

class OProdOperaciones
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

    public function makeOProd($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO ord_prod (lote, fechProd, idFormula, cantidadKg, codResponsable, codProducto, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function getTableOProd($limit, $order, $where, $bindings)
    {
        $qry = "select * from (SELECT lote, fechProd, p.nomProducto, f.nomFormula, ROUND(cantidadKg, 0) cantidadKg, p2.nomPersonal, eop.descEstado
                FROM ord_prod
                LEFT JOIN formula f on ord_prod.idFormula = f.idFormula
                LEFT JOIN productos p on ord_prod.codProducto = p.codProducto
                LEFT JOIN personal p2 on ord_prod.codResponsable = p2.idPersonal
                LEFT JOIN estados_o_prod eop on ord_prod.estado = eop.idEstado) opfpp2e
                $where
                $order
                $limit
                ";
        $stmt = $this->_pdo->prepare($qry);
        // Bind parameters
        if (is_array($bindings)) {
            for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $binding = $bindings[$i];
                $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
            }
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalTableOProd( $where, $bindings)
    {
        $qry = "select COUNT(lote) c from (SELECT lote, fechProd, p.nomProducto, f.nomFormula, ROUND(cantidadKg, 0) cantidadKg, p2.nomPersonal, eop.descEstado
                FROM ord_prod
                LEFT JOIN formula f on ord_prod.idFormula = f.idFormula
                LEFT JOIN productos p on ord_prod.codProducto = p.codProducto
                LEFT JOIN personal p2 on ord_prod.codResponsable = p2.idPersonal
                LEFT JOIN estados_o_prod eop on ord_prod.estado = eop.idEstado) opfpp2e
                $where
                ";
        $stmt = $this->_pdo->prepare($qry);
        // Bind parameters
        if (is_array($bindings)) {
            for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $binding = $bindings[$i];
                $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
            }
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['c'];
    }

    public function getOrdenesProdXProd($codProducto)
    {
        $qry = "SELECT lote, fechProd, p2.nomPersonal, ROUND(cantidadKg, 0) cantidadKg, eop.descEstado
                FROM ord_prod
                         LEFT JOIN productos p on ord_prod.codProducto = p.codProducto
                         LEFT JOIN personal p2 on ord_prod.codResponsable = p2.idPersonal
                         LEFT JOIN estados_o_prod eop on ord_prod.estado = eop.idEstado
                WHERE p.codProducto = ?;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProducto));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableOProdAnuladas()
    {
        $qry = "SELECT lote, fechProd, p.nomProducto, f.nomFormula, ROUND(cantidadKg, 0) cantidadKg, p2.nomPersonal
                FROM ord_prod
                LEFT JOIN formula f on ord_prod.idFormula = f.idFormula
                LEFT JOIN productos p on ord_prod.codProducto = p.codProducto
                LEFT JOIN personal p2 on ord_prod.codResponsable = p2.idPersonal
                WHERE estado=5";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableOProdSinEnvasar()
    {
        $qry = "SELECT lote, fechProd, p.nomProducto, f.nomFormula, ROUND(cantidadKg, 0) cantidadKg, p2.nomPersonal
                FROM ord_prod
                LEFT JOIN formula f on ord_prod.idFormula = f.idFormula
                LEFT JOIN productos p on ord_prod.codProducto = p.codProducto
                LEFT JOIN personal p2 on ord_prod.codResponsable = p2.idPersonal
                WHERE estado=1 OR estado=3";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOProdPorAnular()
    {
        $qry = "SELECT lote
                FROM ord_prod
                WHERE estado=1 OR estado=2";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOProdSinEnvasar()
    {
        $qry = "SELECT lote, nomProducto, cantidadKg
                FROM ord_prod op
                LEFT JOIN productos p on p.codProducto = op.codProducto
                WHERE estado=1 OR estado=3 ORDER BY lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOProdXCalidad()
    {
        $qry = "SELECT lote
                FROM ord_prod
                WHERE estado=2 ORDER BY lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOProdXCalProdTerminado()
    {
        $qry = "SELECT lote
                FROM ord_prod
                WHERE estado=4 ORDER BY lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEtiquetasXLote($lote)
    {
        $qry = "SELECT DISTINCT nomEtiqueta
                FROM ord_prod op
                         LEFT JOIN prodpre p on op.codProducto = p.codProducto
                         LEFT JOIN etiquetas e on p.codEtiq = e.codEtiqueta
                WHERE lote = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOProd($lote)
    {
        $qry = "SELECT lote, fechProd, ord_prod.codProducto, p.nomProducto, f.nomFormula, ROUND(cantidadKg, 0) cantidadKg, vencimiento,
                ord_prod.estado, p2.nomPersonal, eop.descEstado, densMin, densMax, pHmin, pHmax, fragancia, color, apariencia
                FROM ord_prod
                LEFT JOIN formula f on ord_prod.idFormula = f.idFormula
                LEFT JOIN productos p on ord_prod.codProducto = p.codProducto
                LEFT JOIN personal p2 on ord_prod.codResponsable = p2.idPersonal
                LEFT JOIN estados_o_prod eop on ord_prod.estado = eop.idEstado
                WHERE lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCantMPrimaAcXMes($fecha, $codMPrima)
    {
        $qry = "SELECT ROUND(SUM(cantidadMPrima), 1) cantidadProduccion
                FROM ord_prod op
                         LEFT JOIN det_ord_prod dop on op.lote = dop.lote
                WHERE MONTH(fechProd) = MONTH('$fecha')
                  AND YEAR(fechProd) = YEAR('$fecha')
                  AND codMPrima = $codMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result === null) {
            return 0;
        } else {
            return $result['cantidadProduccion'];
        }

    }

    public function getCantProductoAcXMes($fecha, $codProducto)
    {
        $qry = "SELECT ROUND(SUM(cantidadKg), 0) cantidadProduccion
                FROM ord_prod op
                WHERE MONTH(fechProd) = MONTH('$fecha')
                  AND YEAR(fechProd) = YEAR('$fecha')
                  AND codProducto = $codProducto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['cantidadProduccion'] === null) {
            return 0;
        } else {
            return $result['cantidadProduccion'];
        }

    }

    public function isValidLote($lote)
    {
        $qry = "SELECT * FROM ord_prod WHERE lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function getLastLote()
    {
        $qry = "SELECT MAX(lote) lastLote FROM ord_prod";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['lastLote'];
    }

    public function anulaOProd($lote)
    {
        $qry = "UPDATE ord_prod SET estado=5, cantidadKg=0 WHERE lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
    }

    public function updateEstadoOProd($datos)
    {
        $qry = "UPDATE ord_prod SET estado=? WHERE lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }
}
