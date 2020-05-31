<?php

class FormulasColorOperaciones
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

    public function makeFormulaColor($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO formula_col (idFormulaColor, codSolucionColor) VALUES (0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

public function deleteFormulaColor($idFormulaColor)
{
    $qry = "DELETE FROM det_formula_col WHERE idFormulaColor=$idFormulaColor";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
    $qry = "DELETE FROM formula_col WHERE idFormulaColor=$idFormulaColor";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
}

    public function getTableFormulas()
    {
        $qry = "SELECT idFormulaColor, nitProv, nomProv, numFact, fechFormula, fechVenc, descEstado, CONCAT('$', FORMAT(totalFormula, 0)) totalFormula,
                CONCAT('$', FORMAT(retefuenteFormula, 0)) retefuenteFormula, CONCAT('$', FORMAT(reteicaFormula, 0)) reteicaFormula,
                CONCAT('$', FORMAT(totalFormula-retefuenteFormula-reteicaFormula, 0))  vreal
                FROM formula_col
                   LEFT JOIN estados e on formula_col.estadoFormula = e.idEstado
                   LEFT JOIN proveedores p on formula_col.idProv = p.idProv
                ORDER BY idFormulaColor DESC;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFormulasColor()
    {
        $qry = "SELECT idFormulaColor, nomMPrima
                FROM formula_col
                LEFT JOIN mprimas m on formula_col.codSolucionColor = m.codMPrima
                ORDER BY nomMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getSoluciones()
    {
        $qry = "SELECT codMPrima, nomMPrima
                FROM mprimas
                LEFT JOIN formula_col ON codMPrima=codSolucionColor
                WHERE codSolucionColor IS NULL AND nomMPrima LIKE 'Solucion%'";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getFormulasColorEliminar()
    {
        $qry = "SELECT formula_col.idFormulaColor, nomMPrima
                FROM formula_col
                    LEFT JOIN mprimas ON formula_col.codSolucionColor = mprimas.codMPrima
                    LEFT JOIN ord_prod_col op on formula_col.idFormulaColor = op.idFormulaColor
                WHERE op.idFormulaColor IS NULL
                ORDER BY nomMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNomFormulaColor($idFormulaColor)
    {
        $qry = "SELECT nomMPrima FROM formula_col
                LEFT JOIN mprimas m on formula_col.codSolucionColor = m.codMPrima
                WHERE idFormulaColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaColor));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nomMPrima'];
    }

    public function getFormulaById($idFormulaColor)
    {
        $qry = "SELECT idFormulaColor, formula_col.idProv, nomProv, numFact, fechFormula, fechVenc, estadoFormula, descEstado
                FROM formula_col
                         LEFT JOIN estados e on formula_col.estadoFormula = e.idEstado
                         LEFT JOIN proveedores p on formula_col.idProv = p.idProv
                WHERE idFormulaColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormulaColor));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkFactura($idProv, $numFact)
    {
        $qry = "SELECT idFormulaColor  FROM formula_col WHERE idProv= ? AND numFact= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv, $numFact));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateFormula($datos)
    {
        $qry = "UPDATE formula_col SET idProv=?, numFact=?, fechFormula=?, fechVenc=? WHERE idFormulaColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function cancelaFormula($estadoFormula, $fechPago, $idFormulaColor)
    {
        $qry = "UPDATE formula_col SET estadoFormula=?, fechCancelacion=? WHERE idFormulaColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estadoFormula, $fechPago, $idFormulaColor));
    }

    public function updateEstadoFormula($datos)
    {
        $qry = "UPDATE formula_col SET estadoFormula=? WHERE idFormulaColor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateTotalesFormula($base, $idFormulaColor)
    {
        $qry = "UPDATE formula_col,
                (SELECT IF(SUM(precFormula * cantFormula) IS NULL, 0, ROUND(SUM(precFormula * cantFormula), 2)) subtotal,
                        IF(SUM(precFormula * cantFormula) IS NULL, 0,
                           ROUND(SUM(precFormula * cantFormula * tasaIva), 2)) AS iva,
                        IF(SUM(precFormula * cantFormula) IS NULL, 0,
                           ROUND((SUM(precFormula * cantFormula) + SUM(precFormula * cantFormula * tasaIva)),
                                 0)) total,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precFormula * cantFormula) >= $base, ROUND(SUM(precFormula * cantFormula * tasaRetIca), 0),
                              0)) AS reteica,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precFormula * cantFormula) >= $base, ROUND(SUM(precFormula * cantFormula * tasaRetefuente), 0),
                              0)) AS retefuente
                 FROM det_formula_col dg
                          LEFT JOIN formula_col g ON dg.idFormulaColor = g.idFormulaColor
                          LEFT JOIN tasa_iva ti ON dg.codIva = ti.idTasaIva
                          LEFT JOIN proveedores p ON g.idProv = p.idProv
                          LEFT JOIN tasa_reteica tr on p.idTasaIcaProv = tr.idTasaRetIca
                          LEFT JOIN tasa_retefuente t on p.idRetefuente = t.idTasaRetefuente
                      WHERE dg.idFormulaColor = $idFormulaColor) tabla
            SET totalFormula=total,
                subtotalFormula=subtotal,
                ivaFormula=iva,
                retefuenteFormula=retefuente,
                reteicaFormula=reteica
            WHERE idFormulaColor = $idFormulaColor";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
    }
}
