<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/config.php';

class Conectar{
    //Creamos un método estático que no necesita ser instanciado
    public static function conexion(){
     //Parámetros de la conexion tipo base de datos: dbname=nombreBaseDeDatos; host=ipServidorBD; charset=utf8; para no tener problemas con acentos
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_SERVER . ';charset=utf8';
        $user = DB_USER;
        $password = DB_PASS;
        $conexion = null;
        
        try {
            $conexion = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Conexión incorrecta a la Base de Datos : ' . $e->getMessage();
        }
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        return $conexion;
    }
    public static function closeConnection()
    {
        unset($conexion);
    }
}

