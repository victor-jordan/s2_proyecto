<?php
class mdlAlquiler
{
    var $id;
    var $id_cliente;
    var $fecha_alquiler;
    var $nro_factura;
    var $monto;
    var $creado_por;

    public function identificarDocumento(){
        if(is_null($nro_factura)){
            return "Ticket N° " . str($this -> id);
        } else {
            return "Factura N° " . $this -> nro_factura;
        }
    }
}
?>