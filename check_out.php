<?php
session_start();
require_once './utils/functions.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
}

// Obtener la lista de proyectos asignados al trabajador
$id_trabajador = $_SESSION['usuario']['id'];
$proyectos_asignados = obtenerProyectosAsignados($id_trabajador);


// Verificar si se ha enviado el formulario de check-out
if (filter_has_var(INPUT_POST, "check_out")) {
    $id_proyecto = filter_input(INPUT_POST, 'proyecto', FILTER_VALIDATE_INT);

    // Registrar el check-out
    if (registrarCheckOut($id_trabajador, $id_proyecto)) {
        $success = "Check-out realizado exitosamente.";
    } else {
        $error = "Error al realizar el check-out.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Check-Out - TimeTrack</title>
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php include_once "./components/icons.php"  ?>
</head>

<body>
    <?php include_once "./components/header.php"; ?>

    <main class="container">
        <h1>Check-Out</h1>

        <?php if (isset($success)) { ?>
            <p class="success"><?php echo $success ?></p>
        <?php } else if (isset($error)) {  ?>
            <p class="error"><?php echo $error ?></p>
        <?php } ?>

        <form method="post">
            <label for="proyecto">Seleccione un proyecto para realizar el check-out:</label>
            <select name="proyecto" id="proyecto" required>
                <option value="" selected disabled>Seleccione un proyecto</option>
                <?php foreach ($proyectos_asignados as $proyecto) { ?>
                    <option value="<?php echo $proyecto['id']; ?>"><?php echo $proyecto['nombre']; ?></option>
                <?php } ?>
            </select>

            <button type="submit" name="check_out">Check-Out</button>
        </form>
        <form action="dashboard.php" method="post">
            <button type="submit" class="button">Volver al Dashboard</button>
        </form>
    </main>

    <?php include_once "./components/footer.php" ?>
</body>

</html>