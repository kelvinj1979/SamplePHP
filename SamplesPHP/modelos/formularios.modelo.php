<?php

require_once "conexion.php";

class ModeloFormularios{
	/*=====================
	Registro
	=====================*/

	static public function mdlRegistro($tabla, $datos){

		#statement : declaracion

		#prepare() Prepara una sentencia SQL para ser ejecutada por el metodo PDOStetament::execute(). La sentencia SQL puede conectar cero o mas marcadores de parametros con nombre (:name) o signos de interrogacion(?) por los cuales los valores reales seran sustituidos cuando la sentencia sea ejecutada. Ayuda a prevenir iyecciones SQL eliminado la necesidad de entrecomillar manualmente los parametros.

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(token, nombre, email, password) VALUES(:token, :nombre, :email, :password)");

		#bindParam() Vincula una variable de PHP a un parametro de sustitucion con nombre o de signo de interrogacion correspondiente de la sentencia SQL que fue usada para preparar la sentencia.

		
		$stmt->bindParam(":token", $datos["token"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);

		if($stmt->execute()){
			
			return "ok";

		}else{
			
			print_r(Conexion::conectar()->errorInfo());

		}

		$stmt->close();

		$stmt=null;

	}

	/*--------------------------------
	  Seleccionar Registros
	  --------------------------------*/

	static public function mdlSelecionarRegistros($tabla, $item, $valor){

		
		if ($item == null && $valor == null){

			$stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha FROM $tabla");

			$stmt->execute();

			return $stmt -> fetchAll();

			$stmt->close();

			$stmt=null;

		}else{

			
			$stmt = Conexion::conectar()->prepare("SELECT *,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt -> fetch();

			$stmt->close();

			$stmt=null;


		}
		

	}


	/*--------------------------------
	  Actualizar Registros
	  --------------------------------*/

	static public function mdlActualizarRegistro($tabla, $datos){


		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, email = :email, password = :password WHERE token = :token ");
		
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":token", $datos["token"], PDO::PARAM_STR);

		if($stmt->execute()){
			
			return "ok";

		}else{
			
			print_r(Conexion::conectar()->errorInfo());

		}

		$stmt->close();

		$stmt=null;

	}

	/*=============================================
	Eliminar Registro
	=============================================*/
	static public function mdlEliminarRegistro($tabla, $valor){
	
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE token = :token");

		$stmt->bindParam(":token", $valor, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());

		}

		$stmt->close();

		$stmt = null;	

	}


}