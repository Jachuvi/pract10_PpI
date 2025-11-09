<?php


$servername = 'db';
$username   = 'root';
$password   = 'root_password';
$dbname     = 'prac10';
$table      = 'Libros'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método no permitido';
    exit;
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    http_response_code(500);
    echo 'Error de conexión a MySQL: ' . htmlspecialchars(mysqli_connect_error(), ENT_QUOTES, 'UTF-8');
    exit;
}
mysqli_set_charset($conn, 'utf8mb4');

// campos
$pk      = isset($_POST['id']) ? trim($_POST['id']) : '';
$titulo  = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
$autor   = isset($_POST['autor']) ? trim($_POST['autor']) : '';
$estreno = isset($_POST['estreno']) ? trim($_POST['estreno']) : '';

// Validacion
if ($titulo === '' || $autor === '') {
    http_response_code(400);
    echo 'Faltan datos obligatorios: título y autor.';
    exit;
}

// Procesar imagen
$blob = null;
if (isset($_FILES['portada']) && is_array($_FILES['portada'])) {
    if ($_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['portada']['tmp_name'];
        // Verificar que sea imagen
        $info = @getimagesize($tmpPath);
        if ($info === false) {
            http_response_code(400);
            echo 'El archivo subido no es una imagen válida.';
            exit;
        }
        $blob = file_get_contents($tmpPath);
    } elseif ($_FILES['portada']['error'] !== UPLOAD_ERR_NO_FILE) {
        http_response_code(400);
        echo 'Error al subir el archivo (código: ' . (int)$_FILES['portada']['error'] . ').';
        exit;
    }
}


$usaPk = ($pk !== '' && ctype_digit($pk));
try {
    if ($usaPk) {
        $sql = "INSERT INTO `$table` (id, titulo, autor, estreno, portada) VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . mysqli_error($conn));
        }
        $id = (int)$pk;
        // Vincular parámetros (b = blob).
        $blobTemp = null; // placeholder para blob
        mysqli_stmt_bind_param($stmt, 'isssb', $id, $titulo, $autor, $estreno, $blobTemp);
        if (!is_null($blob)) {
            mysqli_stmt_send_long_data($stmt, 4, $blob);
        }
    } else {
        $sql = "INSERT INTO `$table` (titulo, autor, estreno, portada) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . mysqli_error($conn));
        }
        $blobTemp = null; // placeholder para el blob
        mysqli_stmt_bind_param($stmt, 'sssb', $titulo, $autor, $estreno, $blobTemp);
        if (!is_null($blob)) {
            mysqli_stmt_send_long_data($stmt, 3, $blob);
        }
    }

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('No se pudo insertar el registro: ' . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirigir a consulta
    header('Location: consultaPR10.php');
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    if (isset($stmt) && $stmt) { mysqli_stmt_close($stmt); }
    if (isset($conn) && $conn) { mysqli_close($conn); }
    exit;
}
?>
