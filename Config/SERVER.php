<?php 
    const SERVER = "localhost";
    const DB = "prestamos";
    const USER = "root";
    const PASSWORD = "";

    //Conectar a la BD
    const SGBD = "mysql:host=".SERVER.";dbname=".DB;

    //Método que vamos a utilizar para procesar por el hash 
    //las contraseñas y parámetros
    const METHOD = "AES-256-CBC";

    //Llave secreta
    const SECRET_KEY = '$PRESTAMOS@2023';

    //Identificador único
    const SECRET_IV = '037970';