<?php
// Establece la conexión a la base de datos
require('../Models/conexion.php');

// Verifica si se proporcionó el parámetro de ID de incidencia
if (isset($_GET['id'])) {
    $id_incidencia = $_GET['id'];

    // Consulta SQL para recuperar el contenido del adjunto de la incidencia
    $sql = "SELECT adjunto FROM inci_incidencia WHERE id = :id_incidencia";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_incidencia', $id_incidencia, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Recupera el contenido del adjunto
        $row = $stmt->fetch();
        $adjunto = $row['adjunto'];
        
        // Obtén la extensión del archivo (por ejemplo, .jpg, .png, .pdf, etc.)
        $extension = pathinfo($adjunto, PATHINFO_EXTENSION);
        
        // Define el tipo MIME basado en la extensión del archivo
        $mime_types = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
            // Agrega más tipos MIME según las extensiones que necesites
        ];
        
        $tipo_adjunto = isset($mime_types[$extension]) ? $mime_types[$extension] : 'application/octet-stream';

        // Define la cabecera como un archivo descargable
        header('Content-Type: ' . $tipo_adjunto);
        header('Content-Disposition: inline; filename='.$adjunto);
        
        // header('Content-Length: ' . filesize($)); //Para descargar y cuanto se demora

        readfile("../../imagenes/".$adjunto);

    } else {
        echo "No se encontró el adjunto para la incidencia especificada.";
    }
} else {
    echo "ID de incidencia no proporcionado.";
}

// Cierra la conexión a la base de datos
$conn = null;
?>
