<?php 
//Cargar el modelo para acceder a sus metodos y crear objetos 
require_once 'models/categoria.php';
// cargar modelo de producto para cargar lso productos en cada categoria
require_once 'models/producto.php';

    class categoriaController{
        public function index(){
            //Acceder metodo isAdmin
            Utils::isAdmin(); 
            /*2- Crear un objeto del modelo cate  */
            $categoria= new Categoria();
            //crear var y dar el valor [Nota: Categorias ya esta disponible en index.php xq esta se declara antes de incluir la vista index.php]
            $categorias = $categoria->getAll();
            /*1- Cargar una vista */
            require_once 'views/categorias/index.php';
        }

        /** VER PRODUCTOS POR CATEGORIAS**/
        public function ver(){
            // comprobar Si existe $_GET[id] por la url
            if(isset($_GET['id'])){
                // Asignarle a una variable el id 
                $id = $_GET['id'];

            //CONSEGUIR CATEGORIAS
                // Crear objeto para acceder modelo categoria
                $categoria = new Categoria();
                // Pasarle como parametro el id
                $categoria->setId($id);
                // Asignar a una variable el resultado del metodo | Acceder al metodo
                $categoria = $categoria->getOne();
                // el resultado de la variable categoria se le pasa a la vista para mostrar el resultado

            // CONSEGUIR PRODUCTOS
                $producto = new Producto();
                $producto->setCategoria_id($id);
                $productos = $producto->getAllCategory(); 
            }
            // Incluir vista
            require_once 'views/categorias/ver.php';
        }
        /*** CREAR CATEGORIAS ***/
        public function crear(){
            //Acceder a metodo isAdmin
            Utils::isAdmin();
            //Incluir vista para crear categorias
            require_once 'views/categorias/crear.php';
        }

        public function save(){
            //Comprobar si el usuario a crear categoria es ADMINISTRADOR
            Utils::isAdmin();
            //Comprobar si llegan datos por POST y si llega el nombre
            if (isset($_POST) && isset($_POST['nombre'])) {
            //Crear categoria
                /*Crear objeto categoria del modelo*/
                $categoria = new Categoria();
                $categoria->setNombre($_POST['nombre']);
                $save = $categoria->save();
            }
            header("Location:".base_url."categoria/index");
        }
    }
?>
