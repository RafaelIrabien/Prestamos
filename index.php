<?php

    require_once "./Config/APP.php";
    require_once "./Controllers/vistasController.php";

    $plantilla = new vistasController();
    $plantilla->obtener_plantilla_controlador();