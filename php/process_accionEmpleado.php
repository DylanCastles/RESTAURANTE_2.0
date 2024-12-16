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

// var_dump($_GET);
// var_dump($_POST);
// var_dump($_SESSION);

// exit;


// Requerimos los archivos
require '../php/conexion.php'; 
require_once '../php/functions.php'; 

// variable donde se guarda cualquier error
$errors = [];

// Funcion para saber si se ha iniciado sesion
inicioSesion();

// Funcion para saber si es admin o no
isAdmin();

// Funcion que sanitiza datos
$resultadoGET = sanitizarVariables($_GET);
$resultadoPOST = sanitizarVariables($_POST);

// Comprobamos si esta vacio el campo
if (empty($resultadoGET['accion'])) {
    $errors['errorAccionEmpleado'] = 'faltaIdReserva';
    redirigirConErrores('../PAGES/personal.php', $errors);
    exit();
}

switch ($resultadoGET['accion']) {
    case 'editar':
        // EDITAR EMPLEADO

        // Conseguir id empleado
        $infoUsuario = recuperarInfoUsuario($pdo, $resultadoGET['empleado']);

        // Saber duplicados
        $duplicados = saberDuplicados($pdo, $resultadoPOST['usuarioEmpleado'], $resultadoPOST['dniEmpleado'], $infoUsuario['id_empleado']);

        if ($duplicados === "username") {
            $errors['accion'] = 'editar';
            $errors['empleado'] = $resultadoGET['empleado'];
            $errors['errorAccionEmpleado'] = 'usernameDuplicado';
            redirigirConErrores('../PAGES/personal.php', $errors);
            exit();
        }
        if ($duplicados === "dni") {
            $errors['accion'] = 'editar';
            $errors['empleado'] = $resultadoGET['empleado'];
            $errors['errorAccionEmpleado'] = 'dniDuplicado';
            redirigirConErrores('../PAGES/personal.php', $errors);
            exit();
        }
        
        $editarEmpleadoQuery = "UPDATE empleado e INNER JOIN persona p ON e.persona_empleado=p.id_persona 
                                SET e.username_empleado = :userName, 
                                p.nombre_persona = :nombre, 
                                p.apellido_persona = :apellido, 
                                e.salario_empleado = :salario, 
                                e.DNI_empleado = :DNI, 
                                e.pwd_empleado = :pwd,
                                e.tipoEmpleado_empleado = :tipoEmpleado
                                WHERE e.username_empleado = :userNameAntiguo";
        // Preparamos la consulta con la conexion a la bbdd
        $stmtEditar = $pdo->prepare($editarEmpleadoQuery);

        // Vinculamos los parametros (esta parametrizado)
        $stmtEditar->bindParam(':userName', $resultadoPOST['usuarioEmpleado']);
        $stmtEditar->bindParam(':nombre', $resultadoPOST['nombreEmpleado']);
        $stmtEditar->bindParam(':apellido', $resultadoPOST['apellidoEmpleado']);
        $stmtEditar->bindParam(':salario', $resultadoPOST['salarioEmpleado']);
        $stmtEditar->bindParam(':DNI', $resultadoPOST['dniEmpleado']);
        $pwdHashed = password_hash($resultadoPOST['pwdEmpleado'], PASSWORD_BCRYPT);
        $stmtEditar->bindParam(':pwd', $pwdHashed);
        $stmtEditar->bindParam(':tipoEmpleado', $resultadoPOST['tipoEmpleado']);
        $stmtEditar->bindParam(':userNameAntiguo', $resultadoGET['empleado']);
        
        // Ejecutamos la consulta
        $stmtEditar->execute();

        // Redirección con SweetAlert
        echo "<script type='text/javascript'>
        Swal.fire({
            title: '¡Empleado actualizado!',
            html: 'El empleado se ha editado con exito.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = '../PAGES/personal.php?';
        });
        </script>";    

        exit();

        break;
    case 'crear':
        // CREAR EMPLEADO

        // Saber duplicados
        $duplicados = saberDuplicados($pdo, $resultadoPOST['usuarioEmpleado'], $resultadoPOST['dniEmpleado'], 0);

        if ($duplicados === "username") {
            $errors['accion'] = 'crear';
            $errors['errorAccionEmpleado'] = 'usernameDuplicado';
            $errors['usuarioEmpleado'] = $resultadoPOST['usuarioEmpleado'];
            $errors['nombreEmpleado'] = $resultadoPOST['nombreEmpleado'];
            $errors['apellidoEmpleado'] = $resultadoPOST['apellidoEmpleado'];
            $errors['salarioEmpleado'] = $resultadoPOST['salarioEmpleado'];
            $errors['dniEmpleado'] = $resultadoPOST['dniEmpleado'];
            redirigirConErrores('../PAGES/personal.php', $errors);
            exit();
        }
        if ($duplicados === "dni") {
            $errors['accion'] = 'crear';
            $errors['errorAccionEmpleado'] = 'dniDuplicado';
            $errors['usuarioEmpleado'] = $resultadoPOST['usuarioEmpleado'];
            $errors['nombreEmpleado'] = $resultadoPOST['nombreEmpleado'];
            $errors['apellidoEmpleado'] = $resultadoPOST['apellidoEmpleado'];
            $errors['salarioEmpleado'] = $resultadoPOST['salarioEmpleado'];
            $errors['dniEmpleado'] = $resultadoPOST['dniEmpleado'];
            redirigirConErrores('../PAGES/personal.php', $errors);
            exit();
        }

        try {
            $pdo->beginTransaction();

            // TABLA PERSONA
            $crearPersonaQuery = "INSERT INTO persona (nombre_persona, apellido_persona) VALUES (:nombre, :apellido)";

            // Preparamos la consulta con la conexion a la bbdd
            $stmt1 = $pdo->prepare($crearPersonaQuery);

            // Vinculamos los parametros (esta parametrizado)
            $stmt1->bindParam(':nombre', $resultadoPOST['nombreEmpleado']);
            $stmt1->bindParam(':apellido', $resultadoPOST['apellidoEmpleado']);

            // Ejecutamos la consulta
            $stmt1->execute();


            // TABLA EMPLEADO
            $crearEmpleadoQuery = "INSERT INTO empleado (username_empleado, pwd_empleado, salario_empleado, DNI_empleado, persona_empleado, tipoEmpleado_empleado) 
                                VALUES (:username, :pwd, :salario, :dni, :persona, :tipo)";

            // Preparamos la consulta con la conexion a la bbdd
            $stmt2 = $pdo->prepare($crearEmpleadoQuery);

            // Vinculamos los parametros (esta parametrizado)
            $stmt2->bindParam(':username', $resultadoPOST['usuarioEmpleado']);
            $pwdHashed = password_hash($resultadoPOST['pwdEmpleado'], PASSWORD_BCRYPT);
            $stmt2->bindParam(':pwd', $pwdHashed);
            $stmt2->bindParam(':salario', $resultadoPOST['salarioEmpleado']);
            $stmt2->bindParam(':dni', $resultadoPOST['dniEmpleado']);
            $idPersona = $pdo->lastInsertId();
            $stmt2->bindParam(':persona', $idPersona);
            $stmt2->bindParam(':tipo', $resultadoPOST['tipoEmpleado']);
            
            // Ejecutamos la consulta
            $stmt2->execute();
        
            // Confirmamos la transacción
            $pdo->commit();
            
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }

        // Redirección con SweetAlert
        echo "<script type='text/javascript'>
        Swal.fire({
            title: '¡Empleado creado!',
            html: 'El empleado se ha creado con exito.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = '../PAGES/personal.php?';
        });
        </script>";    

        exit();

        break;
    case 'eliminar':

        // ELIMINAR EMPLEADO
        try {
            $pdo->beginTransaction();

            // SELECT TABLA OCUPACION
            $seleccionarOcupacionesQuery = "SELECT id_ocupacion FROM ocupacion WHERE empleado_ocupacion = :idEmpleado";

            // Preparamos la consulta con la conexion a la bbdd
            $stmt1 = $pdo->prepare($seleccionarOcupacionesQuery);

            // Vinculamos los parametros (esta parametrizado)
            $stmt1->bindParam(':idEmpleado', $resultadoGET['empleado']);

            // Ejecutamos la consulta
            $stmt1->execute();

            $resultadoQuery = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            if ($resultadoQuery) {
                foreach ($resultadoQuery as $row) {
                    // TABLA RECURSO OCUPACION
                    $eliminarRecursoOcupacionesQuery = "DELETE FROM recursoOcupacion WHERE ocupacion_recursoOcupacion = :idOcupacion";

                    // Preparamos la consulta con la conexion a la bbdd
                    $stmt2 = $pdo->prepare($eliminarRecursoOcupacionesQuery);

                    // Vinculamos los parametros (esta parametrizado)
                    $stmt2->bindParam(':idOcupacion', $row['id_ocupacion']);

                    // Ejecutamos la consulta
                    $stmt2->execute();

                    // --------------------------------------------------------------

                    // TABLA OCUPACION
                    $eliminarOcupacionesQuery = "DELETE FROM ocupacion WHERE id_ocupacion = :idOcupacion";

                    // Preparamos la consulta con la conexion a la bbdd
                    $stmt3 = $pdo->prepare($eliminarOcupacionesQuery);

                    // Vinculamos los parametros (esta parametrizado)
                    $stmt3->bindParam(':idOcupacion', $row['id_ocupacion']);

                    // Ejecutamos la consulta
                    $stmt3->execute();
                }
            }

            // ----------------------------------------------------------------------------

            // TABLA EMPLEADO
            $eliminarEmpleadoQuery = "DELETE FROM empleado WHERE persona_empleado = :idPersona";

            // Preparamos la consulta con la conexion a la bbdd
            $stmt4 = $pdo->prepare($eliminarEmpleadoQuery);

            // Vinculamos los parametros (esta parametrizado)
            $stmt4->bindParam(':idPersona', $resultadoGET['empleado']);
            
            // Ejecutamos la consulta
            $stmt4->execute();

            // TABLA PERSONA
            $eliminarPersonaQuery = "DELETE FROM persona WHERE id_persona = :id";

            // Preparamos la consulta con la conexion a la bbdd
            $stmt5 = $pdo->prepare($eliminarPersonaQuery);

            // Vinculamos los parametros (esta parametrizado)
            $stmt5->bindParam(':id', $resultadoGET['empleado']);

            // Ejecutamos la consulta
            $stmt5->execute();

            // Confirmamos la transacción
            $pdo->commit();
            
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }

        // Redirección con SweetAlert
        echo "<script type='text/javascript'>
        Swal.fire({
            title: '¡Empleado eliminado!',
            html: 'El empleado se ha eliminado con exito.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = '../PAGES/personal.php?';
        });
        </script>";   

        exit;

        break;
}

?>

</body>
</html>
