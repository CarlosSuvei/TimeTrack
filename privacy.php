<?php
session_start();


// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos de Privacidad - TimeTrack</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php include_once "./components/icons.php"  ?>
</head>

<body>
    <?php include_once "./components/header.php" ?>

    <main class="container">
        <section>
            <h2>Introducción</h2>
            <p>Bienvenido a TimeTrack. Esta página establece los términos de privacidad para el uso de nuestra plataforma.</p>
        </section>

        <section>
            <h2>Información que Recopilamos</h2>
            <p>Recopilamos información personal solo con el propósito de proporcionar y mejorar nuestros servicios. La información que solicitamos será retenida por nosotros y no será compartida con terceros.</p>
        </section>

        <section>
            <h2>Uso de la Información</h2>
            <p>La información personal recopilada se utiliza para mejorar la calidad de nuestro servicio y para mantener la seguridad de nuestra plataforma.</p>
        </section>

        <section>
            <h2>Seguridad</h2>
            <p>Tomamos precauciones razonables y seguimos las mejores prácticas de la industria para proteger la información personal que nos proporciona.</p>
        </section>

        <section>
            <h2>Cookies</h2>
            <p>Utilizamos cookies para recopilar información. Puede configurar su navegador para que rechace todas las cookies o para que le avise cuando se envía una cookie. Sin embargo, si no acepta cookies, es posible que no pueda utilizar algunas partes de nuestro Servicio.</p>
        </section>

        <section>
            <h2>Cambios a Esta Política de Privacidad</h2>
            <p>Esta política de privacidad está sujeta a cambios. Le notificaremos cualquier cambio mediante la publicación de la nueva política de privacidad en esta página.</p>
        </section>

        <section>
            <h2>Contacto</h2>
            <p>Si tiene alguna pregunta sobre esta política de privacidad, no dude en ponerse en contacto con nosotros.</p>
            <p>Email: info@timetrack.com</p>
        </section>

        <form action="dashboard.php" method="post">
            <button type="submit" class="button">Volver al Dashboard</button>
        </form>
    </main>

    <?php include_once "./components/footer.php" ?>
</body>

</html>
