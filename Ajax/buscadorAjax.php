<?php
    session_start(['name'=>'SPM']);
    require_once "../Config/APP.php";

    if (isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda']) 
       || isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])) {
        //Array de las vistas donde se va a redireccionar
        $data_url = [
            "usuario"=>"user-search",
            "cliente"=>"client-search",
            "item"=>"item-search",
            "prestamo"=>"reservation-search"
        ];

        //Comprobamos que el input "modulo" venga definido
        if (isset($_POST['modulo'])) {
            $modulo = $_POST['modulo'];
            //Comnprobar si el valor está en el array $data_url
            if (!isset($data_url[$modulo])) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No podemos continuar con la búsqueda debido a un error",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }
            
        } else {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"No podemos continuar con la búsqueda debido a un error de configuración",
                "Tipo"=>"error"
               ];
            echo json_encode($alerta);
            exit();
        }

        if ($modulo=="prestamo") {
            //Creamos estas variables dinamicamente para definir las variables de sesión
            $fecha_inicio = "fecha_inicio_".$modulo;
            $fecha_final = "fecha_final_".$modulo;

            //Iniciar búsqueda
            if (isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])) {
                //Comprobar que vengan definidos los dos valores de las variables
                if ($_POST['fecha_inicio']=="" || $_POST['fecha_final']=="") {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Por favor introduzca una fecha de inicio y una fecha final",
                        "Tipo"=>"error"
                       ];
                    echo json_encode($alerta);
                    exit();
                }

                //Creamos las variables de sesión
                $_SESSION[$fecha_inicio]=$_POST['fecha_inicio'];
                $_SESSION[$fecha_final]=$_POST['fecha_final'];
            }

            //Eliminar la búsqueda
            if (isset($_POST['eliminar_busqueda'])) {
                //Eliminamos el valor almacenado
                unset($_SESSION[$fecha_inicio]);
                unset($_SESSION[$fecha_final]);
            }

        } else {
            $name_var = "busqueda_".$modulo;

            //Iniciar búsqueda
            if(isset($_POST['busqueda_inicial'])) {
                //Comprobar que esta definido el valor enviado desde el formulario
                if ($_POST['busqueda_inicial']=="") {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Por favor introduzca un término de búsqueda para empezar",
                        "Tipo"=>"error"
                       ];
                    echo json_encode($alerta);
                    exit();
                }

                //creamos la variable de sesión
                $_SESSION[$name_var]=$_POST['busqueda_inicial'];
            }
        }
        
        
    } else {
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
        exit();
    }
    