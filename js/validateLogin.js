// Validaciones del login

// ------------------------------------------------------------------------------------------------------------------
// Para prevenir que se envie el formulario

window.onload = function() {
    document.getElementById('formulario').addEventListener('submit', function(event) {
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });
};

// ------------------------------------------------------------------------------------------------------------------
// Validar ambos campos

function validarFormulario() {
    let nombreValido = validarNombre(document.getElementById('user'));
    let pswdValido = validarPswd(document.getElementById('contrasena'));

    return nombreValido && pswdValido;
}

// ------------------------------------------------------------------------------------------------------------------
// Validaciones campos

// VALIDACION NOMBRE
// - No puede estar vacío

function validarNombre(input) {
    const userField = input.value.trim();
    const userError = document.getElementById("userError");

    if (userField === "") {
        userError.textContent = "El usuario no puede estar vacío.";
        input.classList.add("error");
        return false;
    } 

    userError.textContent = "";
    input.classList.remove("error");

    return true;
}


// VALIDACIÓN CONTRASEÑA
// - No puede estar vacía

function validarPswd(input) {
    const passwordField = input.value.trim();
    const passwordError = document.getElementById("passwordError");

    if (passwordField === "") {
        passwordError.textContent = "La contraseña no puede estar vacía.";
        input.classList.add("error");
        return false;
    }

    passwordError.textContent = "";
    input.classList.remove("error");

    return true;
}
