<?php
session_start();
require_once './utils/functions.php';

if (isset($_SERVER['usuario']) && !empty($_SESSION['usuario'])) {
    header('Location: dashboard.php');
}


if (filter_has_var(INPUT_POST, "iniciar")) {
    if (
        filter_has_var(INPUT_POST, "correo") && !empty($correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL)) &&
        filter_has_var(INPUT_POST, "contrasena") && !empty($contrasena = filter_input(INPUT_POST, 'contrasena'))
    ) {

        if (!empty($info = login($correo, $contrasena))) {
            $_SESSION['usuario'] = $info;
            $_SESSION['checkin'] = true;
            $_SESSION['checkout'] = false;
            header("Location: dashboard.php");
        }
    } else {
        $error = "El correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - TimeTrack</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php include_once "./components/icons.php" ?>
    <style>
        main {
            display: grid;
            place-items: center;
            height: 100lvh;
        }

        div.flex {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            text-align: center;

            i {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>

    <main class="container">
        <form method="post">
            <div class="flex">
                <i class="ti ti-lock"></i>
                <h1>Bienvenido</h1>
            </div>
            <?php if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            } ?>
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <button type="submit" name="iniciar">Iniciar sesión</button>
        </form>
    </main>
</body>

</html>