<?php
// src/download_certificate.php

// Ruta al archivo del certificado
$file = '../certificados/certificado.pdf';

// Verificar si el archivo existe
if (file_exists($file)) {
    // Definir los encabezados para la descarga
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    
    // Leer el archivo y enviarlo al navegador
    readfile($file);
    exit;
} else {
    echo "El archivo no existe.";
}
?>
