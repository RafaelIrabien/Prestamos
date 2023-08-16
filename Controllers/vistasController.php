<?php

    require_once "./Models/vistasModel.php";

    class vistasController extends vistasModel {

        /*-------- Controlador obtener plantilla --------*/
        public function obtener_plantilla_controlador() {
            //Devolvemos la plantilla
            return require_once "./Views/plantilla.php";
        }

         /*-------- Controlador obtener vistas --------*/
         public function obtener_vistas_controlador() {
            //Comprobamos si viene definido la variable que configuramos
            //en .htaccess
            if (isset($_GET['views'])) {
                //Queremos separar lo que viene en la variable views
                $ruta = explode("/", $_GET['views']);

                $respuesta = vistasModel::obtener_vistas_model($ruta[0]);
            } else {
                $respuesta = "login";
            }
            return $respuesta;
         }

    }