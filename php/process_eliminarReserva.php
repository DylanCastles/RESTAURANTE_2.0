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

// Requerimos los archivos
require '../php/conexion.php'; 
require_once '../php/functions.php'; 

// variable donde se guarda cualquier error
$errors = [];

// Funcion para saber si se ha iniciado sesion
inicioSesion();

// Funcion que sanitiza datos por get
$resultado = sanitizarVariables($_GET);

// Comprobamos si esta vacio el campo
if (empty($resultado['reserva'])) {
    $errors['errorEliminarReserva'] = 'faltaIdReserva';
    redirigirConErrores('../PAGES/mesas.php', $errors);
    exit();
}

// ELIMINAR REGISTROS RESERVA (con transacciones y try catch)
try {
    $pdo->beginTransaction();

    $eliminarTablaRecursoOcupacion = "DELETE FROM recursoOcupacion WHERE ocupacion_recursoOcupacion = :idOcupacion";

    // Preparamos la consulta con la conexion a la bbdd
    $stmt1 = $pdo->prepare($eliminarTablaRecursoOcupacion);

    // Vinculamos los parametros (esta parametrizado)
    $stmt1->bindParam(':idOcupacion', $resultado['reserva']);

    // Ejecutamos la consulta
    $stmt1->execute();

    // ---------------------------------------------------------------------------------------------------------

    // TABLA OCUPACION
    $eliminarTablaOcupacion = "DELETE FROM ocupacion WHERE id_ocupacion = :idOcupacion";

    // Preparamos la consulta con la conexion a la bbdd
    $stmt2 = $pdo->prepare($eliminarTablaOcupacion);

    // Vinculamos los parametros (esta parametrizado)
    $stmt2->bindParam(':idOcupacion', $resultado['reserva']);

    // Ejecutamos la consulta
    $stmt2->execute();

    // Confirmamos la transacción
    $pdo->commit();

    // Redirección a mesas.php con SweetAlert
    echo "<script type='text/javascript'>
    Swal.fire({
        title: '¡Reserva eliminada!',
        html: 'La reserva " . $resultado['reserva'] . " se ha eliminado con exito.',
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