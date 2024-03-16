<?php
include('../Models/conexion.php');

if (isset($_GET['id_incidencia'])) {
    $id_incidencia = $_GET['id_incidencia'];

    $sql = "SELECT * FROM inci_historico_incidencias WHERE id_incidencia = $id_incidencia";
    $result = $conn->query($sql);
    
    if (!$result) {
        echo "Error en la consulta SQL: " . $conn->errorInfo()[2];
    }
} else {
    echo "No hay incidencia por mostrar";
}
?>

