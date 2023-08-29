<?php
    //Detectar cuando se realiza una petición ajax o no
    if ($peticionAjax) {
        //Lo ejecutamos en el archivo usuarioAjax.php
        require_once "../Models/usuarioModel.php";
    } else {
        //Lo ejecutamos en el archivo index.php
        require_once "./Models/usuarioModel.php";
    }

    class usuarioController extends usuarioModel {
        
        /*-------- Controlador agregar usuario --------*/
        public function agregar_usuario_controlador() {
            //Guardar en variables los datos enviados del formulario
            //Usamos la función Limpiar cadenas del mainModel
            $dni = mainModel::limpiar_cadena($_POST['usuario_dni_reg']);
            $nombre = mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
            $apellido = mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
            $telefono = mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);
            $direccion = mainModel::limpiar_cadena($_POST['usuario_direccion_reg']);

            $usuario = mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
            $email = mainModel::limpiar_cadena($_POST['usuario_email_reg']);
            $clave1 = mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
            $clave2 = mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);

            $privilegio = mainModel::limpiar_cadena($_POST['usuario_privilegio_reg']);


            //Comprobar que los campos requeridos estén llenos
            if ($dni=="" || $nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2="") {
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


            //Verificar integridad de los datos
            if (mainModel::verificar_datos("[0-9-]{10,20}",$dni)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El DNI no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
           
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$nombre)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$apellido)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El apellido no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            if ($telefono!="") {
                if (mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)) {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El teléfono no coincide con el formato solicitado",
                        "Tipo"=>"error"
                       ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if ($direccion!="") {
                if (mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}",$direccion)) {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"La dirección no coincide con el formato solicitado",
                        "Tipo"=>"error"
                       ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}",$usuario)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre de usuario no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || 
                mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave2)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Las claves no coinciden con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

        }


    }
    