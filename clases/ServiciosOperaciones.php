<?php


class ServiciosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeServicio($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO servicios (idServicio, desServicio, codIva, activo, codSiigo ) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteServicio($idServicio)
    {
        $qry = "DELETE FROM servicios WHERE idServicio= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idServicio));
    }

    public function getServicios($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idServicio, desServicio FROM servicios WHERE activo=0 ORDER BY desServicio;";
        } else {
            $qry = "SELECT idServicio, desServicio FROM servicios ORDER BY desServicio;";
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableServicios()
    {
        $qry = "SELECT idServicio, desServicio, CONCAT(format((tasaIva*100),1), ' %') iva,  CONCAT ('003000', codSiigo) coSiigo
        FROM servicios
        LEFT JOIN tasa_iva ti on servicios.codIva = ti.idTasaIva
        WHERE activo=0 
        ORDER BY desServicio";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getServicio($idServicio)
    {
        $qry = "SELECT idServicio, desServicio, activo, codSiigo, codIva, CONCAT(format((tasaIva*100),1), ' %') iva
        FROM  servicios
        LEFT JOIN tasa_iva ti on servicios.codIva = ti.idTasaIva
        WHERE idServicio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idServicio));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLastServicio()
    {
        $qry = "SELECT MAX(idServicio) as Cod from servicios";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Cod'];
    }


    public function updateServicio($datos)
    {
        $qry = "UPDATE servicios SET desServicio=?, codIva=?, activo=? WHERE idServicio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
