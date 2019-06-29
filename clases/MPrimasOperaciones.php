<?php

class MPrimasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeMPrima($datos)
    {
        /*Preparo la inserción */
        $qry = "INSERT INTO mprimas (codMPrima, nomMPrima, aliasMPrima, idCatMPrima, minStockMPrima, aparienciaMPrima, olorMPrima, colorMPrima, pHmPrima, densidadMPrima, codIva) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    
    public function deleteMPrima($codMPrima)
    {
        $qry = "DELETE FROM mprimas WHERE codMPrima= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima));
    }

    public function getMPrimas()
    {
        $qry = "SELECT codMPrima, nomMPrima FROM mprimas ORDER BY nomMPrima;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableMPrimas()
    {
        $qry = "SELECT codMPrima as 'Código', nomMPrima as 'Materia Prima', aliasMPrima Alias, catMP as 'Tipo de Materia Prima', minStockMprima as 'Stock Mínimo', 
        aparienciaMPrima Apariencia, olorMPrima Olor, colorMPrima Color, pHmPrima pH, densidadMPrima Densidad, codMPrimaAnt 'Código ant'
        FROM  mprimas, cat_mp
        WHERE idCatMprima=idCatMP
        ORDER BY Código;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getMPrima($codMPrima)
    {
        $qry = "SELECT codMPrima, nomMPrima, aliasMPrima, idCatMPrima, catMP, codIva, tasaIva, minStockMprima, aparienciaMPrima, olorMPrima, colorMPrima, pHmPrima, densidadMPrima, codMPrimaAnt
        FROM  mprimas, cat_mp, tasa_iva
        WHERE idCatMprima=idCatMP AND idTasaIva = codIva AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimaMPrimaxCat(int $idCatMPrima)
    {
        $qry = "SELECT codMPrima, catMP FROM mprimas mp1, cat_mp, (SELECT MAX(codMPrima) as Cod from mprimas where idCatMPrima=?) mp2 
        WHERE mp1.codMPrima = Cod AND idCatMP=idCatMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function updateMPrima($datos)
    {                                     
        $qry = "UPDATE mprimas SET nomMPrima=?, aliasMPrima=?, idCatMPrima=?, minStockMprima=?, aparienciaMPrima=?, olorMPrima=?,  colorMPrima=?, pHmPrima=?, densidadMPrima=?, codIva=? WHERE codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
