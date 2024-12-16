<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once '../php/functions.php'; 

$resultadoGET = sanitizarVariables($_GET);


 // Obtenemos la información del fichero subido

// Devuelve la ruta temporal donde se sube el archivo
 $ruta_temporal = $_FILES['file']['tmp_name'];
// Nombre completo del archivo subido. Incluye extensión
 $nombrecompleto_fichero = $_FILES['file']['name'];
// Tipo de archivo subido
 $tipo_fichero = $_FILES['file']['type'];           
// Devuelve el tamaño del archivo en bytes.
 $tamanio_fichero = $_FILES['file']['size'];        
// Devuelve un código de error si se produce
 $error_fichero = $_FILES['file']['error'];         

 if ($tipo_fichero != "image/jpg") {
    $error = "La foto tiene que estar en formato PNG.";
    header('Location: ../PAGES/mesas.php?sala=' . $resultadoGET['sala'] . '&MalExtension=true');
    exit; // Detener la ejecución para evitar que se sigan ejecutando más líneas de código.
}


 // realizamos un "explode", que es una operación de "división" o "separación"
 // de una cadena (string) en un array de subcadenas, utilizando
 // un delimitador específico, en este caso un ".". El resultado se guarda
 // en un array donde [0] => NombreDocumento y [1] => ExtensiónDocumento.
 // Finalmente recogemos el último elemento del array con la función 'end()'
 // para obtener su extensión. Así, si hay más "." en el nombre, nos aseguramos
 // de obtener siempre la extensión.
 $array_fichero = explode(".", $nombrecompleto_fichero);


// Recupera el primer objeto del array, que contiene el nombre sin la extensión
 $nombre_fichero = $array_fichero[0];


//Recupera el último objeto del array, que contiene la extensión
 $extension_fichero = strtolower(end($array_fichero));


 // Se define el directorio donde deseas guardar los ficheros subidos
 $directorio_destino = '../img/imgSalas/';
 // DEBUG
echo "Ruta temporal: ".$ruta_temporal."<br>";
echo "Nombre Completo del fichero: ".$nombrecompleto_fichero."<br>";
echo "Tipo de fichero: ".$tipo_fichero."<br>";
echo "Tamaño del Fichero: ".$tamanio_fichero."<br>";
echo "Error (Si se produce): ".$error_fichero."<br>";
echo "Array fichero: ";
var_dump($array_fichero);
echo "<br>";
echo "Extensión fichero: ".$nombre_fichero."<br>";
echo "Extensión fichero: ".$extension_fichero."<br>";
echo "Directorio destino: ".$directorio_destino."<br>";
 
 // --------------------------
 // VALIDACIONES
 // --------------------------


 // Comprueba si el archivo tiene una extensión permitida
 $extensiones_permitidas = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');


 // DEBUG
echo "Extensiones permitidas: ";
var_dump($extensiones_permitidas);
echo "<br>";
 //


 // --------------------------
 if (!in_array($extension_fichero, $extensiones_permitidas))
 {
    $error="El archivo es de un tipo no permitido";
    header('location: ../PAGES/mesas.php?sala=' . $resultadoGET['sala'] . '&ErrorExtension=true');
 }
 else
 {
    // --------------------------
    // Establecemos la redirección de errores a un archivo de registro utilizando la
    // función error_reporting(0) para desactivar la visualización de errores en pantalla.
    // Además, configuramos la redirección de errores utilizando ini_set('log_errors', 1) y
    // ini_set('error_log', 'error_log.txt'). Esto hará que los errores se registren en un
    // archivo llamado "error_log.txt" en lugar de mostrarse en pantalla.
    error_reporting(0);
    ini_set('log_errors', 1);
    ini_set('error_log', 'error_log.txt');


    // Comprobamos si ho hay errores DE SUBIDA
    if ($error_fichero === UPLOAD_ERR_OK) {
        // Cambiamos el nombre del fichero.
        // La función uniqid() genera una cadena única basada en la hora actual
        // en microsegundos para evitar conflictos en los nombres de ficheros y
        // asegurarse de que el nuevo nombre sea único en cada subida de fichero.
        $nombreNuevo_fichero = "sala" . $resultadoGET['sala'] . "foto";
        $nombre_nuevo = $nombreNuevo_fichero . "." . $extension_fichero;


        // COMPOSICIÓN DE NOMBRE ALTERNATIVA:
        $nombre_nuevoMD5 = md5(time() . $nombre_fichero) . '.' . $extension_fichero;
       
        //DEBUG
        echo "Nombre nuevo: ".$nombre_nuevo."<br>";
        echo "Nombre nuevo MD5: ".$nombre_nuevoMD5."<br>";


        // Mover el fichero subido al directorio de destino con el nuevo nombre
        if (move_uploaded_file($ruta_temporal, $directorio_destino . $nombre_nuevo)) {
            echo "Fichero subido y renombrado correctamente.";
            header('location: ../PAGES/mesas.php?sala=' . $resultadoGET['sala']);
            exit;
        } else {
            echo "Error al mover el fichero.";
        }


    } else {




    // SI HAY errores DE SUBIDA, mostramos el error que ha pasado.
        echo "Error en la subida del fichero: ";
        switch ($error_fichero) {
           
            case UPLOAD_ERR_INI_SIZE:
             // El archivo excede el tamaño máximo permitido según la directiva
             // upload_max_filesize en el archivo de configuración PHP.
           
            case UPLOAD_ERR_FORM_SIZE:
             // (valor 1): El usuario intenta subir un fichero que excede el tamaño máximo
             // permitido (se indicó un MAX_FILE_SIZE de 2 MB), al procesar el formulario
             // con lo que produce error UPLOAD_ERR_FORM_SIZE en $_FILES['file']['error']
             // y se mostrará un mensaje indicando que el fichero excede el tamaño máximo
             // permitido.
                echo "Error: El fichero excede el tamaño máximo permitido (2 MB).";
                break;


            case UPLOAD_ERR_PARTIAL:
             // (valor 3): El archivo se subió parcialmente, es decir, la carga se detuvo
             // antes de completarse.
                echo "El fichero no se subió completamente.";
                break;


            case UPLOAD_ERR_NO_FILE:
             // (valor 4): No se seleccionó ningún archivo para cargar.
                echo "Ningún fichero fue subido.";
                break;


            case UPLOAD_ERR_NO_TMP_DIR:
             // (valor 6): Falta el directorio temporal necesario para cargar archivos.
                echo "Falta la carpeta temporal.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
             // (valor 7): No se pudo escribir el archivo en el disco.
                echo "No se pudo escribir el fichero en el disco.";
                break;


            case UPLOAD_ERR_EXTENSION:
             // (valor 8): Una extensión de PHP detuvo la carga del archivo.
                echo "Subida de fichero detenida por la extensión.";
                break;
            default:
                echo "Error desconocido.";
                break;
        }
    }
 }
}
?>
