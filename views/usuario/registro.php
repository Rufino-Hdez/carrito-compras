
    <h1>Registrarse</h1>

    <!-- COMPROBAR SI EXISTE LA SESION y si sesion es = a complete -->
        <?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'Complete'): ?>
                <!-- Mostrar msg con html -->
                <strong class="alert_green">Registro Completado Correctamente</strong>
        <?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'Failed'): ?>
                <!-- si falla  Mostrar msg con html  -->
                <strong class="alert_red">Falló al Registrar, Introduce bien los datos</strong>        
        <?php endif; ?>
        <!-- Invocar a la clase eliminar sesion -->
        <?php Utils::deleteSession('register')?>

    <form action="<?=base_url?>usuario/save" method="post">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" required>

            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" required>

            <input type="submit" value="Registrarse">
    </form>
