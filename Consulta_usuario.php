<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Lista de Usuarios</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM usuario";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            while($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>{$fila['ID']}</td>
                        <td>{$fila['Nombre']}</td>
                        <td>{$fila['Correo']}</td>
                        <td>{$fila['Fecha_Registro']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No se encontraron usuarios</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>