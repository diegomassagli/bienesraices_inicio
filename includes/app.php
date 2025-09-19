<?php 
 // App queda como el archivo principal que llama a funciones/bases de datos y a las clases creadas

require 'funciones.php';
require 'config/database.php';
require __DIR__ . "/../vendor/autoload.php";

// Conectarnos a la BD
$db = conectarDB();

use App\Propiedad;

Propiedad::setDB($db);         // al ser un metodo static no requiere instanciarse y queda disponible para todos los objetos que se creen y no cambia.



