<h1> Algunos de nuestros Productos</h1>

<!-- Crear bucle para mostrar los productos -->
 <!-- crear var y en cada iteracion asignarle el valor que se obtenga -->
<?php while($pro = $productos->fetch_object()):?>
        <div class="product">
            <!-- la imagen y el nombre del producto sera un enlace a detalle produc -->
            <a href="<?=base_url?>producto/ver&id=<?=$pro->id?>">
                <!-- Comprobar si imagen NO esta vacio mostrar imagen De lo contrario asignarle uno por defecto -->
                <?php if($pro->imagen != null):?>
                    <img src="<?=base_url?>/uploads/images/<?= $pro->imagen?>" alt="Camiseta azul">
                <?php else:?>
                    <img src="<?=base_url?>assets/img/camiseta.png" alt="Camiseta azul">
                    
                <?php endif;?>
                <h2><?= $pro->nombre?></h2>
            </a>

            <p><?= $pro->precio?></p>
            <a href="<?=base_url?>carrito/add&id=<?=$pro->id?>" class="button">Comprar</a>
        </div>
<?php endwhile;?>
