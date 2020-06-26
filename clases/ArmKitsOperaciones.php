<?php

class ArmKitsOperaciones
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

    public function makeArmKit($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO arm_kit (idArmado, codKit, cantArmado, fechArmado) VALUES (0, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

public function deleteArmKit($idArmado)
{
    $qry = "DELETE FROM arm_kit WHERE idArmado=?";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute(array($idArmado));
}

    public function getTableArmKits()
    {
        $qry = "SELECT idArmado, codigo, presentacion producto, cantArmado, fechArmado
                FROM arm_kit ak
                    LEFT JOIN kit k ON ak.codKit = k.idKit
                LEFT JOIN prodpre p ON k.codigo = p.codPresentacion
                WHERE p.presentacion IS NOT NULL
                UNION
                SELECT idArmado, codigo, producto, cantArmado, fechArmado
                FROM arm_kit ak
                         LEFT JOIN kit k ON ak.codKit = k.idKit
                         LEFT JOIN distribucion d ON k.codigo = d.idDistribucion
                WHERE d.idDistribucion IS NOT NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getArmKit($idArmado)
    {
        $qry = "SELECT k.idArmado, codigo, presentacion producto, nomEnvase
                FROM arm_kit k
                         LEFT JOIN prodpre p on k.codigo = p.codPresentacion
                         LEFT JOIN envases e on k.codKit = e.codKit
                WHERE k.idArmado=$idArmado AND p.presentacion IS NOT NULL
                UNION
                SELECT k.idArmado, codigo, producto, nomEnvase
                FROM arm_kit k
                         LEFT JOIN distribucion d on k.codigo = d.idDistribucion
                         LEFT JOIN envases e on k.codKit = e.codKit
                WHERE k.idArmado=$idArmado AND d.idDistribucion IS NOT NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getArmKits()
    {
        $qry = "SELECT idArmado, nomKit FROM arm_kit ORDER BY nomKit;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getArmKitsEliminar()
    {
        $qry = "SELECT arm_kit.idArmado, nomKit
                FROM arm_kit
                LEFT JOIN ord_prod op on arm_kit.idArmado = op.idArmado
                WHERE op.idArmado IS NULL
                ORDER BY nomKit";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNomArmKit($idArmado)
    {
        $qry = "SELECT nomKit FROM arm_kit WHERE idArmado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idArmado));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nomArmKit'];
    }

    public function getArmKitById($idArmado)
    {
        $qry = "SELECT idArmado, arm_kit.idProv, nomProv, numFact, fechKit, fechVenc, estadoKit, descEstado
                FROM arm_kit
                         LEFT JOIN estados e on arm_kit.estadoKit = e.idEstado
                         LEFT JOIN proveedores p on arm_kit.idProv = p.idProv
                WHERE idArmado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idArmado));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getArmKitByProd($codProducto)
    {
        $qry = "SELECT idArmado, nomKit FROM arm_kit WHERE codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProducto));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateArmKit($datos)
    {
        $qry = "UPDATE arm_kit SET idProv=?, numFact=?, fechArmKit=?, fechVenc=? WHERE idArmado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

}
