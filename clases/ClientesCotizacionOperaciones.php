<?php

class ClientesCotizacionOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeCliente($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO clientes_cotiz (nomCliente, contactoCliente, cargoContacto, telCliente, celCliente, dirCliente, emailCliente, idCatCliente, idCiudad, codVendedor) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteCliente($idCliente)
    {
        $qry = "DELETE FROM clientes_cotiz WHERE idCliente= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
    }

    public function getClientes()
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes_cotiz ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getClientesByTipo($tipoCompra)
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes_cotiz WHERE idCatCliente = $tipoCompra ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllClientesGastos()
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes_cotiz WHERE (idCatCliente = 5 OR idCatCliente = 6) ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getClientesByName($q)
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes_cotiz WHERE nomCliente like '%" . $q . "%' ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getClienteesByNameAndTipoCompra($q, $tipoCompra)
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes_cotiz WHERE idCatCliente=? AND nomCliente like '%" . $q . "%' ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getClienteesGastos($q)
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes_cotiz WHERE (idCatCliente=5 OR idCatCliente=6) AND nomCliente like '%" . $q . "%' ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableClientes()
    {
        $qry = "SELECT c.idCliente,
                       nomCliente,
                       contactoCliente,
                       cargoContacto,
                       telCliente,
                       dirCliente,
                       emailCliente,
                       celCliente,
                       desCatClien,
                       nomPersonal,
                       ciudad
                FROM clientes_cotiz c
                         LEFT JOIN cat_clien cc ON c.idCatCliente = cc.idCatClien
                         LEFT JOIN personal p ON c.codVendedor = p.idPersonal
                         LEFT JOIN ciudades c1 ON c.idCiudad = c1.idCiudad";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCliente($idCliente)
    {
        $qry = "SELECT c.idCliente,
                       nomCliente,
                       contactoCliente,
                       cargoContacto,
                       telCliente,
                       dirCliente,
                       emailCliente,
                       celCliente,
                       idCatCliente,
                       desCatClien,
                       codVendedor,
                       nomPersonal,
                       c.idCiudad,
                       ciudad
                FROM clientes_cotiz c
                         LEFT JOIN cat_clien cc ON c.idCatCliente = cc.idCatClien
                         LEFT JOIN personal p ON c.codVendedor = p.idPersonal
                         LEFT JOIN ciudades c1 ON c.idCiudad = c1.idCiudad
                WHERE idCliente=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkNit($nitCliente)
    {
        $qry = "SELECT idCliente, nitCliente  FROM clientes_cotiz WHERE nitCliente= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($nitCliente));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCliente($datos)
    {
        $qry = "UPDATE clientes_cotiz SET nomCliente=?, contactoCliente=?, cargoContacto=?, telCliente=?,
                celCliente=?,  dirCliente=?, emailCliente=?, idCatCliente=?, idCiudad=?, codVendedor=? WHERE idCliente=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
