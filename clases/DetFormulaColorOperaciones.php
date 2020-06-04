<?php

class DetFormulaColorOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetFormulaColor($datos)
    {
        $qry = "INSERT INTO det_formula_col (idFormulaColor, codMPrima, porcentaje)VALUES(?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetFormulaColor($datos)
    {
        $qry = "DELETE FROM det_formula_col WHERE idFormulaColor= ? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getMPrimasFormula($idFormulaColor){
        $qry = "SELECT mprimas.codMPrima, nomMPrima FROM mprimas
                LEFT JOIN (SELECT codMPrima FROM det_formula_col WHERE idFormulaColor=?) df
                          on mprimas.codMPrima = df.codMPrima
                WHERE df.codMPrima IS NULL ORDER BY nomMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaColor));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableDetFormulaColor($idFormulaColor)
    {
        $qry = "SELECT det_formula_col.codMPrima, nomMPrima, CONCAT(ROUND(porcentaje*100,3), ' %') porcentaje FROM det_formula_col
                LEFT JOIN mprimas m on det_formula_col.codMPrima = m.codMPrima
                WHERE idFormulaColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaColor));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetalleFormulaColor($idFormulaColor)
    {
        $qry = "SELECT codMPrima, porcentaje FROM det_formula_col
                WHERE idFormulaColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaColor));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPorcentajeTotal($idFormulaColor){
        $qry = "SELECT CONCAT(ROUND(SUM(porcentaje)*100,3), ' %') porcentaje FROM det_formula_col WHERE idFormulaColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaColor));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result['porcentaje'];
    }

    public function getDetFormulaColor($idFormulaColor, $codMPrima)
    {
        $qry = "SELECT idFormulaColor, df.codMPrima, porcentaje, nomMPrima
                FROM det_formula_col df
                         LEFT JOIN mprimas mp ON df.codMPrima = mp.codMPrima
                WHERE idFormulaColor=? AND df.codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaColor, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function codMPrimaExiste($idFormulaColor, $codMPrima)
    {
        $qry = "SELECT COUNT(*) c from det_formula_col where idFormulaColor=? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaColor, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $codMPrimaExiste = $result['c'] > 0;
        return $codMPrimaExiste;
    }


    public function updateDetFormulaColor($datos)
    {
        $qry = "UPDATE det_formula_col SET porcentaje=? WHERE idFormulaColor=? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
