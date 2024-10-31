<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta SQL para obtener los datos de la tabla 'articulo'
$sql = "SELECT * FROM articulo";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización de Artículos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Artículos</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Presentación</th>
            <th>Precio</th>
            <th>Marca</th>
            <th>Fecha de Producción</th>
            <th>Fecha de Vencimiento</th>
        </tr>
        <?php
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Mostrar cada fila de los resultados
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["ID"] . "</td>
                    <td>" . $row["Nombre"] . "</td>
                    <td>" . $row["Presentacion"] . "</td>
                    <td>" . $row["Precio"] . "</td>
                    <td>" . $row["Marca"] . "</td>
                    <td>" . $row["Fecha_Produccion"] . "</td>
                    <td>" . $row["Fecha_Vencimiento"] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay artículos en la base de datos</td></tr>";
        }
        // Cerrar conexión
        $conn->close();
        ?>
    </table>
</body>
</html>
