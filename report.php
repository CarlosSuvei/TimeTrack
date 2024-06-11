<?php
// Inicio la sesión para tener la info del usuario 
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] != 2) {
    header("Location: index.php");
}

require './utils/functions.php';

// Recuperar la lista de proyectos y trabajadores
// Utilizamos el 
$proyectoSelect = filter_input(INPUT_GET, "id");

// Obtenemos los proyectos y trabajadores
$listaProyectos = obtenerProyectos();
$listaTrabajadores = obtenerTrabajadores();

// Si le damos a consultar verificamos y guardamos los datos
if (filter_has_var(INPUT_POST, "consultar")) {
    $id_project = filter_input(INPUT_POST, 'proyecto', FILTER_VALIDATE_INT);
    $trabajadores = filter_input(INPUT_POST, 'SelectTrabajadores', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    // Si tenemos el id del proyecto y el array de trabajadores
    if ($id_project && $trabajadores) {
        try {
            // Llamamos a la función y le pasamos los datos
            $reporte = create_report($id_project, $trabajadores);
            // Si todo a funcionado guardo el mensaje de exito
            if ($reporte) {
                $success = "Reporte creado exitosamente";
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    } else {
        $error = "Error al realizar el reporte. Por favor, seleccione un proyecto y uno o más trabajadores.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Crear Reporte</title>
    <link rel="stylesheet" href="./css/pico.min.css">
    <?php include_once './components/icons.php' ?>
    <style>
        @media print {

            header,
            footer,
            main>* {
                display: none;
            }

            #reporte,
            #reporte_header {
                display: block;
            }
        }
    </style>
</head>

<body>
    <?php include './components/header.php'; ?>
    <main class="container">
        <article>
            <header>Crear reporte</header>
            <!-- Formulario para generar reporte -->
            <form name="generateReport" method="post">
                <label>Proyecto <span style="color:IndianRed;">*</span>
                    <select name="proyecto" required>
                        <option selected disabled>Seleccione un proyecto</option>
                        <!-- Recorro y muestro los proyectos, teniendo seleccionado ya el proyecto que has pulsado antes-->
                        <?php foreach ($listaProyectos as $proyecto) { ?>
                            <option value="<?php echo $proyecto['id']; ?>" <?php
                                    if (isset($proyectoSelect) && !empty($proyectoSelect) && $proyecto['id'] == $proyectoSelect) {
                                        echo 'selected';
                                      }
                                      ?>>
                                <?php echo $proyecto['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>
                <label>Seleccione uno o varios trabajadores.<span style="color:IndianRed;">*</span>
                    <select name="SelectTrabajadores[]" multiple required>
                        <!-- Lo mismo recorro y muestro los trabajadores -->
                        <?php foreach ($listaTrabajadores as $worker) { ?>
                            <option value="<?php echo $worker['id']; ?>"><?php echo $worker['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </label>
                <button type="submit" name="consultar">Consultar <i class="ti ti-search"></i></button>
            </form>
        </article>

        <!-- Si arriba se a creado el reporte correctamente mostramos esto -->
        <?php if (isset($reporte)) { ?>
            <article id="reporte">
                <header id="reporte_header">
                    <hgroup>
                        <!-- Mostramos el nombre y la descripción del proyecto -->
                        <h2><i class="ti ti-report"></i> <?php echo $reporte[0]['nombre_proyecto']; ?></h2> <br>
                        <h3><?php echo $reporte[0]['descripcion']; ?></h3>
                    </hgroup>
                </header>
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Trabajador</th>
                            <th>Horas Trabajadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Recorro y muestro nombre de los trabajadores junto sus horas trabajadas -->
                        <?php foreach ($reporte as $row) { ?>
                            <tr>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo formatearHora($row['horas_trabajadas']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <footer>
                    <button onclick="window.print()">Exportar a PDF <i class="ti ti-file-type-pdf"></i></button>
                </footer>
            </article>
        <?php } ?>

        <!-- Si sale bien muestro mensaje de exito -->
        <?php if (isset($success)) { ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php } ?>
        <!-- Si sale mal muestro mensaje de error -->
        <?php if (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>

        <!-- Botón para volver al dashboard -->
        <form action="dashboard.php" method="post">
            <button type="submit">Volver al Dashboard</button>
        </form>
    </main>
    <?php include './components/footer.php'; ?>
</body>

</html>