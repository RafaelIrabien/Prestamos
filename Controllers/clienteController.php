<?php
    //Detectar cuando se realiza una petición ajax o no
    if ($peticionAjax) {
        require_once "../Models/clienteModel.php";
    } else {
        require_once "./Models/clienteModel.php";
    }

    class clienteController extends clienteModel {
        
    }