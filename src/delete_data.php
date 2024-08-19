<?php
require '../config/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminación de datos de la base de datos
    $sql = "DELETE FROM datos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    try {
        $stmt->execute();
        header("Location: ../public/index.php?deleted=true");
    } catch (Exception $e) {
        header("Location: ../public/index.php?error=delete");
    }
}
?>
