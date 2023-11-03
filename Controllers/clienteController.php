<?php
    //Detectar cuando se realiza una petición ajax o no
    if ($peticionAjax) {
        require_once "../Models/clienteModel.php";
    } else {
        require_once "./Models/clienteModel.php";
    }

    class clienteController extends clienteModel {
        
        /*-------- Controlador Agregar Cliente --------*/
        public function agregar_cliente_controlador() {
            //Limpiar los datos que se enviarán
            $dni = mainModel::limpiar_cadena($_POST['cliente_dni_reg']);
            $nombre = mainModel::limpiar_cadena($_POST['cliente_nombre_reg']);
            $apellido = mainModel::limpiar_cadena($_POST['cliente_apellido_reg']);
            $telefono = mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
            $direccion = mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);
        }

    }