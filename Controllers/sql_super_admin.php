<?php
include('../Models/conexion.php');

// Determina el número total de registros
$sql = "SELECT COUNT(*) as total FROM inci_incidencias";
$result = $conn->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC); 
$totalRegistros = $row['total'];

// Define la cantidad de registros por página
$registrosPorPagina = 10;

// Calcula el número total de páginas
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Obtiene el número de página actual
if (isset($_GET['pagina'])) {
    $paginaActual = $_GET['pagina'];
} else {
    $paginaActual = 1;
}

// Calcula el inicio del conjunto de resultados a mostrar
$inicio = ($paginaActual - 1) * $registrosPorPagina;

// Realiza la consulta paginada
$sql = "SELECT id, nombre_herramienta, correo, descripcion, url, estatus, fecha_registro FROM inci_incidencias LIMIT $inicio, $registrosPorPagina";
$result = $conn->query($sql);
