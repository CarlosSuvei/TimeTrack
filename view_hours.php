<?php
session_start();
require_once './utils/functions.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Obtener la lista de registros de horas del usuario actual
$id_trabajador = $_SESSION['usuario']['id'];
$registros_horas = obtenerRegistrosHoras($id_trabajador);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Horas Registradas - TimeTrack</title>
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php include_once "./components/icons.php"  ?>

</head>

<body>
    <?php include_once "./components/header.php"; ?>

    <main class="container">
        <h1>Horas Registradas</h1>

        <?php if (empty($registros_horas)) { ?>
            <p>No hay registros de horas para mostrar.</p>
        <?php } else { ?>
            <table>
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Fecha</th>
                        <th>Hora de Entrada</th>
                        <th>Hora de Salida</th>
                        <th>Tiempo Trabajado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros_horas as $registro) : ?>
                        <tr>
                            <td><?php echo $registro['nombre_proyecto']; ?></td>
                            <td><?php echo $registro['fecha']; ?></td>
                            <td><?php echo $registro['hora_entrada']; ?></td>
                            <td><?php echo $registro['hora_salida']; ?></td>
                            <td><?php echo calcularTiempoTrabajado($registro['hora_entrada'], $registro['hora_salida']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php } ?>

        <form action="dashboard.php" method="post">
            <button type="submit" class="button">Volver al Dashboard</button>
        </form>
    </main>

    <?php include_once "./components/footer.php" ?>
</body>

</html>