<?php 
    require_once 'models/producto.php';

    class carritoController{

        public function index(){
        
            if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1){
                $carrito = $_SESSION['carrito'];
            }else{
                $carrito = array();
            }
            //Pasarle carrito
            require_once 'views/carrito/index.php';
        }

        public function add(){
            
            if (isset($_GET['id'])) {
                $producto_id = $_GET['id'];
            }else{
                
                header('Location:'.base_url);
            }

                // Comprobra si existe sesion carrito
            if (isset($_SESSION['carrito'])) {
                    $counter =0;
                   foreach ($_SESSION['carrito'] as $indice => $elemento) {
                       if ($elemento['id_producto'] == $producto_id) {
                        $_SESSION['carrito'][$indice]['unidades']++;
                        $counter++;
                       }
                   }
            }
            if(!isset($counter) || $counter == 0){
                    // Acceder al modelo para conseguir producto
                    $producto = new Producto();
                    //Le pasamos por set producto seleccionado
                    $producto->setId($producto_id);
                    //Accede al metodo
                    $producto = $producto->getOne();
                    //Pasarle los datos del producto al carrito
                    // Crear sesion carrito
                    if (is_object($producto)) 
                    {
                        
                        $_SESSION['carrito'][] = array
                        (
                            "id_producto"=>$producto->id,
                            "precio"=>$producto->precio,
                            "unidades"=>1,
                            "producto"=>$producto
                        );
                    }
                }
            header("Location:".base_url."carrito/index");
            
        }

        public function delete(){
        if(isset($_GET['index'])){
            $index = $_GET['index'];
            unset($_SESSION['carrito'][$index]);
        }
        header("Location:".base_url."carrito/index");
    }
    
    public function up(){
        if(isset($_GET['index'])){
            $index = $_GET['index'];
            $_SESSION['carrito'][$index]['unidades']++;
        }
        header("Location:".base_url."carrito/index");
    }
    
    public function down(){
        if(isset($_GET['index'])){
            $index = $_GET['index'];
            $_SESSION['carrito'][$index]['unidades']--;
            
            if($_SESSION['carrito'][$index]['unidades'] == 0){
                unset($_SESSION['carrito'][$index]);
            }
        }
        header("Location:".base_url."carrito/index");
    }

        public function delete_all(){
            unset($_SESSION['carrito']);
            header("Location:".base_url."carrito/index");
            
        }
    }
?>
