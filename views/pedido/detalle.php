<h1>Detalle del pedido</h1>

<!-- se va a mostrar la info solo si existe la variable pedido que llega del controlador 
		pedidocontroller -->
	<?php if(isset($pedido)): ?>
		<!-- Cambiar estado del pedido solo si es ADMINISTRADOR -->
		<?php if (isset($_SESSION['admin'])): ?>
			<h3>Cambiar estado del pedido</h3>
			<form action="<?=base_url?>pedido/estado" method="POST">
				<input type="hidden" value="<?=$pedido->id?>" name="pedido_id">
				<select name="estado">
					<option value="confirm" <?=$pedido->estado == 'confirm' ? 'selected' : '';?> >Pendiente</option>
					<option value="preparation" <?=$pedido->estado == 'preparation' ? 'selected' : '';?> >En preparacion</option>
					<option value="ready" <?=$pedido->estado == 'ready' ? 'selected' : '';?> >Preparado para enviar</option>
					<option value="sended" <?=$pedido->estado == 'sended' ? 'selected' : '';?> >Enviado</option>
				</select>
				<input type="submit" value="Cambiar estado">
			</form>
			<br>
		<?php endif ?>

		<h3>Direccion de envio</h3>
			Provincia: <?=$pedido->provincia?>	<br>
			Ciudad: <?=$pedido->localidad?>	<br>
			Direccion: <?=$pedido->direccion?>	<br><br>	
		<h3>Datos del pedido</h3>
			Estado: <?=Utils::showStatus($pedido->estado)?> <br>
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