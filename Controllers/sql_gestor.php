<?php

if (isset($_SESSION['id_user_gestor']) && isset($_SESSION['cedula_user_gestor'])) {
    $id_user = $_SESSION['id_user_gestor'];
    $cedula = $_SESSION['cedula_user_gestor'];
    
} else {
    echo "Asegúrate de haber iniciado sesión correctamente.";
    exit();
} 

// Consulta para obtener las incidencias asignadas
$sql_asignadas = "SELECT inci_asignaciones.id, inci_incidencias.url, inci_incidencias.nombre_herramienta, inci_incidencias.descripcion, 
inci_incidencias.adjunto, inci_incidencias.estatus, inci_asignaciones.id_incidencia, inci_asignaciones.id_user_management
FROM inci_asignaciones
INNER JOIN inci_incidencias
ON inci_asignaciones.id_incidencia = inci_incidencias.id
WHERE inci_incidencias.estatus = 'Asignada' 
AND inci_asignaciones.id_user_management = :cedula"; // Filtra por incidencias asignadas al usuario

// Consulta para obtener las incidencias realizadas
$sql_realizadas = "SELECT inci_asignaciones.id, inci_incidencias.url, inci_incidencias.nombre_herramienta, inci_incidencias.descripcion, 
inci_incidencias.adjunto, inci_incidencias.estatus, inci_asignaciones.id_incidencia, inci_asignaciones.id_user_management
FROM inci_asignaciones
INNER JOIN inci_incidencias
ON inci_asignaciones.id_incidencia = inci_incidencias.id
WHERE inci_incidencias.estatus = 'Solucionado' 
AND inci_asignaciones.id_user_management = :cedula"; // Filtra por incidencias realizadas por el usuario

// Prepara las consultas
$stmt_asignadas = $conn->prepare($sql_asignadas);
$stmt_realizadas = $conn->prepare($sql_realizadas);

// Enlaza la variable $cedula_usuario a las consultas
$stmt_asignadas->bindParam(':cedula', $cedula, PDO::PARAM_STR);
$stmt_realizadas->bindParam(':cedula', $cedula, PDO::PARAM_STR);

// Ejecutar ambas consultas
if ($stmt_asignadas->execute()) {
    $incidencias_asignadas = $stmt_asignadas->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['incidencias_asignadas'] = $incidencias_asignadas;
} else {
    die("Error en la consulta de incidencias asignadas: " . $stmt_asignadas->errorInfo()[2]);
}

if ($stmt_realizadas->execute()) {
    $incidencias_realizadas = $stmt_realizadas->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['incidencias_realizadas'] = $incidencias_realizadas;
} else {
    die("Error en la consulta de incidencias realizadas: " . $stmt_realizadas->errorInfo()[2]);
}
