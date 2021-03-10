<?php
function limpiarDatos($dato){
    // Limpar datos de cross site scripting
    $retornar = trim($dato); // Eliminar espacios adelante y atras
    $retornar = strip_tags($dato); // escapar posibles etiquetas html
    $retornar = stripslashes($dato); // escapar barras \ /
    $retornar = htmlspecialchars($dato); // escapar caracteres especiales

    return $retornar;
}
?>