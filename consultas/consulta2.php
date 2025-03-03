<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Consulta 2</h1>

<p class="mt-3">
    Debe mostrar el identificador y el titulo de los temas de debate de los dos temas de debate que tienen la mayor cantidad de comentarios.
</p>

<?php
// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
$query = <<<SQL
SELECT 
    tema_de_debate.id_tema as identificador, tema_de_debate.titulo as titulo
FROM 
    comentario as comentario1, publicacion, tema_de_debate
WHERE (
    comentario1.id_publicacion = publicacion.id_publicacion
    AND
    publicacion.id_tema = tema_de_debate.id_tema
)
GROUP BY 
    tema_de_debate.id_tema, tema_de_debate.titulo
HAVING (
        SELECT 
            COUNT(*) 
        FROM
        (
            SELECT 
                publicacion_aux.id_tema
            FROM 
                comentario as comentario_aux
                INNER JOIN
                publicacion as publicacion_aux ON comentario_aux.id_publicacion = publicacion_aux.id_publicacion
            GROUP BY
                publicacion_aux.id_tema
            HAVING (
                COUNT(comentario_aux.id_comentario) > COUNT(comentario1.id_comentario)
                OR
                (COUNT(comentario_aux.id_comentario) = COUNT(comentario1.id_comentario) AND publicacion_aux.id_tema < tema_de_debate.id_tema)
            ) 
        ) as temas_de_debate_con_mayor_comentarios
) < 2
ORDER BY COUNT(*) DESC, tema_de_debate.id_tema ASC;
SQL;

// Ejecutar la consulta
$resultadoC2 = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<?php
// Verificar si llegan datos
if($resultadoC2 and $resultadoC2->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Identificador</th>
                <th scope="col" class="text-center">Titulo</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoC2 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["identificador"]; ?></td>
                <td class="text-center"><?= $fila["titulo"]; ?></td>
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