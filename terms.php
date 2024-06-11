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
    <title>Términos y Servicios - TimeTrack</title>
    <!-- ESTILOS -->
    <link rel="stylesheet" href="./css/pico.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php include_once "./components/icons.php"  ?>
</head>

<body>
    <?php include_once "./components/header.php" ?>

    <main class="container">
        <section>
            <h2>1. Términos</h2>
            <p>Al acceder a este sitio web, acepta estar sujeto a estos términos de servicio, todas las leyes y regulaciones aplicables, y acepta que usted es responsable del cumplimiento de las leyes locales aplicables. Si no está de acuerdo con alguno de estos términos, tiene prohibido usar o acceder a este sitio. Los materiales contenidos en este sitio web están protegidos por las leyes de derechos de autor y marcas comerciales aplicables.</p>
        </section>

        <section>
            <h2>2. Uso de la licencia</h2>
            <ol>
                <li>Se concede permiso para descargar temporalmente una copia de los materiales (información o software) en el sitio web de TimeTrack para visualización transitoria personal y no comercial solamente. Esta es la concesión de una licencia, no una transferencia de título y bajo esta licencia usted no puede:</li>
                <ul>
                    <li>Modificar o copiar los materiales.</li>
                    <li>Usar los materiales para cualquier propósito comercial, o para cualquier exhibición pública (comercial o no comercial).</li>
                    <li>Intentar descompilar o aplicar ingeniería inversa a cualquier software contenido en el sitio web de TimeTrack.</li>
                    <li>Eliminar cualquier copyright u otra notación de propiedad de los materiales.</li>
                </ul>
            </ol>
        </section>

        <section>
            <h2>3. Renuncia</h2>
            <p>Los materiales en el sitio web de TimeTrack se proporcionan "tal cual". TimeTrack no ofrece garantías, expresas o implícitas, y por la presente renuncia y niega todas las demás garantías, incluidas, entre otras, las garantías implícitas o condiciones de comerciabilidad, idoneidad para un propósito particular o no infracción de propiedad intelectual o violación de derechos.</p>
        </section>

        <section>
            <h2>4. Limitaciones</h2>
            <p>En ningún caso TimeTrack o sus proveedores serán responsables de ningún daño (incluidos, entre otros, daños por pérdida de datos o beneficios, o debido a interrupción del negocio) que surjan del uso o la imposibilidad de usar los materiales en el sitio web de TimeTrack, incluso si TimeTrack o un representante autorizado de TimeTrack ha sido notificado oralmente o por escrito de la posibilidad de tal daño. Debido a que algunas jurisdicciones no permiten limitaciones en garantías implícitas, o limitaciones de responsabilidad por daños consecuentes o incidentales, estas limitaciones pueden no aplicarse a usted.</p>
        </section>

        <section>
            <h2>5. Precisión de los materiales</h2>
            <p>Los materiales que aparecen en el sitio web de TimeTrack pueden incluir errores técnicos, tipográficos o fotográficos. TimeTrack no garantiza que ninguno de los materiales en su sitio web sea preciso, completo o actual. TimeTrack puede realizar cambios en los materiales contenidos en su sitio web en cualquier momento sin previo aviso. Sin embargo, TimeTrack no se compromete a actualizar los materiales.</p>
        </section>

        <section>
            <h2>6. Enlaces</h2>
            <p>TimeTrack no ha revisado todos los sitios vinculados a su sitio web y no es responsable del contenido de ningún sitio vinculado. La inclusión de cualquier enlace no implica la aprobación por parte de TimeTrack del sitio. El uso de cualquier sitio web vinculado es bajo el propio riesgo del usuario.</p>
        </section>

        <section>
            <h2>7. Modificaciones</h2>
            <p>TimeTrack puede revisar estos términos de servicio para su sitio web en cualquier momento sin previo aviso. Al utilizar este sitio web, usted acepta estar sujeto a la versión actual de estos términos de servicio.</p>
        </section>

        <section>
            <h2>8. Ley Aplicable</h2>
            <p>Estos términos y condiciones se rigen y se interpretan de acuerdo con las leyes de TimeTrack y usted se somete irrevocablemente a la jurisdicción exclusiva de los tribunales en ese estado o ubicación.</p>
        </section>

        <section>
            <h2>Contacto</h2>
            <p>Si tiene alguna pregunta sobre estos términos, puede ponerse en contacto con nosotros a través del siguiente correo electrónico: info@timetrack.com</p>
        </section>

        <form action="dashboard.php" method="post">
            <button type="submit" class="button">Volver al Dashboard</button>
        </form>
    </main>

    <?php include_once "./components/footer.php" ?>
</body>

</html>
