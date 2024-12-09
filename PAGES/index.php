<?php
    require_once '../php/functions.php';

    $resultado = sanitizarVariables($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <script src="../js/validateLogin.js"></script>
    <title>Iniciar Sesión</title>
</head>
<body>
    <div id="contenedorPrincipal">
        <div id="contenedorLogo">
            <img src="../img/logoWestfield.png" alt="Dinner at Westfield Logo" class="logo">
        </div>
        <div id="contenedorForm">
            <div id="contenedorFormFlotante">
                <div id="logoResponsive">
                    <img src="../img/logoWestfield.png" alt="Dinner at Westfield Logo" class="logo">
                </div>
                <form action="../php/process_login.php" method="POST" id="formulario">
                    <h1>INICIAR SESIÓN</h1>
                    <input type="text" name="user" id="user" placeholder="Usuario">
                    <span id="userError" class="error-message"></span>
                    <br><br>
                    <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña">
                    <span id="passwordError" class="error-message">
                        <?php
                            if (!empty($_GET['errorLogin'])) {
                                if ($_GET['errorLogin'] === 'camposIncorrectos') {
                                    echo "Usuario o contraseña incorrectos.";
                                }
                            }
                        ?>
                    </span>
                    <br><br>
                    <button type="submit" name="submit_form" id="submit_form">ENTRAR</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>