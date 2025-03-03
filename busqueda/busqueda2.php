<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Búsqueda 2</h1>

<p class="mt-3">
    ii) El identificador de un tema de debate. Se debe mostrar todos los datos de los comentarios de ese tema de debate que han sufrido modificaciones
</p>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <!-- En esta caso, el Action va a esta mismo archivo -->
    <form action="busqueda2.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="identificador" class="form-label">Identificador </label>
            <input type="number" class="form-control" id="identificador" name="identificador" required>
        </div>

        <button type="submit" class="btn btn-primary">Buscar</button>

    </form>
    
</div>

<?php
// Dado que el action apunta a este mismo archivo, hay que hacer eata verificación antes
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

    // Crear conexión con la BD
    require('../config/conexion.php');

    $identificador = $_POST["identificador"];

    // Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
    $query = <<<SQL
    SELECT 
        comentario1.* 
    FROM 
        comentario AS comentario1, publicacion, tema_de_debate 
    WHERE (  
        comentario1.id_publicacion = publicacion.id_publicacion and publicacion.id_tema = tema_de_debate.id_tema
        AND EXISTS(SELECT * FROM comentario AS comentario2 WHERE comentario2.id_comentario_anterior = comentario1.id_comentario)
        AND tema_de_debate.id_tema = '$identificador'
    );
    SQL;
    // Ejecutar la consulta
    $resultadoB2 = mysqli_query($conn, $query) or die(mysqli_error($conn));

    mysqli_close($conn);

    // Verificar si llegan datos
    if($resultadoB2 and $resultadoB2->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Identificador Comentario</th>
                <th scope="col" class="text-center">Contenido</th>
                <th scope="col" class="text-center">Fecha Creacion</th>
                <th scope="col" class="text-center">CommentRank</th>
                <th scope="col" class="text-center">Identificador Publicacion</th>
                <th scope="col" class="text-center">Identificador Comentario Anterior</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoB2 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["id_comentario"]; ?></td>
                <td class="text-center"><?= $fila["contenido"]; ?></td>
                <td class="text-center"><?= $fila["fecha_creacion"]; ?></td>
                <td class="text-center"><?= $fila["comment_rank"]; ?></td>
                <td class="text-center"><?= $fila["id_publicacion"]; ?></td>
                <td class="text-center"><?= $fila["id_comentario_anterior"]; ?></td>
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
endif;

include "../includes/footer.php";
?>