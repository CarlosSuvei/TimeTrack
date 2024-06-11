<?php
session_start();
require_once './utils/functions.php';

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 2) {
    header("Location: index.php");
}

// Inicializar variables de mensajes
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

// Limpiar variables de sesión
unset($_SESSION['success']);
unset($_SESSION['error']);


// Procesar el formulario para crear un nuevo trabajador
if (filter_has_var(INPUT_POST, "crear_trabajador")) {
    if (
        filter_has_var(INPUT_POST, "nombre") && !empty($nombre = filter_input(INPUT_POST, 'nombre')) &&
        filter_has_var(INPUT_POST, "email") && !empty($email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) &&
        filter_has_var(INPUT_POST, "password") && !empty($password = filter_input(INPUT_POST, 'password')) &&
        filter_has_var(INPUT_POST, "rol") && !empty($rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_NUMBER_INT))
    ) {
        try {
            // Crear el nuevo trabajador en la base de datos
            if (crearTrabajador($nombre, $email, $password, $rol)) {
                $_SESSION['success'] = "Trabajador creado correctamente.";

                // Limpiar el formulario
                header('Location: manage_workers.php');
                die();
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    } else {
        $error = "Error al crear el trabajador. Por favor, inténtelo de nuevo.";
    }
}

// Procesar el formulario para eliminar un trabajador
if (filter_has_var(INPUT_POST, "eliminar")) {
    if (filter_has_var(INPUT_POST, "id") && !empty($id_trabajador = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT))) {
        if (eliminarTrabajador($id_trabajador)) {
            $_SESSION['success'] = "Trabajador eliminado correctamente.";
        } else {
            $_SESSION['error'] = "Error al eliminar el trabajador. Por favor, inténtelo de nuevo.";
        }
        header('Location: manage_workers.php');
        die();
    } else {
        $error = "ID de trabajador no válido.";
    }
}

// Obtener la lista de trabajadores
$trabajadores = obtenerTrabajadores();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administrar Trabajadores - TimeTrack</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php include_once "./components/icons.php"  ?>

</head>

<body>
    <?php include_once "./components/header.php" ?>
    <main class="container">
        <?php if (isset($success)) { ?>
            <p class="success"><?php echo $success ?></p>
        <?php } else if (isset($error)) {  ?>
            <p class="error"><?php echo $error ?></p>
        <?php } ?>
        <h2>Lista de Trabajadores</h2>
        <table class="striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trabajadores as $trabajador) { ?>
                    <tr>
                        <td><?php echo $trabajador['nombre']; ?></td>
                        <td><?php echo $trabajador['correo']; ?></td>
                        <td class="flex-row gap">
                            <form action="edit_worker.php" method="get">
                                <input type="hidden" name="id" value="<?php echo $trabajador['id']; ?>">
                                <button type="submit">Editar <i class="ti ti-edit"></i></button>
                            </form>
                            <form action="manage_workers.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $trabajador['id']; ?>">
                                <button type="submit" name="eliminar">Eliminar <i class="ti ti-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Crear Nuevo Trabajador</h2>
        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="1">Trabajador</option>
                <option value="2">Administrador</option>
            </select>

            <button type="submit" name="crear_trabajador">Crear Trabajador <i class="ti ti-plus"></i></button>
        </form>
        <form action="dashboard.php" method="post">
            <button type="submit" class="button">Volver al Dashboard</button>
        </form>
    </main>
    <?php include_once "./components/footer.php" ?>
</body>

</html>