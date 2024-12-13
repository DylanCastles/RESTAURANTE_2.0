<?php
$id_mesa = $variablesGET['mesa'];
$idSala = reucuperarIdSala($pdo, $id_mesa);
$cantidadSillas = reucuperarCantidadSillas($pdo, $id_mesa);
?>

<div id="formOpcionesRecurso">
    <form action="../php/process_mesa.php" id="formPersonalizado" method="post">
        <h1 id="tituloForm">Reservar mesa <?php echo $variablesGET['mesa']; ?></h1>
        <br>
        <p><strong>Sala:</strong> <?php echo $idSala['recursoPadre_recurso'] ?></p>
        <p><strong>Sillas:</strong> <?php echo $cantidadSillas['sillasMesa'] ?></p>
        <p><strong>Estado:</strong> <span class="libreEstilo">libre</span></p>
        <label class="labelForm" for=""><strong>Nombre cliente:</strong> <input type="text" class="inputPers inputPersTexto" name="nombreCliente" id="nombreCliente"></label>
        <span id="nombreError" class="error-message"></span>
        <br>
        <br>
        <label class="labelForm" for=""><strong>Apellido cliente:</strong> <input type="text" class="inputPers inputPersTexto" name="apellidoCliente" id="apellidoCliente"></label>
        <span id="apellidoError" class="error-message"></span>
        <br>
        <br>
        <label class="labelForm" for=""><strong>Detalles:</strong> <input type="text" class="inputPers inputPersTextoLargo" name="detallesReserva" id="detallesReserva"></label>
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
</div>