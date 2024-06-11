<?php
if ($_SESSION) {
    $rol = $_SESSION['usuario']['rol'];

    $checkin = $_SESSION['checkin'];
    $checkout = $_SESSION['checkout'];
}

?>
<header class="container">
    <nav>
        <ul>
            <li><img src="http://localhost/TimeTrack-New/assets/images/prueba.png" width="128" alt="logo-time-track" /></li>
            <!-- <li><strong>Time Track</strong></li> -->
        </ul>
        <ul>
            <!-- TRABAJADOR -->
            <li <?php if (!$checkin)  echo 'hidden' ?>><a role="button" href="check_in.php">Check In</a></li>
            <li <?php if (!$checkout) echo 'hidden' ?>><a role="button" href="check_out.php">Check Out</a></li>
            <li><a role="button" href="view_hours.php"> Consultar Horas <i class="ti ti-timeline"></i></a></li>
            <li><a role="button" href="dashboard.php"> Dashboard <i class="ti ti-dashboard"></i></a></li>

            <!-- ADMINISTRADOR -->
            <li <?php if ($rol !== 2) echo 'hidden' ?>><a role="button" href="manage_workers.php"> Gestionar Trabajadores <i class="ti ti-users"></i></a></li>

            <!-- CERRAR SESIÓN -->
            <li><a role="button" href="logout.php"> Log Out <i class="ti ti-logout"></i></a></li>
        </ul>
    </nav>
    <hr>
</header>