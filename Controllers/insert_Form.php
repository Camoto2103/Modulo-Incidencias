<?php
include('../Models/conexion.php');

// Obtiene los datos del formulario
$cedula = $_POST['cedula'];
$correo = $_POST['correo'];
$multimedia = $_POST['multimedia'];
$url = $_POST['url'];
$descripcion = $_POST['descripcion'];

// Verifica si se proporcionó un archivo adjunto
if ($_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
    // Obtiene la información del archivo
    $adjunto = $_FILES['adjunto'];
    $nombre_adjunto = $adjunto['name'];
    $ruta_adjunto = '../../imagenes/' . $nombre_adjunto; // Ruta de destino para guardar el archivo

    // Obtiene la extensión del archivo
    $extension = pathinfo($nombre_adjunto, PATHINFO_EXTENSION);

    // Define una lista de extensiones válidas para videos y pantallazos (puedes personalizarla)
    $extensionesValidas = array('mp4', 'mov', 'jpg', 'jpeg', 'png');

    // Verifica si la extensión del archivo está en la lista de extensiones válidas
    if (in_array(strtolower($extension), $extensionesValidas)) {
        // Mueve el archivo cargado al directorio de destino
        if (move_uploaded_file($adjunto['tmp_name'], $ruta_adjunto)) {
            // El archivo se movió correctamente
        } else {
            // Hubo un error al mover el archivo
            header('location:../Views/formulario.php');
            exit;
        }
    } else {
        // Extensión no válida, redirecciona a una página de error
        header('location:../Views/formulario.php');
        exit;
    }
} else {
    // No se proporcionó un archivo adjunto
    header('location:../Views/formulario.php');
    exit;
}

/* SE DEBE DE CORREGIR CON LA BASE DE DATOS DE INFOPOS */

// Prepara una consulta para verificar si existe un usuario con la misma cédula
$checkUserQuery = $conn->prepare("SELECT cedula FROM mu_maestro_usuarios WHERE cedula = ?");
$checkUserQuery->bindParam(1, $cedula, PDO::PARAM_STR);
$checkUserQuery->execute();
$checkUserQuery->setFetchMode(PDO::FETCH_ASSOC);

// Comprueba si se encontró al menos un usuario con la misma cédula
if ($checkUserQuery->rowCount() > 0) {
    // Prepara una consulta para insertar los datos en la tabla de incidencias
    $insertQuery = $conn->prepare("
    INSERT INTO inci_incidencias (cedula_usuario, correo, nombre_herramienta, descripcion, url, adjunto, estatus)
    SELECT ?, ?, ?, ?, ?, ?, 'PENDIENTE'
");

    // Pasa el nombre del archivo como valor para adjunto
    $insertQuery->bindParam(1, $cedula, PDO::PARAM_STR);
    $insertQuery->bindParam(2, $correo, PDO::PARAM_STR);
    $insertQuery->bindParam(3, $multimedia, PDO::PARAM_STR);
    $insertQuery->bindParam(4, $descripcion, PDO::PARAM_STR);
    $insertQuery->bindParam(5, $url, PDO::PARAM_STR);
    $insertQuery->bindParam(6, $nombre_adjunto, PDO::PARAM_STR); // Aquí usamos $nombre_adjunto

    // Ejecuta la consulta de inserción
    if ($insertQuery->execute()) {
        // Obtiene el ID de la última inserción
        $lastInsertId = $conn->lastInsertId();

        // Inicia la sesión y almacena el ID de la última inserción y el correo en variables de sesión
        session_start();
        $_SESSION['lastInsertId'] = $lastInsertId;
        $_SESSION['correo'] = $correo;

        header('location:../Views/ticket.php');

    } else {
        header('location:../Views/formulario.php');

    }
} else {
    header('location:../Views/formulario.php');
    
}

// Cierra las consultas y la conexión PDO
$conn = null;
