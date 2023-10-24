<?php
//Se va a encargar de recibir los datos enviados desde los formularios
$peticionAjax = true;
require_once "../Config/APP.php";

//Detectar si estamos enviando los datos desde un formulario
//para ejecutar aqui los controladores y algunas funciones.
//Sino, quiere decir que alguien esta intentando acceder a 
//este archivo desde el navegador
if (isset($_POST['usuario_dni_reg']) || isset($_POST['usuario_id_del']) || isset($_POST['usuario_id_up'])) {
    /*-------- Instancia al controlador --------*/
    require_once "../Controllers/usuarioController.php";
    $ins_usuario = new usuarioController();

     /*-------- Agregar un usuario --------*/
    //Utilizaremos el controlador de registro una vez
    //enviemos este parametro
    if (isset($_POST['usuario_dni_reg']) && isset($_POST['usuario_nombre_reg'])) {
        //Ejecutamos el controlador
        echo $ins_usuario->agregar_usuario_controlador();
    }

    /*-------- Eliminar un usuario --------*/
    if (isset($_POST['usuario_id_del'])) {
        //Ejecutamos el controlador
        echo $ins_usuario->eliminar_usuario_controlador();
    }

    /*-------- Actualizar un usuario --------*/
    if (isset($_POST['usuario_id_up'])) {
        //Ejecutamos el controlador
        echo $ins_usuario->actualizar_usuario_controlador();
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

