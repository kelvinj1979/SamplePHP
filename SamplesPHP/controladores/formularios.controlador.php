<?php 

class ControladorFormularios{

	/*--------------------------------
	  Registros
	  --------------------------------*/

	static public function ctrRegistro(){

		if (isset($_POST["registroNombre"])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["registroNombre"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["registroEmail"]) &&
			   preg_match('/^[0-9a-zA-Z]+$/', $_POST["registroPassword"])){

				//echo $_POST["registroNombre"]; //se utiliza para methodos publicos no estaticos
				$tabla = "registros";
				
				//Token lo utilizamos para controlar los ataques por medio de CSFR (Cross-Site Request Forgeries, es cuando pro vie del inspector de objeto del navegador sueden modificar los valores y actualizar incluso hasta otro registro)
				$token = md5($_POST["registroNombre"]."+".$_POST["registroEmail"]);

				//$encriptarPassword = crypt($_POST["registroPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				/*$datos = array("token" => $token,
								"nombre" => $_POST["registroNombre"],
					           "email" => $_POST["registroEmail"],
					           "password" => $encriptarPassword);*/
				/*sustituido por version de token*/
				$datos = array("token" => $token,
					   		   "nombre" => $_POST["registroNombre"], 
					           "email" => $_POST["registroEmail"], 
					           "password" => $_POST["registroPassword"]); 

				$respuesta = ModeloFormularios::mdlRegistro($tabla, $datos);

				return $respuesta;
			}else{

				$respuesta = "error";

				return $respuesta;
			}
		}
	}



	/*--------------------------------
	  Seleccionar Registros
	  --------------------------------*/
	static public function ctrSeleccionarRegistros($item, $valor){

		$tabla = "registros";

		$respuesta = ModeloFormularios::mdlSelecionarRegistros($tabla, $item, $valor);

		return $respuesta;
		
	}

	/*--------------------------------
	  Ingreso
	  --------------------------------*/

	public function ctrIngreso(){

		if(isset($_POST["ingresoEmail"])){

			$tabla = "registros";
			$item = "email";
			$valor = $_POST["ingresoEmail"];

			$respuesta = ModeloFormularios::mdlSelecionarRegistros($tabla, $item, $valor);

			if($respuesta["email"] ?? "" == $_POST["ingresoEmail"] && $respuesta["password"] == $_POST["ingresoPassword"]){

				$_SESSION["validarIngreso"] = "ok";

				echo '<script>

					if ( window.history.replaceState ) {

						window.history.replaceState( null, null, window.location.href );

					}

					window.location = "index.php?pagina=inicio";

				</script>';

			}else{


				echo '<script>

					if ( window.history.replaceState ) {

						window.history.replaceState( null, null, window.location.href );

					}

				</script>';

				echo '<div class="alert alert-danger">Error al ingresar al sistema, el email o la contraseña no coinciden</div>';
			}
			

		
		}

	}

	/*--------------------------------
	  Actualizar Registros
	  --------------------------------*/

	static public function ctrActualizarRegistro(){

		if (isset($_POST["actualizarNombre"])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["actualizarNombre"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["actualizarEmail"])){



				$usuario = ModeloFormularios::mdlSelecionarRegistros("registros", "token", $_POST["tokenUsuario"]);

				$compararToken = md5($usuario["mombre"]."+".$usuaio["email"]);

				if($compararToken == $_POST["tokenUsuario"]) {

					if ($_POST["actualizarNombre"]!= ""){

						if(preg_match('/^[0-9a-zA-Z]+$/', $_POST["actualizarPassword"])){

							$password = $_POST["actualizarPassword"];

						}

					}else{

						$password = $_POST["passwordActual"];

					}

					
					$tabla = "registros";

					$datos = array("token" => $_POST["tokenUsuario"],
								   "nombre" => $_POST["actualizarNombre"], 
						           "email" => $_POST["actualizarEmail"], 
						           "password" => $password);

					$respuesta = ModeloFormularios::mdlActualizarRegistro($tabla, $datos);

					if($repuesta == "ok"){

						echo '<script>

							if ( window.history.replaceState ) {

								window.history.replaceState( null, null, window.location.href );

							}

							window.location = "index.php?pagina=inicio";

						</script>';

					}

				}else{

					$respuesta = "error";

					return $respuesta;

				}
			}else{

					$respuesta = "error";

					return $respuesta;
			}	
		}

	}

	/*--------------------------------
	  Eliminar Registros
	  --------------------------------*/

	public function ctrEliminarRegistro(){

	  	if(isset($_POST["eliminarRegistro"])){

	  		$usuario = ModeloFormularios::mdlSelecionarRegistros("registros", "token", $_POST["eliminarRegistro"]);

			$compararToken = md5($usuario["nombre"]."+".$usuario["email"]);

			if($compararToken == $_POST["eliminarRegistro"]) {

				$tabla = "registros";
				$valor = $_POST["eliminarRegistro"];

				$respuesta = ModeloFormularios::mdlEliminarRegistro($tabla, $valor);

				if($respuesta == "ok"){

					echo '<script>

						if ( window.history.replaceState ) {

							window.history.replaceState( null, null, window.location.href );

						}

						window.location = "index.php?pagina=inicio";

					</script>';

				}
			}

		}

	}
}