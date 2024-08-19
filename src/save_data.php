<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Inserción de datos en la base de datos
    $sql = "INSERT INTO datos (nombre, fecha, edad, tipo, descripcion) VALUES (:nombre, :fecha, :edad, :tipo, :descripcion)";
    $stmt = $pdo->prepare($sql);

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

