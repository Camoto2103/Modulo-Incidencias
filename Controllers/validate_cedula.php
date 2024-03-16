<?php
session_start();

include('../Models/conexion.php');

try {
    // Validar y obtener la cédula de entrada
    $cedula = filter_input(INPUT_POST, "cedula");

    if (!$cedula) {
        exit(json_encode(["success" => false, "message" => "Cédula no válida"]));
    }

    // Preparar la consulta SQL con INNER JOIN para obtener nombres en lugar de IDs
    $sql = "SELECT u.nombre, u.cedula, c.nombre_canal as Canal, ch.cargo_homologado as Cargo
    FROM mu_maestro_usuarios u
    INNER JOIN mu_maestro_canales c ON u.id_canal = c.id
    INNER JOIN mu_maestro_cargos_homologados ch ON u.id_cargo_homologado = ch.id
    WHERE cedula = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        exit(json_encode(["success" => false, "message" => "Error en la consulta"]));
    }

    // Enlazar la cédula como parámetro y ejecutar la consulta
    $stmt->bindParam(1, $cedula, PDO::PARAM_STR);
    $stmt->execute();

    // Obtener el resultado como un arreglo asociativo
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        $_SESSION["cedula"] = $cedula;
        echo json_encode(["success" => true, "message" => "Cédula válida", "userData" => $userData]);
    } else {
        echo json_encode(["success" => false, "message" => "La cédula no se encontro"]);
    }
    
} catch (PDOException $e) {

    exit(json_encode(["success" => false, "message" => "Error en la conexión a la base de datos: " . $e->getMessage()]));
} finally {

    $conn = null; // Cerrar la conexión PDO
}
