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
        $qry = "INSERT INTO cotizaciones (idCliente, fechaCotizacion, precioCotizacion, presentaciones, distribucion, productos, destino) VALUES(?, ?, ?, ?, ?, ?, ?)";
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

    public function getProductosCotizacion($precio, $presentaciones, $productos_c, $iva)
    {
        if ($precio == 1) {
            $lista = 'fabrica';
        }
        if ($precio == 2) {
            $lista = 'distribuidor';
        }
        if ($precio == 3) {
            $lista = 'detal';
        }
        if ($precio == 4) {
            $lista = 'mayor';
        }
        if ($precio == 5) {
            $lista = 'super';
        }
        //SELECCIONA EL TIPO DE PRESENTACIONES 1 PARA TODAS, 2 PARA PEQUEÑAS Y 3 PARA GRANDES
        if ($presentaciones == 1)
            $wh = " AND cantMedida<=20000";
        if ($presentaciones == 2)
            $wh = " AND cantMedida<4000";
        if ($presentaciones == 3)
            $wh = " AND cantMedida>3500";
        $seleccion_p = explode(",", $productos_c);
        $b = count($seleccion_p);
        $qryp = " AND (";
        for ($k = 0; $k < $b; $k++) {
            $qryp = $qryp . " p2.idCatProd=" . ($seleccion_p[$k]);
            if ($k <= ($b - 2))
                $qryp = $qryp . " OR ";
        }
        $qryp = $qryp . ")";
        $qry = "SELECT DISTINCT pr.codigoGen,
                                producto,";
               $qry .= $iva == 1 ? " FORMAT($lista, 0) " : " FORMAT($lista/1.19, 0) "." ".$lista;
        $qry .=" FROM precios pr
                         LEFT JOIN prodpre p on pr.codigoGen = p.codigoGen
                         LEFT JOIN medida m on p.codMedida = m.idMedida
                         LEFT JOIN productos p2 on p.codProducto = p2.codProducto
                         LEFT JOIN cat_prod cp on p2.idCatProd = cp.idCatProd
                WHERE presActiva = 1
                  AND presLista = 1
                  $wh
                  $qryp
                  ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_NUM);
        return $result;
    }

    public function getProductosDistCotizacion($distribucion)
    {
        $qryd = '';
        if ($distribucion != NULL) {
            $seleccion = explode(",", $distribucion);
            $qryd = " AND ( ";
            $a = count($seleccion);
            for ($j = 0; $j < $a; $j++) {
                $qryd = $qryd . "(idDistribucion > " . ($seleccion[$j] * 100000) . " and idDistribucion < " . (($seleccion[$j] + 1) * 100000) . ")";
                if ($j <= ($a - 2))
                    $qryd = $qryd . " or ";
            }
            $qryd = $qryd . ")";
        }
        $qry = "SELECT idDistribucion, producto, precioVta, ROUND(precioVta/(1+tasaIva)) precioVtaSinIva
                FROM distribucion d 
                LEFT JOIN tasa_iva t ON t.idTasaIva=d.codIva
                WHERE cotiza=1 AND activo=1
                $qryd
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_NUM);
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
        $qry = "SELECT idCotizacion, c.idCliente, nomCliente, fechaCotizacion, precioCotizacion, presentaciones, distribucion, productos, destino
                FROM cotizaciones c
                LEFT JOIN clientes_cotiz cc on cc.idCliente = c.idCliente
                WHERE idCotizacion =?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCotizacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionForPrint($idCotizacion)
    {
        $qry = "SELECT idCotizacion,
                       c.idCliente,
                       nomCliente,
                       dirCliente,
                       contactoCliente,
                       cc.cargoContacto,
                       fechaCotizacion,
                       precioCotizacion,
                       presentaciones,
                       distribucion,
                       productos,
                       destino,
                       c2.ciudad,
                       nomPersonal,
                       celPersonal,
                       emlPersonal,
                       cargo,
                       cc2.desCatClien
                FROM cotizaciones c
                         LEFT JOIN clientes_cotiz cc on cc.idCliente = c.idCliente
                         LEFT JOIN ciudades c2 on c2.idCiudad = cc.idCiudad
                         LEFT JOIN personal p on p.idPersonal = cc.codVendedor
                         LEFT JOIN cargos_personal cp ON p.cargoPersonal = cp.idCargo
                         LEFT JOIN cat_clien cc2 on cc2.idCatClien = cc.idCatCliente
                WHERE idCotizacion =?";
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
        $qry = "UPDATE cotizaciones SET idCliente=?, fechaCotizacion=?, precioCotizacion=?, 
                        presentaciones=?, distribucion=?,productos=?, destino=?
                 WHERE idCotizacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
