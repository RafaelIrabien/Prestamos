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

    /*-------- Función desencriptar cadenas --------*/
    protected static function decryption($string) {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        //base64_decode($string): Esto decodifica la cadena de entrada codificada en base64 de nuevo en su forma cifrada binaria
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }


     /*-------- Función generar códigos aleatorios --------*/
     protected static function generar_codigo_aleatorio($letra,$longitud,$numero) {
        //Agregamos los números aleatorios
        for ($i=1; $i <= $longitud ; $i++) { 
            //rand() recoge un número al azar, de 0-9
            $aleatorio = rand(0,9);
            //Concatenamos la letra con el valor de $aleatorio
            $letra.=$aleatorio;
        }
        return $letra."-".$numero;
     }

     /*-------- Función limpiar cadenas --------*/
     //Evita inyecciones sql
     protected static function limpiar_cadena($cadena) {
        //Eliminamos espacios que estén antes o después del texto
        $cadena = trim($cadena);
        //Eliminar las barras invertidas
        $cadena = stripcslashes($cadena);
        //Nos permite definir una cadena que debe ser reemplazada 
        //con otra dentro de una frase o palabra
        $cadena = str_ireplace("<stript>", "", $cadena);
        $cadena = str_ireplace("</stript>", "", $cadena);
        $cadena = str_ireplace("<stript src", "", $cadena);
        $cadena = str_ireplace("<stript type=", "", $cadena);
        $cadena = str_ireplace("SELECT * FROM", "", $cadena);
        $cadena = str_ireplace("DELETE FROM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("DROP TABLE", "", $cadena);
        $cadena = str_ireplace("DROP DATABASE", "", $cadena);
        $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena = str_ireplace("SHOW TABLES", "", $cadena);
        $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
        $cadena = str_ireplace("<?php", "", $cadena);
        $cadena = str_ireplace("?>", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace("<", "", $cadena);
        $cadena = str_ireplace(">", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("==", "", $cadena);
        $cadena = str_ireplace(";", "", $cadena);
        $cadena = str_ireplace("::", "", $cadena);
        //Eliminar las barras invertidas
        $cadena = stripcslashes($cadena);
        //Eliminamos espacios que estén antes o después del texto
        $cadena = trim($cadena);
        return $cadena;
     }

     /*-------- Función verificar datos --------*/
     protected static function verificar_datos($filtro,$cadena) {
        //preg_match: realiza una comparación con una expresión regular
        if(preg_match("/^".$filtro."$/", $cadena)) {
            return false;
        } else {
            return true;
        }
     }

     


}