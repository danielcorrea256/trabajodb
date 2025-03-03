<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Entidad análoga a REPARACION (COMENTARIO)</h1>
<h3>Nota: Al insertar un comentario como version corregio de un comentario original, ambos comentarios tiene que hacer referencia a la misma publicacion</h1>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="comentario_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="id_comentario" class="form-label">Identificador</label>
            <input type="number" class="form-control" id="id_comentario" name="id_comentario" required>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <input type="text" class="form-control" id="contenido" name="contenido" required>
        </div>

        <div class="mb-3">
            <label for="fecha_creacion" class="form-label">Fecha Creacion</label>
            <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" required>
        </div>


        <div class="mb-3">
            <label for="comment_rank" class="form-label">CommentRank</label>
            <input type="number" class="form-control" id="comment_rank" name="comment_rank" required>
        </div>

         <!-- Consultar la lista de clientes y desplegarlos -->
        <div class="mb-3">
            <label for="id_publicacion" class="form-label">Publicacion</label>
            <select name="id_publicacion" id="id_publicacion" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../publicacion/publicacion_select.php");
                
                // Verificar si llegan datos
                if($resultadoPublicacion):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoPublicacion as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["id_publicacion"]; ?>"><?= $fila["titulo"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>

         <!-- Consultar la lista de clientes y desplegarlos -->
         <div class="mb-3">
            <label for="id_comentario_anterior" class="form-label">Comentario Original</label>
            <select name="id_comentario_anterior" id="id_comentario_anterior" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../comentario/comentario_select.php");
                
                // Verificar si llegan datos
                if($resultadoComentario):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoComentario as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["id_comentario"]; ?>"><?= $fila["contenido"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Agregar</button>

    </form>
    
</div>

<?php
// Importar el código del otro archivo
require("comentario_select.php");

// Verificar si llegan datos
if($resultadoComentario and $resultadoComentario->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Identificador</th>
                <th scope="col" class="text-center">Contenido</th>
                <th scope="col" class="text-center">Fecha Creacion</th>
                <th scope="col" class="text-center">CommentRank</th>
                <th scope="col" class="text-center">Identificador Publicacion</th>
                <th scope="col" class="text-center">Identificador Comentario Anterior</th>
                <th scope="col" class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoComentario as $fila):
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

                <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                <td class="text-center">
                    <form action="comentario_delete.php" method="post">
                        <input hidden type="text" name="identificadorEliminar" value="<?= $fila["id_comentario"]; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>

            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<?php
endif;

include "../includes/footer.php";
?>