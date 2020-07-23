<!-- Comprobar si se realiza creacion o edicion  ademas si llega la variable pro
    y si es un objeto-->
<?php if(isset($edit) && isset($pro) && is_object($pro)):?>
    <h1>Editar producto: <?= $pro->nombre?></h1>
    <?php $url_action = base_url."producto/save&id=".$pro->id; ?>
<?php else:?>   
    <h1>Crear nuevo producto</h1>
    <!-- Dirijir a la accion guardar -->
    <?php $url_action = base_url."producto/save";?>
<?php endif; ?>


<div class="form_container">
    <!-- Cambiar la accion del formulario dependiendo si es editar o crear-->
    
    <form action="<?= $url_action ?>" method="POST" enctype="multipart/form-data">

        <label for="nombre">Nombre</label>
        <!-- Condicion mediante ternaria para mostrar datos [En caso de edicion]o no mostrar nada [En el caso de la creacion] -->
        <input type="text" name="nombre" value="<?=isset($pro) && is_object($pro) ? $pro->nombre: ' '; ?>">

        <label for="descripcion">Descripcion</label>
        <textarea name="descripcion"><?=isset($pro) && is_object($pro) ? $pro->descripcion: ''; ?></textarea>

        <label for="precio">Precio</label>
        <input type="number" name="precio" value="<?=isset($pro) && is_object($pro) ? $pro->precio: ' '; ?>">

        <label for="stock">Stock</label>
        <input type="text" name="stock" value="<?=isset($pro) && is_object($pro) ? $pro->stock: ' '; ?>">

        <label for="categoria">categoria</label>
        <?php $categorias = Utils::showCategorias(); ?>
        <select name="categoria">
            <?php while ($cat = $categorias->fetch_object()) : ?>
                <!-- 1-cargar las categorias de la base de datos modulo CREAR
                     2-cargar la categoria del producto seleccionado comprobando si existe pro si pro es un objeto si categoria actual es = categoria que se encuentra en tabla producto de la bd si es asi selecciona-->
                <option value="<?= $cat->id ?>"     <?=isset($pro) && is_object($pro) && $cat->id == $pro->categoria_id ? 'selected': ' '; ?>>
                    <?= $cat->nombre ?>
                </option>
            <?php endwhile;?>
        </select>

        <label for="imagen">Imagen</label>
        <!-- Comprobar si existe var $pro, si es un objeto y si la propiedad no esta vacia
                 -->
            <?php if(isset($pro) && is_object($pro) && !empty($pro->imagen)): ?>
                <!-- Pasar la ruta -->
                <img src="<?= base_url?>/uploads/images/<?= $pro->imagen?>" class="thumb">
            <?php endif; ?>
            <br>

        <input type="file" name="imagen">

        <input type="submit" value="Guardar">
    </form>
</div>