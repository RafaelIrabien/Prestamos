<?php
    $peticionAjax = true;
    require_once "../Config/APP.php";

    if (isset($_POST['cliente_dni_reg'])) {
        /*-------- Instancia al controlador --------*/
        require_once "../Controllers/clienteController.php";
        $ins_cliente = new clienteController();

    } else {
        session_start(['name'=>'SPM']);
        //Vaciamos la sesión
        session_unset();
        session_destroy();
        //Redireccionamos al usuario que intenta acceder a este archivo
        header("Location: ".SERVER_URL."login/");
        //Para que no siga ejecutando más código php
        exit();
    }