<?php

class DesarmKitsOperaciones
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

    public function makeDesarmKit($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO desarm_kit (idDesarmado, codKit, cantDesarmado, fechDesarmado) VALUES (0, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

public function deleteDesarmKit($idDesarmado)
{
    $qry = "DELETE FROM desarm_kit WHERE idDesarmado=?";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute(array($idDesarmado));
}


    public function getTableDesarmKits()
    {
        $qry = "SELECT idDesarmado, codigo, presentacion producto, cantDesarmado, fechDesarmado
                FROM desarm_kit ak
                    LEFT JOIN kit k ON ak.codKit = k.idKit
                LEFT JOIN prodpre p ON k.codigo = p.codPresentacion
                WHERE p.presentacion IS NOT NULL
                UNION
                SELECT idDesarmado, codigo, producto, cantDesarmado, fechDesarmado
                FROM desarm_kit ak
                         LEFT JOIN kit k ON ak.codKit = k.idKit
                         LEFT JOIN distribucion d ON k.codigo = d.idDistribucion
                WHERE d.idDistribucion IS NOT NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDesarmKit($idDesarmado)
    {
        $qry = "SELECT k.idDesarmado, codigo, presentacion producto, nomEnvase
                FROM desarm_kit k
                         LEFT JOIN prodpre p on k.codigo = p.codPresentacion
                         LEFT JOIN envases e on k.codKit = e.codKit
                WHERE k.idDesarmado=$idDesarmado AND p.presentacion IS NOT NULL
                UNION
                SELECT k.idDesarmado, codigo, producto, nomEnvase
                FROM desarm_kit k
                         LEFT JOIN distribucion d on k.codigo = d.idDistribucion
                         LEFT JOIN envases e on k.codKit = e.codKit
                WHERE k.idDesarmado=$idDesarmado AND d.idDistribucion IS NOT NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDesarmKits()
    {
        $qry = "SELECT idDesarmado, nomKit FROM desarm_kit ORDER BY nomKit;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDesarmKitsEliminar()
    {
        $qry = "SELECT desarm_kit.idDesarmado, nomKit
                FROM desarm_kit
                LEFT JOIN ord_prod op on desarm_kit.idDesarmado = op.idDesarmado
                WHERE op.idDesarmado IS NULL
                ORDER BY nomKit";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNomDesarmKit($idDesarmado)
    {
        $qry = "SELECT nomKit FROM desarm_kit WHERE idDesarmado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDesarmado));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nomDesarmKit'];
    }

    public function getDesarmKitById($idDesarmado)
    {
        $qry = "SELECT idDesarmado, desarm_kit.idProv, nomProv, numFact, fechKit, fechVenc, estadoKit, descEstado
                FROM desarm_kit
                         LEFT JOIN estados e on desarm_kit.estadoKit = e.idEstado
                         LEFT JOIN proveedores p on desarm_kit.idProv = p.idProv
                WHERE idDesarmado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDesarmado));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDesarmKitByProd($codProducto)
    {
        $qry = "SELECT idDesarmado, nomKit FROM desarm_kit WHERE codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProducto));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateDesarmKit($datos)
    {
        $qry = "UPDATE desarm_kit SET idProv=?, numFact=?, fechDesarmKit=?, fechVenc=? WHERE idDesarmado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

}
