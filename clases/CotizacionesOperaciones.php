<?php

class CotizacionesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeCotizacion($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cotizaciones (idCliente, fechaCotizacion, precioCotizacion, presentaciones, distribucion, productos) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteCotizacion($idCotizacion)
    {
        $qry = "DELETE FROM cotizaciones WHERE idCotizacion= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCotizacion));
    }

    public function getCotizacions($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idCotizacion, nomCotizacion FROM cotizaciones WHERE estadoCotizacion=1 ORDER BY nomCotizacion;";
        } else {
            $qry = "SELECT idCotizacion, nomCotizacion FROM cotizaciones ORDER BY nomCotizacion;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionsByTipo($tipoCompra)
    {
        $qry = "SELECT idCotizacion, nomCotizacion FROM cotizaciones WHERE idCatCotizacion = $tipoCompra ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllCotizacionsGastos()
    {
        $qry = "SELECT idCotizacion, nomCotizacion FROM cotizaciones WHERE (idCatCotizacion = 5 OR idCatCotizacion = 6) ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionsByName($q)
    {
        $qry = "SELECT idCotizacion, nomCotizacion FROM cotizaciones WHERE nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getCotizacionesByNameAndTipoCompra($q, $tipoCompra)
    {
        $qry = "SELECT idCotizacion, nomCotizacion FROM cotizaciones WHERE idCatCotizacion=? AND nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionesGastos($q)
    {
        $qry = "SELECT idCotizacion, nomCotizacion FROM cotizaciones WHERE (idCatCotizacion=5 OR idCatCotizacion=6) AND nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableCotizaciones()
    {
        $qry = "SELECT idCotizacion,
                       nomCliente,
                       desCatClien,
                       nomPersonal,
                       fechaCotizacion,
                       IF(precioCotizacion=1,'Fábrica', IF(precioCotizacion=2,'Distribuidor',IF(precioCotizacion=3,'Detal', IF(precioCotizacion=4,'Mayorista', 'Super')) )) precioCotizacion,
                       IF(presentaciones=1,'Todas', IF(presentaciones=2,'Pequeñas','Grandes')) presentacionesCotizacion,
                       distribucion,
                       productos
                FROM cotizaciones c
                LEFT JOIN clientes_cotiz cc on cc.idCliente = c.idCliente
                LEFT JOIN cat_clien cc2 on cc2.idCatClien = cc.idCatCliente
                LEFT JOIN personal p on p.idPersonal = cc.codVendedor";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacion($idCotizacion)
    {
        $qry = "SELECT idCotizacion,
                       nitCotizacion,
                       nomCotizacion,
                       contactoCotizacion,
                       cargoCotizacion,
                       telCotizacion,
                       celCotizacion,
                       dirCotizacion,
                       emailCotizacion,
                       estadoCotizacion,
                       c.idCatCotizacion,
                       cc.desCatClien,
                       ciudadCotizacion,
                       ciudad,
                       retIva,
                       retIca,
                       retFte,
                       codVendedor,
                       nomPersonal,
                       retCree,
                       fchCreacionCotizacion,
                       exenIva
                FROM cotizaciones c
                LEFT JOIN ciudades c2 on c.ciudadCotizacion = c2.idCiudad
                LEFT JOIN personal p on p.idPersonal = c.codVendedor
                LEFT JOIN cat_clien cc on cc.idCatClien = c.idCatCotizacion
                WHERE idCotizacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCotizacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkNit($nitCotizacion)
    {
        $qry = "SELECT idCotizacion, nitCotizacion  FROM cotizaciones WHERE nitCotizacion= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($nitCotizacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCotizacion($datos)
    {
        $qry = "UPDATE cotizaciones SET nitCotizacion=?, nomCotizacion=?, contactoCotizacion=?, cargoCotizacion=?, telCotizacion=?,
                celCotizacion=?,  dirCotizacion=?, emailCotizacion=?, estadoCotizacion=?, idCatCotizacion=?, ciudadCotizacion=?,  retIva=?,
                retIca=?, retFte=?, codVendedor=?, exenIva=? WHERE idCotizacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
