<?php
class Producto{
/*PROPIEDADES DE CLASE*/
        private $id;
        private $categoria_id;
        private $nombre;
        private $descripcion;
        private $precio;
        private $stock;
        private $oferta;
        private $fecha;
        private $imagen;
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
        public function getCategoria_id(){
            return $this->categoria_id;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function getDescripcion(){
            return $this->descripcion;
        }
        public function getPrecio(){
            return $this->precio;
        }
        public function getStock(){
            return $this->stock;
        }
        public function getOferta(){
            return $this->oferta;
        }
        public function getFecha(){
            return $this->fecha;
        }
        public function getImagen(){
            return $this->imagen;
        }

        public function setId($id){
            $this->id = $id; 
        }
        public function setCategoria_id($categoria_id){
            $this->categoria_id = $categoria_id; 
        }
        //Escapar los datos p/mayor seguridad y evitar insertar caracteres especiales
        //this->db (Para acceder al objeto mysqli)
        public function setNombre($nombre){
            $this->nombre = $this->db->real_escape_string($nombre); 
        }
        public function setDescripcion($descripcion){
            $this->descripcion = $this->db->real_escape_string($descripcion); 
        }
        public function setPrecio($precio){
            $this->precio = $this->db->real_escape_string($precio); 
        }
        public function setStock($stock){
            $this->stock = $this->db->real_escape_string($stock); 
        }
        public function setFecha($fecha){
            $this->fecha = $fecha; 
        }
        public function setImagen($imagen){
            $this->imagen = $imagen; 
        }

        //LISTAR PRODUCTOS
        public function getAll(){
            $productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
            return $productos;
        }

        //LISTAR PRODUCTOS ESPECIFICAMENTE DE UNA CATEGORIA
        public function getAllCategory(){
            $sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p"
            . " INNER JOIN categorias c ON c.id = p.categoria_id"
            . " WHERE p.categoria_id = {$this->getCategoria_id()} "
            . " ORDER BY id DESC";
            $productos = $this->db->query($sql);
            return $productos;
        }

        //LISTAR DE FORMA ALEATORIA ALGUNOS PRODUCTOS EN LA PAGINA DE INICIO
        public function getRandom($limit){
            //Hacer una consulta para listar los productos con un parametro limit
            $productos = $this->db->query("SELECT *FROM productos ORDER BY RAND() LIMIT $limit ");
            return $productos;
        }

        //MOSTRAR EL PRODUCTO DE ACUERDO AL ID
        // public function getOne(){
        // $producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()}");
        //     return $producto->fetch_object();
        // }
        public function getOne(){
            $producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()}");
            return $producto->fetch_object();
        }

        // GUARDAR PRODUCTOS
        public function save(){
            
            $sql = "INSERT INTO productos VALUES (NULL,'{$this->getCategoria_id()}' ,'{$this->getNombre()}', '{$this->getDescripcion()}',{$this->getPrecio()},{$this->getStock()},null,CURDATE(),'{$this->getImagen()}');";
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

        // GUARDAR PRODUCTOS
        public function edit(){
            
            $sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio={$this->getPrecio()}, stock={$this->getStock()}, categoria_id={$this->getCategoria_id()} ";
            //$sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio={$this->getPrecio()}, stock={$this->getStock()}, categoria_id={$this->getCategoria_id()}  ";
                    // Comprobar si imagen es diferente de null - guarda imagen
                    if ($this->getImagen() !=null) {
                        $sql .= ", imagen = '{$this->getImagen()}'";
                    }
                //Editar solamente los productos que lleguen con id en el controlador linea 87
            $sql .= "WHERE id ={$this->id}";
            /*Asignar a variable la conexion a la base de datos y ejecutar la query*/
            $save = $this->db->query($sql);

            //CAPTURA DE ERRORES
            // echo $sql .'<br>';
            // echo $this->db->error;
            // die();
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

    public function delete(){
            //Crear la consulta
        $sql = "DELETE FROM productos WHERE id = {$this->id}";
            //Ejecutar la sentencia
        $delete = $this->db->query($sql);
            //devolver resultado positivo o negativo
            $result = false;
            if ($delete) {
                    /*Si da true el valor de result cambia a true para retornar este valor*/
                    $result = true;
            }
            /**Devolver el valor de result */
            return $result;
    }

}
?>