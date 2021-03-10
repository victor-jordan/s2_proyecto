<?php
http_response_code(404);
echo "<h1>Error 404</h1><p>Página no encontrada</p><br>";
/*echo $_SERVER['REQUEST_URI'] . '<br>';
echo $_SERVER['DOCUMENT_ROOT'] . '<br>';
echo __DIR__ . '<br>';*/
die();
?>