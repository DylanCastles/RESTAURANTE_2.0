// Validaciones del form mesas y hacer dinamicas las opciones del form

// ------------------------------------------------------------------------------------------------------------------
// Para prevenir que se envie el formulario

window.onload = function() {
    document.getElementById('formPersonalizado').addEventListener('submit', function(event) {
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });
    document.getElementById('nombreCliente').addEventListener('blur', function() {
        validarNombre(this);
    });
    document.getElementById('nombreCliente').addEventListener('keyup', function() {
        validarNombre(this);
    });
    document.getElementById('apellidoCliente').addEventListener('blur', function() {
        validarApellido(this);
    });
    document.getElementById('apellidoCliente').addEventListener('keyup', function() {
        validarApellido(this);
    });
    document.getElementById('detallesReserva').addEventListener('blur', function() {
        validarDetalles(this);
    });
    document.getElementById('detallesReserva').addEventListener('keyup', function() {
        validarDetalles(this);
    });
    document.getElementById('fechaReserva').addEventListener('change', function() {
        validarFechaHora(this);
    });
    document.getElementById('fechaReserva').addEventListener('blur', function() {
        validarFechaHora(this);
    });

    // Hacer dinamicos los radio inputs
    const opcionAhora = document.getElementById('opcionRadioAhora');
    const opcionReserva = document.getElementById('opcionRadioReserva');
    opcionEscogida = "";
    const radioAhora = document.getElementById('radioAhora');
    const radioReserva = document.getElementById('radioReserva');

    if (radioAhora && radioReserva) {
        radioAhora.addEventListener('change', function() {
            opcionAhora.style.display = "inline-block";
            opcionReserva.style.display = "none";
            opcionEscogida = "ahora";
            document.getElementById("fechaHoraError").textContent = "";
        });
        radioReserva.addEventListener('change', function() {
            opcionReserva.style.display = "inline-block";
            opcionAhora.style.display = "none";
            opcionEscogida = "";
        });
    }
};

// ------------------------------------------------------------------------------------------------------------------
// Validar campos

function validarFormulario() {
    let nombreValido = validarNombre(document.getElementById('nombreCliente'));
    let apellidoValido = validarApellido(document.getElementById('apellidoCliente'));
    let detallesValido = validarDetalles(document.getElementById('detallesReserva'));
    let fechaValido = validarFechaHora(document.getElementById('fechaReserva'));

    return nombreValido && apellidoValido && detallesValido && fechaValido;
}

// ------------------------------------------------------------------------------------------------------------------
// Validaciones campos

// VALIDACION NOMBRE
// - No puede estar vacío.
// - Solo puede contener letras.
// - No puede contener mas de 30 caracteres.

function validarNombre(input) {
    const userField = input.value.trim();
    const userError = document.getElementById("nombreError");
    const regexSoloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/;

    if (userField === "") {
        userError.textContent = "El nombre no puede estar vacío.";
        input.classList.add("error");
        return false;
    }

    if (!regexSoloLetras.test(userField)) {
        userError.textContent = "El nombre solo puede contener letras.";
        input.classList.add("error");
        return false;
    }

    if (userField.length > 30) {
        userError.textContent = "El nombre no puede contener mas de 30 caracteres.";
        input.classList.add("error");
        return false;
    }

    userError.textContent = "";
    input.classList.remove("error");

    return true;
}


// VALIDACION APELLIDO
// - No puede estar vacío
// - Solo puede contener letras.
// - No puede contener mas de 60 caracteres

function validarApellido(input) {
    const userField = input.value.trim();
    const userError = document.getElementById("apellidoError");
    const regexSoloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/;

    if (userField === "") {
        userError.textContent = "El apellido no puede estar vacío.";
        input.classList.add("error");
        return false;
    }

    if (!regexSoloLetras.test(userField)) {
        userError.textContent = "El apellido solo puede contener letras.";
        input.classList.add("error");
        return false;
    }

    if (userField.length > 60) {
        userError.textContent = "El apellido no puede contener mas de 60 caracteres.";
        input.classList.add("error");
        return false;
    }

    userError.textContent = "";
    input.classList.remove("error");

    return true;
}


// VALIDACION DETALLES
// - No puede contener mas de 100 caracteres

function validarDetalles(input) {
    const userField = input.value.trim();
    const userError = document.getElementById("detallesError");

    if (userField.length > 100) {
        userError.textContent = "Este campo no puede contener mas de 100 caracteres.";
        input.classList.add("error");
        return false;
    }

    userError.textContent = "";
    input.classList.remove("error");

    return true;
}

// VALIDACION FECHA HORA (solo para reservas)
// - No puede estar vacio
// - La fecha/hora no puede ser anterior a la de ahora

function validarFechaHora(input) {

    const now = new Date();
    now.setHours(now.getHours() + 1);
    const currentDateTime = now.toISOString().slice(0, 16);

    const userField = input.value;
    const userError = document.getElementById("fechaHoraError");

    if (opcionEscogida === "ahora") {
        userError.textContent = "";
        input.classList.remove("error");
        return true;
    }

    if (userField === "") {
        userError.textContent = "Es obligatorio escoger una fecha y hora.";
        input.classList.add("error");
        return false;
    }

    if (userField < currentDateTime) {
        userError.textContent = "La fecha seleccionada no puede ser anterior a la fecha y hora actual.";
        input.classList.add("error");
        return false;
    }

    const validDateTimePattern = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/;
    if (!validDateTimePattern.test(userField)) {
        userError.textContent = "Por favor, selecciona una fecha y hora válidas.";
        input.classList.add("error");
        return false;
    }

    userError.textContent = "";
    input.classList.remove("error");

    return true;
}
