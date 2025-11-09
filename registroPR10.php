<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
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
                        <a class="nav-link active" aria-current="page" href="inicioPrac10.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registroPR10.php">Registro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="consultaPR10.php">Consulta</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <form action="registroDB.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="id" class="form-label">PK</label>
            <input class="form-control" type="number" placeholder="Default input" aria-label="default input example" name="id" id="id">
        </div>
        
        <label for="titulo" class="form-label">Título</label>
        <input class="form-control" type="text" placeholder="Default input" aria-label="default input example" name="titulo" id="titulo">
         <label for="autor" class="form-label">Autor</label>
        <input class="form-control" type="text" placeholder="Default input" aria-label="default input example" name="autor" id="autor">
        <label for="estreno" class="form-label">Estreno</label>
        <input type="date" name="estreno" id="estreno">
        <div class="mb-3">
            <label for="portada" class="form-label">Subir imagen</label>
            <input class="form-control" type="file" id="portada" name="portada" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">
            Subir
        </button>
        

    </form>

    
    
    
</body>
</html>
