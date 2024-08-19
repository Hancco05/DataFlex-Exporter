<?php
require '../config/config.php';
require '../lib/fpdf.php'; // Asegúrate de que esta ruta es correcta

if (isset($_POST['export'])) {
    $exportType = $_POST['export'];

    // Obtener todos los registros de la base de datos
    $sql = "SELECT * FROM datos";
    $stmt = $pdo->query($sql);
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si los registros se han recuperado correctamente
    if (!$registros) {
        die('No se encontraron registros en la base de datos.');
    }

    if ($exportType == 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="datos.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, array('ID', 'Nombre', 'Fecha', 'Edad', 'Tipo', 'Descripción'));

        foreach ($registros as $registro) {
            fputcsv($output, $registro);
        }
        fclose($output);
        exit;
    } elseif ($exportType == 'excel') {
        // Si necesitas exportar a Excel, necesitarás una librería compatible como PhpSpreadsheet
    } elseif ($exportType == 'pdf') {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Agregar título
        $pdf->Cell(0, 10, 'Datos Exportados', 0, 1, 'C');

        // Agregar encabezados de tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 10, 'ID', 1);
        $pdf->Cell(40, 10, 'Nombre', 1);
        $pdf->Cell(30, 10, 'Fecha', 1);
        $pdf->Cell(20, 10, 'Edad', 1);
        $pdf->Cell(20, 10, 'Tipo', 1);
        $pdf->Cell(50, 10, 'Descripción', 1);
        $pdf->Ln();

        // Agregar datos de la tabla
        $pdf->SetFont('Arial', '', 10);
        foreach ($registros as $registro) {
            $pdf->Cell(30, 10, $registro['id'], 1);
            $pdf->Cell(40, 10, $registro['nombre'], 1);
            $pdf->Cell(30, 10, $registro['fecha'], 1);
            $pdf->Cell(20, 10, $registro['edad'], 1);
            $pdf->Cell(20, 10, $registro['tipo'], 1);
            $pdf->Cell(50, 10, $registro['descripcion'], 1);
            $pdf->Ln();
        }

        $filename = 'datos.pdf';

        // Enviar el archivo al navegador
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $pdf->Output('php://output', 'I');
        exit;
    }
} else {
    // Redirigir de nuevo a la página principal si no se establece el parámetro 'export'
    header("Location: ../public/index.php");
    exit;
}
?>
