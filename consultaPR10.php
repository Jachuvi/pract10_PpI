<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta - Práctica 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="inicioPrac10.html">Práctica 10</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="inicioPrac10.html">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="registroPR10.php">Registro</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="consultaPR10.php">Consulta</a>
        </li>
      </ul>
    </div>
  </div>
  </nav>

<div class="container py-4">
<?php

$servername = 'db';
$username   = 'root';
$password   = 'root_password';
$dbname     = 'prac10';
$table      = 'Libros'; 

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    echo '<div class="alert alert-danger" role="alert">Error de conexión a MySQL: ' . htmlspecialchars(mysqli_connect_error(), ENT_QUOTES, 'UTF-8') . '</div>';
} else {
    mysqli_set_charset($conn, 'utf8mb4');

    $sql = "SELECT id, titulo, autor, estreno, portada FROM `$table` ORDER BY id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger" role="alert">Error en la consulta: ' . htmlspecialchars(mysqli_error($conn), ENT_QUOTES, 'UTF-8') . '</div>';
    } else {
        echo '<h1 class="mb-4">Consulta de Libros</h1>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped align-middle">';
        echo '<thead><tr>';
        echo '<th scope="col">ID</th>';
        echo '<th scope="col">Título</th>';
        echo '<th scope="col">Autor</th>';
        echo '<th scope="col">Estreno</th>';
        echo '<th scope="col">Portada</th>';
        echo '</tr></thead><tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            $id      = htmlspecialchars((string)$row['id'], ENT_QUOTES, 'UTF-8');
            $titulo  = htmlspecialchars((string)$row['titulo'], ENT_QUOTES, 'UTF-8');
            $autor   = htmlspecialchars((string)$row['autor'], ENT_QUOTES, 'UTF-8');
            $estreno = htmlspecialchars((string)$row['estreno'], ENT_QUOTES, 'UTF-8');

            $imgCell = 'Sin imagen';
            if (!is_null($row['portada'])) {
                $blob = $row['portada'];
                
                $mime = 'image/jpeg';
                if (function_exists('getimagesizefromstring')) {
                    $info = @getimagesizefromstring($blob);
                    if ($info !== false && isset($info['mime'])) {
                        $mime = $info['mime'];
                    }
                }
                $base64 = base64_encode($blob);
                $imgCell = '<img src="data:' . htmlspecialchars($mime, ENT_QUOTES, 'UTF-8') . ';base64,' . $base64 . '" alt="Portada" style="max-height:120px; max-width:120px; object-fit:cover;" />';
            }

            echo '<tr>';
            echo '<td>' . $id . '</td>';
            echo '<td>' . $titulo . '</td>';
            echo '<td>' . $autor . '</td>';
            echo '<td>' . $estreno . '</td>';
            echo '<td>' . $imgCell . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table></div>';
        mysqli_free_result($result);
    }
    mysqli_close($conn);
}
?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
