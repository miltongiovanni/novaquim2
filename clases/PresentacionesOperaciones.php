<?php

class PresentacionesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makePresentacion($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO prodpre VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, 365)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    
    public function deletePresentacion($codPresentacion)
    {
        $qry = "DELETE FROM prodpre WHERE codPresentacion= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
    }

    public function getPresentaciones($actif)
    {
        if ($actif == true) {
            $qry = "SELECT codPresentacion, nomPresentacion FROM prodpre WHERE prodActivo=0 ORDER BY nomPresentacion;";
        } else {
            $qry = "SELECT codPresentacion, nomPresentacion FROM prodpre ORDER BY nomPresentacion;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTablePresentaciones()
    {
        $qry = "SELECT codPresentacion AS 'Código', presentacion as 'Presentación',
        desMedida as 'Medida', nomEnvase as 'Envase', tapa as 'Tapa', codigoGen as 'Código Anterior'  
        FROM prodpre, medida, envases, tapas_val, productos
        where medida.IdMedida=prodpre.codMedida and productos.codProducto=prodpre.codProducto
        and prodpre.codEnvase=envases.codEnvase and prodpre.codTapa=tapas_val.codTapa and prodActivo=0 and presentacionActiva=0
        ORDER BY nomProducto, desMedida;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getPresentacion($codPresentacion)
    {
        $qry = "SELECT codPresentacion, nomPresentacion, catProd, prodpre.idCatProd, prodActivo, densMin, densMax, pHmin, pHmax, fragancia, color, apariencia
        FROM  prodpre, cat_prod
        WHERE prodpre.idCatProd=cat_prod.idCatProd AND codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimoProdxCat($idCatProd)
    {
        $qry = "SELECT MAX(codPresentacion) as Cod from prodpre where idCatProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Cod'];
    }


    public function updatePresentacion($datos)
    {                                      
        $qry = "UPDATE prodpre SET nomPresentacion=?, idCatProd=?, prodActivo=?, densMin=?, densMax=?, pHmin=?,  pHmax=?, fragancia=?, color=?, apariencia=? WHERE codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
