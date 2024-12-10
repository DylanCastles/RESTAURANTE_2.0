<?php
// Iniciamos la sesión
session_start();

// variable donde se guarda cualquier error
$errors = [];

// Requerimos los archivos
require_once '../php/functions.php'; 

// Verificamos si la sesión del camarero está activa
if (!isset($_SESSION['user_id'])) {

    // Si no está activo, redirigimos a la página de inicio de sesión
    $errors['errorPagina'] = 'noAutorizado';
    redirigirConErrores('./index.php', $errors);
    exit();
}

// Incluimos el archivo de conexión a la base de datos
require '../php/conexion.php';



// Esta funcion no la uso, mirar si la puedo usar
// require '../php/estadoMesaRecuperar.php';



// Recojemos la información del usuario
$info_user = reucperarInfoUsuario($pdo, $_SESSION['user_id']);
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
    <?php require_once './header.php' ?>

    <main id="mesas_main">

        <?php
            // Consulta para saber si el nomrbe de usuario y contraseña son correctos
            $query1 = "SELECT recurso.id_recurso, tipoSala.nombre_tipoSala FROM recurso INNER JOIN tipoRecurso ON recurso.tipoRecurso_recurso = tipoRecurso.id_tipoRecurso INNER JOIN tipoSala ON tipoRecurso.tipoSala_tipoRecurso = tipoSala.id_tipoSala WHERE tipoRecurso.nombre_tipoRecurso = :tiporecurso1";
            
            // Preparamos la consulta con la conexion a la bbdd
            $stmt1 = $pdo->prepare($query1);

            // Vinculamos los parametros (esta parametrizado)
            $recurso1 = 'sala';
            $stmt1->bindParam(':tiporecurso1', $recurso1);

            // Ejecutamos la consulta
            $stmt1->execute();

            // Hacemos un array asociativo de los resultados
            $resultadoQuery1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultadoQuery1 as $fila1) {

                // Consulta para saber si el nomrbe de usuario y contraseña son correctos
                $query2 = "SELECT recurso.id_recurso FROM recurso INNER JOIN tipoRecurso ON recurso.tipoRecurso_recurso = tipoRecurso.id_tipoRecurso WHERE tiporecurso.nombre_tipoRecurso = :tiporecurso2 AND recurso.recursoPadre_recurso = :recursoPadre1";
                
                // Preparamos la consulta con la conexion a la bbdd
                $stmt2 = $pdo->prepare($query2);

                // Vinculamos los parametros (esta parametrizado)
                $recurso2 = 'mesa';
                $stmt2->bindParam(':tiporecurso2', $recurso2);
                $recursoPadre1 = $fila1['id_recurso'];
                $stmt2->bindParam(':recursoPadre1', $recursoPadre1);

                // Ejecutamos la consulta
                $stmt2->execute();

                // Hacemos un array asociativo de los resultados
                $resultadoQuery2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                ?>
                <a href="./hola.php" class="divClicable"><div class="sala">
                    <h2>Sala <?php echo $fila1['id_recurso'];?></h2>
                    <p>Tipo: <?php echo $fila1['nombre_tipoSala'];?></p>
                    <div class="imgSalaContenedor">
                        <i id="imgSala" class="fa-solid fa-image"></i>
                    </div>
                    <?php
                        foreach ($resultadoQuery2 as $fila2) {

                                // Consulta para saber si el nomrbe de usuario y contraseña son correctos
                                $query3 = "SELECT recurso.id_recurso FROM recurso INNER JOIN tipoRecurso ON recurso.tipoRecurso_recurso = tipoRecurso.id_tipoRecurso WHERE tiporecurso.nombre_tipoRecurso = :tiporecurso3 AND recurso.recursoPadre_recurso = :recursoPadre2";
                                
                                // Preparamos la consulta con la conexion a la bbdd
                                $stmt3 = $pdo->prepare($query3);

                                // Vinculamos los parametros (esta parametrizado)
                                $recurso3 = 'silla';
                                $stmt3->bindParam(':tiporecurso3', $recurso3);
                                $recursoPadre2 = $fila2['id_recurso'];
                                $stmt3->bindParam(':recursoPadre2', $recursoPadre2);

                                // Ejecutamos la consulta
                                $stmt3->execute();

                                // Hacemos un array asociativo de los resultados
                                $resultadoQuery3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                                <a href="./adios.php" class="divClicable"><div class="mesa">
                                    <span><h5>Mesa <?php echo $fila2['id_recurso'];?></h5></span>
                                    <span>Sillas: <?php echo count($resultadoQuery3)?></span>
                                </div></a>
                            <?php
                        }
                    ?>
                </div></a>
                <?php
            }
        ?>
    </main>
</body>
</html>