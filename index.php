<?php

    /*INICIAR SESION AL REGISTRAR UN USUARIO */
    session_start();
    // CONTROLADOR FRONTAL:
        /*SE ENCARGA DE RECOGER PARAM GET DE URL, VER A QUE CONTROLADOR PERTENECE Y CARGAR ESE ARCHIVO
          Y ACCEDER A LA FUNCION Y EJECUTAR LA ACCION */

    //cargar el autoload
    require_once 'autoload.php';
    //cargar bd
    require_once 'config/db.php';
    //Incluir el scrip para eliminad sesiones en form registro
    require_once 'helpers/utilidades.php';
    //cargar archivo que contiene el parametro base_url
    require_once 'config/parameters.php';

    //Incluir la maquetacion HTML de header y sidebar
    require_once 'views/layout/header.php';
    require_once 'views/layout/sidebar.php';

    //  FUNCION MOSTRAR ERROR CUANDO NO ENCUENTRE LA PAGINA
    function show_error(){
        /*Instanciar obj de controlador creado */
        $error = new errorController();
        /*Utilizar la funcion del controlador*/
        $error->index();
    }

    /*Comprobar si llega el controlador por Url*/
        if (isset($_GET['controller'])) {
                /*Si llega se genera la variable */
                $nombre_controlador = $_GET['controller'].'Controller';
                //SI CONTROLLER Y ACTION NO EXISTE REDIRIJE A INDEX PAGINA PRINCIPAL
            }else if(!isset($_GET['controller']) && !isset($_GET['action'])){
                //Crear var y darl el valor a la constante controller defaul creado en parameter
                $nombre_controlador = controller_default;
            }else{
                /*No llega, corta la ejecusion */
                    //echo 'La pagina que buscas no existe12';
                    show_error();
                exit();
            }

            /*Comprueba si existe la clase del controlador */
            if (class_exists($nombre_controlador)) 
               {
                    /*SI existe crea el objeto */
                    $controlador = new $nombre_controlador();
                    /*Comprueba si llega la accion(Funcion-metodo) y si existe el metodo dentro del controlador */
                    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
                        /*Llama e invoca al metodo */
                        $action = $_GET['action'];
                        $controlador->$action();
                        //SI ACTION Y CONTROLLER NO EXISTE REDIRIJE A INDEX PAGINA PRINCIPAL
                    }else if(!isset($_GET['controller']) && !isset($_GET['action'])){
                        $default = action_default;
                        $controlador->$default();
                    }else{
                        /*En caso contrario manda el msg */
                        //echo 'La pagina que buscas no existe';
                        show_error();
                    }
                }else{
                        /*Si no se cumple la 1er condicion manda el msg */
                        //echo 'La pagina que buscas no existe';
                        show_error();
                     }

    //Incluir la maquetacion HTML del footer
    require_once 'views/layout/footer.php';
?>