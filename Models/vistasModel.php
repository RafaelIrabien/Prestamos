<?php

    class vistasModel {

         /*-------- Modelo obtener vistas --------*/
        protected static function obtener_vistas_model($vistas) {
            //Lista blanca de palabras que si podrán escribirse en la URL
            //y que si van a obtener vistas mediante esa palabra clave
            $listaBlanca = ["home",
                            "client-list",
                            "client-new",
                            "client-search",
                            "client-update",
                            "company",
                            "item-list",
                            "item-new",
                            "item-search",
                            "item-update",
                            "reservation-list",
                            "reservation-new",
                            "reservation-pending",
                            "reservation-reservation",
                            "reservation-search",
                            "reservation-update",
                            "user-list",
                            "user-new",
                            "user-search",
                            "user-update"
                            ];

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