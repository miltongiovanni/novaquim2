<?php

class KitsOperaciones
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

    public function makeKit($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO kit (idKit, codEnvase, codigo) VALUES (0, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

public function deleteKit($idKit)
{
    $qry = "DELETE FROM det_kit WHERE idKit=$idKit";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
    $qry = "DELETE FROM kit WHERE idKit=$idKit";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
}

    public function getTableKits()
    {
        $qry = "SELECT k.idKit, codigo, presentacion producto, nomEnvase FROM kit k
                LEFT JOIN prodpre p on k.codigo = p.codPresentacion
                LEFT JOIN envases e on k.codEnvase = e.codEnvase
                WHERE p.presentacion IS NOT NULL
                UNION
                SELECT k.idKit, codigo, producto, nomEnvase FROM kit k
                LEFT JOIN distribucion d on k.codigo = d.idDistribucion
                LEFT JOIN envases e on k.codEnvase = e.codEnvase
                WHERE d.idDistribucion IS NOT NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getKit($idKit)
    {
        $qry = "SELECT k.idKit, codigo, presentacion producto, nomEnvase, k.codEnvase
                FROM kit k
                         LEFT JOIN prodpre p on k.codigo = p.codPresentacion
                         LEFT JOIN envases e on k.codEnvase = e.codEnvase
                WHERE k.idKit=$idKit AND p.presentacion IS NOT NULL
                UNION
                SELECT k.idKit, codigo, producto, nomEnvase, k.codEnvase
                FROM kit k
                         LEFT JOIN distribucion d on k.codigo = d.idDistribucion
                         LEFT JOIN envases e on k.codEnvase = e.codEnvase
                WHERE k.idKit=$idKit AND d.idDistribucion IS NOT NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getKits()
    {
        $qry = "SELECT k.idKit, presentacion producto FROM kit k
                LEFT JOIN prodpre p on k.codigo = p.codPresentacion
                WHERE p.presentacion IS NOT NULL
                UNION
                SELECT k.idKit, producto FROM kit k
                LEFT JOIN distribucion d on k.codigo = d.idDistribucion
                WHERE d.idDistribucion IS NOT NULL
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getKitsEliminar()
    {
        $qry = "SELECT kit.idKit, nomKit
                FROM kit
                LEFT JOIN ord_prod op on kit.idKit = op.idKit
                WHERE op.idKit IS NULL
                ORDER BY nomKit";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNomKit($idKit)
    {
        $qry = "SELECT nomKit FROM kit WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idKit));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nomKit'];
    }

    public function getKitById($idKit)
    {
        $qry = "SELECT idKit, kit.idProv, nomProv, numFact, fechKit, fechVenc, estadoKit, descEstado
                FROM kit
                         LEFT JOIN estados e on kit.estadoKit = e.idEstado
                         LEFT JOIN proveedores p on kit.idProv = p.idProv
                WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idKit));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getKitByProd($codProducto)
    {
        $qry = "SELECT idKit, nomKit FROM kit WHERE codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProducto));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkFactura($idProv, $numFact)
    {
        $qry = "SELECT idKit  FROM kit WHERE idProv= ? AND numFact= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv, $numFact));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateKit($datos)
    {
        $qry = "UPDATE kit SET idProv=?, numFact=?, fechKit=?, fechVenc=? WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function cancelaKit($estadoKit, $fechPago, $idKit)
    {
        $qry = "UPDATE kit SET estadoKit=?, fechCancelacion=? WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estadoKit, $fechPago, $idKit));
    }

    public function updateEstadoKit($datos)
    {
        $qry = "UPDATE kit SET estadoKit=? WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateTotalesKit($base, $idKit)
    {
        $qry = "UPDATE kit,
                (SELECT IF(SUM(precKit * cantKit) IS NULL, 0, ROUND(SUM(precKit * cantKit), 2)) subtotal,
                        IF(SUM(precKit * cantKit) IS NULL, 0,
                           ROUND(SUM(precKit * cantKit * tasaIva), 2)) AS iva,
                        IF(SUM(precKit * cantKit) IS NULL, 0,
                           ROUND((SUM(precKit * cantKit) + SUM(precKit * cantKit * tasaIva)),
                                 0)) total,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precKit * cantKit) >= $base, ROUND(SUM(precKit * cantKit * tasaRetIca), 0),
                              0)) AS reteica,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precKit * cantKit) >= $base, ROUND(SUM(precKit * cantKit * tasaRetefuente), 0),
                              0)) AS retefuente
                 FROM det_kit dg
                          LEFT JOIN kit g ON dg.idKit = g.idKit
                          LEFT JOIN tasa_iva ti ON dg.codIva = ti.idTasaIva
                          LEFT JOIN proveedores p ON g.idProv = p.idProv
                          LEFT JOIN tasa_reteica tr on p.idTasaIcaProv = tr.idTasaRetIca
                          LEFT JOIN tasa_retefuente t on p.idRetefuente = t.idTasaRetefuente
                      WHERE dg.idKit = $idKit) tabla
            SET totalKit=total,
                subtotalKit=subtotal,
                ivaKit=iva,
                retefuenteKit=retefuente,
                reteicaKit=reteica
            WHERE idKit = $idKit";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
    }
}
