<?php
    //MODELO ENTIDAD - USUARIO:
        /* Entidad: Es una clase que representa a un registro de la base de datos */
    class Usuario{
/*PROPIEDADES DE CLASE*/
        private $id;
        private $nombre;
        private $apellido;
        private $email;
        private $password;
        private $rol;
        private $imagen;
        /*Crear propiedad de base de datos */
        private $db;

/*CONSTRUCTOR */
        public function __construct()
        {
            $this->db = Database::connect();
        }

/*METODOS DE LAS PROPIEDADES */
        //GENERAR FUNCION GET (OBTENER VALOR)
       public function getId(){
            return $this->id;
        }

        public function getNombre(){
            
            return $this->nombre;
        }

        public function getApellido(){
            return $this->apellido;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getPassword(){
            return password_hash( $this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
        }

        public function getRol(){
            return $this->rol;
        }

        public function getImage(){
            return $this->imagen;
        }


        //GENERAR FUNCIONES SET (ASIGNAR VALOR)
        public function setId($id){
            $this->id = $id;
        }
    //mejora en setter agregar lo sig. para mayor seguridad al enviar la informacion
        /*real_scape_string - Escapa caracteres especiales en la cadena que se ingresa en formulario antes de enviar
                             Datos susceptibles a introducir caracter raro seran limpiados y escapados con este metodo */
        public function setNombre($nombre){
            $this->nombre = $this->db->real_escape_string($nombre);
        }

        public function setApellido($apellido){
            $this->apellido = $this->db->real_escape_string($apellido);
        }

        public function setEmail($email){
            $this->email = $this->db->real_escape_string($email);
        }

        public function setPassword($password){
            $this->password = $password;
        }

        public function setRol($rol){
            $this->rol = $rol;
        }

        public function setImagen($imagen){
            $this->imagen = $imagen;
        }

/* METODOS OTROS*/

        public function save(){
            
            $sql = "INSERT INTO usuarios VALUES (NULL, '{$this->getNombre()}', '{$this->getApellido()}','{$this->getEmail()}','{$this->getPassword()}','user',null);";
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

        public function login(){
            // var para retornar y ejecutar un resultado o no
            $result = false;
            //Obtener los datos de email y pass  
            $email = $this->email;
            $password = $this->password;
            //Comprobar si existe el usuario
            $sql ="SELECT * FROM usuarios WHERE email = '$email'";
            //Realizar la consulta
            $login = $this->db->query($sql);

            //Comprobar si login da true (existe el email) y login tiene contenido en la fila
            if ($login && $login->num_rows== 1) {
                    /*Sacar el onjeto que devuelve la base de datos */
                    $usuario = $login->fetch_object();
                    //Verificar contraseña B_CRIPT
                    //cerificar si la pass que se ingresa es = a la que esta en la BD
                    $verify = password_verify($password, $usuario->password);

                    //Comprobar si pass son iguales
                    if ($verify) {
                        //Devolver los datos del usuario 
                        $result = $usuario;
                    }
            }
                // ejecuta 
            return $result;
        }
    }
?>