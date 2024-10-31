<?php
// Conexión a la base de datos
include 'conexion.php';


// Inicializar variables
$mensaje = "";
$tipo_alerta = "";

// Consulta para obtener los productos de la base de datos
$query = "SELECT nombre_producto, precio, cantidad FROM articulo";
$resultado = $conexion->query($query);

$productos = [];
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $productos[] = $row;
    }
} else {
    $mensaje = "No hay productos disponibles.";
    $tipo_alerta = "info"; // Mensaje informativo si no hay productos
}

$conexion->close(); // Cerrar la conexión
?>

<!-- HTML para mostrar los productos -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Disponibles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Productos</h2>

        <!-- Mostrar mensaje de alerta si no hay productos -->
        <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipo_alerta; ?>"><?= $mensaje; ?></div>
        <?php endif; ?>

        <!-- Mostrar tabla de productos si hay productos disponibles -->
        <?php if (!empty($productos)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td><?= number_format($producto['precio'], 2); ?></td>
                            <td><?= htmlspecialchars($producto['cantidad']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Botón para redirigir al formulario de agregar producto -->
        <a href="form_agregar_producto.php" class="btn btn-primary">Agregar Nuevo Producto</a>
    </div>

    <!-- Incluir Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>