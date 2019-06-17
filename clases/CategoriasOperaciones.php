<?php

class EstadosPersonasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeEstadoPersona($descripcion)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO estados_pers VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($descripcion));
        return $this->_pdo->lastInsertId();
    }
    public function deleteEstadoPersona($idEstado)
    {
        $qry = "DELETE FROM estados_pers WHERE idEstado= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEstado));
    }
    public function getEstadosPersonas()
    {
        $qry = "SELECT idEstado, estadoPersona FROM estados_pers order by idEstado";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEstadoPersona($idEstado)
    {
        $qry = "SELECT idEstado, descripcion perfil from estados_pers where idEstado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEstado));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateEstadoPersona($datos)
    {
        $qry = "UPDATE estados_pers SET descripcion=? WHERE idEstado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
