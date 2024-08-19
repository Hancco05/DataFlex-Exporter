<?php
// Configuración de la base de datos
$host = 'localhost';
$db   = 'mi_proyecto_db'; // Cambia 'mi_proyecto_db' por el nombre de tu base de datos
$user = 'root';           // Cambia 'root' por tu usuario de MySQL
$pass = '';               // Cambia '' por tu contraseña de MySQL
$charset = 'utf8mb4';     // Opcional, para compatibilidad con caracteres UTF-8

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

?>
