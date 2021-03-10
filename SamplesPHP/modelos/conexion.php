<?php

class Conexion{

	static public function conectar(){
 
		#PDO("nombre del servidor; nombre de la DB", "usuario", "contrasena")

		$link =  new PDO("mysql:host=localhost;dbname=curso-php", "root", "");
		$link->exec("set names utf8");

		return $link;

	}
}