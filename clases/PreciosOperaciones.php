<?php

class PreciosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makePrecio($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO precios VALUES(?, ?, ?, ?, ?, ?, ?, 0, 0)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    
    public function deletePrecio($codigoGen)
    {
        $qry = "DELETE FROM precios WHERE codigoGen= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codigoGen));
    }

    public function getPrecios($actif)
    {
        if ($actif == true) {
            $qry = "SELECT codigoGen, producto FROM precios WHERE presActiva=1 ORDER BY producto;";
        } else {
            $qry = "SELECT codigoGen, producto FROM precios ORDER BY producto;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTablePreciosHTML()
    {
        $qry = "SELECT codigoGen 'Código', producto 'Descripción', CONCAT('$', FORMAT(fabrica, 0)) 'Precio Fábrica', CONCAT('$', FORMAT(distribuidor, 0)) 'Precio Distribución', 
        CONCAT('$', FORMAT(detal, 0)) 'Precio Detal', CONCAT('$', FORMAT(mayor, 0)) 'Precio Mayorista', CONCAT('$', FORMAT(super, 0)) 'Precio Super'
        FROM precios
        WHERE presActiva=1";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTablePreciosHTMLSinIva()
    {
        $qry = "SELECT codigoGen 'Código', producto 'Descripción', CONCAT('$', FORMAT(fabrica/1.19, 0)) 'Precio Fábrica', CONCAT('$', FORMAT(distribuidor/1.19, 0)) 'Precio Distribución', 
        CONCAT('$', FORMAT(detal/1.19, 0)) 'Precio Detal', CONCAT('$', FORMAT(mayor/1.19, 0)) 'Precio Mayorista', CONCAT('$', FORMAT(super/1.19, 0)) 'Precio Super'
        FROM precios
        WHERE presActiva=1";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTablePrecios()
    {
        $qry = "SELECT codigoGen 'Código', producto 'Descripción', fabrica 'Precio Fábrica', distribuidor 'Precio Distribución', 
        detal 'Precio Detal', mayor 'Precio Mayorista', super 'Precio Super'
        FROM precios 
        WHERE presActiva=1";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }
    public function getTablePreciosSinIva()
    {
        $qry = "SELECT codigoGen 'Código', producto 'Descripción', ROUND(fabrica/1.19) 'Precio Fábrica', ROUND(distribuidor/1.19) 'Precio Distribución', 
        ROUND(detal/1.19) 'Precio Detal', ROUND(mayor/1.19) 'Precio Mayorista', ROUND(super/1.19) 'Precio Super'
        FROM precios 
        WHERE presActiva=1";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }
 public function getTablePreciosPDF()
    {
        $qry = "SELECT codigoGen 'Código', producto 'Descripción', fabrica 'Precio Fábrica', distribuidor 'Precio Distribución', 
        detal 'Precio Detal', mayor 'Precio Mayorista', super 'Precio Super'
        FROM precios 
        WHERE presActiva=1";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll(PDO::FETCH_NUM);
        return $result;
    }
    public function getPrecio($codigoGen)
    {
        $qry = "SELECT codigoGen, producto, fabrica, presActiva, presLista FROM precios
        WHERE codigoGen=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codigoGen));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function codigoGen($codProducto)
    {
        $qry = "SELECT codigoGen FROM prodpre WHERE codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProducto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['codigoGen'];
    }

    public function maxCodigoGen($idCodCat)
    {
        $qry = "SELECT MAX(codigoGen) cod FROM precios WHERE codigoGen LIKE ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array("$idCodCat%"));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cod'];
    }

    public function updatePrecio($datos)
    {                                      
        $qry = "UPDATE precios SET producto=?, fabrica=?, distribuidor=?, detal=?, mayor=?, super=?,  presActiva=?, presLista=? WHERE codigoGen=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateListaPrecio($datos)
    {
        $qry = "UPDATE precios SET fabrica=?, distribuidor=?, detal=?, super=?, mayor=? WHERE codigoGen=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
