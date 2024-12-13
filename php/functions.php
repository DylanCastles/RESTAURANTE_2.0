<?php
// Funcion para redirigir a una ruta con un array de errores
function redirigirConErrores($url, $errores) {
    if (is_array($errores)) {
        $erroresString = http_build_query($errores);
    } else {
        header("Location: $url");
        exit();
    }
    header("Location: $url?$erroresString");
    exit();
}

// Funcion para sanitizar un array de variables
function sanitizarVariables($variables) {
    if (is_array($variables)) {
        $resultado = [];
        foreach ($variables as $variable => $valor) {
            $resultado[$variable] = trim(htmlspecialchars($valor));
        }
        return $resultado;
    } else {
        echo "Error: funcion sanitizarVariables (llamada incorrecta).";
        exit;
    }
}

// Función que recupera la información del camarero
function recuperarInfoUsuario($pdo, $id_camarero) {
    $query = "SELECT empleado.*, persona.* FROM empleado INNER JOIN persona ON empleado.id_empleado=persona.id_persona WHERE username_empleado = :username";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':username', $id_camarero);

    $stmt->execute();

    $resultadoQuery = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultadoQuery) {
        return $resultadoQuery;
    } else {
        echo "Error: funcion reucperarInfoUsuario (no se encuentran resultados).";
        exit;
    }
}

// Función que recupera la id de la sala de la mesa
function reucuperarIdSala($pdo, $id_mesa) {
    $query = "SELECT recursoPadre_recurso FROM recurso WHERE id_recurso = :recurso";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':recurso', $id_mesa);

    $stmt->execute();

    $resultadoQuery = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultadoQuery) {
        return $resultadoQuery;
    } else {
        echo "Error: funcion reucperarIdSala (no se encuentran resultados).";
        exit;
    }
}

// Función que recupera la id de la sala de la mesa
function reucuperarCantidadSillas($pdo, $id_mesa) {
    $query = "SELECT COUNT(*) AS sillasMesa FROM recurso WHERE recursoPadre_recurso = :recursoPadre AND tipoRecurso_recurso = :tipoRecurso;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':recursoPadre', $id_mesa);

    $tipoRecurso = 1;
    $stmt->bindParam(':tipoRecurso', $tipoRecurso);

    $stmt->execute();

    $resultadoQuery = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultadoQuery) {
        return $resultadoQuery;
    } else {
        echo "Error: funcion reucperarIdSala (no se encuentran resultados).";
        exit;
    }
}

// Funcion para saber si se ha iniciado sesion
function inicioSesion(){
    if (!isset($_SESSION['user_id'])) {
        $errors['errorLogin'] = 'noSesion';
        redirigirConErrores('../PAGES/index.php', $errors);
    }
}

// Funcion para comprobar que las dos fechas de la reserva no coincidan con otra
function comprobarFechas($pdo, $fechaInicio, $fechaFinal, $recurso){

    // Comprobar que ninguna de las fechas de la ocupacion actual este entre dos de cualquier ocupacion
    $query1 = "SELECT COUNT(*) AS ocupacionesEncontradas FROM ocupacion INNER JOIN recursoOcupacion ON ocupacion.id_ocupacion = recursoOcupacion.ocupacion_recursoOcupacion WHERE ((ocupacion.fechaInicio_ocupacion <= :fechaInicioNueva AND ocupacion.fechaFinal_ocupacion >= :fechaInicioNueva) OR (ocupacion.fechaInicio_ocupacion <= :fechaFinalNueva AND ocupacion.fechaFinal_ocupacion >= :fechaFinalNueva)) AND recursoOcupacion.recurso_recursoOcupacion = :recursoOcupado;";

    $stmt1 = $pdo->prepare($query1);

    $stmt1->bindParam(':fechaInicioNueva', $fechaInicio);

    $stmt1->bindParam(':fechaFinalNueva', $fechaFinal);

    $stmt1->bindParam(':recursoOcupado', $recurso);

    $stmt1->execute();

    $resultadoQuery1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($resultadoQuery1['ocupacionesEncontradas'] > 0) {
        return true;
    }

    // Comprobar que no haya ninguna ocupacion con cualquier de las dos fechas entre las dos de la actual
    $query1 = "SELECT COUNT(*) AS ocupacionesEncontradas FROM ocupacion INNER JOIN recursoOcupacion ON ocupacion.id_ocupacion = recursoOcupacion.ocupacion_recursoOcupacion WHERE ((ocupacion.fechaInicio_ocupacion >= :fechaInicioNueva AND ocupacion.fechaInicio_ocupacion <= :fechaFinalNueva) OR (ocupacion.fechaFinal_ocupacion >= :fechaInicioNueva AND ocupacion.fechaFinal_ocupacion <= :fechaFinalNueva)) AND recursoOcupacion.recurso_recursoOcupacion = :recursoOcupado;";
    
    $stmt1 = $pdo->prepare($query1);

    $stmt1->bindParam(':fechaInicioNueva', $fechaInicio);

    $stmt1->bindParam(':fechaFinalNueva', $fechaFinal);

    $stmt1->bindParam(':recursoOcupado', $recurso);

    $stmt1->execute();

    $resultadoQuery1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($resultadoQuery1['ocupacionesEncontradas'] > 0) {
        return true;
    }
}

?>