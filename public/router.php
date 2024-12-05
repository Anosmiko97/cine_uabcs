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

    // Rutas para cartelera
    case '/admin/cartelera':
        require_once __DIR__.'/../src/views/public/admin/movie/billboard.php';
        break;
    case "/admin/cartelera/editar":
        require_once __DIR__.'/../src/controllers/admin/movie/edit.php';
        break;
    case "/admin/cartelera/eliminar":
        require_once __DIR__.'/../src/controllers/admin/movie/delete.php';
        break;
    case "/admin/cartelera/agregar":
        require_once __DIR__.'/../src/controllers/admin/movie/add.php';
        break;
    case "/admin/cartelera/agregar_horario":
        require_once __DIR__.'/../src/controllers/admin/movie/addShedule.php';
        break;
    

    case '/admin/eventos':
        require_once __DIR__.'/../src/views/public/admin/panel.php';
        break;

    // Rutas de usuarios
    case '/admin/usuarios':
        require_once __DIR__.'/../src/views/public/admin/users/users.php';
        break;
    case "/admin/usuarios/editar":
        require_once __DIR__.'/../src/controllers/admin/users/edit.php';
        break;
    case "/admin/usuarios/eliminar":
        require_once __DIR__.'/../src/controllers/admin/users/delete.php';
        break;
    case "/admin/usuarios/agregar":
        require_once __DIR__.'/../src/controllers/admin/users/add.php';
        break;

    // Rutas para gestionar perfil de administrador
    case '/admin/configurar_perfil':
        require_once __DIR__.'/../src/controllers/admin/configure.php';
        break;

    // Rutas para session
    case '/admin/cerrar_session':
        require_once __DIR__.'/../src/controllers/admin/logout.php';
        break;
    case '/admin/iniciar_sesion':
        require_once __DIR__.'/../src/views/public/admin/login.php';
        break;
    
    // Rutas para registro de asistencias
    case '/admin/registrar_asistencias':
        require_once __DIR__.'/../src/views/public/admin/registerAttendance.php';
        break;
    case '/admin/registrar_asistencias/post':
        require_once __DIR__.'/../src/views/public/admin/postAttendance.php';
        break;

    default:
        http_response_code(404);
        //Hacer una vista de 404
        break;
}