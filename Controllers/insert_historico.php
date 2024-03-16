<?php
require("../Models/conexion.php");

if (isset($_GET['id'])) {
    $id_incidencia = $_GET['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comentario = $_POST["comentario"];
    $id_incidencia = $_POST["id_incidencia"];
    $id_user = $_POST["id_user"];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Actualizar el estado de la incidencia en la tabla de incidencias a "Solucionado"
        $nuevo_estado = "SOLUCIONADO"; // Estado deseado
        $sql_actualizar_estado = "UPDATE inci_incidencia SET estatus = :nuevo_estado WHERE id = :id_incidencia";
        $stmt_actualizar_estado = $conn->prepare($sql_actualizar_estado);
        $stmt_actualizar_estado->bindParam(':nuevo_estado', $nuevo_estado, PDO::PARAM_STR);
        $stmt_actualizar_estado->bindParam(':id_incidencia', $id_incidencia, PDO::PARAM_INT);
        $stmt_actualizar_estado->execute();

        // Inserta un registro en la tabla historico_incidencias
        $insert_query = "INSERT INTO inci_historico_incidencias (id_user_management, id_incidencia, comentarios, fecha_actualizacion, estatus)
VALUES (:id_user, :id_incidencia, :comentarios, NOW(), '$nuevo_estado');"; // Asigna directamente el valor de $nuevo_estado
        $stmt = $conn->prepare($insert_query);
        $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->bindParam(":id_incidencia", $id_incidencia, PDO::PARAM_INT);
        $stmt->bindParam(":comentarios", $comentario, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: ../Views/gestor.php");
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
} else {
    echo "No se recibieron datos del formulario.";
}
