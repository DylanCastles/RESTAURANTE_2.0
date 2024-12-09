<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "restaurante_bbdd";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);

    // Para obtener más detalles si ocurre un error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
    die("Conexión fallida.");
}
?>
