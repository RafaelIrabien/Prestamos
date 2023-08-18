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

    /*-------- Función ejecutar consultas simples --------*/
    protected static function ejecutar_consulta_simple($consulta) {
        $sql = self::conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }


    /*-------- Función encriptar cadenas --------*/
    public function encryption($string) {
        $output = false;
        //Genera una clave de cifrado de 256 bits mediante el hash 
        //de SECRET_KEY mediante el algoritmo SHA-256
        $key = hash('sha256', SECRET_KEY);
        //Genera un vector de inicialización (IV) de 128 bits al codificar 
        //el SECRET_IV usando el algoritmo SHA-256 y luego tomando los primeros 16 caracteres del hash
        $iv = substr(hash('sha256',  SECRET_IV), 0, 16);
        /*openssl_encrypt de la biblioteca OpenSSL se usa para realizar el cifrado real.
        Los parámetros utilizados son:
        $string: la cadena de texto sin formato que se cifrará.
        METHOD: Debe reemplazarse con el algoritmo de encriptación o cifrado que pretende usar, como 'AES-256-CBC'.
        $key: la clave de cifrado generada anteriormente.
        0: este parámetro se establece en 0 para indicar que no se utilizan opciones o indicadores adicionales.
        $iv: El vector de inicialización generado anteriormente.*/
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        //La salida cifrada del paso anterior se codifica en base64 para 
        //garantizar que se pueda almacenar o transmitir de forma segura como texto.
        $output = base64_encode($output);
        return $output;
    }

    

}