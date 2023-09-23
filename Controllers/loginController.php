<?php

    //Detectar cuando se realiza una petición ajax o no
    if ($peticionAjax) {
        //Lo ejecutamos en el archivo usuarioAjax.php
        require_once "../Models/loginModel.php";
    } else {
        //Lo ejecutamos en el archivo index.php
        require_once "./Models/loginModel.php";
    }

class loginController extends loginModel {
    
     /*-------- Controlador iniciar sesión --------*/
     public function iniciar_sesion_controlador() {
        $usuario=mainModel::limpiar_cadena($_POST['usuario_log']);
        $clave=mainModel::limpiar_cadena($_POST['clave_log']);

        //Comprobar que los campos requeridos estén llenos
        if ($usuario=="" || $clave=="") {
            echo '
            <script>
                Swal.fire({
                    title: "Ocurrió un error inesperado",
                    text: "No has llenado todos los campos que son requeridos",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
            ';
        }

        //Verificar integridad de los datos
        if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}",$usuario)) {
            echo '
            <script>
                Swal.fire({
                    title: "Ocurrió un error inesperado",
                    text: "El nombre de usuario no coincide con el formato solicitado",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
            ';
        }

        if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)) {
            echo '
            <script>
                Swal.fire({
                    title: "Ocurrió un error inesperado",
                    text: "La clave no coincide con el formato solicitado",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
            ';
        }

        //Se envia la clave encriptada al modelo 
        //para comparar que sea la misma que tenemos en la BD
        $clave = mainModel::encryption($clave);

        $datos_login = [
            "Usuario"=>$usuario,
            "Clave"=>$clave
        ];

        $datos_cuenta = loginModel::iniciar_sesion_modelo($datos_login);

        if ($datos_cuenta->rowCount()==1) {
            //Almacenamos todos los datos del usuario en la BD
            $row = $datos_cuenta->fetch();
            //Iniciamos sesión
            session_start(['name'=>'SPM']);

            //Variables de sesión que se utilizará en todo el sistema
            //Se le asigna el campo usuario_id de la tabla
            //Va a llevar el id del usuario que acaba de iniciar sesión
            $_SESSION['id_spm']=$row['usuario_id'];
            $_SESSION['nombre_spm']=$row['usuario_nombre'];
            $_SESSION['apellido_spm']=$row['usuario_apellido'];
            $_SESSION['usuario_spm']=$row['usuario_usuario'];
            $_SESSION['privilegio_spm']=$row['usuario_privilegio'];
            //Servirá para cerrar la sesión de forma segura
            //Será un numero al azar
            $_SESSION['token_spm']=md5(uniqid(mt_rand(),true));

            //Redireccionamos al usuario a la página principal
            return header("Location: ".SERVER_URL."home/");

        } else {
            echo '
            <script>
                Swal.fire({
                    title: "Ocurrió un error inesperado",
                    text: "El usuario o clave son incorrectos",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
            ';
        }
        
        
     }
}