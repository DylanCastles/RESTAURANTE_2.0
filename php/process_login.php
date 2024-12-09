<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>process</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
// Requerimos los archivos
require '../php/conexion.php'; 
require_once '../php/functions.php'; 

// variable donde se guarda cualquier error
$errors = [];

// Si los datos no vienen por post da un error
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $errors['errorLogin'] = 'noPost';
    redirigirConErrores('../PAGES/index.php', $errors);
    exit();
}

// Funcion que sanitiza datos por post
$resultado = sanitizarVariables($_POST);

// Comprobamos si estan vacios los campos
if (empty($resultado['user']) || empty($resultado['contrasena'])) {
    $errors['errorLogin'] = 'campoVacio';
    redirigirConErrores('../PAGES/index.php', $errors);
    exit();
}

// Consulta para saber si el nomrbe de usuario y contraseña son correctos
$query = "SELECT username_empleado, pwd_empleado FROM empleado WHERE username_empleado = :username";

// Preparamos la consulta con la conexion a la bbdd
$stmt = $pdo->prepare($query);

// Vinculamos los parametros (esta parametrizado)
$stmt->bindParam(':username', $resultado['user']);

// Ejecutamos la consulta
$stmt->execute();

// Hacemos un array asociativo de los resultados
$resultadoQuery = $stmt->fetch(PDO::FETCH_ASSOC);

// Comprobamos si existe el usuario y la contraseña es correcta
if ($resultado && password_verify($resultado['contrasena'], $resultadoQuery['pwd_empleado'])) {

    // Variable de sesion que se mantiene durente todas las paginas al entrar
    session_start();
    $_SESSION['user_id'] = $resultado['user'];

    // Redirección a mesas.php con SweetAlert
    echo "<script type='text/javascript'>
    Swal.fire({
        title: 'Inicio de sesión',
        text: '¡Has iniciado sesión correctamente!',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(function() {
        window.location.href = '../PAGES/mesas.php';
    });
    </script>";

    exit();

} else {

    $errors['errorLogin'] = 'camposIncorrectos';
    redirigirConErrores('../PAGES/index.php', $errors);
    exit();

}
?>

</body>
</html>