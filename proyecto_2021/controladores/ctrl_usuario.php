<?php
require_once('ctrl_conexion.php');
require_once('ctrl_auditoria.php');
require_once(__DIR__ . '\..\modelos\mdl_usuario.php');
require_once(__DIR__ . '\..\modelos\mdl_auditoria.php');
/**
 * Clase para controlar los eventos de los usuarios
 */
class ctrlUsuario{
    public $usuario;
    public $usuarios;

    public function obtenerUno($id){
        $this -> usuario = new mdlUsuario;
        $conexion = new ctrlBaseDatos();
        $sentencia = "select id, username, password, nombre, apellido, activo from usuario where id = " . $id . ";";
        try{
            $resultado = $conexion->getConexion()->query($sentencia);
            if ($resultado->rowCount()>0) {
                $fila = $resultado->fetch(PDO::FETCH_ASSOC);
                $this -> usuario->id = $fila['id'];
                $this -> usuario->username = $fila['username'];
                $this -> usuario->password = $fila['password'];
                $this -> usuario->nombre = $fila['nombre'];
                $this -> usuario->apellido = $fila['apellido'];
                $this -> usuario->activo = boolval($fila['activo']);
            }
        }  catch (PDOException $e){
            // Si algo falla mostramos el error
            echo "Falla:" . $e->getMessage();
        }   
        $conexion->__destruct();
    }

    public function obtenerTodos(){
        $this -> usuarios = array();
        $conexion = new ctrlBaseDatos();
        $objeto = new mdlUsuario;
        $sentencia = "select id, username, password, nombre, apellido, activo from usuario;";
        try{
            $resultado = $conexion->getConexion()->query($sentencia);
            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $objeto->id = $fila['id'];
                $objeto->username = $fila['username'];
                $objeto->password = $fila['password'];
                $objeto->nombre = $fila['nombre'];
                $objeto->apellido = $fila['apellido'];
                $objeto->activo = boolval($fila['activo']);
                $this -> usuarios[] = $objeto;
                $objeto = new mdlUsuario;
            }
        }  catch (PDOException $e){
            // Si algo falla mostramos el error
            echo "Falla:" . $e->getMessage();
        }
        $conexion->__destruct();
    }

    public function insertarUsuario(mdlUsuario $objeto){
        try{
            $this -> usuario = $objeto;
            $bd = new ctrlBaseDatos();
            $conexion = $bd -> getConexion();
            $sentencia = "INSERT INTO usuario (username, password, nombre, apellido, activo) VALUES ('%s', '%s', '%s', '%s', %d);";
            $ejecutar = sprintf($sentencia, $this -> usuario -> username, $this -> usuario -> password, $this -> usuario -> nombre, $this -> usuario -> apellido, $this -> usuario -> activo);
            $conexion -> beginTransaction();
            $conexion -> exec($ejecutar);
            $conexion -> commit();

            // Indicamos la auditoria de esta acción
            $ob_audit = new mdlAuditoria;
            $ob_audit -> fecha = date("Y-m-d H:i:s");
            $ob_audit -> tabla = 'usuario';
            $ob_audit -> accion = 'Creado: ' . $this -> usuario -> username;

            $ct_audit = new ctrlAuditoria;
            $ct_audit -> insertarAuditoria($ob_audit);
            
            return "Usuario: " . $this -> usuario -> username . " creado correctamente";
        } catch (PDOException $e){
            // Si algo falla, deshacemos la transacción y mostramos el error
            $conn->rollback(); // termina la transacción
            return "Falla:" . $e->getMessage();
        }
        $conexion = null;
    }

    public function modificarUsuario(mdlUsuario $objeto){
        // Modificaremos todos los campos excepto password que se hará en otro modulo.
        try{
            $this -> usuario = $objeto;
            $bd = new ctrlBaseDatos();
            $conexion = $bd -> getConexion();
            $sentencia = "UPDATE usuario SET username = '%s', nombre = '%s', apellido = '%s', activo = %s WHERE id = %s;";
            $ejecutar = sprintf($sentencia, $this -> usuario -> username, $this -> usuario -> nombre, $this -> usuario -> apellido, (($this -> usuario -> activo) ? '1' : '0'), $this -> usuario -> id);
            $preparado = $conexion -> prepare($ejecutar);
            $preparado -> execute();

            $ob_audit = new mdlAuditoria;
            $ob_audit -> fecha = date("Y-m-d H:i:s");
            $ob_audit -> tabla = 'usuario';
            $ob_audit -> accion = 'Modificado: ' . $this -> usuario -> username;

            $ct_audit = new ctrlAuditoria;
            $ct_audit -> insertarAuditoria($ob_audit);

            return "Usuario: " . $this -> usuario -> username . " modificado correctamente. " . $preparado -> rowCount() . " registros modificados.";
        } catch (PDOException $e){
            return "Falla: " . $e -> getMessage();
        }
        $conexion = null;
    }

    public function modificarPassword(mdlUsuario $objeto){
        // Por razones obvias de seguridad, modificamos el password en un modulo aparte.
        try{
            $this -> usuario = $objeto;
            $conexion = new ctrlBaseDatos();
            $sentencia = "UPDATE usuario SET password = '%s' WHERE id = %d;";
            $ejecutar = sprintf($sentencia, $this -> usuario -> password, $this -> usuario -> id);
            $preparado = $conexion -> prepare($ejecutar);
            $preparado -> execute();

            $audit = new mdlAuditoria;
            $audit -> fecha = str(date("Y-m-d H:i:s"));
            $audit -> tabla = 'usuario';
            $audit -> accion = 'Password modificado: ' . $this -> usuario -> username;

            return "Password de " . $this -> usuario -> username . "modificado correctamente.";
        } catch (PDOException $e){
            return "Falla:" . $sql . "  ->  " . $e -> getMessage();
        }
        $conexion = null;
    }
}
?>