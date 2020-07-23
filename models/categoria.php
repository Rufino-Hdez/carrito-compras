<?php
class Categoria{
/*Crear propiedades privadas P/ que no se puedan acceder desde fuera solo mediante un metodo */
/*PROPIEDADES DE CLASE*/
        private $id;
        private $nombre;
        /*Crear propiedad de base de datos */
        private $db;

/*CONSTRUCTOR */
        public function __construct()
        {
            $this->db = Database::connect();
        }
/*** CONSTRUIR METODOS GETTER Y SETTER***/
        public function getId(){
            return $this->id;
        }
        public function getNombre(){
            return $this->nombre;
        }

        public function setId($id){
            $this->id = $id;
        }
        public function setNombre($nombre){
            //Escapar datos al ingresar caracteres raros(tildes,signos) por seguridad para evitar inyeccion sql
            $this->nombre = $this->db->real_escape_string($nombre);
        }

/*-- METODO DE CONSULTA A LA BD PARA OBTENER LA INFO--*/
//Este metodo sera utilizado dentro del controlador de categorias
        public function getAll(){
            $categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC");
            return $categorias;
        }
/*** OBTENER CATEGORIA DE LA BASE DE DATOS***/
        public function getOne(){
        $categoria = $this->db->query("SELECT * FROM categorias WHERE id = {$this->getId()}");
            // retornar la consulta y muestra el objeto de la consulat 
        return $categoria->fetch_object();
        }
/*-- METODO GUARDAR CATEGORIAS --*/
        public function save(){
            $sql = "INSERT INTO categorias VALUES (NULL, '{$this->getNombre()}');";
            /*Asignar a variable la conexion a la base de datos y ejecutar la query*/
            $save = $this->db->query($sql);
            
            /*Crear vaiable con valor false por default */
            $result = false;

            //Comprobar si save da true
            if ($save) {
                    /*Si da true el valor de result cambia a true para retornar este valor*/
                    $result = true;
            }
            /**Devolver el valor de result */
            return $result;
        }
        

}

?>