<?php
// Iniciamos la sesión
session_start();

// variable donde se guarda cualquier error
$errors = [];

require '../php/conexion.php';
require_once '../php/functions.php';

// Funcion para saber si se ha iniciado sesion
inicioSesion();

// Funcion para saber si es admin o no
isAdmin();

$id_camarero = $_SESSION['user_id'];
$info_waiter = recuperarInfoUsuario($pdo, $id_camarero);

// Crear objeto a partir de la fecha y hora actual
$fechaHoraActual = new DateTime();
// Añadirle una hora al objeto de la fecha/hora actual para que sea como España
$fechaHoraActual->modify('+ 1 hour');
// Guardar en la variable fechaInicio la fecha/hora actual formateada
$fechaHoraActual = $fechaHoraActual->format('Y-m-d H:i:s');

// Construcción dinámica de condiciones y ordenación
$conditions = "WHERE o.fechaFinal_ocupacion < '$fechaHoraActual'";
$order_by = "";
$params = [];

// Manejo de filtros y ordenación
if (!empty($_GET['search']) && !empty($_GET['field'])) {
    $search = $_GET['search'];
    $field = $_GET['field'];
    $valid_fields = ['username_empleado', 'nombre_persona', 'apellido_persona', 'detalles_ocupacion'];

    // Verifica que el campo sea válido
    if (in_array($field, $valid_fields)) {
        $conditions .= " AND $field LIKE ?";
        $params[] = "%$search%";
    }
}

if (!empty($_GET['field']) && !empty($_GET['order'])) {
    $field = $_GET['field'];
    $order = $_GET['order'];
    $valid_fields = ['username_empleado', 'nombre_persona', 'apellido_persona', 'detalles_ocupacion'];

    // Verifica que el campo y el orden sean válidos
    if (in_array($field, $valid_fields) && in_array($order, ['asc', 'desc'])) {
        $order_by = " ORDER BY $field $order";
    }
}

// Consulta SQL
$query = "
    SELECT 
        o.id_ocupacion,
        e.username_empleado,
        p.nombre_persona,
        p.apellido_persona,
        o.detalles_ocupacion,
        ro.sillas_recursoOcupacion,
        o.fechaInicio_ocupacion,
        o.fechaFinal_ocupacion,
        r.id_recurso
    FROM 
        ocupacion o
    INNER JOIN 
        recursoOcupacion ro ON o.id_ocupacion = ro.ocupacion_recursoOcupacion
    INNER JOIN 
        recurso r ON ro.recurso_recursoOcupacion = r.id_recurso
    INNER JOIN 
        empleado e ON o.empleado_ocupacion = e.id_empleado
    INNER JOIN 
        persona p ON e.persona_empleado = p.id_persona
    $conditions $order_by";

// Preparamos la consulta
$stmt_register = $pdo->prepare($query);

if (!empty($params)) {
    foreach ($params as $index => $param) {
        $stmt_register->bindValue($index + 1, $param, PDO::PARAM_STR);
    }
}

// Ejecutamos la consulta
$stmt_register->execute();

// Hacemos un array asociativo de los resultados
$resultadoQuery = $stmt_register->fetchAll(PDO::FETCH_ASSOC);
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
    <?php require_once './incluidos/header.php' ?>

    <main id="mesas_main">
        <div class="container mt-4">
            <!-- Filtros -->
            <form method="GET" class="mb-3">
                <div class="row g-2">
                    <!-- Campo de búsqueda -->
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Buscar..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    </div>

                    <!-- Selección de columna -->
                    <div class="col-md-4">
                        <select name="field" class="form-select">
                            <option value="username_empleado" <?php echo ($_GET['field'] ?? '') === 'username_empleado' ? 'selected' : ''; ?>>Empleado</option>
                            <option value="nombre_persona" <?php echo ($_GET['field'] ?? '') === 'nombre_persona' ? 'selected' : ''; ?>>Nombre Persona</option>
                            <option value="apellido_persona" <?php echo ($_GET['field'] ?? '') === 'apellido_persona' ? 'selected' : ''; ?>>Apellido Persona</option>
                            <option value="detalles_ocupacion" <?php echo ($_GET['field'] ?? '') === 'detalles_ocupacion' ? 'selected' : ''; ?>>Detalles Ocupación</option>
                        </select>
                    </div>

                    <!-- Ordenación -->
                    <div class="col-md-4">
                        <select name="order" class="form-select">
                            <option value="" <?php echo ($_GET['order'] ?? '') === '' ? 'selected' : ''; ?>>Sin orden</option>
                            <option value="asc" <?php echo ($_GET['order'] ?? '') === 'asc' ? 'selected' : ''; ?>>Ascendente</option>
                            <option value="desc" <?php echo ($_GET['order'] ?? '') === 'desc' ? 'selected' : ''; ?>>Descendente</option>
                        </select>
                    </div>

                    <!-- Botón de búsqueda -->
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100" id="botonFiltrar">Filtrar</button>
                    </div>
                </div>
            </form>

            <!-- Tabla de resultados -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden-mobile">ID Ocupación</th>
                        <th class="hidden-mobile">Empleado</th>
                        <th>Nombre Persona</th>
                        <th class="hidden-mobile">Apellido Persona</th>
                        <th class="hidden-mobile">Detalles Ocupación</th>
                        <th class="hidden-mobile">Sillas Recurso</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Final</th>
                        <th>ID Mesa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resultadoQuery)): ?>
                        <?php foreach ($resultadoQuery as $row): ?>
                            <tr>
                                <td class="hidden-mobile"><?php echo htmlspecialchars($row['id_ocupacion']); ?></td>
                                <td class="hidden-mobile"><?php echo htmlspecialchars($row['username_empleado']); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre_persona']); ?></td>
                                <td class="hidden-mobile"><?php echo htmlspecialchars($row['apellido_persona']); ?></td>
                                <td class="hidden-mobile"><?php echo htmlspecialchars($row['detalles_ocupacion']); ?></td>
                                <td class="hidden-mobile"><?php echo htmlspecialchars($row['sillas_recursoOcupacion']); ?></td>
                                <td><?php echo htmlspecialchars($row['fechaInicio_ocupacion']); ?></td>
                                <td><?php echo htmlspecialchars($row['fechaFinal_ocupacion']); ?></td>
                                <td><?php echo htmlspecialchars($row['id_recurso']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No hay ocupaciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
