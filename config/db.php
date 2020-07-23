<?php
    /*CREAR UNA CLASE ESTATICA*/
    class Database{

        public static function connect() {
            // Crear variable y pasar parametros del servidor
            $db = new mysqli('localhost', 'root', 'toor', 'tienda_master');
            //Crear consulta para ver los resultado en castellano
            $db->query("SET NAMES 'utf8'");
            //Retornar la conexion
            return $db;
        }
    }
?>