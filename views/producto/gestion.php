<h1>Gestion de productos</h1>

<!-- redirije a views-producto-crear -->
<a href="<?=base_url?>producto/crear" class="button button-small">Crear producto</a>

<!-- SESIONES DE MSG PARA AGREGAR PRODUCTO -->
        <!-- Mostrar mensaje complete and failed -->
        <!-- Comprobar que exista la sesion y que sea igual a ...? -->
            <?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'Complete'):?>
                <strong class="alert_green">Completado con exito !!</strong>
            <?php elseif(isset($_SESSION['producto']) && $_SESSION['producto'] != 'Complete'):?>
                <strong class="alert_red">Fallo al agregar el producto</strong>
            <?php endif;?>

<!-- SESIONES DE MSG PARA ELIMINAR PRODUCTO -->
            <?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'Complete'):?>
                <strong class="alert_green">El producto se ah eliminado correctamente</strong>
            <?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] != 'Complete'):?>
                <strong class="alert_red">Fallo al eliminar el producto</strong>
            <?php endif;?>
<!-- Borrar sesion -->
        <?php Utils::deleteSession('producto')?>
        <?php Utils::deleteSession('delete')?>
<!-- Mostrar las categorias almacenadas en la BD -->
<!-- Crear tabla -->
<table class="gestion-p">
    <!-- Encabezados -->
    <tr class="tr-gestionp">
        <th class="th-gestionp">ID</th> 
        <th class="th-gestionp">NOMBRE</th>
        <th class="th-gestionp">PRECIO</th>
        <th class="th-gestionp">STOCK</th>
        <th class="th-gestionp">Acciones</th>
    </tr>
    
    <!-- Crear un ciclo while para mostrar los datos -->
    <?php while($pro = $productos->fetch_object()): ?>
        <!-- Generar una fila por cada iteracion del bucle -->
        <tr class="tr-gestionp">
            <!-- Un td por cada columna a mostrar -->
            <td class="td-gestionp"><?=$pro->id;?></td>
            <td class="th-gestionp"><?=$pro->nombre;?></td>
            <td class="th-gestionp"><?=$pro->precio;?></td>
            <td class="th-gestionp"><?=$pro->stock;?></td>
            <td class="th-gestionp">
                <!-- Para actualizar o eliminar se debe de pasar un parametro Get con el id -->
                <!-- NOTA: id es el tercer parametro get que se envia por lo tanto no se envia
                           ya que producto es el 1er parametro
                           editar-eliminar el 2do parametro e id el 3ero
                           por lo tanto para que se envie se debe de cambiar el ? por el &-->
                <a href="<?=base_url?>producto/editar&id=<?=$pro->id?>" class="button button-gestion">Editar</a>
                <a href="<?=base_url?>producto/eliminar&id=<?=$pro->id?>" class="button button-gestion button-red">Eliminar</a>
            </td>
        </tr>

        <?php endwhile; ?>
</table>