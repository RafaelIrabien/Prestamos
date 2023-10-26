<?php
    session_start(['name'=>'SPM']);
    require_once "../Config/APP.php";

    if (isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda']) 
       || isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])) {
        //Array de las vistas donde se va a redireccionar
        $data_url = [
            "usuario"=>"user-search"
            
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
        
    } else {
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
        exit();
    }
    