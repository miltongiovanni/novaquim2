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
        $qry = "INSERT INTO prodpre VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function validarPresentacion($codPresentacion)
	{
		$valida = 0;
        $qry="select * from prodpre where codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result['codPresentacion']>0){
            $valida=1;
        }
		return $valida;
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
            $qry = "SELECT codPresentacion, presentacion FROM prodpre WHERE presentacionActiva=0 ORDER BY presentacion;";
        } else {
            $qry = "SELECT codPresentacion, presentacion FROM prodpre  WHERE presentacionActiva=1 ORDER BY presentacion;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTablePresentaciones()
    {
        $qry = "SELECT codPresentacion, presentacion, desMedida, nomEnvase, tapa , codigoGen, CONCAT ('003000', codSiigo) coSiigo   
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
        $qry = "SELECT codPresentacion, presentacion, prodpre.codProducto, nomProducto, codMedida, desMedida, prodpre.codEnvase, nomEnvase, 
        prodpre.codTapa, tapa, codEtiq, nomEtiqueta, prodpre.codigoGen, producto, stockPresentacion, cotiza, presentacionActiva, codSiigo
        FROM prodpre, productos, medida, envases, tapas_val, etiquetas, precios
        WHERE prodpre.codProducto=productos.codProducto AND codMedida=idMedida AND prodpre.codEnvase=envases.codEnvase AND prodpre.codTapa=tapas_val.codTapa AND 
        codEtiq=codEtiqueta AND prodpre.codigoGen = precios.codigoGen  AND codPresentacion=?";
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
        $qry = "UPDATE prodpre SET presentacion=?, codEnvase=?, codTapa=?, codEtiq=?,  codigoGen=?, stockPresentacion=?, cotiza=? WHERE codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function activarDesactivarPresentacion($datos)
    {                                      
        $qry = "UPDATE prodpre SET presentacionActiva=? WHERE codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }


    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
