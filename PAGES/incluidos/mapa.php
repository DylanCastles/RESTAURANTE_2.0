<?php
// Consulta
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

    // Consulta
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
    <a href="./mesas.php?sala=<?php echo $fila1['id_recurso']; ?>" class="divClicable"><div class="sala">
        <h2>Sala <?php echo $fila1['id_recurso'];?></h2>
        <p>Tipo: <?php echo $fila1['nombre_tipoSala'];?></p>
        <div class="imgSalaContenedor">
            <i id="imgSala" class="fa-solid fa-image"></i>
        </div>
        <?php
            foreach ($resultadoQuery2 as $fila2) {

                    // Consulta 
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

                    // Llamamos a funcion para comprobar si la silla esta ocupada
                    if (comprobarEstadoMesa($pdo, $fila2['id_recurso'])) {
                        $mesaOcupada = true;
                    } else {
                        $mesaOcupada = false;
                    }
                ?>
                    <a href="./mesas.php?mesa=<?php echo $fila2['id_recurso']; ?>" class="divClicable"><div style="background-color: <?php echo $mesaOcupada ? "#7e4248;" : "#417544" ;?>;" class="mesa">
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