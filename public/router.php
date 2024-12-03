<?php
/**
 * Para que sean visibles tus rutas, 
 * escribe la ruta del archivo vista 
 * y asigna un nombre a la ruta 
 */

$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');

switch($request){
    case '/':
        require_once __DIR__.'/../src/views/public/home.php';
        break;
    case '/cartelera':
        require_once __DIR__.'/../src/views/public/billboard.php';
        break;
    case '/eventos':
        require_once __DIR__.'/../src/views/public/events.php';
        break;
    case '/server_status':
        require_once __DIR__.'/../src/views/public/status.php';
        break;

    // Rutas de administracion
    case '/admin/panel':
        require_once __DIR__.'/../src/views/public/admin/panel.php';
        break;
    case '/admin/iniciar_sesion':
        require_once __DIR__.'/../src/views/public/admin/login.php';
        break;
    default:
        http_response_code(404);
        //Hacer una vista de 404
        break;

}