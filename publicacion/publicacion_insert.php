<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$identificador = $_POST["identificador"];
$titulo = $_POST["titulo"];
$contenido = $_POST["contenido"];
$publication_rank = $_POST["publication_rank"];
$imagen_link = $_POST["imagen_link"];
$identificador_tema_de_debate = $_POST["identificador_tema_de_debate"];

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO `publicacion`(`identificador`,`titulo`, `contenido`, `publication_rank`, `imagen_link`, `identificador_tema_de_debate`) VALUES ('$identificador', '$titulo', '$contenido', '$publication_rank', '$imagen_link', '$identificador_tema_de_debate')";

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