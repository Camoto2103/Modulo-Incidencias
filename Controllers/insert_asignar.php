<?php
require("../Models/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $id_incidencia = $_POST["id_incidencia"]; //Input hidden del formulario
    $id_user= $_POST["id_user"]; // Debe coincidir con el nombre del campo en el formulario del select

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Consulta preparada para insertar la asignación en la tabla de asignaciones
        $sql_asignacion = "INSERT INTO inci_asignaciones (id_incidencia, id_user_management) VALUES (:id_incidencia, :id_user)";
        $stmt_asignacion = $conn->prepare($sql_asignacion);
        $stmt_asignacion->bindParam(':id_incidencia', $id_incidencia, PDO::PARAM_INT);
        $stmt_asignacion->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt_asignacion->execute();
        
        // Actualizar el estado de la incidencia en la tabla de incidencias a "Asignada"
        $nuevo_estado = "ASIGNADO"; // Estado deseado
        $sql_actualizar_estado = "UPDATE inci_incidencias SET estatus = :nuevo_estado WHERE id = :id_incidencia";
        $stmt_actualizar_estado = $conn->prepare($sql_actualizar_estado);
        $stmt_actualizar_estado->bindParam(':nuevo_estado', $nuevo_estado, PDO::PARAM_STR);
        $stmt_actualizar_estado->bindParam(':id_incidencia', $id_incidencia, PDO::PARAM_INT);
        $stmt_actualizar_estado->execute();
        
        // Redirigir de vuelta a la página de administrador o a donde sea necesario
        header("Location: ../Views/super_admin.php");
        exit();
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>

