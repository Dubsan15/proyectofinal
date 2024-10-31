<?php
// Conexión a la base de datos
include 'conexion.php';

// Inicializar variables para mensaje y tipo de alerta
$mensaje = "";
$tipo_alerta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar los datos del formulario
    $nombre_producto = trim($_POST['nombre_producto']);
    $precio = trim($_POST['precio']);
    $cantidad = trim($_POST['cantidad']);
    $presentacion = trim($_POST['presentacion']);
    $marca = trim($_POST['marca']);
    $fecha_produccion = $_POST['fecha_produccion'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    // Validación simple
    if (empty($nombre_producto) || empty($precio) || empty($cantidad) || empty($presentacion) || empty($marca) || empty($fecha_produccion) || empty($fecha_vencimiento)) {
        $mensaje = "Todos los campos son obligatorios.";
        $tipo_alerta = "danger"; // Alerta de error
    } else if (!is_numeric($precio) || !is_numeric($cantidad)) {
        $mensaje = "El precio y la cantidad deben ser numéricos.";
        $tipo_alerta = "danger"; // Alerta de error
    } else {
        // Preparar la consulta para evitar inyecciones SQL
        $stmt = $conexion->prepare("INSERT INTO Productos (nombre_producto, precio, cantidad, presentacion, marca, fecha_produccion, fecha_vencimiento) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdissss", $nombre_producto, $precio, $cantidad, $presentacion, $marca, $fecha_produccion, $fecha_vencimiento); // "sdissss" significa: string, double, integer, string, string, string, string

        if ($stmt->execute()) {
            $mensaje = "Producto agregado exitosamente.";
            $tipo_alerta = "success"; // Alerta de éxito
        } else {
            $mensaje = "Error al agregar el producto: " . $stmt->error;
            $tipo_alerta = "danger"; // Alerta de error
        }

        $stmt->close(); // Cerrar la declaración
    }
}

$conexion->close(); // Cerrar la conexión
?>

<!-- HTML del formulario para agregar productos -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Agregar Producto</h2>

        <!-- Mostrar mensaje de alerta si existe -->
        <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipo_alerta; ?>"><?= $mensaje; ?></div>
        <?php endif; ?>

        <form method="POST" action="Agregar_Producto.php">
            <div class="form-group">
                <label for="nombre_producto">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" placeholder="Ejemplo: Televisor Samsung 42 pulgadas" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" placeholder="Ejemplo: 399.99" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ejemplo: 10" required>
            </div>
            <div class="form-group">
                <label for="presentacion">Presentación</label>
                <input type="text" class="form-control" id="presentacion" name="presentacion" placeholder="Ejemplo: Caja, Botella, Bolsa" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" placeholder="Ejemplo: Samsung, LG, Apple" required>
            </div>
            <div class="form-group">
                <label for="fecha_produccion">Fecha de Producción</label>
                <input type="date" class="form-control" id="fecha_produccion" name="fecha_produccion" required>
            </div>
            <div class="form-group">
                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
            <a href="index.php" class="btn btn-secondary">Volver a la Página Principal</a>
        </form>
    </div>

    <!-- Incluir Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>