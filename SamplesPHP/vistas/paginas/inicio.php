<?php 

if(!isset($_SESSION["validarIngreso"])){

	echo '<script>window.location = "index.php?pagina=ingreso";</script>';

	return;

}else{

	if($_SESSION["validarIngreso"] != "ok"){

		echo '<script>window.location = "index.php?pagina=ingreso";</script>';

		return;
	}
	
}


$usuarios = ControladorFormularios::ctrSeleccionarRegistros(null, null);
//echo '<pre>';print_r($usuarios);echo '</pre>';


?>


<h1>Inicio</h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Email</th>
			<th>Fecha</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($usuarios as $key=> $value): ?>

		<tr>
			<td><?php echo $value["nombre"]; ?></td>
			<td><?php echo $value["email"]; ?></td>
			<td><?php echo $value["fecha"]; ?></td>
			<td>
				<div class="btn-group">
					<div class="px-1">
						<a href="index.php?pagina=editar&token=<?php echo $value["token"]; ?>" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>	
					</div>

					<form method="post">

					<input type="hidden" value="<?php echo $value["token"]; ?>" name="eliminarRegistro">
					
					<button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

					<?php

						$eliminar = new ControladorFormularios();
						$eliminar -> ctrEliminarRegistro();

					?>

				</form>	
									
				</div>
			</td>
		</tr>

		<?php endforeach ?>

	</tbody>
</table>
