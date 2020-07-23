<?php 
    require_once "models/producto.php";
    
    class productoController{
        public function index(){
            //Llamar al metodo que esta en el modelo para mostrar los productos
            $producto = new Producto;
            $productos = $producto->getRandom(6);
            //var_dump($productos->num_rows);
            //echo "Controlador producto, Acción index";
            //Renderizar vista
            require_once 'views/producto/destacados.php';
        }

        //DETALLE DE PRODUCTO
        public function ver(){
            // Comprobar si llega el id del producto
            if(isset($_GET['id'])){      
           
                $id = $_GET['id'];
                //Invocar clase del modelo
                $producto = new Producto();
                $producto->setId($id);
                //Obtener el producto seleccionado 
                $pro = $producto->getOne();
                }

            require_once 'views/producto/ver.php';
        }

        //Subir nuevos productos
        public function gestion(){
            //Comprobar si es administrador
            Utils::isAdmin();

            //crear objeto producto del modelo
            $producto = new Producto();
            //crear var y acceder al metodo dnd se realiza la consulta
            $productos = $producto->getAll();
            //cargar archivo que contiene vista y enviar variable productos
            require_once 'views/producto/gestion.php';
        }

        //Metodo crear productos
            public function crear(){
                //Comprobar si es administrador
                Utils::isAdmin();
                //Cargar la vista
                require_once 'views/producto/crear.php';
            }
        
            public function save(){
                Utils::isAdmin();
                //Comprobar si llega parametros por POST    
                if (isset($_POST)) 
                {
                    //Crer 1 variable por cada dato que se va a gusrdar
                    //comprobar con ternaria si llega el dato por post
                    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                    $descripcion  = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
                    $precio  = isset($_POST['precio']) ? $_POST['precio'] : false;
                    $stock  = isset($_POST['stock']) ? $_POST['stock'] : false;
                    $categoria  = isset($_POST['categoria']) ? $_POST['categoria'] : false;
                   // $imagen  = isset($_POST['imagen']) ? $_POST['imagen'] : false;

                   //Comprobar que los datos hayan llegado bien (true)y no esten vacios
                   if ($nombre && $descripcion && $precio && $stock && $categoria) {
                        //Crear objeto apartir del modelo
                        $producto = new Producto();
                        //Dar valor al objeto que se va a guardar en la base de datos
                        $producto->setNombre($nombre);
                        $producto->setDescripcion($descripcion);
                        $producto->setPrecio($precio);
                        $producto->setStock($stock);
                        $producto->setCategoria_id($categoria);

                        // COMPROBAR SI LLEGA LA IMAGEN
                        if (isset($_FILES['imagen'])) 
                        {
                            # code...
                            
                            // Guardar la imagen
                            //Crear variable file
                            $file = $_FILES['imagen'];
                            $filename = $file['name'];
                            $mimetype = $file['type'];

                            //Comprobar la extencion de la imagen sea del tipo 
                            if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {
                                    //Si no existe el directorio
                                    if (!is_dir('uploads/images')) {
                                        # crear directorio
                                        mkdir('uploads/images', 0777, true);
                                    }
                                    //Mover archivo
                                    $producto->setImagen($filename);
                                    move_uploaded_file($file['tmp_name'], 'uploads/images/'. $filename);
                            }
                        }

        /* CREAR CONDICION PARA REUTILIZAR CODIGO GUARDAR Y ACTUALIZAR */
                        //Si llega un id por la url entonces
                        if (isset($_GET['id'])) {
                            //id que llega por la url
                            $id = $_GET['id'];
                            //pasarle el ide al metodo edit 
                            $producto->setId($id);
                            //Se hace una llamada al metodo edit del modelo
                            $save = $producto->edit();   
                            
                        }else{
                         //Guardar el objeto
                            //Hace la llamada al metodo de guardar
                            $save = $producto->save();
                        }
                        

                        //Comprbar si se ah guardado correctamente
                        if ($save) {
                                $_SESSION['producto'] = 'Complete';
                        }else{
                            $_SESSION['producto'] = 'Failed';
                        }
                   }else{
                        $_SESSION['producto'] = 'Failed';
                        }
                }else{
                    $_SESSION['producto'] = 'Failed';
                }
                header("Location:". base_url.'producto/gestion');
            }

        public function editar(){
            /* Mostrar que se envie correctamente
                var_dump($_GET);*/ 

                Utils::isAdmin();

            // Comprobar si llega el id del producto
            if(isset($_GET['id'])){      
           
            $id = $_GET['id'];
            //Crear var edit con valor true y pasarselo a la vista de crear
            $edit = true;

            //Invocar clase del modelo
            $producto = new Producto();
            $producto->setId($id);
            //Obtener el producto seleccionado 
            $pro = $producto->getOne();
            /*Reutilizar vista de crear para la edicion */
            require_once 'views/producto/crear.php';
            }else{
                header("Location:".base_url.'producto/gestion');
            }


        }

        public function eliminar(){
            /* Mostrar que se envie correctamente
                var_dump($_GET);*/
            //solo puede eliminar los admin- para ello comprobar si el que esta logueado es admin
            Utils::isAdmin();

            // Comprobar si llega el id del producto
            if(isset($_GET['id'])){
                //Llamar a metodo del modelo 
                $id = $_GET['id'];
                //Instanciar el objeto
                $producto = new Producto();
                //Pasarle el id que llega por get
                $producto->setId($id);
                //Eliminar
                $delete = $producto->delete();
                //Comprobar que todo vaya bien y crear sesion
                if ($delete) {
                        $_SESSION['delete'] = 'Complete';
                }else{
                        $_SESSION['delete'] = 'Failed';
                }
            }else{
                //Si no llega el parametro por get
                $_SESSION['delete'] = 'failed';
            }

            header("Location:".base_url.'producto/gestion');
        }
    }
?>