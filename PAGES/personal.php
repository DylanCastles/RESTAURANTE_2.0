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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/mesas.css">
</head>
<body>
    <?php require_once './header.php' ?>

    <main id="mesas_main">
        
    </main>

<script src="../js/modal.js"></script>
</body>
</html>