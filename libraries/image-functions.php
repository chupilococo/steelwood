<?php
/**
 * Retorna la extensión del nombre de un archivo.
 *
 * @param string $filename
 * @return bool|string
 */
function getExtension($filename) {
    // Para obtener la extensión de un archivo, tenemos que obtener
    // el contenido que sigue al último punto.
    // Primero, obtenemos la ubicación del último punto usando
    // la función strrpos().
    // Una vez que obtuvimos eso, usamos la función substr() para
    // obtener el fragmento. substr() permite obtener un fragmento
    // de un string. Le pasamos primero el string del cual queremos
    // sacar un fragmento, y luego le pasamos desde donde queremos
    // empezar a "obtener".
    return substr($filename, strrpos($filename, '.') + 1);
}

/**
 * Crea una imagen a partir de la $extension proporcionada.
 * De no brindar ninguna, trata de obtenerla desde el $imagePath.
 * Retorna false si la extensión no es "jpg", "jpeg", "gif" o "png",
 * o si ocurre algún error.
 *
 * @param string $imagePath
 * @param string|null $extension
 * @return bool|resource
 */
function createImage($imagePath, $extension = null) {
    $extension = $extension ?? getExtension($imagePath);

    // Para crear una imagen a partir de otra, GD library ofrece
    // funciones específicas para cada tipo de imagen.
    // Para abrir la imagen con el formato adecuado, podemos basarnos
    // en la extensión (como en este ejemplo), o en el type MIME.
    switch($extension) {
        case 'jpg':
        case 'jpeg':
            return imagecreatefromjpeg($imagePath);
            break;

        case 'gif':
            return imagecreatefromgif($imagePath);
            break;

        case 'png':
            return imagecreatefrompng($imagePath);
            break;

        default:
            return false;
    }
}

/**
 * Graba una imagen en el $filePath indicado, en base a su extensión.
 * Opcionalmente, puede pasarse una $extension para forzar con qué formato
 * grabarla, al margen de la extensión propia del archivo. No modifica la
 * extensión que tenga el $filePath.
 * Retorna true en caso de éxito, false de lo contrario.
 *
 * @param resource $imagePath
 * @param string $filePath
 * @param string|null $extension
 * @return bool
 */
function saveImage($imagePath, $filePath, $extension = null) {
    $extension = $extension ?? getExtension($filePath);

    // Para grabar la imagen, necesitamos tener primero una imagen en
    // formato de GD library (ej: obtenida a partir de alguna de las
    // funciones de imagecreatefrom...), y luego salvarla en el 
    // formato que deseamos usando también una función específica
    // del formato. Ej: imagejpeg, imagegif.
    switch($extension) {
        case 'jpg':
        case 'jpeg':
            return imagejpeg($imagePath, $filePath);
            break;

        case 'gif':
            return imagegif($imagePath, $filePath);
            break;

        case 'png':
            return imagepng($imagePath, $filePath);
            break;

        default:
            return false;
    }
}

/**
 * Intenta croppear una imagen a los tamaños indicados.
 * Retorna la imagen croppeada, o la original si hubo un error.
 * Retorna false si la imagen es igual o menor al tamaño de croppeo.
 *
 * @param resource $image
 * @param int $width
 * @param int $height
 * @return bool|resource
 */
function cropImage($image, $width, $height) {
    // Antes de croppear, verificamos si hace falta.
    // Esto lo hacemos comprobando que las dimensiones actuales de
    // la imagen no sean iguales o menores a las del croppeo que 
    // piden.
    // Usando imagesx (Image Size X) y imagesy (Image Size Y) 
    // conseguimos las dimensiones actuales.
    $imageX = imagesx($image);
    $imageY = imagesy($image);
    if($imageY <= $height && $imageX <= $width) return $image;
    
    // Para croppear, php nos pide la imagen de GD, y las dimensiones
    // del croppeo como un array asociativo de 4 posiciones:
    // x => La posición/coordenada donde empieza el recorte en X.
    // y => La posición/coordenada donde empieza el recorte en Y.
    // width => El ancho del recorte a partir de x.
    // height => El alto del recorte a partir de y.
    // Si queremos croppear el medio, entonces necesitamos calcular
    // donde empezamos.
    $startX = ($imageX / 2) - ($width / 2);
    $startY = ($imageY / 2) - ($height / 2);

    $cropped = imagecrop($image, [
        'x' => $startX,
        'y' => $startY,
        'width' => $width,
        'height' => $height,
    ]);

    return $cropped === false ? $image : $cropped;
}

/**
 * Crea dos versiones de la $image provista de $_FILES,
 * guardándolas en el $path indicado.
 * La primera con un ancho de 100px, manteniendo la proporción.
 * La segunda con un ancho de 550px, manteniendo la proporción.
 * Retorna un array con los nombres de las imágenes generadas,
 * usando time() o el $filename provisto. La imagen de 550px
 * tendrá de sufijo "-big" antes de la extensión.
 *
 * @param array $image
 * @param string $path
 * @param string|null $filename
 * @param bool $crop
 * @return array    Los nombres de las imágenes generadas.
 */
function generateSiteImages($image, $path, $filename = null, $crop = false) {
    // Primero, definimos el nombre de archivo que queremos usar.
    // Si no especificaron ninguno, usamos time().
    $filename = $filename ?? time();
    $extension = getExtension($image['name']);
    // Creamos la copia de la imagen usando nuestra función.
    $imageCopy = createImage($image['tmp_name'], $extension);

    // Redimensionamos la imagen copiada a los dos tamaños diferentes.
    // Esto se logra usando la función de GD imagescale(), que recibe
    // el recurso de la imagen GD, y el ancho a escalar.
    // Opcionalmente, pueden como 3er parámetro pasar el alto, por
    // defecto sin embargo, mantiene la proporción.
    $imageResized = imagescale($imageCopy, 100); // Tipo un thumbnail.
    $imageBigResized = imagescale($imageCopy, 550);

    // Si nos piden croppear, las croppeamos usando otra función
    // función personalizada.
    if($crop) {
//        $imagenesCroppeadas = generateCroppedImages($imageResized, $imageBigResized);
//        $imageResized = $imagenesCroppeadas[0];
//        $imageBigResized = $imagenesCroppeadas[1];
        // En los casos donde queremos hacer como lo anterior, donde
        // una función retorna un array, y quiero guardar cada parte
        // del array en una variable diferente, podemos usar lo que
        // se llama "Array Destructuring".
        // Esto se hace usando como valor de la izquierda de la
        // asignación, en vez de solo una variable, pasamos un
        // array con las variables en las que queremos guardar los
        // valores del array a la derecha de la asignación.
        [$imageResized, $imageBigResized] = generateCroppedImages($imageResized, $imageBigResized);
        // Antes, en versiones viejas de php, podíamos hacer así:
//        list($imageResized, $imageBigResized) = generateCroppedImages($imageResized, $imageBigResized);
    }

    // Finalmente, creamos los nombres de las imágenes.
    $resizedName = $filename . "." . $extension;
    $resizedBigName = $filename . "-big." . $extension;
    // Grabamos las imágenes usando nuestra función personalizada.
    saveImage($imageResized, $path . $resizedName);
    saveImage($imageBigResized, $path . $resizedBigName);

    // Finalmente, retornamos un array con los nombres de las dos
    // imágenes.
    return ['name' => $resizedName, 'big' => $resizedBigName];
}

/**
 * Intenta croppear las imágenes a los tamaños del sitio.
 * Retorna un array con la imagen $normal croppeada en la primer posición,
 * y la imagen $big croppeada en la segunda.
 * De fallar, retorna las mismas imágenes.
 *
 * @param resource $normal
 * @param resource $big
 * @return array    La imagen $normal croppeada en la primer posición, la $big en la segunda.
 */
function generateCroppedImages($normal, $big) {
    return [
        cropImage($normal, 100, 100),
        cropImage($big, 550, 150)
    ];
}