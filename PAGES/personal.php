<?php
// Iniciamos la sesión
session_start();

// variable donde se guarda cualquier error
$errors = [];

// Requerimos los archivos
require_once '../php/functions.php'; 

// Funcion para saber si se ha iniciado sesion
inicioSesion();

// Funcion para saber si es admin o no
isAdmin();

// Funcion que sanitiza datos por get
$resultadoGET = sanitizarVariables($_GET);

// Incluimos el archivo de conexión a la base de datos
require '../php/conexion.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="../js/validateEmpleado.js"></script>
    <link rel="stylesheet" href="../css/mesas.css">
</head>
<body>
    <?php require_once './incluidos/header.php' ?>

    <main id="mesas_main">
        <?php
        if (isset($resultadoGET['accion'])) {
            if ($resultadoGET['accion'] === "editar") {
                $infoEmpleado = recuperarInfoUsuario($pdo, $resultadoGET['empleado']);
            }
        ?>
            <div id="formCrearUsuario">
                <form action="../php/process_accionEmpleado.php?accion=<?php echo $resultadoGET['accion'] ?>" id="formPersonalizado" method="post">
                    <h1 id="tituloForm">Datos empleado</h1>
                    <br>
                    <label class="labelForm" for=""><strong>Nombre de usuario:</strong><br><input type="text" class="inputPers inputPersCrear" name="usuarioEmpleado" id="usuarioEmpleado" value="<?php echo isset($infoEmpleado['username_empleado']) ? $infoEmpleado['username_empleado'] : '' ?>"></label>
                    <span id="usuarioError" class="error-message"></span>
                    <br>
                    <label class="labelForm" for=""><strong>Nombre:</strong> <input type="text" class="inputPers inputPersCrear" name="nombreEmpleado" id="nombreEmpleado" value="<?php echo isset($infoEmpleado['nombre_persona']) ? $infoEmpleado['nombre_persona'] : '' ?>"></label>
                    <span id="nombreError" class="error-message"></span>
                    <br>
                    <label class="labelForm" for=""><strong>Apellido:</strong> <input type="text" class="inputPers inputPersCrear" name="apellidoEmpleado" id="apellidoEmpleado" value="<?php echo isset($infoEmpleado['apellido_persona']) ? $infoEmpleado['apellido_persona'] : '' ?>"></label>
                    <span id="apellidoError" class="error-message"></span>
                    <br>
                    <label class="labelForm" for=""><strong>Salario:</strong> <input type="text" class="inputPers inputPersCrear" name="salarioEmpleado" id="salarioEmpleado" value="<?php echo isset($infoEmpleado['salario_empleado']) ? $infoEmpleado['salario_empleado'] : '' ?>"></label>
                    <span id="salarioError" class="error-message"></span>
                    <br>
                    <label class="labelForm" for=""><strong>DNI:</strong> <input type="text" class="inputPers inputPersCrear" name="dniEmpleado" id="dniEmpleado" value="<?php echo isset($infoEmpleado['DNI_empleado']) ? $infoEmpleado['DNI_empleado'] : '' ?>"></label>
                    <span id="dniError" class="error-message"></span>
                    <br>
                    <label class="labelForm" for=""><strong>Contraseña:</strong> <input type="password" class="inputPers inputPersCrear" name="pwdEmpleado" id="pwdEmpleado"></label>
                    <span id="pwdError" class="error-message"></span>
                    <br>
                    <button class="btn btn-danger btnSubmitPers"><?php echo $resultadoGET['accion'] === "editar" ? "Editar" : "Crear" ;?></button>
                </form>
            </div>
        <?php
        } else {
            $query = "SELECT empleado.id_empleado, empleado.username_empleado, empleado.salario_empleado, empleado.DNI_empleado, persona.*, tipoEmpleado.* FROM empleado INNER JOIN persona ON empleado.id_empleado=persona.id_persona INNER JOIN tipoEmpleado ON empleado.tipoEmpleado_empleado=tipoEmpleado.id_tipoEmpleado ORDER BY empleado.username_empleado ASC";

            $stmt = $pdo->prepare($query);

            $stmt->execute();

            $resultadoQuery = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <div class="container mt-4">
                <a id="recursosBtn" class="btn btn-danger me-2 btn_custom_logOut btn_Crear" href="./personal.php?accion=crear">Empleado nuevo</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th class="hidden-mobile">Nombre</th>
                            <th class="hidden-mobile">Apellido</th>
                            <th class="hidden-mobile">Tipo</th>
                            <th class="hidden-mobile">DNI</th>
                            <th class="hidden-mobile">Salario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($resultadoQuery)): ?>
                            <?php foreach ($resultadoQuery as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['username_empleado']); ?></td>
                                    <td class="hidden-mobile"><?php echo htmlspecialchars($row['nombre_persona']); ?></td>
                                    <td class="hidden-mobile"><?php echo htmlspecialchars($row['apellido_persona']); ?></td>
                                    <td class="hidden-mobile"><?php echo htmlspecialchars($row['nombre_tipoEmpleado']); ?></td>
                                    <td class="hidden-mobile"><?php echo htmlspecialchars($row['DNI_empleado']); ?></td>
                                    <td class="hidden-mobile"><?php echo htmlspecialchars($row['salario_empleado']); ?></td>
                                    <td>
                                        <a id="recursosBtn" class="btn btn-danger me-2 btn_custom_logOut btn_Editar" href="./personal.php?accion=editar&empleado=<?php echo $row['username_empleado'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a id="recursosBtn" class="btn btn-danger me-2 btn_custom_logOut btn_Eliminar" href="../php/process_accionEmpleado.php?accion=eliminar&empleado=<?php echo $row['id_empleado'] ?>"><i class="fa-solid fa-trash"></i></a>
                                    </td>
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
        <?php
        }
        ?>
    </main>

<script src="../js/modal.js"></script>
</body>
</html>