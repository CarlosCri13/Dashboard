<?php
session_start();
require 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    die('Debes iniciar sesión para cambiar tu contraseña.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Encriptar la nueva contraseña
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $sql = "UPDATE users SET password = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_password, $_SESSION['username']);
    
    if ($stmt->execute()) {
        echo "Contraseña cambiada exitosamente.";
    } else {
        echo "Error al cambiar la contraseña.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
</head>
<body>
    <h2>Cambiar Contraseña</h2>
    <form action="change_password.php" method="post">
        <label for="new_password">Nueva Contraseña:</label>
        <input type="password" id="new_password" name="new_password" required><br><br>

        <input type="submit" value="Cambiar Contraseña">
    </form>

    <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
