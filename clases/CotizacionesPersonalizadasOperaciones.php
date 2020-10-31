<?php

class CotizacionesPersonalizadasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeCotizacionP($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cot_personalizada (idCliente, fechaCotizacion, tipPrecio, destino) VALUES(?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteCotizacion($idCotPersonalizada)
    {
        $qry = "DELETE FROM cot_personalizada WHERE idCotPersonalizada= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCotPersonalizada));
    }

    public function getCotizacions($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idCotPersonalizada, nomCotizacion FROM cot_personalizada WHERE estadoCotizacion=1 ORDER BY nomCotizacion;";
        } else {
            $qry = "SELECT idCotPersonalizada, nomCotizacion FROM cot_personalizada ORDER BY nomCotizacion;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionsByTipo($tipoCompra)
    {
        $qry = "SELECT idCotPersonalizada, nomCotizacion FROM cot_personalizada WHERE idCatCotizacion = $tipoCompra ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllCotizacionsGastos()
    {
        $qry = "SELECT idCotPersonalizada, nomCotizacion FROM cot_personalizada WHERE (idCatCotizacion = 5 OR idCatCotizacion = 6) ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionsByName($q)
    {
        $qry = "SELECT idCotPersonalizada, nomCotizacion FROM cot_personalizada WHERE nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductosCotizacion($precio, $presentaciones, $productos_c)
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
                                producto,
                                FORMAT($lista, 0)      $lista
                FROM precios pr
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
        $qry = "SELECT idDistribucion, producto, precioVta
                FROM distribucion
                WHERE cotiza=1 AND activo=1
                $qryd
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_NUM);
        return $result;
    }

    public function getProdTerminadosByIdCotizacion($idCotPersonalizada)
    {
        $qry = "SELECT t.codPresentacion, t.presentacion
                FROM (SELECT DISTINCT ip.codPresentacion, p.presentacion
                      FROM inv_prod ip
                               LEFT JOIN prodpre p on ip.codPresentacion = p.codPresentacion
                      WHERE invProd > 0) t
                         LEFT JOIN (SELECT codProducto FROM det_cot_personalizada WHERE idCotPersonalizada = ?) dr1
                                   ON dr1.codProducto = t.codPresentacion
                WHERE dr1.codProducto IS NULL
                ORDER BY t.presentacion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCotPersonalizada));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getProdDistribucionByIdCotizacion($idCotPersonalizada)
    {
        $qry = "SELECT codDistribucion, producto
                FROM (SELECT codDistribucion, producto
                      FROM inv_distribucion id
                               LEFT JOIN distribucion d on id.codDistribucion = d.idDistribucion
                      WHERE invDistribucion > 0) t
                         LEFT JOIN (SELECT codProducto FROM det_cot_personalizada WHERE idCotPersonalizada = ?) dr1
                                   ON dr1.codProducto = t.codDistribucion
                WHERE dr1.codProducto IS NULL
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCotPersonalizada));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionesGastos($q)
    {
        $qry = "SELECT idCotPersonalizada, nomCotizacion FROM cot_personalizada WHERE (idCatCotizacion=5 OR idCatCotizacion=6) AND nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableCotizacionesP()
    {
        $qry = "SELECT idCotPersonalizada, nomCliente, desCatClien, nomPersonal, fechaCotizacion, 
                IF(tipPrecio=1,'Fábrica', IF(tipPrecio=2,'Distribuidor',IF(tipPrecio=3,'Detal', IF(tipPrecio=4,'Mayorista', 'Super')) )) tipPrecio, destino
                FROM cot_personalizada
                         LEFT JOIN clientes_cotiz cc on cc.idCliente = cot_personalizada.idCliente
                         LEFT JOIN personal p on p.idPersonal = cc.codVendedor
                         LEFT JOIN cat_clien c on c.idCatClien = cc.idCatCliente";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionP($idCotPersonalizada)
    {
        $qry = "SELECT idCotPersonalizada,
               c.idCliente,
               nomCliente,
               contactoCliente,
               cargoContacto,
               fechaCotizacion,
               nomPersonal,
               tipPrecio tipoPrecio,
               IF(tipPrecio = 1, 'Fábrica', IF(tipPrecio = 2, 'Distribuidor',
                                               IF(tipPrecio = 3, 'Detal', IF(tipPrecio = 4, 'Mayorista', 'Super')))) tipPrecio,
               destino
        FROM cot_personalizada c
                 LEFT JOIN clientes_cotiz cc on cc.idCliente = c.idCliente
                 LEFT JOIN personal p on p.idPersonal = cc.codVendedor
        WHERE idCotPersonalizada =$idCotPersonalizada";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionPForPrint($idCotPersonalizada)
    {
        $qry = "SELECT idCotPersonalizada,
                       c.idCliente,
                       nomCliente,
                       contactoCliente,
                       cargoContacto,
                       fechaCotizacion,
                       nomPersonal,
                       tipPrecio tipoPrecio,
                       IF(tipPrecio = 1, 'Fábrica', IF(tipPrecio = 2, 'Distribuidor',
                                                       IF(tipPrecio = 3, 'Detal', IF(tipPrecio = 4, 'Mayorista', 'Super')))) tipPrecio,
                       destino,
                       c2.ciudad,
                       nomPersonal,
                       celPersonal,
                       emlPersonal,
                       cargo,
                       cc2.desCatClien
                FROM cot_personalizada c
                         LEFT JOIN clientes_cotiz cc on cc.idCliente = c.idCliente
                         LEFT JOIN personal p on p.idPersonal = cc.codVendedor
                         LEFT JOIN ciudades c2 on c2.idCiudad = cc.idCiudad
                         LEFT JOIN cargos_personal cp ON p.cargoPersonal = cp.idCargo
                         LEFT JOIN cat_clien cc2 on cc2.idCatClien = cc.idCatCliente
                WHERE idCotPersonalizada =?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCotPersonalizada));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCotizacionP($datos)
    {
        $qry = "UPDATE cot_personalizada SET idCliente=?, fechaCotizacion=?, tipPrecio=?, destino=?
                 WHERE idCotPersonalizada=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
