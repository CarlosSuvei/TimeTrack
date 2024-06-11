<?php
session_start();
require_once './utils/functions.php';

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 2) {
    header("Location: index.php");
}

// Verificar si se ha proporcionado el ID del trabajador a editar
if (!filter_has_var(INPUT_GET, "id") || empty(filter_input(INPUT_GET, "id"))) {
    header("Location: manage_workers.php");
}

// Obtener el ID del trabajador desde el formulario
$id_trabajador = filter_input(INPUT_GET, "id");

// Obtener la información del trabajador
$trabajador = obtenerTrabajadorPorId($id_trabajador);


// Procesar el formulario de edición si se envió
if (filter_has_var(INPUT_POST, 'editar_trabajador')) {
    if (
        filter_has_var(INPUT_POST, "nombre") && !empty($nombre = filter_input(INPUT_POST, 'nombre')) &&
        filter_has_var(INPUT_POST, "email") && !empty($email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) &&
        filter_has_var(INPUT_POST, "rol") && !empty($rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_NUMBER_INT))
    ) {

        // Actualizar el trabajador en la base de datos
        if (actualizarTrabajador($id_trabajador, $nombre, $email, $rol)) {
            $_SESSION['success'] = "Trabajador actualizado correctamente.";
            header("Location: manage_workers.php");
            
        } else {
            $error = "Error al actualizar el trabajador. Por favor, inténtelo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Trabajador - TimeTrack</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <?php include_once "./components/header.php" ?>
    <main class="container">
        <h1>Editar Trabajador</h1>
        <?php if (isset($success)) { ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php } ?>
        <?php if (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
        <form method="post">
            <label for="nombre">Nombre del Trabajador:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $trabajador['nombre']; ?>" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo $trabajador['correo']; ?>" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="1" <?php if ($trabajador['id_rol'] == 1) echo "selected"; ?>>Trabajador</option>
                <option value="2" <?php if ($trabajador['id_rol'] == 2) echo "selected"; ?>>Administrador</option>
            </select>

            <button type="submit" name="editar_trabajador">Guardar Cambios</button>
        </form>
        <form action="manage_workers.php" method="post">
            <button type="submit" class="button">Volver a la Gestión de Trabajadores</button>
        </form>
    </main>
    <?php include_once "./components/footer.php" ?>
</body>

</html>
