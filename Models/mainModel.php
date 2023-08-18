<?php
    //Detectamos si estamos realizando una petición ajax o no
    if ($peticionAjax) {
        require_once "../Config/SERVER.php";
    } else {
        require_once "./Config/SERVER.php";
    }

class mainModel {

    /*-------- Función conectar a BD --------*/
    protected static function conectar() {
        $conexion = new PDO(SGBD, USER, PASSWORD);

        //La conexión utilizará los caracteres utf8
        $conexion->exec("SET CHARACTER SET utf8");
        return $conexion;
    }

   
}