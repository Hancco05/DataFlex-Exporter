<?php
// Obtener el valor de búsqueda, si existe
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Modificar la consulta SQL para incluir el filtro de búsqueda
$sql = "SELECT * FROM datos";
if ($search) {
    $sql .= " WHERE nombre LIKE :search OR descripcion LIKE :search OR tipo LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $pdo->query($sql);
}

// Obtener todos los registros de la base de datos
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
