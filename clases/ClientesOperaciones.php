<?php

class ClientesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeCliente($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO clientes (nitCliente, nomCliente, contactoCliente, cargoCliente, telCliente, celCliente, dirCliente, emailCliente, estadoCliente, idCatCliente, ciudadCliente, retIva, retIca, retFte, codVendedor, fchCreacionCliente, exenIva) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteCliente($idCliente)
    {
        $qry = "DELETE FROM clientes WHERE idCliente= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
    }

    public function getClientes($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idCliente, nomCliente FROM clientes WHERE estadoCliente=1 ORDER BY nomCliente;";
        } else {
            $qry = "SELECT idCliente, nomCliente FROM clientes ORDER BY nomCliente;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getClientesByTipo($tipoCompra)
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes WHERE idCatCliente = $tipoCompra ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllClientesGastos()
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes WHERE (idCatCliente = 5 OR idCatCliente = 6) ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getClientesByName($q)
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes WHERE nomCliente like '%" . $q . "%' ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getClienteesByNameAndTipoCompra($q, $tipoCompra)
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes WHERE idCatCliente=? AND nomCliente like '%" . $q . "%' ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getClienteesGastos($q)
    {
        $qry = "SELECT idCliente, nomCliente FROM clientes WHERE (idCatCliente=5 OR idCatCliente=6) AND nomCliente like '%" . $q . "%' ORDER BY nomCliente;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableClientes($activo)
    {
        $qry = "SELECT nitCliente,
                       nomCliente,
                       dirCliente,
                       desCatClien,
                       nomPersonal,
                       ultimaCompra,
                       contactoCliente,
                       cargoCliente,
                       telCliente,
                       ciudad,
                       celCliente,
                       emailCliente
                FROM clientes c
                         LEFT JOIN cat_clien cc ON c.idCatCliente = cc.idCatClien
                         LEFT JOIN personal p ON c.codVendedor = p.idPersonal
                         LEFT JOIN ciudades c1 ON c.ciudadCliente = c1.idCiudad
                         LEFT JOIN (SELECT max(fechaFactura) ultimaCompra, idCliente FROM factura GROUP BY idCliente) uc
                                   ON uc.idCliente = c.idCliente
                WHERE c.estadoCliente = ? AND ultimaCompra IS NOT NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($activo));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCliente($idCliente)
    {
        $qry = "SELECT idCliente,
                       nitCliente,
                       nomCliente,
                       contactoCliente,
                       cargoCliente,
                       telCliente,
                       celCliente,
                       dirCliente,
                       emailCliente,
                       estadoCliente,
                       c.idCatCliente,
                       cc.desCatClien,
                       ciudadCliente,
                       ciudad,
                       retIva,
                       retIca,
                       retFte,
                       codVendedor,
                       nomPersonal,
                       retCree,
                       fchCreacionCliente,
                       exenIva
                FROM clientes c
                LEFT JOIN ciudades c2 on c.ciudadCliente = c2.idCiudad
                LEFT JOIN personal p on p.idPersonal = c.codVendedor
                LEFT JOIN cat_clien cc on cc.idCatClien = c.idCatCliente
                WHERE idCliente=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkNit($nitCliente)
    {
        $qry = "SELECT idCliente, nitCliente  FROM clientes WHERE nitCliente= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($nitCliente));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCliente($datos)
    {
        $qry = "UPDATE clientes SET nitCliente=?, nomCliente=?, contactoCliente=?, cargoCliente=?, telCliente=?,
                celCliente=?,  dirCliente=?, emailCliente=?, estadoCliente=?, idCatCliente=?, ciudadCliente=?,  retIva=?,
                retIca=?, retFte=?, codVendedor=?, exenIva=? WHERE idCliente=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
