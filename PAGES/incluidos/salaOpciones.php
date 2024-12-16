<?php
require_once '../php/functions.php'; 
$resultadoGET = sanitizarVariables($_GET);
?>
<div id="formOpcionesRecurso">
    <label for="divFoto"><h2>Imagen seleccionada:</h2></label>
    <div id="divFoto" 
        style="background-image: url('<?php 
            echo file_exists('../img/imgSalas/sala' . $resultadoGET['sala'] . 'foto.jpg') 
                ? '../img/imgSalas/sala' . $resultadoGET['sala'] . 'foto.jpg' 
                : '../img/noFoto.jpg'; 
        ?>');">
    </div>
    <span style="color: red;">
        <?php 
        echo isset($resultadoGET['ErrorExtension']) ? ($resultadoGET['ErrorExtension'] === 'true' ? "Selecciona una imagen." : "" ) : "";
        echo isset($resultadoGET['MalExtension']) ? ($resultadoGET['MalExtension'] === 'true' ? "Selecciona una imagen de tipo png." : "" ) : "";
        ?>
        </span>
    <br>
    <br>
    <form action="../php/procesoSubirFoto.php?sala=<?php echo $resultadoGET['sala'];?>" method="post" enctype="multipart/form-data">
        <label for="file">Seleccionar fichero:</label>
        <!-- Mediante un campo oculto, establecemos el tamaño máximo permitido
        (en BYTES) será de 2Mb (2x1024x1024) que luego se controlará con
        UPLOAD_ERR_FORM_SIZE-->
        <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    
        <input type="file" name="file" id="file">
        <br><br>
        <input type="submit" class="btnSubmitPers" value="Subir">
    </form>
</div>