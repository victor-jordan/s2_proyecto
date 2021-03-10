<?php
class mdlUsuario
{
    var $id;
    var $username;
    var $password;
    var $nombre;
    var $apellido;
    var $activo;

    public function nombreCompleto(){
        return "{$this -> nombre} {$this -> apellido}";
    }
}
?>