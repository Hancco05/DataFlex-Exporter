<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $edad = $_POST['edad'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];

    // Validaciones adicionales
    if (!preg_match("/^[A-Za-z\s]+$/", $nombre)) {
        header("Location: ../public/index.php?error=nombre");
        exit;
    }

    if ($edad < 0 || $edad > 120) {
        header("Location: ../public/index.php?error=edad");
        exit;
    }

    // Actualización de datos en la base de datos
    $sql = "UPDATE datos SET nombre = :nombre, fecha = :fecha, edad = :edad, tipo = :tipo, descripcion = :descripcion WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':edad', $edad);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':descripcion', $descripcion);

    try {
        $stmt->execute();
        header("Location: ../public/index.php?success=true");
    } catch (Exception $e) {
        header("Location: ../public/index.php?error=save");
    }
}
?>
