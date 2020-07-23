<!-- SOLUCION PROBLEMAS DE CABECERAS -->
<?php ob_start(); ?>

<!-- BARRA LATERAL -->
<aside id="lateral">
    <!-- Mi carrito -->
    <div id="carrito" class="block_aside">
        <h3>Mi carrito</h3>
        <ul>
            <!-- asignarle a la variable stats el metodo estadistico de carrito -->
            <?php $stats = Utils::statsCarrito();?>
                                                              <!-- Contar cantidad de productos no unidades -->
            <li><a href="<?=base_url?>carrito/index">Productos (<?=$stats['count']?>)</a></li>
            <li><a href="<?=base_url?>carrito/index">Total: <?=$stats['total']?> $</a></li>
            <li><a href="<?=base_url?>carrito/index">Ver el carrito</a></li>
        </ul>
    </div>

    
    <!-- Formulario de login -->
    <div id="login" class="block_aside">
        <!-- Comprobar si no existe la sesion identity muestra el form-->
        <?php if(!isset($_SESSION['identity'])):?>

        <h3>Entrar a la web</h3>

        <!-- Mostrar msg en caso de que no se identifique correctamente -->
        <?php if(isset($_SESSION['error_login'])):?>
                <div class="alerta alert_red">
                    <!-- Mostrar msg de error -->
                    <?= $_SESSION['error_login'];?>
                </div>
        <?php endif; ?>

        <form action="<?=base_url?>usuario/login" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email">
            <label for="password">Contraseña</label>
            <input type="password" name="password">
            <input type="submit" value="Enviar">
        </form>
        
        <!-- Invocar a la clase eliminar sesion -->
        <?php Utils::deleteLogin('register')?>

        <?php else:?>
            <!-- Imprimimos el nombre del user -->
            <h3><?= $_SESSION['identity']->nombre?> <?= $_SESSION['identity']->apellido?></h3>
        <?php endif;?>
        <ul>
                <!-- Mostrar opciones solo si el usuario es administrador -->
                <?php if(isset($_SESSION['admin'])):?>
                    <!-- base url/Views/file -->
                    <li> <a href="<?=base_url?>categoria/index">Gestionar categorias</a> </li>
                    <li> <a href="<?=base_url?>producto/gestion">Gestionar productos</a> </li>
                    <li> <a href="<?=base_url?>pedido/gestion">Gestionar pedidos</a> </li>
                <?php endif; ?>

                <!-- Mostrar opciones solo si se han identificado -->
                <?php if(isset($_SESSION['identity'])):?>
                    <li> <a href="<?=base_url?>pedido/mis_pedidos">Mis pedidos</a> </li>
                    <li> <a href="<?=base_url?>/usuario/logout">Cerrar Sesión</a></li>
                <?php else: ?>
                    <!-- Registrar usuario -->
                    <a href="<?=base_url?>/usuario/registro">Registrate aqui</a>
                <?php endif; ?>
        </ul>
    </div>
</aside>
<!-- CONTENIDO CENTRAL -->
<div id="central">

