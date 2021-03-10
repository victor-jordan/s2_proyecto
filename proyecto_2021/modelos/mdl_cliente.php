<?php
class mdlCliente
{
    var $id;
    var $documento;
    var $dv;
    var $nombres;
    var $apellidos;
    var $fecha_ingreso;

    public function nombreCompleto(){
        return "{$this -> nombres} {$this -> apellidos}";
    }

    public function documentoFormateado(){
    	if (is_null($this -> dv)) {
    		return str($this -> documento);
    	} else {
    		return str($this -> documento) . "-" . str($this -> dv);
    	}
    }

    public function verAntiguedad(){
    	$hoy = date("Y-m-d");
    	$antiguedad = date_diff(date_create($this -> fecha_ingreso), date_create($hoy)) -> format('%y');
    	return str($antiguedad) . " años.";
    }
}
?>