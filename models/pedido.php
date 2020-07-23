<?php
class Pedido{
/*PROPIEDADES DE CLASE*/
        private $id;
        private $usuario_id;
        private $provincia;
        private $localidad;
        private $direccion;
        private $coste;
        private $estado;
        private $fecha;
        private $hora;
        /*Crear propiedad de base de datos */
        private $db;

/*CONSTRUCTOR */
        public function __construct()
        {
            $this->db = Database::connect();
        }

/*METODOS GET Y SET */
        public function getId(){
            return $this->id;
        }
        public function getUsuario_id(){
            return $this->usuario_id;
        }
        public function getProvincia(){
            return $this->provincia;
        }
        public function getLocalidad(){
            return $this->localidad;
        }
        public function getDireccion(){
            return $this->direccion;
        }
        public function getCoste(){
            return $this->coste;
        }
        public function getEstado(){
            return $this->estado;
        }
        public function getFecha(){
            return $this->fecha;
        }
        public function getHora(){
            return $this->hora;
        }

        public function setId($id){
            $this->id = $id; 
        }
        public function setUsuario_id($usuario_id){
            $this->usuario_id = $usuario_id; 
        }
        //Escapar los datos p/mayor seguridad y evitar insertar caracteres especiales
        //this->db (Para acceder al objeto mysqli)
        public function setProvincia($provincia){
            $this->provincia = $this->db->real_escape_string($provincia); 
        }
        public function setLocalidad($localidad){
            $this->localidad = $this->db->real_escape_string($localidad); 
        }
        public function setDireccion($direccion){
            $this->direccion = $this->db->real_escape_string($direccion); 
        }
        public function setCoste($coste){
            $this->coste = $coste; 
        }
        public function setEstado($estado){
            $this->estado = $estado; 
        }
        public function setFecha($fecha){
            $this->fecha = $fecha; 
        }
        public function setHora($hora){
            $this->hora = $hora; 
        }

        //LISTAR PRODUCTOS
        public function getAll(){
            $productos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC");
            return $productos;
        }

        //MOSTRAR EL PRODUCTO DE ACUERDO AL ID
        // public function getOne(){
        // $producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()}");
        //     return $producto->fetch_object();
        // }
        // BUSCAR PEDIDO EN BASE AL ID DEL PEDIDO
        public function getOne(){
            $producto = $this->db->query("SELECT * FROM pedidos WHERE id = {$this->getId()}");
            return $producto->fetch_object();
        }

        // BUSCAR UN PEDIDO EN BASE AL USUARIO
        public function getOneByUser(){
            $sql = "SELECT p.id, p.coste FROM pedidos p "
                    //."INNER JOIN linea_pedidos lp ON lp.pedido_id = p.id " 
                    ."WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC LIMIT 1";
            $pedido = $this->db->query($sql);

            // echo $sql;
            // echo $this->db->error;
            // die();

            return $pedido->fetch_object();
        }

        // BUSCAR TODOS LOS PEDIDO EN BASE AL USUARIO
        public function getAllByUser(){
            $sql = "SELECT p.* FROM pedidos p "
                    ."WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC ";
            $pedido = $this->db->query($sql);

            // echo $sql;
            // echo $this->db->error;
            // die();

            return $pedido;
        }

        // BUSCAR LOS PRODUCTOS DE LOS PEDIDOS
        public function getProductsByPedido($id){
            //todos los productos en base a un pedido
            // $sql = "SELECT * FROM productos WHERE id IN "
            //         ." (SELECT producto_id FROM linea_pedidos WHERE pedido_id = {$id})";

            $sql = "SELECT pr.*, lp.unidades FROM productos pr "
                . "INNER JOIN linea_pedidos lp ON pr.id = lp.producto_id "
                . "WHERE lp.pedido_id={$id}";

            $productos = $this->db->query($sql);
           
            return $productos;
        }

        // GUARDAR PRODUCTOS
        public function save(){
            
            $sql = "INSERT INTO pedidos VALUES (NULL,{$this->getUsuario_id()} ,'{$this->getProvincia()}', '{$this->getLocalidad()}','{$this->getDireccion()}',{$this->getCoste()},'Confirm',CURDATE(),CURTIME());";
            /*Asignar a variable la conexion a la base de datos y ejecutar la query*/
            $save = $this->db->query($sql);

            //CAPTURA DE ERRORES
            /*echo $sql .'<br>';
            echo $this->db->error;
            die();*/
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

        public function save_linea(){
            // Identificar el ultimo insert que se agrego a la bd
            $sql = "SELECT LAST_INSERT_ID() AS 'pedido';";
            $query = $this->db->query($sql);
            $pedido_id = $query->fetch_object()->pedido;

            // Recorrer el carrito
            foreach($_SESSION['carrito'] as $elemento){
            $producto = $elemento['producto'];
            // Cada vez que recorra esta inserta un registro en la bd
            $insert = "INSERT INTO linea_pedidos VALUES (NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']});";

            // Ejecutar
            $save = $this->db->query($insert);
            }

            //Comprobar si la ultima insercion es correcta
            if ($save) {
                    /*Si da true el valor de result cambia a true para retornar este valor*/
                    $result = true;
            }
            /**Devolver el valor de result */
            return $result;
        }

        // ACTUALIZAR EL ESTADO DEL PEDIDO
    public function edit(){
        $sql = "UPDATE pedidos SET estado='{$this->getEstado()}' ";
        $sql .= " WHERE id={$this->getId()};";
        
        $save = $this->db->query($sql);
        
        $result = false;
        if($save){
            $result = true;
        }
        return $result;
    }

}
?>