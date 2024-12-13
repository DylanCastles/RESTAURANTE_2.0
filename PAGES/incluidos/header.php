<!-- HEADER PARA INCLUIRLO EN TODAS LAS PAGINAS -->

<?php 
$paginaActual = basename($_SERVER['SCRIPT_NAME']); 
$resultadoInfoUser = recuperarInfoUsuario($pdo, $_SESSION['user_id']);
?>

<header id="container_header">
    <div id="container-username">
        <div id="icon_profile_header">
            <img src="../img/logoSinFondo.png" alt="" id="icon_profile">
        </div>

        <div id="username_profile_header">
            <p id="p_username_profile"><?php echo $resultadoInfoUser['username_empleado'];?></p>
            <span class="span_subtitle"><?php echo $resultadoInfoUser['nombre_persona'] . ' ' . $resultadoInfoUser['apellido_persona'];?></span>
        </div>
    </div>

    <div id="container_title_header">
        <h1 id="title_header"><strong>Dinner At Westfield</strong></h1>
        <?php
            switch ($paginaActual) {
                case 'mesas.php':
                    echo "<span class='span_subtitle'>Gestión de mesas</span>";
                    break;
                case 'recursos.php':
                    echo "<span class='span_subtitle'>Gestión de recursos</span>";
                    break;
                case 'personal.php':
                    echo "<span class='span_subtitle'>Gestión de personal</span>";
                    break;
                case 'historico.php':
                    echo "<span class='span_subtitle'>Gestión de historico</span>";
                    break;
            }
        ?>
    </div>

    <nav id="nav_header">
        <a id="mesasBtn" class="btn btn-danger me-2 btn_custom_logOut <?php echo $paginaActual === 'mesas.php' ? 'btn_seleccionado' : 'btn_normal'; ?>" href="./mesas.php">
            <?php echo $paginaActual === 'mesas.php' ? 'Mesas' : '<i class="fa-solid fa-chair"></i>'; ?>
        </a>

        <a id="recursosBtn" class="btn btn-danger me-2 btn_custom_logOut <?php echo $paginaActual === 'recursos.php' ? 'btn_seleccionado' : 'btn_normal'; ?>" href="./recursos.php">
            <?php echo $paginaActual === 'recursos.php' ? 'Recursos' : '<i class="fa-solid fa-box-open"></i>'; ?>
        </a>

        <a id="personalBtn" class="btn btn-danger me-2 btn_custom_logOut <?php echo $paginaActual === 'personal.php' ? 'btn_seleccionado' : 'btn_normal'; ?>" href="./personal.php">
            <?php echo $paginaActual === 'personal.php' ? 'Personal' : '<i class="fa-solid fa-people-group"></i>'; ?>
        </a>

        <a id="historicoBtn" class="btn btn-danger me-2 btn_custom_logOut <?php echo $paginaActual === 'historico.php' ? 'btn_seleccionado' : 'btn_normal'; ?>" href="./historico.php">
            <?php echo $paginaActual === 'historico.php' ? 'Histórico' : '<i class="fa-solid fa-clock-rotate-left"></i>'; ?>
        </a>

        <a id="logoutBtn" class="btn btn-danger btn_custom_logOut btn_normal" href="../php/cerrarSesion.php"><i class="fa-solid fa-right-from-bracket"></i></a>
    </nav>

</header>