<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TimeTrack - 404</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php include_once './components/icons.php' ?>
    <style>
        main {
            height: 100lvh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            margin-bottom: .5rem;
        }

        img {
            filter: hue-rotate(-40deg);
        }
    </style>
</head>

<body>

    <main class="container">
        <div>
            <hgroup>
                <h1>Oops</h1>
                <h2>Esta no es la página que buscas</h2>
            </hgroup>
            <a href="dashboard.php">Volver al inicio <i class="ti ti-arrow-right"></i></a>
        </div>

        <img id="404Draw" src="./assets/undraw_404.svg" width="35%" alt="Carita triste">
    </main>
</body>

</html>