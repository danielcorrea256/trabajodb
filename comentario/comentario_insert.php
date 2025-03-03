<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$identificador = $_POST["identificador"];
$contenido = $_POST["contenido"];
$fecha_creacion = $_POST["fecha_creacion"];
$comment_rank = $_POST["comment_rank"];
$identificador_publicacion = $_POST["identificador_publicacion"];
$identificador_comentario_anterior = $_POST["identificador_comentario_anterior"];

if (empty($identificador_comentario_anterior)) {
	// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
	$query = "INSERT INTO `comentario`(`identificador`,`contenido`, `fecha_creacion`, `comment_rank`, `identificador_publicacion`) VALUES ('$identificador', '$contenido', '$fecha_creacion', '$comment_rank', '$identificador_publicacion')";
}
else {
	// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
	$query = "INSERT INTO `comentario`(`identificador`,`contenido`, `fecha_creacion`, `comment_rank`, `identificador_publicacion`, `identificador_comentario_anterior`) VALUES ('$identificador', '$contenido', '$fecha_creacion', '$comment_rank', '$identificador_publicacion', '$identificador_comentario_anterior')";
}

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: comentario.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);