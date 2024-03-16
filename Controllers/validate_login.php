<?php
session_start();
require("../Models/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST["cedula_user"];

    $stmt = $conn->prepare("SELECT id, id_rol FROM inci_user_management WHERE cedula = :cedula");
    $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);

    try {
        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verifica el rol del usuario y redirige en consecuencia
                $id_rol = $user['id_rol'];
                $id_user = $user['id'];

                if ($id_rol == 1) {
                    $_SESSION['id_user'] = $id_user;
                    $_SESSION['cedula_user'] = $cedula;
                    echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso", "redirect" => "../Views/super_admin.php"]);
                    exit();
                } elseif ($id_rol == 2) {
                    $_SESSION['id_user_gestor'] = $id_user;
                    $_SESSION['cedula_user_gestor'] = $cedula;
                    echo json_encode(["success" => true, "message" => "Inicio de sesión Gestor", "redirect" => "../Views/gestor.php"]);
                    exit();
                } else {
                    echo json_encode(["success" => true, "message" => "Rol sin permiso de ingresar", "redirect" => "../Views/login.php"]);
                    exit();
                }
            } else {
                echo json_encode(["success" => false, "message" => "Cédula o contraseña incorrecta"]);
            }
        }
    } catch (PDOException $e) {
        // Manejo de excepciones para la consulta
        $error_message = "Error en la consulta: " . $e->getMessage();
        echo $error_message;
    }
}

// Cierra la conexión a la base de datos
$conn = null;
