<h1>Gestionar categorias</h1>
<!-- redirije a views-categoria-crear -->
<a href="<?=base_url?>categoria/crear" class="button button-small">Crear categorias</a>
<!-- Mostrar las categorias almacenadas en la BD -->
<!-- Crear tabla -->
<table >
    <!-- Encabezados -->
    <tr>
        <th>ID</th> 
        <th>NOMBRE</th>
    </tr>
    
    <!-- Crear un ciclo while para mostrar los datos -->
    <?php while($cat = $categorias->fetch_object()): ?>
        <!-- Generar una fila por cada iteracion del bucle -->
        <tr>
            <!-- Un td por cada columna a mostrar -->
            <td><?=$cat->id;?></td>
            <td><?=$cat->nombre;?></td>
        </tr>

        <?php endwhile; ?>
</table>

