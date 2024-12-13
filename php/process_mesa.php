<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>process</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
session_start();

echo "Valores post:";
var_dump($_POST);
echo "-----------------------";
echo "Valores sesion:";
var_dump($_SESSION);

// Requerimos los archivos
require '../php/conexion.php'; 
require_once '../php/functions.php'; 

// variable donde se guarda cualquier error
$errors = [];

// Funcion para saber si se ha iniciado sesion
inicioSesion();

// Funcion que sanitiza datos por post
$resultado = sanitizarVariables($_POST);

// Si los datos no vienen por post da un error
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $errors['errorReservar'] = 'noPost';
    redirigirConErrores('../PAGES/mesas.php', $errors);
    exit();
}

// Comprobamos si estan vacios los campos
if (empty($resultado['nombreCliente']) || empty($resultado['apellidoCliente']) || empty($resultado['apellidoCliente'])) {
    $errors['errorReservar'] = 'campoVacio';
    redirigirConErrores('../PAGES/mesas.php', $errors);
    exit();
}
if ($resultado['option'] === "reserva") {
    if (empty($resultado['fechaReserva'])) {
        $errors['errorReservar'] = 'campoVacio';
        redirigirConErrores('../PAGES/mesas.php', $errors);
        exit();
    }
// -- CONSEGUIR FECHAS -- 
    // Pasar al formato de fecha/hora correcto
    $fechaHoraInicioFormateada = str_replace('T', ' ', $resultado['fechaReserva']) . ':00';
    // Crear objeto a partir de la fecha formateada
    $fechaHoraInicioObjeto = new DateTime($fechaHoraInicioFormateada);
    // Conseguir tiempo que se suma (al ser reserva)
    $tiempoFinal = $resultado['tiempoReserva'];
} else {
    // Crear objeto a partir de la fecha y hora actual
    $fechaHoraInicioObjeto = new DateTime();
    // Conseguir tiempo que se suma (al ser ahora)
    $tiempoFinal = $resultado['tiempoAhora'];
}

// Guardar en la variable fechaInicio la fecha/hora actual formateada
$fechaInicio = $fechaHoraInicioObjeto->format('Y-m-d H:i:s');

// Añadirle una hora al objeto de la fecha/hora actual
$fechaHoraInicioObjeto->modify('+' . $tiempoFinal . ' hour');

// Guardar en la variable fechaFinal la fecha/hora obtenido en la suma formateado
$fechaFinal = $fechaHoraInicioObjeto->format('Y-m-d H:i:s');

// Funcion para comprobar si las fechas de la ocupacion son correctas
if (!comprobarFechas($pdo, $fechaInicio, $fechaFinal, $resultado['mesa'])) {
    $errors['errorReservar'] = 'fechasMal';
    redirigirConErrores('../PAGES/mesas.php?mesa=' . $resultado['mesa'], $errors);
    exit();
}

exit;
// CONSEGUIR INFO


// HACER INSERTS (con transacciones y try catch)

// Insert de la reserva
$query = "SELECT empleado.username_empleado, empleado.pwd_empleado, tipoEmpleado.nombre_tipoEmpleado FROM empleado INNER JOIN tipoEmpleado ON empleado.tipoEmpleado_empleado=tipoEmpleado.id_tipoEmpleado WHERE username_empleado = :username";

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

    // Si es gerente guarda una variable de sesion (ya que es admin)
    if ($resultadoQuery['nombre_tipoEmpleado'] === "gerente") {
        $_SESSION['userAdmin'] = "true";
    }

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