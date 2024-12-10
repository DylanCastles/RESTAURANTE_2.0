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
function reucperarInfoUsuario($pdo, $id_camarero) {
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
?>