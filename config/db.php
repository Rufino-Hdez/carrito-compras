<?php
    /*CREAR UNA CLASE ESTATICA*/
    class Database{

        public static function connect() {
            
            $db = new mysqli('localhost', 'root', 'toor', 'tienda_master');
            
            $db->query("SET NAMES 'utf8'");
            
            return $db;
        }
    }
?>
