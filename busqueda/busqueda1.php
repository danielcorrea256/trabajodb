<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Búsqueda 1</h1>

<p class="mt-3">
    i) El identificador de una publicacion y un rango de fechas (es decir, dos fechas f1 y f2
    (cada fecha con día, mes y año) y f2 &gt;= f1). Se debe mostrar la suma de los commentRank de los
    comentarios correspondientes a esa publicacion durante ese rango de fechas.
</p>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <!-- En esta caso, el Action va a esta mismo archivo -->
    <form action="busqueda1.php" method="post" class="form-group">
        
        <div class="mb-3">
            <label for="identificador" class="form-label">Identifidor Publicacion</label>
            <input type="number" class="form-control" id="identificador" name="identificador" required>
        </div>

        <div class="mb-3">
            <label for="fecha1" class="form-label">Fecha 1</label>
            <input type="date" class="form-control" id="fecha1" name="fecha1" required>
        </div>

        <div class="mb-3">
            <label for="fecha2" class="form-label">Fecha 2</label>
            <input type="date" class="form-control" id="fecha2" name="fecha2" required>
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
    $fecha1 = $_POST["fecha1"];
    $fecha2 = $_POST["fecha2"];

    // Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
    $query = <<<SQL
        SELECT
            publicacion.identificador as identificador, SUM(comentario.comment_rank) AS total
        FROM 
            publicacion JOIN comentario ON publicacion.identificador = comentario.identificador_publicacion
        WHERE 
            comentario.fecha_creacion BETWEEN '$fecha1' and '$fecha2'
        GROUP BY 
            publicacion.identificador
        HAVING
            publicacion.identificador = '$identificador'
        UNION ALL
            SELECT 
                '$identificador' AS identificador, 
                0 AS total
            WHERE NOT EXISTS (
                SELECT 1
                FROM publicacion 
                JOIN comentario ON publicacion.identificador = comentario.identificador_publicacion
                WHERE comentario.fecha_creacion BETWEEN '$fecha1' AND '$fecha2'
                AND publicacion.identificador = '$identificador'
            );
    SQL;

    // Ejecutar la consulta
    $resultadoB1 = mysqli_query($conn, $query) or die(mysqli_error($conn));

    mysqli_close($conn);

    // Verificar si llegan datos
    if($resultadoB1 and $resultadoB1->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Identificador</th>
                <th scope="col" class="text-center">Total</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoB1 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["identificador"]; ?></td>
                <td class="text-center"><?= $fila["total"]; ?></td>
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