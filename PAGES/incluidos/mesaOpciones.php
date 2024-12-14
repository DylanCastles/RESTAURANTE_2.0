<?php
$id_mesa = $variablesGET['mesa'];
$idSala = reucuperarIdSala($pdo, $id_mesa);
$cantidadSillas = reucuperarCantidadSillas($pdo, $id_mesa);
$estadoMesa = comprobarEstadoMesa($pdo, $id_mesa);
?>

<div id="formOpcionesRecurso">
    <?php
        if ($estadoMesa) {
                $idOcupacion = comprobarIdOcupacionMesa($pdo, $id_mesa);
                // Consulta para saber si el nomrbe de usuario y contraseña son correctos
                $queryOcupacion = "SELECT ocupacion.*, empleado.username_empleado, persona.nombre_persona, persona.apellido_persona FROM ocupacion INNER JOIN recursoOcupacion ON recursoOcupacion.ocupacion_recursoOcupacion = ocupacion.id_ocupacion INNER JOIN empleado ON ocupacion.empleado_ocupacion = empleado.id_empleado INNER JOIN cliente ON ocupacion.cliente_ocupacion = cliente.id_cliente INNER JOIN persona ON cliente.persona_cliente = persona.id_persona WHERE ocupacion.id_ocupacion = :idOcupacion;";

                // Preparamos la consulta con la conexion a la bbdd
                $stmtOcupacion = $pdo->prepare($queryOcupacion);

                // Vinculamos los parametros (esta parametrizado)
                $stmtOcupacion->bindParam(':idOcupacion', $idOcupacion);

                // Ejecutamos la consulta
                $stmtOcupacion->execute();

                // Hacemos un array asociativo de los resultados
                $resultadoQueryOcupacion = $stmtOcupacion->fetch(PDO::FETCH_ASSOC);
            ?>
            <div id="formPersonalizado2" method="post">
                <h1 id="tituloForm">Reserva mesa <?php echo $id_mesa; ?></h1>
                <br>
                <p><strong>Sala:</strong> <?php echo $idSala['recursoPadre_recurso'] ?></p>
                <p><strong>Sillas:</strong> <?php echo $cantidadSillas['sillasMesa'] ?></p>
                <p><strong>Estado:</strong> <span class="ocupadoEstilo">ocupado</span></p>
                <p><strong>Empleado asignacion:</strong><?php echo " " . $resultadoQueryOcupacion['username_empleado'] ?></p>
                <p><strong>Nombre cliente:</strong><?php echo " " . $resultadoQueryOcupacion['nombre_persona'] ?></p>
                <p><strong>Apellido cliente:</strong><?php echo " " . $resultadoQueryOcupacion['apellido_persona'] ?></p>
                <p><strong>Detalles:</strong><?php echo " " . $resultadoQueryOcupacion['detalles_ocupacion'] ?></p>
                <p><strong>Fecha inicio:</strong><?php echo " " . $resultadoQueryOcupacion['fechaInicio_ocupacion'] ?></p>
                <p><strong>Fecha final:</strong><?php echo " " . $resultadoQueryOcupacion['fechaFinal_ocupacion'] ?></p>
                <a class="btn btn-danger btnSubmitPers" href='../php/process_eliminarReserva.php?<?php echo "reserva=" . $resultadoQueryOcupacion['id_ocupacion'] . "&mesa=" . $id_mesa ?>'>Desocupar</a>
            </div>
            <form action="../php/process_ocuparMesa.php" id="formPersonalizado" method="post">
                <h1 id="tituloForm">Reservar mesa <?php echo $id_mesa; ?></h1>
                <br>
                <label class="labelForm" for=""><strong>Nombre cliente:</strong> <input type="text" class="inputPers inputPersTexto" name="nombreCliente" id="nombreCliente" value="<?php echo isset($variablesGET['nombre']) ? $variablesGET['nombre'] : '' ?>"></label>
                <span id="nombreError" class="error-message"></span>
                <br>
                <br>
                <label class="labelForm" for=""><strong>Apellido cliente:</strong> <input type="text" class="inputPers inputPersTexto" name="apellidoCliente" id="apellidoCliente" value="<?php echo isset($variablesGET['apellido']) ? $variablesGET['apellido'] : '' ?>"></label>
                <span id="apellidoError" class="error-message"></span>
                <br>
                <br>
                <label class="labelForm" for=""><strong>Detalles:</strong> <input type="text" class="inputPers inputPersTextoLargo" name="detallesReserva" id="detallesReserva" value="<?php echo isset($variablesGET['detalles']) ? $variablesGET['detalles'] : '' ?>"></label>
                <span id="detallesError" class="error-message"></span>
                <br>
                <label><strong>Fecha:</strong>
                    <input class="inputPers" type="datetime-local" name="fechaReserva" id="fechaReserva">
                </label>
                <br>
                <br>
                <label><strong>Tiempo:</strong>
                <select class="inputPers" name="tiempoReserva" id="tiempoReserva">
                    <option value="1">1 hora</option>
                    <option value="2">2 horas</option>
                    <option value="3">3 horas</option>
                    <option value="4">4 horas</option>
                </select>
                </label>
                <span id="fechaHoraError" class="error-message"></span>
                <br>
                <br>
                <input type="hidden" name="option" value="reserva">
                <input type="hidden" name="mesa" value="<?php echo $id_mesa; ?>">
                <button class="btn btn-danger btnSubmitPers">Ocupar</button>
            </form>

            <?php
        } else {
            ?>
            <form action="../php/process_ocuparMesa.php" id="formPersonalizado" method="post">
                <h1 id="tituloForm">Reservar mesa <?php echo $id_mesa; ?></h1>
                <br>
                <p><strong>Sala:</strong> <?php echo $idSala['recursoPadre_recurso'] ?></p>
                <p><strong>Sillas:</strong> <?php echo $cantidadSillas['sillasMesa'] ?></p>
                <p><strong>Estado:</strong> <span class="libreEstilo">libre</span></p>
                <label class="labelForm" for=""><strong>Nombre cliente:</strong> <input type="text" class="inputPers inputPersTexto" name="nombreCliente" id="nombreCliente" value="<?php echo isset($variablesGET['nombre']) ? $variablesGET['nombre'] : '' ?>"></label>
                <span id="nombreError" class="error-message"></span>
                <br>
                <br>
                <label class="labelForm" for=""><strong>Apellido cliente:</strong> <input type="text" class="inputPers inputPersTexto" name="apellidoCliente" id="apellidoCliente" value="<?php echo isset($variablesGET['apellido']) ? $variablesGET['apellido'] : '' ?>"></label>
                <span id="apellidoError" class="error-message"></span>
                <br>
                <br>
                <label class="labelForm" for=""><strong>Detalles:</strong> <input type="text" class="inputPers inputPersTextoLargo" name="detallesReserva" id="detallesReserva" value="<?php echo isset($variablesGET['detalles']) ? $variablesGET['detalles'] : '' ?>"></label>
                <span id="detallesError" class="error-message"></span>
                <br>
                <br>
                <p><strong>Tipo:</strong></p>
                <label>
                    <input type="radio" id="radioAhora" class="form-check-input" name="option" value="ahora"><strong>Ahora</strong>
                </label>
                <label id="opcionRadioAhora" style="display: none;">Tiempo:
                <select class="inputPers" name="tiempoAhora" id="tiempoAhora">
                    <option value="1">1 hora</option>
                    <option value="2">2 horas</option>
                    <option value="3">3 horas</option>
                    <option value="4">4 horas</option>
                </select>
                </label>
                <br>
                <br>
                <label>
                    <input type="radio" id="radioReserva" class="form-check-input" name="option" value="reserva"><strong>Reserva</strong>
                </label>
                <label id="opcionRadioReserva" style="display: none;">
                    <label>Fecha:
                        <input class="inputPers" type="datetime-local" name="fechaReserva" id="fechaReserva">
                    </label>
                    <label>Tiempo:
                    <select class="inputPers" name="tiempoReserva" id="tiempoReserva">
                        <option value="1">1 hora</option>
                        <option value="2">2 horas</option>
                        <option value="3">3 horas</option>
                        <option value="4">4 horas</option>
                    </select>
                    </label>
                </label>
                <span id="fechaHoraError" class="error-message"></span>
                <br>
                <br>
                <input type="hidden" name="mesa" value="<?php echo $id_mesa; ?>">
                <button class="btn btn-danger btnSubmitPers">Ocupar</button>
            </form>
            <?php
        }
    ?>
    
</div>

<div id="reservasEncontradas">
    <h1 id="tituloForm">Reservas futuras:</h1>
    <?php
    // Crear objeto a partir de la fecha y hora actual
    $fechaHoraActual = new DateTime();
    // Añadirle una hora al objeto de la fecha/hora actual para que sea como España
    $fechaHoraActual->modify('+ 1 hour');
    // Guardar en la variable fechaInicio la fecha/hora actual formateada
    $fechaHoraActual = $fechaHoraActual->format('Y-m-d H:i:s');

    // Consulta para saber si el nomrbe de usuario y contraseña son correctos
    $query = "SELECT ocupacion.*, empleado.username_empleado, persona.nombre_persona, persona.apellido_persona FROM ocupacion INNER JOIN recursoOcupacion ON recursoOcupacion.ocupacion_recursoOcupacion = ocupacion.id_ocupacion INNER JOIN empleado ON ocupacion.empleado_ocupacion = empleado.id_empleado INNER JOIN cliente ON ocupacion.cliente_ocupacion = cliente.id_cliente INNER JOIN persona ON cliente.persona_cliente = persona.id_persona WHERE fechaInicio_ocupacion > :fechaHoraActual AND recursoOcupacion.recurso_recursoOcupacion = :mesaEscogida ORDER BY fechaInicio_ocupacion DESC;";

    // Preparamos la consulta con la conexion a la bbdd
    $stmt = $pdo->prepare($query);

    // Vinculamos los parametros (esta parametrizado)
    $stmt->bindParam(':fechaHoraActual', $fechaHoraActual);
    $stmt->bindParam(':mesaEscogida', $id_mesa);

    // Ejecutamos la consulta
    $stmt->execute();

    // Hacemos un array asociativo de los resultados
    $resultadoQuery = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h5>Resultados: " . count($resultadoQuery) . "</h5>";
    if ($resultadoQuery) {
        foreach ($resultadoQuery as $fila) {
            echo "
                <div class='reservaEncontradaDiv'>
                    <p class='interiorReserva'>
                        Empleado asignacion: " . $fila['username_empleado'] . "
                        <br>
                        Cliente: " . $fila['nombre_persona'] . " " . $fila['apellido_persona'] . "
                        <br>
                        Fecha inicio: " . $fila['fechaInicio_ocupacion'] . "
                        <br>
                        Fecha final: " . $fila['fechaFinal_ocupacion'] . "
                        <br>
                        Detalles: " . $fila['detalles_ocupacion'] . "
                    </p>
                    <a class='btn btn-danger btnEliminarReserva' href='../php/process_eliminarReserva.php?reserva=" . $fila['id_ocupacion'] . "&mesa=" . $id_mesa . "'>Eliminar reserva</a>
                </div>
            ";
        }
    }
    ?>
</div>

<?php
    if (isset($variablesGET['errorReservar'])) {
        if ($variablesGET['errorReservar'] === "fechasMal") {
            echo "
            <script type='text/javascript'>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '¡No se puede reservar en esta hora!',
                        text: 'Revisa las reservas programadas y cambia la fecha.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
            ";
        }
    }
?>