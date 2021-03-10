<?php
class mdlAlquilerPelicula
{
    var $id;
    var $id_alquiler;
    var $id_pelicula;
    var $alquilado_en;
    var $devuelto_en;
    var $monto;

    public function actualizarMontoFactura(){
        ;
    }

    public function tiempoAlquilado(){
    	if (is_null($this -> devuelto_en)) {
            $hoy = date("Y-m-d");
        } else {
            $hoy = $this -> devuelto_en;
        }
    	
        $tiempo = date_diff(date_create($this -> alquilado_en), date_create($hoy)) -> format('%R%a');
    	return str($tiempo) . " dias.";
    }
}
?>