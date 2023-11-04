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

            //Verificar integridad de los datos
            if (mainModel::verificar_datos("[0-9-]{1,27}",$dni)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El DNI no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$nombre)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$apellido)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El apellido no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

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

            if (mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}",$direccion)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"La dirección no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            //Comprobando que el DNI no esté registrado en la BD
            $consulta = "SELECT cliente_dni FROM cliente WHERE cliente_dni='$dni'";
            $chek_dni = mainModel::ejecutar_consulta_simple($consulta);
            if ($chek_dni->rowCount()>0) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            //Colocar los índices del Modelo
            $datos_cliente_reg = [
                "DNI"=>$dni,
                "Nombre"=>$nombre,
                "Apellido"=>$apellido,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion
            ];

            //Llamar a la función para registrar clientes
            $agregar_cliente = clienteModel::agregar_cliente_modelo($datos_cliente_reg);
            //Comprobamos si se ha hecho un registro en la BD
            if ($agregar_cliente->rowCount()==1) {
                $alerta = [
                    "Alerta"=>"limpiar",
                    "Titulo"=>"Cliente registrado",
                    "Texto"=>"Los datos del cliente han sido registrados con éxito",
                    "Tipo"=>"success"
                   ];
            } else {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No se pudo registrar el cliente",
                    "Tipo"=>"error"
                    ];
            }
            echo json_encode($alerta);

        } //Finaliza agregar_usuario_controlador()

    }