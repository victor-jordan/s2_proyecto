<?php
class mdlAuditoria
{
    var $id;
    var $fecha;
    var $tabla;
    var $accion;

    public function mostrarAuditoria(){
        return "Fecha/Hora: " . str($this -> fecha) . ", Accion: " . $this -> tabla . " -> " . $this -> accion;
    }
}
?>