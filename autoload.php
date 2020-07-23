<?php

    function controllers_autoloads($clase){
        //Entra a carpeta de los controladores y hace el include de cada uno de los controllers
        include 'controllers/' . $clase . '.php';
    }

    //Funcion php busca todas las clases cargadas en el directorio indicado y las incluye en la clase que se desea utilizar 
    spl_autoload_register("controllers_autoloads");

?>