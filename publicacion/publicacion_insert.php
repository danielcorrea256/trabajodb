<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$id_publicacion = $_POST["id_publicacion"];
$titulo = $_POST["titulo"];
$contenido = $_POST["contenido"];
$publication_rank = $_POST["publication_rank"];
$archivo_adjunto = $_POST["archivo_adjunto"];
$id_tema = $_POST["id_tema"];

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO `publicacion`(`id_publicacion`,`titulo`, `contenido`, `publication_rank`, `archivo_adjunto`, `id_tema`) VALUES ('$id_publicacion', '$titulo', '$contenido', '$publication_rank', '$archivo_adjunto', '$id_tema')";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: publicacion.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);