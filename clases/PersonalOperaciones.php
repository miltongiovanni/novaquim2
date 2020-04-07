<?php

class PersonalOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makePersonal($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO personal VALUES(0, ?, ?, ?, ?, ?, ?,0,0)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deletePersonal($idPersonal)
    {
        $qry = "DELETE FROM personal WHERE idPersonal= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPersonal));
    }

    public function getPersonal($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idPersonal, nomPersonal, celPersonal, emlPersonal, areas_personal.area, cargo, activoPersonal, areaPersonal, cargoPersonal, areaPersonal  
            from personal, areas_personal, cargos_personal
            wHERE areaPersonal=idArea and activoPersonal=1 AND cargoPersonal=idCargo order by idPersonal";
        } else {
            $qry = "SELECT idPersonal, nomPersonal, celPersonal, emlPersonal, areas_personal.area, cargo, activoPersonal, areaPersonal, cargoPersonal, areaPersonal  
            from personal, areas_personal, cargos_personal
            wHERE areaPersonal=idArea AND cargoPersonal=idCargo order by idPersonal";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTablePersonal()
    {
        $qry = "SELECT idPersonal, nomPersonal, celPersonal, emlPersonal, area, cargo 
        from personal, areas_personal, cargos_personal
        wHERE areaPersonal=idArea and activoPersonal=1 AND cargoPersonal=idCargo order by idPersonal";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPerson($idPersonal)
    {
        $qry = "SELECT idPersonal, nomPersonal, celPersonal, emlPersonal, areas_personal.area, cargo, activoPersonal, areaPersonal, cargoPersonal, estadoPersona 
        from personal, areas_personal, estados_pers, cargos_personal
        wHERE areaPersonal=idArea AND cargoPersonal=idCargo AND idEstado=activoPersonal AND idPersonal=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPersonal));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updatePersonal($datos)
    {
        $qry = "UPDATE personal SET nomPersonal=?, activoPersonal=?, areaPersonal=?, celPersonal=?, emlPersonal=?, cargoPersonal=? WHERE idPersonal=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
