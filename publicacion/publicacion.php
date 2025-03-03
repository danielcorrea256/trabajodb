<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Entidad análoga a MECANICO (PUBLICACION)</h1>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="publicacion_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="identificador" class="form-label">Identificador</label>
            <input type="number" class="form-control" id="identificador" name="identificador" required>
        </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <input type="text" class="form-control" id="contenido" name="contenido" required>
        </div>

        <div class="mb-3">
            <label for="publication_rank" class="form-label">PublicationRank</label>
            <input type="number" class="form-control" id="publication_rank" name="publication_rank" required>
        </div>

        <div class="mb-3">
            <label for="imagen_link" class="form-label">Link Imagen</label>
            <input type="text" class="form-control" id="imagen_link" name="imagen_link">
        </div>
        
        <!-- Consultar la lista de temas de debate y desplegarlos -->
        <div class="mb-3">
            <label for="identificador_tema_de_debate" class="form-label">Tema de Debate</label>
            <select name="identificador_tema_de_debate" id="identificador_tema_de_debate" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../tema_de_debate/tema_de_debate_select.php");
                
                // Verificar si llegan datos
                if($resultadoTemaDeDebate):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoTemaDeDebate as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["identificador"]; ?>"><?= $fila["titulo"]; ?></option>

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
require("publicacion_select.php");
            
// Verificar si llegan datos
if($resultadoPublicacion and $resultadoPublicacion->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Identificador</th>
                <th scope="col" class="text-center">Titulo</th>
                <th scope="col" class="text-center">Contenido</th>
                <th scope="col" class="text-center">PublicationRank</th>
                <th scope="col" class="text-center">Link Imagen</th>
                <th scope="col" class="text-center">Identificador Tema De Debate</th>
                <th scope="col" class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoPublicacion as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["identificador"]; ?></td>
                <td class="text-center"><?= $fila["titulo"]; ?></td>
                <td class="text-center"><?= $fila["contenido"]; ?></td>
                <td class="text-center"><?= $fila["publication_rank"]; ?></td>
                <td class="text-center"><?= $fila["imagen_link"]; ?></td>
                <td class="text-center"><?= $fila["identificador_tema_de_debate"]; ?></td>
                
                <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                <td class="text-center">
                    <form action="publicacion_delete.php" method="post">
                        <input hidden type="text" name="identificadorEliminar" value="<?= $fila["identificador"]; ?>">
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