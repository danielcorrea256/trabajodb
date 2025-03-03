<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Consulta 1</h1>

<p class="mt-3">
    Mostrar los datos de los tres comentarios con mayor CommentRank junto con los datos de las publicaciones asociados a cada una de estos comentarios.
</p>

<?php
// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
$query = $query = <<<SQL
SELECT
    comentario1.identificador AS comment_identificador,
    comentario1.contenido AS comment_contenido,
    comentario1.fecha_creacion AS comment_fecha_creacion,
    comentario1.comment_rank AS comment_rank,
    comentario1.identificador_publicacion AS comment_identificador_publicacion,
    comentario1.identificador_comentario_anterior AS comment_identificador_comentario_anterior,
    publicacion.identificador AS publicacion_identificador,
    publicacion.titulo AS publicacion_titulo,
    publicacion.contenido AS publicacion_contenido,
    publicacion.publication_rank as publication_rank,
    publicacion.imagen_link as publication_imagen_link,
    publicacion.identificador_tema_de_debate as identificador_tema_de_debate
FROM
    comentario AS comentario1
    INNER JOIN 
    publicacion ON comentario1.identificador_publicacion = publicacion.identificador
WHERE (
    SELECT COUNT(*) FROM comentario AS comentario2 
        WHERE (
            comentario2.comment_rank > comentario1.comment_rank 
            OR (comentario2.comment_rank = comentario1.comment_rank AND comentario2.identificador < comentario1.identificador)
        )
) < 3
ORDER BY comment_rank DESC, comment_identificador ASC;
SQL;

// Ejecutar la consulta
$resultadoC1 = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<?php
// Verificar si llegan datos
if($resultadoC1 and $resultadoC1->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Identificador Comentario</th>
                <th scope="col" class="text-center">Contenido Comentario</th>
                <th scope="col" class="text-center">Fecha Creacion Comentario</th>
                <th scope="col" class="text-center">CommentRank</th>
                <th scope="col" class="text-center">Identificador Comentario Anterior</th>
                <th scope="col" class="text-center">Identificador Publicacion</th>
                <th scope="col" class="text-center">Titulo Publicacion</th>
                <th scope="col" class="text-center">Contenido Publicacion</th>
                <th scope="col" class="text-center">PublicationRank</th>
                <th scope="col" class="text-center">Link Imagen</th>
                <th scope="col" class="text-center">Identificador Tema De Debate</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoC1 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["comment_identificador"]; ?></td>
                <td class="text-center"><?= $fila["comment_contenido"]; ?></td>
                <td class="text-center"><?= $fila["comment_fecha_creacion"]; ?></td>
                <td class="text-center"><?= $fila["comment_rank"]; ?></td>
                <td class="text-center"><?= $fila["comment_identificador_comentario_anterior"]; ?></td>
                <td class="text-center"><?= $fila["publicacion_identificador"]; ?></td>
                <td class="text-center"><?= $fila["publicacion_titulo"]; ?></td>
                <td class="text-center"><?= $fila["publicacion_contenido"]; ?></td>
                <td class="text-center"><?= $fila["publication_rank"]; ?></td>
                <td class="text-center"><?= $fila["publication_imagen_link"]; ?></td>
                <td class="text-center"><?= $fila["identificador_tema_de_debate"]; ?></td>
            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<!-- Mensaje de error si no hay resultados -->
<?php
else:
?>

<div class="alert alert-danger text-center mt-5">
    No se encontraron resultados para esta consulta
</div>

<?php
endif;

include "../includes/footer.php";
?>