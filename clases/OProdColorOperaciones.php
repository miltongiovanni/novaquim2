<?php

class OProdColorOperaciones
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

    public function makeOProdColor($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO ord_prod_col (loteColor, fechProd, idFormulaColor, cantKg, codPersonal, codColor) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function getTableOProdColor()
    {
        $qry = "SELECT loteColor, fechProd, nomMPrima, ROUND(cantKg, 0) cantKg, p2.nomPersonal
                FROM ord_prod_col
                    LEFT JOIN formula_col f on ord_prod_col.idFormulaColor = f.idFormulaColor
                    LEFT JOIN mprimas ON ord_prod_col.codColor = mprimas.codMPrima
                    LEFT JOIN personal p2 on ord_prod_col.codPersonal = p2.idPersonal";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOProdColor($loteColor)
    {
        $qry = "SELECT loteColor, fechProd, nomMPrima, ROUND(cantKg, 0) cantKg, p2.nomPersonal
                FROM ord_prod_col
                    LEFT JOIN formula_col f on ord_prod_col.idFormulaColor = f.idFormulaColor
                    LEFT JOIN mprimas ON ord_prod_col.codColor = mprimas.codMPrima
                    LEFT JOIN personal p2 on ord_prod_col.codPersonal = p2.idPersonal
                WHERE loteColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteColor));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCantMPrimaAcXMes($fecha, $codMPrima)
    {
        $qry = "SELECT ROUND(SUM(cantMPrima),1) cantidadProdColor
                FROM ord_prod_col opc
                         LEFT JOIN det_ord_prod_col dop on opc.loteColor = dop.loteColor
                WHERE MONTH(fechProd) = MONTH('$fecha')
                  AND YEAR(fechProd) = YEAR('$fecha')
                  AND codMPrima = $codMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result === null){
            return 0;
        } else{
            return $result['cantidadProdColor'];
        }

    }

    public function isValidLote($loteColor)
    {
        $qry = "SELECT * FROM ord_prod_col WHERE loteColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteColor));
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
        $qry = "SELECT MAX(loteColor) lastLote FROM ord_prod_col";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['lastLote'];
    }

    public function updateOProdColor($datos)
    {
        $qry = "UPDATE ord_prod_col SET idProv=?, numFact=?, fechOProdColor=?, fechVenc=? WHERE loteColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function anulaOProdColor($loteColor)
    {
        $qry = "UPDATE ord_prod_col SET estado=5, cantKg=0 WHERE loteColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteColor));
    }

    public function updateEstadoOProdColor($datos)
    {
        $qry = "UPDATE ord_prod_col SET estado=? WHERE loteColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }
}
