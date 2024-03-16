<?php
session_start();

require('../Models/conexion.php');
require('../Controllers/sql_gestor.php');

if (isset($_SESSION['id_user_gestor']) && isset($_SESSION['cedula_user_gestor'])) {
    $id_user = $_SESSION['id_user_gestor'];
    $cedula = $_SESSION['cedula_user_gestor'];
} else {
    echo "Asegúrate de haber iniciado sesión correctamente.";
    exit();
}


// Cierra la conexión a la base de datos
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor</title>
    <link rel="stylesheet" href="../public/css/admin2.css">
    <!-- BOOSTRAP 5.0.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>

<body>
    <div class="img">
        <img src="img/Logo-Tigo.png" alt="" class="logo">
    </div>

    <h1 class="header">ASIGNACIONES</h1>
    <h5><?php echo $id_user ?></h5>
    <h5><?php echo $cedula ?></h5>
    <div class="reports">
        <!-- Botones de pestañas -->
        <button class="tab-button" onclick="showTab('asignadas')">Incidencias Asignadas</button>
        <button class="tab-button" onclick="showTab('realizadas')">Incidencias Realizadas</button>

        <!-- Tabla de incidencias asignadas -->
        <div id="asignadas" class="tab">
            <table id="tablate" class="center-table">
                <thead>
                    <tr>
                        <th>Nombre Herramienta</th>
                        <th>URL</th>
                        <th>Descripción</th>
                        <th>Adjunto</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php
                    // Recupera las incidencias asignadas desde la sesión
                    $incidencias_asignadas = isset($_SESSION['incidencias_asignadas']) ? $_SESSION['incidencias_asignadas'] : array();

                    if (!empty($incidencias_asignadas)) {
                        foreach ($incidencias_asignadas as $incidencia) {
                            // Asegúrate de que solo se muestren las incidencias asignadas aquí
                            if ($incidencia["estatus"] == "Asignada") {
                                echo "<tr>";
                                echo "<td>" . $incidencia['nombre_herramienta'] . "</td>";
                                echo "<td>" . $incidencia['url'] . "</td>";
                                echo "<td>" . $incidencia['descripcion'] . "</td>";
                                echo "<td class='center-cell'>";
                                echo "<a href='../Controllers/ver_adjunto.php?id=" . $incidencia['id_incidencia'] . "' target='_blank'><button class='Button-Ver'>Ver</button></a>";
                                echo "</td>";
                                echo "<td>" . $incidencia['estatus'] . "</td>";
                                echo "<td>";
                                echo "<a href='reasignar_incidencia.php?id_incidencia=" . $incidencia['id_incidencia'] . "'><button class='Button-Reasignar'>Reasignar</button></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='6'>No se encontraron asignaciones de incidencias.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla de incidencias realizadas -->
        <div id="realizadas" class="tab">
            <table id="tablate" class="center-table">
                <thead>
                    <tr>
                        <th>Nombre Herramienta</th>
                        <th>URL</th>
                        <th>Descripción</th>
                        <th>Adjunto</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Recupera las incidencias asignadas desde la sesión
                    $incidencias_realizadas = isset($_SESSION['incidencias_realizadas']) ? $_SESSION['incidencias_realizadas'] : array();

                    if (!empty($incidencias_realizadas)) {
                        foreach ($incidencias_realizadas as $incidencia) {
                            // Asegúrate de que solo se muestren las incidencias realizadas aquí
                            if ($incidencia["estatus"] == "Solucionado") {
                                echo "<tr>";
                                echo "<td>" . $incidencia['nombre_herramienta'] . "</td>";
                                echo "<td>" . $incidencia['url'] . "</td>";
                                echo "<td>" . $incidencia['descripcion'] . "</td>";
                                echo "<td>";
                                echo "<a href='../Controllers/ver_adjunto.php?id=" . $incidencia['id_incidencia'] . "' target='_blank'><button class='Button-Ver'>Ver</button></a>";
                                echo "</td>";
                                echo "<td>" . $incidencia['estatus'] . "</td>";
                                echo "<td>";
                                echo "<a href='historico.php?id_incidencia=" . $incidencia['id_incidencia'] . "'><button class='Button-Historico'>Ver Historico</button></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='6'>No se encontraron realizadas de incidencias.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
     <!-- <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Responder</h2>
            <form action="../Controllers/insert_historico.php" method="POST">
                <input type="hidden" name="id_incidencia" value="">
                <input type="hidden" name="id_user" value="">
                <label for="comentario">Ingrese su comentario:</label>
                <textarea name="comentario" id="comentario" cols="30" rows="10" placeholder="Ingrese el comentario"></textarea>
                <button type="submit" class="btn btn-primary">Compartir</button>
            </form>
        </div>
    </div> -->


    <script src="../public/js/views.js"></script>
</body>

</html>