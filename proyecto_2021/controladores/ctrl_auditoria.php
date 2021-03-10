<?php
require_once('ctrl_conexion.php');
require_once(__DIR__ . '\..\modelos\mdl_auditoria.php');

/**
 * Clase para controlar los eventos de todas las tablas
 */
class ctrlAuditoria{
    public $auditorias;

    public function obtenerTodos(){
        $this -> auditorias = array();
        $conexion = new ctrlBaseDatos();
        $objeto = new mdlAuditoria;
        $sentencia = "select id, fecha, tabla, accion from auditoria;";
        try{
            $resultado = $conexion->getConexion()->query($sentencia);
            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $objeto->id = $fila['id'];
                $objeto->fecha = $fila['fecha'];
                $objeto->tabla = $fila['tabla'];
                $objeto->accion = $fila['accion'];
                $this -> auditorias[] = $objeto;
                $objeto = new mdlAuditoria;
            }
        }  catch (PDOException $e){
            echo "Falla:" . $e->getMessage();
        }
        $conexion->__destruct();
    }

    public function insertarAuditoria(mdlAuditoria $objeto){
        try{
            $bd = new ctrlBaseDatos();
            $conexion = $bd -> getConexion();
            $sentencia = "INSERT INTO auditoria (fecha, tabla, accion) VALUES ('%s', '%s', '%s');";
            $ejecutar = sprintf($sentencia, $objeto -> fecha, $objeto -> tabla, $objeto -> accion);
            $conexion -> beginTransaction();
            $conexion -> exec($ejecutar);
            $conexion -> commit();
        } catch (PDOException $e){
            $conn->rollback();
            echo "Falla:" . $e->getMessage();
        }
        $conexion = null;
    }
}
?>