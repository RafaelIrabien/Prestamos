<?php
 require_once "mainModel.php";

 class clienteModel extends mainModel {

    /*-------- Modelo agregar cliente --------*/
    protected static function agregar_cliente_modelo($datos) {
        $conexion = mainModel::conectar();
        $sql = "INSERT INTO cliente(cliente_dni,cliente_nombre,cliente_apellido,cliente_telefono,cliente_direccion) 
                VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion)";

        $query = $conexion->prepare($sql);

        $query->bindParam(":DNI",$datos['DNI']);
        $query->bindParam(":Nombre",$datos['Nombre']);
        $query->bindParam(":Apellido",$datos['Apellido']);
        $query->bindParam(":Telefono",$datos['Telefono']);
        $query->bindParam(":Direccion",$datos['Direccion']);
        $query->execute();

        return $query;
    }

 }