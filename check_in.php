<?php
session_start();
require_once './utils/functions.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
}

// Obtener la información del usuario desde la sesión
$usuario = $_SESSION['usuario'];

// Obtener los proyectos activos
$proyectos = obtenerProyectosActivos();

if (filter_has_var(INPUT_POST, 'check_in')) {
    $id_proyecto = filter_input(INPUT_POST, 'id_proyecto', FILTER_VALIDATE_INT);
    if (registrarCheckIn($usuario['id'], $id_proyecto)) {
        $success = "Check-in realizado con éxito.";
    } else {
        $error = "Error al realizar el check-in. Por favor, inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Check In - TimeTrack</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php include_once "./components/icons.php"  ?>

</head>

<body>
    <?php include_once "./components/header.php"; ?>
    <main class="container">
        <h1>Realizar Check In</h1>
        <?php if (isset($success)) { ?>
            <p class="success"><?php echo $success ?></p>
        <?php } else if (isset($error)) {  ?>
            <p class="error"><?php echo $error ?></p>
        <?php } ?>
        <form method="post">
            <label for="id_proyecto">Selecciona un Proyecto:</label>
            <select name="id_proyecto" id="id_proyecto" required>
                <option value="" disabled selected>Seleccione un proyecto</option>
                <?php foreach ($proyectos as $proyecto) { ?>
                    <option value="<?php echo $proyecto['id']; ?>"><?php echo $proyecto['nombre']; ?></option>
                <?php } ?>
            </select>
            <button type="submit" name="check_in">Check In</button>
        </form>
        <form action="dashboard.php" method="post">
            <button type="submit" class="button">Volver al Dashboard</button>
        </form>

    </main>
    <?php include_once "./components/footer.php"; ?>
</body>

</html>