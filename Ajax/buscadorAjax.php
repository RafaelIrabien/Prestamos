<?php
    session_start(['name'=>'SPM']);
    require_once "../Config/APP.php";

    if (isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda']) 
       || isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])) {
        //Array de las vistas donde se va a redireccionar
        $data_url = [
            "usuario"=>"user-search"
            
        ];
    } else {
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
        exit();
    }
    