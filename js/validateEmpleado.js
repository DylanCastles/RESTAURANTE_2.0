// Validaciones del form crear empleado

// ------------------------------------------------------------------------------------------------------------------
// Para prevenir que se envie el formulario

window.onload = function() {
    document.getElementById('formCrearUsuario').addEventListener('submit', function(event) {
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });
    document.getElementById('usuarioEmpleado').addEventListener('blur', function() {
        validarUsuario(this);
    });
    document.getElementById('usuarioEmpleado').addEventListener('keyup', function() {
        validarUsuario(this);
    });
    document.getElementById('nombreEmpleado').addEventListener('blur', function() {
        validarNombre(this);
    });
    document.getElementById('nombreEmpleado').addEventListener('keyup', function() {
        validarNombre(this);
    });
    document.getElementById('apellidoEmpleado').addEventListener('blur', function() {
        validarApellido(this);
    });
    document.getElementById('apellidoEmpleado').addEventListener('keyup', function() {
        validarApellido(this);
    });
    document.getElementById('salarioEmpleado').addEventListener('blur', function() {
        validarSalario(this);
    });
    document.getElementById('salarioEmpleado').addEventListener('keyup', function() {
        validarSalario(this);
    });
    document.getElementById('dniEmpleado').addEventListener('blur', function() {
        validarDni(this);
    });
    document.getElementById('dniEmpleado').addEventListener('keyup', function() {
        validarDni(this);
    });
    document.getElementById('pwdEmpleado').addEventListener('blur', function() {
        validarPwd(this);
    });
    document.getElementById('pwdEmpleado').addEventListener('keyup', function() {
        validarPwd(this);
    });
};

// ------------------------------------------------------------------------------------------------------------------
// Validar campos

function validarFormulario() {
    let usuarioValido = validarUsuario(document.getElementById('usuarioEmpleado'));
    let nombreValido = validarNombre(document.getElementById('nombreEmpleado'));
    let apellidoValido = validarApellido(document.getElementById('apellidoEmpleado'));
    let salarioValido = validarSalario(document.getElementById('salarioEmpleado'));
    let dniValido = validarDni(document.getElementById('dniEmpleado'));
    let pwdValido = validarPwd(document.getElementById('pwdEmpleado'));

    return usuarioValido && nombreValido && apellidoValido && salarioValido && dniValido && pwdValido;
}

// ------------------------------------------------------------------------------------------------------------------
// Validaciones campos

// VALIDACION USUARIO
// - No puede estar vacío.
// - No puede contener mas de 100 caracteres.
// - Minimo 6 caracteres

function validarUsuario(input) {
    const userField = input.value.trim();
    const userError = document.getElementById("usuarioError");

    if (userField === "") {
        userError.textContent = "El nombre de usuario no puede estar vacío.";
        input.classList.add("error");
        return false;
    }

    if (userField.length < 6) {
        userError.textContent = "El nombre de usuario debe tener al menos 6 caracteres.";
        input.classList.add("error");
        return false;
    }

    if (userField.length > 100) {
        userError.textContent = "El nombre de usuario no puede contener mas de 100 caracteres.";
        input.classList.add("error");
        return false;
    }

    userError.textContent = "";
    input.classList.remove("error");

    return true;
}


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


// VALIDACION SALARIO
// - Solo puede contener números
// - No puede contener más de 6 dígitos

function validarSalario(input) {
    const salarioField = input.value.trim();
    const salarioError = document.getElementById("salarioError");

    if (salarioField === "") {
        salarioError.textContent = "";
        input.classList.remove("error");

        return true;
    }

    if (!/^\d+$/.test(salarioField)) {
        salarioError.textContent = "El campo salario solo puede contener números.";
        input.classList.add("error");
        return false;
    }

    if (salarioField.length > 6) {
        salarioError.textContent = "El campo salario no puede contener más de 6 dígitos.";
        input.classList.add("error");
        return false;
    }

    salarioError.textContent = "";
    input.classList.remove("error");

    return true;
}



// VALIDACION DNI
// - No puede estar vacío
// - Tiene que tener el formato correcto
// - Tiene que tener la letra correcta

function validarDni(input) {
    const userField = input.value.trim().toUpperCase();
    const userError = document.getElementById("dniError");

    if (!userField) {
        userError.textContent = "El DNI no puede estar vacío.";
        input.classList.add("error");
        return false;
    }

    const dniRegex = /^[0-9]{8}[A-Z]$/;
    if (!dniRegex.test(userField)) {
        userError.textContent = "El formato del DNI no es correcto.";
        input.classList.add("error");
        return false;
    }

    const letras = "TRWAGMYFPDXBNJZSQVHLCKE";
    const numeros = parseInt(userField.slice(0, 8), 10);
    const letra = userField.slice(-1);
    const letraCorrecta = letras[numeros % 23];

    if (letra !== letraCorrecta) {
        userError.textContent = `La letra del DNI no es correcta ("${letraCorrecta}")`;
        input.classList.add("error");
        return false;
    }

    userError.textContent = "";
    input.classList.remove("error");

    return true;
}


// VALIDACION PWD
// - No puede estar vacío
// - Mínimo 6 caracteres

function validarPwd(input) {
    const pwdField = input.value.trim();
    const pwdError = document.getElementById("pwdError");

    if (pwdField === "") {
        pwdError.textContent = "El campo contraseña no puede estar vacío.";
        input.classList.add("error");
        return false;
    }

    if (pwdField.length < 6) {
        pwdError.textContent = "La contraseña debe tener al menos 6 caracteres.";
        input.classList.add("error");
        return false;
    }

    pwdError.textContent = "";
    input.classList.remove("error");

    return true;
}
