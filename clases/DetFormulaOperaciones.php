<?php

class DetFormulaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetFormula($datos)
    {
        $qry = "INSERT INTO det_formula (idFormula, codMPrima, porcentaje, orden)VALUES(?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(
            $datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetFormula($datos)
    {
        $qry = "DELETE FROM det_formula WHERE idFormula= ? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getMPrimasFormula($idFormula){
        $qry = "SELECT mprimas.codMPrima, nomMPrima FROM mprimas
                LEFT JOIN (SELECT codMPrima FROM det_formula WHERE idFormula=?) df
                          on mprimas.codMPrima = df.codMPrima
                WHERE df.codMPrima IS NULL ORDER BY nomMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormula));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableDetFormulas($idFormula)
    {
        $qry = "SELECT det_formula.codMPrima, orden, nomMPrima, CONCAT(ROUND(porcentaje*100,3), ' %') porcentaje FROM det_formula
                LEFT JOIN mprimas m on det_formula.codMPrima = m.codMPrima
                WHERE idFormula=? ORDER BY orden";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormula));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPorcentajeTotal($idFormula){
        $qry = "SELECT CONCAT(ROUND(SUM(porcentaje)*100,3), ' %') porcentaje FROM det_formula WHERE idFormula=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormula));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result['porcentaje'];
    }

    public function getDetFormula($idFormula, $codMPrima)
    {
        $qry = "SELECT idFormula, df.codMPrima, porcentaje, orden, nomMPrima
                FROM det_formula df
                         LEFT JOIN mprimas mp ON df.codMPrima = mp.codMPrima
                WHERE idFormula=? AND df.codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormula, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetalleFormula($idFormula)
    {
        $qry = "SELECT idFormula, codMPrima, porcentaje, orden
                FROM det_formula df
                WHERE idFormula=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormula));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function codMPrimaExiste($idFormula, $codMPrima)
    {
        $qry = "SELECT COUNT(*) c from det_formula where idFormula=? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormula, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $codMPrimaExiste = $result['c'] > 0;
        return $codMPrimaExiste;
    }


    public function updateDetFormula($datos)
    {
        $qry = "UPDATE det_formula SET porcentaje=?, orden=?  WHERE idFormula=? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
