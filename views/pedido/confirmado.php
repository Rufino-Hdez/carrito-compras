<?php if (isset($_SESSION['pedido']) && $_SESSION['pedido'] == 'complete'): ?>
	
	<h1>Tu pedido se ah confirmado</h1>
	<p>
		Tu pedido ah sido guardado con exito, una vez que realices la transferencia 
		bancaria a la cuenta 788634009876 con el coste pedido, será procesada y enviada.
	</p>
	<br>
	<!-- se va a mostrar la info solo si existe la variable pedido que llega del controlador 
		pedidocontroller -->
	<?php if(isset($pedido)): ?>

		<h3>Datos del pedido</h3>
		
			Numero de pedido: <?=$pedido->id?>	<br>
			Total a pagar:	  <?=$pedido->coste?> <br><br>
			Productos: <br> 

			<table>
						<?php while($producto = $productos->fetch_object()):?>
<!-- <ul><li><?=$producto->nombre?> - $<?=$producto->precio?> - <?=$producto->unidades?></li></ul> -->
							<tr>
					            <td>
					                <?php if ($producto->imagen != null) : ?>
					                    <img src="<?= base_url ?>/uploads/images/<?= $producto->imagen ?>" alt="Camiseta azul" class="img-carrito">
					                <?php else : ?>
					                    <img src="<?= base_url ?>assets/img/camiseta.png" alt="Camiseta azul" class="img-carrito">
					                <?php endif; ?>
					            </td>

					            <td>
					                <!-- Enlace para acceder al mismo producto y agregarlo -->
									<a href="<?= base_url?>producto/ver&id=<?=$producto->id?>"><?= $producto->nombre ?> </a>
					        	</td>

						        <td>
									<?=$producto->precio?>
								</td>

						        <td>
						            <?=$producto->unidades?>
						        </td>

						      </tr>
						<?php endwhile;?>
			</table>
		

	<?php endif;?>

<?php elseif (isset($_SESSION['pedido']) && $_SESSION['pedido'] != 'complete'): ?>	
	<h1>Tu pedido No ah podido procesarce</h1>
<?php endif; ?>