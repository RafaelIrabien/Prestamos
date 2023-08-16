<?php

    class vistasModel {

         /*-------- Modelo obtener vistas --------*/
        protected static function obtener_vistas_model($vistas) {
            //Lista blanca de palabras que si podrán escribirse en la URL
            //y que si van a obtener vistas mediante esa palabra clave
            $listaBlanca = [];

            //Comprobar que una vista esté en nuestro sistema
            if (in_array($vistas, $listaBlanca)) {
                //Comprobamos que ese archivo exista
                if (is_file("./Views/contenidos/".$vistas."-view.php")) {
                    $contenido = "./Views/contenidos/".$vistas."-view.php";
                } else {
                    $contenido = "404";
                }

            } elseif ($vistas=="login" || $vistas=="index"){
                $contenido = "login";
            } else {
                $contenido = "404";
            }
            return $contenido;
        }
    }