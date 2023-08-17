<?php

    class vistasModel {

         /*-------- Modelo obtener vistas --------*/
        protected static function obtener_vistas_model($vistas) {
            //Lista blanca de palabras que si podrán escribirse en la URL
            //y que si van a obtener vistas mediante esa palabra clave
            $listaBlanca = ["home","client-list"];

            //Comprobar que una vista esté en nuestro sistema
            if (in_array($vistas, $listaBlanca)) {
                //Comprobamos que ese archivo exista
                if (is_file("./Views/contents/".$vistas."-view.php")) {
                    $contenido = "./Views/contents/".$vistas."-view.php";
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