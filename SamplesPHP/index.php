<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

//echo "Hello world!<br>";

#EL INDEX: en el mostramos la salida de las vistas al usuario y tambien a traves de el enviamos las distintas acciones que el usuario envie al controlador.

#require() establece que el codigo del archivo invocado es requerido, es decir, obligatorio para el funcionamiento del programa.

require_once "controladores/plantilla.controlador.php";
require_once "controladores/formularios.controlador.php";
require_once "modelos/formularios.modelo.php";

$plantilla = new controladorPlantilla();
$plantilla -> ctrTraerPlantilla();