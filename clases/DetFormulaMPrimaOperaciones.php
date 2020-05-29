<?php

class DetFormulaMPrimaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetFormulaMPrima($datos)
    {
        $qry = "INSERT INTO det_formula_mp (idFormulaMPrima, codMPrima, porcentaje)VALUES(?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetFormulaMPrima($datos)
    {
        $qry = "DELETE FROM det_formula_mp WHERE idFormulaMPrima= ? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getMPrimasFormula($idFormulaMPrima){
        $qry = "SELECT mprimas.codMPrima, nomMPrima FROM mprimas
                LEFT JOIN (SELECT codMPrima FROM det_formula_mp WHERE idFormulaMPrima=?) df
                          on mprimas.codMPrima = df.codMPrima
                WHERE df.codMPrima IS NULL ORDER BY nomMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaMPrima));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableDetFormulaMPrimas($idFormulaMPrima)
    {
        $qry = "SELECT det_formula_mp.codMPrima, nomMPrima, CONCAT(ROUND(porcentaje*100,3), ' %') porcentaje FROM det_formula_mp
                LEFT JOIN mprimas m on det_formula_mp.codMPrima = m.codMPrima
                WHERE idFormulaMPrima=? ";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaMPrima));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPorcentajeTotal($idFormulaMPrima){
        $qry = "SELECT CONCAT(ROUND(SUM(porcentaje)*100,3), ' %') porcentaje FROM det_formula_mp WHERE idFormulaMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result['porcentaje'];
    }

    public function getDetFormulaMPrima($idFormulaMPrima, $codMPrima)
    {
        $qry = "SELECT idFormulaMPrima, df.codMPrima, porcentaje, nomMPrima
                FROM det_formula_mp df
                         LEFT JOIN mprimas mp ON df.codMPrima = mp.codMPrima
                WHERE idFormulaMPrima=? AND df.codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaMPrima, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function codMPrimaExiste($idFormulaMPrima, $codMPrima)
    {
        $qry = "SELECT COUNT(*) c from det_formula_mp where idFormulaMPrima=? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaMPrima, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $codMPrimaExiste = $result['c'] > 0;
        return $codMPrimaExiste;
    }


    public function updateDetFormulaMPrima($datos)
    {
        $qry = "UPDATE det_formula_mp SET porcentaje=?  WHERE idFormulaMPrima=? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
