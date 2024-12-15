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

// echo "Valores post:";
// var_dump($_POST);
// echo "<br>";
// echo "Valores sesion:";
// var_dump($_SESSION);

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
if (empty($resultado['nombreCliente']) || empty($resultado['apellidoCliente'])) {
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
    // Añadirle una hora al objeto de la fecha/hora actual para que sea como España
    $fechaHoraInicioObjeto->modify('+ 1 hour');
    // Conseguir tiempo que se suma (al ser ahora)
    $tiempoFinal = $resultado['tiempoAhora'];
}

// Guardar en la variable fechaInicio la fecha/hora actual formateada
$fechaInicio = $fechaHoraInicioObjeto->format('Y-m-d H:i:s');

// Añadirle las horas al objeto de la fecha/hora actual
$fechaHoraInicioObjeto->modify('+' . $tiempoFinal . ' hour');

// Guardar en la variable fechaFinal la fecha/hora obtenido en la suma formateado
$fechaFinal = $fechaHoraInicioObjeto->format('Y-m-d H:i:s');

// Funcion para comprobar si las fechas de la ocupacion son correctas
if (comprobarFechas($pdo, $fechaInicio, $fechaFinal, $resultado['mesa'])) {
    $errors['errorReservar'] = 'fechasMal';
    $errors['mesa'] = $resultado['mesa'];
    $errors['nombre'] = $resultado['nombreCliente'];
    $errors['apellido'] = $resultado['apellidoCliente'];
    $errors['detalles'] = $resultado['detallesReserva'];

    redirigirConErrores('../PAGES/mesas.php', $errors);
    exit();
}

// Recuperar id del empleado
$infoEmpleado = recuperarInfoUsuario($pdo, $_SESSION['user_id']);
$idEmpleado = $infoEmpleado['id_empleado'];

// Recuperar cantidad de sillas actuales
$cantidadSillas = reucuperarCantidadSillas($pdo, $resultado['mesa']);
$sillasMesa = $cantidadSillas['sillasMesa'];

// HACER INSERTS (con transacciones y try catch)
try {
    $pdo->beginTransaction();

    // TABLA PERSONA
    $InsertTablaPersona = "INSERT INTO persona (nombre_persona, apellido_persona) VALUES (:nombreCliente, :apellidoCliente)";

    // Preparamos la consulta con la conexion a la bbdd
    $stmt1 = $pdo->prepare($InsertTablaPersona);

    // Vinculamos los parametros (esta parametrizado)
    $stmt1->bindParam(':nombreCliente', $resultado['nombreCliente']);
    $stmt1->bindParam(':apellidoCliente', $resultado['apellidoCliente']);

    // Ejecutamos la consulta
    $stmt1->execute();

    // ---------------------------------------------------------------------------------------------------------

    // TABLA CLIENTE
    $idPersonaCliente = $pdo->lastInsertId();

    $InsertTablaCliente = "INSERT INTO cliente (persona_cliente) VALUES (:idPersonaCliente)";

    // Preparamos la consulta con la conexion a la bbdd
    $stmt2 = $pdo->prepare($InsertTablaCliente);

    // Vinculamos los parametros (esta parametrizado)
    $stmt2->bindParam(':idPersonaCliente', $idPersonaCliente);

    // Ejecutamos la consulta
    $stmt2->execute();

    // ---------------------------------------------------------------------------------------------------------

    // TABLA OCUPACION
    $idCliente = $pdo->lastInsertId();

    $InsertTablaOcupacion = "INSERT INTO ocupacion (fechaInicio_ocupacion, fechaFinal_ocupacion, detalles_ocupacion, empleado_ocupacion, cliente_ocupacion) VALUES (:fechaInicio, :fechaFinal, :detalles, :empleado, :cliente)";

    // Preparamos la consulta con la conexion a la bbdd
    $stmt3 = $pdo->prepare($InsertTablaOcupacion);

    // Vinculamos los parametros (esta parametrizado)
    $stmt3->bindParam(':fechaInicio', $fechaInicio);
    $stmt3->bindParam(':fechaFinal', $fechaFinal);
    $stmt3->bindParam(':detalles', $resultado['detallesReserva']);
    $stmt3->bindParam(':empleado', $idEmpleado);
    $stmt3->bindParam(':cliente', $idCliente);

    // Ejecutamos la consulta
    $stmt3->execute();

    // ---------------------------------------------------------------------------------------------------------

    // TABLA RECURSOOCUPACION

    $idOcupacion = $pdo->lastInsertId();

    $InsertTablaRecursoOcupacion = "INSERT INTO recursoOcupacion (sillas_recursoOcupacion, ocupacion_recursoOcupacion, recurso_recursoOcupacion) VALUES (:sillas, :ocupacion, :recurso)";

    // Preparamos la consulta con la conexion a la bbdd
    $stmt4 = $pdo->prepare($InsertTablaRecursoOcupacion);

    // Vinculamos los parametros (esta parametrizado)
    $stmt4->bindParam(':sillas', $sillasMesa);
    $stmt4->bindParam(':ocupacion', $idOcupacion);
    $stmt4->bindParam(':recurso', $resultado['mesa']);

    // Ejecutamos la consulta
    $stmt4->execute();

    // Confirmamos la transacción
    $pdo->commit();

    // Redirección a mesas.php con SweetAlert
    echo "<script type='text/javascript'>
    Swal.fire({
        title: 'Mesa " . $resultado['mesa'] . " reservada',
        html: 'Fecha inicio: " . $fechaInicio . "<br>Fecha final: " . $fechaFinal . "<br>Cantidad de sillas: " . $sillasMesa . "<br>Detalles: " . $resultado['detallesReserva'] . "',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(function() {
        window.location.href = '../PAGES/mesas.php?mesa=" . $resultado['mesa'] . "';
    });
    </script>";    

    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>

</body>
</html>