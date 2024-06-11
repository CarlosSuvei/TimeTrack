<?php
session_start();
require_once './utils/functions.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] != 2) {
    header("Location: index.php");
}

// Obtener la información del usuario desde la sesión
$usuario = $_SESSION['usuario'];

// // Verificar si se ha proporcionado el ID del proyecto a editar
if (!filter_has_var(INPUT_GET, "id") || empty(filter_input(INPUT_GET, "id"))) {
    header("Location: dashboard.php");
}

// Obtener el ID del proyecto desde la URL
$id_proyecto = filter_input(INPUT_GET, "id");

// Obtener la información del proyecto
$proyecto = obtenerProyectoPorId($id_proyecto);



// Procesar el formulario de edición si se envió
if (filter_has_var(INPUT_POST, 'editar_proyecto')) {
    if (
        filter_has_var(INPUT_POST, "nombre") && !empty($nombre = filter_input(INPUT_POST, 'nombre')) &&
        filter_has_var(INPUT_POST, "descripcion") && !empty($descripcion = filter_input(INPUT_POST, 'descripcion')) &&
        filter_has_var(INPUT_POST, "estado") && !empty($estado = filter_input(INPUT_POST, 'estado'))
    ) {

        // Actualizar el proyecto en la base de datos
        if (actualizarProyecto($id_proyecto, $nombre, $descripcion, $estado)) {
            $success = "Proyecto actualizado correctamente.";
            
        } else {
            $error = "Error al actualizar el proyecto. Por favor, inténtelo de nuevo.";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Proyecto - TimeTrack</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <?php include_once "./components/header.php" ?>
    <main class="container">
        <h1>Editar Proyecto</h1>
        <?php if (isset($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form method="post">
            <label for="nombre">Nombre del Proyecto:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $proyecto['nombre']; ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo $proyecto['descripcion']; ?></textarea>

            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="En espera" <?php if ($proyecto['estado'] == "En espera") echo "selected"; ?>>En espera</option>
                <option value="En progreso" <?php if ($proyecto['estado'] == "En progreso") echo "selected"; ?>>En progreso</option>
                <option value="Finalizado" <?php if ($proyecto['estado'] == "Finalizado") echo "selected"; ?>>Finalizado</option>
            </select>

            <button type="submit" name="editar_proyecto">Guardar Cambios</button>
        </form>
        <form action="dashboard.php" method="post">
            <button type="submit" class="button">Volver al Dashboard</button>
        </form>
    </main>
    <?php include_once "./components/footer.php" ?>
</body>

</html>