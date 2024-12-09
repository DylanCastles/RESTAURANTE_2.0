<?php
// Iniciamos la sesión
session_start();

// variable donde se guarda cualquier error
$errors = [];

// Requerimos los archivos
require_once '../php/functions.php'; 

// Verificamos si la sesión del camarero está activa
if (!isset($_SESSION['user_id'])) {

    // Si no está activo, redirigimos a la página de inicio de sesión
    $errors['errorPagina'] = 'noAutorizado';
    redirigirConErrores('./index.php', $errors);
    exit();
}

// Incluimos el archivo de conexión a la base de datos
require '../php/conexion.php';



// Esta funcion no la uso, mirar si la puedo usar
// require '../php/estadoMesaRecuperar.php';



// Recojemos la información del usuario
$info_user = reucperarInfoUsuario($pdo, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/mesas.css">
</head>
<body>
    <header id="container_header">
        <div id="container-username">
            <div id="icon_profile_header">
                <img src="../img/logoSinFondo.png" alt="" id="icon_profile">
            </div>

            <div id="username_profile_header">
                <p id="p_username_profile">hola</p>
                <span class="span_subtitle">adios</span>
            </div>
        </div>

        <div id="container_title_header">
            <h1 id="title_header"><strong>Dinner At Westfield</strong></h1>
            <span class="span_subtitle">Gestión de mesas</span>
        </div>

        <nav id="nav_header">
            <a href="./historico.php" class="btn btn-danger me-2 btn_custom_logOut">Histórico reservas</a>
            <a href="../php/cerrarSesion.php" class="btn btn-danger btn_custom_logOut m-1">Cerrar sesión</a>
        </nav>
    </header>

    <main id="mesas_main">
        
    </main>

<script src="../js/modal.js"></script>
</body>
</html>