<?php
session_start();
require_once './utils/functions.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
}

// Obtener la información del usuario desde la sesión
$usuario = $_SESSION['usuario'];

// Obtener los proyectos
$proyectos = obtenerProyectos();

// Verificar si se ha enviado el formulario de eliminación
if (filter_has_var(INPUT_POST, "eliminar")) {
    $id_proyecto = filter_input(INPUT_POST, "id");

    // Eliminar el proyecto
    if (eliminarProyecto($id_proyecto)) {
        $success = "Proyecto eliminado exitosamente.";
        // Actualizar la lista de proyectos después de eliminar
        $proyectos = obtenerProyectos();
    } else {
        $error = "Error al eliminar el proyecto. Por favor, inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - TimeTrack</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <!-- ICONOS -->
    <?php include_once "./components/icons.php" ?>
    <style>
        .welcome {
            display: flex;
            justify-content: center;
            align-items: center;

            img {
                transition: .5s ease !important;
            }

            img:hover {
                scale: 1.05;
                filter: drop-shadow(4px 6px 4px #888);
            }
        }
    </style>
</head>

<body>
    <?php include_once "./components/header.php" ?>
    <main class="container">

        <section class="welcome">
            <hgroup>
                <h1>
                    <!-- Dividimos el nombre con 'explode', 
                    obtenemos la primera palabra, 
                    sacamos la última letra con 'substr',
                    el nombre acaba en a mosramos 'bienvenida' de lo contrario 'bienbenido' 
                -->
                    ¡Bienvenid<?php echo substr(explode(' ', $_SESSION['usuario']['nombre'])[0], -1) == 'a' ?  'a' : 'o' ?>, <?php echo $_SESSION['usuario']['nombre'] ?>! 👋
                </h1>
                <br>
                <p>
                    Cuanto tiempo sin verte. ⏰
                </p>

                <p>
                    Has iniciado sesión como: <?php echo $_SESSION['usuario']['correo'] ?>
                </p>
            </hgroup>
            <img src="./assets/images/time.png" width="512" />
        </section>



        <hgroup>
            <h2>Panel de Control</h2>
            <p>Desde aquí puedes gestionar tus proyectos, trabajadores y registrar horas.</p>
        </hgroup>
        <section>
            <h3>Tus Proyectos</h3>
            <?php if (isset($success)) { ?>
                <p class="success"><?php echo $success; ?></p>
            <?php } ?>

            <?php if (isset($error)) { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>

            <table class="striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <?php if ($usuario['rol'] == 2) { ?>
                            <th>Acciones</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proyectos as $proyecto) { ?>
                        <tr>
                            <td style="padding: 1rem 1rem;"><?php echo ($proyecto['nombre']); ?></td>
                            <td><?php echo ($proyecto['descripcion']); ?></td>
                            <td>
                                <span class="estado <?php echo $proyecto['estado'] == 'En espera' ? 'espera' : ($proyecto['estado'] == 'En progreso' ? 'progreso' : 'finalizado') ?> ">
                                    <?php echo ($proyecto['estado']); ?>
                                </span>
                            </td>
                            <?php if ($usuario['rol'] == 2) { ?>
                                <td style="display: flex; gap:.5rem;">
                                    <form action="edit_project.php" method="get">
                                        <input type="hidden" name="id" value="<?php echo $proyecto['id']; ?>">
                                        <button type="submit">Editar <i class="ti ti-edit"></i></button>
                                    </form>
                                    <form action="report.php" method="get">
                                        <input type="hidden" name="id" value="<?php echo $proyecto['id']; ?>">
                                        <button type="submit">Reporte <i class="ti ti-report"></i></button>
                                    </form>
                                    <form action="dashboard.php" method="post"> <!-- Eliminar proyecto -->
                                        <input type="hidden" name="id" value="<?php echo $proyecto['id']; ?>">
                                        <button type="submit" name="eliminar">Eliminar <i class="ti ti-trash"></i></button>
                                    </form>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if ($usuario['rol'] == 2) { ?>
                <form action="create_project.php" method="post">
                    <button type="submit" class="button" role="button">Crear Proyecto <i class="ti ti-plus"></i></button>
                </form>
            <?php } ?>
        </section>
    </main>
    <?php include_once "./components/footer.php" ?>
</body>

</html>