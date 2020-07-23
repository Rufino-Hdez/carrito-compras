<?php 
    //Incluir el modelo usuario para obtener los datos de los campos del formulario
    require_once 'models/usuario.php';

    class usuarioController{
        public function index(){
            echo "Controlador Usuarios, Acción index";
        }

        public function registro(){
            require_once 'views/usuario/registro.php';
        }

        public function save(){
            //Recoger los datos por url de registro
            /*Comprobar que exista el parametro POST */
            if (isset($_POST)) {
                /*Comprobar si los datos existen*/
                    //Si llega el nombre por post - se asigna ese valor de lo contrario es falso
                    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : false;
                    $email = isset($_POST['email']) ? $_POST['email'] : false;
                    $password = isset($_POST['password']) ? $_POST['password'] : false;

                    /*Comprobar si alguno de esos datos esta en false - vacio  si es true guardar*/
                    if ($nombre && $apellido && $email && $password) 
                    {

                        /*instanciar la clase usuario del modelo para acceder a sus propiedades y metodos */
                        $usuario = new Usuario();
                        //pasamos las variables del controller a los models
                        $usuario->setNombre($nombre);
                        $usuario->setApellido($apellido);
                        $usuario->setEmail($email);
                        $usuario->setPassword($password);
                   
                        /*Utilizar el metodo save del modelo dnd se guarda la info a la bd */
                        /*Guardar en una variable y comprobar si da true */
                        $save = $usuario->save();
                        if ($save) {
                            /*Crear sesion con nombre register con valor complete*/
                            $_SESSION['register'] = 'Complete';
                            //echo 'Registro completado con exito!!';
                        }else{
                            $_SESSION['register'] = 'Failed';
                            //echo 'Falló al guardar';
                        }
                    }else{
                        $_SESSION['register'] = 'Failed';
                    }
            }else{
                /*Si $_POST no llega nada mostrar */
                $_SESSION['register'] = 'Failed';
            }
            /*redirijir a registro este correcto o no */
            header("Location:".base_url.'usuario/registro');

        }

        public function login(){
            /*Comprobar si llegan datos por post*/
            if (isset($_POST)) 
                {
                    //Identificar al usuario
                    //Consultar la base de datos
                    /*Crear un objeto del modelo usuario */
                    $usuario = new Usuario();
                    //Acceder y dar valos a las variables por set
                    $usuario->setEmail($_POST['email']);
                    $usuario->setPassword($_POST['password']);
                    /*Hace la consulta y devuelve el objeto del usuario identificado*/
                    $identity = $usuario->login();

                    /**Condicion verificar si identiti es true y si es un objeto */
                    if($identity && is_object($identity))
                        {
                            //Creamos una sesion
                            $_SESSION['identity'] = $identity;
                            /*comprobar si es usuario admin */
                            if ($identity->rol == 'admin') {
                                /*Crear sesion admin y iniciarlo en true */
                                $_SESSION['admin'] = true;
                            }
                        }else{
                            //Si no coinciden datos de identificacion
                            /*Crea una sesion de error */
                            $_SESSION['error_login'] = 'Identificacion fallida !!';
                        }

                }
            header("Location:". base_url);
        }
        //CERRAR SESION
        public function logout(){
            /*Comprobar si existe la sesion identity*/
            if(isset($_SESSION['identity'])){
                /*Borrar sesion*/
                unset($_SESSION['identity']);
            }

            //Si la sesion es admin tambien se elimina la sesion
            /*Comprobar si existe la sesion identity*/
            if(isset($_SESSION['admin'])){
                /*Borrar sesion*/
                unset($_SESSION['admin']);
            }

            header("Location:".base_url);

        }

        public function borrarError(){
            //Limpiar login
        if (isset($_SESSION['error_login'])) {
            $_SESSION['error_login'] = null;
            unset($_SESSION['error_login']);
        }
        }
    } // fin de la clase
?>