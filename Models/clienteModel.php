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

    /*-------- Modelo eliminar cliente --------*/
    protected static function eliminar_cliente_modelo($id) {
        $conexion = mainModel::conectar();
        $sql = "DELETE FROM cliente WHERE cliente_id=:ID";
        $query = $conexion->prepare($sql);

        $query->bindParam(":ID",$id);
        $query->execute();
        return $query;
    }

    /*-------- Modelo datos cliente --------*/
    protected static function datos_cliente_modelo($tipo,$id) {
        if ($tipo=="Unico") {
            $conexion = mainModel::conectar();
            $sql = "SELECT * FROM cliente WHERE cliente_id=:ID";
            $query = $conexion->prepare($sql);

            $query->bindParam(":ID",$id);
        } 
        elseif ($tipo=="Conteo") {
            $conexion = mainModel::conectar();
            //Contamos los clientes registrados
            $sql = "SELECT cliente_id FROM cliente";
            $query = $conexion->prepare($sql);
        }
        $query->execute();
        return $query;
    }

    /*-------- Modelo actualizar cliente --------*/
    protected function actualizar_cliente_modelo($datos) {
        $conexion = mainModel::conectar();
        $sql = "UPDATE cliente SET
                cliente_dni=:DNI,
                cliente_nombre=:Nombre,
                cliente_apellido=:Apellido,
                cliente_telefono=:Telefono,
                cliente_direccion=:Direccion
                WHERE cliente_id=:ID";
        
        $query = $conexion->prepare($sql);

        $query->bindParam(":DNI",$datos['DNI']);
        $query->bindParam(":Nombre",$datos['Nombre']);
        $query->bindParam(":Apellido",$datos['Apellido']);
        $query->bindParam(":Telefono",$datos['Telefono']);
        $query->bindParam(":Direccion",$datos['Direccion']);
        $query->bindParam(":ID",$datos['ID']);

        $query->execute();
        return $query;
    }

 }