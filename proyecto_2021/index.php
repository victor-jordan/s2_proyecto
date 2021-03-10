<?php
// Index php hara todas las veces de un ruteador
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/proyecto_2021/index':
        require(__DIR__ . '/vistas/vst_index.php');
        break;
    
    case '/proyecto_2021/':
        require(__DIR__ . '/vistas/vst_index.php');
        break;

    case '/proyecto_2021/usuarios':
        require(__DIR__ . '/vistas/vst_usuarios.php');
        break;

    case '/proyecto_2021/peliculas':
        require(__DIR__ . '/vistas/vst_peliculas.php');
        break;

    case '/proyecto_2021/alquileres':
        require(__DIR__ . '/vistas/vst_alquileres.php');
        break;

    default:
        require(__DIR__ . '/vistas/vst_404.php');
        break;
}
?>