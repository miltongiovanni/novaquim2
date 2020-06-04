<?php

class FormulasMPrimaOperaciones
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

    public function makeFormulaMPrima($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO formula_mp (idFormulaMPrima, codMPrima) VALUES (0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

public function deleteFormulaMPrima($idFormulaMPrima)
{
    $qry = "DELETE FROM det_formula_mp WHERE idFormulaMPrima=$idFormulaMPrima";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
    $qry = "DELETE FROM formula_mp WHERE idFormulaMPrima=$idFormulaMPrima";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
}

    public function getTableFormulaMPrimas()
    {
        $qry = "SELECT idFormulaMPrima, nitProv, nomProv, numFact, fechFormulaMPrima, fechVenc, descEstado, CONCAT('$', FORMAT(totalFormulaMPrima, 0)) totalFormulaMPrima,
                CONCAT('$', FORMAT(retefuenteFormulaMPrima, 0)) retefuenteFormulaMPrima, CONCAT('$', FORMAT(reteicaFormulaMPrima, 0)) reteicaFormulaMPrima,
                CONCAT('$', FORMAT(totalFormulaMPrima-retefuenteFormulaMPrima-reteicaFormulaMPrima, 0))  vreal
                FROM formula_mp
                   LEFT JOIN estados e on formula_mp.estadoFormulaMPrima = e.idEstado
                   LEFT JOIN proveedores p on formula_mp.idProv = p.idProv
                ORDER BY idFormulaMPrima DESC;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMPrimasParaFormula()
    {
        $qry = "SELECT mprimas.codMPrima, nomMPrima FROM mprimas
                LEFT JOIN formula_mp fm on mprimas.codMPrima = fm.codMPrima
                WHERE fm.codMPrima IS NULL
                ORDER BY nomMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFormulasMPrima()
    {
        $qry = "SELECT idFormulaMPrima, nomMPrima
                FROM formula_mp
                         LEFT JOIN mprimas m on formula_mp.codMPrima = m.codMPrima
                ORDER BY nomMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFormulasMPrimaEliminar()
    {
        $qry = "SELECT formula_mp.idFormulaMPrima, nomMPrima
                FROM formula_mp
                LEFT JOIN mprimas ON formula_mp.codMPrima = mprimas.codMPrima
                LEFT JOIN ord_prod_mp op ON formula_mp.idFormulaMPrima = op.idFormMP
                WHERE op.idFormMP IS NULL
                ORDER BY nomMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNomFormulaMPrima($idFormulaMPrima)
    {
        $qry = "SELECT idFormulaMPrima, nomMPrima
                FROM formula_mp
                LEFT JOIN mprimas m on formula_mp.codMPrima = m.codMPrima
                WHERE idFormulaMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nomMPrima'];
    }

    public function getCodFormulaMPrima($idFormulaMPrima)
    {
        $qry = "SELECT formula_mp.codMPrima
                FROM formula_mp
                LEFT JOIN mprimas m on formula_mp.codMPrima = m.codMPrima
                WHERE idFormulaMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['codMPrima'];
    }

    public function getFormulaMPrimaById($idFormulaMPrima)
    {
        $qry = "SELECT idFormulaMPrima, formula_mp.idProv, nomProv, numFact, fechFormulaMPrima, fechVenc, estadoFormulaMPrima, descEstado
                FROM formula_mp
                         LEFT JOIN estados e on formula_mp.estadoFormulaMPrima = e.idEstado
                         LEFT JOIN proveedores p on formula_mp.idProv = p.idProv
                WHERE idFormulaMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkFactura($idProv, $numFact)
    {
        $qry = "SELECT idFormulaMPrima  FROM formula_mp WHERE idProv= ? AND numFact= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv, $numFact));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateFormulaMPrima($datos)
    {
        $qry = "UPDATE formula_mp SET idProv=?, numFact=?, fechFormulaMPrima=?, fechVenc=? WHERE idFormulaMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function cancelaFormulaMPrima($estadoFormulaMPrima, $fechPago, $idFormulaMPrima)
    {
        $qry = "UPDATE formula_mp SET estadoFormulaMPrima=?, fechCancelacion=? WHERE idFormulaMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estadoFormulaMPrima, $fechPago, $idFormulaMPrima));
    }

    public function updateEstadoFormulaMPrima($datos)
    {
        $qry = "UPDATE formula_mp SET estadoFormulaMPrima=? WHERE idFormulaMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateTotalesFormulaMPrima($base, $idFormulaMPrima)
    {
        $qry = "UPDATE formula_mp,
                (SELECT IF(SUM(precFormulaMPrima * cantFormulaMPrima) IS NULL, 0, ROUND(SUM(precFormulaMPrima * cantFormulaMPrima), 2)) subtotal,
                        IF(SUM(precFormulaMPrima * cantFormulaMPrima) IS NULL, 0,
                           ROUND(SUM(precFormulaMPrima * cantFormulaMPrima * tasaIva), 2)) AS iva,
                        IF(SUM(precFormulaMPrima * cantFormulaMPrima) IS NULL, 0,
                           ROUND((SUM(precFormulaMPrima * cantFormulaMPrima) + SUM(precFormulaMPrima * cantFormulaMPrima * tasaIva)),
                                 0)) total,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precFormulaMPrima * cantFormulaMPrima) >= $base, ROUND(SUM(precFormulaMPrima * cantFormulaMPrima * tasaRetIca), 0),
                              0)) AS reteica,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precFormulaMPrima * cantFormulaMPrima) >= $base, ROUND(SUM(precFormulaMPrima * cantFormulaMPrima * tasaRetefuente), 0),
                              0)) AS retefuente
                 FROM det_formula_mp dg
                          LEFT JOIN formula_mp g ON dg.idFormulaMPrima = g.idFormulaMPrima
                          LEFT JOIN tasa_iva ti ON dg.codIva = ti.idTasaIva
                          LEFT JOIN proveedores p ON g.idProv = p.idProv
                          LEFT JOIN tasa_reteica tr on p.idTasaIcaProv = tr.idTasaRetIca
                          LEFT JOIN tasa_retefuente t on p.idRetefuente = t.idTasaRetefuente
                      WHERE dg.idFormulaMPrima = $idFormulaMPrima) tabla
            SET totalFormulaMPrima=total,
                subtotalFormulaMPrima=subtotal,
                ivaFormulaMPrima=iva,
                retefuenteFormulaMPrima=retefuente,
                reteicaFormulaMPrima=reteica
            WHERE idFormulaMPrima = $idFormulaMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
    }
}
