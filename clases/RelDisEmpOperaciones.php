<?php

class RelDisEmpOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeRelDisEmp($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO rel_dist_emp (codPaca, codUnidad, cantidad) VALUES(?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteRelDisEmp($idPacUn)
    {
        $qry = "DELETE FROM rel_dist_emp WHERE idPacUn= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPacUn));
    }

    public function checkPaca($codPaca)
    {
        $qry = "SELECT idPacUn, codPaca  FROM rel_dist_emp WHERE codPaca= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPaca));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRelsDisEmp()
    {
        $qry = "SELECT idPacUn, producto FROM rel_dist_emp
        LEFT JOIN distribucion d on rel_dist_emp.codPaca = d.idDistribucion ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUnidadByPaca($codPaca)
    {
        $qry = "SELECT codUnidad, cantidad FROM rel_dist_emp WHERE codPaca = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPaca));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPacaByUnidad($codUnidad)
    {
        $qry = "SELECT codPaca, cantidad FROM rel_dist_emp WHERE codUnidad = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codUnidad));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getTableRelsDisEmp()
    {
        $qry = "SELECT idPacUn, codPaca, d.producto paca, codUnidad, d2.producto unidad, cantidad FROM rel_dist_emp
                LEFT JOIN distribucion d on rel_dist_emp.codPaca = d.idDistribucion
                LEFT JOIN distribucion d2 on rel_dist_emp.codUnidad= d2.idDistribucion
                ORDER BY d.producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRelDisEmp($idPacUn)
    {
        $qry = "SELECT idPacUn, codPaca, d.producto paca, codUnidad, d2.producto unidad, cantidad FROM rel_dist_emp
                LEFT JOIN distribucion d on rel_dist_emp.codPaca = d.idDistribucion
                LEFT JOIN distribucion d2 on rel_dist_emp.codUnidad= d2.idDistribucion
                WHERE idPacUn=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPacUn));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function updateRelDisEmp($datos)
    {
        $qry = "UPDATE rel_dist_emp SET codPaca=?, codUnidad=?, cantidad=? WHERE idPacUn=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
