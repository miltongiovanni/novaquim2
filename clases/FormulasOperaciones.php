<?php

class FormulasOperaciones
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

    public function makeFormula($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO formula (idFormula, nomFormula, codProducto) VALUES (0, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

public function deleteFormula($idFormula)
{
    $qry = "DELETE FROM det_formula WHERE idFormula=$idFormula";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
    $qry = "DELETE FROM formula WHERE idFormula=$idFormula";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
}

    public function getTableFormulas()
    {
        $qry = "SELECT idFormula, nitProv, nomProv, numFact, fechFormula, fechVenc, descEstado, CONCAT('$', FORMAT(totalFormula, 0)) totalFormula,
                CONCAT('$', FORMAT(retefuenteFormula, 0)) retefuenteFormula, CONCAT('$', FORMAT(reteicaFormula, 0)) reteicaFormula,
                CONCAT('$', FORMAT(totalFormula-retefuenteFormula-reteicaFormula, 0))  vreal
                FROM formula
                   LEFT JOIN estados e on formula.estadoFormula = e.idEstado
                   LEFT JOIN proveedores p on formula.idProv = p.idProv
                ORDER BY idFormula DESC;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFormulas()
    {
        $qry = "SELECT idFormula, nomFormula FROM formula ORDER BY nomFormula;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFormulasEliminar()
    {
        $qry = "SELECT formula.idFormula, nomFormula
                FROM formula
                LEFT JOIN ord_prod op on formula.idFormula = op.idFormula
                WHERE op.idFormula IS NULL
                ORDER BY nomFormula";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNomFormula($idFormula)
    {
        $qry = "SELECT nomFormula FROM formula WHERE idFormula=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormula));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nomFormula'];
    }

    public function getFormulaById($idFormula)
    {
        $qry = "SELECT idFormula, formula.idProv, nomProv, numFact, fechFormula, fechVenc, estadoFormula, descEstado
                FROM formula
                         LEFT JOIN estados e on formula.estadoFormula = e.idEstado
                         LEFT JOIN proveedores p on formula.idProv = p.idProv
                WHERE idFormula=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormula));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFormulaByProd($codProducto)
    {
        $qry = "SELECT idFormula, nomFormula FROM formula WHERE codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProducto));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkFactura($idProv, $numFact)
    {
        $qry = "SELECT idFormula  FROM formula WHERE idProv= ? AND numFact= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv, $numFact));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateFormula($datos)
    {
        $qry = "UPDATE formula SET idProv=?, numFact=?, fechFormula=?, fechVenc=? WHERE idFormula=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function cancelaFormula($estadoFormula, $fechPago, $idFormula)
    {
        $qry = "UPDATE formula SET estadoFormula=?, fechCancelacion=? WHERE idFormula=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estadoFormula, $fechPago, $idFormula));
    }

    public function updateEstadoFormula($datos)
    {
        $qry = "UPDATE formula SET estadoFormula=? WHERE idFormula=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateTotalesFormula($base, $idFormula)
    {
        $qry = "UPDATE formula,
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
                 FROM det_formula dg
                          LEFT JOIN formula g ON dg.idFormula = g.idFormula
                          LEFT JOIN tasa_iva ti ON dg.codIva = ti.idTasaIva
                          LEFT JOIN proveedores p ON g.idProv = p.idProv
                          LEFT JOIN tasa_reteica tr on p.idTasaIcaProv = tr.idTasaRetIca
                          LEFT JOIN tasa_retefuente t on p.idRetefuente = t.idTasaRetefuente
                      WHERE dg.idFormula = $idFormula) tabla
            SET totalFormula=total,
                subtotalFormula=subtotal,
                ivaFormula=iva,
                retefuenteFormula=retefuente,
                reteicaFormula=reteica
            WHERE idFormula = $idFormula";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
    }
}
