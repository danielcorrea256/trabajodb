<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$id_tema = $_POST["id_tema"];
$titulo = $_POST["titulo"];

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO `tema_de_debate`(`id_tema`,`titulo`) VALUES ('$id_tema', '$titulo')";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: tema_de_debate.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);