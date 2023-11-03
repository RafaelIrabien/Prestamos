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

            //Comprobar que los campos requeridos estén llenos
            if ($dni=="" || $nombre=="" || $apellido=="" || $telefono=="" || $direccion=="") {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has llenado los campos obligatorios",
                    "Tipo"=>"error"
                   ];
                //Pasamos a json el array para que js lo entienda
                echo json_encode($alerta);
                exit();
            }

        } //Finaliza agregar_usuario_controlador()

    }