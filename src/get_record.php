<?php
// Obtener los datos del registro a modificar
$sqlEdit = "SELECT * FROM datos WHERE id = :id";
$stmtEdit = $pdo->prepare($sqlEdit);
$stmtEdit->bindParam(':id', $editId);
$stmtEdit->execute();
$editData = $stmtEdit->fetch(PDO::FETCH_ASSOC);
?>
