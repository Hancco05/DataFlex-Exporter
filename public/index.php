<?php
// Incluir configuración de la base de datos
require '../config/config.php';

// Obtener el valor de búsqueda, si existe
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Cargar los registros de la base de datos
include '../src/load_records.php';

// Verificar si estamos en modo de edición
$isEdit = false;
if (isset($_GET['id'])) {
    $isEdit = true;
    $editId = $_GET['id'];

    // Obtener los datos del registro a modificar
    include '../src/get_record.php';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario PHP y MySQL</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1><?= $isEdit ? 'Modificar' : 'Formulario' ?></h1>

    <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
        <p style="color: green;">Datos guardados con éxito.</p>
    <?php endif; ?>

    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
        <p style="color: green;">Registro eliminado con éxito.</p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] == 'nombre'): ?>
            <p style="color: red;">Error: El nombre solo debe contener letras y espacios.</p>
        <?php elseif ($_GET['error'] == 'edad'): ?>
            <p style="color: red;">Error: La edad debe estar entre 0 y 120 años.</p>
        <?php elseif ($_GET['error'] == 'save'): ?>
            <p style="color: red;">Error al guardar los datos.</p>
        <?php elseif ($_GET['error'] == 'delete'): ?>
            <p style="color: red;">Error al eliminar el registro.</p>
        <?php elseif ($_GET['error'] == 'missing_id'): ?>
            <p style="color: red;">Error: ID de registro faltante.</p>
        <?php endif; ?>
    <?php endif; ?>

    <form action="../src/save_data.php" method="POST">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']); ?>">
        <?php endif; ?>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required pattern="[A-Za-z\s]+" title="Solo letras y espacios" value="<?= $isEdit ? htmlspecialchars($editData['nombre']) : '' ?>">

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required value="<?= $isEdit ? htmlspecialchars($editData['fecha']) : '' ?>">

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required min="0" max="120" value="<?= $isEdit ? htmlspecialchars($editData['edad']) : '' ?>">

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="A" <?= $isEdit && $editData['tipo'] == 'A' ? 'selected' : '' ?>>A</option>
            <option value="B" <?= $isEdit && $editData['tipo'] == 'B' ? 'selected' : '' ?>>B</option>
            <option value="C" <?= $isEdit && $editData['tipo'] == 'C' ? 'selected' : '' ?>>C</option>
        </select>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?= $isEdit ? htmlspecialchars($editData['descripcion']) : '' ?></textarea>

        <button type="submit"><?= $isEdit ? 'Actualizar' : 'Enviar' ?></button>
    </form>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="index.php" style="margin-top: 20px;">
        <input type="text" name="search" placeholder="Buscar..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Buscar</button>
    </form>

    <h2>Datos Guardados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Edad</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($registros)): ?>
                <?php foreach ($registros as $registro): ?>
                    <tr>
                        <td><?= htmlspecialchars($registro['id']); ?></td>
                        <td><?= htmlspecialchars($registro['nombre']); ?></td>
                        <td><?= htmlspecialchars($registro['fecha']); ?></td>
                        <td><?= htmlspecialchars($registro['edad']); ?></td>
                        <td><?= htmlspecialchars($registro['tipo']); ?></td>
                        <td><?= htmlspecialchars($registro['descripcion']); ?></td>
                        <td>
                            <a href="index.php?id=<?= htmlspecialchars($registro['id']); ?>">Modificar</a> |
                            <a href="../src/delete_data.php?id=<?= htmlspecialchars($registro['id']); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">Borrar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay datos guardados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Botones para exportar a CSV/Excel y PDF -->
    <form method="POST" action="../src/export.php" style="margin-top: 20px;">
        <button type="submit" name="export" value="csv">Exportar a CSV</button>
        <button type="submit" name="export" value="excel">Exportar a Excel</button>
        <button type="submit" name="export" value="pdf">Exportar a PDF</button>
    </form>


    <!-- Formulario para descargar certificado -->
    <form method="POST" action="../src/download_certificate.php" style="margin-top: 20px;">
        <button type="submit" name="download" value="certificado">Descargar Certificado</button>
    </form>
</body>
</html>
