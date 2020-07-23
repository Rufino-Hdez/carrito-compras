<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
    <title>Mi tienda Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url?>assets/css/styles.css">
</head>

<body>
    <div id="container">
        <!-- CABECERA -->
        <header id="header">
            <div id="logo">
                <!-- <img src="<?=base_url?>assets/img/camiseta.png" alt="camiseta logo"> -->
                <a href="<?=base_url?>">
                    Mi tienda Online
                </a>
            </div>
        </header>
        <!-- MENU -->
        <!-- Acceder al metodo para mostrar categorias en el menu -->
        <?php $categorias = Utils::showCategorias();?>
        <nav id="menu">
            <ul>
                <li>
                    <a href="<?=base_url?>">Inicio</a>
                </li>
                <!-- Crear bucle que muestra los resultados -->
                <!-- Crear variable cat dnd se guarda el resultado por cada iteracion-->
                <?php while($cat = $categorias->fetch_object()): ?>
                    <li>
						<a href="<?=base_url?>categoria/ver&id=<?=$cat->id?>"><?=$cat->nombre?></a>
					</li>
                <?php endwhile; ?>
            </ul>
        </nav>

        <div id="content">

    
					
				