<?php
session_start();
// Realiza la conexión a la base de datos
require('../Models/conexion.php');
require('../Controllers/sql_super_admin.php');

if (isset($_SESSION['id_user']) && isset($_SESSION['cedula_user'])) {
    $id_user = $_SESSION['id_user'];
    $cedula = $_SESSION['cedula_user'];
} else {
    echo "Asegúrate de haber iniciado sesión correctamente.";
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Super Admin</title>
</head>


<body>

    <div class="container">
        <div class="img">
            <img src="../public/img/Logo-Tigo.png" alt="" class="logo">
        </div>
        <h1 class="header">REPORTES</h1>
        <!-- <h5><?php echo $id_user ?></h5> -->

        <table id="tablate">
            <thead>
                <tr>
                    <th>N° de inicidencia</th>
                    <th>Correo Analista</th>
                    <th>Nombre Herramienta</th>
                    <th>Url</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Accion</th>
                </tr>
            </thead>

            <tbody id="tbody">
                <?php
                if (!empty($result)) {
                    foreach ($result as $incidencia) {
                        echo "<tr>";
                        echo "<td>" . $incidencia['id'] . "</td>";
                        echo "<td>" . $incidencia["correo"] . "</td>";
                        echo "<td>" . $incidencia["nombre_herramienta"] . "</td>";
                        echo "<td><div class='url'>" . $incidencia["url"] . "</div></td>";
                        echo "<td><div class='descripcion'>" . $incidencia["descripcion"] . "</div></td>";
                        echo "<td>" . $incidencia["fecha_registro"] . "</td>";
                        echo "<td>" . $incidencia["estatus"] . "</td>";
                        echo "<td>";

                        // Verifica el estado de la incidencia y muestra los botones correspondientes
                        if ($incidencia["estatus"] == "ASIGNADO") {
                            echo "<a href='reasignar_incidencia.php?id=" . $incidencia['id'] . "'><button class='Button-Reasignar'>Reasignar</button></a>";
                        } elseif ($incidencia["estatus"] == "SOLUCIONADO") {
                            echo "<a href='historico.php?id_incidencia=" . $incidencia["id"] . "'><button class='Button-Historico'>Ver Historico</button></a>";
                        } else {
                            echo  "<a href='#' onclick='asignarIncidencia(" . $incidencia['id'] . ")' data-bs-toggle='modal' data-bs-target='#exampleModal'><button class='Button-Asignar'>Asignar</button></a>";
                        }

                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No se encontraron asignaciones de incidencias.</td></tr>";
                }

                ?>
            </tbody>
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php if ($paginaActual > 1) : ?>
                <li class="page-item"><a class="page-link" href="../Views/super_admin.php?pagina=<?= $paginaActual - 1 ?>">Anterior</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                <li class="page-item <?= $i == $paginaActual ? 'active' : '' ?>"><a class="page-link" href="../Views/super_admin.php?pagina=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>

            <?php if ($paginaActual < $totalPaginas) : ?>
                <li class="page-item"><a class="page-link" href="../Views/super_admin.php?pagina=<?= $paginaActual + 1 ?>">Siguiente</a></li>
            <?php endif; ?>
        </ul>
    </nav>

<!-- Modal HTML -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p></p>
                <select name="gestor" id="gestor">
                    <option value="">Selecciona un gestor</option>
                    <?php

                    // Consulta para obtener las personas de la base de datos
                    $sql = "SELECT id, nombre FROM inci_user_management";
                    $stmt = $conn->query($sql);

                    // Verificar el número de filas devueltas por la consulta
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row["id"] . '">' . $row["nombre"] . '</option>';
                        }
                    } else {
                        echo "<option value=''>No se encontraron personas</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <a href="../Controllers/insert_asignar.php"><button type="button" class="btn btn-primary">Enviar</button></a>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>