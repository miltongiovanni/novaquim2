<?php

class OProdMPrimaOperaciones
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

    public function makeOProdMPrima($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO ord_prod_mp (loteMP, fechProd, idFormMP, cantKg, codPersonal, codMPrima) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function getTableOProdMPrima()
    {
        $qry = "SELECT loteMP, fechProd, nomMPrima, ROUND(cantKg, 0) cantKg, p2.nomPersonal
                FROM ord_prod_mp
                    LEFT JOIN formula_mp f on ord_prod_mp.idFormMP = f.idFormulaMPrima
                    LEFT JOIN mprimas ON ord_prod_mp.codMPrima = mprimas.codMPrima
                    LEFT JOIN personal p2 on ord_prod_mp.codPersonal = p2.idPersonal";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOProdMPrima($loteMP)
    {
        $qry = "SELECT loteMP, fechProd, nomMPrima, ROUND(cantKg, 0) cantKg, p2.nomPersonal
                FROM ord_prod_mp
                    LEFT JOIN formula_mp f on ord_prod_mp.idFormMP = f.idFormulaMPrima
                    LEFT JOIN mprimas ON ord_prod_mp.codMPrima = mprimas.codMPrima
                    LEFT JOIN personal p2 on ord_prod_mp.codPersonal = p2.idPersonal
                WHERE loteMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteMP));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCantMPrimaAcXMes($fecha, $codMPrima)
    {
        $qry = "SELECT ROUND(SUM(cantMPrima), 1) cantidadProdMPrima
                FROM ord_prod_mp opmp
                         LEFT JOIN det_ord_prod_mp dopm on opmp.loteMP = dopm.loteMP
                WHERE MONTH(fechProd) = MONTH('$fecha')
                  AND YEAR(fechProd) = YEAR('$fecha')
                  AND idMPrima = $codMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result == null){
            return 0;
        } else{
            return $result['cantidadProdMPrima'];
        }

    }

    public function isValidLote($loteMP)
    {
        $qry = "SELECT * FROM ord_prod_mp WHERE loteMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteMP));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result==false){
            return false;
        }
        else{
            return true;
        }
    }

    public function getLastLote()
    {
        $qry = "SELECT MAX(loteMP) lastLote FROM ord_prod_mp";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['lastLote'];
    }

    public function updateOProdMPrima($datos)
    {
        $qry = "UPDATE ord_prod_mp SET idProv=?, numFact=?, fechOProdMPrima=?, fechVenc=? WHERE loteMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function anulaOProdMPrima($loteMP)
    {
        $qry = "UPDATE ord_prod_mp SET estado=5, cantKg=0 WHERE loteMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteMP));
    }

    public function updateEstadoOProdMPrima($datos)
    {
        $qry = "UPDATE ord_prod_mp SET estado=? WHERE loteMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }
}
