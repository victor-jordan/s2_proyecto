<?php
class mdlPelicula
{
    var $id;
    var $titulo;
    var $genero;
    var $anho;
    var $director;
    var $formato;
    var $precio_alquiler;

    public function descripcion(){
        return "{$this -> titulo} / {$this -> anho} - {$this -> formato}";
    }
}
?>