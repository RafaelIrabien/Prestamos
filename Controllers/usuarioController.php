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

            if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las claves no coinciden con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

            /*
            //Comprobando que el DNI no esté registrado en la BD
            //Seleccionamos el DNI registrado siempre y cuando sea el
            //que se está recibiendo en el formulario
            $check_dni = mainModel::ejecutar_consulta_simple("SELECT usuario_dni FROM usuario WHERE usuario_dni='$dni'");
            //rowCount(): Devuelve el número de filas afectadas por 
            //la última sentencia SQL
            if ($check_dni->rowCount()>0) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }


            //Comprobando que el usuario no esté registrado en la BD
            $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
            if ($check_user->rowCount()>0) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre de usuario ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }


             //Comprobando que el email no esté registrado en la BD
            if ($email!="") {
                //filter_var: Filtra una variable con el filtro 
                //que se indique
                //Comprobamos si el email ingresado es un email valido
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                     //Comprobamos si existe en la BD
                     $check_email = mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
                     if ($check_email->rowCount()>0) {
                         $alerta = [
                             "Alerta"=>"simple",
                             "Titulo"=>"Ocurrió un error inesperado",
                             "Texto"=>"El correo ingresado ya se encuentra registrado en el sistema",
                             "Tipo"=>"error"
                            ];
                         echo json_encode($alerta);
                         exit();
                     }
                } else {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Ha ingresado un correo no válido",
                        "Tipo"=>"error"
                       ];
                    echo json_encode($alerta);
                    exit();
                }
                
            }
*/

            //Comprobando las claves
            if($clave1!=$clave2){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las claves que acaba de ingresar no coinciden",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$clave=mainModel::encryption($clave1);
			}
            

            //Comprobando el privilegio
            if ($privilegio<1 || $privilegio>3){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El privilegio seleccionado no es válido",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}


        } //FINALIZA agregar_usuario_controlador()


    } //FINALIZA CONTROLADOR