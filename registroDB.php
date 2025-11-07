<?php

$servername = 'db';
$username = 'root';
$password = 'root_password';
$dbname   = 'prac10';
$table    = 'Libros'; 

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    http_response_code(500);
    echo 'Error de conexión a MySQL: ' . mysqli_connect_error();
    exit;
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método no permitido';
    exit;
}

//Datos del formulario
$id = isset($_POST['pk']) ? intval($_POST['pk']) : null;
$titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
$autor = isset($_POST['autor']) ? trim($_POST['autor']) : '';
$estreno = isset($_POST['estreno']) ? $_POST['estreno'] : null; // formato YYYY-MM-DD

// Validar archivo de imagen
if (!isset($_FILES['portada']) || $_FILES['portada']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo 'Error al subir la imagen de portada.';
    exit;
}

$tmpPath = $_FILES['portada']['tmp_name'];
if (!is_uploaded_file($tmpPath)) {
    http_response_code(400);
    echo 'Archivo de portada inválido.';
    exit;
}

// Verificar que sea una imagen
$imgInfo = @getimagesize($tmpPath);
if ($imgInfo === false) {
    http_response_code(400);
    echo 'El archivo subido no es una imagen.';
    exit;
}

$portadaData = file_get_contents($tmpPath);
if ($portadaData === false) {
    http_response_code(500);
    echo 'No se pudo leer la imagen subida.';
    exit;
}



mysqli_set_charset($conn, 'utf8mb4');

// Validaciones 
if ($id === null || $titulo === '' || $estreno === null) {
    http_response_code(400);
    echo 'Faltan campos obligatorios: id, titulo o estreno.';
    mysqli_close($conn);
    exit;
}

// Insertar 
$sql = "INSERT INTO `$table` (id, titulo, autor, estreno, portada) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    http_response_code(500);
    echo 'Error al preparar la consulta: ' . mysqli_error($conn);
    mysqli_close($conn);
    exit;
}

mysqli_stmt_bind_param($stmt, 'issss', $id, $titulo, $autor, $estreno, $portadaData);

if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    echo 'Error al ejecutar la inserción: ' . mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirigir o mostrar confirmación
?>
