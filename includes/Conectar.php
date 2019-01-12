<?php

/*
MySqli
class Conectar{
    //Creamos un método estático que no necesita ser instanciado
    public static function conexion(){
     
    //new mysqli creamos o instanciamos el objeto mysqli
    //new mysqli('servidor','usuario','contraseña','nombre de la BD');
        $conexion=new mysqli("localhost", "root", "novaquim", "novaquim2");
             
       if ($conexion->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
       //llamamos a la conexión y hacemos una consulta para utilizar UTF-8
        //$conexion->query("SET NAMES 'utf8'"); 
        $conexion->set_charset("utf8");
 
       //devolvemos la conexión para que pueda ser utilizada en otros métodos
        return $conexion; 
    }
} */

//PDO 
class Conectar{
    //Creamos un método estático que no necesita ser instanciado
    public static function conexion(){
     //Parámetros de la conexion tipo base de datos: dbname=nombreBaseDeDatos; host=ipServidorBD; charset=utf8; para no tener problemas con acentos
        $dsn = 'mysql:dbname=novaquim2;host=localhost;charset=utf8';
        $user = 'root'; //usuario
        $password = 'novaquim';//contraseña
        
        try {
            $conexion = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Conexión incorrecta a la Base de Datos : ' . $e->getMessage();
        }
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        return $conexion;
    }
}
/*
Como utilizarla en los Manager
public function __construct(){
       $this->productos=array(); //Le decimos que sea un array 
       $this->db=Conectar::conexion(); //Almacenamos en db la llamada la clase estática Conectar
    }*/
?>
