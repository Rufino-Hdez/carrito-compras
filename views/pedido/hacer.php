<!-- Comprobar si esta identificado -->

<?php if(isset($_SESSION['identity'])):?>
	<h1>Hacer pedido</h1>
	<a href="<?=base_url?>carrito/index">Ver productos y precio de pedido</a>
	<br><br>
	<!-- Mostrar formulario si esta identificado -->
		<h3>Direccion para el envio</h3>
		<form action="<?=base_url.'pedido/add'?>" method="POST">
			<label for="provincia">Provincia:</label>
			<input type="text" name="provincia" required>

			<label for="localidad">Localidad:</label>
			<input type="text" name="localidad" required>

			<label for="direccion">Direccion:</label>
			<input type="text" name="direccion">

			<input type="submit" value="Confirmar pedido" required>
		</form>
<?php else: ?>
	<h1>Aviso !!</h1>
	<p>Necesitas iniciar sesion para realizar tu pedido</p>
<?php endif; ?>