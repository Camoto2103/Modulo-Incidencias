<?php 
session_start();
include('../Models/conexion.php');
require('../Controllers/sql_historico.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historico</title>
    <link rel="stylesheet" href="../public/CSS/historico.css">
</head>
<body>
    <div class="principal">
        <div class="img">
            <img src="img/Logo-Tigo.png" alt="" class="logo">
        </div>
        <h1 class="header">HISTORICO</h1>
        <table id="tablate">
            <thead>
                <tr>
                    <th>N° de historico</th>
                    <th>N° de incidencia</th>
                    <th>Comentario</th>
                    <th>Fecha Actualizacion</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["id_incidencia"] . "</td>";
                    echo "<td>" . $row["comentarios"] . "</td>";
                    echo "<td><div class='url'>" . $row["fecha_actualizacion"] . "</div></td>";
                    echo "<td><a><button>Actualizar</button></a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
