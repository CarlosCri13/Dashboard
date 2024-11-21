<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Bienvenida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .welcome-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .btn-primary {
            background-color: #ff7700;
            border-color: #ff7700;
        }
        .btn-primary:hover {
            background-color: #e06600;
            border-color: #e06600;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Bienvenido/a, <?php echo $_SESSION['username']; ?></h1>
        <div class="button-container mt-4">
            <button onclick="window.location.href='formulario.php'" class="btn btn-primary">Llenar formulario</button>
            <button onclick="window.location.href='gestionar_datos.php'" class="btn btn-primary">Datos</button>
            <button onclick="window.location.href='reprobacion_definitiva.php'" class="btn btn-primary">Reprobación Definitiva2</button>
        </div>
        <div class="mt-4">
            <a href="logout.php" class="btn btn-secondary">Cerrar sesión</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
