<?php
session_start();
require_once './utils/functions.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
}

// Verificar si se ha enviado el formulario de creación de proyecto
if (filter_has_var(INPUT_POST, "crear_proyecto")) {
    if (
        filter_has_var(INPUT_POST, "nombre") && !empty($nombre = filter_input(INPUT_POST, 'nombre')) &&
        filter_has_var(INPUT_POST, "descripcion") && !empty($descripcion = filter_input(INPUT_POST, 'descripcion')) &&
        filter_has_var(INPUT_POST, "estado") && !empty($estado = filter_input(INPUT_POST, 'estado'))
    ) {
        // Crear el nuevo proyecto
        if (crearProyecto($nombre, $descripcion, $estado)) {
            $success = "¡Proyecto creado exitosamente!";
        }
    } else {
        $error = "Error al crear el proyecto. Por favor, inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Proyecto - TimeTrack</title>
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php include_once "./components/icons.php"  ?>
</head>

<body>
    <?php include_once "./components/header.php"; ?>

    <main class="container">
        <h1>Crear Proyecto</h1>

        <!-- Mostrar mensajes de éxito o error -->
        <?php if (isset($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>

        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <!-- Formulario para crear un nuevo proyecto -->
        <form action="create_project.php" method="post">
            <label for="nombre">Nombre del Proyecto:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="En Espera">En Espera</option>
                <option value="En Progreso">En Progreso</option>
                <option value="Finalizado">Finalizado</option>
            </select>

            <button type="submit" name="crear_proyecto">Crear Proyecto</button>
        </form>

        <form action="dashboard.php" method="post">
            <button type="submit" class="button">Volver al Dashboard</button>
        </form>
    </main>

    <?php include_once "./components/footer.php" ?>
</body>

</html>