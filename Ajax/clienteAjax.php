<?php
    $peticionAjax = true;
    require_once "../Config/APP.php";

    if (isset($_POST['cliente_dni_reg']) || isset($_POST['cliente_id_del'])) {
        /*-------- Instancia al controlador --------*/
        require_once "../Controllers/clienteController.php";
        $ins_cliente = new clienteController();

        /*-------- Agregar un cliente --------*/
        if (isset($_POST['cliente_dni_reg']) && isset($_POST['cliente_nombre_reg'])) {
            //Ejecutamos el controlador
            echo $ins_cliente->agregar_cliente_controlador();
        }

        /*-------- Eliminar un cliente --------*/
        if (isset($_POST['cliente_id_del'])) {
            //Ejecutamos el controlador
            echo $ins_cliente->eliminar_cliente_controlador();
        }

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