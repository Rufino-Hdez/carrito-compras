<?php 
    class Utils{
        public static function deleteSession($name){
            // Comprobar si existe la sesion
            if (isset($_SESSION[$name])) {
                    $_SESSION[$name] = null;
                    // Borrar la sesion
                    unset($_SESSION[$name]);
            }
            return $name;
        }

        public static function deleteLogin(){
            // Comprobar si existe la sesion
            if (isset($_SESSION["error_login"])) {
                    $_SESSION["error_login"] = null;
                    // Borrar la sesion
                  unset($_SESSION["error_login"]);
            }

        }
        
        //COMPROBAR SI ES ADMINISTRADOR
        public static function isAdmin(){
            /*Comprobar si no existe la sesion admin*/
            if(!isset($_SESSION['admin'])){
                header("Location:".base_url);
            }else{
                return true;
            }
        }

        //COMPROBAR SI ESTAMOS IDENTIFICADOS
        public static function isIdentity(){
            /*Comprobar si no existe la sesion admin*/
            if(!isset($_SESSION['identity'])){
                header("Location:".base_url);
            }else{
                return true;
            }
        }

    //MOSTRAR CATEGORIAS EN EL MENU
        public static function showCategorias(){
            /*Incluir modelo para ser utilizado  */
            require_once 'models/categoria.php';
            /*Crear objeto categorias apartir del modelo */
            $categoria = new Categoria();
            /*Accede al metodo donde se encuentra la consulta a la bd */
            $categorias = $categoria->getAll();
            /*Devolver categorias */
            return $categorias;

        }
    // ESTADISTICAS CARRITO
    public static function statsCarrito(){
        // Crear array con valor cantidad de productos y total efectivo
        $stats = array
                ('count' => 0,
                 'total' => 0
                 );
        //comprobar que exista la sesion del carrito
        if (isset($_SESSION['carrito'])) {
            // dar valor al array | contar  cantidad de productos del carrito
            $stats['count'] = count($_SESSION['carrito']);
            // Recorrer todo lo que tiene carrito
            foreach ($_SESSION['carrito'] as $producto) {
                // dar valor al array stats e indice total
                // += suma lo que hay en total mas el nuevo producto (suma el primer producto  el resultado lo suma con el segundo)
                $stats['total'] += $producto['precio']*$producto['unidades'];
            }
        }
        return $stats;
    }

    public static function showStatus($status){

        $value = 'pendiente';

        if ($status == 'confirm') {
            $value = 'pendiente';
        }elseif ($status == 'preparation') {
            $value = 'En preparacion';
        }elseif ($status == 'ready') {
            $value = 'Preparado para enviar';
        }elseif ($status == 'sended') {
            $value = 'Enviado';
        }
        return $value;
    }

    }
?>