<h1>Crear nueva categoriar</h1>

<!-- action = redirije al controlador categoria y al metodo save -->
<form action="<?=base_url?>categoria/save" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required>

    <input type="submit" value="Guardar">
</form>