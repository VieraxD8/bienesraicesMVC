<?php
    
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadControllers;
use Controllers\VendedorControllers;
use Controllers\paginaControllers;
use Controllers\loginControllers;


$router = new Router();

//zona privada
$router->get('/admin', [PropiedadControllers::class, 'index']);
$router->get('/propiedades/crear', [PropiedadControllers::class, 'crear']);
$router->post('/propiedades/crear', [PropiedadControllers::class, 'crear']);
$router->get('/propiedades/actualizar', [PropiedadControllers::class, 'actualizar']);
$router->post('/propiedades/actualizar', [PropiedadControllers::class, 'actualizar']);
$router->post('/propiedades/eliminar', [PropiedadControllers::class, 'eliminar']);


$router->get('/vendedores/crear', [VendedorControllers::class, 'crear']);
$router->post('/vendedores/crear', [VendedorControllers::class, 'crear']);
$router->get('/vendedores/actualizar', [VendedorControllers::class, 'actualizar']);
$router->post('/vendedores/actualizar', [VendedorControllers::class, 'actualizar']);
$router->post('/vendedores/eliminar', [VendedorControllers::class, 'eliminar']);

//zona publica

$router->get('/', [paginaControllers::class, 'index']);
$router->get('/nosotros', [paginaControllers::class, 'nosotros']);
$router->get('/propiedades', [paginaControllers::class, 'propiedades']);
$router->get('/propiedad', [paginaControllers::class, 'propiedad']);
$router->get('/blog', [paginaControllers::class, 'blog']);
$router->get('/entrada', [paginaControllers::class, 'entrada']);
$router->get('/contacto', [paginaControllers::class, 'contacto']);
$router->post('/contacto', [paginaControllers::class, 'contacto']);


//Login y autenticacion


$router->get('/login', [loginControllers::class, 'login']);
$router->post('/login', [loginControllers::class, 'login']);
$router->get('/logout', [loginControllers::class, 'logout']);


$router->ComprobarRutas();

?>