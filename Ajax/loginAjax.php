<?php
//Se va a encargar de recibir los datos enviados desde los formularios
$peticionAjax = true;
require_once "../Config/APP.php";

//Detectar si estamos enviando los datos desde un formulario
//para ejecutar aqui los controladores y algunas funciones.
//Sino, quiere decir que alguien esta intentando acceder a 
//este archivo desde el navegador
if () {
   

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

