<?php 
	// Incluir modelo de pedidos
	require_once 'models/pedido.php';
    class pedidoController{
        public function hacer(){
            // renderizar vista
            require_once 'views/pedido/hacer.php';
        }

        public function add(){
        	// Comprobar si esta identificado
        	if(isset($_SESSION['identity']))
        	{
        		// Validar datos que se insertan en el formulario
        		// Comprobar que llegue por post | si llega asignarl el valor que llega sino da falso
        		$usuario_id = $_SESSION['identity']->id;
        		$provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
        		$localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
        		$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;

        		// obtener el total
        		$stats = Utils::statsCarrito();
        		$coste = $stats['total'];
        		// comprobar que todo vaya correcto y todo de true
        		if ($provincia && $localidad && $direccion)
        		{
        			$pedido = new Pedido();
        			$pedido->setUsuario_id($usuario_id);
        			$pedido->setProvincia($provincia);
        			$pedido->setLocalidad($localidad);
        			$pedido->setDireccion($direccion);
        			$pedido->setCoste($coste);
        			// Guardar datos en bd
        			$save = $pedido->save();

        			// Guardar linea pedido
        			$save_lineas = $pedido->save_linea();
        			//Si pedido se ah guardado crear sesion
        			if ($save && $save_lineas) {
        				$_SESSION['pedido'] = 'complete';
        			}else{
        				$_SESSION['pedido'] = 'failed';
        			}
        		}else{
        			// Si datos no estan validados correctamente
        			$_SESSION['pedido'] = 'failed';
        		}
        		header("Location:".base_url.'pedido/confirmado');
        	}else{
        		// Redirijir al index
        		header("Location:".base_url);
        	}
        }

	    public function confirmado(){
	    	// Comprobar si existe la sesion identity
	    	if(isset($_SESSION['identity']))
	    	{
	    		$identity = $_SESSION['identity'];
		    	// Buscar el ultimo pedido del usuario identificado
		    	$pedido = new Pedido();
		    	$pedido->setUsuario_id($identity->id);
		    	// Obtener usuario
		    	$pedido = $pedido->getOneByUser();

		    	// Buscar productos del pedido x
		    	$pedido_productos = new Pedido();
		    	$productos = $pedido_productos->getProductsByPedido($pedido->id);
	    	}
	    	//renderizar- redirijir
	    	require_once 'views/pedido/confirmado.php';
	    }

	    public function mis_pedidos(){
	    	// Comprobar si estamos identificados
	    	Utils::isIdentity();
	    	$usuario_id = $_SESSION['identity']->id;

	    	$pedido = new Pedido();
	    	$pedido->setUsuario_id($usuario_id);
	    	$pedidos = $pedido->getAllByUser();

	    	//renderizar 
	    	require_once 'views/pedido/mis_pedidos.php';
	    }

	    public function detalle(){
	    	Utils::isIdentity();

	    	// Comprobar que llegue el id
	    	if (isset($_GET['id'])) {
	    		//recoger por url el id del pedido
	    		$id = $_GET['id'];

	    		// sacar el pedido
	    		$pedido = new Pedido();
	    		$pedido->setId($id);
	    		$pedido = $pedido->getOne();

	    		//Sacar los productos
	    		$pedido_productos = new Pedido();
	    		$productos = $pedido_productos->getProductsByPedido($id);


	    	 	// Cargar vista
	    		require_once 'views/pedido/detalle.php';
	    	 }else{
	    	 	header("Location:".base_url."pedido/mis_pedidos");
	    	 }
	    	
	    }

	    public function gestion(){
	    	Utils::isAdmin();
	    	$gestion=true;

	    	$pedido = new Pedido();
	    	$pedidos = $pedido->getAll();

	    	require_once 'views/pedido/mis_pedidos.php';
	    }

	    public function estado(){
		Utils::isAdmin();
		if(isset($_POST['pedido_id']) && isset($_POST['estado'])){
			// Recoger datos form
			$id = $_POST['pedido_id'];
			$estado = $_POST['estado'];
			
			// Upadate del pedido
			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido->setEstado($estado);
			$pedido->edit();
			
			header("Location:".base_url.'pedido/detalle&id='.$id);
		}else{
			header("Location:".base_url);
		}
	}

	

    }
?>