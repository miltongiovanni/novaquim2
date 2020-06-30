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

    public function getMPrimasEliminar()
    {
        $qry = "SELECT mprimas.codMPrima, nomMPrima
                FROM mprimas
                LEFT JOIN det_formula df ON mprimas.codMPrima = df.codMPrima
                LEFT JOIN det_formula_col dfc ON mprimas.codMPrima = dfc.codMprima
                LEFT JOIN det_formula_mp dfm ON mprimas.codMPrima = dfm.codMPrima
                LEFT JOIN mPrimaDist ed ON mprimas.codMPrima = ed.codMPrima
                LEFT JOIN det_ord_prod dop on mprimas.codMPrima = dop.codMPrima
                WHERE df.codMPrima IS NULL AND dfc.codMprima IS NULL
                  AND dfm.codMPrima IS NULL AND ed.codMPrima IS NULL AND dop.codMPrima IS NULL
                ORDER BY nomMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableMPrimas()
    {
        $qry = "SELECT codMPrima, nomMPrima, aliasMPrima, catMP, minStockMprima, 
        aparienciaMPrima, olorMPrima, colorMPrima, pHmPrima, densidadMPrima, codMPrimaAnt 
		FROM mprimas
        LEFT JOIN cat_mp ON idCatMprima=idCatMP 
        ORDER BY codMPrima;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMPrima($codMPrima)
    {
        $qry = "SELECT codMPrima, nomMPrima, aliasMPrima, idCatMPrima, catMP, codIva, CONCAT(format((tasaIva*100),1), ' %') iva, minStockMprima, aparienciaMPrima, olorMPrima, colorMPrima, pHmPrima, densidadMPrima, codMPrimaAnt
        FROM  mprimas
           LEFT JOIN cat_mp cm on mprimas.idCatMPrima = cm.idCatMP
           LEFT JOIN tasa_iva ti on mprimas.codIva = ti.idTasaIva
        WHERE  codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPrecioMPrima($codMPrima)
    {
        $qry = "SELECT precioMPrima FROM  mprimas WHERE codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['precioMPrima'];
    }

    public function getNomMPrima($codMPrima)
    {
        $qry = "SELECT nomMPrima FROM  mprimas WHERE codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nomMPrima'];
    }

    public function getUltimaMPrimaxCat(int $idCatMPrima)
    {
        $qry = "SELECT codMPrima, catMP
        FROM mprimas mp1
        LEFT JOIN cat_mp cm on mp1.idCatMPrima = cm.idCatMP,
        (SELECT MAX(codMPrima) as Cod from mprimas where idCatMPrima=?) mp2
        WHERE mp1.codMPrima = Cod";
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

    public function updatePrecioMPrima($datos)
    {
        $qry = "UPDATE mprimas SET precioMPrima=? WHERE codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
